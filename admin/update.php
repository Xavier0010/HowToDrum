<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../css/update.css">
    <title>Update User - Admin Dashboard</title>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="./">
                <img src="../img/Logo_HowToDrum.png" alt="">
            </a>
        </div>
        <div class="nav-right">
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <main>
        <?php
            include '../db.php';
            $user_id = $_GET['user_id'];

            $query = "SELECT * FROM user_table WHERE user_id = '$user_id'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
        ?>
        
        <form action="" method="POST">
            <h1>Update Data</h1>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>"><br><br>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="none" selected disabled hidden></option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <label for="password">Password</label>
            <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>"><br><br>
            <button type="submit" class="btn-submit" name="update">Update</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
        <?php
             if (isset($_POST['update'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $status = $_POST['status'];
                $password = $_POST['password'];

                $stmt = $conn->prepare("UPDATE user_table SET username = ?, email = ?, status = ?, password = ? WHERE user_id = ?");
                $stmt->bind_param("ssssi", $username, $email, $status, $password, $user_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "User updated successfully.";
                    header("Location: ../admin/");
                    exit;
                } else {
                    echo "Error updating user: " . $conn->error;
                }
            }
        ?>
    </main>
</body>
<style>
    body {
        margin: 0;
    }

    ::-webkit-scrollbar {
        display: none;
    }

    .title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 25px;
        background-color: #ffdbb5;
        box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.25);
    }

    .btn-logout {
        text-decoration: none;
        color: #000;
    }
</style>
</html>