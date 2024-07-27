<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];

if ($search == "") {

    $reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y'))
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
    WHERE sollicitation.etat=2  AND sollicitation.id_commercial=?");
    $reponse->execute(array($_SESSION['id_vigilus_user']));
} else {
    $reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin, CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y'))
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
    WHERE sollicitation.etat=2 AND CONCAT (client.client,' ',sollicitation.departement, ' ',sollicitation.details_ao) like CONCAT('%', ?, '%') AND sollicitation.id_commercial=?");
    $reponse->execute(array($search, $_SESSION['id_vigilus_user']));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucune sollicitation en attente</h3></td></tr>";
}
$i = 1;

while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_reception = $donnees['1'];
    $client = $donnees['2'];
    $departement = $donnees['3'];
    $detail_ao = $donnees['4'];
    $type_sollicitation = $donnees['5'];
    $nom_doc = $donnees['6'];
    $chemin = $donnees['7'];
    $date_limite = $donnees['8'];
    if ($chemin != "") {
        $pj = '<a href="' . $chemin . '" class="btn btn-primary btn-rounded btn-sm" >PJ</a></td>';
    } else {
        $pj = "";
    }

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_reception . "</td>";
    echo "<td class='text-center'>" . $client . "</td>";
    echo "<td class='text-center'>" . $type_sollicitation . "</td>";
    echo "<td class='text-center'>" . $departement . "</td>";
    echo "<td class='text-center'>" . $date_limite . "</td>";
    echo '<td class="text-center"><a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modalEtat' . $id . '">Détail(s)</a></td>';
    echo '<td class="text-center">' . $pj . '</td>';
    echo '<td class="text-center"><a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modaltrmnt' . $id . '">traiter</a></td>';
    echo "<td class='text-center'>";
?>
    <!-- Modal: Succursale form -->
    <div class="modal fade" id="modalEtat<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><?= $type_sollicitation ?></h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="recup_sollicitation.php?id=<?= $id ?>">
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="details_ao"></label>
                                <textarea class="form-control z-depth-1" id="details_ao" name="details_ao" rows="3" placeholder="Commentaire"><?= $detail_ao ?></textarea>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Traiter</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
        </div>
    </div>
    <?php
    echo "</td>";
    echo '<td>';
    ?>
    <div class="modal fade" id="modaltrmnt<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class="">Traitement <?= $type_sollicitation ?></h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="traitement_sollicitation.php?id=<?= $id ?>" action="traitement_sollicitation.php?id=<?= $id ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <input type="date" value="<?= date('Y') . '-' . date('m') . '-' . date('d') ?>" id="date_traitement" name="date_traitement" class="form-control ">
                                    <label for="date_traitement" class="active">Date</label>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <select class="browser-default custom-select md-form" name="etat" id="etat" required>
                                    <option value="" disabled selected>Etat</option>
                                    <option value="3">Abandonner</option>
                                    <option value="4">Déposer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <input type="number" value="0" id="offre_financiere" required name="offre_financiere" class="form-control ">
                                    <label for="offre_financiere" class="active">Offre Financière</label>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <input type="number" value="0" id="marge" required name="marge" class="form-control ">
                                    <label for="marge" class="active">Marge</label>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="of" accept="application/pdf" class="custom-file-input" id="of" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="of">Financière</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="md-form">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="ot" accept="application/pdf" class="custom-file-input" id="ot" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="ot">Technique</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="details_ao"></label>
                                <textarea class="form-control z-depth-1" id="details_ao" name="details_ao" rows="3" placeholder="Commentaire"></textarea>
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
    echo '</td>';
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