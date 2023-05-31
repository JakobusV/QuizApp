<?php
include_once 'header.php';
GenerateHeader("Quizzes Page", ['quizzesPage.css']);
CanIBeHere();
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div class="gradient-banner">
                <div>Quiz Wall</div>
            </div>
            <div class="utility-bar">
                <div class="search-bar">
                    <img src="./search.png" />
                    <input placeholder="search quizzes" oninput="Search(this.value)"/>
                </div>
            </div>
            <div class="quizzes-container">
            </div>
        </div>
    </div>
</body>

<script>
    let quizzes = [];
    const quizzesContainer = document.getElementsByClassName('quizzes-container')[0];

    const SetupWall = async () => {
        const response = await fetch('backend/sqlSelect.php?table=quiz');
        quizzes = await response.json();
        ShowQuizzes(quizzes);
    }

    const Search = (searchRequest) => {
        let searchResults = [];
        searchRequest = searchRequest.toLowerCase();
        quizzes.forEach(quiz =>
            quiz.title.toLowerCase().includes(searchRequest) ? searchResults.push(quiz) : null
        );
        ShowQuizzes(searchResults);
    }

    const ShowQuizzes = (quizzes) => {
        let quizElements = [];
        quizzes.forEach(quiz => 
            quizElements.push(CreateQuizCardElement(quiz))
        );
        quizzesContainer.innerHTML = quizElements.join('\n');
    }

    const CreateQuizCardElement = quiz => {
        return `<a class="quiz-card" href="./playQuiz.php?q=${quiz.id}">
                    <div class="quiz-body">
                        <div class="quiz-title">${quiz.title}</div>
                        <p>Click here to play this quiz!</p>
                    </div>
                </a>`;
    }

    SetupWall();
</script>
<?php
