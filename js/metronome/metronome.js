import Timer from './timer.js';

const tempoDisplay = document.querySelector('.tempo');
const decreaseTempoBtn = document.querySelector('.decrease');
const decreaseTempo5Btn = document.querySelector('.decrease-5');
const increaseTempoBtn = document.querySelector('.increase');
const increaseTempo5Btn = document.querySelector('.increase-5');
const tempoSlider = document.querySelector('.tempo-slider');
const startStopBtn = document.querySelector('.start-stop');

const clickAccent = new Audio('./audio/metronome/click-accent.mp3');
const clickNormal = new Audio('./audio/metronome/click-normal.mp3');

let bpm = parseInt(tempoSlider.value);
tempoDisplay.textContent = bpm;
let count = 0;
let beatsPerMeasure = 4;
let isRunning = false;

decreaseTempoBtn.addEventListener('click', () => {
    if (bpm <= 1) { return };
    bpm--;
    validateTempo();
    updateMetronome();
});

decreaseTempo5Btn.addEventListener('click', () => {
    if (bpm <= 5) { return };
    bpm -= 5;
    validateTempo();
    updateMetronome();
});

increaseTempoBtn.addEventListener('click', () => {
    if (bpm >= 300) { return };
    bpm++;
    validateTempo();
    updateMetronome();
});

increaseTempo5Btn.addEventListener('click', () => {
    if (bpm >= 296) { return };
    bpm += 5;
    validateTempo();
    updateMetronome();
});

tempoSlider.addEventListener('input', () => {
    bpm = parseInt(tempoSlider.value);;
    validateTempo();
    updateMetronome();
});

startStopBtn.addEventListener('click', () => {
    count = 0;
    if (!isRunning) {
        metronome.start();
        isRunning = true;
        startStopBtn.innerHTML = '<i class="fa fa-pause"></i>';
    } else {
        metronome.stop();
        isRunning = false;
        startStopBtn.innerHTML = '<i class="fa fa-play"></i>';
    }
});

function updateMetronome() {
    tempoDisplay.textContent = bpm;
    tempoSlider.value = bpm;
    metronome.timeInterval = 60000 / bpm;
}

function validateTempo() {
    if (bpm <= 1) { return };
    if (bpm >= 300) { return };
}

function playClick() {
    console.log(count);
    if (count === beatsPerMeasure) {
        count = 0;
    }

    if (count === 0) {
        clickAccent.play();
        clickAccent.currentTime = 0;
    } else {
        clickNormal.play();
        clickNormal.currentTime = 0;
    }

    count++;
}

const metronome = new Timer(playClick, 60000 / bpm, { immediate: true });