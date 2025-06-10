<?php
include('../../db.php');
session_start();
$isLoggedIn = isset($_SESSION['user']);

if (!isset($_SESSION['user'])) {
    header("Location: ../../");
    exit;
}

$user = $_SESSION['user'];

// Get current user data
$userQuery = "SELECT * FROM user_table WHERE username = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $user);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult->num_rows === 0) {
    header("Location: ../");
    exit;
}

$userData = $userResult->fetch_assoc();
$status = $userData['status'];

// Redirect if not admin
if ($status !== 'admin') {
    header("Location: ../../");
    exit;
}

$type = $_GET['type'] ?? '';
$value = $_GET['value'] ?? '';

$sql = "SELECT * FROM exercise_table";
$params = [];
$types = "";

if (!empty($type) && !empty($value)) {
    switch ($type) {
        case 'exercise_Id':
            $sql .= " WHERE exercise_Id = ?";
            $params[] = (int)$value;
            $types .= "i";
            break;
        case 'exercise_name':
            $sql .= " WHERE exercise_name LIKE ?";
            $params[] = "%$value%";
            $types .= "s";
            break;
        case 'skill_Focus':
            $sql .= " WHERE skill_Focus LIKE ?";
            $params[] = "%$value%";
            $types .= "s";
            break;
    }
}

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    $result = $conn->query("SELECT * FROM exercise_table");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin_dashboard.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../../img/Logo_HowToDrum.png">
    <title>Manage Exercise - HowToDrum</title>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="../../">
                <img src="../../img/Logo_HowToDrum.png" alt="">
            </a>
            <a href="../">Manage user</a>
            <a href="../topic/">Manage topic</a>
            <a href="../song_recommendation/">Manage song recommendation</a>
            <a href="./">Manage exercise</a>
        </div>
        <div class="nav-right">
            <a href="../../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <main>
        <div class="action-menu">
            <a href="create.php" class="btn-add-data"><b>&#43</b> Add Data</a>
            <form method="GET" action="#" class="search-user">
                <div class="search-box">
                    <input type="text" class="search-bar" id="search-bar" name="value" placeholder="Search..." maxlength="20">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="select-type">
                    <select name="type" id="search-for">
                        <option value="exercise_name" selected>Exercise Name</option>
                        <option value="exercise_Id">Exercise ID</option>
                        <option value="skill_Focus">Skill Focus</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Exercise ID</th>
                    <th>Exercise Name</th>
                    <th style="max-width: 250px;">Description</th>
                    <th>Skill Focus</th>
                    <th style="max-width: 250px;">Media</th>
                    <th colspan='2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['exercise_Id']}</td>
                                <td>{$row['exercise_name']}</td>
                                <td style='max-width: 250px;'>{$row['description']}</td>
                                <td>{$row['skill_Focus']}</td>
                                <td style='max-width: 250px;'>{$row['media']}</td>
                                <td>
                                    <a href='update.php?exercise_Id={$row['exercise_Id']}' class='btn-update'><i class='fa fa-edit'></i></a>    
                                    <a href='#' class='btn-remove' onclick='ConfirmExerciseDeleteAlert({$row['exercise_Id']})'><i class='fa fa-remove'></i></a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No exercise found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </main>
</body>
<script src="../../js/admin.js"></script>
</html>