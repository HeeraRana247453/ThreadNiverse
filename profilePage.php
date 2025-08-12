<?php
// Start output buffering at the very beginning of your script
ob_start();
?>
<?php include "components/_dbconnect.php";
$userid = $_GET['user_id'];
?>


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

    <div class="maincontainer container">
<!-- CENTER PART OF THE LAYOUT
 ============================================================= -->
<div class="centerpart">
<!-- UPPER PART IN THE CENTER LAYOUT
 =================================================-->
            <div class="upperpart">
                <?php
                    $sql_1 = "SELECT * FROM `user_credentials` WHERE `user_id`='$userid'";
                    $result1 = mysqli_query($conn, $sql_1);
                    $row1 = mysqli_fetch_assoc($result1);

                    // Check if the user is logged in and matches the current user
                    if (isset($_SESSION['loggedin']) && $userid == $_SESSION['curr_user_id']) {
                        echo '<div style="border:0px solid blue;">
                                <img id="profilephoto" style="box-shadow: 0px 0px 25px 0.5px black; border:5px solid skyblue;" class="rounded-circle" src="' . $row1['image_url'] . '" alt="loading..";>

                                <p class="username mt-3 mb-0" id="nameDisplay">' . $row1['fname'] . ' ' . $row1['lname'] . '
                                    <button id="editNameBtn" class="btn rounded-1 p-0 m-0" onclick="enableEditName()">
                                        <img width="23px" src="images/editicon.png">
                                    </button>
                                </p>

                                <!-- Hidden form to edit name -->
                                <form id="editNameForm" style="display:none;" method="POST" action="' . $_SERVER['PHP_SELF'] . '?user_id=' . $userid . '">
                                    <input type="text" name="fname" value="' . $row1['fname'] . '" class="form-control mt-3" placeholder="First Name" maxlength="50">
                                    <input type="text" name="lname" value="' . $row1['lname'] . '" class="form-control mt-2" placeholder="Last Name" maxlength="50">
                                    <button type="submit" name="updateName" class="btn btn-success mt-2">Update</button>
                                </form>

                            </div>';
                            
                    }else{
                        echo '<div style="border:0px solid blue;">
                                <img id="profilephoto" style="box-shadow: 0px 0px 25px 0.5px black; border:5px solid skyblue;" class="rounded-circle" src="' . $row1['image_url'] . '" alt="loading..";>
                                <p class="username mt-3 mb-0">' . $row1['fname'] . ' ' . $row1['lname'] . '</p>
                            </div>';
                    }
                ?>

                <!-- HANDLE EDIT NAME FORM PHP -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateName'])) {
                    $newFname = mysqli_real_escape_string($conn, $_POST['fname']);
                    $newLname = mysqli_real_escape_string($conn, $_POST['lname']);
                    $newFname = htmlspecialchars($newFname); // Prevent XSS attacks
                    $newLname = htmlspecialchars($newLname); // Prevent XSS attacks

                    // Update the user's first name and last name in the database
                    $sql_update = "UPDATE `user_credentials` SET `fname`='$newFname', `lname`='$newLname' WHERE `user_id`='$userid'";
                    $result_update = mysqli_query($conn, $sql_update);

                    if ($result_update) {
                        // Redirect to the same page after successful update
                        header("Location: " . $_SERVER['PHP_SELF'] . "?user_id=" . $userid);
                        exit;
                    } else {
                        echo '<div class="alert alert-danger">Failed to update the name. Please try again.</div>';
                    }
                }
                ?>

                <!-- JavaScript to toggle edit mode -->
                <script>
                    function enableEditName() {
                        document.getElementById("nameDisplay").style.display = "none";// Hide the about content
                        document.getElementById("editNameBtn").style.display = "none";// Hide the edit button
                        document.getElementById("editNameForm").style.display = "block";// Show the textarea and submit button
                    }
                </script>
            </div>

<!-- LOWER PART IN CENTER LAYOUT
 ============================================ -->
            <div class="lowerpart">
                <h2>About</h2>
                <?php
                // Check if the user is logged in and matches the current user
                if (isset($_SESSION['loggedin']) && $userid == $_SESSION['curr_user_id']) {
                    // Display the about content and the Edit button
                    echo '<p class="aboutcontent" id="aboutContent">' . $row1['aboutuser'] . '</p>';
                    echo '<p class="editbutton">
                            <button id="editAboutBtn" class="btn btn-outline-primary rounded-5 px-2 py-1" onclick="enableEditAbout()">
                                <img width="23px" src="images/editicon.png"> Edit
                            </button>
                        </p>';

                    // Form to submit the updated content (hidden initially)   //I have spent more than 6 hours in this problem due to action="'.$_SERVER['PHP_SELF'].'?user_id='.$userid.'"
                    echo '<form action="' . $_SERVER['PHP_SELF'] .'?user_id='.$userid.'" method="POST" id="editForm" style="display:none;"> 
                            <textarea id="aboutTextarea" name="aboutuserupdate" rows="5" class="form-control" maxlength="600">' . $row1['aboutuser'] . '</textarea>
                            <button type="submit" name="save" class="btn btn-success mt-2">Save</button>
                        </form>';
                } else {
                    // If the user is not logged in or is viewing someone else's profile, just display the content
                    echo '<p class="aboutcontent">' . $row1['aboutuser'] . '</p>';
                }


                // HANDLING EDIT ABOUT CONTENT PHP FORM SUBMISSION
                // --------------------------------------------------
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {

                    // Escape the content before updating
                    $newAboutContent = mysqli_real_escape_string($conn, $_POST['aboutuserupdate']);
                    $newAboutContent = htmlspecialchars($newAboutContent); // Prevent XSS attacks

                    // Update the about content in the database
                    $sql_update = "UPDATE `user_credentials` SET `aboutuser`='$newAboutContent' WHERE `user_id`='$userid'";
                    $result_update = mysqli_query($conn, $sql_update);

                    if ($result_update) {
                        // Redirect to the same page after successful update
                        header("Location: " . $_SERVER['PHP_SELF'] . "?user_id=" . $_SESSION['curr_user_id']);
                        exit; // Stop further script execution after the redirect
                    } else {
                        echo '<div class="alert alert-danger">Failed to update the content. Please try again.</div>';
                    }
                }
                ?>
            </div>

            <!-- JavaScript to toggle edit mode -->
            <script>
                function enableEditAbout() {
                    document.getElementById("aboutContent").style.display = "none";// Hide the about content
                    document.getElementById("editAboutBtn").style.display = "none";// Hide the edit button
                    document.getElementById("editForm").style.display = "block";// Show the textarea and submit button
                }
            </script>

