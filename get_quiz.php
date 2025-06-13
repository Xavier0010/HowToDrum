<?php
header('Content-Type: application/json');
require_once './db.php';

if (!isset($_GET['quiz_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing quiz_id']);
    exit;
}

$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

$sql = "SELECT question, option_a, option_b, option_c, option_d, answer FROM qna_table WHERE quiz_id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}
mysqli_stmt_bind_param($stmt, "i", $quiz_id);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute statement']);
    exit;
}
$result = mysqli_stmt_get_result($stmt);

$questions = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to get result']);
    exit;
}

echo json_encode($questions);