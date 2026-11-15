<?php
   require "../Models/fonctions.php";
   $conn=connexion();
   modif_statut($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/acceuil.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <title>Acceuil</title>
    </head>
    <body >
        <!--barre-->
        <?php
            require "navbar_footer/navbar.php";
        ?>
        <div id="carouselExample" class="carousel slide">
           <div class="carousel-inner">
               <div class="carousel-item active">
                   <p >Approvisionnement sanguin<br>ciblé.<span style="color:rgb(255, 64, 64)"> Réponse en temps réel.</span></p>
                  <p class="desc">BioBank TN remplace les appels d'urgence sur les réseaux sociaux par une logistique de précision. Chaque alerte est ciblée. Chaque don est tracable.</p>
                  <a href="inscription_donneur.php" class="insc">S'inscrire comme donneur ➝</a>
                  <a href="espaceCentre.php" class="espace">Espace centres</a>
                  <img src="../image/font.png" class="d-block w-100" alt="..." >
               </div>
               <div class="carousel-item">
                  
                  <p >Donnez votre sang rare,<br>sauvez des vies</p>
                  <p class="desc">Le don de sang rare et de plasma est un acte vital. Chaque don compte pour les patients qui dépendent de groupes sanguins rares.</p>
                  <a href="info_cond.php" class="info">Savoir plus ➝</a>
                  <img src="../image/font.png" class="d-block w-100" alt="...">
               </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Next</span>
            </button>
        </div>
            
        
        </div>
            <!--infos sur le site-->
            <h3 id="comm">Comment ca fonctionne</h3>
            <section class="fonct">
                <div class="f">
                    <img src="../image/log1.jpg">
                    <h4>Alertes géolocalisées</h4>
                    <span>Alertes ciblés par groupe sanguin et <br>proximité. Acun donneur<br>inutilement alerté.</span>
                </div>
                <div class="f">
                    <img src="../image/log2.jpg">
                    <h4>Données sécurisées</h3>
                    <span>chiffrement bout-en-bout.<br>Conformité aux standars de<br>santé tunisiens.</span>
                </div>
                <div class="f">
                    <img src="../image/log1.jpg">
                    <h4>Réponse en temps réel</h3>
                    <span>Du signal d'alerte au don confirmé <br>en mois de 2 heures.</span>
                </div>
           </section>
        </div>
        <?php
          require "navbar_footer/footer.php";
        ?>
    </body>
    
</html>