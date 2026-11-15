<?php
   require "../Models/fonctions.php";
   $conn=connexion();
   $questions=recupere_table($conn,"question_reponse",1);
?>