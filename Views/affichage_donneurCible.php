<?php
   require "../Controllers/filtre_donneur.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <link href="../css/admin.css" rel="stylesheet">
    <script>
      document.getElementById("msg").style.display="none";
    </script>
</head>
<body class="d-flex flex-column min-vh-100">
   <?php
       require "navbar_footer/navbar_user.php";
    ?>
       <?php if(isset($_SESSION['message'])):?>
            <h5  id="error" style="display:block; color:rgb(211, 187, 187);margin-top:150px;margin-left:450px">
                 <?php echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
            </h5>
       <?php else:?>
       <p id='nb_total'>Nombre de donneurs trouvés :  <?php echo Count($donneurs);?></p>
       <br><input type='checkbox' id='select_all' ><span>Envoyer à tous</span> 
                 <form method='POST' action='../Controllers/envoi_alertes.php' style='display:inline-block'>
                   <div style='display:flex; gap:20px; align-items:flex-start;'>
                   <div>  
                     <table class='table table-striped' style='width:800px;margin-top:10px;margin-left:10px;display:block' id='donneur_cible'>
                        <thead>
                            <tr style='height:50px'>
                               <th scope='col' >Nom & Prénom</th>
                               <th scope='col' >Télèphone</th>
                               <th scope='col' >gouvernorat</th>
                               <th scope='col' >Groupe Sanguin & Rhésus</th>
                               <th scope='col' >Dernier don</th>
                               <th scope='col' >Actions</th>
                            </tr>
                        </thead>
                        <tbody class='table-group-divider'>
                            <?php foreach($donneurs as $donneur):?>
                                <tr style="height:10px">
                                   <td ><?php echo $donneur['nom'].' '.$donneur['prenom'];?></td>
                                   <td ><?php echo $donneur['telephone'];?></td>
                                   <td ><?php echo $donneur['gov'];?></td>
                                   <td ><?php echo $donneur['groupe_sanguin_rhesus'];?></td>
                                   <td ><?php echo $donneur['dernier_don'];?></td>
                                   <td >
                                          <input type="checkbox" class="check" name="select[]" value="<?php echo  $donneur['id_user'];?>" >
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
               </div>
               <div>
                    <button type='submit' class='btn btn-outline-danger rounded' ><i class='bi bi-bell-fill'></i> Envoye l'alerte</button>
                    <div style='margin-top:10px'>
                        <label for='exampleFormControlInput1' class='form-label'>ID de l'alerte <span style='color:red'>*</span></label>
                        <input type='number' class='form-control' name='idAlerte' placeholder='Identifiant' style='width:200px;'>
                        <?php if(isset($_SESSION['error'])):?>
                            <h6 style='color:red;'><?php echo $_SESSION['error'];?></h6>
                            <?php unset($_SESSION['error']);?>
                        <?php endif;?>
                    </div>
               </div>
            </form>
                <?php 
                if(isset($_SESSION['notif'])){
                    echo "<script>
                         alert('".$_SESSION['notif']."')
                    </script>"; 
                    unset($_SESSION['notif']);
                }
                ?>
        <?php endif;?>
<!-- ce script permet de sélectionner tout les donneurs filtrés suite à la sélection du champ d'id 'select_all'-->
<script>
    document.getElementById('select_all').addEventListener('change', function() {
        let CH=document.getElementsByClassName('check');
        for(let i=0;i<CH.length;i++ )
        CH[i].checked=this.checked;
    });                    
</script>
</body>

</html>