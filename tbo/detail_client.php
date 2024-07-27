<?php
session_start();
include 'connexion.php';
$id = intval(htmlspecialchars($_GET['id']));

$req = $db->prepare("SELECT client.client, CONCAT(DATE_FORMAT(client.date_enregistrement, '%d'), '/', DATE_FORMAT(client.date_enregistrement, '%m'),'/', DATE_FORMAT(client.date_enregistrement, '%Y')), client.contact, client.telephone, client.email, client.adresse, CONCAT(user.prenom,' ', user.nom)  
FROM `client` 
INNER JOIN user ON user.id=client.id_user
WHERE client.id=?");
$req->execute(array($id));
$donnees = $req->fetch();
$client = $donnees['0'];
$date_enregistrement = $donnees['1'];
$contact = $donnees['2'];
$telelphone = $donnees['3'];
$email = $donnees['4'];
$adresse = $donnees['5'];
$commercial = $donnees['6'];
$req->closeCursor();

$req_taches = $db->prepare("SELECT type_tache, COUNT(type_tache)  
FROM `tache` 
WHERE tache.id_client=?
GROUP BY type_tache");
$req_taches->execute(array($id));

$req_vente = $db->prepare("SELECT SUM(montant) 
FROM `tache` 
WHERE id_client=? AND date_validation is NOT NULL  AND type_tache='Devis'");
$req_vente->execute(array($id));
$donnees = $req_vente->fetch();
$mnt_vente = $donnees['0'];

$req_devis = $db->prepare("SELECT SUM(montant) 
FROM `tache` 
WHERE id_client=? AND date_validation is NULL  AND type_tache='Devis'");
$req_devis->execute(array($id));
$donnees = $req_devis->fetch();
$mnt_devis = $donnees['0'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Détail de Client / Prospect</title>
    <?php include 'css.php'; ?>
</head>

<body class="fixed-sn white-skin">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid" style="margin-top: -65px;">
        <!-- Section: Team v.1 -->
        <section class="section team-section">

            <!-- Grid row -->
            <div class="row text-center">

                <!-- Grid column -->
                <div class="col-md-8 mb-4">

                    <!-- Card -->
                    <div class="card card-cascade cascading-admin-card user-card">

                        <!-- Card Data -->
                        <div class="admin-up d-flex justify-content-start">
                            <i class="fas fa-users info-color py-4 mr-3 z-depth-2"></i>
                            <div class="data">
                                <h5 class="font-weight-bold dark-grey-text">Détail Client / Prospect<span class="text-muted"></span></h5>
                            </div>
                        </div>
                        <!-- Card Data -->

                        <!-- Card content -->
                        <div class="card-body card-body-cascade">

                            <div class="row">

                                <!-- Grid column -->
                                <div class="col-md-6">

                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form5" value="<?= $client ?>" class="form-control form-control-sm" disabled active>
                                        <label for="form5" class="disabled active active">Client</label>
                                    </div>

                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-md-6">

                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form5" value="<?= $contact ?>" class="form-control form-control-sm" disabled active>
                                        <label for="form5" class="disabled active">Contact</label>
                                    </div>

                                </div>
                                <!-- Grid column -->

                            </div>


                            <div class="row">

                                <!-- Grid column -->
                                <div class="col-md-6">

                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form5" value="<?= $telelphone ?>" class="form-control form-control-sm" disabled active>
                                        <label for="form5" class="disabled active active">Téléphone</label>
                                    </div>

                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-md-6">

                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form5" value="<?= $email ?>" class="form-control form-control-sm" disabled active>
                                        <label for="form5" class="disabled active">Email</label>
                                    </div>

                                </div>
                                <!-- Grid column -->

                            </div>
                            <div class="row">

                                <!-- Grid column -->
                                <div class="col-lg-4">

                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form12" value="<?= $commercial ?>" class="form-control form-control-sm" disabled active>
                                        <label for="form12" class="disabled active">Commercial</label>
                                    </div>

                                </div>
                                <!-- Grid column -->

                            </div>

                        </div>
                        <!-- Card content -->

                    </div>
                    <!-- Card -->

                </div>

                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4">

                    <!-- Card -->
                    <div class="card profile-card">
                        <div class="card-body pt-0 mt-0">
                            <h4>Total Ventes
                                <br>
                                <b><?= number_format($mnt_vente, 0, '.', ' ') ?></b>
                            </h4>
                            <br>
                            <h4>Total Devis
                                <br>
                                <b><?= number_format($mnt_devis, 0, '.', ' ') ?></b>
                            </h4>
                            <br>
                            <?php
                            while ($donnees_tache = $req_taches->fetch()) {
                                $type_tache = $donnees_tache['0'];
                                $nbr = $donnees_tache['1'];
                                echo "<h5>" . $type_tache . " : <b>" . str_pad($nbr, 2, "0", STR_PAD_LEFT) . "</b></h5>";
                            }
                            ?>
                        </div>

                    </div>
                    <!-- Card -->

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->


        </section>
        <!-- Section: Team v.1 -->

    </div>

</body>
<?php include 'footer.php'; ?>
<?php include 'js.php'; ?>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {

    })
</script>

</html>