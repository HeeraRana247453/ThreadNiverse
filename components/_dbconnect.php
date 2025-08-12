<?php  

    $servername = "sql202.infinityfree.com";
    $username = "if0_37994441";
    $password = "RsbYySgTsUUqe";
    $database = "if0_37994441_threadni";

    $conn = mysqli_connect($servername,$username,$password,$database);
    if(!$conn)
        die("Failed to connect to the database: " . mysqli_connect_error());
    else
        // echo"<br> Connection Successfull";
        
?>