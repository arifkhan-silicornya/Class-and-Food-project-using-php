<?php

$changeAvatar = false;

if (isLogged())
{
    if ($timeline['id'] == $user['id'])
    {
        $changeAvatar = true;
    }
}

if ($changeAvatar)
{
    $themeData['change_avatar_html'] = \miuan\UI::view('timeline/user/change-avatar');
}

if ($timeline['verified'] == true)
{
	$themeData['verified_badge'] = \miuan\UI::view('timeline/user/verified-badge');
}

$owner = false;
$post_visibility_privacy = true;
$themeData['followrequests_num'] = $timelineObj->numFollowRequests();
$themeData['following_num'] = $timelineObj->numFollowing();
$themeData['followers_num'] = $timelineObj->numFollowers();
$themeData['page_likes_num'] = $timelineObj->numPageLikes();
$themeData['groups_joined_num'] = $timelineObj->numGroupsJoined();
$themeData['stories_num'] = $timelineObj->numStories();

$themeData['followrequests_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=requests&id=' . $timeline['username']);
$themeData['friends_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=friends&id=' . $timeline['username']);
$themeData['following_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=following&id=' . $timeline['username']);
$themeData['followers_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=followers&id=' . $timeline['username']);
$themeData['page_likes_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=likes&id=' . $timeline['username']);
$themeData['groups_joined_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=groups&id=' . $timeline['username']);
$themeData['stories_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=stories&id=' . $timeline['username']);
$themeData['settings_tab_url'] = smoothLink('index.php?tab1=settings');

if (isset($user))
{
    if ($timeline['id'] == $user['id'])
    {
        $owner = true;
    }
}

if ($timeline['post_privacy'] == "following")
{
    $post_visibility_privacy = false;

    if (isset($user) && is_array($user))
    {
        if ($owner == true or $timelineObj->isFollowing())
        {
            $post_visibility_privacy = true;
        }
    }
}

if (isLogged() && $owner == true && $themeData['followrequests_num'] > 0)
{
	$themeData['follow_requests_link'] = \miuan\UI::view('timeline/user/follow-requests-link');
}

if ($post_visibility_privacy == true)
{
	$themeData['stories_link'] = \miuan\UI::view('timeline/user/stories-link');
}

if ($config['friends'] == true)
{
	$themeData['following_link'] = \miuan\UI::view('timeline/user/friends-link');
}
else
{
	$themeData['following_link'] = \miuan\UI::view('timeline/user/following-link');
}

if (isLogged() == true)
{
    if ($owner == true)
    {
        $themeData['timeline_buttons'] = \miuan\UI::view('timeline/user/timeline-buttons-admin');
    }
    else
    {
        $showFollowButton = false;

        if ($config['friends'] == true)
        {
            $showFollowButton = true;
        }
        else
        {
            if ($timeline['follow_privacy'] == "everyone" or ($timeline['follow_privacy'] == "following" && $timelineObj->isFollowing()))
            {
                $showFollowButton = true;
            }
        }

        if ($showFollowButton == true)
        {
            $themeData['follow_button'] = $timelineObj->getFollowButton();
            $themeData['follow_button_html'] = \miuan\UI::view('timeline/user/follow-button');
        }

        if ($timeline['message_privacy'] == "everyone" or ($timeline['message_privacy'] == "following" && $timelineObj->isFollowing()))
        {
            $themeData['message_button_url'] = smoothLink('index.php?tab1=messages&recipient_id=' . $timeline['id']);
            $themeData['message_button_html'] = \miuan\UI::view('timeline/user/message-button');
        }

        $themeData['timeline_buttons'] = \miuan\UI::view('timeline/user/timeline-buttons-default');
    }
}

$themeData['gender_label'] = ucfirst($lang['gender_' . $timeline['gender'] . '_label']);

if (! empty($timeline['gender']))
{
    $themeData['info_gender_row'] = \miuan\UI::view('timeline/user/info-gender-row');
}

if (! empty($timeline['birth']))
{
    $months = getMonths();
    $themeData['timeline_birth_month_name'] = ucfirst($months[$timeline['birth']['month']][1]);
    $themeData['info_birthday_row'] = \miuan\UI::view('timeline/user/info-birthday-row');
}

if (! empty($timeline['current_city']))
{
    $themeData['info_location_row'] = \miuan\UI::view('timeline/user/info-location-row');
}

if (! empty($timeline['hometown']))
{
    $themeData['info_hometown_row'] = \miuan\UI::view('timeline/user/info-hometown-row');
}

if (! empty($timeline['about']))
{
    $themeData['info_about_row'] = \miuan\UI::view('timeline/user/info-about-row');
}

