<?php 
    require "../Controllers/AdminController.php";
    
    modif_statut($conn);
    unset($_SESSION['gsr']);//si l'admin quitte la page de resultat d'une filtrage des donneurs la derniere recherche est supprimée
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard_Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="../css/admin.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100"  >
        <script>
            function activer(){
                document.getElementById("msg").style.display="none";
                document.getElementById("donneur_cible").style.display="block";
            }
            function desactiver(){
                document.getElementById("donneur_cible").style.display="none";
                document.getElementById("msg").style.display="block";
                document.getElementById("nb_total").style.display="none";
            }
        </script>
        <?php
       require "navbar_footer/navbar_user.php";?>
       <!--Actions-->
       <h3>Tableau de bord</h3>
       <ul class="nav nav-tabs text-center " id="myTab" role="tablist" >
            <li class="nav-item " id="acceuil">
                <button class="nav-link active" id="Acceuil-tab" data-bs-toggle="tab" data-bs-target="#Acceuil-tab-pane" type="button" role="tab" aria-controls="Acceuil-tab-pane" aria-selected="false" ><i class="bi bi-bar-chart-line"></i> Acceuil</button>
            </li>
            <li class="nav-item" >
                <button class="nav-link" id="donneur-tab" data-bs-toggle="tab" data-bs-target="#donneur-tab-pane" type="button" role="tab" aria-controls="donneur-tab-pane" aria-selected="false" ><i class="bi bi-person-gear"></i> Donneurs</button>
            </li>
            <li class="nav-item" >
                <button class="nav-link" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock-tab-pane" type="button" role="tab" aria-controls="stock-tab-pane" aria-selected="false" ><i class="bi bi-suit-heart"></i>Centres & Stocks  </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="alerte-tab" data-bs-toggle="tab" data-bs-target="#alerte-tab-pane" type="button" role="tab" aria-controls="stock-tab-pane" aria-selected="false" onclick="activer()"><i class="bi bi-bell"></i> Alertes</button>
            </li>
            <li class="nav-item" >
                <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#Question-tab-pane" type="button" role="tab" aria-controls="Question-tab-pane" aria-selected="false" ><i class="bi bi-question-circle"></i> Question</button>
            </li>
            <li>
                <button type="button" class="btn btn-dark position-relative" style="margin-left:450px" id="btnNotif">
                    Notifications
                    <?php if($notif_alertes>0 || $notif_questions>0) :?>
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                    <?php endif ?>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
           <!--l'acceuil de l'admin-->
           <div class="tab-pane fade show active" id="Acceuil-tab-pane" role="tabpanel" aria-labelledby="Acceuil-tab" tabindex="0" >
               <div style='background-color:rgb(255, 243, 243);
                                  border-radius:15px;
                                  border:solid 1px rgb(226, 170, 170);
                                  width:80%;margin-left:120px;margin-top:20px;'>
                                <h2 style='margin-top:30px;margin-left:10px'><i class='bi bi-heart-pulse-fill' style='color:rgb(192, 3, 3)'></i>  
                                <?php  echo "Bienvenu ".$admin['prenom']." ".$admin['nom'];?>
                                    <a href='../Controllers/changerInfosAdmin.php'><i class='bi bi-pencil-square' style='margin-left:600px;'></i></a>
                                </h2>
                                <h6 style='color:grey;margin-left:10px'>Tableau de bord centralisé pour la gestion des dons de sang</h6>
                                <h6 style='color:green;margin-left:10px;margin-top:20px;'><i class='bi bi-check-circle-fill'></i> État du système : Optimal</h6>
                           </div>
                    <!--Taux de conversion-->
                <h4 id='Taux'>Taux de conversion des notifications en rendez-vous : <span><?php echo $taux."%"; ?> </span></h4>
                <div class='stat'>
                    <!--Donneurs-->
                   <div id="chartContainerDonneur"></div>

                    <!--Alertes-->
                    <div id="chartContainerAlerte"></div>
                    <!--RDV-->
                     <div id="chartContainerRDV"></div>
                    <!--notifications-->
                    <div id="chartContainerNotif"></div>
                </div>
                
                <script>
            window.onload = function() {
              //donneur
               var chart = new CanvasJS.Chart("chartContainerDonneur", {
	            animationEnabled: true,
	            title: {
		           text: "Analyse de la population des Donneurs"
	            },
	            subtitles: [{
		            text: new Date().toLocaleDateString('fr-FR').replaceAll('/', '-')
	           }],
	            data: [{
		            type: "pie",
	             	yValueFormatString: "#,##0.00\"%\"",
		            indexLabel: "{label} ({y})",
		            dataPoints: <?php echo json_encode($dataDonneur, JSON_NUMERIC_CHECK); ?>
	           }]
               });
              chart.render();
              //alertes
               var chart = new CanvasJS.Chart("chartContainerAlerte", {
	                     animationEnabled: true,
	                     theme: "light2",
	                    title:{
		                  text: "Analyse des demandes de sang par groupe"
	                    },
	                    axisY: {
		                  title: "Pourcentage (%)"
	                    },
                        axisX: {
                            title: "Groupes sanguins"
                        },
	                    data: [{
		                   type: "column",
		                   yValueFormatString: "#,##0.00\"%\"",
		                    dataPoints: <?php echo json_encode($dataAlerte, JSON_NUMERIC_CHECK); ?>
	                    }]
                });
                chart.render();
               //RDV
               var chart = new CanvasJS.Chart("chartContainerRDV", {
	                     animationEnabled: true,
	                     theme: "light2",
	                    title:{
		                  text: "Évaluation des rendez-vous"
	                    },
	                    axisY: {
		                  title: "Pourcentage (%)"
	                    },
                        axisX: {
                            title: "Statut des rendez-vous"
                        },
	                    data: [{
		                   type: "column",
		                   yValueFormatString: "#,##0.00\"%\"",
		                    dataPoints: <?php echo json_encode($dataRDV, JSON_NUMERIC_CHECK); ?>
	                    }]
                });
                chart.render();
                    //notifications
                    var chart = new CanvasJS.Chart("chartContainerNotif", {
	                            theme: "light2",
	                            animationEnabled: true,
	                            title: {
		                           text: "Taux de réponse aux notifications"
	                            },
	                            data: [{
		                           type: "doughnut",
		                           indexLabel: "{label} - {y}%",
		                           yValueFormatString: "#,##0.0\"%\"",
		                           showInLegend: true,
		                           legendText: "{label} : {y}%",
		                           dataPoints: <?php echo json_encode($dataNotifications, JSON_NUMERIC_CHECK); ?>
	                            }]
                            });
                    chart.render();
            }
            </script>
            </div>
            <!--contenu donneur-->
            <div class="tab-pane fade" id="donneur-tab-pane" role="tabpanel" aria-labelledby="donneur-tab" tabindex="0">
                <table class="table table-striped" style="width:1300px;margin-top:50px;margin-left:10px;">
                    <thead>
                        <tr style="height:50px">
                            <th scope="col" style="width:200px;height:10px">Nom & Prénom</th>
                            <th scope="col" style="width:250px">Télèphone</th>
                            <th scope="col" style="width:150px">gouvernorat</th>
                            <th scope="col" style="width:50px">Groupe Sanguin & Rhésus</th>
                            <th scope="col" style="width:100px">Dernier don</th>
                            <th scope="col" style="width:200px">anomalie</th>
                            <th scope="col" style="width:200px">Etat du compte</th>
                            <th scope="col" style="width:200px">Durée de désactivation</th>
                            <th scope="col" style="width:200px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php while($user=$Donneurs->fetch(PDO::FETCH_ASSOC)):?>
                            <tr style="height:10px">
                                   <td style="width:200px;height:10px"><?php echo $user['nom'].' '.$user['prenom'];?></td>
                                   <td style="width:250px"><?php echo $user['telephone']; ?></td>
                                   <td style="width:50px"><?php echo $user['gov'];?></td>
                                   <td style="width:50px"><?php echo $user['groupe_sanguin_rhesus'];?></td>
                                   <td style="width:100px"><?php echo $user['dernier_don'];?></td>
                                   <td style="width:100px">
                                       <?php 
                                           if(empty($user['anomalie']))
                                              echo '--';
                                            else
                                               echo $user['anomalie'];
                                       ?>
                                    </td>
                                   <td style="width:200px"><?php echo $user['etat'];?></td>
                                   <td style="width:200px">
                                   <?php
                                      if(calcul_durée($conn,$user['id_user'])!=null)
                                       echo calcul_durée($conn,$user['id_user']);
                                      else
                                        echo '--';
                                    ?>
                                    </td>
                                   <td style="width:200px">
                                       <form method="POST" action="../Controllers/Donneur_question_centreController.php">
                                          <input type="hidden" value="<?php echo $user['id_user'];?>" name="id_user">
                                         <button type="submit" name="delete_D" style="font-size:25px;border:none;color:rgb(124, 7, 7)"><i class="bi bi-trash"></i></button>
                                       </form>
                                   </td>
                                </tr>
                            <?php endwhile;?>
                    </tbody>
                </table>
            </div>
            <!--stock-->
            <div class="tab-pane fade" id="stock-tab-pane" role="tabpanel" aria-labelledby="stock-tab" tabindex="0">
                <?php
                    while ($centre=$Centres->fetch(PDO::FETCH_ASSOC)):?>
                        <div class="centre-card">
                                   <div class="header-centre">
                                        <h3 class="nom"><?php echo $centre['nom'];?>
                                            <form method="POST" action="../Controllers/Donneur_question_centreController.php">
                                              <input type="hidden" value="<?php echo $centre['id_user'];?>" name="id_user">
                                              <button type="submit" name="delete_c" style="margin-left:1200px;font-size:25px;border:none;color:rgb(226, 3, 3);background-color:white">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            </form>
                                        </h3>
                                   </div>
                                   <div class="details">
                                      <i class="bi bi-geo-fill" style="color:red;font-size:16px"></i><?php echo $centre['gov'].' — '.$centre['adresse'];?>
                                      <i class="bi bi-telephone" style="color:green;font-size:16px"></i><?php echo $centre['telephone'].' |';?>
                                       <i class="bi bi-clock-history" style="color:blue;font-size:16px"></i><?php echo $centre['horaire_open'].' - '.$centre['horaire_close'];?>
                                   </div>
                                   <div class="grid-stocks">
                                       <?php 
                                          $stock=getstock_centre($centre['id_centre'],$conn);
                                         foreach ($stock as $key => $qte){
                                          // Logique métier : définir l'état du stock
                                          if($key!="id_centre"){
                                              if ($qte<10) 
                                                $etat = "faible";
                                              elseif ($qte <= 30) 
                                                $etat = "normale";
                                              else
                                                $etat = "très_bien";
                                          
                                              echo '<div class="stock-item" id="'.$etat.'">
                                                     '.$key.' : '.$qte.'
                                                   </div>';
                                            }
                                        
                                        }?>
                                   </div>
                                </div>
                    <?php endwhile?>
            </div>
            <!--Alertes-->
            <div class="tab-pane fade" id="alerte-tab-pane" role="tabpanel" aria-labelledby="alerte-tab" tabindex="0">
                    <form class="d-flex" id="search" role="search" method="GET" action="affichage_donneurCible.php">
                        <input class="form-control me-2" type="search" placeholder="B- / ville" aria-label="Search" name="groupe_recherche"/>
                        <button class="btn btn-outline-success" type="submit">Filtrer donneur</button>
                    </form>
                    <?php
                    if(isset($_SESSION['erreur'])){
                       echo "<h6 style='width:400px;color:red;font-size:15px;margin-left:40px'>".$_SESSION['erreur']."</h6>";
                       unset($_SESSION['erreur']);
                    }
                    ?>
                    <!--Liste des alertes-->
                    <div class="tab-pane fade show active" id="liste-tab-pane" role="tabpanel" aria-labelledby="liste-tab" tabindex="0">
                        <?php
                           //affichage de la table alerte+ information du centre qui envoi l'alerte
                           if($Alertes->rowCount()>0):?>
                           <table class="table table-striped table-sm table-responsive" id="table_centre" style="margin-top:20px;line-height: 1.2">
                                <thead data-bs-theme="dark">
                                   <tr class="table-active" >
                                       <th style="width:80px">ID</th>
                                       <th>Nom centre</th>
                                       <th>gouvernorat</th>
                                       <th>type de don</th>
                                       <th>groupe sanguin & rhésus</th>
                                       <th>Qantité</th>
                                       <th>Urgence</th>
                                       <th>Date limite</th>
                                       <th>statut</th>
                                   </tr>
                               </thead>
                            <tbody>
                            <?php while($alerte=$Alertes->fetch(PDO::FETCH_ASSOC)):?>
                                <tr  style="height: 30px;">
                                       <td style="width:80px"><?php echo $alerte['id_alerte'];?></td>
                                       <td><?php echo $alerte['nom'];?></td>
                                       <td><?php echo $alerte['gov'];?></td>
                                       <td><?php echo $alerte['type_don'];?></td>
                                       <td><?php echo $alerte['groupe_sanguin_rhesus'];?></td>
                                       <td><?php echo $alerte['quantite'];?></td>
                                       <td><?php echo $alerte['urgence'];?></td>
                                       <td><?php echo $alerte['date_limite'];?></td>
                                       <td><?php echo $alerte['statut'];?></td>
                                     <td><form method="POST" action="../Controllers/Donneur_question_centreController.php">
                                          <button type="submit" name="delete_A" style="font-size:25px;border:none;color:rgb(124, 7, 7)"><i class="bi bi-trash"></i></button>
                                          <input type="hidden" value="<?php echo $alerte['id_alerte'];?>" name="id_alerte">
                                          </form>
                                      </td>
                                </tr>
                            <?php endwhile?>
                           </tbody>
                            </table>
                           <?php else:?>
                              <h5  style="color:rgb(211, 187, 187);margin-top:150px;margin-left:550px;">Aucune alerte n’a été trouvée.</h5>
                            <?php endif;?>
                   </div>
            </div>
            <!--Contenue de question-->
            <div class="tab-pane fade" id="Question-tab-pane" role="tabpanel" aria-labelledby="Question-tab" tabindex="0">
                   <!--affichage de la table des question-->
                    <table class="table table-striped table-sm table-responsive" id="tableQuestion">
                        <thead data-bs-theme="dark">
                           <tr class="table-active" >
                              <th >ID</th>
                              <th >Question</th>
                              <th >Réponse</th>
                              <th>Date</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                    <?php while($QR=$QRS->fetch(PDO::FETCH_ASSOC)):?>
                        
                       <tr >
                            <td ><?php echo $QR['id_QR'];?></td>
                               <td ><?php echo $QR['question'];?></td>
                               <td ><?php if(!empty($QR['reponse'])):/*lire la réponse si existe*/?>
                                        <?php  echo $QR['reponse'];?>
                                    <?php else: /*sinon un formulaire pour saisir la réponse*/?> 
                                             <form method="POST" action ="../Controllers/reponse.php">
                                            <input type="hidden" value="<?php echo $QR['id_QR']; ?>" name="id">
                                            <input type="text" name="reponse" placeholder="Veuillez Répondre à cette question" style="border:none">
                                            <button type="submit" name="valider">OK</button>
                                         </form>
                                    <?php endif;?>
                               </td>
                               <td><?php echo $QR['date_creation'];?></td>
                               <td>
                                    <form method="POST" action="../Controllers/Donneur_question_centreController.php">
                                        <input type="hidden" name="QR" value="<?php echo $QR['id_QR'];?>">
                                        <button type="submit" name="delete_Q" style="font-size:25px;border:none;color:rgb(226, 3, 3);"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                          </tr>
                     
                    <?php endwhile?>
                    </tbody>
                    </table>
                    <?php 
                    if(isset($_SESSION['message1'])){
                       echo '<p style="color:green;font-size:17px">'.$_SESSION['message1'].'</p>';
                       unset($_SESSION['message1']);
                    }
                    if(isset($_SESSION['message2'])){
                       echo '<p style="color:red;font-size:17px">'.$_SESSION['message2'].'</p>';
                       unset($_SESSION['message2']);
                    }
                     ?>
            </div>
            <!--Notification(nouvelles alertes /questions non répondu)!-->
            
            <div aria-live="polite" aria-atomic="true" >
               <div class="toast-container top-0 end-0 p-3" style="margin-top:150px">
                   <?php if($notif_alertes>0): ?>
                   <div class="toast notif-toast" role="alert" aria-live="assertive" aria-atomic="true">
                       <div class="toast-header">
                           <i class="bi bi-bell-fill" style="font-size:18px;color:red"></i>
                           <strong class="me-auto"> Nouvelles alertes</strong>
                           <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                       </div>
                       <div class="toast-body">
                           <?php
                              echo $notif_alertes." alerte(s) non envoyée(s).";
                            ?>
                       </div>
                    </div>
                    <?php endif;?>
                    <?php if ($notif_questions>0): ?>
                    <div class="toast notif-toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                           <i class="bi bi-patch-question" style="font-size:18px;color:red"></i>
                           <strong class="me-auto"> Nouvelles questions</strong>
                           <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                           <?php
                              echo $notif_questions." question(s) non répondus.";
                            ?>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <script>
               document.getElementById("btnNotif").addEventListener("click", function () {
                    let toasts = document.querySelectorAll('.notif-toast');
                    toasts.forEach(function(toastEl) {
                        let toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    });
               });
            </script>
        </div>
        <footer style="text-align:center; padding:10px; background:#f5f5f5; margin-top:20px;">
            <p>BioBank Admin Panel © 2026</p>
        </footer>
    </body>
    
</html>