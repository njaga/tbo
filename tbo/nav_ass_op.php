<?php
include 'connexion.php';
$reponse = $db->query("SELECT COUNT(sollicitation.id) FROM `sollicitation` WHERE sollicitation.etat=2 AND sollicitation.id_commercial=" . $_SESSION['id_vigilus_user']);
$donnees = $reponse->fetch();
$nbr_en_cour = $donnees['0'];

$reponse = $db->query("SELECT COUNT(sollicitation.id)
FROM `sollicitation`
WHERE sollicitation.etat=1 AND sollicitation.id_commercial=" . $_SESSION['id_vigilus_user']);
$donnees = $reponse->fetch();
$nbr_en_att = $donnees['0'];

?>
<!--Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar blue darken-4 mb-5">
        <a class="navbar-brand" href="accueil.php"><b>TBO</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
                <!--
              <li class="nav-item active">
                <a class="nav-link" href="#">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tâches
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="e_tache.php">Enregistrer</a>
                        <a class="dropdown-item" href="l_taches.php">Liste tâches</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Prospects
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="">Ajouter</a>
                    </div>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="e_prospect.php">Enregistrer</a>
                        <a class="dropdown-item" href="l_prospect.php">Liste prospects</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clients(s)
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="e_client.php">Enregistrer</a>
                        <a class="dropdown-item" href="l_client.php">Liste clients</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sollicitation(s) <span class="badge bg-danger ms-5"> <?= $nbr_en_cour ?></span>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="sollicitation.php">Enregistrer</a>
                        <a class="dropdown-item" href="l_sollicitation_cours.php">En cours <span class="badge bg-danger ms-5"> <?= $nbr_en_cour ?></span></a>
                        <a class="dropdown-item" href="l_sollicitation_close.php">Terminé</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rapport(s)
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="rapport_mensuel.php">Rapport</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"> <?= $_SESSION['nom_vigilus_user'] ?></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="deconnexion.php">Déconnexion</a>
                        <a class="dropdown-item" href="m_pwd.php?id=<?= $_SESSION['id_vigilus_user'] ?>">Modifier mot de
                            passe</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--/.Navbar -->
<style type="text/css">
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }

    .dropdown-item:hover {
        background-color: #0d47a1 !important;
    }
</style>