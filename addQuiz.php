<?php
include_once 'header.php';
include_once 'questionCard.php';
GenerateHeader("Edit Quiz Page", ['editQuiz.css']);
?>

<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div id="quiz-color-banner" class="color-banner"></div>
            <div class="options-container">
                <img class="del-icon" src="./delete.png" />
                <h2>Create Quiz</h2>

                <div class="inputs-container">
                    <label for="title">Title</label>
                    <input id="title" placeholder="Quiz Name" value="My Quiz" class="inputs" />
                    <label for="color">Color</label>
                    <input id="color" placeholder="#ffffff" value="#316bff" class="inputs" oninput="OnColorChanged()" />
                    <p>Questions:</p>
                    <div id=questions>
                    </div>
                    <button class="option-btn" onclick="OnAddQuestion()">Add Question</button>
                    <button class="option-btn" onclick="OnCreate()">Create</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">

    const getURLParameter = (parameterKey) => {
        const URLParams = new URLSearchParams(window.location.search);
        return URLParams.get(parameterKey);
    }

    var id = getURLParameter("userId");
    var questionsCount = 0;
    var quizId;

    OnAddQuestion();

    function createQuiz() {
        var request = new XMLHttpRequest();

        var title =document.getElementById("title").value;
        var color = document.getElementById("color").value;

        const address = "./backend/sqlInsert.php?table=quiz";
        const body = '{"quizOwner":"' + id + '", "quizTitle":"' + title + '", "color":"' + color + '"}';

        request.open("POST", address);
        request.send(body);
    }

    function getQuiz(title) {
        var request = new XMLHttpRequest();

        var title =document.getElementById("title").value;
        var color = document.getElementById("color").value;

        const address = "./backend/sqlInsert.php?table=quiz";
        const body = '{"quizOwner":"' + id + '", "quizTitle":"' + title + '", "color":"' + color + '"}';

        request.open("POST", address);
        request.send(body);
    }

    function createQuestion(userId, question = 'none', rightAnswer = 'none', wrongAnswer1 = 'none', wrongAnswer2 = 'none', wrongAnswer3 = 'none') {
        var request = new XMLHttpRequest();
        const address = "./backend/sqlInsert.php?table=question";
        const body = '{"questionContainer":"' + userId + '", "question":"' + question + '", "rightAnswer":"' + rightAnswer + '", "wrongAnswer1":"' + wrongAnswer1 + '", "wrongAnswer2":"' + wrongAnswer2 + '", "wrongAnswer3":"' + wrongAnswer3 + '"}';

        request.open("POST", address);
        //request.onload = onDataLoaded;
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

    function OnRemoveQuestion(number) {
        console.log(number);
        // var element =document.getElementById("question-card" + number);
        // element.parentNode.removeChild(element);
        let i = number;
        while (i < questionsCount) {
            var question = document.getElementById("question-" + (i + 1)).value;
            var rightAnswer = document.getElementById("rightAnswer-" + (i + 1)).value;
            var wrongAnswer1 = document.getElementById("wrongAnswer1-" + (i + 1)).value;
            var wrongAnswer2 = document.getElementById("wrongAnswer2-" + (i + 1)).value;
            var wrongAnswer3 = document.getElementById("wrongAnswer3-" + (i + 1)).value;

            document.getElementById("question-" + i).value = question;
            document.getElementById("rightAnswer-" + i).value = rightAnswer;
            document.getElementById("wrongAnswer1-" + i).value = wrongAnswer1;
            document.getElementById("wrongAnswer2-" + i).value = wrongAnswer2;
            document.getElementById("wrongAnswer3-" + i).value = wrongAnswer3;
            i++;
        }
        console.log(i);
        var element = document.getElementById("question-card" + i);
        element.parentNode.removeChild(element);
        questionsCount--;
    }

    function OnCreate() {
        createQuiz();
        let i = 1;
        while (i <= questionsCount) {
            var question = document.getElementById("question-" + i);
            var rightAnswer = document.getElementById("rightAnswer-" + i);
            var wrongAnswer1 = document.getElementById("wrongAnswer1-" + i);
            var wrongAnswer2 = document.getElementById("wrongAnswer2-" + i);
            var wrongAnswer3 = document.getElementById("wrongAnswer3-" + i);
            createQuestion(quizId, question.value, rightAnswer.value, wrongAnswer1.value, wrongAnswer2.value, wrongAnswer3.value);
            i++;
        }
    }

    function GenerateBlankQuestionBox(number) {
        return '<div id="question-card' + number + '" class="question-card"><h3>Question ' + number + '</h3><label for="title">Question</label><input id="question-' + number + '" class="inputs" value=""/><div class="answer-box"><label for="rightAnswer-' + number + '">Correct Answer</label><input id="rightAnswer-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer1-' + number + '">Wrong Answer 1</label><input id="wrongAnswer1-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer2-' + number + '">Wrong Answer 2</label><input id="wrongAnswer2-' + number + '" class="inputs" value=""/></div><div class="answer-box"><label for="wrongAnswer3-' + number + '">Wrong Answer 3</label><input id="wrongAnswer3-' + number + '" class="inputs" value=""/></div><button class="" onclick="OnRemoveQuestion(' + number + ')">Delete</button></div>';
    }

    function GenerateQuestionBox(number, question = '', rightAnswer = '', wrongAnswer1 = '', wrongAnswer2 = '', wrongAnswer3 = '') {
        return '<div id="question-card' + number + '" class="question-card"><h3>Question ' + number + '</h3><label for="title">Question</label><input id="question-' + number + '" class="inputs" value="' + question + '" /><div class="answer-box"><label for="rightAnswer-' + number + '">Correct Answer</label><input id="rightAnswer-' + number + '" class="inputs" value="' + rightAnswer + '" /></div><div class="answer-box"><label for="wrongAnswer1-' + number + '">Wrong Answer 1</label><input id="wrongAnswer1-' + number + '" class="inputs" value="' + wrongAnswer1 + '"/></div><div class="answer-box"><label for="wrongAnswer2-' + number + '">Wrong Answer 2</label><input id="wrongAnswer2-' + number + '" class="inputs" value="' + wrongAnswer2 + '"/></div><div class="answer-box"><label for="wrongAnswer3-' + number + '">Wrong Answer 3</label><input id="wrongAnswer3-' + number + '" class="inputs" value="' + wrongAnswer3 + '"/></div><button class="" onclick="OnRemoveQuestion(' + number + ')">Delete</button></div>';
    }
</script>