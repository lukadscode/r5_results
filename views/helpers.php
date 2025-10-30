<?php
function displayAlert($type, $title, $message)
{
    // Définir l'icône et les couleurs en fonction du type d'alerte
    $icon = $type === 'success' ? 'ki-duotone ki-shield-tick' : 'ki-duotone ki-shield-warning';
    $textColor = $type === 'success' ? 'text-success' : 'text-danger';
    $alertColor = $type === 'success' ? 'alert-success' : 'alert-danger';

    // Retourner le HTML de l'alerte
    return '
    <!--begin::Alert-->
    <div class="alert ' . $alertColor . ' d-flex align-items-center p-5">
        <!--begin::Icon-->
        <i class="' . $icon . ' fs-2hx ' . $textColor . ' me-4"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 ' . $textColor . '">' . $title . '</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span>' . $message . '</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
    ';
}


// Fonction pour générer un token AAA-BBB-CCC
function generateToken()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';

    // Générer 3 groupes de 3 caractères aléatoires
    for ($i = 0; $i < 3; $i++) {
        if ($i > 0) {
            $token .= '-'; // Ajouter le tiret entre les groupes
        }
        $group = '';
        for ($j = 0; $j < 3; $j++) {
            $group .= $characters[random_int(0, strlen($characters) - 1)];
        }
        $token .= $group;
    }

    return $token;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';


function Envoiemail($reception, $nom, $sujet, $contenue)
{

    //Create an instance; passing `true` enables exceptions
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //certif
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Server settings
        $mail->SMTPAutoTLS = false;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.ffaviron.fr';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = 'true';                                   //Enable SMTP authentication
        $mail->Username   = 'noreply@ffaviron.fr';                     //SMTP username
        $mail->Password   = 'couler-94736';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = '587';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('noreply@ffaviron.fr', 'MAIF AVIRON INDOOR 2025');
        $mail->addAddress($reception, $nom);    //Add a recipient
        $mail->addReplyTo('maif-aviron-indoor@ffaviron.fr', 'MAIF AVIRON INDOOR');
        //$mail->addCC('cc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $sujet;
        $mail->Body = "<html>$contenue</html>";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
