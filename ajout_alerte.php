<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout des alertes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/acceuil.css" rel="stylesheet">
    <style>
       body { font-family: 'Segoe UI', , sans-serif;background-color:white; display: flex;justify-content: center;align-items: center; ; margin: 0;
        box-sizing: border-box;}
       form[name="ajoutalerte"] {background:white;padding: 30px;border-radius: 24px;box-shadow: 0 10px 25px black;margin-top:70px;width:600px;}
       form>div{margin-bottom:5px;border-radius:5px;border:solid 1px rgb(205, 210, 216);padding:4px}
       h3 { margin: 0 0 10px 0; font-size: 22px; color: black; }
       p { color: #64748b; font-size: 14px; margin-bottom: 25px; }
       label { display: block; font-size: 14px; font-weight: 600; margin-bottom:5px; color: #334155; }
       input[type="text"],input[type="number"] {width:80%;padding: 12px 16px;border: 2px solid #f1f5f9;border-radius: 12px;background-color: #f8fafc;
        font-size: 15px;transition: all 0.3s ease;outline: none;}
       input:focus {border-color: #ff5252;background-color: #fff;}
       input[type="submit"] {width: 100%;background-color: #f75151;color: white;border: none; padding: 14px;border-radius: 12px;font-size: 16px;font-weight: 600;
        cursor: pointer;transition: background 0.3s;}
       input[type="submit"]:hover { background-color: #e04545; } 
    </style>
    </head>
    <body  class="d-flex flex-column min-vh-100">
       <?php
           require "Views/navbar_footer/navbar_user.php";
        ?>
        <!--formulaire pour ajouter une alerte-->
        <form action="alerte.php" method="post" name="ajoutalerte">
            <h5 class="modal-title">Nouvelle alerte</h5>
            <div>
               <label>Type : </label><input type="text" placeholder="Type de don" name="type">
            </div>
            <div>
               <label>groupe sanguin & rhésus : </label><input type="text" placeholder="B +" name="gsr">
            </div>
            <div>
              <label>Quantité : </label><input type="number"  name="qte">
            </div>
            <div >
              <label>Niveau d'urgence : </label><input type="text" placeholder="Critique / normale" name="urgence">  
            </div>
            <div>
               <label>Date limite : <label><input type="datetime-local"  name="date_limite"> 
            </div>
        </div>
        <?php
             if(isset($_SESSION['erreur'])){
                    echo "<h6 style='color:red;'>".$_SESSION['erreur']."</h6>";
                     unset($_SESSION['erreur']);
                }
        ?>
        <input type="submit" value="Ajouter" name="ajout">
    </form>
</body>
</html>