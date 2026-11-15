<?php
/*si le centre se déconnecte*/
session_start();
 require "../Models/fonctions.php";
 require "../Models/CentreModel.php";
 require "../Models/AdminModel.php";
 $conn=connexion();
 modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Centre</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../css/acceuil.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <link href="../css/centre.css" rel="stylesheet">
    
    </head>
    <body  class="d-flex flex-column min-vh-100">
       <?php
           require "navbar_footer/navbar_user.php";
           $req=recupere_table($conn,"user","id_user=".$_SESSION['id_user']);
           $user=$req->fetch(PDO::FETCH_ASSOC);
           $req=recupere_table($conn,"centres","id_user=".$_SESSION['id_user']);
           $centre=$req->fetch(PDO::FETCH_ASSOC);
           echo "<div class='menu'>
                    <h6 >Tableau de bord centralisé pour la gestion des dons de sang </h6>
                    <h3 style='margin-left:10px;margin-top:10px'>Bienvenu ".$user['nom']."</h3>
                    <div class='centre-card'>
                       <div class='details' style='margin-bottom:10px;margin-left:10px'>
                          <i class='bi bi-geo-fill' style='color:red;font-size:16px;'></i>".$centre['gov']." — ".$centre['adresse']."
                          <i class='bi bi-telephone' style='color:green;font-size:16px;'></i> ".$centre['telephone']." | <i class='bi bi-clock-history' style='color:blue;font-size:16px'></i> ". $centre['horaire_open']." - ".$centre['horaire_close']."
                       </div>
                   </div>
                </div>";
                
        ?>
        <div class=corp>
           <!--Stock-->
           <div class='contenu' >
               <h4 style='margin-left:10px;color:black;'>
                  <i class="bi bi-box2-heart"></i> Stocks de sang 
                  <a href="Gere_stock.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><i class="bi bi-gear"></i> Gérer</a>
               </h4>
              <div class='centre-card'>
                  <?php
                    $stock=recupere_stock($conn,$centre['id_centre']);
                    foreach ($stock as $key => $qte){
                        // Logique métier : définir l'état du stock
                        if($key!="id_centre"){
                          if ($qte<10) 
                            $etat = "faible";
                          elseif ($qte <= 30) 
                            $etat = "normale";
                          else
                            $etat = "très_bien";
                           echo '<div class="stock-item1" id="'.$etat.'">
                                   '.$key.' : '.$qte.'
                                 </div>';
                        }
                     }
                 ?>
               </div>
            </div>
            
            <!--Alerte-->
            <div class='contenu'>
               <h4 style='margin-left:10px;color:black'><i class="bi bi-bell-fill"></i> Alertes envoyées<a href="../Gere_alerte.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><i class="bi bi-gear"></i> Gérer</a></h3>
               <div class='centre-card'>
                  <?php
                     echo "<h6> Alertes résolues : ".nbr_ligne($conn,"alertes","id_user=".$_SESSION['id_user']." AND statut='Résolue'")."</h6>
                          <h6> Alertes activées : ".nbr_ligne($conn,"alertes","id_user=".$_SESSION['id_user']." AND statut='active'")."</h6>";
                  ?>
                  <a href="../ajout_alerte.php" id="ajout_alerte"><i class='bi bi-plus-circle me-2' style='color:white;' ></i>Ajouter alerte</a>
               </div>
            </div>
            
            <!--Historique de don-->
            <div class='contenu'>
               <h4 style='margin-left:10px;color:black'><i class="bi bi-calendar2-day"></i> Historiques</h3>
               <div class='centre-card'>
                  <a href="../consulterHistorique.php" class="info" style="margin-top:10px;margin-left:80px">Voir historique</a>
               </div>
            </div>
            <div></div>
            <!--Rendez-vous-->
            <div class='contenu' style="width:1150px">
               <h4 style='margin-left:10px;color:black'><i class="bi bi-calendar2-date"></i> Rendez-vous</h4>
               <div class='centre-card'>
                   <h6>Aujourd'hui</h6>
                   <?php
                   //lire les rendez-vous confirmé d'aujourd'hui par ordre selon heure de début 
                     $req=$conn->query("SELECT * FROM rendez_vous WHERE statut='confirmé' 
                                       AND id_creneau IN (SELECT id_creneau FROM creneau WHERE date_jour=CURDATE() AND id_alerte 
                                                                                                   IN(SELECT id_alerte FROM alertes WHERE id_user=".$_SESSION['id_user'].")) 
                                       ORDER BY (SELECT Heure_debut FROM creneau WHERE creneau.id_creneau=rendez_vous.id_creneau)");
                     $RDV=$req->fetchAll();
                     if(count($RDV)>0){
                     foreach($RDV as $rdv){
                        $req=$conn->query("SELECT nom,prenom FROM user WHERE id_user=".$rdv['id_user']);//recupérer nom et prenom du donneur
                        $donneur=$req->fetch(PDO::FETCH_ASSOC);
                        $req=$conn->query("SELECT CIN FROM donneur WHERE id_user=".$rdv['id_user']);//recupérer CIN du donneur
                        $Donneur=$req->fetch(PDO::FETCH_ASSOC);
                        $req=$conn->query("SELECT type_don,groupe_sanguin_rhesus FROM alertes 
                                           WHERE id_alerte IN(SELECT id_alerte FROM creneau WHERE id_creneau=".$rdv['id_creneau'].")");
                        $don=$req->fetch(PDO::FETCH_ASSOC);//chercher le type du don correspend à cet RDV 
                        if($don['type_don']==="sang total")
                           $color="red";
                        else
                           $color="blue";
                        $req=$conn->query("SELECT Heure_debut,Heure_fin FROM creneau WHERE id_creneau=".$rdv['id_creneau']);//lire heure debut et fin du RDV
                        $creneau=$req->fetch(PDO::FETCH_ASSOC);
                        echo '<div class="alert alert-secondary" role="alert" >
                                   <div>
                                       <span style="border-right:3px solid '.$color.';padding-right:10px;color:black">'
                                          .$creneau['Heure_debut'].
                                       '</span>
                                       <span style="padding-left:10px;font-weight:bold">'.$donneur['prenom'].' '.$donneur['nom'].'</span>
                                       <span class="statut text-end " style="margin-left:760px">'.$rdv['statut'].'</span>
                                    </div>
                                    <div>
                                       <span style="border-right:3px solid '.$color.';padding-right:21px;font-size:13px;">'
                                          .$creneau['Heure_fin'].
                                       '</span>
                                       <span style="padding-left:10px">
                                          <i class="bi bi-circle-fill" style="color:'.$color.'"></i> '.$don['type_don'].' : '.$don['groupe_sanguin_rhesus'].
                                       '</span>
                                         <span style="margin-left:30px"> CIN '.$Donneur['CIN'].'</span>
                                         <form method="POST" action="../changerStatutRDV.php" style="margin-top:5px;margin-left:850px">
                                           <input type="hidden" name="id_user" value="'.$rdv['id_user'].'">
                                           <button type="submit" name="effectue" class="btn btn-success" >Réalisé</button>
                                           <button type="submit" name="non_effectue" class="btn btn-danger" >Non réalisé</button>
                                        </form>
                                    </div>
                              </div>';
                     }
                     }else
                        echo "<h5  style='display:block; color:rgb(211, 187, 187);margin-top:20px;margin-left:420px'>Pas de rendez-vous aujourd'hui.</h5>";
                   ?>
                   <h6>Demain</h6>
                   <?php
                   //lire les rendez-vous confirmé d'aujourd'hui par ordre selon heure de début 
                     $req=$conn->query("SELECT * FROM rendez_vous WHERE statut='confirmé' 
                                       AND id_creneau IN (SELECT id_creneau FROM creneau WHERE date_jour=DATE_ADD(CURDATE(),INTERVAL 1 DAY) AND id_alerte 
                                                                                                   IN(SELECT id_alerte FROM alertes WHERE id_user=".$_SESSION['id_user'].")) 
                                       ORDER BY (SELECT Heure_debut FROM creneau WHERE creneau.id_creneau=rendez_vous.id_creneau)");
                     $RDV=$req->fetchAll();
                     if(count($RDV)>0){
                     foreach($RDV as $rdv){
                        $req=$conn->query("SELECT nom,prenom FROM user WHERE id_user=".$rdv['id_user']);//recupérer nom et prenom du donneur
                        $donneur=$req->fetch(PDO::FETCH_ASSOC);
                        $req=$conn->query("SELECT CIN FROM donneur WHERE id_user=".$rdv['id_user']);//recupérer CIN du donneur
                        $Donneur=$req->fetch(PDO::FETCH_ASSOC);
                        $req=$conn->query("SELECT type_don,groupe_sanguin_rhesus FROM alertes 
                                           WHERE id_alerte IN(SELECT id_alerte FROM creneau WHERE id_creneau=".$rdv['id_creneau'].")");
                        $don=$req->fetch(PDO::FETCH_ASSOC);//chercher le type du don correspend à cet RDV 
                        if($don['type_don']==="sang total")
                           $color="red";
                        else
                           $color="blue";
                        $req=$conn->query("SELECT Heure_debut,Heure_fin FROM creneau WHERE id_creneau=".$rdv['id_creneau']);//lire heure debut et fin du RDV
                        $creneau=$req->fetch(PDO::FETCH_ASSOC);
                        echo '<div class="alert alert-secondary" role="alert">
                                   <div>
                                       <span style="border-right:3px solid '.$color.';padding-right:10px;color:black">'
                                          .$creneau['Heure_debut'].
                                       '</span>
                                       <span style="padding-left:10px;font-weight:bold">'.$donneur['prenom'].' '.$donneur['nom'].'</span>
                                       <span class="statut text-end d-block" >'.$rdv['statut'].'</span>
                                    </div>
                                    <div>
                                       <span style="border-right:3px solid '.$color.';padding-right:21px;font-size:13px">'
                                          .$creneau['Heure_fin'].
                                       '</span>
                                       <span style="padding-left:10px">
                                          <i class="bi bi-circle-fill" style="color:'.$color.'"></i> '.$don['type_don'].' : '.$don['groupe_sanguin_rhesus'].
                                       '</span>
                                         <span style="margin-left:30px"> CIN '.$Donneur['CIN'].'</span>
                                        <form method="POST" action="../changerStatutRDV.php" style="margin-top:5px;margin-left:500px">
                                           <input type="hidden" name="id_user" value="'.$rdv['id_user'].'">
                                           <button type="submit" name="effectue" class="btn btn-success" >Réalisé</button>
                                           <button type="submit" name="non_effectue" class="btn btn-danger" >Non réalisé</button>
                                        </form>
                                    </div>
                              </div>';
                     }
                     }else
                        echo "<h5  style='display:block; color:rgb(211, 187, 187);margin-top:20px;margin-left:420px'>Pas de rendez-vous demain.</h5>";
                   ?>
               </div>
            </div>
         </div>


</body>
</html>
