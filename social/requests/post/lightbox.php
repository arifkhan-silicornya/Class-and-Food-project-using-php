<?php
if (isset($story['media']))
{
    $themeData['post_id'] = $story['id'];
    $themeData['post_image_url'] = $story['media']['each'][0]['url'];
    $themeData['post_time'] = date('c', $story['time']);
    $themeData['post_text'] = $story['text'];

    $themeData['story_privacy'] = "public";
    $themeData['story_privacy_title'] = "Public";
    $themeData['story_privacy_icon'] = '<i class="fa fa-globe"></i>';

    if ($story['privacy'] == "friends")
    {
        $themeData['story_privacy'] = "people_i_follow";
        $themeData['story_privacy_title'] = "People I Follow";
        $themeData['story_privacy_icon'] = '<i class="fa fa-users"></i>';

        if ($config['friends'] == true)
        {
            $themeData['story_privacy'] = "friends";
            $themeData['story_privacy_title'] = "Friends";
            $themeData['story_privacy_icon'] = '<i class="fa fa-users"></i>';
        }

        if ( !isLogged() )
        {
            return "";
        }

        if ($story['timeline']['id'] != $user['id'])
        {
            $friendsCheck = $this->conn->query("SELECT id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $story['timeline']['id'] . " AND following_id=" . $user['id'] . " AND active=1");

            if ($friendsCheck->num_rows != 1)
            {
                return "";
            }
        }
    }

    $themeData['post_user_thumbnail_url'] = $story['timeline']['thumbnail_url'];
    $themeData['post_user_url'] = $story['timeline']['url'];
    $themeData['post_user_name'] = $story['timeline']['name'];

    $themeData['post_like_button'] = $storyObj->getReactButtonTemplate();
    $themeData['post_share_button'] = $storyObj->getShareButtonTemplate();
    $themeData['post_follow_button'] = $storyObj->getFollowButtonTemplate();

    $themeData['post_view_all_comments_html'] = '';

    if ($storyObj->numComments() > 8)
    {
        $themeData['post_view_all_comments_html'] = \miuan\UI::view('lightbox/view-all-comments-html');
    }

    $themeData['post_comments'] = '';

    foreach ($storyObj->getCommentIds(8) as $k => $v)
    {
        $commentObj = new \miuan\Comment();
        $commentObj->setId($v);
        $comment = $commentObj->getRows();

        $themeData['post_comment_id'] = $comment['id'];
        $themeData['post_comment_text'] = $comment['text'];
        $themeData['post_comment_time'] = date('c', $comment['time']);
        $themeData['post_comment_like_button'] = $commentObj->getLikeButtonTemplate();
        $themeData['post_comment_like_activity'] = $commentObj->getLikeActivityTemplate();

        $themeData['post_comment_user_url'] = $comment['timeline']['url'];
        $themeData['post_comment_user_thumbnail_url'] = $comment['timeline']['thumbnail_url'];
        $themeData['post_comment_user_name'] = $comment['timeline']['name'];

        $themeData['post_comment_remove_button'] = '';
        $themeData['post_comment_report_button'] = '';
        $themeData['post_comment_control_buttons'] = '';

        if (isLogged())
        {
            if ($commentObj->isAdmin())
            {
                $themeData['post_comment_remove_button'] = \miuan\UI::view('lightbox/comment-remove-button');
            }
            elseif (! $commentObj->isReported())
            {
                $themeData['post_comment_report_button'] = \miuan\UI::view('lightbox/comment-report-button');
            }

            $themeData['post_comment_control_buttons'] = \miuan\UI::view('lightbox/comment-control-buttons');
        }

        $themeData['post_comments'] .= \miuan\UI::view('lightbox/comment');
    }

    list($width, $height) = getimagesize(str_replace($config['site_url'] . '/', '', $story['media']['each'][0]['url']));
    $themeData['post_image_width'] = $width;
    $themeData['post_image_height'] = $height;

    $data = array(
        'status' => 200,
        'html' => \miuan\UI::view('lightbox/content')
    );

    header("Content-type: application/json; charset=utf-8");
    echo json_encode($data);
    $conn->close();
    exit();
}