</div>

<!-- SIDE PART IN THE LAYOUT
 ================================================================ -->
        <div class="sidepart">
            <!-- Fetch Data from 'threadlist' table on 'Profile' page in 'Thread Posted' section-->
            <?php
            if ($userid) {
                echo "<h2>Threads Posted</h2>";

                $sql_2 = "SELECT * FROM `threadlist` WHERE `thread_user_id`='$userid'
                                    ORDER BY `thread_datetime` DESC";
                $result2 = mysqli_query($conn, $sql_2);

                $numrow = mysqli_num_rows($result2);
                if ($numrow) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $noResultFound = false;

                        $thread_id = $row2['thread_id'];
                        // $title = $row['thread_title'];
                        // $description = $row['thread_desc'];

                        // When you fetch the data from the database, you can use nl2br() as follows to display spaces and newlines properly:
                        $title = $row2['thread_title'];
                        $description = nl2br($row2['thread_desc']); // Preserve newlines

                        $date_time = date("d-M-Y, h:i A", strtotime($row2['thread_datetime']));
                        $thread_user_id = $row2['thread_user_id'];


                        // Fetch the userdata of the thread using thread_user_id
                        $sql_3 = "SELECT * FROM `user_credentials` WHERE `user_id`='$thread_user_id';";
                        $result3 = mysqli_query($conn, $sql_3);
                        $row3 = mysqli_fetch_assoc($result3);
                        $username = $row3['fname'];
                        $imageurl = $row3['image_url'];

                        echo '<div class="threadbar d-flex align-items-center my-3 p-2 rounded-3 shadow" style="border: 1px solid white; background-color:whitesmoke">
                                    <div class="flex-shrink-0">
                                        <img src="' . $imageurl . '" class="rounded-4" height="50" width="50" alt="...">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div style="display:flex; justify-content:space-between;"><h6 class="mt-0 text-primary">' . $username . '</h6> <small style="display:inline-flex;">' . $date_time . '</small>';
                                    
                                        // Check if the logged-in user is the one who posted the thread
                                        if (isset($_SESSION['loggedin']) && $_SESSION['curr_user_id'] == $thread_user_id) {
                                            // Show delete button for the logged-in user who posted the thread
                                        echo'<p class="deletebutton m-0">
                                                <form action="" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this thread?\')">
                                                    <input type="hidden" name="thread_id" value="' . $thread_id . '">
                                                    <button type="submit" name="deleteThread" class="btn btn-outline-danger rounded-5 px-1 py-0 m-0">
                                                        <small class="deletetxt p-0" style="display:flex; align-content:center;"><img width="20px" src="images/deleteicon.png">delete</small>
                                                    </button>
                                                </form>
                                            </p>';}
                                        
                                        // Handle delete request
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteThread'])) {
                                            $thread_id_to_delete = $_POST['thread_id'];
                                            
                                            // Make sure the thread ID is valid
                                            if ($thread_id_to_delete) {
                                                $delete_sql = "DELETE FROM `threadlist` WHERE `thread_id` = $thread_id_to_delete AND `thread_user_id` = " . $_SESSION['curr_user_id'];
                                                $delete_result = mysqli_query($conn, $delete_sql);

                                                if ($delete_result) {
                                                    // Redirect to the same page after deletion
                                                    header("Location: " . $_SERVER['PHP_SELF'] . "?user_id=" . $_SESSION['curr_user_id']);
                                                    exit(); // Stop further script execution after the redirect
                                                } else {
                                                    echo '<div class="alert alert-danger">Failed to delete the thread. Please try again.</div>';
                                                }
                                            }
                                        }

                                echo'</div>
                                        <a href="thread.php?thread_id=' . $thread_id . '" style="text-decoration:; color:black;"><h5>' . $title . '</h5></a>
                                    </div>
                                </div>';
                    }
                } else {
                    echo '<div class="container-fluid bg-opacity-50 p-5 my-3 bg-body-tertiary rounded-3">
                                <div class="container">
                                    <h1 class="display-4">No Thread Posted yet</h1>
                                    <p class="lead">Be the first person to ask a question</p>
                                </div>
                            </div>';
                }
            }
            ?>
        </div>

    </div>
    <?php include "components/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
// Send output to the browser
ob_end_flush();
?>