<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../css/create.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <title>Create User - HowToDrum</title>
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
        <form action="#" method="POST">
            <h1>Create User</h1>
            <label for="username">Username (Below 20 characters)</label><br>
            <input type="text" id="username" name="username"><br><br>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email"><br><br>
            <label for="status">Status</label><br>
            <select name="status" id="status">
                <option value="none" selected disabled hidden></option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <label for="password">Password (8-16 characters)</label><br>
            <input type="text" id="password" name="password"><br><br>
            <button type="submit" class="btn-submit" name="create">Create</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
    </main>

    <?php
        include '../db.php';
        if (isset($_POST['create'])) {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 
                "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function () {
                        showAlert('nok', 'Please use valid email address.', 'Invalid Email!');
                    });
                </script>";
            } elseif (strlen($username) > 20) {
                echo 
                "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function () {
                        showAlert('nok', 'Username cannot exceed 20 characters.', 'Invalid Username!')
                    });
                </script>";
            } elseif (strlen($password) < 8 || strlen($password) > 16) {
                echo 
                "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function () {
                        showAlert('nok', 'Password should be 8-16 characters long.', 'Invalid Password!')
                    });    
                </script>";
            } elseif (!empty($username) && !empty($email) && !empty($password)) {
                $stmt = $conn->prepare("INSERT INTO user_table (username, email, password) values (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $password);
                $stmt->execute();
                header('Location: ./index.php');
                exit;
            } else {
                echo 
                "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function () {
                        showAlert('nok', 'Please enter valid information.', 'Sign Up Unsuccessful!')
                    });    
                </script>";
            }
        }
    ?>

    <script src="../js/alerts.js"></script>
</body>
</html>