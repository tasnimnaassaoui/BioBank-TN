<?php
session_start();
require "Models/fonctions.php";
 $conn=connexion();
delete_Data($conn,"historiques","id_hist=".$_POST['id_hist']);
 header('Location:consulterHistorique.php');
 exit;
?>