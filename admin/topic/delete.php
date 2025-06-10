<?php

if (isset($_GET['topic_id'])) {
    include '../../db.php';
    $topic_id = (int)$_GET['topic_id'];

    $stmt = $conn->prepare("DELETE FROM topic_table WHERE topic_id = ?");
    $stmt->bind_param("i", $topic_id);
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
    echo "Error: topic_id parameter not set.";
}

?>