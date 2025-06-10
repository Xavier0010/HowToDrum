<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../../css/create.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <title>Create Topic - HowToDrum</title>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="./">
                <img src="../../img/Logo_HowToDrum.png" alt="">
            </a>
        </div>
        <div class="nav-right">
            <a href="../../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <main>
        <form action="#" method="POST">
            <h1>Create Topic</h1>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title"><br><br>
            <label for="description">Description</label><br>
            <textarea name="description" id="description"></textarea><br><br>
            <button type="submit" class="btn-submit" name="create">Create</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
    </main>

    <?php
        include '../../db.php';
        if (isset($_POST['create'])) {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            if (!empty($title)) {
                $stmt = $conn->prepare("INSERT INTO topic_table (title, description) values (?, ?)");
                $stmt->bind_param("ss", $title, $description);
                $stmt->execute();
                header('Location: ./');
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

    <script src="../../js/alerts.js"></script>
</body>
</html>