<?php
include_once 'utility.php';

/**
 * Generates head tag and echo's result.
 * @param string $title Title of the page being generated. If null, will default to 'Kahoot2'.
 * @param array $stylesheets Array of paths to style sheets to be used.
 */
function GenerateHeader($title, $stylesheets = array()) {
    ValidateHeaderTitle($title);
    $links = CreateLinkTags($stylesheets);
    $header =  '
        <head>
            <title>'.$title.'</title>
            '.$links.'
        </head>';
    echo $header;
}
/**
 * Generates nav tag and echo's result.
 */
function GenerateNavigationElement() {
    $pages = BuildPagesArray();

    $navigationElement = '<nav class="navLinks">';
    foreach (array_keys($pages) as $pageKey)
    {
        $page = $pages[$pageKey];
        $navigationElement .= "<a href=".$page.">".$pageKey."</a>";

        if (array_key_last($pages) != $pageKey)
            $navigationElement .= "&nbsp; &nbsp;";
    }
    echo $navigationElement."</nav><br/>";
}

/**
 * Creates an array that will be used to construct nav bar.
 * Checks against cookies to see if use is logged in.
 * @return array<string> Associative array of links and link titles.
 */
function BuildPagesArray() {
    $pages = array(
        "Home"=>"index.php",
        "Find-A-Quiz"=>"quizzes.php",
    );

    if (GetCookie('login')) {
        $pages["Profile"] = 'userPage.php';
        $pages["Logout"] = "logout.php";
    }
    else {
        $pages["Create Account"] = "createAccount.php";
        $pages["Login"] = "login.php";
    }

    return $pages;
}

function ValidateHeaderTitle(&$title) {
    if (IsNullOrEmptyString($title))
        $title = 'Kahoot2';
}

function CreateLinkTags($additionalStylesheets = array()) {
    $returnVal = "";
    foreach ($additionalStylesheets as $stylesheet)
    {
    	$returnVal .= '<link rel="stylesheet" href="'.$stylesheet.'" />';
    }
    return $returnVal;
}
?>