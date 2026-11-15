<?php 
   /*si le donneur se déconnecte*/
    session_start();
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('Location:Views/Connexion.php');
        exit;
    }
    
        /*inclut de fichier contenant les fonctions définies*/
        require "Models/fonctions.php";
        $conn=connexion();
        modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte
        /*affichage de des notifications spécifié à un donneur connecté*/ 
        $req=$conn->prepare('SELECT * FROM notifications WHERE id_user=?');//récupérer les notifications du cet donneur 
        $req->execute([$_SESSION['id_user']]);
        if($req->rowCount()!=0){
           while($notification=$req->fetch(PDO::FETCH_ASSOC)){
                /*verif le statut  de l'alerte*/
                if($notification['statut']==='active'){//affichage des notification active 
                        //recupération des données de la table alertes
                       $res=$conn->prepare('SELECT * FROM alertes WHERE id_alerte=?');
                       $res->execute([$notification['id_alerte']]);
                       $alerte=$res->fetch(PDO::FETCH_ASSOC);
                       if($alerte){
                       $date_limite=$alerte['date_limite'];//date limite
                       $urgence=$alerte['urgence'];//niveau d urgence
                       $type=$alerte['type_don'];//type:sang total-plasma
                       }//récupération de la table user
                       $res1=$conn->prepare('SELECT * FROM user WHERE id_user=?');
                       $res1->execute([$alerte['id_user']]);
                       $centre=$res1->fetch(PDO::FETCH_ASSOC);
                       if($centre){
                       $nom=$centre['nom'];//nom du centre 
                       $tel=$centre['telephone'];// numéro de télèphone du centre
                       }/*affichege de l alerte selon le niveau d urgence*/
                       if($urgence==="critique"){
                            echo "<div class='alert alert-danger alert-flash-danger' role='alert' style='position:fixed;
                                     top:80px;left:300px;width:50%;'>
                                      <i class='bi bi-exclamation-triangle' style='color:red;font-size:18px'></i> ".$urgence." : ".$type."<br>".$nom.", - Avant ".$date_limite." 
                                ";
                        }else{
                           echo "<div class='alert alert-warning alert-flash-normal' role='alert' style='position:fixed;
                                     top:80px;left:300px;width:50%;'>
                                  <i class='bi bi-exclamation-triangle' style='color:black;font-size:18px'></i> ".$urgence." : ".$type."<br>".$nom.", - Avant ".$date_limite." 
                                "; 
                        }echo "<form method='POST' action='reponse_notification.php' style='margin-left:470px;margin-top:10px'>
                                     <input type='hidden' name='id_alerte' value='".$notification['id_alerte']."'>
                                     <button type='submit' class='btn btn-success' name='accepte'>Accepter</button>
                                     <button type='submit' class='btn btn-danger' name='refuse'>Refuser</button></form>
                                  </div>";//envoyer  id_alerte
                     }
                }
        }
        //si le donneur supprime une notification
        if(isset($_POST['delete_notif'])){
          delete_Data($conn,"notifications","id_notif=".$_POST['id_notif']);
        }
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard_Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="css/acceuil.css" rel="stylesheet">
        <link href="css/connexion.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <style>
