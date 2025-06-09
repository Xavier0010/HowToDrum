<?php
header('Content-Type: application/json');
include('db.php');

if (isset($_GET['subtopic_id'])) {
    $subtopic_id = intval($_GET['subtopic_id']);
    $query = "SELECT * FROM subtopic_table WHERE subtopic_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $subtopic_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $subtopic = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'data' => $subtopic
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Subtopic not found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No subtopic ID provided'
    ]);
}
?>
