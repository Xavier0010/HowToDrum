<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../../css/update.css">
    <title>Update Exercise - Admin Dashboard</title>
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
        <?php
            include '../../db.php';
            $exercise_Id = $_GET['exercise_Id'];

            $query = "SELECT * FROM exercise_table WHERE exercise_Id = '$exercise_Id'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
        ?>
        
        <form action="" method="POST">
            <h1>Update Exercise</h1>
            <label for="title">Exercise Name</label><br>
            <input type="text" id="exercise_name" name="exercise_name" value="<?php echo $row['exercise_name']?>"><br><br>
            <label for="description">Description</label><br>
            <textarea name="description" id="description"><?php echo $row['description']?></textarea><br><br>
            <label for="skill_Focus">Skill Focus</label><br>
            <input type="text" name="skill_Focus" id="skill_Focus" value="<?php echo $row['skill_Focus']?>"><br><br>
            <button type="submit" class="btn-submit" name="update">Update</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
        <?php
             if (isset($_POST['update'])) {
                $exercise_name = $_POST['exercise_name'];
                $description = $_POST['description'];
                $skill_Focus = $_POST['skill_Focus'];

                $stmt = $conn->prepare("UPDATE exercise_table SET exercise_name = ?, description = ?, skill_Focus = ? WHERE exercise_Id = ?");
                $stmt->bind_param("sssi", $exercise_name, $description, $skill_Focus, $exercise_Id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "User updated successfully.";
                    header("Location: ./");
                    exit;
                } else {
                    echo "Error updating exercise: " . $conn->error;
                }
            }
        ?>
    </main>
</body>
</html>