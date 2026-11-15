<?php
  session_start();
   require "Models/fonctions.php";
   $conn=connexion();
   //ajout d'une nouvelle alerte 
   if (isset($_POST['ajout'])) {

    if (!empty($_POST['type']) && !empty($_POST['gsr']) && !empty($_POST['qte']) &&
        !empty($_POST['urgence']) && !empty($_POST['date_limite'])) {
            if ($_POST['urgence'] === "critique" || $_POST['urgence'] === "normale") {
                $req = $conn->prepare("INSERT INTO alertes (id_user,type_don,groupe_sanguin_rhesus,quantite,urgence,date_limite)
                                        VALUES (?,?,?,?,?,?)");
                $req->execute([$_SESSION['id_user'],$_POST['type'],$_POST['gsr'],$_POST['qte'],$_POST['urgence'],$_POST['date_limite']]);
                $id_alerte = $conn->lastInsertId();
                $req = $conn->query("SELECT * FROM alertes WHERE id_alerte=$id_alerte");
                $alerte = $req->fetch(PDO::FETCH_ASSOC);
                $type_don = strtolower($alerte['type_don']);
                $debut = new DateTime($alerte['date_creation']);
                $fin   = new DateTime($alerte['date_limite']);
                $diff = $debut->diff($fin);
                $nombre_jour = $diff->days;
                $req = $conn->query("SELECT horaire_open,horaire_close FROM centres WHERE id_user=".$_SESSION['id_user']);
                $centre = $req->fetch(PDO::FETCH_ASSOC);
                $date=new DateTime($debut->format('Y-m-d')); 
                $open=new DateTime($date->format('Y-m-d').' '.$centre['horaire_open']);
                $close=new DateTime($date->format('Y-m-d').' '.$centre['horaire_close']);
                $req = $conn->query("SELECT horaire_open,horaire_close FROM centres
                                 WHERE id_user=".$_SESSION['id_user']);
                $centre = $req->fetch(PDO::FETCH_ASSOC);
                if($type_don === "sang total")
                    $increment = " +1 hour";
                else
                    $increment =" +1 hour +30 minutes";
                $req= $conn->prepare("INSERT INTO creneau (id_alerte,date_jour,Heure_debut,Heure_fin) VALUES (?,?,?,?)");
                if($nombre_jour==0){//si date limite et la date de creation de l'alerte dans le meme jour 
                    $suivant=clone $debut; 
                    $suivant->modify($increment); 
                    while($suivant<= $fin){ 
                        $req->execute([$alerte['id_alerte'],$date->format('Y-m-d'),$debut->format('H:i'),$suivant->format('H:i')]); 
                        $debut->modify($increment);
                        $suivant=clone $debut; 
                        $suivant->modify($increment); 
                    } 
                }else{ 
                    for($i=0;$i<=$nombre_jour;$i++){ 
                        if($i<$nombre_jour){ 
                            $suivant=clone $debut; 
                            $suivant->modify($increment); 
                            while($suivant<=$close){ 
                                $req->execute([$alerte['id_alerte'],$date->format('Y-m-d'),$debut->format('H:i'),$suivant->format('H:i')]); 
                                $debut->modify($increment); 
                                $suivant=clone $debut; 
                                $suivant->modify($increment); 
                            } 
                             
                            $date->modify('+1 day');//incrementer $date 
                            $open=new DateTime($date->format('Y-m-d').' '.$centre['horaire_open']);
                            $close=new DateTime($date->format('Y-m-d').' '.$centre['horaire_close']);
                            $debut=$open;
                        }else{ 
                            $suivant=clone $debut; 
                            $suivant->modify($increment); 
                            while($suivant<=$fin){ 
                                $req->execute([$alerte['id_alerte'],$date->format('Y-m-d'),$debut->format('H:i'),$suivant->format('H:i')]); 
                                $debut->modify($increment); 
                                $suivant=clone $debut; 
                                $suivant->modify($increment); 
                            } 
                        } 
                    }
                }header('Location:Gere_alerte.php');
                exit; 
            }else{
                $_SESSION['erreur']="Urgence invalide.";
            }
        }else{
            $_SESSION['erreur']= "Veuillez remplir tout les champs";
        }header('Location:ajout_alerte.php'); 
        exit;
    }//mettre à jour le statut d'alerte 'résolue' par le centre
   if(isset($_POST['statut'])){
    $req=$conn->prepare('UPDATE alertes SET statut="Résolue" WHERE id_alerte=?');
    $req->execute([$_POST['id_alert']]);
    $req1=$conn->prepare('UPDATE notifications SET statut="désactivée" WHERE id_alerte=?');
    $req1->execute([$_POST['id_alert']]);
    header('Location:Gere_alerte.php');
    exit;
   }
    
 //saisir nombre maximum creneaux
 if(isset($_POST['enregistrer'])){
    if(isset($_POST['cap_max']) && $_POST['cap_max']>0){
        $req=$conn->prepare("UPDATE creneau SET capacite_max =? WHERE id_creneau=?");
        $req->execute([$_POST['cap_max'],$_POST['id_creneau']]);
        header('Location:Gestion_RDV.php');
        exit;
    }else{
        $_SESSION["msg_erreur"]="capacité incorrecte";
        header('Location:Gestion_RDV.php');
        exit;
    }
 }
 //prise du rendez-vous
 if(isset($_POST['choisir'])){
    $_SESSION['boutton'.$_SESSION['id_user']]="Indisponible";
    //incrementer le nombre de place occupée du creneau choisi
    $conn->query("UPDATE creneau SET place_occupee=(place_occupee+1) WHERE id_creneau=".$_POST['id_creneau']);
    //ajouter le RDV 
    $req=$conn->prepare("INSERT INTO rendez_vous (id_creneau,id_user)
                   VALUES (?,?)");
    $req->execute([$_POST['id_creneau'],$_SESSION['id_user']]);
    //verifier si place occupee =capacité max alors le statut de creneau devient occupé
    $req=$conn->query("SELECT * FROM creneau WHERE id_creneau=".$_POST['id_creneau']);
    $creneau=$req->fetch(PDO::FETCH_ASSOC);
    if($creneau['place_occupee']==$creneau['capacite_max']){
        $conn->query("UPDATE creneau SET statut='occupée' WHERE id_creneau=".$_POST['id_creneau']);
    }
    header('Location:reponse_notification.php');
    exit;
 }
 //annuler un rendez_vouz par le donneur
 if(isset($_POST['annuler'])){
    unset($_SESSION['boutton'.$_SESSION['id_user']]);
    $conn->query("UPDATE creneau SET place_occupee=(place_occupee-1), statut='disponible' WHERE id_creneau=".$_POST['id_creneau']);//décrementer le nombre des places occupées par 1
    $req=$conn->prepare("DELETE FROM rendez_vous WHERE id_creneau=? AND id_user=?");//supprimer le rendez-vous
    $req->execute([$_POST['id_creneau'],$_SESSION['id_user']]);
    header('Location:reponse_notification.php');
    exit;
 }
?>