if (isset($_GET['tab2']) && $_GET['tab2'] == "requests" && $owner == true)
{
    if ($config['friends'] == true)
    {
        $themeData['follow_requests_label'] = $lang['friends_requests_label'];
        $themeData['no_follow_requests_label'] = $timeline['name'] . ' ' . $lang['no_friends'];
    }
    else
    {
        $themeData['follow_requests_label'] = $lang['follow_requests_label'];
        $themeData['no_follow_requests_label'] = $timeline['name'] . ' ' . $lang['no_follow_requests'];
    }

    $i = 0;
    $listFollowRequests = '';

    foreach ($timelineObj->getFollowRequests() as $requestId)
    {
        $requestObj = new \miuan\User();
        $requestObj->setId($requestId);
        $request = $requestObj->getRows();

        $themeData['list_request_id'] = $request['id'];
        $themeData['list_request_url'] = $request['url'];
        $themeData['list_request_username'] = $request['username'];
        $themeData['list_request_name'] = $request['name'];
        $themeData['list_request_thumbnail_url'] = $request['thumbnail_url'];

        if ($owner == true)
        {
            $themeData['list_request_buttons'] = \miuan\UI::view('timeline/user/follow-request-button');
        }

        $listFollowRequests .= \miuan\UI::view('timeline/user/list-followrequests-each');
        $i++;
    }

    if ($i < 1)
    {
        $listFollowRequests .= \miuan\UI::view('timeline/user/no-requests');
    }

    $themeData['list_follow_requests'] = $listFollowRequests;
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/requests-tab');
}
elseif (isset($_GET['tab2']) && ($_GET['tab2'] == "following" or $_GET['tab2'] == "friends"))
{
    if ($config['friends'] == true)
    {
        $themeData['following_header_label'] = $lang['friends_label'];
        $themeData['no_followings'] = $lang['no_friends'];
    }
    else
    {
        $themeData['following_header_label'] = $lang['following_label'];
        $themeData['no_followings'] = $lang['no_followings'];
    }

    $listFollowings = '';
    $i = 0;
    
    foreach ($timelineObj->getFollowings() as $followingId)
    {
        $followingObj = new \miuan\User();
        $followingObj->setId($followingId);
        $following = $followingObj->getRows();

        $themeData['list_following_id'] = $following['id'];
        $themeData['list_following_url'] = $following['url'];
        $themeData['list_following_username'] = $following['username'];
        $themeData['list_following_name'] = $following['name'];
        $themeData['list_following_thumbnail_url'] = $following['thumbnail_url'];

        $themeData['list_following_button'] = $followingObj->getFollowButton();

        $listFollowings .= \miuan\UI::view('timeline/user/list-followings-each');
        $i++;
    }

    if ($i < 1)
    {
        $listFollowings .= \miuan\UI::view('timeline/user/no-followings');
    }

    $themeData['list_followings'] = $listFollowings;
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/followings-tab');
}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "followers" && $config['friends'] !== true)
{
    $listFollowers = '';
    $i = 0;

    foreach ($timelineObj->getFollowers() as $followerId)
    {
        $followerObj = new \miuan\User();
        $followerObj->setId($followerId);
        $follower = $followerObj->getRows();

        $themeData['list_follower_id'] = $follower['id'];
        $themeData['list_follower_url'] = $follower['url'];
        $themeData['list_follower_username'] = $follower['username'];
        $themeData['list_follower_name'] = $follower['name'];
        $themeData['list_follower_thumbnail_url'] = $follower['thumbnail_url'];

        $themeData['list_follower_button'] = $followerObj->getFollowButton();

        $listFollowers .= \miuan\UI::view('timeline/user/list-followers-each');
        $i++;
    }

    if ($i < 1)
    {
        $listFollowers .= \miuan\UI::view('timeline/user/no-followers');
    }

    $themeData['list_followers'] = $listFollowers;
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/followers-tab');
}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "likes")
{
    $listPageLikes = '';
    $i = 0;
    
    foreach ($timelineObj->getLikedPages() as $pageId)
    {
        $pageObj = new \miuan\User();
        $pageObj->setId($pageId);
        $page = $pageObj->getRows();

        $themeData['list_page_id'] = $page['id'];
        $themeData['list_page_url'] = $page['url'];
        $themeData['list_page_username'] = $page['username'];
        $themeData['list_page_name'] = $page['name'];
        $themeData['list_page_thumbnail_url'] = $page['thumbnail_url'];

        $themeData['list_like_button'] = $pageObj->getFollowButton();

        $listPageLikes .= \miuan\UI::view('timeline/user/list-page-likes-each');
        $i++;
    }

    if ($i < 1)
    {
        $listPageLikes .= \miuan\UI::view('timeline/user/no-page-likes');
    }

    $themeData['list_page_likes'] = $listPageLikes;
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/page-likes-tab');
}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "groups")
{
    $listGroupsJoined = '';
    $i = 0;

    foreach ($timelineObj->getGroupsJoined() as $groupId)
    {
        $groupObj = new \miuan\User();
        $groupObj->setId($groupId);
        $group = $groupObj->getRows();

        $themeData['list_group_id'] = $group['id'];
        $themeData['list_group_url'] = $group['url'];
        $themeData['list_group_username'] = $group['username'];
        $themeData['list_group_name'] = $group['name'];
        $themeData['list_group_thumbnail_url'] = $group['thumbnail_url'];

        $themeData['list_join_button'] = $groupObj->getFollowButton();

        $listGroupsJoined .= \miuan\UI::view('timeline/user/list-groups-joined-each');
        $i++;
    }

    if ($i < 1)
    {
        $listGroupsJoined .= \miuan\UI::view('timeline/user/no-groups-joined');
    }

    $themeData['list_groups_joined'] = $listGroupsJoined;
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/groups-joined-tab');
}
else
{
    if (isLogged() == true)
    {
        $themeData['story_postbox'] = getStoryPostBox(0, $timeline['id']);
    }

    $feedObj = new \miuan\Feed($conn);
    $feedObj->setTimelineId($timeline['id']);
    $themeData['stories'] = $feedObj->getTemplate();
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/stories-tab');
}

$themeData['sidebar_postfilters'] = \miuan\UI::view('timeline/user/sidebar-post-filters');

if ($post_visibility_privacy == true)
{
    $themeData['sidebar_albums'] = $timelineObj->getAlbumsTemplate();
}

if ($owner == true)
{
    $themeData['end'] = \miuan\UI::view('timeline/user/admin-end');
}
else
{
    $themeData['end'] = \miuan\UI::view('timeline/user/default-end');
}

/* */
$themeData['page_content'] = \miuan\UI::view('timeline/user/content');