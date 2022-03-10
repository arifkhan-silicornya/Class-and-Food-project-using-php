<?php
if (! isLogged())
{
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
$themeData['announcements'] = getAnnouncements();

if (isLogged())
{
    $themeData['story_postbox'] = getStoryPostBox();
}

/* Stories */
$feedObj = new \miuan\Feed($conn);
$themeData['stories'] = $feedObj->getTemplate();

/* Post Filters */
$themeData['story_postfilters'] = \miuan\UI::view('home/sidebar-post-filters');

/* Suggestions */
$themeData['suggestions'] = getFollowSuggestions('', 5, 'user');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'page');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'group');

/* Trending */
$themeData['trendings'] = getTrendings('popular');

/* Sidebar */
$themeData['sidebar'] = \miuan\UI::view('story-page/sidebar');
/* */

$themeData['page_content'] = \miuan\UI::view('home/content');
