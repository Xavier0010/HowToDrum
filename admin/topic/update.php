<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="../../css/update.css">
    <title>Update Topic - Admin Dashboard</title>
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
            $topic_id = $_GET['topic_id'];

            $query = "SELECT * FROM topic_table WHERE topic_id = '$topic_id'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
        ?>
        
        <form action="" method="POST">
            <h1>Update Topic</h1>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>"><br><br>
            <label for="description">Description</label><br>
            <textarea name="description" id="description"><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>
            <button type="submit" class="btn-submit" name="update">Update</button>
            <button type="button" onclick="location.href='./'" class="btn-cancel">Cancel</button>
        </form>
        <?php
             if (isset($_POST['update'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];

                $stmt = $conn->prepare("UPDATE topic_table SET title = ?, description = ? WHERE topic_id = ?");
                $stmt->bind_param("ssi", $title, $description, $topic_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "User updated successfully.";
                    header("Location: ./");
                    exit;
                } else {
                    echo "Error updating topic: " . $conn->error;
                }
            }
        ?>
    </main>
</body>
</html>