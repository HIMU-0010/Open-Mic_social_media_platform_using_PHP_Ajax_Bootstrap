<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);

function sendOTP($email, $subject, $code)
{
    global $mail;

    try 
    {           
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'openmicmail01@gmail.com';                    
        $mail->Password   = 'smqoibhwnpkfzyws';                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    

    
        $mail->setFrom('openmicmail01@gmail.com', 'open mic');

        $mail->addAddress($email);             


        $mail->isHTML(true);                                 
        $mail->Subject = $subject;
        $mail->Body    = "Your Verification Code is: <b> $code </b>";

        $mail->send();
    } 
    catch (Exception $e) 
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}