<?php
   session_start();
    require "../Controllers/affichage_table_question.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/acceuil.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <title>Question & Rèponse</title>
        <style>
          .nav-link:hover{
            color:rgb(255, 214, 214)!important;
          }p{
            position:relative;
            margin-left:10px;
            font-size:18px;
          }
          @media(max-width:980px){
            p{
                font-size: 35px;
                margin-left:0px;
            }footer>p{
                font-size:29px;
            }button{
                font-size:32px;
            }
          }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <!--barre-->
        <?php
           require "navbar_footer/navbar.php";
        ?>
        <!--formulaire pour envoyer les questions-->
        <div class="container flex-fill">
            <p style="">Notre équipe est à votre écoute. Posez vos questions et nous vous répondrons dans les plus brefs délais.</p>
            <form class="row g-2" style="margin-top:85px; margin-left:10px;width:700px" method="POST" action="../Controllers/envoi_question.php">
               <div class="col-auto">
                    <textarea  class="form-control " style="width:450px;height:100px" id="inputtext" name="qst" placeholder="Puis-je donner du sang si je prends un médicament ?..."></textarea>
               </div>
               <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3" style="width:200px" name="envoyer">Envoyer</button>
               </div>
               <?php
              if(isset($_SESSION['msg1'])){
                   echo '<p style="color:green;font-size:17px">'.$_SESSION['msg1'].'</p>';
                   unset($_SESSION['msg1']);
                }
                if(isset($_SESSION['msg2'])){
                   echo '<p style="color:red;font-size:17px">'.$_SESSION['msg2'].'</p>';
                   unset($_SESSION['msg2']);
                }
            ?>
           </form>
           <!--un message est affiché si le formulaire est envoyé (erreur ou succés)-->
           
       </div>
       <!--Affichage des questions avec réponses-->
        <div class="accordion" id="accordionExample" style="margin-top:70px;margin-bottom:70px;margin-left:50px;width:800px">
            <?php while($question=$questions->fetch(PDO::FETCH_ASSOC)):?>
                <div class="accordion-item">
                   <h2 class="accordion-header">
                        <button class="accordion-button" type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse<?php echo $question['id_QR'];?>" 
                                        aria-expanded="true" 
                                        aria-controls="collapse<?php echo $question['id_QR'];?>">
                                  <?php echo $question['question'];?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $question['id_QR'];?>" 
                        class="accordion-collapse collapse " 
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php echo $question['reponse'];?>
                        </div>
                   </div>
                </div>
            <?php endwhile;?>
        </div>
        <?php
          require "navbar_footer/footer.php";
       ?>
    </body>

    
</html>