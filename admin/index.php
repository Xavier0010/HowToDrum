<?php
include('../db.php');
session_start();
$isLoggedIn = isset($_SESSION['user']);

if (!isset($_SESSION['user'])) {
    header("Location: ../");
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
    header("Location: ../");
    exit;
}

$type = $_GET['type'] ?? '';
$value = $_GET['value'] ?? '';

$sql = "SELECT * FROM user_table";
$params = [];
$types = "";

if (!empty($type) && !empty($value)) {
    switch ($type) {
        case 'user_id':
            $sql .= " WHERE user_id = ?";
            $params[] = (int)$value;
            $types .= "i";
            break;
        case 'username':
            $sql .= " WHERE username LIKE ?";
            $params[] = "%$value%";
            $types .= "s";
            break;
        case 'email':
            $sql .= " WHERE email LIKE ?";
            $params[] = "%$value%";
            $types .= "s";
            break;
        case 'status':
            $sql .= " WHERE status = ?";
            $params[] = $value;
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
    $result = $conn->query("SELECT * FROM user_table");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="img/Logo HowToDrum.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <title>Admin - HowToDrum</title>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="../">
                <img src="../img/Logo_HowToDrum.png" alt="">
            </a>
        </div>
        <div class="nav-right">
            <a href="../logout.php" class="btn-logout">Logout</a>
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
                        <option value="username" selected>Username</option>
                        <option value="user_id">User ID</option>
                        <option value="email">Email</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th colspan='2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['user_id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='update.php?user_id={$row['user_id']}' class='btn-update'><i class='fa fa-edit'></i></a>    
                                    <a href='#' class='btn-remove' onclick='ConfirmAlert({$row['user_id']})'><i class='fa fa-remove'></i></a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </main>
</body>
<script src="../js/admin.js"></script>
</html>