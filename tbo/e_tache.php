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
$req_client = $db->query("SELECT id, client, secteur_activite, contact, telephone, email, adresse FROM `client` WHERE etat=1");

$req_departement = $db->query("SELECT `id`, `nom` FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouvelle tâche</title>
    <?php include 'css.php'; ?>
</head>

<body>
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
                        <h4 class="mb-0"><b> Nouvelle tâche </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_tache_trmnt.php" enctype="multipart/form-data" id="form">
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="date" value="<?= date('Y') . '-' . date('m') . '-' . date('d') ?>" id="date_tache" name="date_tache" class="form-control">
                                        <label for="date_tache" class="active">Date tâche</label>
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
                                            echo "<option value='" . $donnees_client['0'] . "'  >" . $donnees_client['1'] . "  </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <select class="browser-default custom-select md-form" name="type_tache" id="type_tache" required>
                                        <option value='' disabled selected>Type tâche</option>
                                        <option value="Appel d'offre">Appel d'offre</option>
                                        <option value="Call">Call</option>
                                        <option value="Devis">Devis</option>
                                        <option value="Email">Email</option>
                                        <option value="Prospection">Prospection</option>
                                        <option value="RDV Client">RDV Client</option>
                                        <option value="Relance">Relance</option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <select class="browser-default custom-select md-form" name="departement" id="departement" required>
                                        <option value='' disabled selected>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['1'] . "'  >" . $donnees_departement['1'] . "  </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-none devis">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="text" id="num_devis" name="num_devis" class="form-control">
                                        <label for="num_devis" class="active">N° Devis</label>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="number" id="montant" name="montant" class="form-control">
                                        <label for="montant" class="active">Montant Devis</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos  -->
                            <div class="row">
                                <div class="col-md-10 ">
                                    <div class="md-form">
                                        <input type="text" id="commentaire" name="commentaire" required class="form-control">
                                        <label for="commentaire" class="active">Commentaire</label>
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