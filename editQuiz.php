<?php
include_once 'header.php';
include_once 'questionCard.php';
include_once 'backend/models.php';
include_once 'backend/backendUtils.php';
GenerateHeader("Edit Quiz Page", ['editQuiz.css']);
CanIBeHere();

// do i own this quiz
if (isset($_GET['q'])) {
    $userSession = GetSession('current_user');
    
    // Get quiz
    $q = new quiz();
    $filters = [$q->CreateFilterExact('id', $_GET['q'])];
    $query = $q->SelectQuery(filters:$filters);
    $quizzesJSON = SelectExecution($query);
    $quizzes = json_decode($quizzesJSON);
    if (!isset($quizzes))
        header('Location: userPage.php');
    $quiz = $quizzes[0];
    if ($_GET['q'] != $quiz->id)
        header('Location: userPage.php');
}
else
    header('Location: userPage.php');

$userSession = GetSession('current_user');
if (isset($userSession))
    $id = $userSession['id'];

?>

<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div id="quiz-color-banner" class="color-banner"></div>
            <div class="options-container">
                <img class="del-icon" src="./delete.png" onclick="Delete()"/>
                <h2>Edit Quiz</h2>

                <div class="inputs-container">
                    <label for="title">Title</label>
                    <input id="title" placeholder="Quiz Name" value="<?php echo $quiz->title ?>" class="inputs" />
                    <label for="color">Color</label>
                    <input id="color" placeholder="#ffffff" value="<?php echo (null != $quiz->color)?$quiz->color:"" ?>" class="inputs" oninput="OnColorChanged()" />
                    <p>Questions:</p>
                    <div id=questions></div>
                    <button class="option-btn" onclick="OnAddQuestion()">Add Question</button>
                    <button class="option-btn" onclick="OnCreate()">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <input id="myIdHidden" type="hidden" value="<?php echo $id ?>" />
