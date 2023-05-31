<?php
include_once 'header.php';
include_once 'utility.php';
include_once 'backend/backendUtils.php';
include_once 'backend/models.php';
GenerateHeader('User Page', ['userPage.css']);
CanIBeHere();
$myPage = false;
$username = '';

if (isset($_GET['u']))
    $userSession = GetSession('current_user');
    if (isset($userSession))
        if ($userSession['username'] == $_GET['u'])
            $myPage = true;

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
    <input id="myPageHidden" type="hidden" value="<?php echo $myPage ?>" />
</body>

<script>
    const isMyPage = document.getElementById('myPageHidden').value;
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

        // if my page then add addquiz option
        if (isMyPage) {
            quizElements.push(`
                <a class="quiz-card" href="./addQuiz.php">
                    <div class="quiz-body">
                        <div class="quiz-title">Create New Quiz</div>
                    </div>
                </a>`);
        }

        // apply to container
        container.innerHTML = quizElements.join('\n');
    }

    const QuizElement = (data) => {
        let quizElement = `
                <div class="quiz-card">
                    <div class="quiz-body">
                        <div class="quiz-title">${data.title}</div>
                        <div class="quiz-link-cont">
                            <a href="./playQuiz.php?q=${data.id}">PLAY!</a>
                            ${(isMyPage) ? `<a href="./editQuiz.php?quiz_id=${data.id}">EDIT!</a>` : ''}
                        </div>
                    </div>
                </div>`;

        return quizElement;
    }

    getUserData();
</script>
<?php
