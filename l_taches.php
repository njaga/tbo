<?php
session_start();
include 'connexion.php';


$req_annee = $db->query("SELECT DISTINCT YEAR(date_tache) 
FROM `tache` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des tâches</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="e_tache.php" class="btn col-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des tâches</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select" name="anne_academique" required="">
                                    <option selected>Année </option>
                                    <?php
                                    while ($donnees_annee = $req_annee->fetch()) {
                                        echo "<option value='" . $donnees_annee['0'] . "'";
                                        if ($donnees_annee['0'] == $annee_actuelle) {
                                            echo "selected";
                                        }
                                        echo ">" . $donnees_annee['0'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 ">
                                <select class="browser-default custom-select" name="mois" required="">
                                    <option selected>Sélectionnez le mois </option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo "<option value='$i'";
                                        if ($mois[$i] == $mois_actuel) {
                                            echo "selected";
                                        }
                                        echo ">$mois[$i]</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-6 col-md-3 ">
                                <select class="browser-default custom-select" name="type_tache" required="">
                                    <option value='toutes' selected>Toutes les tâches</option>
                                    <option value="Appel d'offre">Appel d'offre</option>
                                    <option value="Call">Call</option>
                                    <option value="Devis">Devis</option>
                                    <option value="Email">Email</option>
                                    <option value="Prospection">Prospection</option>
                                    <option value="RDV Client">RDV Client</option>
                                    <option value="Relance">Relance</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " id="">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date </td>
                                    <td class="white-text">Client / Prospect</td>
                                    <td class="white-text">Tâche</td>
                                    <td class="white-text">Commentaire</td>
                                    <td class="white-text">Etat</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
                    </div>
                    <!-- Card content -->

                </div>
            </div>
            <!-- Card -->

        </section>
        <!-- Section -->
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

</body>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        function l_abs_remp(search) {
            var type_tache = $('select:eq(2)').val();
            var mois = $('select:eq(1)').val();
            var annee = $('select:eq(0)').val();
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_taches_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee + '&search=' + search + '&type_tache=' + type_tache,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        l_abs_remp();
        $('select').change(function() {
            l_abs_remp();
        });
        $('input:first').keyup(function() {
            l_abs_remp()
        });
    })
</script>

</html>