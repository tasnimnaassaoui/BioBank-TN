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
 modif_statut($conn);//mettre à jours le statut de l'alerte et ces notification en expirée si la date limite est atteinte
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
    .table{margin-top:70px;margin-right:20px;width:900px;border:2px solid rgb(62, 104, 79);}
    a{text-decoration:none;font-size:20px;}
    .bi{color:rgb(156, 7, 7);font-size:25px}
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<?php require "Views/navbar_footer/navbar_user.php";?>
    <a href="Gere_alerte.php"class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><i class="bi bi-bell-fill"></i> Retour à la table des alertes</a>
   <table class="table table-success table-striped" >
      <tr>
        <th>ID</th>
        <th>Heure début</th>
        <th>Heure Fin</th>
        <th>Capacité maximle</th>
        <th>Place occupée</th>
        <th></th>
      </tr>
      <?php
      if(isset($_POST['id_alerte'])){
        $_SESSION['id_alerte']=$_POST['id_alerte'];}
         $req=$conn->query("SELECT * FROM creneau WHERE id_alerte=".$_SESSION['id_alerte']);
         $creneaux=$req->fetchAll(PDO::FETCH_ASSOC);
         $date=null;
        foreach($creneaux as $creneau){
            if($creneau['date_jour']!=$date){
                $date=$creneau['date_jour'];
                echo "<tr ><td colspan='6'>".$date."</td></tr>";
            }
            echo "
                <tr><td>".$creneau['id_creneau']."</td>
                      <td>".$creneau['Heure_debut']."</td>
                      <td>".$creneau['Heure_fin']."</td>";
                      if($creneau['capacite_max']!=0)
                        echo "<td>".$creneau['capacite_max']."</td>
                             <td>".$creneau['place_occupee']."</td>
                             <td></td>";
                       else{
                        echo "<form method='POST' action='alerte.php'>
                           <td><input type='number' name='cap_max' style='border:none'></td>
                           <td>".$creneau['place_occupee']."</td>
                            <td><input type='hidden' name='id_creneau' value='".$creneau['id_creneau']."'>
                            <button type='submit' class='btn btn-primary' name='enregistrer'>Enregistrer</button>
                         </td>
                         </form>
                       ";}
                   echo" </tr>";
        }
        
      ?>
   </table>
   <?php
      if(isset($_SESSION['msg_erreur'])){
                    echo "<h6 style='color:red;'>".$_SESSION['msg_erreur']."</h6>";
                     unset($_SESSION['msg_erreur']);
                }
    ?>
</body>
</html>