document.addEventListener('DOMContentLoaded', function() {
    const quizContainer = document.getElementById('quiz-container');
    const questionElement = document.getElementById('quiz-question');
    const optionsContainer = document.getElementById('quiz-options');
    const nextButton = document.getElementById('next-question');
    const resultContainer = document.getElementById('quiz-result');
    const scoreElement = document.getElementById('score');

    let shuffledQuestions, currentQuestionIndex, score;

    function startQuiz() {
        fetch('getQuestions.php') 
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Veri alınırken bir hata oluştu:', data.error);
                } else {
                    shuffledQuestions = data.map(q => ({
                        ...q,
                        options: [q.select_1, q.select_2, q.select_3, q.select_4], 
                        correct: q[q.answer.replace('Şık ', 'select_')] 
                    })).sort(() => Math.random() - 0.5);
                    currentQuestionIndex = 0;
                    score = 0;
                    quizContainer.style.display = 'block';
                    resultContainer.style.display = 'none';
                    showNextQuestion();
                }
            })
            .catch(error => console.error('Fetch hatası:', error));
    }

    function showNextQuestion() {
        resetState();
        if (currentQuestionIndex < shuffledQuestions.length) {
            const currentQuestion = shuffledQuestions[currentQuestionIndex];
            questionElement.innerHTML = currentQuestion.quest;

            currentQuestion.options.forEach(option => {
                const button = document.createElement('button');
                button.innerText = option;
                button.classList.add('option-button');
                button.addEventListener('click', () => selectAnswer(button, option === currentQuestion.correct, currentQuestion.correct));
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

    function selectAnswer(button, isCorrect, correctAnswer) {
        Array.from(optionsContainer.children).forEach(btn => {
            btn.disabled = true;
            if (btn.innerText === correctAnswer) {
                btn.style.backgroundColor = 'lightgreen';
            } else {
                btn.style.backgroundColor = 'lightcoral'; 
            }
        });
    
        if (isCorrect) {
            score += 10;
            saveSubmission(userId, shuffledQuestions[currentQuestionIndex].id, true); 
        }
    }
    
    
    function endQuiz() {
        quizContainer.style.display = 'none';
        resultContainer.style.display = 'block';
        if (shuffledQuestions.length > 0) {
            scoreElement.innerText = `Toplam Skor: ${score}/${shuffledQuestions.length * 10}`;
        } else {
            scoreElement.innerText = "Çözülecek soru kalmadı yeni soruları bekleyeniz.";
        }
       
    }
    
    nextButton.addEventListener('click', function() {
        currentQuestionIndex++;
        showNextQuestion();
    });

    startQuiz();
});

function saveSubmission(userId, questionId, isCorrect) {
    fetch('saveSubmission.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            question_id: questionId,
            is_correct: isCorrect ? 1 : 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cevap kaydedildi.');
        } else {
            console.error('Cevap kaydedilemedi:', data.error);
        }
    })
    .catch(error => console.error('Fetch hatası:', error));
}


function student() {
    window.location.href = "student.php";
  }