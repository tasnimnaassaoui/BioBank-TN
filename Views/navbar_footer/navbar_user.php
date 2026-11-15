
  <nav class="navbar bg-body-tertiary bg-dark fixed-top" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php 
                                                 if($_SESSION['type']==="Admin")
                                                    echo "/BioBank/Views/admin.php";
                                                  elseif($_SESSION['type']==="Donneur")
                                                    echo "/BioBank/donneur.php";
                                                  elseif($_SESSION['type']==="Centre")
                                                    echo "/BioBank/Views/centre.php";
                                                ?>">BioBank | <?php echo $_SESSION['type']?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                   <h5 class="offcanvas-title" id="offcanvasNavbarLabel">BioBank | <?php echo $_SESSION['type']?></h5>
                   <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                       <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="/BioBank/Views/acceuil.php">Page d'acceuil </a>
                       </li>
                       <?php
                       if($_SESSION['type']==="Admin"){
                             echo '<li class="nav-item">
                                     <a class="nav-link active" aria-current="page" href="admin.php">Tableau de bord </a>
                                    </li>
                                 <li class="nav-item">
                                 <a class="nav-link active" aria-current="page" href="../Controllers/change_admin.php">Gestion des administrateurs </a>
                                  </li>';
                       }else{
                         echo '<li class="nav-item">
                                     <a class="nav-link active" aria-current="page" href="';
                                     if($_SESSION["type"]==="Centre")
                                        echo '/BioBank/modif_infos_centre.php">Gestion des informations personnelles </a>
                                        </li>';
                                      else{
                                        echo 'modif_infos_donneur.php">Gestion des informations personnelles </a>
                                        </li>';
                                      }
                        }
                        ?>
                       <li class="nav-item">
                            <form method="POST" action="/BioBank/Controllers/logout.php" >
                                <button type="submit" name="logout" class="nav-link" style="color:red">
                                   <i class="bi bi-arrow-bar-right"></i>Se déconnecter
                                </button>
                            </form>
                       </li>
                    </ul>
                </div>
           </div>
         </div>
       </nav>