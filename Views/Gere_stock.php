<?php 
  session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/centre.css" rel="stylesheet">
</head>
<style>
    body { font-family: 'Segoe UI', sans-serif;
     background-color:rgb(224, 224, 224);margin: 0;display: flex;justify-content: center;align-items: center;}
    </style>
</head>
<body>
<?php require "navbar_footer/navbar_user.php";?>
<div class="container">
    <h3>Stocks : Centre National de Transfusion</h3>
    <p>Mettre à jour les quantités par groupe sanguin (en poches).</p>
    
    <form action="../Controllers/enregistre_stock.php" method="POST" name="modification">
        <div class="stock-grid">
            <div class="stock-item">
                <label>O+</label>
                <input type="number" name="o+" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>O-</label>
                <input type="number" name="o-" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>A+</label>
                <input type="number" name="a+" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>A-</label>
                <input type="number" name="a-" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>B+</label>
                <input type="number" name="b+" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>B-</label>
                <input type="number" name="b-" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>AB+</label>
                <input type="number" name="ab+" oninput="colorerCadre(this)">
            </div>
            <div class="stock-item">
                <label>AB-</label>
                <input type="number" name="ab-" oninput="colorerCadre(this)">
            </div>
        </div>
       <?php
             if(isset($_SESSION['error'])){
                    echo "<h6 style='color:red;'>".$_SESSION['error']."</h6>";
                     unset($_SESSION['error']);
                }
        ?>
        <div class="actions">
            <input type="submit" value="Enregistrer" name="enregistrer">
        </div>
    </form>
</div>

<script>
function colorerCadre(champ) {
    let valeur = parseInt(champ.value);
    let parent = champ.parentElement;

    if (isNaN(valeur) || valeur <10) {
        parent.style.borderColor = "#ef4444";
        parent.style.backgroundColor = "#fee2e2"; 
    } else if (valeur <= 30) {
        parent.style.borderColor = "#f59e0b";
        parent.style.backgroundColor = "#fef3c7"; 
    } else {
        parent.style.borderColor = "#10b981";
        parent.style.backgroundColor = "#d1fae5"; 
    }
}
</script>

</body>
</html>

    
