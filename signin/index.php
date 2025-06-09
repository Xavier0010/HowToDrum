<?php
    session_start();
    include("../db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login_input = isset($_POST['login_input']) ? trim($_POST['login_input']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if (!empty($login_input) && !empty($password)) {
            $login_input = mysqli_real_escape_string($conn, $login_input);
    
            if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT * FROM user_table WHERE email = '$login_input' LIMIT 1";
            } else {
                $query = "SELECT * FROM user_table WHERE username = '$login_input' LIMIT 1";
            }
    
            $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $user_password = $user_data['password'];

            if ($password == $user_password) {
                    $user_username = $user_data['username'];
                    $user_status = $user_data['status'];

                    $_SESSION['user'] = $user_username;
                    header('Location: ../');
                    exit;
                } else {
                    echo 
                    "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function () {
                            showAlert('nok', 'Wrong password.', 'Sign In Unsuccessful!');
                        });
                    </script>";
                }
            } else {
                echo 
                "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function () {
                        showAlert('nok', 'Username or Email not found.', 'Sign In Unsuccessful!');
                    });
                </script>";
            }
        } else {
            echo 
            "<script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function () {
                    showAlert('info', 'Please fill all of the fields.', 'Uncomplete input!');
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
    <link rel="icon" type="image/png" class="tab-logo" href="img/Logo HowToDrum.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../css/signin.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <title>Sign In - HowToDrum</title>
</head>
<body>
    <form method="POST" autocomplete="off">
        <h1>Sign In</h1>
        <h4>Sign in to your account to continue</h4>
        <table>
            <tr>
                <td>
                    <label>Email or Username</label>
                    <input type="text" name="login_input" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password</label>
                    <div class="password-field">
                        <input type="password" class="password" name="password" required>
                        <i class="show fa fa-eye"></i>
                        <i class="hide fa fa-eye-slash"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Sign In</button>
                </td>
            </tr>
        </table>
        <p class="sign-in-text">Don't have an account? <a href="../signup/">Sign Up</a></p>
    </form>

    <script src="../js/signin-signup.js"></script>
    <script src="../js/alerts.js"></script>
</body>
</html>