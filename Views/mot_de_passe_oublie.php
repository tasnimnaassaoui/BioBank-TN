<?php
  session_start();
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
    <link href="../css/connexion.css" rel="stylesheet">
    
    <script>
           //afficher le mot de passe
            function change(){
                if(document.getElementById("check").checked){
                    document.getElementById("nv_psw").type="text";
                    document.getElementById("conf_psw").type="text";
                }else{
                    document.getElementById("nv_psw").type="password";
                    document.getElementById("conf_psw").type="password";
                }
            }
   </script>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require "navbar_footer/navbar.php";?>
    <div class="réinitial">
                <h5 style="margin-left:20px">Le code de sécurité a été validé avec succès.</h5>
                <h6 style="margin-top:30px;margin-left:420px;">Veuillez maintenant saisir un nouveau mot de passe.</p>
                <form method="POST" action="../Controllers/valider_motDePasse.php" >
                    <fieldset style="border:solid 5px rgb(129, 40, 40);width:430px;height:370px;border-radius:10px">
                    <legend><img src="../image/log5.jpg" style="width:40px;height:40px ;border-radius:3px;"></legend>
                    <div><input type="password" name="nv_psw" placeholder="Nouveau mot de passe" id="nv_psw" style="margin-left:20px;"></div>
                    <div><input type="password" name="conf_psw" placeholder="Confirmez votre nouveau mot de passe" id="conf_psw" style="margin-left:20px;"></div>
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user'];?>">
                    <input type="checkbox" id="check" onclick="change()" style="width:15px"><span>afficher le mot de passe</span>
                    <?php
                    if(isset($_SESSION['message'])){
                        echo "<h6 style='color:red;'>".$_SESSION['message']."</h6>";
                        unset($_SESSION['message']);
                    }
                    ?>
                    <div><button type="submit" name="modif" style="background-color:rgb(122,14,14);color:white;margin-top:40px;margin-left:20px;">
                        Enregistrer
                    </button></div>
                </fieldset>
                </form>
                </div>
            <?php
               if(isset($_SESSION['erreur'])){
                  echo $_SESSION['erreur'];
                  unset($_SESSION['erreur']);
                } 
            ?>
            <?php
               require "navbar_footer/footer.php";
            ?>
   </body>

</html>