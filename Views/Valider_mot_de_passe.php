<?php
  session_start();
  if(isset($_SESSION['code'])){
      echo "<script>
           alert('Votre code de sécurité est : ".$_SESSION['code']." \\
            Important : ce code de sécurité est généré une seule fois. Merci de le noter et de le conserver en lieu sûr, car il ne sera plus affiché.')
        </script>";
        unset($_SESSION['code']);
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
    <link href="../css/inscription.css" rel="stylesheet">
    <link href="../css/acceuil.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require "navbar_footer/navbar.php";?>
        <!--terminer l  inscription on demandant un mot de passe-->
          <form method='POST' action='../Controllers/CreationCompteDonneur.php' onsubmit='return validerFormulaire()' style="margin-left:450px;margin-top:40px;">
            <fieldset style="border:solid 5px rgb(129, 40, 40);width:400px;height:350px;border-radius:10px">
                    <legend><img src="../image/log5.jpg" style="width:40px;height:40px ;border-radius:3px;"></legend>
                    
                  <div><label>Mot de passe</label>
                  <input type='password' name='password' id="psw" style="margin-left:20px;"></div>
                  <span id="errnom" style='font-weight:bold'></span>
                  <div style="margin-top:15px"><label>Confirmer le mot de passe</label>
                  <input type='password' name='confpassword' style="margin-left:20px;"></div>
                  <?php
                    if(isset($_SESSION['erreur'])){
                        echo "<span id='vide' style='font-weight:bold'>".$_SESSION['erreur']."</span>";
                        unset($_SESSION['erreur']);
                    }
                  ?>
                  <script>
                    function validerFormulaire() {
                            let password = document.getElementById("psw").value;
                            let test = true;  
                            let regex_password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{10,}$/;
                            if (!regex_password.test(password)) {
                                document.getElementById("errnom").innerHTML = "mot de passe invalide (lettres et chiffre,10 caractère minimum).";
                                test = false;
                            }
                             return test;
                         }
                    </script>
                 <div> <input type='submit' name='confirmer' value='Confirmer'style="background-color:rgb(122,14,14);color:white;margin-top:40px;margin-left:20px;"></div>
               </fieldset>
              </form>
</body>
</html>