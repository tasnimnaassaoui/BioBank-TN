<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard_Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="../css/admin.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <style>
    body { font-family: 'Segoe UI', , sans-serif;background-color:white; display: flex;justify-content: center;align-items: center; ; margin: 0;
        box-sizing: border-box;}
    form[name="modcentre"] {background:white;padding: 30px;border-radius: 24px;box-shadow: 0 10px 25px black;margin-top:70px;max-width: 900px;}
    form>div{margin-bottom:10px;border-radius:5px;border:solid 1px rgb(205, 210, 216);padding:7px}
    h3 { margin: 0 0 10px 0; font-size: 22px; color: black; }
    p { color: #64748b; font-size: 14px; margin-bottom: 25px; }
    label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #334155; }
    input[type="text"],input[type="number"] {width:80%;padding: 12px 16px;border: 2px solid #f1f5f9;border-radius: 12px;background-color: #f8fafc;
        font-size: 15px;transition: all 0.3s ease;outline: none;}
    input:focus {border-color: #ff5252;background-color: #fff;}
    input[type="submit"] {width: 100%;background-color: #f75151;color: white;border: none; padding: 14px;border-radius: 12px;font-size: 16px;font-weight: 600;
        cursor: pointer;transition: background 0.3s;}
    input[type="submit"]:hover { background-color: #e04545; }
</style>
    <body class="d-flex flex-column min-vh-100"  >
        <?php require "navbar_footer/navbar_user.php";?>
      <form action="../Controllers/changerInfosAdmin.php" method="post" name="modcentre">
        <h3> Modification des informations personnelles.</h3>
        <div>
            Nom <input type="text" name="nomAdmin">
        </div>
           <div>
            Prénom <input type="text" name="prenomAdmin">
            </div>
        <div>
            <h4><i class="bi bi-lock"></i> Informations de connexion</h4>
            <div>
                Télèphone <input type="text" name="telAdmin">
            </div>
            <div>
                Mot de passe <input type="text" name="psw">
            </div>
        </div>
        <?php
             if(isset($_SESSION['error'])){
                    echo "<h6 style='color:red;'>".$_SESSION['error']."</h6>";
                     unset($_SESSION['error']);
                }
        ?>
        <input type="submit" value="Modifier" name="modifierInfos">
    </form>
       <footer style="text-align:center; padding:10px; background:#f5f5f5; margin-top:20px;width:100%"">
            <p>BioBank Admin Panel © 2026</p>
       </footer>
    </body>
      
</html>