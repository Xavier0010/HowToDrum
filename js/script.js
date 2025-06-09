document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('technique-select');
    const contentDiv = document.getElementById('technique-content');

    select.addEventListener('change', function() {
        const techniqueId = this.value;
        fetch('get_subtopic.php?subtopic_id=' + techniqueId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const technique = data.data;
                    const titles = technique.title.split(',');
                    const media = technique.media.split(',');
                    contentDiv.innerHTML = `
                        <div class="card-content technique-content">
                            <img src="${media[0]}" alt="${technique.title}">
                            <div class="technique-text">
                                <h3>${titles[0]}</h3>
                                <p>${technique.description}</p>
                            </div>
                        </div>
                    `;
                } else {
                    contentDiv.innerHTML = '<p>' + data.message + '</p>';
                }
            })
            .catch(error => {
                contentDiv.innerHTML = '<p>Error loading notation/rest data.</p>';
                console.error('Error fetching notation/rest:', error);
            });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('component-select');
    const contentDiv = document.getElementById('drum-component-content');

    select.addEventListener('change', function() {
        const componentId = this.value;
        fetch('get_subtopic.php?subtopic_id=' + componentId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const component = data.data;
                    const media = component.media.split(',')
                    contentDiv.innerHTML = `
                        <img src="${media[0]}" alt="${component.title}">
                        <div class="drum-component-text">
                            <h3>${component.title}</h3>
                            <p>${component.description}</p>
                            <button class="audio-btn" id="audio-btn" onclick="playAudio()"><i class="fa fa-play" aria-hidden="true" id="audio-btn-icon"></i></button>
                        </div>
                    `;
                } else {
                    contentDiv.innerHTML = '<p>' + data.message + '</p>';
                }
            })
            .catch(error => {
                contentDiv.innerHTML = '<p>Error loading component data.</p>';
                console.error('Error fetching component:', error);
            });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('notation-rest-select');
    const contentDiv = document.getElementById('notation-rest-content');

    select.addEventListener('change', function() {
        const notationId = this.value;
        fetch('get_subtopic.php?subtopic_id=' + notationId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notation = data.data;
                    const media = notation.media.split(',');
                    const titles = notation.title.split(',');
                    contentDiv.innerHTML = `
                        <div class="card-content notation-rest-content">
                            <div class="notation-content">
                                <img src="${media[0]}" alt="${notation.title}">
                                <div class="notation-text">
                                    <h3>${titles[0]}</h3>
                                    <p>${notation.description} beat</p>
                                </div>
                            </div>
                            <div class="rest-content">
                                <img src="${media[1]}" alt="${notation.title}">
                                <div class="rest-text">
                                    <h3>${titles[1]}</h3>
                                    <p>${notation.description} beat</p>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    contentDiv.innerHTML = '<p>' + data.message + '</p>';
                }
            })
            .catch(error => {
                contentDiv.innerHTML = '<p>Error loading notation/rest data.</p>';
                console.error('Error fetching notation/rest:', error);
            });
    });
});

let prevScrollPos = window.pageYOffset;
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
  const currentScrollPos = window.pageYOffset;
  if (prevScrollPos > currentScrollPos) {
    navbar.style.top = "0";
  } else {
    navbar.style.top = "-100px";
  }
  prevScrollPos = currentScrollPos;
});

document.addEventListener('DOMContentLoaded', function () {
    const genreItems = document.querySelectorAll('.genre-item');
    const songListContainer = document.querySelector('.song-list-container');

    // Fetch and display songs for default genre 'rock' on page load
    fetch('get_song.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'genre=' + encodeURIComponent('rock')
    })
    .then(response => response.text())
    .then(html => {
        songListContainer.innerHTML = html;
    })
    .catch(error => {
        songListContainer.innerHTML = '<p>Error loading songs.</p>';
        console.error('Fetch error:', error);
    });

    genreItems.forEach(item => {
        item.addEventListener('click', function () {
            const genre = this.id;

            fetch('get_song.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'genre=' + encodeURIComponent(genre)
            })
            .then(response => response.text())
            .then(html => {
                songListContainer.innerHTML = html;
            })
            .catch(error => {
                songListContainer.innerHTML = '<p>Error loading songs.</p>';
                console.error('Fetch error:', error);
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.genre-carousel .carousel-items');
    const leftArrow = document.querySelector('.genre-carousel .left-arrow');
    const rightArrow = document.querySelector('.genre-carousel .right-arrow');

    const genreItemWidth = document.querySelector('.genre-item').offsetWidth + 14; // item width + margin
    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;
    let currentIndex = 0;
    const maxIndex = carousel.children.length - 1;

    function scrollToIndex(index) {
        const scrollPosition = index * genreItemWidth;
        carousel.scrollTo({ left: scrollPosition, behavior: 'smooth' });
    }

    leftArrow.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            scrollToIndex(currentIndex);
            // Fetch songs for the current genre after scrolling
            const genre = carousel.children[currentIndex].id;
            fetch('get_song.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'genre=' + encodeURIComponent(genre)
            })
            .then(response => response.text())
            .then(html => {
                const songListContainer = document.querySelector('.song-list-container');
                songListContainer.innerHTML = html;
            })
            .catch(error => {
                const songListContainer = document.querySelector('.song-list-container');
                songListContainer.innerHTML = '<p>Error loading songs.</p>';
                console.error('Fetch error:', error);
            });
        }
    });

    rightArrow.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            scrollToIndex(currentIndex);
            // Fetch songs for the current genre after scrolling
            const genre = carousel.children[currentIndex].id;
            fetch('get_song.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'genre=' + encodeURIComponent(genre)
            })
            .then(response => response.text())
            .then(html => {
                const songListContainer = document.querySelector('.song-list-container');
                songListContainer.innerHTML = html;
            })
            .catch(error => {
                const songListContainer = document.querySelector('.song-list-container');
                songListContainer.innerHTML = '<p>Error loading songs.</p>';
                console.error('Fetch error:', error);
            });
        }
    });
});
