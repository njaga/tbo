<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$type_tache = $_POST['type_tache'];
if ($search == "") {
    if ($type_tache == "toutes") {
        $reponse = $db->prepare("SELECT tache.id, CONCAT(DATE_FORMAT(tache.date_tache, '%d'), '/', DATE_FORMAT(tache.date_tache, '%m'),'/', DATE_FORMAT(tache.date_tache, '%Y')), client.client, tache.type_tache, tache.commentaire, tache.num_devis, tache.montant, tache.etat, CONCAT(DATE_FORMAT(tache.date_validation, '%d'), '/', DATE_FORMAT(tache.date_validation, '%m'),'/', DATE_FORMAT(tache.date_validation, '%Y'))
        FROM `tache`
        INNER JOIN client ON tache.id_client=client.id
        WHERE tache.etat>0 AND MONTH(tache.date_tache)=? AND YEAR(tache.date_tache)=? AND tache.id_user=?
        ORDER BY tache.date_tache DESC");
        $reponse->execute(array($mois, $annee, $_SESSION['id_vigilus_user']));
    } else {
        $reponse = $db->prepare("SELECT tache.id, CONCAT(DATE_FORMAT(tache.date_tache, '%d'), '/', DATE_FORMAT(tache.date_tache, '%m'),'/', DATE_FORMAT(tache.date_tache, '%Y')), client.client, tache.type_tache, tache.commentaire, tache.num_devis, tache.montant, tache.etat, CONCAT(DATE_FORMAT(tache.date_validation, '%d'), '/', DATE_FORMAT(tache.date_validation, '%m'),'/', DATE_FORMAT(tache.date_validation, '%Y'))
        FROM `tache`
        INNER JOIN client ON tache.id_client=client.id
        WHERE tache.etat>0 AND MONTH(tache.date_tache)=? AND YEAR(tache.date_tache)=? AND tache.type_tache=? AND tache.id_user=?
        ORDER BY tache.date_tache DESC");
        $reponse->execute(array($mois, $annee, $type_tache, $_SESSION['id_vigilus_user']));
    }
} else {
    if ($type_tache == "toutes") {
        $reponse = $db->prepare("SELECT tache.id, CONCAT(DATE_FORMAT(tache.date_tache, '%d'), '/', DATE_FORMAT(tache.date_tache, '%m'),'/', DATE_FORMAT(tache.date_tache, '%Y')), client.client, tache.type_tache, tache.commentaire, tache.num_devis, tache.montant, tache.etat, CONCAT(DATE_FORMAT(tache.date_validation, '%d'), '/', DATE_FORMAT(tache.date_validation, '%m'),'/', DATE_FORMAT(tache.date_validation, '%Y'))
        FROM `tache`
        INNER JOIN client ON tache.id_client=client.id
        WHERE tache.etat>0 AND MONTH(tache.date_tache)=? AND YEAR(tache.date_tache)=? AND client.client like CONCAT('%', ?, '%') AND tache.id_user=?
        ORDER BY tache.date_tache DESC");
        $reponse->execute(array($mois, $annee, $search, $_SESSION['id_vigilus_user']));
    } else {
        $reponse = $db->prepare("SELECT tache.id, CONCAT(DATE_FORMAT(tache.date_tache, '%d'), '/', DATE_FORMAT(tache.date_tache, '%m'),'/', DATE_FORMAT(tache.date_tache, '%Y')), client.client, tache.type_tache, tache.commentaire, tache.num_devis, tache.montant, tache.etat, CONCAT(DATE_FORMAT(tache.date_validation, '%d'), '/', DATE_FORMAT(tache.date_validation, '%m'),'/', DATE_FORMAT(tache.date_validation, '%Y'))
        FROM `tache`
        INNER JOIN client ON tache.id_client=client.id
        WHERE tache.etat>0 AND MONTH(tache.date_tache)=? AND YEAR(tache.date_tache)=? AND client.client like CONCAT('%', ?, '%') AND tache.type_tache=? AND tache.id_user=?
        ORDER BY tache.date_tache DESC");
        $reponse->execute(array($mois, $annee, $search, $type_tache, $_SESSION['id_vigilus_user']));
    }
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$total_retire = 0;
$total_hs = 0;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_tache = $donnees['1'];
    $client = $donnees['2'];
    $type_tache = $donnees['3'];
    $commetaire = $donnees['4'];
    $num_devis = $donnees['5'];
    $montant = $donnees['6'];
    $etat = $donnees['7'];
    $date_validation = $donnees['8'];
    $etat1 = "";
    if ($type_tache == "Devis") {
        if ($etat == "1") {
            $etat1 = '<a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modalEtat">En attente</a>';
        } elseif ($etat == "2") {
            $etat1 = "Validé le " . $date_validation;
        } elseif ($etat == "3") {
            $etat1 = "Refusé";
        }
        $etat1 = '<a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modalEtat">En attente</a>';
    }
    //infos sur le site

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_tache . "</td>";
    echo "<td class='text-center'>" . $client . "</td>";
    echo "<td class='text-center'>" . $type_tache . "</td>";
    echo "<td class='text-center'>" . $commetaire . "</td>";
    echo "<td class='text-center'>" . $etat1 . "</td>";
    echo "<td class='text-center'>";
?>
    <!-- Modal: Succursale form -->
    <div class="modal fade" id="modalEtat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class="">Etat Devis</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="modif_etat_tache_trmnt.php">
                        <input type="number" name="id" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <input type="date" value="<?= date('Y') . '-' . date('m') . '-' . date('d') ?>" id="date_validation" name="date_validation" class="form-control ">
                                    <label for="date_validation" class="active">Date</label>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <select class="browser-default custom-select md-form" name="etat" id="etat" required>
                                    <option value="Appel d'offre">En attente</option>
                                    <option value="2">Validé</option>
                                    <option value="3">Non validé</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 ">
                                <div class="md-form">
                                    <input type="text" id="commentaire" name="commentaire" required class="form-control">
                                    <label for="commentaire" class="active">Commentaire</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
        </div>
    </div>
    <?php
    echo "</td>";
    echo '
		<td>
			
			<a href="m_tache.php?id=' . $id . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>		
		</td>
		';

    $i++;

    ?>


<?php
    echo "</tr>";
}

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>