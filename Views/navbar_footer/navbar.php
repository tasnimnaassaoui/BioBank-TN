<?php
  echo
    '<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand " href="/BioBank/Views/acceuil.php"><img src="../image/logo.png" alt="BioBank TN" ></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                   <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a class="nav-link active fs-5 ms-3" aria-current="page" href="/BioBank/Views/Connexion.php">Connexion</a>
                      </li>
                      <li class="nav-item ">
                          <a class="nav-link fs-5 ms-3" href="/BioBank/Views/inscription_donneur.php">Devenir donneur</a>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown" >
                              Infos Don de sang
                          </a>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="/BioBank/Views/info_cond.php">Importance & Condition</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="/BioBank/Views/question.php">Poser une question</a></li>
                          </ul>
                      </li>
                  </ul>
               </div>
           </div>
       </nav>';
?>