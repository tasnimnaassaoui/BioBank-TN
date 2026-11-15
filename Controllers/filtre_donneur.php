<?php
  session_start();
  require "../Models/fonctions.php";
  require "../Models/AdminModel.php";
  $conn=connexion();
  modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte
  if(!empty($_GET['groupe_recherche']) ){
    $_SESSION['gsr']=$_GET['groupe_recherche'];
  }
  
    if(isset($_SESSION['gsr'])){
    $ch=trim($_SESSION['gsr']);
    $T=explode('/',$ch);// groupe sanguin & rhesus
    $T[1]=ucfirst($T[1]);//gouvernerat
    $donneurs=filtrer_donneur($conn,$T[1],$T[0]);
    if(count($donneurs)==0)
       $_SESSION['message']="Aucun donneur correspondant aux critères ";
    }else{
    //affichage message d'erreur dans la page admin (alertes)
    $_SESSION["erreur"]="Veuillez remplir le champ";
    header('Location:../Views/admin.php');
    exit;
   }
    
?>