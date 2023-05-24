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

    $navigationElement = '<nav>';
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
        "Profile"=>"profile.php",
        "Find-A-Quiz"=>"quizzes.php",
    );

    if (GetCookie('login'))
        $pages["Logout"] = "logout.php";
    else
        $pages["Login"] = "login.php";

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

/**
 * Checks user session for logged in session. If admin is true, checks if the current user is an admin as well.
 * @param bool $admin Set to true to check for admin account, defaults to false.
 */
function CanIBeHere($admin = false) {
    $loginURL = 'login.php';
    $profileURL = 'profile.php';

    $userSession = GetSession("current_user");
    if ($userSession == null) {
        header('Location: '.$loginURL);
        die();
    }
    else if ($admin)
    {
        if (!isset($userSession["auth"]) || $userSession['auth'] == 0)
            header('Location: '.$profileURL);
    }

}
?>