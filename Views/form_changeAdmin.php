<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100" >
        <!--partie nav de l'admin-->
        <?php require "navbar_footer/navbar_user.php";?>
        <form method="POST" action="" style="display:inline;margin-top:80px;margin-left:340px;">
            <button type="submit" name="quitter_admin" class="btn btn-warning btn-sm" style="font-weight:bold;font-size:20px;width:70%">
                Quitter l’administration
           </button>
           <?php 
           if(isset($_SESSION['erreur'])){
                echo "<p style='width:400px;color:red;font-size:16px;margin-left:10px'>".$_SESSION['erreur']."</p>";
                unset($_SESSION['erreur']);
           }
           ?>
        </form>
        <!--formulaire pour ajouter administrateur-->
        <form style="margin-top:10px;justify-items:center" method="POST" action="">
            <h3> Ajouter un administrateur</h3>
            <div class="mb-3">
                <label for="exampleInputNom" class="form-label">Nom </label>
                <input type="text" class="form-control" id="exampleInputText1" aria-describedby="TextHelp" name="nom">

                <label for="exampleInputprenom" class="form-label">Prenom</label>
                <input type="text" class="form-control" id="exampleInputText2" aria-describedby="TextHelp" name="prenom">

                <label for="exampleInputTel" class="form-label">Numéro de télèphone</label>
                <input type="text" class="form-control" id="exampleInputText3" aria-describedby="TextHelp" name="tel">

                <label for="exampleInputPSW" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="exampleInputText4" aria-describedby="TextHelp" name="psw">
                <label for="exampleInputPSW" class="form-label">Confirmer</label>
                <input type="password" class="form-control" id="exampleInputText4" aria-describedby="TextHelp" name="psw1">
                <div id="emailHelp" class="form-text">Cet utilisateur recevra les droits d'administration complets.</div>
                
            </div>
            <?php
                if(isset($_SESSION['message'])){
                   echo "<div><p style='width:400px;color:red;font-size:16px;margin-left:10px'>".$_SESSION['message']."</div></p>";
                   unset($_SESSION['message']);
                }
            ?>
            <div>
                <button type="submit" class="btn btn-danger" name="submit" style="margin-top:30px">Nommer administrateur</button>
            </div>
        </form>
        
        <footer style="text-align:center; padding:10px; background:#f5f5f5; margin-top:20px;">
            <p>BioBank Admin Panel © 2026</p>
        </footer>
    </body>
    
</html>