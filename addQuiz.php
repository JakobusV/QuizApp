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
                <h2>Edit/Create Quiz</h2>

                <div class="inputs-container">
                    <label for="title">Title</label>
                    <input id="title" placeholder="My Quiz" class="inputs" />
                    <label for="color">Color</label>
                    <input id="color" placeholder="#ffffff" value="#316bff" class="inputs" oninput="OnColorChanged()"/>
                    <p>Questions:</p>
                    <div id=questions>
                    <?php 
                        GenerateQuestionBox();
                        GenerateQuestionBox(2);
                    ?>
                    </div>
                    <button class="option-btn">Add Question</button>
                    <button class="option-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">

    function createQuiz() {
        var request = new XMLHttpRequest();
        const id = getURLParameter("quiz_id");

        const address = "./backend/sqlInsert.php?table=quiz";
        request.open("GET", address);
        const body = '{"quizOwner":"'+email+'", "quizTitle":"'+title+'", "color":"'+color+'"}';
        request.onload = onDataLoaded;
        request.send(body);

        const onDataLoaded = (event) => {
            var data = event;
            var response = request.responseText;    
            data = JSON.parse(response);
        }
    }

    function createQuestions(data){
        var request = new XMLHttpRequest();
        const id = getURLParameter("quiz_id");
        const address = "./backend/sqlSelect.php?table=quiz&quizId=" + quizId;

        request.open("GET", address);
        request.onload = onDataLoaded;
        request.send();

        const onDataLoaded = (event) => {
            var data = event;
            var response = request.responseText;    
            data = JSON.parse(response);
            
            console.log(data);

        }
    }

    function OnColorChanged(){
        let hexcolor = document.getElementById("color").value;
        //WARNING: Only save the DOM elements current color in the database not what the user entered.
        if(hexcolor.length == 7 && hexcolor[0] == '#'){
            document.getElementById("quiz-color-banner").style.background = hexcolor;
        } else {
            //alert("invalid hex color");
        }
    }

    function SaveQuiz(){
        var request = new XMLHttpRequest();

        var name = document.getElementById("name").value;
        var color = document.getElementById("quiz-color-banner").style.background.valueOf("#");
        
        var body = '{"name":"'+email+'", "color":"'+color+'", ""}'

        request.open('POST', '../Backend/sqlInsert.php')
        request.send(body)
        request.onload = OnLoadJson
    }

    getURLParameter = (parameterKey) => {
        const URLParams = new URLSearchParams(window.location.search);
        return URLParams.get(parameterKey);
    }
</script>
<?php
