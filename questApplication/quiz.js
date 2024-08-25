document.addEventListener('DOMContentLoaded', function() {
    const quizContainer = document.getElementById('quiz-container');
    const questionElement = document.getElementById('quiz-question');
    const optionsContainer = document.getElementById('quiz-options');
    const nextButton = document.getElementById('next-question');
    const resultContainer = document.getElementById('quiz-result');
    const scoreElement = document.getElementById('score');

    let questions = JSON.parse(localStorage.getItem('questions')) || [];
    let shuffledQuestions, currentQuestionIndex, score;

    function startQuiz() {
        shuffledQuestions = questions.sort(() => Math.random() - 0.5);
        currentQuestionIndex = 0;
        score = 0;
        quizContainer.style.display = 'block';
        resultContainer.style.display = 'none';
        showNextQuestion();
    }

    function showNextQuestion() {
        resetState();
        if (currentQuestionIndex < shuffledQuestions.length) {
            const currentQuestion = shuffledQuestions[currentQuestionIndex];
            questionElement.innerText = currentQuestion.question;

            currentQuestion.options.forEach((option, index) => {
                const button = document.createElement('button');
                button.innerText = option;
                button.classList.add('option-button');
                button.addEventListener('click', () => selectAnswer(button, index === currentQuestion.correct));
                optionsContainer.appendChild(button);
            });
        } else {
            endQuiz();
        }
    }

    function resetState() {
        while (optionsContainer.firstChild) {
            optionsContainer.removeChild(optionsContainer.firstChild);
        }
    }

    function selectAnswer(button, isCorrect) {
        if (isCorrect) {
            score += 10;
            button.style.backgroundColor = 'lightgreen';
        } else {
            button.style.backgroundColor = 'lightcoral';
        }
        Array.from(optionsContainer.children).forEach(btn => {
            btn.disabled = true;
            if (btn !== button) {
                btn.style.backgroundColor = btn.dataset.correct ? 'lightgreen' : 'lightcoral';
            }
        });
    }

    function endQuiz() {
        quizContainer.style.display = 'none';
        resultContainer.style.display = 'block';
        scoreElement.innerText = `Toplam Skor: ${score}/${shuffledQuestions.length * 10}`;
    }

    nextButton.addEventListener('click', function() {
        currentQuestionIndex++;
        showNextQuestion();
    });

    startQuiz();
});

function goToHomePage() {
    window.location.href = 'index.html';
}
