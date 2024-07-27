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
$id_sollicitation = $_GET['id'];
$reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y'))
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
    WHERE sollicitation.id=?");
$reponse->execute(array($id_sollicitation));
$donnees = $reponse->fetch();
$id = $donnees['0'];
$date_reception = $donnees['1'];
$client = $donnees['2'];
$departement = $donnees['3'];
$detail_ao = $donnees['4'];
$type_sollicitation = $donnees['5'];
$nom_doc = $donnees['6'];
$chemin = $donnees['7'];
$date_limite = $donnees['8'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouvelle affectation</title>
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
                        <h4 class="mb-0"><b> Nouvelle affectation </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade table-responsive">
                        <form method="POST" action="recup_sollicitation_trmnt.php?id=<?= $id ?>">
                            <div class="row">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <b><?= strtoupper($type_sollicitation) ?></b>
                                        <br>
                                        Client : <b><?= ($client) ?></b>
                                    </div>
                                    <div class="col-md-12">
                                        Départements : <b><?= ($departement) ?></b>
                                    </div>
                                    <br>
                                    <br>
                                    <h4 class="col-md-12">
                                        Veillez choisir le(s) commercial(s)
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 ">
                                    <fieldset class="form-check">

                                        <?php
                                        $req_user = $db->query("SELECT id, CONCAT(prenom,' ',nom) FROM `user` WHERE etat=1 ORDER BY nom");

                                        while ($donnees_user = $req_user->fetch()) {
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="<?= $donnees_user['0'] ?>" name="commercial[]" value="<?= $donnees_user['0'] ?>">
                                                <label class="form-check-label" for="<?= $donnees_user['0'] ?>"> <?= $donnees_user['1'] ?></label>
                                            </div>
                                        <?php

                                        }
                                        ?>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="text-center mt-4">
                                    <input type="submit" value="Enregistrer" class="btn blue-gradient">
                                </div>
                                <div class="text-center mt-4">
                                    <a href="l_sollicitation_att.php" class="btn red text-white">Retour</a>
                                </div>
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