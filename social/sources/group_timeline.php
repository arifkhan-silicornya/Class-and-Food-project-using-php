<?php

$continue = true;

$isGroupAdmin = $timelineObj->isGroupAdmin();
$isFollowing = $timelineObj->isFollowing();
$isFollowedBy = $timelineObj->isFollowedBy();
$numFollowers = $timelineObj->numFollowers();
$numFollowRequests = $timelineObj->numFollowRequests();
$numGroupAdmins = $timelineObj->numGroupAdmins();
$numPosts = $timelineObj->numStories();
$joinButton = $timelineObj->getFollowButton();

if ($timeline['group_privacy'] === "secret")
{
    $continue = false;

    if ($isFollowedBy or $isGroupAdmin)
    {
        $continue = true;
    }
}

if (! $continue)
{
    header('Location: ' . smoothLink('index.php?tab1=home'));
}

if (! isset ($_GET['tab2']))
{
    $_GET['tab2'] = "stories";
}

$themeData['timeline_num_members'] = $numFollowers;
$themeData['timeline_num_requests'] = $numFollowRequests;
$themeData['timeline_num_admins'] = $numGroupAdmins;
$themeData['timeline_num_posts'] = $numPosts;
$themeData['join_button'] = $joinButton;

/* */
$themeData['timeline_group_privacy'] = $lang[$timeline['group_privacy'] . '_group'];

$themeData['add_members_url'] = smoothLink('index.php?tab1=timeline&tab2=add_members&id=' . $timeline['username']);
$themeData['requests_url'] = smoothLink('index.php?tab1=timeline&tab2=requests&id=' . $timeline['username']);
$themeData['members_url'] = smoothLink('index.php?tab1=timeline&tab2=list_members&id='.$timeline['username']);
$themeData['admins_url'] = smoothLink('index.php?tab1=timeline&tab2=list_admins&id=' . $timeline['username']);
$themeData['posts_url'] = smoothLink('index.php?tab1=timeline&tab2=stories&id=' . $timeline['username']);
$themeData['settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&id=' . $timeline['username']);

if (($timeline['add_privacy'] == "members" && $isFollowedBy) or ($timeline['add_privacy'] == "admins" && $isGroupAdmin))
{
    $themeData['add_group_members_html'] = \miuan\UI::view('timeline/group/add-members-link');
}

if ($isGroupAdmin && $numFollowRequests > 0)
{
    $themeData['group_requests_html'] = \miuan\UI::view('timeline/group/requests-link');
}

$themeData['group_members_html'] = \miuan\UI::view('timeline/group/members-link');
$themeData['group_admins_html'] = \miuan\UI::view('timeline/group/admins-link');
$themeData['group_posts_html'] = \miuan\UI::view('timeline/group/posts-link');

if ($isGroupAdmin)
{
    $themeData['timeline_buttons_html'] = \miuan\UI::view('timeline/group/timeline-buttons-admin');
}
elseif (isLogged())
{
    $themeData['timeline_buttons_html'] = \miuan\UI::view('timeline/group/timeline-buttons-default');
}

$themeData['timeline_info_about_html'] = \miuan\UI::view('timeline/group/timeline-info-about-html');
$themeData['timeline_info_html'] = \miuan\UI::view('timeline/group/timeline-info-html');
$themeData['no_one_to_add_label'] = '';

if ($config['friends'] == true)
{
    $themeData['no_one_to_add_label'] = $lang['no_friends_to_add_to_group'];
}
else
{
    $themeData['no_one_to_add_label'] = $lang['no_followers_to_add_to_group'];
}

$themeData['tab_content'] = null;

