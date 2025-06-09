<?php
include 'db.php';

$topic_title = [];
$topic_description = [];

$topicQuery = "SELECT * FROM topic_table";
$topicResult = mysqli_query($conn, $topicQuery);

if ($topicResult && mysqli_num_rows($topicResult) > 0) {
    while ($row = mysqli_fetch_assoc($topicResult)) {
        $topic_id[$row['topic_id']] = $row['topic_id'];
        $topic_title[$row['topic_id']] = $row['title'];
        $topic_description[$row['topic_id']] = $row['description'];
    }
}
?>