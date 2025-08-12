<?php
    session_start();
    if( !isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
    {
        // header("Location: index.php");
    }
    else{
        session_unset();
        header("Location:../index.php");
        // exit();
    }
?>