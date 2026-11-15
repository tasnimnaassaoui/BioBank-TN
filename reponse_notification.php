<?php
  session_start();
  require "Models/fonctions.php";
  $conn=connexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard_Admin</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <style>
    .table{margin-top:70px;margin-left:180px;width:900px;}
    
    a{text-decoration:none;font-size:20px;}
    span{font-weight:bold;color:rgb(255, 196, 0);font-size:18px}
    </style>
<body>
    <?php
    //si le donneur refuse l'alerte
  if(isset($_POST['refuse'])){
       $req=$conn->prepare("UPDATE notifications SET statut='refusé' WHERE id_user=? AND id_alerte=?");
       $req->execute([$_SESSION['id_user'],$_POST['id_alerte']]);
       header('Location:donneur.php');
       exit;
  }
  //si le donneur accepte
  if(isset($_POST['accepte'])){
    $_SESSION['id_alerte']=$_POST['id_alerte'];}
    require "Views/navbar_footer/navbar_user.php";
    if(isset($_SESSION['id_alerte'])){
    $req=$conn->prepare("UPDATE notifications SET statut='accepté' WHERE id_user=? AND id_alerte=?");
     $req->execute([$_SESSION['id_user'],$_SESSION['id_alerte']]);//statut de notification accepté
    $res=$conn->prepare('SELECT * FROM alertes WHERE id_alerte=?');
    $res->execute([$_SESSION['id_alerte']]);
    $alerte=$res->fetch(PDO::FETCH_ASSOC);
    if($alerte){
        $date_creation=$alerte['date_creation'];
        $date_limite=$alerte['date_limite'];//date limite
    }//récupération du centre de la table user
    $res1=$conn->prepare('SELECT * FROM user WHERE id_user=?');
    $res1->execute([$alerte['id_user']]);
    $centre=$res1->fetch(PDO::FETCH_ASSOC);
    require "Views/navbar_footer/navbar_user.php";
    echo "<div class='alert alert-warning' role='alert' style='margin-top:70px;margin-left:180px ;width:900px'>
            <span>Information de l'alerte<br></span> <span style='font-weight:bold'>Centre : </span>".$centre['nom'].
            "<br> <span style='font-weight:bold'>Date création :</span> ".$date_creation."<br><span style='font-weight:bold'> Date limite : </span>".$date_limite."
         </div>";?>
   <table class="table table-success table-striped" >
      <tr>
        <th >Heure</th>
        <th>Durée</th>
        <th>Place occupée</th>
        <th>statut</th>
        <th>Action</th>
      </tr>
      <?php
        $req=$conn->query("SELECT * FROM creneau WHERE id_alerte=".$_SESSION['id_alerte']);
        $creneaux=$req->fetchAll(PDO::FETCH_ASSOC);
        $date=null;
         foreach($creneaux as $creneau){
            if($creneau['date_jour']!=$date){
                $date=$creneau['date_jour'];
                echo "<tr ><td colspan='6'>".$date."</td></tr>";
            }
            echo "<tr>
                      <td >".$creneau['Heure_debut']."</td>";//heure début
                      if($alerte['type_don']==="sang total")//durée de don selon le type
                        echo"<td> 1h</td>";
                      else
                        echo "<td> 1h30</td>";
                     echo "<td>".$creneau['place_occupee']."/".$creneau['capacite_max']."</td>";
                    $req=$conn->prepare("SELECT * FROM rendez_vous WHERE id_creneau=".$creneau['id_creneau']." AND id_user=".$_SESSION['id_user']);
                    $req->execute([]);
                    if($req->rowCount()!=0){
                        echo "<td style='color:blue'>Mon RDV</td>
                            <td><button type='button' class='btn btn-outline-secondary' >Réservé</button>
                                <form method='POST' action='alerte.php'>
                                    <input type='hidden' name='id_creneau' value='".$creneau['id_creneau']."'>
                                   <button type='submit' class='btn btn-outline-danger' name='annuler'>Annuler</button>
                                </form>
                            </td>";
                    }else{
                        if($creneau['statut']==="disponible"){
                          echo "<td style='color:green'>".$creneau['statut']."</td>
                              <td>
                               <form method='POST' action='alerte.php'>
                                  <input type='hidden' name='id_creneau' value='".$creneau['id_creneau']."'>";
                                  if(isset($_SESSION['boutton'.$_SESSION['id_user']]))
                                      echo "<button type='button' class='btn btn-outline-secondary' >Indisponible</button>";
                                   else
                                      echo "<button type='submit' class='btn btn-outline-secondary' name='choisir'>choisir</button>";
                              echo"  </form>
                           </td>";
                        }else{
                           echo "<td style='color:red'>".$creneau['statut']."</td>
                            <td><button type='button' class='btn btn-outline-secondary' >Indisponible</button></td>";
                        }
                    }
                   echo" </tr>";

      }
      }?>
    
   </table>
</body>
</html>
  
  