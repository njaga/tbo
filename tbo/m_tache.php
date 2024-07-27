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
$id = $_GET['id'];
$req_tache = $db->prepare("SELECT id_client, type_tache, date_tache, commentaire,num_devis, montant, date_devis, date_validation  FROM `tache` WHERE id=?");
$req_tache->execute(array($id));
$donnees_taches = $req_tache->fetch();
$id_client = $donnees_taches['0'];
$type_tache = $donnees_taches['1'];
$date_tache = $donnees_taches['2'];
$commentaire = $donnees_taches['3'];
$num_devis = $donnees_taches['4'];
$montant = $donnees_taches['5'];
$date_devis = $donnees_taches['6'];
$date_validation = $donnees_taches['7'];

$req_client = $db->query("SELECT id, client, secteur_activite, contact, telephone, email, adresse FROM `client` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification tâche</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>color-2174065_1280.png);">
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
                        <h4 class="mb-0"><b> Modification tâche </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="m_tache_trmnt.php" enctype="multipart/form-data" id="form">
                            <input type="number" name="id" hidden value="<?= $id ?>">
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="date" value="<?= $date_tache ?>" id="date_tache" name="date_tache" class="form-control">
                                        <label for="date_tache" class="active">Date tâche</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-10 ">
                                    <select class="mdb-select md-form" name="client" id="client" searchable="Recherhce du client ..">
                                        <option value='' disabled>Client</option>
                                        <?php
                                        while ($donnees_client = $req_client->fetch()) {
                                            echo "<option value='" . $donnees_client['0'] . "'";
                                            if ($id_client == $donnees_client['0']) {
                                                echo "selected";
                                            }
                                            echo " >" . $donnees_client['1'] . "  </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 ">
                                    <select class="browser-default custom-select md-form" name="type_tache" id="type_tache" required>
                                        <option value='' disabled>Type tâche</option>
                                        <option value="Appel d'offre" <?php if ($type_tache == "Appel d'offre") {
                                                                            echo "selected";
                                                                        } ?>>Appel d'offre</option>
                                        <option value="Call" <?php if ($type_tache == "Call") {
                                                                    echo "selected";
                                                                } ?>>Call</option>
                                        <option value="Devis" <?php if ($type_tache == "Devis") {
                                                                    echo "selected";
                                                                } ?>>Devis</option>
                                        <option value="Email" <?php if ($type_tache == "Email") {
                                                                    echo "selected";
                                                                } ?>>Email</option>
                                        <option value="Prospection" <?php if ($type_tache == "Prospection") {
                                                                        echo "selected";
                                                                    } ?>>Prospection</option>
                                        <option value="RDV Client" <?php if ($type_tache == "RDV Client") {
                                                                        echo "selected";
                                                                    } ?>>RDV Client</option>
                                        <option value="Relance" <?php if ($type_tache == "Relance") {
                                                                    echo "selected";
                                                                } ?>>Relance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-none devis">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="text" id="num_devis" value="<?= $num_devis ?>" name="num_devis" class="form-control">
                                        <label for="num_devis" class="active">N° Devis</label>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="number" id="montant" value="<?= $montant ?>" name="montant" class="form-control">
                                        <label for="montant" class="active">Montant Devis</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos  -->
                            <div class="row">
                                <div class="col-md-10 ">
                                    <div class="md-form">
                                        <input type="text" id="commentaire" value="<?= $commentaire ?>" name="commentaire" required class="form-control">
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