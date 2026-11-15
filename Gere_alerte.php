<?php
   session_start();
   if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('Location:Connexion.php');
        exit;
    }
   require "Models/fonctions.php";
   $conn=connexion();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion des alertes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<style>
    body { font-family: 'Segoe UI', sans-serif; background-color:rgb(224, 224, 224);margin: 0;display: flex;justify-content: center;align-items: center;}
    </style>
</head>
<body >
<?php require "Views/navbar_footer/navbar_user.php";?>
<div class="tab-pane fade show active" id="liste-tab-pane" role="tabpanel" aria-labelledby="liste-tab" tabindex="0">
                        <?php
                           //affichage de la table alerte+ information du centre qui envoi l'alerte
                           $req=recupere_table($conn,"alertes","id_user=".$_SESSION['id_user']);
                           if($req->rowCount()>0){
                           echo '<table class="table table-striped-columns table-sm table-responsive" id="table_centre" style="display:block;margin-top:70px;">
                                <thead data-bs-theme="dark">
                                   <tr class="table-active" >
                                       <th style="width:80px">ID</th>
                                       <th>type de don</th>
                                       <th>groupe sanguin & rhésus</th>
                                       <th>Qantité</th>
                                       <th>Urgence</th>
                                       <th>Date création</th>
                                       <th>Date limite</th>
                                       <th>statut</th>
                                   </tr>
                               </thead>
                            <tbody>';
                            while($element=$req->fetch(PDO::FETCH_ASSOC)){
                                //recuperation de sinformation du centre de la table user et centre
                                echo '<tr>
                                       <td style="width:80px">'.$element['id_alerte'].'</td>
                                     <td>'.$element['type_don'].'</td>
                                     <td>'.$element['groupe_sanguin_rhesus'].'</td>
                                     <td>'.$element['quantite'].'</td>
                                     <td>'.$element['urgence'].'</td>
                                     <td>'.$element['date_creation'].'</td>
                                     <td>'.$element['date_limite'].'</td>
                                     <td>'.$element['statut'].'</td>
                                     <td> ';
                                     if($element['statut']==='active')
                                        echo '<form method="POST" action="alerte.php" style="margin-top:0px">
                                               <input type="hidden" name="id_alert" value="'.$element['id_alerte'].'">
                                               <button type="submit" class="btn btn-success" name="statut">Résolue</button>
                                            </form></td>';
                                    echo '
                                    <td> <form method="POST" action="Gestion_RDV.php" style="margin-top:0px">
                                               <input type="hidden" name="id_alerte" value="'.$element['id_alerte'].'">
                                               <button type="submit" class="btn btn-primary" name="RDV">Gérer les rendez-vous</button>
                                            </form>
                                    </td>
                                    
                                </tr>';
                            }
                           echo '</tbody>
                            </table>';
                        }else
                              echo '<h5  style="color:rgb(211, 187, 187);margin-top:150px;">Aucune alerte n’a été trouvée.</h5>';
                    ?>
</div>
</body>
</html>