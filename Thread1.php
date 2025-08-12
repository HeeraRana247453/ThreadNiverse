<!-- Connect to the Database -->
<?php 
    // Start output buffering at the very beginning of your script
    ob_start();
    include "components/_dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threadniverse</title>
    <link rel="icon" type="image/png" href="logo/logofile3/png/logo-no-background.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="thread.css">
    <style>

        .carousel img{height: 50vh;}
        .col .card a img{
                height: 220px;
            }
        @media (max-width: 810px)
        { 
            .carousel img{height: 30vh;}
        }
        @media (max-width: 575px){
            .col{
                width: 10rem;
                height: 6rem;
            }
            .col .card a img{
                height: 94px;
                border-radius: 1rem;
                box-shadow: 2px 2px 5px 2px gray;
            }
            .col .card{border:none;}
        }
    </style>
</head>

<body>
    <!-- Include header -->
    <?php include "components/_header.php" ?>
    <main>
        <div id="carouselExampleAutoplaying" class="carousel slide m-2 m-sm-4" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 rounded-sm-5">
                <div class="carousel-item active">
                <img src="images/img1.jpg"  class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="images/c4.jpg"  class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="images/img6.jpg"  class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container">

            <h2 class="text-center my-4" style="font-family: 'Merriweather', serif;color:green;"><u>Threads-Categories</u></h2>

            <div class="subcontainer">

                <div class="row d-flex justify-content-center row-cols-1 row-cols-md-3 g-4">            
                <!-- Iterate through the categories using while loop -->
                <?php 
                    $sql = "SELECT * FROM `categories`";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $date_time = date("d-M-Y, h:i A", strtotime($row['created']));
                        echo'<div class="col my-3">
                                <div class="card h-100">
                                    <a href="threadlist.php?catid='.$row['category_id'].'" style="text-decoration:none;">
                                        <img src="'.$row['image_url'].'" class="card-img-top bg-info-subtle" alt="...">
                                    </a>

                                    <div class="card-body d-none d-sm-block">
                                        <a href="threadlist.php?catid='.$row['category_id'].'" style="text-decoration:none;">
                                            <h5 class="card-title">'.$row['category_name'].'</h5>
                                        </a>
                                        <p class="card-text">'.$row['category_desc'].'</p>
                                    </div>  

                                    <a href="threadlist.php?catid='.$row['category_id'].'&page=1" style="text-decoration:none;" class="d-none d-sm-block">
                                        <div class="badge d-flex justify-content-start">
                                            <button type="button" class="btn btn-outline-primary position-relative">
                                                View Thread
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>
                                        </div>
                                    </a>

                                    <div class="card-footer d-none d-sm-flex justify-content-end">
                                        <small class="text-body-secondary"><img height="23px" src="images/schedule2.png"> Last Updated: '.$date_time.'</small>
                                    </div>

                                </div>
                            </div>';
                    }
                 ?>                 
                </div>
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