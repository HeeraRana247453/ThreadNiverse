<!-- Connect to the Database -->
<?php
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
        body{
            background-color: #15141d;
            color: white;
        }

        .carousel img {
            height: 50vh;
        }

        .col .card a img {
            height: 220px;
            object-fit: cover;
        }

        @media (max-width: 810px) {
            .carousel img {
                height: 30vh;
            }
        }


        /* Card styling 
        ================*/
        .card {
            margin-left: 10px;
            min-width: 100%;
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;

            background-color: #2c2939;
            color: white;

            /* box-shadow: 1px 1px 15px 1px #060408; */
            box-shadow: 1px 1px 15px 1px gray;

            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-footer{
            color: gray;
        }

        /* Hover effect */
        .card:hover {
            transform: scale(1.05); /* Slightly increase the size */
            /* box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); Add a more prominent shadow */
            box-shadow: 1px 1px 15px 1px lightgreen;
        }

        /* Hover effect for card image */
        .card:hover .card-img-top {
            filter: brightness(1.1); /* Slightly brighten the image */
            transition: filter 0.3s ease;
        }

        /* Optional: Style text when hovering */
        .card:hover .card-title, 
        .card:hover .card-text {
            color: #28a745; /* Change text color on hover */
            transition: color 0.3s ease;
        }
        .card:hover .card-footer{
            color: lightskyblue;
            color: lightgreen;
        }

        .card-body,
        .card-footer,
        .badge,
        .card-title,
        .card-text {
            display: block;
        }

        .card-body {
            padding: 10px;
        }

        .card-text {
            font-size: 14px;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .card-footer{
            background-color: #1c1a27;
        }




        /* Horizontal scroll container
================================================= */
        .horizontal-scroll-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        /* Horizontal scrolling styles for categories */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .horizontal-scroll .col {
            margin-left: 15px;
            flex: 0 0 auto;
            width: 310px;
            /* Adjust the width to fit more nicely on larger screens */

        }

        /* Hide the default scrollbar */
        .horizontal-scroll::-webkit-scrollbar {
            display: none;
        }

        .horizontal-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
            width: 1556px;

            /* background-color: lightcoral; */
        }

        /* Scroll buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 1rem;
            padding: 10px;
            cursor: pointer;
            z-index: 1;
        }

        .scroll-btn.left {
            left: 0;
        }

        .scroll-btn.right {
            right: 0;
        }


        @media (min-width: 1400px) {
        .container,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl,
        .container-xxl {
            max-width: 1580px;
        }
        }

        /* Hide elements on small devices (below 811px) */
        @media (max-width: 810px) {

        .card-body,
        .card-footer,
        .badge,
        .card-title,
        .card-text {
            display: none;
        }

        .horizontal-scroll .col {
            width: 250px;
        }
        }

        @media (max-width: 576px) {
        .horizontal-scroll .col {
            width: 150px;
        }

        .card-text {
            font-size: 12px;
            height: 30px;
            -webkit-line-clamp: 1;
            /* Show only 1 line of description on very small screens */
        }

        .col .card a img {
            height: 128px;
        }

        .scroll-btn{
            font-size: 1rem;
            padding: 4px;
        }

        .horizontal-scroll .col {
        margin-left: 0px;
        }
        }
        
    </style>
</head>

<body>
    <!-- Include header -->
    <?php include "components/_header.php" ?>

    <main>
        <!-- Carousel Section -->
        <div id="carouselExampleAutoplaying" class="carousel slide m-2 m-sm-4" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 rounded-sm-5">
                <div class="carousel-item active">
                    <img src="images/img1.jpg" class="d-block w-100" alt='loading.'>
                </div>
                <div class="carousel-item">
                    <img src="images/c4.jpg" class="d-block w-100" alt="loading.">
                </div>
                <div class="carousel-item">
                    <img src="images/img6.jpg" class="d-block w-100" alt="loading.">
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

        <!-- Categories Section -->
        <div class="container">
            <h2 class="text-center my-4" style="text-shadow:1px 1px 1px lightgreen; color:green;"><u>Threads-Categories</u></h2>
            <?php
            $arr = array('Programming', 'Development', 'Database', 'Data Structure & Algorithm', 'Operating System');
            foreach ($arr as $parent_category) {
                echo '<h2>' . $parent_category . '</h2>';
                echo '<div class="horizontal-scroll-wrapper">';
                echo '<button class="scroll-btn left" onclick="scrollToLeft(this)">&#10094;</button>';
                echo '<div class="horizontal-scroll scroll-container">';
                
                // <!-- Iterate through the categories using while loop -->
                $sql = "SELECT * FROM `categories` WHERE `p_category`='$parent_category'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $date_time = date("d-M-Y, h:i A", strtotime($row['created']));
                    echo '
                        <div class="col my-3">
                            <div class="card h-100">
                                <a href="threadlist.php?catid=' . $row['category_id'] . '" style="text-decoration:none;">
                                    <img src="' . $row['image_url'] . '" class="card-img-top bg-info-subtle" alt="...">
                                </a>
                                <div class="card-body">
                                    <a href="threadlist.php?catid=' . $row['category_id'] . '" style="text-decoration:none;">
                                        <h5 class="card-title">' . $row['category_name'] . '</h5>
                                    </a>
                                    <p class="card-text">' . $row['category_desc'] . '</p>
                                </div>
                                <a href="threadlist.php?catid=' . $row['category_id'] . '&page=1" style="text-decoration:none;" class="d-none d-sm-block">
                                    <div class="badge d-flex justify-content-start">
                                        <button type="button" class="btn btn-outline-success position-relative pt-1 pb-1 pl-2 pr-2">
                                            View Thread
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                99+
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>
                                    </div>
                                </a>
                                <div class="card-footer d-none d-sm-flex justify-content-end">
                                    <small class=""><img height="23px" src="images/schedule.png"> Last Updated: ' . $date_time . '</small>
                                </div>
                            </div>
                        </div>';
                }
                echo '</div>'; // Close horizontal-scroll div
                echo '<button class="scroll-btn right" onclick="scrollToRight(this)">&#10095;</button>';
                echo '</div>'; // Close horizontal-scroll-wrapper div
            }
            ?>
        </div>

    </main>

    <!-- Include footer -->
    <?php include "components/_footer.php" ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function scrollToLeft(button) {
    const scrollContainer = button.parentElement.querySelector('.scroll-container');
    scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
}

function scrollToRight(button) {
    const scrollContainer = button.parentElement.querySelector('.scroll-container');
    scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
}

    </script>
</body>

</html>

<?php
ob_end_flush();
?>