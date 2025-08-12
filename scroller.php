<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* Horizontal scroll container */
        .horizontal-scroll-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 1rem;
        }

        .horizontal-scroll::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar */
        }

        .horizontal-scroll {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Card styling */
        .card {
            flex: 0 0 auto;
            width: 250px;
            height: 150px;
            background-color: #2c2939;
            color: white;
            text-align: center;
            line-height: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Scroll buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 2rem;
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
    </style>
</head>

<body>
    <div class="horizontal-scroll-wrapper">
        <button class="scroll-btn left" onclick="scrollToLeft()">&#10094;</button> <!-- Left scroll button -->

        <div class="horizontal-scroll" id="scroll-container">
            <!-- Cards go here -->
            <div class="card">Card 1</div>
            <div class="card">Card 2</div>
            <div class="card">Card 3</div>
            <div class="card">Card 4</div>
            <div class="card">Card 5</div>
        </div>

        <button class="scroll-btn right" onclick="scrollToRight()">&#10095;</button> <!-- Right scroll button -->
    </div>



    <script>
        const scrollContainer = document.getElementById("scroll-container");

        function scrollToLeft() {
            scrollContainer.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        }

        function scrollToRight() {
            scrollContainer.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        }
    </script>

</body>

</html>