</body>
<script type="text/javascript">


    const getURLParameter = (parameterKey) => {
        const URLParams = new URLSearchParams(window.location.search);
        return URLParams.get(parameterKey);
    }

    const qid = Number(getURLParameter('q'));
    const id = Number(document.getElementById('myIdHidden').value);
    const questionsContainer = document.getElementById('questions');
    var questionsCount = -1;

    OnAddQuestion();

    const updateQuiz = async (title, color) => {
        await fetch("./backend/sqlUpdate.php?table=quiz", {
            method: 'POST',
            body: `{"quizId":${qid},"quizOwner":${id}, "quizTitle":"${title}", "color":"${color}"}`
        });
    }

    const Delete = async () => {
        await fetch('backend/sqlDelete.php?table=quiz', {
            method: 'POST',
            body: `{"quizId":"${qid}"}`
        });
        window.location.href = 'userPage.php';
    }

    function createQuestion(quizId, question = 'none', rightAnswer = 'none', wrongAnswer1 = 'none', wrongAnswer2 = 'none', wrongAnswer3 = 'none') {
        var request = new XMLHttpRequest();
        const address = "./backend/sqlInsert.php?table=question";
        const body = '{"questionContainer":"' + quizId+ '", "question":"' + question + '", "rightAnswer":"' + rightAnswer + '", "wrongAnswer1":"' + wrongAnswer1 + '", "wrongAnswer2":"' + wrongAnswer2 + '", "wrongAnswer3":"' + wrongAnswer3 + '"}';

        request.open("POST", address);
        request.send(body);
    }

    function updateQuestion(questionId, quizId, question = 'none', rightAnswer = 'none', wrongAnswer1 = 'none', wrongAnswer2 = 'none', wrongAnswer3 = 'none') {
        var request = new XMLHttpRequest();
        const address = "./backend/sqlUpdate.php?table=question";
        const body = '{"questionId":"' + questionId + '" ,"questionContainer":"' + quizId + '", "question":"' + question + '", "rightAnswer":"' + rightAnswer + '", "wrongAnswer1":"' + wrongAnswer1 + '", "wrongAnswer2":"' + wrongAnswer2 + '", "wrongAnswer3":"' + wrongAnswer3 + '"}';

        request.open("POST", address);
        request.send(body);
    }

    function OnColorChanged() {
        let hexcolor = document.getElementById("color").value;
        //WARNING: Only save the DOM elements current color in the database not what the user entered.
        if (hexcolor.length == 7 && hexcolor[0] == '#') {
            document.getElementById("quiz-color-banner").style.background = hexcolor;
        } else {
            //alert("invalid hex color");
        }
    }
    function OnAddQuestion() {
        questionsCount++;
        document.getElementById("questions").innerHTML += GenerateBlankQuestionBox(questionsCount);
    }

    async function OnRemoveQuestion(btnElement) {
        let qContainer = btnElement.parentElement;
        if (qContainer.classList.contains('existing-question'))
            await fetch('backend/sqlDelete.php?table=question', {
                method: "POST",
                body: `{"questionId":"${qContainer.id.substring(13)}"}`
            });

        qContainer.remove();
    }

    const OnCreate = async () => {
        var title =document.getElementById("title").value;
        var color = document.getElementById("color").value;

        var existingQs = Array.from(document.getElementsByClassName('existing-question'));
        var newQs = Array.from(document.getElementsByClassName('new-question'));

        await updateQuiz(title, color);

        existingQs.forEach(q => {
            var id = q.id.substring(13);
            var inputs = Array.from(q.getElementsByTagName('input'));
            updateQuestion(id, qid, inputs[0].value, inputs[1].value, inputs[2].value, inputs[3].value, inputs[4].value);
        });

        newQs.forEach(q => {
            var inputs = Array.from(q.getElementsByTagName('input'));
            createQuestion(qid, inputs[0].value, inputs[1].value, inputs[2].value, inputs[3].value, inputs[4].value);
        });

        window.location.href = 'userPage.php';
    }

    function GenerateBlankQuestionBox(number) {
        return '<div id="question-card' + number + '" class="question-card new-question"><h3>Question ' + number + '</h3><label for="title">Question</label><input id="question" class="inputs" value=""/><div class="answer-box"><label for="rightAnswer-' + number + '">Correct Answer</label><input id="rightAnswer-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer1-' + number + '">Wrong Answer 1</label><input id="wrongAnswer1-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer2-' + number + '">Wrong Answer 2</label><input id="wrongAnswer2-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer3-' + number + '">Wrong Answer 3</label><input id="wrongAnswer3-' + number + '" class="inputs" value=""/></div><button class="" onclick="OnRemoveQuestion(this)">Delete</button></div>';
    }

    function GenerateQuestionBox(number, question = '', rightAnswer = '', wrongAnswer1 = '', wrongAnswer2 = '', wrongAnswer3 = '') {
        return '<div id="question-card' + number + '" class="question-card existing-question"><h3>Question ' + questionsCount + '</h3><label for="title">Question</label><input id="question-' + number + '" class="inputs" value="' + question + '" /><div class="answer-box"><label for="rightAnswer-' + number + '">Correct Answer</label><input id="rightAnswer-' + number + '" class="inputs" value="' + rightAnswer + '" /></div><div class="answer-box"><label for="wrongAnswer1-' + number + '">Wrong Answer 1</label><input id="wrongAnswer1-' + number + '" class="inputs" value="' + wrongAnswer1 + '"/></div><div class="answer-box"><label for="wrongAnswer2-' + number + '">Wrong Answer 2</label><input id="wrongAnswer2-' + number + '" class="inputs" value="' + wrongAnswer2 + '"/></div><div class="answer-box"><label for="wrongAnswer3-' + number + '">Wrong Answer 3</label><input id="wrongAnswer3-' + number + '" class="inputs" value="' + wrongAnswer3 + '"/></div><button class="" onclick="OnRemoveQuestion(this)">Delete</button></div>';
        return '<div id="question-card' + number + '" class="question-card existing-question"><h3>Question ' + questionsCount + '</h3><label for="title">Question</label><input id="question-' + number + '" class="inputs" value="' + question + '" /><div class="answer-box"><label for="rightAnswer-' + number + '">Correct Answer</label><input id="rightAnswer-' + number + '" class="inputs" value="' + rightAnswer + '" /></div><div class="answer-box"><label for="wrongAnswer1-' + number + '">Wrong Answer 1</label><input id="wrongAnswer1-' + number + '" class="inputs" value="' + wrongAnswer1 + '"/></div><div class="answer-box"><label for="wrongAnswer2-' + number + '">Wrong Answer 2</label><input id="wrongAnswer2-' + number + '" class="inputs" value="' + wrongAnswer2 + '"/></div><div class="answer-box"><label for="wrongAnswer3-' + number + '">Wrong Answer 3</label><input id="wrongAnswer3-' + number + '" class="inputs" value="' + wrongAnswer3 + '"/></div><button class="" onclick="OnRemoveQuestion(this)">Delete</button></div>';
    }

    const startup = async () => {
        const response = await fetch('backend/sqlJoin.php?join=questions', {
            method: 'POST',
            body: '{"quizId":"<?php echo $quiz->id ?>"}'
        });
        const questions = await response.json();
        let htmlQuestions = [];
        questions.forEach(q => {
            questionsCount++;
            htmlQuestions.push(GenerateQuestionBox(q.id, q.content, q.rightAnswer, q.wrong1, q.wrong2, q.wrong3));
        });
        questionsContainer.innerHTML = htmlQuestions.join('\n');
    }

    startup();

</script>