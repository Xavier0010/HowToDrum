<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user']);
    include('db.php');
    include('get_topic.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/alerts.css">
    <link rel="icon" type="image/png" class="tab-logo" href="img/Logo_HowToDrum.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <title>HowToDrum</title>
</head>
<body>
    <nav id="navbar">
        <div class="nav-left logo-and-items">
            <a href="./" class="nav-logo">
                <img src="img/Logo_HowToDrum.png" alt="Logo">
            </a>
        </div>
        <div class="nav-right login-and-user">
            <?php if(!$isLoggedIn): ?>
                <a href="./signup/" class="login-signup">Sign Up</a>
                <a href="./signin/" class="login-signup">Sign In</a>
            <?php  else: ?>
                <a href="./profile/" class="nav-user">
                    <img src="img/User.png" alt="User">
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <header>
        <div class="header-text">
            <h1>Learn How To Drum!</h1>
            <p>With <span>How To Drum</span></p>
        </div>
    </header>

    <main>
        <section class="cards">
            <div class="flex-row">
                <div class="card drum-history-card">
                    <?php
                        $topic_id = 3;
                        
                        $query = "SELECT * FROM subtopic_table WHERE topic_id = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $topic_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $drum_history_description = explode('|', $row['description']);
                            $drum_history_media = explode(',', $row['media']);
                        ?>
                        <div class="card-header">
                            <h2><?php echo htmlspecialchars($topic_title[3]); ?></h2>
                        </div>
                        <hr>
                        <div class="drum-history-content">
                            <div class="row row1">
                                <p><?php echo htmlspecialchars(trim($drum_history_description[0] ?? '')); ?></p>
                                <img src="<?php echo htmlspecialchars(trim($drum_history_media[0] ?? '')); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div class="row row2">
                                <img src="<?php echo htmlspecialchars(trim($drum_history_media[1] ?? '')); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <p><?php echo htmlspecialchars(trim($drum_history_description[1] ?? '')); ?></p>
                            </div>
                        </div>
                        <?php
                        } else {
                            echo "<p>No data found for topic_id = 3.</p>";
                        }
                        ?>
                </div>
            </div>

            <div class="flex-row">
                <div class="card drumming-techniques">
                    <?php
                    
                    $selected_technique = $_POST['technique'] ?? '';
                    $technique_dropdown = "SELECT subtopic_id, title FROM subtopic_table WHERE topic_id = '4'";
                    $technique_dropdown_result = mysqli_query($conn, $technique_dropdown);

                    $technique_result = null;
                    if (!empty($selected_technique)) {
                        $query = "SELECT * FROM subtopic_table WHERE subtopic_id = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $selected_technique);
                        mysqli_stmt_execute($stmt);
                        $technique_result = mysqli_stmt_get_result($stmt);
                    }
                    ?>
                    <div class="card-header">
                        <h2><?php echo $topic_title[4]; ?></h2>   
                    </div>
                    <hr>
                    <select id="technique-select" style="width: 100%">
                        <option value="" hidden disabled selected></option>
                        <?php while ($row = mysqli_fetch_assoc($technique_dropdown_result)): ?>
                        <option value="<?= $row['subtopic_id']; ?>" <?= ($selected_technique == $row['subtopic_id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($row['title']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="card-content technique-content" id="technique-content">
                        <?php if ($technique_result && mysqli_num_rows($technique_result) > 0): ?>
                            
                        <?php else: ?>
                            <p>Select a drumming technique to see details.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="flex-row">
                <div class="card drum-component-card">
                    <?php
                        $selected_component = $_POST['component'] ?? '';
                        $component_dropdown = "SELECT subtopic_id, title FROM subtopic_table WHERE topic_id = '1'";
                        $component_dropdown_result = mysqli_query($conn, $component_dropdown);

                        $component_result = null;
                        if (!empty($selected_component)) {
                            $query = "SELECT * FROM subtopic_table WHERE subtopic_id = ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "i", $selected_component);
                            mysqli_stmt_execute($stmt);
                            $component_result = mysqli_stmt_get_result($stmt);
                        }
                    ?>

                    <div class="card-header">
                        <h2><?php echo $topic_title[1]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="1">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                    <select id="component-select" style="width: 100%;">
                        <option value="" hidden disabled selected></option>
                        <?php while ($row = mysqli_fetch_assoc($component_dropdown_result)): ?>
                        <option value="<?= $row['subtopic_id']; ?>" <?= ($selected_component == $row['subtopic_id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($row['title']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                        
                    <div class="card-content drum-component-content" id="drum-component-content">
                        <?php if ($component_result && mysqli_num_rows($component_result) > 0): ?>
                            
                        <?php else: ?>
                            <p>Select a drum component to see details.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card notation-rest-card">
                    <?php
                        $selected_notation = '';
                        $notation_dropdown = "SELECT subtopic_id, title FROM subtopic_table WHERE topic_id = '2'";
                        $notation_dropdown_result = mysqli_query($conn, $notation_dropdown);

                        $notation_result = null;
                        if (!empty($selected_notation)) {
                            $query = "SELECT * FROM subtopic_table WHERE subtopic_id = ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "i", $selected_notation);
                            mysqli_stmt_execute($stmt);
                            $notation_result = mysqli_stmt_get_result($stmt);
                        }
                    ?>

                    <div class="card-header">
                        <h2><?php echo $topic_title[2]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="2">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                    <select id="notation-rest-select" style="width: 100%;">
                        <?php while ($row = mysqli_fetch_assoc($notation_dropdown_result)): ?>
                            <option value="" hidden disabled selected></option>
                            <option value="<?= $row['subtopic_id']; ?>" <?= ($selected_notation == $row['subtopic_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars(explode(" ", $row['title'])[0]); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                        
                    <div class="card-content notation-rest-content" id="notation-rest-content">
                        <p>Select a notation/rest to see details.</p>
                    </div>
                </div>
            </div>

            <div class="flex-row">
                <div class="card music-staff-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[5]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="5">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>
                <div class="card drum-notation-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[6]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="6">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>
            </div>

            <div class="flex-row">
                <div class="card time-signature-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[7]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="7">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>
                <div class="card tempo-card">
                    <?php
                    $topic_id = 8;

                    $query = "SELECT * FROM subtopic_table WHERE topic_id = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "i", $topic_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $tempo_description = $row['description'];
                        $tempo_media = $row['media'];
                    }
                    ?>
                    <div class="card-header">
                        <h2><?php echo $topic_title[8]; ?></h2>  
                    </div>
                    <hr>
                    <div class="tempo-content">
                        <img src="<?php echo $tempo_media?>" alt="<?php echo $topic_title[8]?>">
                        <p><?php echo $tempo_description?></p>
                    </div>
                </div>
            </div>

            <div class="flex-row">
                <div class="card metronome-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[9]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="9">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>

                    <div class="card-content metronome-content">
                        <div class="tempo-display">
                            <span class="tempo">100</span>
                            <span class="bpm">BPM</span>
                        </div>

                        <div class="tempo-setting">
                            <div class="decrease-tempo">
                                <div class="adjust-tempo-btn decrease">-</div>
                                <div class="adjust-tempo-btn decrease-5">-5</div>
                            </div>
                            <input type="range" class="tempo-slider" min="1" max="300" step="1" value="150">
                            <div class="increase-tempo">
                                <div class="adjust-tempo-btn increase">+</div>
                                <div class="adjust-tempo-btn increase-5">+5</div>
                            </div>
                        </div>

                        <div class="start-stop"><i class="fa fa-play"></i></div>
                    </div>
                </div>
            </div>
            
            <div class="flex-row">
                <div class="card rudiment-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[10]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="10">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>

                <div class="card drum-beats-card">
                    <div class="card-header">
                        <h2><?php echo $topic_title[11]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="11">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>
            </div>

            <div class="flex-row">
                <div class="card fill-in-card" style="flex-grow: 1;">
                    <div class="card-header">
                        <h2><?php echo $topic_title[12]; ?></h2>
                        <button class="open-header-description" id="open-header-description" data-id="12">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                        </button>    
                    </div>
                    <hr>
                </div>
            </div>
        </section>

        <section class="song-recommendation">
            <div class="song-recommendation-container">
                <h2>Song Recommendations</h2>
                <hr>
                <div class="song-recommendation-content">
                    <div class="genre-carousel">
                        <button class="carousel-arrow left-arrow" aria-label="Previous">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div class="carousel-items">
                            <div class="genre-item" id="rock">Rock</div>
                            <div class="genre-item" id="punk">Punk</div>
                            <div class="genre-item" id="pop">Pop</div>
                        </div>
                        <button class="carousel-arrow right-arrow" aria-label="Next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="song-list-container"></div>
                </div>
            </div>
        </section>

        <a href="./exercise/" class="exercise-page-redirect">Practice & Excercise >></a>

        <div class="topic-description-overlay">
            <div class="overlay-content">
                <button class="close-overlay-btn"><i class="fa fa-xmark"></i></button>
                <h1></h1>
                <p></p>
            </div>
        </div>
        <script>
            const topicTitles = <?php echo json_encode($topic_title); ?>;
            const topicDescriptions = <?php echo json_encode($topic_description); ?>;
            const overlay = document.querySelector('.topic-description-overlay');
            const overlayTitle = overlay.querySelector('h1');
            const overlayDesc = overlay.querySelector('p');
            const closeBtn = overlay.querySelector('.close-overlay-btn');
            // Add click listeners to all topic buttons
            document.querySelectorAll('.open-header-description').forEach(btn => {
              btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                overlayTitle.textContent = topicTitles[id] || 'No Title';
                overlayDesc.textContent = topicDescriptions[id] || 'No Description';
                overlay.classList.add('active');
              });
            });
            // Close button
            closeBtn.addEventListener('click', () => {
              overlay.classList.remove('active');
            });
        </script>
    </main>

    <footer>
        <div class="footer-logo">
            <a href="./">
                <img src="img/Logo_HowToDrum.png" alt="Logo">
                <h3>HowToDrum</h3>
            </a>
        </div>
        <hr>
        <div class="footer-bottom">
            <p style="font-size: 1.2rem;"><i>A Drum Cheatsheet.</i></p>
            <p style="font-size: 0.8rem">Copyright &#169 2024 HowToDrum</p>
        </div>
    </footer>

    <script src="./js/metronome/metronome.js" type="module"></script>
    <script src="./js/script.js"></script>
    <script src="./js/alerts.js"></script>
</body>
</html>