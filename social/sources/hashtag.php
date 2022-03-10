<?php

if (! empty($_GET['query']))
{
    $searchQuery = str_replace('#', '', $escapeObj->stringEscape($_GET['query']));
    $hashdata = getHashtag($searchQuery);
    
    if (is_array($hashdata) && count($hashdata) > 0)
    {
        $search_string = "#[" . $hashdata['id'] . "]";

        $query = $conn->query("SELECT id FROM " . DB_POSTS . " WHERE text LIKE '%$search_string%' AND hidden=0 AND active=1");
        $storiesHtml = '';
        
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $storyObj = new \miuan\Story();
            $storyObj->setId($fetch['id']);
            $story = $storyObj->getRows();

            if (isset($story['id']))
            {
                $storiesHtml .= $storyObj->getTemplate();
            }
        }

        $themeData['stories'] = $storiesHtml;
    }
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
    $themeData['sidebar'] = \miuan\UI::view('hashtag/sidebar');
}

if ($config['smooth_links'] == 1)
{
    $themeData['end'] = \miuan\UI::view('hashtag/smooth-end');
}
else
{
    $themeData['end'] = \miuan\UI::view('hashtag/default-end');
}
/* */

$themeData['page_content'] = \miuan\UI::view('hashtag/content');
