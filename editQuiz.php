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
                    <?php 
                        GenerateQuestionBox();
                        GenerateQuestionBox(2);
                    ?>
                    <button class="option-btn">Add Question</button>
                    <button class="option-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    if(getURLParameter('update') == true){
        //load data current from database
        var request = new XMLHttpRequest();

    }else {
        //generate a default question box
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

    getURLParameter = (parameterKey) => {
        const URLParams = new URLSearchParams(window.location.search);
        return URLParams.get(parameterKey);
    }
</script>
<?php
