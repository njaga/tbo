<?php
session_start();
include 'connexion.php';
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$type_tache = $_POST['type_tache'];
$id_commercial = $_POST['commercial'];

if ($type_tache == "toutes") {
    $type_taches = " ";
} else {
    $type_taches = " AND tache.type_tache='" . $type_tache . "'";
}

if ($id_commercial == "tous") {
    $id_commercials = " ";
} else {
    $id_commercials = " AND user.id=" . $id_commercial;
}

$reponse = $db->prepare("SELECT tache.id, CONCAT(DATE_FORMAT(tache.date_tache, '%d'), '/', DATE_FORMAT(tache.date_tache, '%m'),'/', DATE_FORMAT(tache.date_tache, '%Y')), client.client, tache.type_tache, tache.commentaire, tache.num_devis, tache.montant, CONCAT(user.prenom,' ',user.nom), tache.etat
FROM `tache`
INNER JOIN client ON tache.id_client=client.id
INNER JOIN user on user.id=tache.id_user
WHERE tache.etat=1 " . $id_commercials . " AND MONTH(tache.date_tache)=? AND YEAR(tache.date_tache)=?" . $type_taches . "
ORDER BY tache.date_tache DESC");
$reponse->execute(array($mois, $annee));


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
    $commercial = $donnees['7'];
    $etat = $donnees['8'];
    $etat1 = "";
    if ($type_tache == "Devis") {
        $type_tache = "Devis N°" . $num_devis . "<b><br>TTC : " . number_format($montant, 0, '.', ' ') . " <br>HT : " . number_format(($montant * 0.82), 0, '.', ' ') . "</b>";
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
    echo "<td class='text-center'>" . $commercial . "</td>";
    echo "<td class='text-center'>" . $etat1 . "</td>";
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