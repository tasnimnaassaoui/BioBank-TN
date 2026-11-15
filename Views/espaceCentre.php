<?php
   session_start();
   $jour=array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
   $sang=array('O_plus','O_moins','A_plus','A_moins','B_plus','B_moins','AB_plus','AB_moins');
   require "../Models/fonctions.php";
   $conn=connexion();
   modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/acceuil.css" rel="stylesheet">
    <link href="../css/centre.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
       require "navbar_footer/navbar.php";
    ?>
    <form action="../Controllers/inscription_centre.php" method="post"  class="form5">
        <i class="bi bi-suit-heart-fill" style="color:rgb(187, 0, 0);font-size:40px;margin-left:300px"></i>
        <h2 style='text-align:center; font-size: 25px; color: black;'>Espace Centre</h2>
        <h6 style="text-align:center;color: #64748b; font-size: 17px;margin-bottom:15px;">Gérez votre centre de don</h6>
        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist" >
            <li class="nav-item" role="presentation">
                <button class="nav-link active " id="pills-compte-tab" data-bs-toggle="pill" data-bs-target="#pills-compte" type="button" role="tab" aria-controls="pills-compte" aria-selected="true">Créer un compte</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link "  id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Infos du centre</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-compte" role="tabpanel" aria-labelledby="pills-compte-tab" tabindex="0">
                <div>
                   <label>Nom du centre </label>
                   <input type="text" name="nomcentre">
                </div>
                <div>
                   <label>Télèphone</label>
                   <input type="text" name="tel">
                   <label>Mot de passe</label>
                   <input type="text" name="mdp">
                </div> 
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div >
                    <h4><i class="bi bi-geo-alt"></i> Coordonnées</h4>
                    <div>
                       <label>Adresse : </label><input type="text" name="adresse" >
                    </div>
                    <diV>
                        <label>gouvernorat</label><input type="text" name="gouv" >
                    </div>
                </div>
                <div>
                   <h4><i class="bi bi-clock-history" ></i> Horaires & disponibilité </h4>
                   <div>
                      Ouverture : <input type="time" name="open" id="open" >  Fermeture : <input type="time" name="close" id="close" >
                   </div>
                    <div>
                       <label>Jours de collecte :</label>
                       <?php
                         for($i=0;$i<count($jour);$i++){
                               echo '<input type="checkbox" name="check'.$jour[$i].'"  class="jour" value="'.$jour[$i].'">'.$jour[$i];
                           }
                        ?>
                   </div>
                </div>
                <diV>
                    <h4><i class="bi bi-house-heart"></i> Réserves de sang</h4>
                    <?php
                         for($i=0;$i<count($sang);$i++){
                               echo '<div><span style="color:red">'.$sang[$i].'</span>
                                          <input type="number" name="'.$sang[$i].'" style="margin-bottom:15px">
                                    </div>';
                           }
                    ?>
                </div>
            </div>
        </div>
        
        <?php
          if(isset($_SESSION['error'])){
            echo "<h6 style='color:red;'>".$_SESSION['error']."</h6>";
            unset($_SESSION['error']);
          }
        ?>
        <input type="submit" name="creer" value="Créer mon compte">
    </form>
</body>
</html>