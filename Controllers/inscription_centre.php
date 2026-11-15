<?php
   session_start();
   $jour=array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
   require "../Models/fonctions.php";
   require "../Models/CentreModel.php";
   if(empty($_POST['nomcentre']) || empty($_POST['mdp'])
      || empty($_POST['tel']) || empty($_POST['adresse'])
   ||empty($_POST['gouv'])|| empty($_POST['open'])){
     $_SESSION['error']= "Veuillez remplir tout les champs";
        header("Location:../Views/espaceCentre.php");
        exit;
   }else{
      $conn=connexion();
      $nom=$_POST['nomcentre'];
      $tel=$_POST['tel'];
      $mdp=$_POST['mdp'];
      $code=random_int(10000000,99999999);
      while(verif_code_securite($conn,$code)==1){
                  $code=random_int(10000000,99999999);
      }
      //insertion du centre dans la base user comme nouveau utilistaeur
      ajout_centreUser($conn,$nom,$tel,$mdp,$code);
      //insertion dans la table centre avec id_user clé étrangaire
      $id_user= id_userCentre($conn,$tel);// id_user du centre(table user)
      $jour_ouverture="";
      for($i=0;$i<count($jour);$i++){
         if(isset($_POST['check'.$jour[$i]]))
            $jour_ouverture.=$_POST['check'.$jour[$i]].", ";
      }
       ajouter_centre($conn,$id_user,$_POST['adresse'],$tel,$_POST['gouv'],$_POST['open'],$_POST['close'],$jour_ouverture);
     //insertion des stocks dans la table stock_sanguine
      $id_centre=recupere_idCentre($conn,$id_user);//id_centre du centre(table centre)
      remplir_stock_centre($conn,$id_centre,$_POST['A_plus'],$_POST['A_moins'],$_POST['B_plus'],$_POST['B_moins'],$_POST['O_plus'],$_POST['O_moins'],$_POST['AB_plus'],$_POST['AB_moins']);
      header("Location:../Views/Connexion.php");
      exit;
   }
?>