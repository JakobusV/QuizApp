<?php
include_once 'header.php';
include_once 'backend/backendUtils.php';
include_once 'backend/models.php';
GenerateHeader('User Page', ['userPage.css']);
//CanIBeHere();



?>
<body>
    <?php
    GenerateNavigationElement();
    ?>
    <div class="body-container">
        <div class="info-container">
            <div class="gradient-banner"></div>
            <div class="user-container">
                <h2 id="username"></h2>
                <hr />
                <p>Your Quizzes</p>
                <div class="quizzes-container">
                </div>
            </div>
        </div>
        <img class="profile-img"
            src="https://th.bing.com/th/id/R.6e0f2f6bab06c008c79a3b280db49342?rik=jsupiHsPJSF3lA&riu=http%3a%2f%2fassets0.prcdn.com%2fuk%2fpeople%2fdefault-profile.png%3f1406639312&ehk=fgzMewvFjuDc4jTAGFrQAJ%2fhZD3vLHtzxhxb%2bnle3cU%3d&risl=&pid=ImgRaw&r=0" />
    </div>
</body>

<script>
    const getUserData = async () => {
        // get username from url param
        var urlFormatParams = window.location.search;
        var params = new URLSearchParams(urlFormatParams);
        var username = params.get('u');

        // call api for that users info
        const response = await fetch('backend/sqlJoin.php?join=profile', {
            method: 'POST',
            body: `{"username": "${username}"}`,
            headers: { 'Content-Type': 'application/json' }
        });
        const json = await response.json();

        // get username element
        var headerUsername = document.getElementById('username');
        headerUsername.innerHTML = username;

        // check if there's a need to try populate
        if (json == []) {
            return;
        }

        // get quiz element container
        var container = document.getElementsByClassName('quizzes-container')[0];

        // container for all html elements
        let quizElements = [];
        // for each row
        json.forEach((data) => {
            quizElements.push(QuizElement(data));
        });
        // apply to container
        container.innerHTML = quizElements.join('\n');
    }

    const QuizElement = (data) => {
        return `<a class="quiz-card" href="./playQuiz.php?q=${data.id}">
                    <div class="quiz-body">
                        <div class="quiz-title">${data.title}</div>
                        <p>Click to play quiz!</p>
                    </div>
                </a>`;
    }

    getUserData();
</script>
<?php
