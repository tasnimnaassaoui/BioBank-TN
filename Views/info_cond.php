<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Information & Condition</title>
        <link href="../css/acceuil.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <!--barre-->
        <?php
          require "navbar_footer/navbar.php";
        ?>
        <div class="container ">
            <div class="row row-cols-1 row-cols-sm-1 ">
               <div class="col-md-7">
                   <h2 class="card-title">Qu'est-ce que le sang rare ?</h2>
                   <p class="card-text">Un groupe sanguin est dit <span style="color:black;font-weight:bold">rare</span> lorsqu'il est présent chez
                       moins de 4 personnes sur 1000 dans la population. Les personnes porteurses de ces
                       groupes ne peuvent recevoir que du sang compatible, ce qui rend chaque don 
                       extrêmement  précieux.
                   </p>
                   <p>Le<span style="color:black;font-weight:bold"> plasma</span> est la partie liquide du sang. Il est utilisé pour fabriquer des médicaments
                       essentiels (immunoglobulines, facteurs de coagulation) et pour des transfusions directes 
                       chez les patients en situation critique.
                   </p>
               </div>
               <div class="col-md-5">
                    <img src="../image/donation-info.jpg" id="img">
               </div>
           </div>
        </div>
        <section class="section">
        <div class="container " id="container">
            <div class="row text-center">
               <div class="col-sm-12">Les types de don</div>
            </div>
            <div class="row " >
               <div class="col-sm ">
                <div>
                   <h4><i class="bi bi-suit-heart-fill" style="color:rgb(172, 10, 10)"></i> Don de sang total</h4>
                   <ul style="list-style-type:none">
                      <li><i class="bi bi-clock" style="color:rgb(211, 5, 5)"></i> Durée : environ 10 minutes de prélèvement</li>
                      <li><i class="bi bi-exclamation-circle" style="color:rgb(211, 5, 5)"></i> Volume : 450 à 480 ml</li>
                      <li><i class="bi bi-clock" style="color:rgb(211, 5, 5)"></i> Délais entre deux dons : 8 semaines minimum</li>
                   </ul>
                 </div>
               </div>
               <div class="col-sm ">
                <div>
                   <h4><img src="image/log5.jpg" style="width:30px;height:30px"> Don de plasma</h4>
                   <ul style="list-style-type:none">
                      <li><i class="bi bi-clock" style="color:rgb(211, 5, 5)"></i> Durée : environ 45 à 60 minutes</li>
                      <li><i class="bi bi-exclamation-circle" style="color:rgb(211, 5, 5)"></i> Le plasma est séparé et les globules rouges sont restitué</li>
                      <li><i class="bi bi-clock" style="color:rgb(211, 5, 5)"></i> Délais entre deux dons : 2 semaines minimum</li>
                   </ul>
                 </div>
               </div>
            </div>
        </div>
        <div class="container " id="container">
            <div class="row text-center">
               <div class="col-sm-12">Conditions d'éligibilité</div>
            </div>
            <div class="row " >
               <div class="col-sm ">
                  <div>
                   <h4><i class="bi bi-check-circle" style="color:rgb(172, 10, 10)"></i>  Vous pouvez donner si :</h4>
                   <ul style="list-style-type:none">
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous avez entre 18 et 70 ans</li>
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous pesez au moins 50 kg</li>
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous êtes  en bonne santé générale</li>
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous n'avez pas donné de sang dans les 8 derniers semaines</li>
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous avez une pièce d'identité valide</li>
                      <li><i class="bi bi-check2-circle" style="color:rgb(211, 5, 5)"></i> Vous avez mangé et bu suffisamment abant le don</li>
                   </ul>
                   </div>
               </div>
               <div class="col-sm ">
                  <div>
                   <h4><i class="bi bi-x-circle" style="color:rgb(172, 10, 10)"></i>  Contre-indications :</h4>
                   <ul style="list-style-type:none">
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Infection ou fièvre récente (moins de 2 semaines)</li>
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Prise d'antibiotiques en cours</li>
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Grossesse ou accouchement récent (6 mois)</li>
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Intervention chirurgicale récente en zone à risque</li>
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Certains voyages récents en zone à risque</li>
                      <li><i class="bi bi-x-circle" style="color:rgb(211, 5, 5)"></i> Anémie ou taux d'hémoglobine insufisant</li>
                   </ul>
                  </div>
               </div>
            </div>
        </div>
        <div class="alert alert-danger" role="alert" style="margin-top:100px;margin-bottom:120px;margin-left:200px;width:70%;text-align:center">
            <i class="bi bi-exclamation-triangle" style="color:rgb(211, 5, 5)"></i> Important : L'éligibilité finale est déterminée lors de l'entretien pré-don avec un médecin ou un infirmier. 
            Cette liste est donnée à titre indicatif. N'hésitez pas à vous rendre dans un centre de collecte pour en discuter.
         </div>
        <div class="container text-center " style="margin-bottom:80px">
           <h1 style="margin-bottom:60px">Déroulement d'un don</h1>
            <div class="row row-cols-4 ">
               <div class="col">
                  <i class="bi bi-1-circle-fill " style="color:rgb(211, 5, 5);font-size:50px"></i>
                  <h4 style="text-align:left;margin-left:85px;width:40px">Acceuil</h4>
                  <h6 style="color:grey">Inscription et vérification d'identité</h6>
               </div>
               <div class="col">
                  <i class="bi bi-2-circle-fill " style="color:rgb(211, 5, 5);font-size:50px"></i>
                  <h4 style="text-align:left;margin-left:80px;width:40px">Entretient</h4>
                  <h6 style="color:grey">Questionnaire et examen médical confidentiel</h6>
               </div>
              <div class="col">
                  <i class="bi bi-3-circle-fill " style="color:rgb(211, 5, 5);font-size:50px"></i>
                  <h4 style="text-align:left;margin-left:65px;width:40px">Prélèvement</h4>
                  <h6 style="color:grey">Don de sang ou de plasma selon votre profil</h6>
              </div>
              <div class="col">
                  <i class="bi bi-4-circle-fill " style="color:rgb(211, 5, 5);font-size:50px"></i>
                  <h4 style="text-align:left;margin-left:97px;width:40px;">Repos</h4>
                  <h6 style="color:grey">Collation offerte et repos de 20 minutes</h6>
              </div>
            </div>
         </div>
  
        </section>
        <!--footer-->
        <?php
           require "navbar_footer/footer.php";
        ?>
    </body>
</html>