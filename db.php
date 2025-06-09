<?php
    $conn = mysqli_connect("localhost", "root", "", "how_to_drum");

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>