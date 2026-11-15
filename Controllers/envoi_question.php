<?php
   session_start();
   require "../Models/fonctions.php";
   $conn=connexion();
   $question=$_POST['qst'];
    /*insérer une nouvelle ligne dans le table des questions*/
    if(!empty($question)){
        if(ajout_question($conn,$question)){
            $_SESSION['msg1']='Question envoyée avec succès ! elle sera traitée dans 24 heures maximum.';
            header('Location:../Views/question.php');
            exit;
        }
    }/*message d'erreur si le champ est vide*/
    else{
        $_SESSION['msg2']='Veuillez remplir le champ.';
        header('Location:../Views/question.php');
        exit;
    }
?>