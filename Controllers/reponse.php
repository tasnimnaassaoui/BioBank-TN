<?php
    session_start();
    require "../Models/fonctions.php";
    require "../Models/AdminModel.php";
    $conn=connexion();
    /*ajout de la réponse dans le table*/
    if(!empty($_POST['reponse'])){
       if(reponder_question($conn,$_POST['reponse'],$_POST['id'])){
            $_SESSION['message1']='Réponse envoyée avec succès';
            header('Location:../Views/admin.php');
            exit;
        }
    }/* message d'eurreur en cas de champ vide*/
    else{
        $_SESSION['message2']='Veuillez remplir le champ';
        header('Location:../Views/admin.php');
        exit;
    }
?>