<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connexion.php';
$reponse = $db->query("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y')), DATEDIFF(sollicitation.date_limit, CURRENT_DATE())
FROM `sollicitation`
INNER JOIN client ON client.id=sollicitation.id_client
LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
WHERE sollicitation.etat BETWEEN 1 AND 2 AND DATEDIFF(sollicitation.date_limit, CURRENT_DATE()) BETWEEN 0 and 7");
$nbr = $reponse->rowCount();
$message = "";
$message = '<br>
Bonjour Team,
<br>
<br>
Ci dessous, le tableau récapitulatif des dossiers en cours.
<br>
<br>
Bonne réception et surtout good day!
<br>
<br>
<table >
<thead class="black ">
    <tr style="border:1px solid black; text-align: center">
        <td style="border:1px solid black; text-align: center">#</td>
        <td style="border:1px solid black; text-align: center">Date </td>
        <td style="border:1px solid black; text-align: center">Client / Prospect</td>
        <td style="border:1px solid black; text-align: center">Sollicitation</td>
        <td style="border:1px solid black; text-align: center">Département(s)</td>
        <td style="border:1px solid black; text-align: center">Date limite</td>
        <td style="border:1px solid black; text-align: center">Nbr jour restant</td>
    </tr>
</thead>
<tbody class="tbody">';
?>


<?php
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
    $nbr_jour_restant = $donnees['9'];
    $message = $message . "<tr style='border:1px solid black; text-align: center'>";
    $message = $message . "<td style='border:1px solid black; text-align: center'><b>" . $i . "</b></td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $date_reception . "</td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $client . "</td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $type_sollicitation . "</td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $departement . "</td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $date_limite . "</td>";
    $message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_jour_restant . "</td>";
    $message = $message . "</tr>";
    $i++;
}
$message = $message . "</tbody></table>";
//Load Composer's autoloader
echo $message;
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->CharSet = 'UTF-8'; //Format d'encodage à utiliser pour les caractères
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.groupevigilus.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'no-reply@groupevigilus.com';                     //SMTP username
    $mail->Password   = 'No-Reply@';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bassene@groupevigilus.com', 'Team IT');
    $mail->addAddress('teamcommercial@groupevigilus.com', 'TEAM COMMERCIAL');     //Add a recipient
    $mail->addAddress('maury.kandji@groupevigilus.com', 'Maury KANDJI');               //Name is optional
    $mail->addReplyTo('teamcommercial@groupevigilus.com', 'Team Commercial');
    $mail->addCC('a.mbaye@groupevigilus.com', 'Alassane MBAYE - DG Vigilus');
    $mail->addCC('juridique@groupevigilus.com', 'Samba S. MBAYE - DAG VIGILUS');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Rappel TBO';
    $mail->Body    = $message;
    $mail->AltBody = 'Ceci est un second <b>test</b>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
