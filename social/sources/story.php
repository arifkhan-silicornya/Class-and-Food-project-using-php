<?php

$postId = (int) $_GET['id'];
$storyObj = new \miuan\Story($conn);
$storyObj->setId($postId);

/* */
$available = true;
$template = $storyObj->getTemplate();

if (empty($template))
{
	$available = false;
}


if ($available)
{
    $themeData['tab_content'] = $storyObj->getTemplate();

} else {
    $themeData['tab_content'] = \miuan\UI::view('story-page/no-post');
}

if (isLogged())
{
	/* Suggestions */
	$themeData['suggestions'] = getFollowSuggestions('', 5, 'user');
	$themeData['suggestions'] .= getFollowSuggestions('', 5, 'page');
	$themeData['suggestions'] .= getFollowSuggestions('', 5, 'group');

	/* Trending */
	$themeData['trendings'] = getTrendings('popular');
	
    $themeData['sidebar'] = \miuan\UI::view('story-page/sidebar');
    $themeData['end'] = \miuan\UI::view('story-page/end');
}
/* */

$themeData['page_content'] = \miuan\UI::view('story-page/content');