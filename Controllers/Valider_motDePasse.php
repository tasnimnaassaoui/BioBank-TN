<?php
  session_start();
  require "../Models/fonctions.php";
  $conn=connexion();
  
//changer le mot de passe
    if(isset($_POST['modif'])){
        if(empty($_POST['nv_psw']) || empty($_POST['conf_psw'])){
            $_SESSION['message']="Veuillez remplir les deux champs.";
            header('Location:../Views/mot_de_passe_oublie.php');
            exit;
        }else{
            if($_POST['nv_psw']!=$_POST['conf_psw']){
                $_SESSION['message']="mot de passe non confirmé.";
                header('Location:../Views/mot_de_passe_oublie.php');
                exit;
            }else{
                modifier_psw($conn,"user",$_SESSION['id_user'],$_POST['nv_psw']);
                unset($_SESSION['code']);
                unset($_SESSION['id_user']);
                $_SESSION['alert']="<script>alert('Mot de passe modifié avec succès')</script>";
                header('Location:../Views/connexion.php');
                exit;
            }
        }
    }
    
?>