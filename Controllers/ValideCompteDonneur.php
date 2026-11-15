<?php
  session_start();
  require "../Models/fonctions.php";
  require "../Models/InsertionDonneur.php";
  $conn=connexion();
   if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['date']) || empty($_POST['cin']) || empty($_POST['contact']) || empty($_POST['poids']) 
      ||($_POST['maladi']=="oui" && empty($_POST['nomMaladi'])) || ($_POST['deja_donne']=="oui" && empty($_POST['datedon']))){
       $_SESSION['erreur']="Veuillez saisir tout les champs.";
       header('Location:../Views/inscription_donneur.php');
       exit;
   }else{
      $date_naissance = new DateTime($_POST['date']);
      $now = new DateTime();
      $age = $now->diff($date_naissance);
      $age = $age->y;
      //si l'utilisateur pocède une maladie chronique,il est mineur ou bien trop légère
      if($_POST['maladi']=="oui" || $age<18 || $_POST['poids']<50){
         $_SESSION['erreur_creation']="Vous n’êtes pas éligible pour effectuer un don de sang.";
         header('Location:../Views/inscription_donneur.php');
         exit;
      }else{
        //veirifier la periode entre la date de dernier don si effectué et la date du creation du compte
         $date_dernier_don=null;
         $etat="active";
         if($_POST['deja_donne']=="oui"){
            $date_dernier_don = new DateTime($_POST['datedon']);
            $now = new DateTime();
            $periode = $now->diff($date_dernier_don);
            $periode = $periode->days;
            $date_dernier_don=$date_dernier_don->format('Y-m-d');
            if($periode<56){// si la periode <56j le compte créé mais inactive
               $etat="inactive";
            }
         }$code=random_int(10000000,99999999);
         //ajout du donneur dans la base (creation du compte sans password)
        ajoutTableUser($conn,$_POST['nom'],$_POST['prenom'],$_POST['contact'],$etat,$code);
        //recuperer son id_user
        $user=recupererIDuser($conn,$_POST['contact']);
        $id_user=$user['id_user'];
        //ajout du donneur à la base donneur
        $gsr=$_POST['sang'].$_POST['rhesus'];
        ajoutTableDonneur($conn,$id_user,$_POST['cin'],$gsr,$_POST['Gouvernorats'],$_POST['poids'],$date_dernier_don);
        $_SESSION['code']=$code;
         $_SESSION['id_user']=$id_user;
         header('Location:../Views/Valider_mot_de_passe.php');
         exit;
      }
   }
   ?>