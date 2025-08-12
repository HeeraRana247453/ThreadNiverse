<?php 
    // Start output buffering at the very beginning of your script
    ob_start();
    $alertsuccess = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contactUs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- bootstrap for header -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_SESSION['loggedin']) && isset($_POST['send'])) 
    {
        $userid = $_SESSION['curr_user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $msg = $_POST['msg'];

        //Load Composer's autoloader
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        require 'PHPMailer/Exception.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'moviesheater2@gmail.com';                     //SMTP username
            $mail->Password   = 'dsgtdjfgcjdcqzuz';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('moviesheater2@gmail.com', 'contact form');
            $mail->addAddress('threadniverse@gmail.com', 'ThreadNiverse Email');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "$subject";
            // $mail->Body    = "Userid- $userid <br>Sender Name- $name <br>Sender Email- $email <br>Message- $msg";
            $mail->Body = '
                    <div style="max-width: 600px; margin: 0 auto; background-color: whitesmoke; border-radius: 8px; overflow: hidden; border:1px solid green">
                        <div style="background-color: lightgreen; padding: 20px;">
                            <h2 style="color: darkgreen; text-shadow:1px 1px 1px brown; margin: 0; text-align:center;">New Message Received <span style="font-size:40px;">&#128233;</span></h2>
                        </div>
                        <div style="padding: 20px;">
                            <p style="font-size: 18px; color:purple;">Hello,</p>
                            <p style="font-size: 16px;color:purple; line-height: 1.5;">
                                You have received a new message via the contact form on ThreadNiverse.
                            </p>
                            <hr style="border: 0; border-top: 2px solid #dddddd;">
                            <table style="width: 100%; font-size: 16px; margin-bottom: 20px;">
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">User ID:</td>
                                    <td>' . $userid . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Sender Name:</td>
                                    <td>' . $name . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Sender Email:</td>
                                    <td>' . $email . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Subject:</td>
                                    <td>' . $subject . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 10px 0;">Message:</td>
                                    <td>' . nl2br($msg) . '</td> <!-- nl2br() to maintain line breaks -->
                                </tr>
                            </table>
                            <hr style="border: 0; border-top: 2px solid #dddddd;">
                            <p style="font-size: 14px; color: #999;">
                                This message was sent from the contact form on your website.
                            </p>
                        </div>
                        <div style="background-color: lightgreen; color: #999; padding: 10px 20px; text-align: center;">
                            <p style="margin: 0;">&copy; 2024 ThreadNiverse</p>
                        </div>
                    </div>
            ';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            
            // echo 'Message has been sent';
            if ($mail->send()) {
                $alertsuccess = true;
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center m-0" role="alert">
                    Message could not be sent. Mailer Error: {'.$mail->ErrorInfo.'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    else if(isset($_POST['send']) && !isset($_SESSION['loggedin'])){
        echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center m-0" role="alert">
                <strong>Please login!</strong> to Send Message.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    
    
    <div class="contact-container">
        <?php 
            if ($alertsuccess == true) {
                echo '<div class="container-fluid p-5 my-5 rounded-3" style="background-color: lightgreen;border:1px solid green">
                        <div class="container">
                            <h1 class="display-4">Message sent successfully! <img height="65px" src="images/emailsendsuccessful.png"></h1>
                            <p class="lead">We will get back to you as soon as possible.</p>
                        </div>
                    </div>';
                // Use a meta refresh or JavaScript redirect instead of header()
                // echo '<meta http-equiv="refresh" content="5; URL=/php_heera/Project-4_Thread/contactUs.php">';
                // or
                echo '<script>setTimeout(function(){ window.location.href = "/php_heera/Project-4_Thread/contactUs.php"; }, 7000);</script>';
                exit; // stop executing the script
            }
        ?>
    
        <h2>Contact Us</h2>
        <p>Feel free to drop us a message. <br>We will get back to you as soon as possible.</p>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="contact-form" id="contactForm">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email Address" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Subject of Message" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="msg" placeholder="Your Message" rows="5" required></textarea>
            </div>

            <button type="submit" name="send"><img class="me-2" height="30px" src="images/send2.png"> Send Message</button>
        </form>

        <!-- <div id="success-message" class="success-message" style="display: none;"> -->
            <!-- Thank you for your message! We will contact you soon. -->
        <!-- </div> -->
    </div>

    <?php include "components/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
// Send output to the browser
ob_end_flush();
?>