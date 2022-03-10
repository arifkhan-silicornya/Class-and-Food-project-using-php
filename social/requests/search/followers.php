<?php
userOnly();

$searchQuery = $escapeObj->stringEscape($_GET['q']);
$html = '';

foreach ($userObj->getFollowers($searchQuery) as $k => $v) {
    $followerObj = new \miuan\User();
    $followerObj->setId($v);
    $follower = $followerObj->getRows();

    $themeData['list_user_id'] = $follower['id'];
    $themeData['list_user_url'] = $follower['url'];
    $themeData['list_user_name'] = $follower['name'];
    $themeData['list_user_thumbnail_url'] = $follower['thumbnail_url'];
    $themeData['list_user_button'] = $followerObj->getFollowButton();
    
    if ($follower['type'] == "user")
    {
        if (! empty($follower['current_city']))
        {
            $themeData['list_user_info'] = $follower['current_city'];
        }
    }
    elseif ($follower['type'] == "page")
    {
        $category = SK_getPageCategoryData($follower['category_id']);
        $themeData['list_user_info'] = $category['name'];
    }
    elseif ($follower['type'] == "group")
    {
        $themeData['list_user_info'] = ucwords($follower['group_privacy']);
    }

    $html .= \miuan\UI::view('lists/followers');
}

$data = array(
    'status' => 200,
    'html' => $html
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();