<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$verif = 0;

$date_reception = htmlspecialchars($_POST['date_reception']);
$client = htmlspecialchars($_POST['client']);
$type_tache = htmlspecialchars($_POST['type_tache']);
$num_dossier = htmlspecialchars($_POST['num_dossier']);
$date_limite = htmlspecialchars($_POST['date_limite']);
$details_ao = htmlspecialchars($_POST['details_ao']);
$list_departement = "";


if (isset($_POST['departement'])) {
    $departements = $_POST['departement'];
    foreach ($departements as $departement) {
        $list_departement = $departement . ", " . $list_departement;
    }
}


//Démarrage de la transaction

//Insertion des infos perso de l'employer
$req_tache = $db->prepare("INSERT INTO `sollicitation`(`type`, `id_client`, `date_reception`, `num_dossier`, `date_limit`, `departement`, `details_ao`, `id_user`) VALUES (?,?,?,?,?,?,?,?)");
$result = $req_tache->execute(array($type_tache, $client, $date_reception, $num_dossier, $date_limite, $list_departement, $details_ao, $_SESSION['id_vigilus_user'])) or die(print_r($req_tache->errorInfo()));
$id_sollicitation = $db->lastInsertId();

$nbr = $req_tache->rowCount();

switch ($_FILES["pj"]['error']) {
    case 1: // UPLOAD_ERR_INI_SIZE
        $error = "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
        break;
    case 2: // UPLOAD_ERR_FORM_SIZE
        $error = "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
        break;
    case 3: // UPLOAD_ERR_PARTIAL
        $error = "L'envoi du fichier a été interrompu pendant le transfert !";
        break;
    case 4: // UPLOAD_ERR_NO_FILE
        $doc = '';
        break;
    default: {
            // Testons si l'extension est autorisée
            $extension = strtolower(strrchr($_FILES["pj"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'sollicitation/' . $id_sollicitation . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }

                $nom_document = "PJ";
                move_uploaded_file($_FILES["pj"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc_sollicitation = $repertoire . $nom_document . $extension;

                $req_document = $db->prepare("INSERT INTO document_sollicitation (`type_document`, `nom_document`, `chemin`, `id_sollicitation`,  id_user) VALUES (?,?,?,?,?)");
                $req_document->execute((array("PJ", "PJ", $doc_sollicitation, $id_sollicitation,  $_SESSION['id_vigilus_user'])));
            }
        }
}


if ($nbr > 0) {
    //echo $verif;
?>
    <script type="text/javascript">
        window.location = "l_sollicitation.php";
    </script>
<?php

} else {
    //echo $verif;            
?>
    <script type="text/javascript">
        alert("Erreur  non enregistré");
        window.history.go(-1);
    </script>
<?php
}

?>