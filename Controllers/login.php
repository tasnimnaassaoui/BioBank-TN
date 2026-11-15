<?php
    session_start();
    $tel=$_POST['tel'];
    $psw=$_POST['psw'];
    require "../Models/fonctions.php";
    $conn=connexion();
    modif_statut($conn);//mettre à jour le statut des alertes expirées et notifications liée
    if(empty($tel)||empty($psw)){
        $_SESSION['error']= "Veuillez remplir tout les champs";
        header("Location:../Views/Connexion.php");
        exit;
    }else{
        $req=recupere_table($conn,"user","telephone=$tel");
        $user=$req->fetch(PDO::FETCH_ASSOC);//fetch retourne false si aucune ligne récuperé
        if(!$user){
            $_SESSION['error']= "Numéro de télèphone incorrecte";
            header("Location:../Views/Connexion.php");
            exit;
        }else{
            if($user['mot_de_passe']!=$psw){
                $_SESSION['error']= "Mot de passe incorrecte";
                header("Location:../Views/Connexion.php");
            }else{
                $_SESSION['type']=$user['type_user'];
                $_SESSION['id_user']=$user['id_user'];
                if($user['type_user']=="Admin")
                    header("Location:../Views/admin.php");
                elseif($user['type_user']=="Donneur")
                    header("Location:../donneur.php");
                elseif($user['type_user']=="Centre")
                    header("Location:../Views/centre.php");
                exit;
            }
        }
    }
?>