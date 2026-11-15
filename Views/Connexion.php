<?php
   session_start();
   require "../Models/fonctions.php";
   $conn=connexion();
   modif_statut($conn);
   /*si un utilisateurs est déjà  connecté: affichage de son page-->*/
    if(isset($_SESSION['id_user']) && isset($_SESSION['type'])){
        if($_SESSION['type']==="Admin")
            header("Location:admin.php");
        elseif($_SESSION['type']==="Donneur")
            header("Location:../donneur.php");
        elseif($_SESSION['type']=="Centre")
            header("Location:centre.php");
        exit;
    }
    /*une alerte s'affiche si l'administrateur a quitté l'administration*/
    if(isset($_SESSION['alert'])){
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/acceuil.css" rel="stylesheet">
        <link href="../css/connexion.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //ouverture formulaire pou entrer le code de sécurité(réinitialisation de password)
            function ouvrir(){
                const myModal = new bootstrap.Modal(document.getElementById('popup'));
                myModal.show();
            }//fermeture le formulaire
            function fermer(){
                document.getElementById("popup").style.display="none";
            }
        </script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        
        <!--barre-->
        <?php
           require "navbar_footer/navbar.php";
        ?>
        <!--aucun utilisateur est connecté :affichage de formulaire de login-->
        <div class="flex-fill" id="login">
           <div class="main" >
                   <div class="infos" >
                       <h3 id="vue">VUE D'ENSEMBLE</h3>
                       <h4>Ce que le donneur retrouve après connexion</h4>
                       <table>
                           <tr class="mini_case">
                              <td><span>Demandes actives</span><br>Alertes urgentes visibles rapidement.</td>
                              <td><span>Centres proches</span><br> Orientation vers le bon lieu de don.</td>
                              <td><span>Historique</span><br>Suivi clair des actions du donneur.</td>
                          </tr>
                       </table>
                   </div>
                   <div class="formulaire" style="justify-items:center">
                       <h1 >Sign In</h1>
                       <form method="post" action="../Controllers/login.php" class="form1">
                           <div><input type="text" placeholder="numéro de mobile" name="tel"></div>
                           <div><input type="password" placeholder="mot de passe" name="psw"></div>
                           <?php
                              if(isset($_SESSION['error'])){
                                echo "<h6 style='color:red;'>".$_SESSION['error']."</h6>";
                                unset($_SESSION['error']);
                              }
                            ?>
                           <button type="submit" name="envoie" id="envoie">Se connecter</button>
                       </form>
                       <button type="button" name="psw" id="psw" onclick="ouvrir()">Mot de passe oublié ?</button>
                       <a href="inscription_donneur.php">Créer un nouveau compte</a>
                   </div>
           </div>
        </div>
        <!--si le mot de passe est oublié-->
        <div class="modal" tabindex="-1" id="popup" >
            <div class="modal-dialog">
               <div class="modal-content" >
                    <form method="POST" action="../Controllers/Verifier_codeSecurite.php">
                        <div class="modal-header" >
                           <h5 class="modal-title">Veuillez saisir votre code de sécurité fourni lors de votre inscription</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height:150px;">
                           <input type="password" placeholder="Tapez votre code" name="code">
                           <?php
                              if(isset($_SESSION['erreur'])){
                                echo'
                                   <script>
                                      const myModal = new bootstrap.Modal(document.getElementById("popup"));
                                       myModal.show();
                                   </script>';
                                echo "<h6 style='color:red;'>".$_SESSION['erreur']."</h6>";
                                unset($_SESSION['erreur']);
                              }
                            ?>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                           <button type="submit" class="btn btn-primary" name="envoyer">Ok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        require "navbar_footer/footer.php";
        ?>
   </body>
</html>