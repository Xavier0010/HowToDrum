<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$username = $_SESSION['user'];

include '../db.php';

if ($username) {
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $existing_password = $row['password'];
        $status = $row['status'];
    } else {
        header("Location: ../logout.php");
        exit;
    }
} else {
    header("Location: ../signin/");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'] ?? '';
    $new_password = $_POST['input-password'] ?? '';

    // Use existing password if new password is empty
    if (empty($new_password)) {
        $new_password = $existing_password;
    }

    // Update username and password
    $update_stmt = $conn->prepare("UPDATE user_table SET username = ?, password = ? WHERE user_id = ?");
    $update_stmt->bind_param("ssi", $new_username, $new_password, $user_id);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        if ($new_username !== $username) {
            $_SESSION['user'] = $new_username;
            $username = $new_username;
        }
        echo "<script>alert('Details updated successfully.');</script>";
    } else {
        echo "<script>alert('No changes made or update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../css/profile.css">
    <title>User Profile - HowToDrum</title>
</head>
<body>
    <nav>
        <div class="nav-left logo-and-items">
            <a href="../" class="nav-logo">
                <img src="../img/Logo_HowToDrum.png" alt="Logo">
            </a>
        </div>
        <div class="nav-right login-and-user">
            <?php if(!$isLoggedIn): ?>
                <a href="../signup/" class="login-signup">Sign Up</a>
                <a href="../signin/" class="login-signup">Log In</a>
            <?php  else: ?>
                <a href="./" class="nav-user">
                    <img src="../img/User.png" alt="User">
                </a>
            <?php endif; ?>
        </div>
    </nav>
    
    <main>
        <div class="profile-container">
            <img src="../img/User.png" alt="User">
            <?php echo "<h2>Hi, " . $username . "!</h2>"; ?>
            <?php if($status != 'admin'): ?>
                <div class="action-btn">
                    <button class="btn open-overlay">Edit details</button>
                    <a href="../logout.php" class="btn logout">Log Out</a>
                </div>
            <?php else: ?>
                <div class="dashboard-btn" id="dashboard-btn">
                    <a href="../admin/">Dashboard</a>
                </div>
                <div class="action-btn">
                    <button class="btn open-overlay">Edit details</button>
                    <a href="../logout.php" class="btn logout">Log Out</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="edit-details-overlay">
            <div class="overlay-content">
                <form action="" method="POST">
                    <h1>Edit details</h1>
                    <table>
                        <tr>
                            <td>
                                <label for="username">Username</label>
                                <input type="text" name="username" class="input-username" value="<?php echo htmlspecialchars($username); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password</label>
                                <div class="password-field">
                                    <input type="password" name="input-password" id="input-password">
                                    <i class="show fa fa-eye"></i>
                                    <i class="hide fa fa-eye-slash"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="btn-container">
                                <button type="submit" class="btn update-details">OK</button>
                                <button type="button" class="btn close-overlay">Close</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
    <script src="../js/profile.js"></script>
</body>
</html>