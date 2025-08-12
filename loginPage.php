<?php 

    $alertsuccess = false;
    $alertfailed = false;

// Custom error handler
//     function customErrorHandler($errno, $errstr, $errfile, $errline) {
//         // Log the error message for debugging
//         error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, 'errors.log');

//         // Show a custom error message to the user
//         echo "<div style='color: red; text-align:center; font-weight: bold; padding: 13px; border: 1px solid red; border-radius:6px; background-color: #fdd;'>
//             We're experiencing some technical issues. <p>Please try again later.</p>
//             <a href='contact.php'>Contact Support</a> if the problem persists.
//             </div>";
//         exit();
//     }
// // Set the custom error handler
//     set_error_handler("customErrorHandler");


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //Connect to the Database 
        include "components/_dbconnect.php";

        $emailid = $_POST['email'];
        $password = $_POST['password'];

        // It will check that email already exist or not
        $sql = "SELECT * FROM `user_credentials` WHERE `email`='$emailid'; "; //Email is a UNIQUE attribute
        $result = mysqli_query($conn,$sql);
        $rownum = mysqli_num_rows($result);//no. of rows found

        if($rownum == 1)
        {
            // Fetch the associative array of the first result
           $row = mysqli_fetch_assoc($result);

           if(password_verify($password, $row["pass"]))//if encrypted password verify
            {
                $alertsuccess = true;
    
                // Access the first name using the column name
                $fname = $row['fname']; 
                $lname = $row['lname'];
                $aboutuser = $row['aboutuser'];
                $email = $row['email'];
                $image_url = $row['image_url'];
                $user_id = $row['user_id'];
    
                // Start a Session
                // session_start(); //already started in header.php
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = "$fname";
                $_SESSION['fullname'] = "$fname $lname";
                $_SESSION['aboutuser'] = "$aboutuser";
                $_SESSION['email'] = $email;
                $_SESSION['image_url'] = $image_url;
                $_SESSION['curr_user_id'] = $user_id;
                $_SESSION['newThreadCreated'] = false;
                $_SESSION['newCommentPosted'] = false;

                header("Location:../index.php");
                exit();
            }
            else{
                $alertfailed = true;  
            }
        }
        else{
            $alertfailed = true;
        }
    }


 ?>
<!-- ============================================================================================================================================================================ -->
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
     <?php require 'components/_header.php' ?>
     <!-- Alert -->
     <?php 
        if($alertsuccess){
        echo '<div class="alert alert-success alert-dismissible fade show w-100 text-center" role="alert">
                <strong>Successfull!</strong> Login successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            // header("Location: Thread.php");
                // exit();
        }
        if($alertfailed){
            echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center" role="alert">
                    <strong>Failed!</strong> Credentials do not match. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
      ?>
     
    <main>
        <div class="container1">
            <div class="container2">
                <h2>Login to our website</h2>
                <div class="forms">
                    <form action='<?php $_SERVER['PHP_SELF'] ?>' method="POST">

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" style="width: 100%" required>
                        </div>

                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="pass" style="width: 100%;" required>
                        </div>
                        
                        <div class="buttons" style="display:flex; justify-content: space-between;">
                            <button type = "submit" name = "sub" style="padding:8px; border-radius:6px;">Login</button>
                            <a href="signupPage.php">SignUp</a>
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