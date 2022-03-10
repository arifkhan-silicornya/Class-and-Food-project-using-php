<?php
if (!empty($_GET['query']))
{
    $search_query = $escapeObj->stringEscape($_GET['query']);
    $i = 0;
    $listResults = '';

    foreach (getSearch($search_query, 0, 30) as $searchId)
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($searchId);
        $timeline = $timelineObj->getRows();

    	$themeData['list_search_id'] = $timeline['id'];
    	$themeData['list_search_url'] = $timeline['url'];
    	$themeData['list_search_username'] = $timeline['username'];
    	$themeData['list_search_name'] = $timeline['name'];
    	$themeData['list_search_thumbnail_url'] = $timeline['thumbnail_url'];

    	$themeData['list_search_button'] = $timelineObj->getFollowButton();

        $listResults .= \miuan\UI::view('search/list-each');
        $i++;
    }

    $themeData['list_search_results'] = $listResults;
}

/* */
/* Suggestions */
$themeData['suggestions'] = getFollowSuggestions('', 5, 'user');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'page');
$themeData['suggestions'] .= getFollowSuggestions('', 5, 'group');

/* Trending */
$themeData['trendings'] = getTrendings('popular');


if (isLogged())
{
    $themeData['sidebar'] = \miuan\UI::view('search/sidebar');
}

if ($config['smooth_links'] == 1)
{
    $themeData['end'] = \miuan\UI::view('search/end');
}
/* */

$themeData['page_content'] = \miuan\UI::view('search/content');
