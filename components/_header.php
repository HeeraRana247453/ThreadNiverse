<header>

<style>
    /* .navbar-brand{
        font-size:29px; 
        font-weight: 500;
        color:yellowgreen;
        text-shadow: 1px 1px 1px black;
    } */
    .nav-link {
    /* color: white !important; */
    color: blue !important;
    }
    .nav-link.active {
        color:  violet !important;
    }
</style>

    <nav class="navbar navbar-expand-lg navbar-primary bg-success-subtle shadow pt-0 pb-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" style="font-size: 29px; color:yellowgreen; text-shadow:1px 1px 1px black;"><img src="logo/logofile3/png/logo-no-background.png" alt="Logo" width="55px" height="55px" class="d-inline-block align-text-center">ThreadNiverse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-underline me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Blogs
                </a>
                <ul class="dropdown-menu" data-bs-theme="dark" data-bs-popper="static">
                <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                    <span class="d-inline-block bg-warning rounded-circle p-1"></span>Development
                </a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                    <span class="d-inline-block bg-success rounded-circle p-1"></span>DSA
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                    <span class="d-inline-block bg-danger rounded-circle p-1"></span>Interview Experiences
                </a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="contactUs.php" >Contact Us</a>
                </li>
            </ul>
            <div class="d-flex ">
                <form action="searchPage.php" method="GET" class="d-flex" role="search">
                    <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                </form>
                <form class="d-flex" action="components/logout.php" method="POST" class="d-flex">
                        <a href="searchPage.php?search="><img width="38px" class="mr-3" style="transform: scaleX(-1);" src="images/3d-magnifier.png"></a>
                    <?php
                        session_start();
                        if(!isset($_SESSION['loggedin']))
                        {
                        echo'<button data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-outline-primary mx-2" type="button">Login</button>
                            <a href="signupPage.php"><button class="btn btn-outline-primary ml-2"  type="button">SignUp</button></a>';
                        }
                        else{
                            // echo'<button class="btn btn-warning mx-2 p-0 d-flex justify-content-center align-items-center" type="button"><img class="rounded-1  me-2" src="'.$_SESSION['image_url'].'" width="40px" height="40px" alt="loading..";><p class="m-0 pe-2">'.$_SESSION['username'].'</p></button>
                            //     <button class="btn btn-outline-danger ml-2" type="submit">Logout</button>';
                            echo '<div class="dropdown text-end">
                                <button class="btn btn-success mx-2 ps-0 pe-1.5 py-0 d-flex justify-content-center align-items-center  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                                    <img class="rounded-1  me-2" src="'.$_SESSION['image_url'].'" width="40px" height="40px" alt="loading..";><p class="m-0 pe-2">'.$_SESSION['username'].'</p>
                                    </button>
                                    <ul class="dropdown-menu text-small " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 34px);" data-popper-placement="bottom-end">
                                    <li><a class="dropdown-item" href="profilePage.php?user_id='.$_SESSION['curr_user_id'].'">Profile</a></li>
                                        <li><a class="dropdown-item" href="#">Your Blogs</a></li>
                                        <li><a class="dropdown-item" href="#">Settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="components/logout.php">Sign out</a></li>
                                    </ul>
                            </div>';
                        }
                    ?>
                </form>
            </div>
            </div>
        </div>
    </nav>
    <?php include "_searchmodal.php" ?>
    <?php include "_loginmodal.php" ?>
    <script>
        // Get the full URL path from window.location.pathname
        const fullPath = window.location.pathname;
        // Extract only the last part of the path (index.php)
        const currentFile = fullPath.substring(fullPath.lastIndexOf('/') + 1);
        console.log(currentFile); // This will log 'index.php'

        const navLinks = document.querySelectorAll('.nav-link');// Select all the nav links
        // Loop through each nav link
        navLinks.forEach(link => {
            // If the href attribute matches the current URL path
            if (link.getAttribute('href') === currentFile) {
                link.classList.add('active');   // Add the 'active' class to the corresponding link
                link.setAttribute('aria-current', 'page'); // Set aria-current to "page"
            }else {
                link.removeAttribute('aria-current');   // Remove aria-current from non-active links, in case it's set
            }
        });
    </script>
</header>