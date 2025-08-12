<!-- Connect to the Database -->
<?php
// Start output buffering at the very beginning of your script
ob_start();

$loginAlert = false;
$newThreadCreated = false;
include "components/_dbconnect.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="thread.css">
</head>

<body class="bg-body-tertiary">
    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <!-- Fetch Data from 'threadlist' on thread.php page -->
    <?php
    $thread_id = $_GET['thread_id'];
    $sql_1 = "SELECT * FROM `threadlist` WHERE `thread_id`=$thread_id;";
    $result = mysqli_query($conn, $sql_1);
    $row = mysqli_fetch_assoc($result);

    $thread_title = $row['thread_title'];
    $thread_desc = nl2br($row['thread_desc']); // nl2br will preserve Space and Line Break
    $date_time = date("d-M-Y , h:i A", strtotime($row['thread_datetime']));
    $thread_user_id = $row['thread_user_id'];

    // Fetch the userdata using thread_user_id
    $sql_3 = "SELECT * FROM `user_credentials` WHERE `user_id`='$thread_user_id';";
    $result3 = mysqli_query($conn, $sql_3);
    $row3 = mysqli_fetch_assoc($result3);
    $fname = $row3['fname'];
    $lname = $row3['lname'];
    // $imageurl = $row3['image_url'];
    ?>

    <main>
        <div id="jumbucard" class="container">
            <!-- Jumbotron -->
            <div class="container-fluid p-2 p-sm-5 my-5 rounded-3 shadow" style="border:0.5px solid #fc903efb; background-color: #fec192b6;">
                <h3 class="display-5 fw-bold" style="color: #cf5a01;"><?php echo $thread_title; ?></h3>
                <p class="col-md-12 fs-4 "><?php echo $thread_desc; ?></p>
                <hr>
                <p>Respectful communication is key, avoid hate speech, harassment, or personal attacks. Refrain from spamming, self-promotion, or off-topic posts. Ensure your contributions are relevant and meaningful to the discussion.</p>
                <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; ">
                    <?php echo '<a href="profilePage.php?user_id=' . $thread_user_id . '">
                        <button class="btn btn-outline-primary btn-lg btn-sm" type="button">' . $fname . ' ' . $lname . '</button>
                    </a>
                    <p style="margin-top: 6px;margin-bottom:0px;">
                    <b><small><img height="29px" src="images/schedule1.png"> ' . $date_time . '</small></b></p>' ?></div>
            </div>
        </div>

        <!-- 2) Jumbotron for New-Comments-->
        <?php
        // session_start(); //Already start in header.php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['newcommentbutton'])) {
            if (isset($_SESSION['loggedin'])) {
                $curr_user_id = $_SESSION['curr_user_id'];
                $newcomment = $_POST['newcomment'];

                $newcomment = mysqli_real_escape_string($conn, $newcomment); //It will escape the special character from the string or text to avoid the conflict
                // for e.g- when single quotes of the description text will cause the conflict with the single quotes of the query

                // $newcomment = str_replace("<","&lt",$newcomment);//It will protect from the XSS attack ( protect from executing the inserted code)
                // $newcomment = str_replace(">","&gt",$newcomment);  
                //OR
                $newcomment = htmlspecialchars($newcomment); // Prevent XSS attacks

                $sql_2 = "INSERT INTO `comments`(`comment_content`,`thread_id`,`comment_user_id`) VALUES('$newcomment','$thread_id','$curr_user_id');";
                $result = mysqli_query($conn, $sql_2);

                $_SESSION['newCommentPosted'] = true; //It will retain the value even after the redirection and help in display the success-Alert

                // Redirect the header to the location
                header('Location:thread.php?thread_id=' . $thread_id);
                exit();
            } else {
                $loginAlert = true;
            }
        }
        ?>
        <div class="container">
            <hr>
            <!-- Alerts -->
            <?php
            if ($loginAlert) {
                echo '<div class="alert alert-danger alert-dismissible fade show w-100 text-center m-0" role="alert">
                        <strong>Login!</strong> to post comments.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            if (isset($_SESSION['newCommentPosted']) && $_SESSION['newCommentPosted'] == true) {
                echo '<div class="alert alert-success alert-dismissible fade show w-100 text-center m-0" role="alert">
                        <strong>Successful!</strong> New comment posted successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                $_SESSION['newCommentPosted'] = false;
            }
            ?>
            <div class="container-fluid p-2 p-sm-5 my-5 rounded-3" style="background-color: #fec192b6;">
                <p style="font-size: 35px; padding-bottom:10px; color: #cf5a01;"><b>Post a Comment</b></p>
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="mb-3">
                        <textarea style="background-color:whitesmoke;" class="form-control form-control-lg" name="newcomment" type="text" placeholder="Write Your Comments" aria-label=".form-control-lg example" maxlength="3000" required></textarea>
                        <!-- <div id="newcomment" class="form-text">title should be as crisp as possible</div> -->
                    </div>
                    <button type="submit" name="newcommentbutton" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>


        <!-- 3) COMMENTS -->
        <div class="container">
            <b style="font-size: 35px;" class="text-body-secondary">Comments</b>

            <!-- Fetch Data from 'comments' table on thread page -->
            <?php


            $commentsPerPage = 8; // Set the number of threads to display per page
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number from the URL, default to 1 if not set
            $offset = ($page - 1) * $commentsPerPage;   // Calculate the offset for the SQL query

            // Fetch the total number of threads from the database
            $sql_3 = "SELECT COUNT(*) as total_comments FROM comments WHERE thread_id=$thread_id";
            $result_1 = mysqli_query($conn, $sql_3);
            $row_1 = mysqli_fetch_assoc($result_1);
            $totalComments = $row_1['total_comments'];

            // Calculate total number of pages
            $totalPages = ceil($totalComments / $commentsPerPage);


            $sql_2 = "SELECT * FROM `comments` WHERE `thread_id`='$thread_id'
                            ORDER BY `comment_datetime` DESC LIMIT $commentsPerPage OFFSET $offset";
            $result = mysqli_query($conn, $sql_2);
            $noResultFound = true;

            while ($row = mysqli_fetch_assoc($result)) {
                $noResultFound = false;

                // $thread_id = $row['thread_id'];

                // When you fetch the data from the database, you can use htmlspecialchars() and nl2br() as follows to display spaces and newlines properly:
                $comment_content = nl2br($row['comment_content']); // Preserve newlines and prevent XSS

                $date_time = date("d-M-Y , h:i A", strtotime($row['comment_datetime']));
                $comment_user_id = $row['comment_user_id'];

                // Fetch the userdata of the comment using comment_user_id
                $sql_3 = "SELECT * FROM `user_credentials` WHERE `user_id`='$comment_user_id';";
                $result3 = mysqli_query($conn, $sql_3);
                $row3 = mysqli_fetch_assoc($result3);
                $username = $row3['fname'];
                $imageurl = $row3['image_url'];

                echo '<div class="d-flex align-items-start my-3 p-2 rounded-3 shadow" style="border: 1px solid white; background-color: #fec192b6;">
                            
                            <div class="flex-shrink-0">
                                
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                <h6 class="mt-0 text-primary d-flex align-items-center">
                                    <img src="' . $imageurl . '" class="rounded-4 me-2" height="50" width="50" alt="...">
                                    <a href="profilePage.php?user_id=' . $comment_user_id . '">' . $username . '</a>
                                </h6> 
                                <b><small><img height="23px" src="images/schedule.png"> ' . $date_time . '</small></b> </div>
                                <hr class="mt-0">
                                <p style="font-size:1.1rem;  font-family:Cantarell, sans-serif;">' . $comment_content . '</p>
                            </div>
                        </div>';
            }

            // 4) If No Result Found in the threadlist
            if ($noResultFound) {
                echo '<div class="container-fluid p-3 p-sm-5 my-5 shadow rounded-3" style="background-color:#ffdd80d7;>
                            <div class="container">
                            <div class="text-start"><h1 class="display-4">No Comments Found</h1><img src="images/website.png" height="220px" alt="loading.."></div>
                                <p class="lead">Be the first person to post a comment</p>
                            </div>
                        </div>';
            }
            ?>

            <!--  Pagination  -->
            <!-- ============== -->
            <!-- <div class="pagination">
                <?php
                // // Display pagination links
                // if ($page > 1) {
                //     echo '<a href="thread.php?thread_id='.$thread_id.'&page=' . ($page - 1) . '">Previous</a>';
                // }

                // // Display individual page numbers
                // for ($i = 1; $i <= $totalPages; $i++) {
                //     if ($i == $page) {
                //         echo '<strong>' . $i . '</strong>';  // Highlight current page
                //     } else {
                //         echo '<a href="thread.php?thread_id='.$thread_id.'&page=' . $i . '">' . $i . '</a>';
                //     }
                // }

                // if ($page < $totalPages) {
                //     echo '<a href="thread.php?thread_id='.$thread_id.'&page=' . ($page + 1) . '">Next</a>';
                // }
                ?>
            </div> -->

            <div class="pagination">
                <?php
                // Display 'Previous' button
                if ($page > 1) {
                    echo '<a class="rounded-start" href="thread.php?thread_id=' . $thread_id . '&page=' . ($page - 1) . '">Prev</a>';
                }

                // Handle total pages less than 6 (no need for dots in these cases)
                if ($totalPages <= 5) {
                    // Display all page numbers
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        } else {
                            echo '<a href="thread.php?thread_id=' . $thread_id . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                } else {
                    // Display first 3 pages
                    for ($i = 1; $i <= 3; $i++) {
                        if ($i == $page) {
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        } else {
                            echo '<a href="thread.php?thread_id=' . $thread_id . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }

                    // Show dots if current page is not in the first 3
                    if ($page > 4) {
                        echo '...';
                    }

                    // Display middle page numbers (two pages before and after current page)
                    if ($page > 3 && $page < $totalPages - 2) {
                        for ($i = max(4, $page - 1); $i <= min($totalPages - 2, $page + 1); $i++) {
                            if ($i == $page) {
                                echo '<strong>' . $i . '</strong>';  // Highlight current page
                            } else {
                                echo '<a href="thread.php?thread_id=' . $thread_id . '&page=' . $i . '">' . $i . '</a>';
                            }
                        }
                    }

                    // Show dots if current page is not in the last 2 pages
                    if ($page < $totalPages - 2) {
                        echo '...';
                    }

                    // Display last 2 pages
                    for ($i = $totalPages - 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        } else {
                            echo '<a href="thread.php?thread_id=' . $thread_id . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                }

                // Display 'Next' button
                if ($page < $totalPages) {
                    echo '<a class="rounded-end" href="thread.php?thread_id=' . $thread_id . '&page=' . ($page + 1) . '">Next</a>';
                }
                ?>
            </div>



        </div>

    </main>
    <?php include "components/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Send output to the browser
ob_end_flush();
?>