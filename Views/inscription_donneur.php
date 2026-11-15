<?php
   session_start();
?>
<!DOCTYPE html>
<html >
    <head>
       <link rel="stylesheet" href="../css/inscription.css">
       <link rel="stylesheet" href="../css/acceuil.css">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
       <meta charset="UTF-8">
       <title>S'inscrire comme donneur</title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php
            require "navbar_footer/navbar.php";
        ?>
        <section class="inscription">
            <?php
               if(isset($_SESSION['erreur_creation'])){
                echo "<p style='width:900px;font-size:25px;padding:20px;color:blue'>".$_SESSION['erreur_creation']."</p>";
                unset($_SESSION['erreur_creation']);
               }
            ?>
           <form action="../Controllers/ValideCompteDonneur.php" method="post" name="form" onsubmit="return validerFormulaire()">
            <section class ="champ">
               <fieldset>
                    <legend >Identité</legend>
                    <label>Nom  </label>
                    <input type="text" name="nom" id="n">
                    <label>Prénom </label>
                    <input type="text" name="prenom" id="p">
                    <span id="errnom" style="color: red; font-size: 12px;"></span><br>
                    <label>date de naissance </label>
                    <input type="date" name="date" id="date">
                    <label> num carte de identité</label>
                    <input type="number" name="cin" id="cin">
                    <span id="errcin" style="color: red; font-size: 12px;"></span>
               </fieldset>
               <fieldset>
                    <legend>Information médicale</legend>
                    <label>Poids</label>
                    <input type="number" name="poids" id="poids">
                    <label>Groupe sanguin</label>
                    <select name="sang">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                    <label>Rhésus</label>
                    <select name="rhesus">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                    <label>Avez-vous des maladies chroniques ?</label>
                    <div>
                        <label><input type="radio" name="maladi" value="oui" onclick="Affichertext()"> Oui</label>
                        <label><input type="radio" name="maladi" value="non" onclick="Cachertext()" checked> Non</label>
                    </div>
                    <div id="maladie" style="display:none;">
                        <label>Nom de la maladie</label>
                        <input type="text" id="malad" name="nomMaladi" placeholder="Précisez ici...">
                        <span id="errmaladie" style="color: red; font-size: 12px;"></span>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Contact</legend>
                    <label> Téléphone</label>
                    <input type="text" name="contact" class="form-control" placeholder="email ou téléphone">
                    <span id="errtel" style="color: red; font-size: 12px;"></span><br>
                    <label>Ville / Gouvernorat</label>
                    <select name="Gouvernorats" id="Gouvernorats">
                        <option value="tunis">Tunis</option>
                        <option value="ariana">Ariana</option>
                        <option value="ben_arous">Ben Arous</option>
                        <option value="bizerte">Bizerte</option>
                        <option value="gabes">Gabès</option>
                        <option value="gafsa">Gafsa</option>
                        <option value="jendouba">Jendouba</option>
                        <option value="kairouan">Kairouan</option>
                        <option value="kasserine">Kasserine</option>
                        <option value="kebili">Kébili</option>
                        <option value="manouba">Manouba</option>
                        <option value="le_kef">Le Kef</option>
                        <option value="mahdia">Mahdia</option>
                        <option value="medenine">Médenine</option>
                        <option value="monastir">Monastir</option>
                        <option value="nabeul">Nabeul</option>
                        <option value="sfax">Sfax</option>
                        <option value="sidi_bouzid">Sidi Bouzid</option>
                        <option value="siliana">Siliana</option>
                        <option value="sousse">Sousse</option>
                        <option value="tataouine">Tataouine</option>
                        <option value="tozeur">Tozeur</option>
                        <option value="zaghouan">Zaghouan</option>
                        <option value="zarzis">Zarzis</option>
                    </select>
               </fieldset>
               <div class="champ">Historique</div>
                   <fieldset>
                        <label>Avez-vous déjà effectué un don de sang ?</label>
                        <div>
                            <label><input type="radio" name="deja_donne" value="oui" onclick="AfficherDate()"> Oui</label>
                            <label><input type="radio" name="deja_donne" value="non" onclick="CacherDate()" checked> Non</label>
                        </div>
                        <div id="bloc_date" style="display:none;">
                            <label>Dernier don effectué</label>
                            <input type="date" name="datedon" id="dat">
                        </div>
                   </fieldset>
                   <script>
                        function AfficherDate() {
                            document.getElementById("bloc_date").style.display = "block";
                        }
                        function CacherDate() {
                            document.getElementById("bloc_date").style.display = "none";
                        }
                        function Affichertext() {
                            document.getElementById("maladie").style.display = "block";
                        }
                        function Cachertext() {
                            document.getElementById("maladie").style.display = "none";
                        }
                        window.onload = function() {
                            let s = sessionStorage.getItem("Suc");
                            if (s) {
                                document.getElementById("succes").innerHTML = s;
                                sessionStorage.removeItem("Suc");
                            }
                        }
                        function validerFormulaire() {
                            let nom = document.getElementById("n").value;
                             let prenom = document.getElementById("p").value;
                            let tel = document.getElementById("contact").value;
                            let cin = document.getElementById("cin").value;
                            let nommal = document.getElementById("malad").value;
                            let test = true;
                            let chaine = /^[A-Za-zÀ-ÿ\s\-]+$/; 
                            let chiffre=/^[0-9]+$/;
                            let symbolesInterdits = /[^a-zA-Z0-9\s\-éèàîïôûù]/; 
                            if ((!(chaine.test(nom)) && nom!="") || (!(chaine.test(prenom)) && prenom!="")) {
                                document.getElementById("errnom").innerHTML = "Nom invalide (lettres uniquement).";
                                test = false;
                            }
                                if (symbolesInterdits.test(nommal) && nommal!="") {
                                        document.getElementById("errmaladie").innerHTML = "Symboles interdits dans le nom de la maladie.";
                                    test = false;
                                }
                                if (tel!="" && (!(chiffre.test(tel)) || tel.length != 8)) {
                                    document.getElementById("errtel").innerHTML = "Ce champ doit contenir 8 chiffres.";
                                    test = false;
                                }
                                if (cin!="" &&cin.length != 8) {
                                    document.getElementById("errcin").innerHTML = "Ce champ doit contenir 8 chiffres.";
                                    test = false;
                                }
                             return test;
                         }
                    </script>
                    <?php
                      if(isset($_SESSION['erreur'])){
                         echo "<span id='vide'>".$_SESSION['erreur']."</span>";
                         unset($_SESSION['erreur']);
                        } 
                    ?>
                    <input type="submit" value="Valider l'inscription" id="v" name="inscri">
                </form> 
                
            </section>
    </body>
    <?php
       require "navbar_footer/footer.php";
    ?>
</html>
        
