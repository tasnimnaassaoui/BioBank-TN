<?php
//suppresion des donneur ,centre,alerte et question
  require "../Models/fonctions.php";
  $conn=connexion();
  //suppression du donneur
  if(isset($_POST['delete_D'])){
      delete_Data($conn,"user","id_user=".$_POST['id_user']);
      header('Location:../Views/admin.php');
      exit;
  }
  //suppression du centre
  if(isset($_POST['delete_c'])){
      delete_Data($conn,"user","id_user=".$_POST['id_user']);
      header('Location:../Views/admin.php');
      exit;
  }
  //suppression d une alerte
  if(isset($_POST['delete_A'])){
    delete_Data($conn,"alertes","id_alerte=".$_POST['id_alerte']);
    header('Location:../Views/admin.php');
    exit;
  }
  //suppression d une question
  if(isset($_POST['delete_Q'])){
    delete_Data($conn,"question_reponse","id_QR=".$_POST['QR']);
    header('Location:../Views/admin.php');
    exit;
  }
?>
  