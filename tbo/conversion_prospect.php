<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id = htmlspecialchars($_GET['id']);
$date_conversion = htmlspecialchars($_POST['date_conversion']);


$req_client = $db->prepare("UPDATE `client`SET `type`='Client', date_conversion=? WHERE id=?");
$result = $req_client->execute(array($date_conversion, $id)) or die(print_r($req_client->errorInfo()));
$nbr = $req_client->rowCount();

if ($nbr > 0) {
    //echo $verif;
?>
    <script type="text/javascript">
        //alert("Client enregistré");
        window.location = "l_prospect.php";
    </script>
<?php

} else {
    //echo $verif;            
?>
    <script type="text/javascript">
        alert("Erreur : pas de mofication");
        window.history.go(-1);
    </script>
<?php
}

?>