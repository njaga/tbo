<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$verif = 0;

$date_tache = htmlspecialchars($_POST['date_tache']);
$type_tache = htmlspecialchars($_POST['type_tache']);
$client = htmlspecialchars($_POST['client']);
$commentaire = htmlspecialchars($_POST['commentaire']);
$num_devis = htmlspecialchars($_POST['num_devis']);
$montant = htmlspecialchars($_POST['montant']);
$departement = htmlspecialchars($_POST['departement']);

//Démarrage de la transaction

//Insertion des infos perso de l'employer
$req_tache = $db->prepare("INSERT INTO `tache`(`id_client`, `type_tache`, `date_tache`, `commentaire`, `num_devis`, `montant`, departement, `id_user`) VALUES(?,?,?,?,?,?,?,?)");
$result = $req_tache->execute(array($client, $type_tache, $date_tache, $commentaire, $num_devis, $montant, $departement, $_SESSION['id_vigilus_user'])) or die(print_r($req_tache->errorInfo()));
$nbr = $req_tache->rowCount();

if ($nbr > 0) {
    //echo $verif;
?>
    <script type="text/javascript">
        window.location = "l_taches.php";
    </script>
<?php

} else {
    //echo $verif;            
?>
    <script type="text/javascript">
        alert("Erreur Client non enregistré");
        window.history.go(-1);
    </script>
<?php
}

?>