<?php
    session_start();
    require '../Models/fonctions.php';
    require '../Models/AdminModel.php';
    $conn=connexion();
    modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte
    if(isset($_POST['idAlerte']) && $_POST['idAlerte']>0){
        $req=recupere_table($conn,"alertes","id_alerte=".$_POST['idAlerte']);
       $alerte=$req->fetch(PDO::FETCH_ASSOC);
       /*ajouter les notifications à la BD afin de les afficher aux donneurs concernés.*/
       if($alerte && $alerte['statut']==="active"){
          if(isset($_POST['select'])){
                for($i=0;$i<count($_POST['select']);$i++){
                    envoi_notification($conn,$_POST['idAlerte'],$_POST['select'][$i]);//insertion de id_user du donneur + id_alerte + son statut
                }$_SESSION['notif']=count($_POST['select'])." notification(s) envoyées avec succès";// stocker le nombre de notifications envoyées
                header('Location:../Views/affichage_donneurCible.php');
                exit;
            }else{
                $_SESSION['error']="Sélectionnez au moins un donneur";
                header('Location:../Views/affichage_donneurCible.php');
                exit;
            }
       }else{
            $_SESSION['error']="Attention cette alerte est indisponible ou introuvable";
            header('Location:../Views/affichage_donneurCible.php');
            exit;
       }
    }else{
        $_SESSION['error']="id invalide";
        header('Location:../Views/affichage_donneurCible.php');
        exit;
    }
    
?>