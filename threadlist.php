<!-- Connect to the Database -->
<?php
// Start output buffering at the very beginning of your script
ob_start();

$loginAlert = false;
$newThreadCreated = false;
include "components/_dbconnect.php"
?>

<!-- Fetch Data from categories on threadlist page -->
<?php
$cat_id = $_GET['catid'];
$sql_1 = "SELECT * FROM `categories` WHERE `category_id`=$cat_id;";
$result = mysqli_query($conn, $sql_1);
$row = mysqli_fetch_assoc($result);

$cat_name = $row['category_name'];
$cat_desc = $row['category_desc'];
?>

<!-- ============================================================================================================================================================================================================ -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="thread.css">
</head>

<body class="bg-body-tertiary">
    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <main>
        <div class="container">
            <!-- 1) Jumbotron for category-->
            <div class="container-fluid p-2 p-sm-5 my-5 rounded-3 shadow" style=" background-color: #c7bbffbb;">
                <h1 class="display-5 fw-bold" style="color:blueviolet;"><?php echo $cat_name; ?></h1>
                <p class="col-md-10 fs-4"><?php echo $cat_desc; ?></p>
                <hr>
                <p>Respectful communication is key, avoid hate speech, harassment, or personal attacks. Refrain from spamming, self-promotion, or off-topic posts. Ensure your contributions are relevant and meaningful to the discussion.</p>
                <a class="d-flex justify-content-end text-decoration-none me-2" href=""><button class="btn btn-outline-primary btn-lg btn-sm" type="button">Read More</button></a>
            </div>
        </div>

        <!-- 2) Jumbotron for New-Thread-Creation-->
        <?php
        // session_start(); //Already start in header.php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['newthreadbutton'])) {
            if (isset($_SESSION['loggedin'])) {
                $curr_user_id = $_SESSION['curr_user_id'];
                $newtitle = $_POST['newtitle'];
                $newdesc = $_POST['newdesc'];

                $newtitle = mysqli_real_escape_string($conn, $newtitle);
                $newdesc = mysqli_real_escape_string($conn, $newdesc); //It will escape the special character from the string or text to avoid the conflict
                // for e.g- when single quotes of the description text will cause the conflict with the single quotes of the query

                // $newtitle = str_replace("<","&lt",$newtitle);//It will protect from the XSS attack ( protect from executing the inserted code)
                // $newtitle = str_replace(">","&gt",$newtitle);
                // $newdesc = str_replace("<","&lt",$newdesc);//It will protect from the XSS attack ( protect from executing the inserted code)
                // $newdesc = str_replace(">","&gt",$newdesc);
                //OR
                $newtitle = htmlspecialchars($newtitle); // Prevent XSS attacks
                $newdesc = htmlspecialchars($newdesc); // Prevent XSS attacks


                $sql_2 = "INSERT INTO `threadlist`(`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`) VALUES('$newtitle','$newdesc','$cat_id','$curr_user_id');";
                $result = mysqli_query($conn, $sql_2);

                $_SESSION['newThreadCreated'] = true; //It will retain the value even after the redirection and help in display the success-Alert

                // Redirect the header to the location
                header('Location:threadlist.php?catid=' . $cat_id);
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
                        <strong>Login!</strong> to create new thread.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            if (isset($_SESSION['newThreadCreated']) && $_SESSION['newThreadCreated'] == true) {
                echo '<div class="alert alert-success alert-dismissible fade show w-100 text-center m-0" role="alert">
                        <strong>Successful!</strong> New thread created successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                $_SESSION['newThreadCreated'] = false;
            }
            ?>
            <div class="container-fluid p-1 p-sm-5 my-5 rounded-3" style="background-color: #c7bbffbb;">
                <p style="font-size: 35px; padding-bottom:10px; color:blueviolet;"><b>Create new thread</b></p>
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="mb-3">
                        <input class="form-control form-control-lg" name="newtitle" type="text" placeholder="Thread Title" aria-label=".form-control-lg example" required>
                        <div id="threadtitle" class="form-text">title should be as crisp as possible</div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="newdesc" id="exampleFormControlTextarea1" placeholder="Thread Description" rows="3" maxlength="1700" required></textarea>
                    </div>
                    <button type="submit" name="newthreadbutton" class="btn btn-success">Submit</button>
                </form>
            </div>

        </div>


        <!-- 3) Browse Questions -->
        <div class="container">
            <b style="font-size: 35px;">Browse Questions</b>

            <!-- Fetch Data from 'threadlist' table on threadlist page -->
            <?php

            $threadsPerPage = 2; // Set the number of threads to display per page
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number from the URL, default to 1 if not set
            $offset = ($page - 1) * $threadsPerPage;   // Calculate the offset for the SQL query

            // Fetch the total number of threads from the database
            $sql_3 = "SELECT COUNT(*) as total_threads FROM threadlist WHERE `thread_cat_id` = '$cat_id'";
            $result_1 = mysqli_query($conn, $sql_3);
            $row_1 = mysqli_fetch_assoc($result_1);
            $totalThreads = $row_1['total_threads'];

            // Calculate total number of pages
            $totalPages = ceil($totalThreads / $threadsPerPage);

            // Fetch the threads for the current page using LIMIT and OFFSET
            $sql_4 = "SELECT * FROM `threadlist` WHERE `thread_cat_id` = '$cat_id' 
                            ORDER BY `thread_datetime` DESC LIMIT $threadsPerPage OFFSET $offset";
            $result_2 = mysqli_query($conn, $sql_4);

            $noResultFound = true;

            while ($row = mysqli_fetch_assoc($result_2)) {
                $noResultFound = false;

                $thread_id = $row['thread_id'];
                // $title = $row['thread_title'];
                // $description = $row['thread_desc'];

                // When you fetch the data from the database, you can use nl2br() as follows to display spaces and newlines properly:
                $title = $row['thread_title'];
                $description = nl2br($row['thread_desc']); // Preserve newlines

                $date_time = date("d-M-Y , h:i A", strtotime($row['thread_datetime']));
                $thread_user_id = $row['thread_user_id'];

                // Fetch the userdata of the thread using thread_user_id
                $sql_3 = "SELECT * FROM `user_credentials` WHERE `user_id`='$thread_user_id';";
                $result3 = mysqli_query($conn, $sql_3);
                $row3 = mysqli_fetch_assoc($result3);
                $username = $row3['fname'];
                $imageurl = $row3['image_url'];

                echo '<div class="d-flex align-items-center my-3 p-2 rounded-3 shadow" style="border: 1px solid white; background-color: #c7bbffbb;">
                                <div class="flex-shrink-0">
                                    <img src="' . $imageurl . '" class="rounded-4" height="50" width="50" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div style="display:flex; justify-content:space-between;"><h6 class="mt-0 text-primary"><a href="profilePage.php?user_id=' . $thread_user_id . '">' . $username . '</a></h6> 
                                    <b><small><img height="23px" src="images/schedule1.png">' . $date_time . '</small></b> </div>
                                    <a href="thread.php?thread_id=' . $thread_id . '&page=1" style="text-decoration:; color:black;"><h5>' . $title . '</h5></a>
                                </div>
                            </div>';
            }

            // 4) If No Result Found in the threadlist
            if ($noResultFound) {
                echo '<div class="container-fluid p-5 my-5 rounded-3 shadow" style="background-color:#ffdd80d7;">
                                <div class="text-start"><h1 class="display-4">No Threads Found</h1><img src="images/website.png" height="220px" alt="loading.."></div>
                                <p class="lead">Be the first person to post a question</p>
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
                //     echo '<a href="threadlist.php?catid='.$cat_id.'&page=' . ($page - 1) . '">Previous</a>';
                // }

                // // Display individual page numbers
                // for ($i = 1; $i <= $totalPages; $i++) {
                //     if ($i == $page) {
                //         echo '<strong>' . $i . '</strong>';  // Highlight current page
                //     } else {
                //         echo '<a href="threadlist.php?catid='.$cat_id.'&page=' . $i . '">' . $i . '</a>';
                //     }
                // }

                // if ($page < $totalPages) {
                //     echo '<a href="threadlist.php?catid='.$cat_id.'&page=' . ($page + 1) . '">Next</a>';
                // }
                ?>
            </div> -->

            <div class="pagination">
                <?php
                // Display 'Previous' button
                if ($page > 1) {
                    echo '<a class="rounded-start" href="threadlist.php?catid=' . $cat_id . '&page=' . ($page - 1) . '">Prev</a>';
                }

                // Handle total pages less than 6 (no need for dots in these cases)
                if ($totalPages <= 5) {
                    // Display all page numbers
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page)
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        else
                            echo '<a href="threadlist.php?catid=' . $cat_id . '&page=' . $i . '">' . $i . '</a>';
                    }
                } else {
                    // Display first 3 pages
                    for ($i = 1; $i <= 3; $i++) {
                        if ($i == $page)
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        else
                            echo '<a href="threadlist.php?catid=' . $cat_id . '&page=' . $i . '">' . $i . '</a>';
                    }

                    // Show dots if current page is not in the first 3
                    if ($page > 4)
                        echo '...';

                    // Display middle page numbers (two pages before and after current page)
                    if ($page > 3 && $page < $totalPages - 2) {
                        for ($i = max(4, $page - 1); $i <= min($totalPages - 2, $page + 1); $i++) {
                            if ($i == $page)
                                echo '<strong>' . $i . '</strong>';  // Highlight current page
                            else
                                echo '<a href="threadlist.php?catid=' . $cat_id . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }

                    // Show dots if current page is not in the last 2 pages
                    if ($page < $totalPages - 2)
                        echo '...';

                    // Display last 2 pages
                    for ($i = $totalPages - 1; $i <= $totalPages; $i++) {
                        if ($i == $page)
                            echo '<strong>' . $i . '</strong>';  // Highlight current page
                        else
                            echo '<a href="threadlist.php?catid=' . $cat_id . '&page=' . $i . '">' . $i . '</a>';
                    }
                }

                // Display 'Next' button
                if ($page < $totalPages) {
                    echo '<a class="rounded-end" href="threadlist.php?catid=' . $cat_id . '&page=' . ($page + 1) . '">Next</a>';
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