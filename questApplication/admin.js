document.addEventListener('DOMContentLoaded', function() {
    const questionForm = document.getElementById('question-form');
    const questionIndexInput = document.getElementById('question-index');
    const questionText = document.getElementById('question-text');
    const optionTexts = Array.from(document.getElementsByClassName('option-text'));
    const correctOption = document.getElementById('correct-option');
    const difficulty = document.getElementById('difficulty');
    const questionsList = document.getElementById('questions-list');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.querySelector('.search-button');

    let questions = JSON.parse(localStorage.getItem('questions')) || [];
    
    function displayQuestions(questionsToDisplay) {
        questionsList.innerHTML = '';
        questionsToDisplay.forEach((q, index) => {
            const questionElement = document.createElement('div');
            questionElement.innerHTML = `
                <div>
                    <strong>${index + 1}. ${q.question} (${q.difficulty})</strong>
                    <button style="width: 10%;" onclick="editQuestion(${index})">Düzenle</button>
                    <button style="width: 10%;" onclick="deleteQuestion(${index})">Sil</button>
                </div>`;
            questionsList.appendChild(questionElement);
        });
    }

    function saveQuestion() {
        const newQuestion = {
            question: questionText.value,
            options: optionTexts.map(input => input.value),
            correct: parseInt(correctOption.value, 10),
            difficulty: difficulty.value
        };

        const index = parseInt(questionIndexInput.value, 10);
        if (isNaN(index)) {
            questions.push(newQuestion);
        } else {
            questions[index] = newQuestion;
        }

        localStorage.setItem('questions', JSON.stringify(questions));
        displayQuestions(questions);
        questionForm.reset();
        questionIndexInput.value = '';
    }

    function editQuestion(index) {
        const question = questions[index];
        questionText.value = question.question;
        optionTexts.forEach((input, idx) => input.value = question.options[idx]);
        correctOption.value = question.correct;
        difficulty.value = question.difficulty;
        questionIndexInput.value = index;
    }

    function deleteQuestion(index) {
        questions.splice(index, 1);
        localStorage.setItem('questions', JSON.stringify(questions));
        displayQuestions(questions);
    }

    function searchQuestions() {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredQuestions = questions.filter(q =>
            q.question.toLowerCase().includes(searchTerm)
        );
        displayQuestions(filteredQuestions);
    }

    questionForm.onsubmit = function(event) {
        event.preventDefault();
        saveQuestion();
    };

    searchButton.onclick = function() {
        searchQuestions();
    };
    window.editQuestion = editQuestion;
    window.deleteQuestion = deleteQuestion;
    
    displayQuestions(questions);

    window.goToHomePage = function() {
        window.location.href = 'index.html';
    };
});
