<?php
include_once 'header.php';
include_once 'question.php';
GenerateHeader("Play Quiz Page", ['playQuiz.css']);
?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <?php
                GenerateQuestionElement(1, "What is the Capital of Spain?", "Madrid", array('Florence', 'Paris', 'Mexico City'));
            ?>
        </div>
    </div>
</body>
<?php
