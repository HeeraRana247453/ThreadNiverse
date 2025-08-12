<?php 
    // Start output buffering at the very beginning of your script
    ob_start();

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


    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['loginbutton']))
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

<!--Login Modal -->
<!--Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-dark" id="loginModalLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Login form -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label text-dark">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="inputEmail3">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label text-dark">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword3">
                        </div>
                    </div>
                    <a href="" class="forget text-decoration-none text-body-secondary">Forget password ?</a>
                    <div class="submit d-flex justify-content-end">
                        <button type="submit" name="loginbutton" class="btn btn-success rounded-5">Login</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer d-flex justify-content-start py-1">
                <p class="newuser text-dark">New User?<a href="../signupPage.php">SignUp</a></p>
            </div>
        </div>
    </div>
</div>

  <!-- Alert -->
  <?php 
    if($alertsuccess){
    echo '<div class="alert alert-success alert-dismissible fade show w-100 text-center" role="alert">
            <strong>Successfull!</strong> Login successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($alertfailed){
        echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center" role="alert">
                <strong>Failed!</strong> Credentials do not match. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
  ?>

  <?php
    // Send output to the browser
    ob_end_flush();
?>