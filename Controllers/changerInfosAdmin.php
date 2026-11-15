<?php
   session_start();
    /*inclut de fichier contenant les fonctions définies*/
    require "../Models/fonctions.php";
    require "../Models/AdminModel.php";
    $conn=connexion();
    modif_statut($conn);//mettre à jour le statut des alertes expirées et notifications liée
    if(isset($_POST['modifierInfos'])){
    $nom=$_POST['nomAdmin'];
    $prenom=$_POST['prenomAdmin'];
    $tel=$_POST['telAdmin'];
    $psw=$_POST['psw'];
    if(empty($nom) && empty($prenom) && empty($CIN) && empty($tel) && empty($psw) ){
        $_SESSION['error']= "Veuillez effectuer au moins une modification de vos données.";
    }else{
         $user=['nom'=>$nom,'prenom'=>$prenom,'telephone'=>$tel,'mot_de_passe'=>$psw];
        foreach($user as $k=>$val){
            if(!empty($val)){
                modif_infoAdmin($conn,$k,$val);
            }
        }
        }
    }
?>
<?php require "../Views/form_modifInfoAdmin.php" ?>
