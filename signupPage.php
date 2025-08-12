<?php

// Custom error handler
    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        // Log the error message for debugging
        // error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, 'errors.log');

        // Show a custom error message to the user
        echo "<div style='color: red; text-align:center; font-weight: bold; padding: 13px; border: 1px solid red; border-radius:6px; background-color: #fdd;'>
                We're experiencing some technical issues. <p>Please try again later.</p>
            <a href='contact.php'>Contact Support</a> if the problem persists.
            </div>";
        exit();
    }
// Set the custom error handler
    set_error_handler("customErrorHandler");

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

// require 'vendor/autoload.php'; // Include the Cloudinary PHP SDK

// use Cloudinary\Cloudinary;
// use Cloudinary\Configuration\Configuration;

// Cloudinary Configuration
// $cloudinary = new Cloudinary(
//     new Configuration([
//         'cloud' => [
//             'cloud_name' => 'dmvmebkrr',
//             'api_key'    => '294865893923795',
//             'api_secret' => 'kYVrwzxgOJiA-_RxExT6F6_-o1w',
//         ]
//     ])
// );

$alertsuccess = false;
$alertfailed = false;
$exists = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Connect to the Database
    include "components/_dbconnect.php";

    echo "<script>console.log('console-1');</script>";

    $fname = htmlspecialchars($_POST['firstname']); // Prevent XSS attacks
    $lname = htmlspecialchars($_POST['lastname']); // Prevent XSS attacks
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if the email already exists
    $sql_1 = "SELECT * FROM `user_credentials` WHERE `email`='$email'";
    $checkresult = mysqli_query($conn, $sql_1);
    $exists = mysqli_num_rows($checkresult) > 0;

    // Check if passwords match, email doesn't exist, and a profile photo was uploaded
    if ($password == $cpassword && !$exists && isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == UPLOAD_ERR_OK) {
        // UPLOAD THE IMAGE TO CLOUDINARY
        $image = $_FILES['profilePhoto']['tmp_name'];
        
        // Ensure Cloudinary is properly configured
        $uploadResult = $cloudinary->uploadApi()->upload($image, ['folder' => 'user_profiles']);
        $imageUrl = $uploadResult['secure_url']; // Get the URL of the uploaded image

        // Hash the password
        $hash_pass = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database, including the image URL
        $sql_2 = "INSERT INTO `user_credentials`(`fname`,`lname`,`email`,`pass`,`image_url`) 
                  VALUES('$fname','$lname','$email','$hash_pass','$imageUrl')";
        $result = mysqli_query($conn, $sql_2);
        
        if ($result) {
            $alertsuccess = true;
            header("Location:index.php");
            exit();
        }
    } else if ($password != $cpassword) {
        echo "<script>console.log('console-2');</script>";
        $alertfailed = true;
    } elseif (!$exists && !isset($_FILES['profilePhoto'])) {
        echo "<script>console.log('console-3');</script>";
        // If no profile photo was uploaded, only insert user credentials
        $hash_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql_2 = "INSERT INTO `user_credentials`(`fname`,`lname`,`email`,`pass`) 
                  VALUES('$fname','$lname','$email','$hash_pass')";
        $result = mysqli_query($conn, $sql_2);
        
        if ($result) {
            $alertsuccess = true;
            header("Location:index.php");
            exit();
        }
    }
}

?>
<!-- =============================================================================================================================================================================== -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="login_signup.css">

</head>

<body>
    <!-- Header -->
    <?php include 'components/_header.php' ?>
    <!-- Alerts -->
    <?php
    if ($alertsuccess) {
        echo '<div class="alert alert-success alert-dismissible fade show w-100 text-center" role="alert">
                <strong>Successfull!</strong> You have successfully Sign Up.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        // header("Location: /php_heera/Project-4_Thread/index.php");
        // exit();
    }
    if ($alertfailed) {
        echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center" role="alert">
                    <strong>Failed!</strong> Password do not match. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
    if ($exists) {
        echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center" role="alert">
                    <strong>Failed!</strong> This email already exists. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
    ?>

    <main>
        <div class="container1">
            <div class="container2">
                <h2>SignUp to our website</h2>
                <div class="forms">
                    <form action='<?php $_SERVER['PHP_SELF'] ?>' method="POST">

                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="firstname" class="form-control" placeholder="First name" aria-label="First name" maxlength="50" required>
                            </div>
                            <div class="col">
                                <input type="text" name="lastname" class="form-control" placeholder="Last name" aria-label="Last name" maxlength="50">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" style="width: 100%" required>
                            <small>We'll never share your email with anyone else.</small>
                        </div>

                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="pass" style="width: 100%;" minlength="8" required>
                        </div>
                        <div class="mb-3">
                            <label for="cpass" class="form-label">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" id="cpass" style="width: 100%;" minlength="8" required>
                        </div>

                        <div class="mb-3">
                            <label for="profilePhoto" class="form-label">Upload Profile Photo</label>
                            <input type="file" name="profilePhoto" class="form-control" id="profilePhoto" disabled>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" style="font-size: small;" for="gridCheck">
                                I accept the <a class="text-decoration-none" href="">Terms of Use</a> and <a class="text-decoration-none" href="">Privacy Policy.</a>
                            </label>
                        </div>

                        <div class="buttons" style="display:flex; justify-content: space-between;">
                            <button type="submit" name="sub" style="padding:8px; border-radius:6px;">SignUp</button>
                            <a href="loginPage.php">Login</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>