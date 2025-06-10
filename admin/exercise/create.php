<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../../css/create.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <title>Create Exercise - HowToDrum</title>
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
            <h1>Create Exercise</h1>
            <label for="title">Exercise Name</label><br>
            <input type="text" id="exercise_name" name="exercise_name"><br><br>
            <label for="description">Description</label><br>
            <textarea name="description" id="description"></textarea><br><br>
            <label for="skill_Focus">Skill Focus</label><br>
            <input type="text" name="skill_Focus" id="skill_Focus"><br><br>
            <button type="submit" class="btn-submit" name="create">Create</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
    </main>

    <?php
        include '../../db.php';
        if (isset($_POST['create'])) {
            $exercise_name = trim($_POST['exercise_name']);
            $description = trim($_POST['description']);
            $skill_Focus = trim($_POST['skill_Focus']);

            if (!empty($exercise_name)) {
                $stmt = $conn->prepare("INSERT INTO exercise_table (exercise_name, description, skill_Focus) values (?, ?, ?)");
                $stmt->bind_param("sss", $exercise_name, $description, $skill_Focus);
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