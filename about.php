<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us - Programming Forum</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="about.css">
</head>
<body>
   <!-- Include header -->
   <?php include "components/_header.php" ?>

    <section class="about-story">
        <h1>The Story Behind Our Forum</h1>
        <p class="description">Connecting programmers with a community to solve all the challenges related to programming, Develoments, Networking, Management, etc.</p>

        <div class="team">
            <div class="team-member">
                <img src="https://res.cloudinary.com/dmvmebkrr/image/upload/v1726942352/edfdj0ohbh0gfhauknaw.jpg" alt="loading..">
                <h2>Harshika Tomer</h2>
                <p>Founder & CEO</p>
                <p>Enthusiastic about creating a community where programmers help each other grow.</p>
            </div>
            <div class="team-member">
                <img src="https://res.cloudinary.com/dmvmebkrr/image/upload/v1726931132/dxljwkyvyv3m4uvkwkxr.jpg" alt="loading..">
                <h2>Heera Rana</h2>
                <p>Co-Founder & CTO</p>
                <p>Expert in building scalable platforms to foster knowledge sharing.</p>
            </div>
        </div>
    </section>

    <!-- <section class="why-we-started">
        <h2>Why Did We Start This Forum?</h2>
        <p>If you're passionate about programming, you know the importance of solving coding challenges. With the growth of remote collaboration, we wanted to create a space where programmers could connect, share knowledge, and help each other grow.</p>
        <p>Most coding forums lack the personalized experience needed to foster genuine learning. That's why we built this platform—to make programming collaboration easier and more rewarding for everyone.</p>
        <p class="highlight">Join us and be a part of a thriving coding community.</p>
    </section> -->

    <!-- continue-about-story section -->
    <section class="continue-about-story py-5">
        <div class="container">
            <h2 class="text-center">Our Vision and Journey</h2>
            <div class="content-wrapper">
                <img height="250px" width="400px" src="images/startup.png" alt="Forum Startup" class="float-left ">
                <p class="mt-4">
                    What started as a small idea has now grown into a thriving online space where programmers from around the world come to connect, learn, and grow together. At the heart of our platform lies the belief that collaboration and knowledge sharing are the key to solving complex coding problems.
                </p>
                <p>
                    Our mission is to empower developers by creating a space that encourages open dialogue and the free flow of ideas. We understand the challenges faced by coders at every level—whether you're just starting out or you're an experienced developer working on large-scale projects.
                </p>
            </div>
            
            <div class="content-wrapper mt-4">
                <p>
                    Over the years, we've seen countless success stories unfold in our community. From beginners who found their footing in the world of programming to seasoned developers who solved challenging issues with the help of their peers—our forum has played a pivotal role in shaping the journeys of many. 
                </p>
                <img height="250px" width="400px" src="images/meeting-team.png" alt="Programmers Working Together" class="float-right ">
                <p>
                    We take pride in fostering an environment where users feel comfortable asking questions and providing answers. Collaboration is the key to success, and our community continues to grow stronger with every interaction.
                </p>
            </div>

            <div class="content-wrapper mt-4">
                <p>
                    As technology evolves, so does our forum. We are continuously innovating and adding new features to improve the user experience. From improving search algorithms to enhancing content discovery, we are committed to staying at the forefront of community-driven learning. In the future, we plan to expand our reach even further, offering more specialized channels for different programming languages and tools.
                </p>
                <img height="250px" width="400px" src="images/ai-generated-work.png" alt="Technology Evolution" class="float-left ">
                <p>
                    Thank you for being a part of this journey. Your contributions, whether big or small, help make this forum the vibrant, supportive space that it is today. Together, we’re building a future where knowledge is accessible, and learning never stops.
                </p>
            </div>
        </div>
    </section>


    <?php include "components/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
