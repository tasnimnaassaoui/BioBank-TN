<?php 
   /*si l'utilisateur se déconnecte*/
    session_start();
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('Location:../Views/Connexion.php');
        exit;
    }
?>