if ($_GET['tab2'] == "add_members")
{
    if (($timeline['add_privacy'] === "members" && $isFollowedBy) or ($timeline['add_privacy'] === "admins" && $isGroupAdmin))
    {
        $i = 0;
        $add_member_userlists = '';
        
        foreach ($userObj->getFollowers() as $followerId)
        {
            if (! $timelineObj->isFollowedBy($followerId))
            {
                $followerObj = new \miuan\User();
                $followerObj->setId($followerId);
                $follower = $followerObj->getRows();
                
                $themeData['add_member_user_id'] = $follower['id'];
                $themeData['add_member_user_url'] = $follower['url'];
                $themeData['add_member_username'] = $follower['username'];
                $themeData['add_member_user_thumbnail_url'] = $follower['thumbnail_url'];
                $themeData['add_member_user_name'] = $follower['name'];
                
                $add_member_userlists .= \miuan\UI::view('timeline/group/add-members-userlist-each');
                $i++;
            }
        }

        if ($i == 0)
        {
            $add_member_userlists = \miuan\UI::view('timeline/group/add-members-nouser');
        }
        
        $themeData['add_member_userlists'] = $add_member_userlists;
        $themeData['tab_content'] = \miuan\UI::view('timeline/group/add-members-tab');
    }
}
elseif ($_GET['tab2'] == "list_members")
{
    $list_member_userlists = '';
    $foreach_indexes = array('list_member_user_id', 'list_member_user_url', 'list_member_username', 'list_member_user_thumbnail_url', 'list_member_user_name', 'list_members_make_admin_btn', 'list_members_btn');

    foreach ($timelineObj->getFollowers() as $memberId)
    {
        $memberObj = new \miuan\User();
        $memberObj->setId($memberId);
        $member = $memberObj->getRows();

        $themeData['list_member_user_id'] = $member['id'];
        $themeData['list_member_user_url'] = $member['url'];
        $themeData['list_member_username'] = $member['username'];
        $themeData['list_member_user_thumbnail_url'] = $member['thumbnail_url'];
        $themeData['list_member_user_name'] = $member['name'];

        if ($isGroupAdmin)
        {
            if (! $timelineObj->isGroupAdmin($member['id']))
            {
                $themeData['list_members_make_admin_btn'] = \miuan\UI::view('timeline/group/list-members-make-admin-btn');
            }

            $themeData['list_members_btn'] = \miuan\UI::view('timeline/group/list-members-btn');
        }

        $list_member_userlists .= \miuan\UI::view('timeline/group/list-members-userlist-each');

        foreach($foreach_indexes as $fei => $fev)
        {
            $themeData[$fev] = null;
        }
    }

    $themeData['list_member_userlists'] = $list_member_userlists;
    $themeData['tab_content'] = \miuan\UI::view('timeline/group/list-members-tab');
}
elseif ($_GET['tab2'] == "list_admins")
{
    $list_admin_userlists = '';
    $foreach_indexes = array('list_admin_user_id', 'list_admin_user_url', 'list_admin_username', 'list_admin_user_thumbnail_url', 'list_admin_user_name', 'list_admins_btn');
    
    $listAdminButtons = false;

    if ($isGroupAdmin && $timelineObj->numGroupAdmins() > 1)
    {
        $listAdminButtons = true;
    }

    foreach ($timelineObj->getGroupAdmins() as $adminId)
    {
        $adminObj = new \miuan\User();
        $adminObj->setId($adminId);
        $admin = $adminObj->getRows();

        $themeData['list_admin_user_id'] = $admin['id'];
        $themeData['list_admin_user_url'] = $admin['url'];
        $themeData['list_admin_username'] = $admin['username'];
        $themeData['list_admin_user_thumbnail_url'] = $admin['thumbnail_url'];
        $themeData['list_admin_user_name'] = $admin['name'];

        if ($listAdminButtons)
        {
            $themeData['list_admins_btn'] = \miuan\UI::view('timeline/group/list-admins-btn');
        }

        $list_admin_userlists .= \miuan\UI::view('timeline/group/list-admins-userlist-each');

        foreach($foreach_indexes as $fei => $fev) {
            $themeData[$fev] = null;
        }
    }

    $themeData['list_admin_userlists'] = $list_admin_userlists;
    $themeData['tab_content'] = \miuan\UI::view('timeline/group/list-admins-tab');
}
elseif ($_GET['tab2'] == "requests" && $isGroupAdmin)
{
    $group_request_userlists = '';

    foreach ($timelineObj->getFollowRequests() as $requestId)
    {
        $requestObj = new \miuan\User();
        $requestObj->setId($requestId);
        $request = $requestObj->getRows();

        $themeData['group_request_user_id'] = $request['id'];
        $themeData['group_request_user_url'] = $request['url'];
        $themeData['group_request_username'] = $request['username'];
        $themeData['group_request_user_thumbnail_url'] = $request['thumbnail_url'];
        $themeData['group_request_user_name'] = $request['name'];
        $themeData['group_requests_btn'] = \miuan\UI::view('timeline/group/group-requests-btn');

        $group_request_userlists .= \miuan\UI::view('timeline/group/group-requests-userlist-each');
    }

    $themeData['group_request_userlists'] = $group_request_userlists;
    $themeData['tab_content'] = \miuan\UI::view('timeline/group/group-requests-tab');
}
elseif ($_GET['tab2'] == "settings" && $isGroupAdmin)
{
    $checked_attr = '';
    if ($timeline['group_privacy'] == "open")
    {
        $checked_attr = ' checked';
    }
    $themeData['group_privacy_open_checked_attr'] = $checked_attr;


    $checked_attr = '';
    if ($timeline['group_privacy'] == "closed")
    {
        $checked_attr = ' checked';
    }
    $themeData['group_privacy_closed_checked_attr'] = $checked_attr;


    $checked_attr = '';
    if ($timeline['group_privacy'] == "secret")
    {
        $checked_attr = ' checked';
    }
    $themeData['group_privacy_secret_checked_attr'] = $checked_attr;


    $add_privacy_members_selected_attr = '';    
    if ($timeline['add_privacy'] == "members")
    {
        $add_privacy_members_selected_attr = ' selected';
    }
    $themeData['add_privacy_members_attr'] = $add_privacy_members_selected_attr;
    

    $add_privacy_admins_selected_attr = '';
    if ($timeline['add_privacy'] == "admins")
    {
        $add_privacy_admins_selected_attr = ' selected';
    }
    $themeData['add_privacy_admins_attr'] = $add_privacy_admins_selected_attr;


    $post_privacy_members_selected_attr = '';
    if ($timeline['timeline_post_privacy'] == "members")
    {
        $post_privacy_members_selected_attr = ' selected';
    }
    $themeData['post_privacy_members_attr'] = $post_privacy_members_selected_attr;
    

    $post_privacy_admins_selected_attr = '';
    if ($timeline['timeline_post_privacy'] == "admins")
    {
        $post_privacy_admins_selected_attr = ' selected';
    }
    $themeData['post_privacy_admins_attr'] = $post_privacy_admins_selected_attr;


    $themeData['tab_content'] = \miuan\UI::view('timeline/group/settings-tab');
}
else
{
    $themeData['story_postbox'] = getStoryPostBox(0, $timeline['id']);

    $feedObj = new \miuan\Feed($conn);
    $feedObj->setTimelineId($timeline['id']);
    $themeData['stories'] = $feedObj->getTemplate();

    $themeData['tab_content'] = \miuan\UI::view('timeline/group/stories-tab');
}

$themeData['sidebar'] = \miuan\UI::view('timeline/group/sidebar');
$themeData['sidebar_postfilters'] = \miuan\UI::view('timeline/group/sidebar-post-filters');

if (isLogged() && $isGroupAdmin)
{
    $themeData['end'] = \miuan\UI::view('timeline/group/admin-end');
}
else
{
    $themeData['end'] = \miuan\UI::view('timeline/group/default-end');
}

/* */

$themeData['page_content'] = \miuan\UI::view('timeline/group/content');
