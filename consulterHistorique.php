<?php
session_start();
require "Models/fonctions.php";
 require "Models/CentreModel.php";
 $conn=connexion();
 if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('Location:Views/Connexion.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Centre</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="css/acceuil.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
    <link href="css/centre.css" rel="stylesheet">
    
    </head>
    <body  class="d-flex flex-column min-vh-100">
       <?php
           require "Views/navbar_footer/navbar_user.php";
                     
    $id=recupere_idCentre($conn,$_SESSION['id_user']);
    $hists=historique($conn,$id);
    echo '<div id="historique" >';
    foreach($hists as $val){
    echo '<div class="alert alert-secondary" role="alert" style="font-weight:bold;font-size:18px;">'
          . $val['prenom'].' '.$val['nom'].' | '.$val['groupe_sanguin_rhesus'].' | '.$val['date_don'].'
            <form method="POST" action="supprimerHistorique.php">
                <input type="hidden" value="'.$val['id_hist'].'"name="id_hist">
               <button type="submit" name="supp" class="trash3"><i class="bi bi-trash3-fill"></i></button>
            </form>
          </div>
          ';
    }
    echo "</div>";
?>
</body>
</html>