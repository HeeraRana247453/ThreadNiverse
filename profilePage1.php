<?php 
    // Start output buffering at the very beginning of your script
    ob_start();
?>
<?php include "components/_dbconnect.php";
$userid = $_GET['user_id'];?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profilePage.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <div class="maincontainer container" style="display:flex; justify-content:space-around; align-items:center; flex-wrap:wrap; width:1500px; min-height: 74.1vh; padding-top:10vh; padding-bottom:10vh"> 

      <!-- LOWER PART IN CENTER LAYOUT
 --------------------------------------- -->
 <div class="lowerpart">
    <h2>About</h2>
    <?php
        // Check if the user is logged in and matches the current user
        if (isset($_SESSION['loggedin']) && $userid == $_SESSION['curr_user_id']) {
            // Display the about content and the Edit button
            echo '<p class="aboutcontent" id="aboutContent"></p>';
            echo '<p class="editbutton">
                    <button id="editBtn" class="btn btn-outline-primary rounded-5 px-2 py-1" onclick="enableEdit()">
                        <img width="23px" src="images/editicon.png"> Edit
                    </button>
                </p>';

            // Form to submit the updated content (hidden initially)
            echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" id="editForm" style="display:none;">
                    <textarea id="aboutTextarea" name="aboutuserupdate" rows="5" class="form-control">write updated about</textarea>
                    <button type="submit" name="save" class="btn btn-success mt-2">Save</button>
                </form>';
        } else {
            // If the user is not logged in or is viewing someone else's profile, just display the content
            echo '<p class="aboutcontent">Existing content</p>';
        }
    

        
// HANDLING PHP FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    // Debug: Check if the form data is being captured
    if (isset($_POST['aboutuserupdate'])) {
        $aboutuserupdate = $_POST['aboutuserupdate'];
        echo "<p>aboutuserupdate =". $aboutuserupdate."</p>";  // Debugging output
    } else {
        echo "<p>No content received!</p>";  // Debugging output in case the form is not captured
    }

    // Escape the content before updating
    $newAboutContent = mysqli_real_escape_string($conn, $aboutuserupdate);

    // Update the about content in the database
    $sql_update = "UPDATE `user_credentials` SET `aboutuser`='$newAboutContent' WHERE `user_id`='$userid'";
    $result_update = mysqli_query($conn, $sql_update);

    // header('Location: /php_heera/Project-4_Thread/Thread.php');
                    // exit();

    if (mysqli_affected_rows($conn) > 0) {
        echo "<p>Rows updated successfully!</p>";
    } else {
        echo "<p>No rows affected. Please check your query and input data.</p>";
    }
                    

    if ($result_update) {
        // Redirect to the same page after successful update
        echo '<div class="alert alert-success">successful to update the content. Please try again.</div>';
        // header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$_SESSION['curr_user_id']);
        // exit; // Stop further script execution after the redirect
    } else {
        echo '<div class="alert alert-danger">Failed to update the content. Please try again.</div>';
    }
}
?>
</div>

<!-- JavaScript to toggle edit mode -->
<script>
    function enableEdit() {
        // Hide the about content and edit button
        document.getElementById("aboutContent").style.display = "none";
        document.getElementById("editBtn").style.display = "none";

        // Show the textarea and submit button
        document.getElementById("editForm").style.display = "block";
    }
</script>
       
    
    </div>
    <?php include "components/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
// Send output to the browser
ob_end_flush();
?>