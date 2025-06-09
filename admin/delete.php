<?php

if (isset($_GET['user_id'])) {
    include '../db.php';
    $user_id = (int)$_GET['user_id'];

    $stmt = $conn->prepare("DELETE FROM user_table WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Record deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: ../admin/');
    exit;
} else {
    echo "Error: user_id parameter not set.";
}

?>