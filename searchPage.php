<?php 
    // Start output buffering at the very beginning of your script
    ob_start();
    $searched = true;
?>

<?php include "components/_dbconnect.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
    <link rel="stylesheet" href="searchPage.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <div class="container d-flex flex-column justify-content-start align-items-center mb-3 mb-sm-0" style="min-height: 74.1vh; padding-top:10vh; overflow:auto;"> 

        <form id="searching" action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" class="d-flex rounded-3" style="border:3px solid green; box-shadow:1px 1px 15px 3px yellowgreen;" role="search">
            <input name="search" class="form-control" style="border:none; box-shadow:none; opacity:0.5" type="search" placeholder="Search Your Question" aria-label="Search">
            <button class="btn btn-success rounded-0" type="submit"><img width="35px" class="mx-2" style="transform: scaleX(-1);" src="images/3d-magnifier.png"></button>
        </form>

        <div class="searchresults mt-5 w-100">
            <!-- Fetch Data from 'threadlist' table on 'Search Result' page -->
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search']) && !empty($_GET['search'])) 
                {
                    echo "<h2>Search Results</h2>";

                    $searchinput = $_GET['search'];
                    // $sql_2 = "SELECT * FROM `threadlist` WHERE `thread_cat_id`='$cat_id'";
                    $sql_2 = "SELECT * FROM `threadlist` WHERE MATCH (`thread_title`,`thread_desc`) AGAINST('$searchinput')
                                ORDER BY `thread_datetime` DESC";
                    $result = mysqli_query($conn,$sql_2);

                    $numrow = mysqli_num_rows($result);
                    if($numrow)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $searched = false;

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
                            $result3 = mysqli_query($conn,$sql_3);
                            $row3 = mysqli_fetch_assoc($result3);
                            $username = $row3['fname'];
                            $imageurl = $row3['image_url'];

                            echo'<div class="d-flex align-items-center my-3 p-2 rounded-3 shadow" style="border: 1px solid white; background-color:whitesmoke">
                                    <div class="flex-shrink-0">
                                        <img src="'.$imageurl.'" class="rounded-4" height="50" width="50" alt="...">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div style="display:flex; justify-content:space-between;"><h6 class="mt-0 text-primary">'.$username.'</h6> <b><small>'.$date_time.'</small></b> </div>
                                        <a href="thread.php?thread_id='.$thread_id.'" style="text-decoration:; color:black;"><h5>'.$title.'</h5></a>
                                    </div>
                                </div>';
                        }
                    }
                    else{
                        $searched = false;
                        echo'<div class="container-fluid d-flex justify-content-center flex-wrap align-items-center bg-opacity-50 p-3 p-sm-5 my-3 bg-body-tertiary rounded-3">
                                <div class="container">
                                <div class="text-start"><h1 class="display-4">No Results Found</h1><img src="images/error.png" height="240px" alt="loading.."></div>
                                    <p class="lead">Be the first person to ask a question</p>
                                    </div>
                            </div>';
                    }
                }

                if($searched)
                    {
                        echo'<div class="container-fluid bg-opacity-50 p-4 my-3 bg-body-tertiary rounded-3 ">
                                <div class="container d-flex-col">
                                    <h1 class="w-100 text-success text-center">Search Your Threads</h1>
                                    <div class="text-center"><img src="images/women-search-notebook.png" height="300px" alt="loading.."></div>
                                    
                                </div>
                            </div>';
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