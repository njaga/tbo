<?php
session_start();
include 'connexion.php';

$date_validation = $_POST['date_validation'];
$etat = $_POST['etat'];
$commentaire = $_POST['commentaire'];
$id = $_POST['id'];

//Insertion des infos perso de l'employer
$req_client = $db->prepare("UPDATE `tache` SET `commentaire_etat`=?,`etat`=?,`date_validation`=?, id_user_validation=? WHERE id=?");
$result = $req_client->execute(array($commentaire, $etat, $date_validation, $_SESSION['id_vigilus_user'], $id)) or die(print_r($req_client->errorInfo()));
$nbr = 1;

if ($nbr > 0) {
    //echo $verif;
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php

} else {
    //echo $verif;            
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
}

?>