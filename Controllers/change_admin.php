<?php 
    session_start();
    /*inclut de fichier contenant les fonctions définies*/
    require "../Models/fonctions.php";
    require "../Models/AdminModel.php";
    $conn=connexion();
    /*verification du formulaire*/
    if(isset($_POST['submit'])){
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['psw'])  && !empty($_POST['psw1'])){
            if($_POST['psw']==$_POST['psw1']){
               $code=random_int(10000000,99999999);
               while(verif_code_securite($conn,$code)==1){
                  $code=random_int(10000000,99999999);
               }
               ajout_admin($conn,$_POST['nom'],$_POST['prenom'],$_POST['tel'],$_POST['psw'],$code);
                echo "<script>
                        alert('Votre code de sécurité est : ".$code." \\
                         Important : ce code de sécurité est généré une seule fois. Merci de le noter et de le conserver en lieu sûr, car il ne sera plus affiché.')
                       </script>";
            }else
               $_SESSION['message']="Mot de passe incorrecte.";
        }else
            $_SESSION['message']="Veuillez saisir tout les champs.";
    }
    if(isset($_POST['quitter_admin'])){
        //avant il faut verifier qu 'il a un autre admin sinon la demande est refusé
      
        if (autreAdmin_existe($conn,$_SESSION['id_user'])){
           delete_Data($conn,"user","id_user=".$_SESSION['id_user']);
            $_SESSION['alert']="<div class='alert alert-primary' role='alert'>
                              Vous avez quitté l 'administration.
                            </div>";
            unset($_SESSION['type']);
            unset($_SESSION['id_user']);
            header('Location:../Views/Connexion.php');
             exit;
       }else{
           $_SESSION['erreur']="Action impossible : vous devez transférer les droits d’administration à un autre utilisateur avant de quitter.";
        }
    }
?>
<?php require '../Views/form_changeAdmin.php';?>