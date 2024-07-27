<?php
session_start();
if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include 'connexion.php';
$id = intval($_GET['id']);
$req_client = $db->query("SELECT id, client, secteur_activite, contact, telephone, email, adresse FROM `client` WHERE etat=1");

$req_departement = $db->query("SELECT `id`, `nom` FROM `departement` WHERE etat=1");

$req_sollicitation = $db->query("SELECT `type`, `id_client`, `date_reception`, `num_dossier`, `date_limit`, `departement`, `details_ao` FROM `sollicitation` WHERE id=" . $id);
$donnees_sollicitation = $req_sollicitation->fetch();
$type = $donnees_sollicitation['0'];
$id_client = $donnees_sollicitation['1'];
$date_reception = $donnees_sollicitation['2'];
$num_dossier = $donnees_sollicitation['3'];
$date_limit = $donnees_sollicitation['4'];
$departement = $donnees_sollicitation['5'];
$details_ao = $donnees_sollicitation['6'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouvelle sollicitation</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>ddf.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <main class="container-fluid">

        <div class="row">
            <!-- Section: add employe -->
            <section class="mb-5 col-6 offset-md-3">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Modification Sollicitation </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="sollicitation_trmnt.php" enctype="multipart/form-data" id="form">
                            <input type="number" value="<?= $id ?>" hidden name="id">
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="date" value="<?= $date_reception ?>" id="date_reception" name="date_reception" class="form-control" required>
                                        <label for="date_reception" class="active">Date réception</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-10 ">
                                    <select class="mdb-select md-form" name="client" id="client" searchable="Recherhce du client .." required>
                                        <option value='' disabled selected>Client</option>
                                        <?php
                                        while ($donnees_client = $req_client->fetch()) {
                                            echo "<option value='" . $donnees_client['0'] . "'  ";
                                            if ($id_client == $donnees_client['0']) {
                                                echo "selected";
                                            }
                                            echo ">" . $donnees_client['1'] . "  </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 ">
                                    <select class="browser-default custom-select md-form" name="type_tache" id="type_tache" required>
                                        <option value='' disabled>Type </option>
                                        <option value="Avis d'appel d'offre" <?php if ($type == "Avis d'appel d'offre") {
                                                                                    echo "selected";
                                                                                } ?>>Avis d'Appel d'offre</option>
                                        <option value="Avis à manifestation d'interêt" <?php if ($type == "Avis à manifestation d'interêt") {
                                                                                            echo "selected";
                                                                                        } ?>>Avis à manifestation d'interêt</option>
                                        <option value="Avis générale de passation des marchés" <?php if ($type == "Avis générale de passation des marchés") {
                                                                                                    echo "selected";
                                                                                                } ?>>Avis générale de passation des marchés</option>
                                        <option value="Avis Spécifique de passation des marchés" <?php if ($type == "Avis Spécifique de passation des marchés") {
                                                                                                        echo "selected";
                                                                                                    } ?>>Avis Spécifique de passation des marchés</option>
                                        <option value="Demande de renseignement de prix à compétition ouverte" <?php if ($type == "Demande de renseignement de prix à compétition ouverte") {
                                                                                                                    echo "selected";
                                                                                                                } ?>>Demande de renseignement de prix à compétition ouverte</option>
                                    </select>
                                </div>
                                <div class="col-md-7 ">
                                    <select class="mdb-select colorful-select dropdown-primary md-form" multiple name="departement[]" id="departement" required>
                                        <option value='' disabled selected>Département</option>

                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['1'] . "'";
                                            echo ">" . $donnees_departement['1'] . "  </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="text" id="num_dossier" <?= $num_dossier ?> name="num_dossier" class="form-control">
                                        <label for="num_dossier" class="active">N° Dossier</label>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="date" value="<?= $date_limit ?>" id="date_limite" name="date_limite" class="form-control">
                                        <label for="date_limite" class="active">Date limite</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos  -->
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="details_ao"></label>
                                    <textarea class="form-control z-depth-1" id="details_ao" name="details_ao" rows="3" placeholder="Commentaire"><?= $details_ao ?></textarea>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="pj" accept="application/pdf" class="custom-file-input" id="pj" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="pj">PJ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <input type="submit" value="Enregistrer" class="btn blue-gradient">
                            </div>
                        </form>
                    </div>
                    <!-- Card content -->

                </div>
                <!-- Card -->

            </section>
            <!-- Section: Horizontal stepper -->




        </div>
    </main>
    <span id="fin"></span>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
            $('.datepicker').pickadate({
                // Escape any “rule” characters with an exclamation mark (!).
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy/mm/dd',
                hiddenPrefix: 'prefix__',
                hiddenSuffix: '__suffix'
            });
            //fonction pour les types
            function type_taches() {
                var type_tache = $('#type_tache').val();
                if (type_tache == "Devis") {
                    $('.devis').removeClass('d-none');
                } else {
                    $('.devis').addClass('d-none');
                }
            }
            $('#type_tache').change(function() {
                type_taches();
            });
            $('#form').submit(function() {
                if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
                    return false;
                }
            });
            <?php
            if (isset($_GET['a'])) {
            ?>
                $('.toast').toast('show')
            <?php
            }
            ?>
        });
    </script>
</body>
<style type="text/css">

</style>

</html>