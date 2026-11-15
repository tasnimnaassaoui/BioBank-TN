<?php
  session_start();
  require "../Models/fonctions.php";
  $conn=connexion();
  
  //vérifier le code securité 
  if(!empty($_POST["code"])){
           $req=recupere_table($conn,"user","code_securite=".$_POST['code']); 
           $user=$req->fetch(PDO::FETCH_ASSOC);
           if($user){
              $_SESSION['id_user']=$user['id_user'];
               header('Location:../Views/mot_de_passe_oublie.php');
               exit;
           }else{
               $_SESSION['erreur']="code incorrecte, veuillez réessayer";
               header('Location:../Views/connexion.php');
               exit;
           }
        }else{
            $_SESSION['erreur']="saisir le code";
            header('Location:../Views/connexion.php');
            exit;
        }
  
?>