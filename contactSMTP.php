<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 //Load Composer's autoloader
 require 'PHPMailer/PHPMailer.php';
 require 'PHPMailer/SMTP.php';
 require 'PHPMailer/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'moviesheater2@gmail.com';                     //SMTP username
    $mail->Password   = 'dsgtdjfgcjdcqzuz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    // $mail->setFrom('moviesheater2@gmail.com', 'contact form');
    // $mail->addAddress('threadniverse@gmail.com', 'Hamari website');     //Add a recipient
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Subject - $subject";
    $mail->Body    = "Userid- $userid <br>Sender Name- $name <br>Sender Email- $email <br>Message- $msg";

    $mail->send();
    echo 'Message has been sent';
    echo'
                    <div style="max-width: 600px; margin: 0 auto; background-color: whitesmoke; border-radius: 8px; overflow: hidden; border:1px solid black">
                        <div style="background-color: lightgreen; padding: 20px;">
                            <h2 style="margin: 0;color: brown;">New Message Received <span style="font-size:40px;">&#128233;</span></h2>
                        </div>
                        <div style="padding: 20px;">
                            <p style="font-size: 16px;color:purple; line-height: 1.5;">
                                Hello, You have received a new message via the contact form on your website.
                            </p>
                            <hr style="border: 0; border-top: 2px solid #dddddd;">
                            <table style="width: 100%; font-size: 16px; margin-bottom: 20px;">
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">User ID:</td>
                                    <td>13</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Sender Name:</td>
                                    <td>Heera Rana</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Sender Email:</td>
                                    <td>heerarana123@gmail.com</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Subject:</td>
                                    <td>Add like button</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Message:</td>
                                    <td>' . nl2br('Please add like button to thread') . '</td> <!-- nl2br() to maintain line breaks -->
                                </tr>
                            </table>
                            <p style="font-size: 14px; color: #999;">
                                This message was sent from the contact form on your website.
                            </p>
                        </div>
                        <div style="background-color: lightgreen; color: #999; padding: 10px 20px; text-align: center;">
                            <p style="margin: 0;">&copy; 2024 ThreadNiverse</p>
                        </div>
                    </div>
            ';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>