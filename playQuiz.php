<?php
include_once 'header.php';
GenerateHeader("Play Quiz Page", ['playQuiz.css']);
CanIBeHere();
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div class="question-box">
                <p>Quiz:</p>
                <h2></h2>
            </div>
            <div class="options-container"></div>
            <button class="option-btn" onclick="StartQuiz()">Start Quiz</button>
        </div>
    </div>
</body>

<script>
    let questions = [];
    let title = '';
    let questionNumber = 0;
    let points = 0;
    let questionCounterP = document.querySelector('.question-box p');
    let questionContentH2 = document.querySelector('.question-box h2');
    let optionsContainer = document.querySelector('.options-container');

    const SetupQuiz = async () => {
        // get username from url param
        var urlFormatParams = window.location.search;
        var params = new URLSearchParams(urlFormatParams);
        var quizId = params.get('q');
        // fetch quiz data
        const response = await fetch('backend/sqlJoin.php?join=questions', {
            method: 'POST',
            body: `{"quizId": "${quizId}"}`,
            headers: { 'Content-Type': 'application/json' }
        });
        const json = await response.json();
        // clear format questions
        json.forEach((data) => {
            questions.push(CreateQuestionFormat(data));
        });

        title = json[0].title;
        questionContentH2.innerHTML = title;
    }

    const StartQuiz = () => {
        questionNumber = 0;
        points = 0;

        NextQuestion();
        ToggleOptionButton();
    }

    const ToggleOptionButton = () => {
        let optionBtn = document.getElementsByClassName('option-btn')[0];
        if (optionBtn.style.display === "none") {
            optionBtn.innerHTML = 'Restart Quiz';
            optionBtn.style.display = "block";
        }
        else
            optionBtn.style.display = "none";
    }

    const CreateQuestionFormat = (data) => {
        let question = {
            content: data.content,
            r: data.rightAnswer,
            w1: data.wrong1,
            w2: data.wrong2,
            w3: data.wrong3,
        }
        return question;
    }

    const NextQuestion = () => {
        let index = questionNumber;
        questionNumber++;
        if (questionNumber > questions.length)
            return EndQuiz();

        let question = questions[index];

        questionCounterP.innerHTML = `Question ${questionNumber}:`;
        questionContentH2.innerHTML = question.content;

        MakeQuestionSet(question);
    }

    const MakeQuestionSet = (question) => {
        let answers = [];
        answers.push(MakeQuestionButton(question.r));
        answers.push(MakeQuestionButton(question.w1));
        answers.push(MakeQuestionButton(question.w2));
        answers.push(MakeQuestionButton(question.w3));
        shuffle(answers);
        optionsContainer.innerHTML = answers.join('\n');
    }

    const MakeQuestionButton = (answer) => {
        return `<button class="answer-btn" onclick="ChosenAnswer('${answer}')">${answer}</button>`
    }

    const ChosenAnswer = (answer) => {
        let currentQuestion = questions[questionNumber - 1];
        if (answer == currentQuestion.r)
            points++;
        NextQuestion();
    }

    const EndQuiz = () => {
        questionCounterP.innerHTML = 'Quiz Results:';
        questionContentH2.innerHTML = `${title}`;
        optionsContainer.innerHTML = `<h3>Final Score: ${points}/${questions.length}</h3>`;
        ToggleOptionButton();
    }

    const shuffle = (array) => {
        let arraySize = array.length;
        let randomIndex = 0;
        while (arraySize > 1) {
            randomIndex = Math.floor(Math.random() * arraySize);
            arraySize--;
            let temp = array[arraySize];
            array[arraySize] = array[randomIndex];
            array[randomIndex] = temp;
        }
        return array;
    }

    SetupQuiz();

</script>
<?php
