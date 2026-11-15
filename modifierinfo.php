<?php
session_start();
    /*inclut de fichier contenant les fonctions définies*/
    require "Models/fonctions.php";
    $conn=connexion();
    modif_statut($conn);//mettre à jour le statut des alertes expirées et notifications liée
    if(isset($_POST['modifierInfos'])){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $tel=$_POST['tel'];
    $psw=$_POST['psw'];
    $poids=$_POST['poids'];
    $anomalie=$_POST['anomalie'];
    if(empty($nom) && empty($prenom) && empty($CIN) && empty($tel) && empty($psw) && empty($poids) && empty($anomalie)){
        $_SESSION['error']= "Veuillez effectuer au moins une modification de vos données.";
        header('Location:modif_infos_donneur.php');
        exit;
    }else{
         $user=['nom'=>$nom,'prenom'=>$prenom,'telephone'=>$tel,'mot_de_passe'=>$psw,];
         $donneur=['poids'=>$poids,'anomalie'=>$anomalie];
         if(!empty($donneur['anomalie']) || (!empty($donneur['poids']) && $user['poids']<50)){
            $req=$conn->query("DELETE FROM user WHERE id_user=".$_SESSION['id_user']);
            $_SESSION['alert']='<div class="alert alert-danger">
                                  Santé ou poids non conforme → compte désactivé.
                                </div>';
            unset($_SESSION['type']);
            unset($_SESSION['id_user']);
            header('Location:Views/Connexion.php');
            exit;
         }else{
            foreach($user as $k=>$val){
               if(!empty($val)){
                  $req=$conn->prepare("UPDATE user SET $k=? WHERE id_user=".$_SESSION['id_user']);
                  $req->execute([$val]);
               }
            }
            foreach($donneur as $k=>$val){
               if(!empty($val)){
                  $req=$conn->prepare("UPDATE donneur SET $k=? WHERE id_user=".$_SESSION['id_user']);
                  $req->execute([$val]);
               }
            }    
         } header('Location:donneur.php');
            exit;
        }
    }
?>