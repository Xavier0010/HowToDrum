<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["genre"])) {
    $genre = $conn->real_escape_string($_POST["genre"]);
    $sql = "SELECT * FROM song_recommendation_table WHERE genre = '$genre'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $song_link = explode('|', $row['song_link']);
            $skills = explode(',', $row['skills']);

            echo '<div class="song-list">
                    <img src="' . $row['cover_img'] . '" alt="Cover">
                    <div class="song-details">
                        <h2>' . htmlspecialchars($row['song_title']) . '</h2>
                        <span>' . htmlspecialchars($row['artist']) . '</span>
                    </div>
                    <hr style="height: 100%; width: 0; margin: 0 30px;">
                    <div class="song-list-content">
                        <p>Difficulty: <span class="difficulty-span" id="difficulty-span">' . htmlspecialchars($row['difficulty']) . '</span></p>
                        <div class="skills-learned">
                            <ul>';
            foreach ($skills as $skill) {
                echo '<li>' . trim($skill) . '</li>';
            }
            echo        '</ul>
                        </div>
                        <div class="redirect-links">
                            <a href="' . $song_link[0] . '" target="_blank" class="redirect-spotify">
                                <img src="https://img.icons8.com/?size=100&id=99983&format=png&color=FFFFFF" alt="Spotify">
                                <p>Spotify</p>
                            </a>';
            if (isset($song_link[1])) {
                echo '<a href="' . $song_link[1] . '" target="_blank" class="redirect-youtube">
                        <img src="https://img.icons8.com/?size=100&id=37326&format=png&color=FFFFFF" alt="Youtube">
                        <p>Youtube</p>
                      </a>';
            }
            echo    '</div>
                    </div>
                </div>';
        }
    } else {
        echo "<p>No songs found for this genre.</p>";
    }
}
?>
