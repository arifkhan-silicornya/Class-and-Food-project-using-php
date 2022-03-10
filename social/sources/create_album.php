<?php

if (! isLogged())
{
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
/* Suggestions */
$themeData['suggestions'] = getFollowSuggestions('', 5, 'user');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'page');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'group');

/* Trending */
$themeData['trendings'] = getTrendings('popular');

$themeData['sidebar'] = \miuan\UI::view('album/create/sidebar');
$themeData['end'] = \miuan\UI::view('album/create/end');
/* */

$themeData['page_content'] = \miuan\UI::view('album/create/content');
?>