<?php
  session_start();
  require "../Models/fonctions.php";
  if(isset($_POST['enregistrer'])){
    $O_plus=$_POST['o+'];
    $O_moins=$_POST['o-'];
    $A_plus=$_POST['a+'];
    $A_moins=$_POST['a-'];
    $B_plus=$_POST['b+'];
    $B_moins=$_POST['b-'];
    $AB_plus=$_POST['ab+'];
    $AB_moins=$_POST['ab-'];
    $stock=['O_plus'=>$O_plus,'O_moins'=>$O_moins,'A_plus'=>$A_plus,'A_moins'=>$A_moins,'B_plus'=>$B_plus,'B_moins'=>$B_moins,'AB_plus'=>$AB_plus,'AB_moins'=>$AB_moins];
    if($O_plus=="" && $O_moins=="" && $A_plus=="" && $A_moins=="" && $B_plus=="" && $B_moins=="" && $AB_plus=="" && $AB_moins==""){
        $_SESSION['error']= "Veuillez effectuer au moins une modification de l'un des stocks.";
        header('Location:../Views/Gere_stock.php');
        exit;
    }else{
        $conn=connexion();
        $req=recupere_table($conn,"centres","id_user=".$_SESSION['id_user']);
        $centre=$req->fetch(PDO::FETCH_ASSOC);
        foreach($stock as $k=>$val){
            if($val!=""){
               $req=$conn->prepare("UPDATE stocks_sanguins SET $k=? WHERE id_centre=?");
               $req->execute([$val,$centre['id_centre']]);
            }
        }header('Location:../Views/Gere_stock.php');
        exit;
    }
  }
?>