<?php
    session_start();
    include("../db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

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
            $query = "INSERT INTO user_table (username, email, password) values ('$username', '$email', '$password')";
            mysqli_query($conn, $query);
            header('location: ../');
            $_SESSION['user'] = $username;
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <title>Sign Up - HowToDrum</title>
</head>
<body>
    <form method="POST" autocomplete="off">
        <h1>Sign Up</h1>
        <h4>Create an account</h4>
        <table>
            <tr>
                <td>
                    <label>Username (Below 20 characters)</label>
                    <input type="text" name="username" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password (8-16 characters)</label>
                    <div class="password-field">
                        <input type="password" class="password" name="password" required>
                        <i class="show fa fa-eye"></i>
                        <i class="hide fa fa-eye-slash"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Sign Up</button>
                </td>
            </tr>
        </table>
        <p class="sign-in-text">Already have an account? <a href="../signin/">Sign In</a></p>
    </form>
    
    <script src="../js/signin-signup.js"></script>
    <script src="../js/alerts.js"></script>
</body>
</html>