@keyframes flashGlow {
  0% {
    opacity: 1;
    box-shadow: 0 0 10px rgb(255, 7, 7);
  }
  50% {
    opacity: 0.5;
    box-shadow: 0 0 30px rgba(255,0,0,1);
  }
  100% {
    opacity: 1;
    box-shadow: 0 0 10px rgb(255, 0, 0);
  }
}
@keyframes FlashGlow {
  0% {
    opacity: 1;
    box-shadow: 0 0 10px rgb(255, 168, 7);
  }
  50% {
    opacity: 0.5;
    box-shadow: 0 0 30px rgb(255,168,7);
  }
  100% {
    opacity: 1;
    box-shadow: 0 0 10px rgb(255, 168, 7);
  }
}
.alert-flash-danger {
  animation: flashGlow 1s infinite;
}.alert-flash-normal{
        animation: FlashGlow 1s infinite;
}span{font-weight:bold;}
</style>
    <body class="d-flex flex-column min-vh-100"  >
       <?php
         require "Views/navbar_footer/navbar_user.php";
           $req=recupere_table($conn,"user","id_user=".$_SESSION['id_user']);
           $user=$req->fetch(PDO::FETCH_ASSOC);
           $req=recupere_table($conn,"donneur","id_user=".$_SESSION['id_user']);
           $donneur=$req->fetch(PDO::FETCH_ASSOC);
           echo "<div class='tab-pane fade show active' id='Acceuil-tab-pane' role='tabpanel' aria-labelledby='Acceuil-tab' tabindex='0' >
               <div style='background-color:rgb(255, 243, 243);
                                  border-radius:15px;
                                  border:solid 1px rgb(226, 170, 170);
                                  width:60%;margin-left:120px;margin-top:70px;'>
                                <h2 style='margin-top:30px;margin-left:10px'><i class='bi bi-heart-pulse-fill' style='color:rgb(192, 3, 3)'></i> " 
                                 .$user['prenom']." ".$user['nom']."
                                    <a href='modif_infos_donneur.php'><i class='bi bi-pencil-square' style='display:block;margin-left:700px;'></i></a>
                                </h2>
                                <h6 style='color:grey;margin-left:10px'>Mes informations & notifications</h6>
                                <h6 style='color:green;margin-left:10px;margin-top:20px;'><i class='bi bi-check-circle-fill'></i> État du système : ".$user['etat']."</h6>
                           </div>";
         //recuperer de toutes les notifications acceptés du donneur connecté
         $req=$conn->query("SELECT * FROM notifications WHERE id_user=".$_SESSION['id_user']." AND statut='accepté'");
         $notifications=$req->fetchAll(PDO::FETCH_ASSOC);
         if($notifications){
            foreach($notifications as $notif){
              $req=$conn->query("SELECT * FROM alertes WHERE id_alerte=".$notif['id_alerte']);//recuperer les infos de l'alerte de cette notification
              $alerte=$req->fetch(PDO::FETCH_ASSOC);
              $date_creation=$alerte['date_creation'];
              $date_limite=$alerte['date_limite'];//date limite
              if(date('Y-m-d H:i')<$date_limite){
              //récupération du centre de la table user
              $res1=$conn->prepare('SELECT * FROM user WHERE id_user=?');
              $res1->execute([$alerte['id_user']]);
              $centre=$res1->fetch(PDO::FETCH_ASSOC);
              $req=$conn->query("SELECT * FROM creneau WHERE id_alerte=".$alerte['id_alerte'].
                                 " AND id_creneau IN (SELECT id_creneau FROM rendez_vous WHERE id_user=".$_SESSION['id_user'].")");
              $creneau=$req->fetch(PDO::FETCH_ASSOC);
              if($creneau){
                $heure_RDV=$creneau['Heure_debut'];
                $_SESSION['boutton'.$_SESSION['id_user']]="Indisponible";
              }
              else
                $heure_RDV="Non fixé";
              echo "<div class='alert alert-secondary' role='alert' style='margin-top:30px;margin-left:120px ;width:700px'>
                      <span style='font-size:20px'>Notification</span>
                      <span><form method='POST' action=''>
                                          <input type='hidden' value='".$notif['id_notif']."' name='id_notif'>
                                         <button type='submit' name='delete_notif' style='margin-left:600px;font-size:25px;border:none;color:rgb(192, 4, 4);background-color:rgba(80, 63, 63, 0)'>
                                            <i class='bi bi-trash'></i>
                                          </button>
                                       </form></span>
                      <form method='POST' action='reponse_notification.php'>
                        <input type='hidden' name='id_alerte' value='".$notif['id_alerte']."'>
                        <button type='submit' name='accepte' class='btn btn-outline-warning'><i class='bi bi-gear'></i> Gérer</button>
                      </form>
                      <br><span> Centre : </span>".$centre['nom'].
                        "\t <span>Date Limite : </span>".$date_limite."
                      <br> <span>Date du rendez_vous : </span>".$heure_RDV.
                   "</div>";
            }
          }
         }
         echo "<div class='tab-pane fade show active' id='Acceuil-tab-pane' role='tabpanel' aria-labelledby='Acceuil-tab' tabindex='0' >
               <div style='background-color:rgb(255, 250, 243);
                                  border-radius:15px;
                                  border:solid 3px rgb(248, 206, 152);
                                  width:30%;margin-left:120px;margin-top:70px;font-weight:bold;padding:10px;font-size:15px'>
                    <p ><span style='color:rgb(185, 117, 28)'>Numéro du télèphone : </span>".$user['telephone']."</p> 
                    <p><span style='color:rgb(185, 117, 28)'>CIN : </span>".$donneur['CIN']."</p> 
                     <p><span style='color:rgb(185, 117, 28)'>Groupe sanguin & rhésus : </span>".$donneur['groupe_sanguin_rhesus']."</p> 
                    <p><span style='color:rgb(185, 117, 28)'>Poids : </span>".$donneur['poids']." kg</p>

                </div>     
               </div>"
        ?>

    </body>
</html>