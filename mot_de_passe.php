<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Centre</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../css/inscription.css" rel="stylesheet">
    <link href="../../css/acceuil.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require "../Views/navbar_footer/navbar.php";?>
        <!--terminer l  inscription on demandant un mot de passe-->
          <form method='POST' action='#' onsubmit='return validerFormulaire()'>
                  <label>Mot de passe</label>
                  <input type='password' name='password' id="psw">
                  <span id="errnom"></span>
                  <label>Confirmer le mot de passe</label>
                  <input type='password' name='confpassword' >
                  <?php
                    if(isset($_SESSION['erreur'])){
                        echo "<span id='vide'>".$_SESSION['erreur']."</span>";
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
                  <input type='submit' name='confirmer' value='Confirmer'>
              </form>
</body>
</html>