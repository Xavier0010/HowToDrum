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

function shuffleArray(array) {
    return array.sort(() => Math.random() - 0.5);
}

let quizData = [];
let currentQuestionIndex = 0;
let score = 0;
let answered = false;

document.querySelectorAll(".open-overlay").forEach(button => {
    button.addEventListener("click", async () => {
        const quizId = button.dataset.quiz;

        try {
            const response = await fetch(`../get_quiz.php?quiz_id=${quizId}`);
            const data = await response.json();
            quizData = shuffleArray(data)
            currentQuestionIndex = 0;
            score = 0;
            console.log(quizData);
            renderQuestion();
            document.querySelector(".quiz-overlay").classList.add("visible");
            document.body.style.overflow = "hidden";
        } catch (error) {
            document.getElementById("quiz-content").innerHTML = "<p>Error loading quiz questions.</p>";
        }
    });
});

function renderQuestion() {
    answered = false;
    const q = quizData[currentQuestionIndex];
    const options = shuffleArray([
        { text: q.option_a },
        { text: q.option_b },
        { text: q.option_c },
        { text: q.option_d }
    ]);

    const optionButtons = options.map(opt => 
        `<button onclick="selectAnswer(this, '${q.answer}', '${opt.text}')">${opt.text}</button>`
    ).join("");

    document.getElementById("quiz-content").innerHTML = `
        <div style="text-align: left;">
            <p><strong>Q${currentQuestionIndex + 1}:</strong> ${q.question}</p>
            <div id="options">${optionButtons}</div>
        </div>
        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <button id="nextBtn" onclick="nextQuestion()" disabled ${currentQuestionIndex === quizData.length - 1 ? "disabled" : ""}>Next</button>
        </div>
    `;
}

function selectAnswer(button, correct, selected) {
    if (answered) return;

    answered = true;

    const buttons = document.querySelectorAll("#options button");
    buttons.forEach(btn => {
        btn.disabled = true;
        if (btn.textContent.includes(correct)) {
            btn.style.backgroundColor = "#4CAF50"; // green for correct
            btn.style.color = "#fff";
        } else if (btn.textContent.includes(selected)) {
            btn.style.backgroundColor = "#f44336"; // red for incorrect
            btn.style.color = "#fff";
        }
    });

    if (selected === correct) score++;

    document.getElementById("nextBtn").disabled = false;
}

function nextQuestion() {
    if (currentQuestionIndex < quizData.length - 1) {
        currentQuestionIndex++;
        renderQuestion();
    } else {
        let apprText = ""
        if (score == 10) {
            apprText = "Perfect!";
        } else if (score > 8) {
            apprText = "Excellent!";
        } else if (score > 5) {
            apprText = "Great!";
        } else if (score > 3) {
            apprText = "Not bad!";
        } else {
            apprText = "Too bad 💀💀💀"
        }

        document.getElementById("quiz-content").innerHTML = `
            <h2>Quiz Completed!</h2>
            <p>Your score: ${score} / ${quizData.length}</p>
            <p>${apprText}</p>
            <button class="close-overlay">Close</button>
        `;
        document.querySelector(".close-overlay").addEventListener("click", () => {
            document.querySelector(".quiz-overlay").classList.remove("visible");
            document.body.style.overflow = "";
        });
    }
}

function prevQuestion() {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        renderQuestion();
    }
}

document.querySelector(".close-overlay").addEventListener("click", () => {
    document.querySelector(".quiz-overlay").classList.remove("visible");
    document.body.style.overflow = "";
});