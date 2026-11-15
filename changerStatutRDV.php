<?php
session_start();
require "Models/fonctions.php";
$conn=connexion();
//si le RDV est effectué
   if(isset($_POST['effectue'])){
       //changer le statut du RDV effectue + etat du compte donneur inactive 
       $conn->query("UPDATE rendez_vous SET statut='effectue' WHERE id_user=".$_POST['id_user']);
       $conn->query("UPDATE user SET etat='inactive' WHERE id_user=".$_POST['id_user']);

       //update la colonne dernier_don de la table donneur
        $conn->query("UPDATE donneur SET dernier_don=NOW() WHERE id_user=".$_POST['id_user']);

       //recuperer id_donneur,id_centre et ajout a la table historique
       $req=$conn->query("SELECT id_donneur FROM donneur WHERE id_user=".$_POST['id_user']);
       $donneur=$req->fetch(PDO::FETCH_ASSOC);
       $req=$conn->query("SELECT id_centre FROM centres WHERE id_user=".$_SESSION['id_user']);
       $centre=$req->fetch(PDO::FETCH_ASSOC);
       //ajout à la table historiques la nouvelle don
       $conn->query("INSERT INTO historiques (id_donneur,id_centre) VALUES(".$donneur['id_donneur'].",".$centre['id_centre'].")");
       header('Location:Views/centre.php');
       exit;
   }
   if(isset($_POST['non_effectue'])){
    //changer le statut du RDV effectue + etat du compte donneur inactive 
       $conn->query("UPDATE rendez_vous SET statut='non effectue' WHERE id_user=".$_POST['id_user']);
       header('Location:Views/centre.php');
       exit;
   }
?>