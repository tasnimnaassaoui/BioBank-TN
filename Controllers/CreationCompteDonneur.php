<?php
  session_start();
  require "../Models/fonctions.php";
  require "../Models/InsertionDonneur.php";
  $conn=connexion();
  if(isset($_POST['confirmer'])){
        if(empty($_POST['password']) || empty($_POST['confpassword'])){
            $_SESSION['erreur']="Veuillez remplir les deux champs.";
            header('Location:mot_de_passe.php');
            exit;
        }else{
            if($_POST['password']!=$_POST['confpassword']){
                $_SESSION['erreur']="mot de passe non confirmé.";
                header('Location:../Views/Valider_mot_de_passe.php');
                exit;
            }else{
                ajouter_password($conn,$_POST['password'],$_SESSION['id_user']);
                unset($_SESSION['id_user']);
                header('Location:../Views/connexion.php');
                exit;
            }
        }
   }
?>