<?php
    $conn = mysqli_connect("localhost", "root", "", "how_to_drum");

    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
?>
