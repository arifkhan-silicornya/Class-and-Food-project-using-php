<?php
userOnly();

if (! isset($_GET['q']))
{
    $_GET['q'] = "";
}

$type = "all";

if (! empty($_GET['type']))
{
    $type = $_GET['type'];
}

$search_query = $escapeObj->stringEscape($_GET['q']);
$html = '';

foreach (getFollowSuggestionsData($search_query, 5, $type) as $k => $v)
{
    $timelineObj = new \miuan\User();
    $timelineObj->setId($v);
    $timeline = $timelineObj->getRows();
    
    $themeData['list_suggestion_id'] = $timeline['id'];
    $themeData['list_suggestion_url'] = $timeline['url'];
    $themeData['list_suggestion_username'] = $timeline['username'];
    $themeData['list_suggestion_name'] = $timeline['name'];
    $themeData['list_suggestion_thumbnail_url'] = $timeline['thumbnail_url'];

    if ($timeline['type'] == "user")
    {
        if (! empty($timeline['current_city']))
        {
            $themeData['list_suggestion_info'] = $timeline['current_city'];
        }
    }
    elseif ($timeline['type'] == "page")
    {
        $category = getPageCategoryData($timeline['category_id']);
        $themeData['list_suggestion_info'] = $category['name'];
    }
    elseif ($timeline['type'] == "group")
    {
        $themeData['list_suggestion_info'] = ucwords($timeline['group_privacy']) . ' Group';

    }

    $themeData['follow_id'] = $timeline['id'];
    $themeData['list_suggestion_button'] = $timelineObj->getFollowButton();

    $html .= \miuan\UI::view('suggestions/follow-suggestions-each');
}

$data = array(
    'status' => 200,
    'html' => $html
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();