<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connexion.php';
$id = htmlspecialchars($_GET['id']);
$date_recup = date('Y') . '-' . date('m') . '-' . date('d');

$i = 0;
if (isset($_POST['commercial'])) {
    foreach ($_POST['commercial'] as $valeur) {
        if ($i > 0) {
            //Recupération des infos sur la sollicitation
            $req = $db->prepare("SELECT `type`, `id_client`, `date_reception`, `num_dossier`, `date_limit`, `departement`, `details_ao`, `id_commercial`, `date_recup`, `offre_financiere`,  `date_depot`, `date_resultat`, `commentaire_resultat`, `date_enregistrement`, `etat`, `id_user`, `marge` FROM `sollicitation` WHERE id=?");
            $req->execute(array($id)) or die(print_r($req->errorInfo()));
            $donnees = $req->fetch();
            $type = $donnees['0'];
            $id_client = $donnees['1'];
            $date_reception = $donnees['2'];
            $num_dossier = $donnees['3'];
            $date_limit = $donnees['4'];
            $departement = $donnees['5'];
            $details_ao = $donnees['6'];
            $id_commercial = $donnees['7'];
            $date_recup = $donnees['8'];
            $offre_financiere = $donnees['9'];
            $date_depot = $donnees['10'];
            $date_resultat = $donnees['11'];
            $commentaire_resultat = $donnees['12'];
            $date_enregistrement = $donnees['13'];
            $etat = $donnees['14'];
            $id_user = $donnees['15'];
            $marge = $donnees['16'];

            //Duplication de la sollicitation
            $req = $db->prepare("INSERT INTO `sollicitation` (`type`, `id_client`, `date_reception`, `num_dossier`, `date_limit`, `departement`, `details_ao`, `id_commercial`, `date_recup`, `offre_financiere`, `marge`, `date_depot`, `date_resultat`, `commentaire_resultat`, `date_enregistrement`, `etat`, `id_user`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
            $req->execute(array($type, $id_client, $date_reception, $num_dossier, $date_limit, $departement, $details_ao, $id_commercial, $date_recup, $offre_financiere, $marge, $date_depot, $date_resultat, $commentaire_resultat, $date_enregistrement, $etat, $id_user)) or die(print_r($req->errorInfo()));
            $id = $db->lastInsertId();

            //Affectation de la sollicitation 
            $req = $db->prepare("UPDATE `sollicitation` SET etat=2, id_commercial=?, date_recup=? WHERE id=?");
            $req->execute(array($valeur, $date_recup, $id)) or die(print_r($req->errorInfo()));

            //Envoi de la notification au commerciale
            $req = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y')), DATEDIFF(sollicitation.date_limit, CURRENT_DATE()), CONCAT(user.prenom,' ', user.nom), user.email
FROM `sollicitation`
INNER JOIN client ON client.id=sollicitation.id_client
INNER JOIN user ON user.id=sollicitation.id_commercial
WHERE sollicitation.id=?");
            $result = $req->execute(array($id)) or die(print_r($req->errorInfo()));
            $donnees = $req->fetch();
            $id = $donnees['0'];
            $date_reception = $donnees['1'];
            $client = $donnees['2'];
            $departement = $donnees['3'];
            $detail_ao = $donnees['4'];
            $type_sollicitation = $donnees['5'];
            $date_limite = $donnees['6'];
            $nbr_jour_restant = $donnees['7'];
            $nom_commercial = $donnees['8'];
            $email_commercial = $donnees['9'];

            $message = "";
            $message = '<br>
Bonjour ' . strtoupper($nom_commercial) . ',
<br>
<br>
Merci de prendre en compte cette sollicitation
<br>
<br>
<b>' . $type_sollicitation . '</b>
<br>
<b>Date limite : ' . $date_limite . '</b>
<br>
<b>Client </b>: ' . $client . '
<br>
<b>Détails</b> <br>: ' . nl2br($detail_ao) . '
<br>
<br>
Pour plus dinformation rendez-vous sur lapplication TBO!
<br><br>
Cordialement!
<br>';

            //Load Composer's autoloader
            //echo $message;
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
                $mail->Username   = 'bassene@groupevigilus.com';                     //SMTP username
                $mail->Password   = 'Khalifa@Bassene';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('mareme@groupevigilus.com', 'Mareme DIOP Reponsable Commerciale');
                $mail->addAddress($email_commercial, 'TEAM COMMERCIAL');     //Add a recipient
                //$mail->addAddress('malick.ka@groupevigilus.com', 'Malick KA');               //Name is optional
                $mail->addReplyTo('mareme@groupevigilus.com', 'Mareme DIOP Reponsable Commerciale');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Nouvelle affectation TBO';
                $mail->Body    = $message;
                $mail->AltBody = 'Ceci est un second <b>test</b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $i++;
        } else {
            $req = $db->prepare("UPDATE `sollicitation` SET etat=2, id_commercial=?, date_recup=? WHERE id=?");
            $result = $req->execute(array($valeur, $date_recup, $id)) or die(print_r($req->errorInfo()));
            $i++;

            //Envoi de la notification au commerciale
            $req = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y')), DATEDIFF(sollicitation.date_limit, CURRENT_DATE()), CONCAT(user.prenom,' ', user.nom), user.email
FROM `sollicitation`
INNER JOIN client ON client.id=sollicitation.id_client
INNER JOIN user ON user.id=sollicitation.id_commercial
WHERE sollicitation.id=?");
            $result = $req->execute(array($id)) or die(print_r($req->errorInfo()));
            $donnees = $req->fetch();
            $id = $donnees['0'];
            $date_reception = $donnees['1'];
            $client = $donnees['2'];
            $departement = $donnees['3'];
            $detail_ao = $donnees['4'];
            $type_sollicitation = $donnees['5'];
            $date_limite = $donnees['6'];
            $nbr_jour_restant = $donnees['7'];
            $nom_commercial = $donnees['8'];
            $email_commercial = $donnees['9'];
            $message = "";
            $message = '<br>
Bonjour ' . strtoupper($nom_commercial) . ',
<br>
<br>
Merci de prendre en compte cette sollicitation
<br>
<br>
<b>' . $type_sollicitation . '</b>
<br>
<b>Date limite : ' . $date_limite . '</b>
<br>
<b>Client </b>: ' . $client . '
<br>
<b>Détails</b> <br>: ' . nl2br($detail_ao) . '
<br>
<br>
Pour plus dinformation rendez-vous sur lapplication TBO!
<br><br>
Cordialement!
<br>
<table width="500" style="background:white; padding:5px; color:#0a0a0a; font-size:14px; font-family: Verdana, Geneva, sans-serif; border-spacing: 0;" >
  <tr>
    <td width="320">
      <table>
        <tr>
          <td valign="top" width="30%" align="center">
            <a href="http://groupevigilus.com/" target="_blank">
              <img src="https://www.vigilus-securite.com/wp-content/uploads/2021/11/global.jpg" alt="Vigilus Groupe SA" width="150">
            </a>
          </td>
            <td style="line-height:19px;padding-left:15px; padding-top: 15px; font-family: Verdana, Geneva, sans-serif;" valign="center" width="70%">
           <strong style="color:rgb(8, 8, 8); font-size:18px" spellcheck="false"> <font face="verdana" size =" 3" color="#565859">Mareme DIOP </font></strong>
              <br>
<font face="verdana" size =" 2" color="#565859">Business Developer Manager</font><br>
              <font face="verdana" size =" 1.5" color="#67666A">Bur:</font> <a href="tel:+2221338677732" style="color:#121213; text-decoration:none !important;outline:none !important; font-family: Verdana, Geneva, sans-serif;" > &nbsp; <font face="verdana" size =" 1" color="#67666A"><strong style="font-weight:normal !important">+221 33 867 77 32</strong></font></a>
              <br>
               <font face="verdana" size =" 1.5" color="#67666A">Cel:</font>
             <a href="tel:+221774432214" style="color:#0b0c0c; text-decoration:none !important; font-family: Verdana, Geneva, sans-serif;"> &nbsp; <font face="verdana" size =" 1" color="#67666A"><strong style="font-weight:400 !important; text-decoration: none !important;">  +221 75 640 49 52 / 77 209 07 49 </strong></font></a>
              <br>
              
<!--                 <a href="#" style="text-decoration:none;color:#565859;font-family: Verdana, Geneva, sans-serif;" target="_blank"> -->
                  <font face="verdana" size =" 2" color="#67666A"><strong style="font-weight:normal !important">Immeuble VIGILUS VDN Sacré cœur 3,<br>
                  Dakar - Sénégal</strong></font>
<!--       </a> -->
              <br>
                <a href="http://groupevigilus.com" style="color:#BC1231; text-decoration:none !important; font-weight:700; font-family: Verdana, Geneva, sans-serif;" target="_blank">
                  <font face="verdana" size =" 2" color="#b1132f"><strong style="font-weight:normal">https://groupevigilus.com</strong></font></a> 

                  

<hr style="border-width: 2px;">
           <center>
<!--               <a href="https://web.facebook.com/vigilussecurite?_rdc=1&_rdr --><a href="https://www.facebook.com/vigilusgroupe/" style="text-decoration:none; margin-right:10px;text-decoration:none !important;outline:none !important;    color: white !important;" target="_blank" style="color:white">
                <img src="https://comfordev.com/wp-content/uploads/2019/09/social_fb.png" alt="Vigilus Security" width="28">
              </a>
              
               <a href="https://twitter.com/VigilusSecurity" style="text-decoration:none; margin-right:10px;text-decoration:none !important;outline:none !important;    color: white !important;" target="_blank" style="color:white">
              <img src="https://comfordev.com/wp-content/uploads/2019/09/social_twt.png" alt="Vigilus Security" width="28">
                 </a>
              <a href="https://www.linkedin.com/company/vigilus-security-sa/" style="text-decoration:none; margin-right:10px;text-decoration:none !important;outline:none !important;    color: white !important;" target="_blank" style="color:white">
              <img src="https://comfordev.com/wp-content/uploads/2019/09/social_in.png" alt="Vigilus Security" width="28">
             </a> 
              <a href="https://www.youtube.com/channel/UCvsIMaQ-L_tq6eV0cXfP86w" style="text-decoration:none; margin-right:10px;text-decoration:none !important;outline:none !important;    color: white !important;" target="_blank" style="color:white">
         <img src="https://comfordev.com/wp-content/uploads/2019/09/social_yt.png" alt="Vigilus Security" width="28">
              </a>
              </center>
              
              <br>
                 
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
';

            //Load Composer's autoloader
            //echo $message;
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
                $mail->Username   = 'bassene@groupevigilus.com';                     //SMTP username
                $mail->Password   = 'Khalifa@Bassene';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('mareme@groupevigilus.com', 'Mareme DIOP Reponsable Commerciale');
                $mail->addAddress($email_commercial, $nom_commercial);     //Add a recipient
                $mail->addReplyTo('mareme@groupevigilus.com', 'Mareme DIOP Reponsable Commerciale');
                //Name is optional
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
                $mail->addCC('malick.ka@groupevigilus.com', 'Malick KA');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Nouvelle affectation TBO';
                $mail->Body    = $message;
                $mail->AltBody = 'Ceci est un second <b>test</b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

//$req = $db->prepare("UPDATE `sollicitation` SET etat=2, id_commercial=?, date_recup=? WHERE id=?");
//$result = $req->execute(array($commercial, $date_recup, $id)) or die(print_r($req->errorInfo()));
//$nbr = $req->rowCount();




//echo $verif;
?>
<script type="text/javascript">
    window.location = "l_sollicitation_cours.php";
</script>