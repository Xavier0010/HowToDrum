<?php 

session_start();
$isLoggedIn = isset($_SESSION['user']);
include('../db.php');
$isLoggedIn = isset($_SESSION['user']);

if (!isset($_SESSION['user'])) {
    header("Location: ../signin/");
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
    header("Location: ../signin/");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/exercise.css">
    <link rel="icon" type="image/png" class="tab-logo" href="../img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <title>Practice & Exercise - HowToDrum</title>
</head>
<body>
    <nav id="navbar">
        <div class="nav-left logo-and-items">
            <a href="../" class="nav-logo">
                <img src="../img/Logo_HowToDrum.png" alt="Logo">
            </a>
        </div>
        <div class="nav-right login-and-user">
            <?php if(!$isLoggedIn): ?>
                <a href="../signup/" class="login-signup">Sign Up</a>
                <a href="../signin/" class="login-signup">Sign In</a>
            <?php  else: ?>
                <a href="../profile/" class="nav-user">
                    <img src="../img/User.png" alt="User">
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <header>
        <div class="header-text">
            <h1>Practice & Exercise</h1>
        </div>
    </header>

    <main>
        <div class="flex-row">
        <?php
        include '../db.php';
                    
        $exerciseQuery = "SELECT * FROM exercise_table";
        $exerciseResult = mysqli_query($conn, $exerciseQuery);
                    
        if ($exerciseResult && mysqli_num_rows($exerciseResult) > 0) {
            while ($row = mysqli_fetch_assoc($exerciseResult)) {
                ?>
                <div class="card exercise-card">
                    <img src="<?= htmlspecialchars($row['media']) ?>" alt="">
                    <h2><?= htmlspecialchars($row['exercise_name']) ?></h2>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <ul>
                        <?php
                        $skills = explode(',', $row['skill_Focus']);
                        foreach ($skills as $skill) {
                            echo '<li>' . htmlspecialchars(trim($skill)) . '</li>';
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
        }
        ?>
        </div>
        
        <div class="flex-row">
            <div class="card quiz-card quiz1">
                <?php
                
                $query = "SELECT * FROM quiz_table";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result); 
                
                ?>
                <h2><?php echo $row['title']?></h2>
                <p><?php echo $row['description']?></p>
                <button class="open-overlay" data-quiz="1">Start!</button>
            </div>
        </div>

        <div class="quiz-overlay">
            <div class="overlay-content">
                <p id="quiz-content"></p>
            </div>
        </div>

        <a href="../" class="home-page-redirect">Cheatsheet >></a>
    </main>
    <footer>
        <div class="footer-logo">
            <a href="./">
                <img src="../img/Logo_HowToDrum.png" alt="Logo">
                <h3>HowToDrum</h3>
            </a>
        </div>
        <hr>
        <div class="footer-bottom">
            <p style="font-size: 1.2rem;"><i>A Drum Cheatsheet.</i></p>
            <p style="font-size: 0.8rem">Copyright &#169 2024 HowToDrum</p>
        </div>
    </footer>
    <script src="../js/exercise.js"></script>
</body>
</html>