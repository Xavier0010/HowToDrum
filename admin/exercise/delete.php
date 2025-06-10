<?php

if (isset($_GET['exercise_Id'])) {
    include '../../db.php';
    $exercise_Id = (int)$_GET['exercise_Id'];

    $stmt = $conn->prepare("DELETE FROM exercise_table WHERE exercise_Id = ?");
    $stmt->bind_param("i", $exercise_Id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Record deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: ./');
    exit;
} else {
    echo "Error: exercise_Id parameter not set.";
}

?>