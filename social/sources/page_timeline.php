<?php

$isPageAdmin = $timelineObj->isAdmin();

if (isset($_GET['tab2']) && $_GET['tab2'] == "settings" && $isPageAdmin)
{
    if (empty($_GET['tab3']))
    {
        $_GET['tab3'] = 'general_settings';
    }

    $themeData['general_settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=general_settings&id=' . $timeline['username']);
	$themeData['privacy_settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=privacy&id=' . $timeline['username']);
	$themeData['admins_settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=admins&id=' . $timeline['username']);
	$themeData['messages_settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=messages&id=' . $timeline['username']);
	$themeData['likes_settings_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=likes&id=' . $timeline['username']);

	if ($isPageAdmin == "admin")
    {
		$themeData['admin_settings_link'] = \miuan\UI::view('timeline/page/admin/admin-settings-link');
	}

    $themeData['messages_count'] = $timelineObj->numMessages();

    $themeData['sidebar'] = \miuan\UI::view('timeline/page/admin/sidebar');

    if (isset($_GET['tab3']) && $_GET['tab3'] == "general_settings")
    {
        $value_attr = '';

        if (!empty($timeline['phone']))
        {
            $value_attr = ' value="' . $timeline['phone'] . '"';
        }

        $themeData['phone_value_attr'] = $value_attr;
        $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/general-settings-tab');
    }
    elseif (isset($_GET['tab3']) && $_GET['tab3'] == "privacy")
    {
        $post_privacy_everyone_selected_attr = '';
        
        if ($timeline['timeline_post_privacy'] == "everyone")
        {
            $post_privacy_everyone_selected_attr = ' selected';
        }

        $themeData['post_privacy_everyone_selected_attr'] = $post_privacy_everyone_selected_attr;
        $post_privacy_none_selected_attr = '';

        if ($timeline['timeline_post_privacy'] == "none")
        {
            $post_privacy_none_selected_attr = ' selected';
        }

        $themeData['post_privacy_none_selected_attr'] = $post_privacy_none_selected_attr;
        $message_privacy_everyone_selected_attr = '';

        if ($timeline['message_privacy'] == "everyone")
        {
            $message_privacy_everyone_selected_attr = ' selected';
        }

        $themeData['message_privacy_everyone_selected_attr'] = $message_privacy_everyone_selected_attr;
        $message_privacy_none_selected_attr = '';

        if ($timeline['message_privacy'] == "none")
        {
            $message_privacy_none_selected_attr = ' selected';
        }

        $themeData['message_privacy_none_selected_attr'] = $message_privacy_none_selected_attr;
        $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/privacy-settings-tab');
    }
    elseif (isset($_GET['tab3']) && $_GET['tab3'] == "admins" && $isPageAdmin == "admin")
    {
        $admins_i = 0;
        $themeData['admins_list'] = '';

        foreach ($timelineObj->getPageAdmins() as $adminId)
        {
            $adminObj = new \miuan\User();
            $adminObj->setId($adminId);
            $admin = $adminObj->getRows();

            $themeData['list_admin_id'] = $admin['id'];
            $themeData['list_admin_url'] = $admin['url'];
            $themeData['list_admin_username'] = $admin['username'];
            $themeData['list_admin_name'] = $admin['name'];
            $themeData['list_admin_thumbnail_url'] = $admin['thumbnail_url'];

            $admin_role = $timelineObj->isPageAdmin($admin['id']);

            if ($admin_role == "admin")
            {
                $themeData['list_admin_selected_attr'] = 'selected';
            }
            elseif ($admin_role == "editor")
            {
                $themeData['list_editor_selected_attr'] = 'selected';

            }

            $themeData['admins_list'] .= \miuan\UI::view('timeline/page/admin/list-admins-each');
            $admins_i++;
        }

        if ($admins_i == 0)
        {
            $themeData['admins_list'] .= \miuan\UI::view('timeline/page/admin/no-admins');
        }

        $nonadmin_followings = 0;
        $themeData['potential_admins_list'] = '';

        foreach ($userObj->getFollowings() as $potentialId)
        {
            if (! $timelineObj->isPageAdmin($potentialId))
            {
                $potentialObj = new \miuan\User();
                $potentialObj->setId($potentialId);
                $potential = $potentialObj->getRows();

                $themeData['list_pa_id'] = $potential['id'];
                $themeData['list_pa_url'] = $potential['url'];
                $themeData['list_pa_username'] = $potential['username'];
                $themeData['list_pa_name'] = $potential['name'];
                $themeData['list_pa_thumbnail_url'] = $potential['thumbnail_url'];

                $themeData['potential_admins_list'] .= \miuan\UI::view('timeline/page/admin/list-potential-admins-each');
                $nonadmin_followings++;
            }
        }
        
        if ($nonadmin_followings == 0)
        {
            if ($config['friends'] == true)
            {
                $themeData['no_admin_to_add_label'] = $lang['no_friends_to_add_to_page'];
            }
            else
            {
                $themeData['no_admin_to_add_label'] = $lang['no_followers_to_add_to_page'];
            }

            $themeData['potential_admins_list'] .= \miuan\UI::view('timeline/page/admin/no-potential-admins');
        }

        $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/admins-tab');
    }
    elseif (isset($_GET['tab3']) && $_GET['tab3'] == "messages" && $isPageAdmin)
    {
        if (! empty($_GET['recipient_id']))
        {
            if (! is_numeric($_GET['recipient_id']))
            {
                $_GET['recipient_id'] = getUserId($conn, $_GET['recipient_id']);
            }

            $recipientId = (int) $_GET['recipient_id'];
            $recipientObj = new \miuan\User();
            $recipientObj->setId($recipientId);
            $recipient = $recipientObj->getRows();
            
            $hidden_class = '';

            if (! isset($recipient['id']))
            {
                $hidden_class = ' hidden';
            }
            $themeData['recipient_name_class'] = $hidden_class;

            $themeData['recipient_id'] = $recipient['id'];
            $themeData['recipient_name'] = $recipient['name'];

            $no_messages = true;
            $listMessages = '';
            
            if (isset($recipient['id']))
            {
                $messages = getMessages(
                    array(
                        'recipient_id' => $recipient['id'],
                        'timeline_id' => $timeline['id']
                    )
                );
                $count_messages = countMessages($timeline['id'], $recipient['id'], false);
                
                if ($count_messages > 0)
                {
                    foreach ($messages as $msg)
                    {
                        $themeData['list_message_id'] = $msg['id'];
                        $themeData['list_message_text'] = $msg['text'];
                        $themeData['list_message_time'] = date('c', $msg['time']);
                        $themeData['list_message_owner'] = $msg['owner'];

                        foreach ($msg['timeline'] as $key => $value)
                        {
                            if (! is_array($value))
                            {
                                $themeData['list_message_timeline_' . $key] = $value;
                            }
                        }

                        foreach ($msg['media'] as $key => $value)
                        {
                            if (! is_array($value))
                            {
                                $themeData['list_message_media_' . $key] = $value;
                            }
                        }

                        $themeData['list_message_media_html'] = '';

                        if (! empty($msg['media']['id']))
                        {
                            $themeData['list_message_media_complete_url'] = $site_url . '/' . $msg['media']['each'][0]['complete_url'];
                            $themeData['list_message_media_html'] = \miuan\UI::view('messages/list-message-each-media');
                        }

                        if ($msg['owner'] == true)
                        {
                            $themeData['list_message_buttons'] = \miuan\UI::view('messages/list-message-each-buttons');
                        }

                        $listMessages .= \miuan\UI::view('messages/list-message-each');
                    }

                    $no_messages = false;
                }

            }
            
            if ($no_messages == true) {
                $listMessages .= \miuan\UI::view('timeline/page/admin/no-messages');
            }

            $themeData['list_messages'] = $listMessages;

            $label = $lang['write_a_message_label'];
            $disabled_attr = '';
            $hidden_class = '';
            
            if (! isset($recipient['id']) or ! is_numeric($recipient['id']) or $recipient['message_privacy'] == "following")
            {
                $label = $lang['cannot_reply_to_conversation'];
                $disabled_attr = 'disabled';
                $hidden_class = 'hidden';
            }

            $themeData['convo_textarea_label'] = $label;
            $themeData['convo_textarea_disabled_attr'] = $disabled_attr;
            $themeData['options_hidden_class'] = $hidden_class;
            $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/messages-conversation-tab');

        } else {

            $messageRecipients = '';
            $message_recipients = $timelineObj->getMessageRecipients();
            if (is_array($message_recipients) && count($message_recipients) > 0) {
                
                foreach ($message_recipients as $recipient)
                {
                    $themeData['list_recipient_id'] = $recipient['id'];
                    $themeData['list_recipient_url'] = $recipient['url'];
                    $themeData['list_recipient_convo_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&tab3=messages&recipient_id=' . $recipient['username'] . '&id=' . $timeline['username']);
                    $themeData['list_recipient_username'] = $recipient['username'];
                    $themeData['list_recipient_name'] = $recipient['name'];
                    $themeData['list_recipient_thumbnail_url'] = $recipient['thumbnail_url'];

                    $themeData['list_recipient_messages_count'] = countMessages($timeline['id'], $recipient['id'], true);

                    $messageRecipients .= \miuan\UI::view('timeline/page/admin/messages-default-each');
                }
                
            } else {
                $messageRecipients = \miuan\UI::view('timeline/page/admin/no-message-recipients');
            }
            $themeData['message_recipients'] = $messageRecipients;
            $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/messages-default-tab');

        }

    }
    elseif (isset($_GET['tab3']) && $_GET['tab3'] == "likes" && $isPageAdmin)
    {
        $likesList = '';

        if ($timelineObj->numFollowers() == 0)
        {
            $likesList .= \miuan\UI::view('timeline/page/admin/no-likes');
        }
        else
        {
            foreach ($timelineObj->getFollowers() as $fanId)
            {
                $fanObj = new \miuan\User();
                $fanObj->setId($fanId);
                $fan = $fanObj->getRows();

                $themeData['list_like_user_id'] = $fan['id'];
                $themeData['list_like_user_url'] = $fan['url'];
                $themeData['list_like_user_username'] = $fan['username'];
                $themeData['list_like_user_thumbnail_url'] = $fan['thumbnail_url'];
                $themeData['list_like_user_name'] = $fan['name'];

                $likesList .= \miuan\UI::view('timeline/page/admin/likes-each');

            }
        }

        $themeData['likes_list'] = $likesList;
        $themeData['tab_content'] = \miuan\UI::view('timeline/page/admin/likes-tab');
    }

    $themeData['page_content'] = \miuan\UI::view('timeline/page/admin/content');
}
else
{
    $themeData['likes_num'] = $timelineObj->numFollowers();
    $themeData['posts_num'] = $timelineObj->numStories();
    $themeData['like_button'] = $timelineObj->getFollowButton();
    $themeData['posts_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=stories&id=' . $timeline['username']);
    $themeData['settings_tab_url'] = smoothLink('index.php?tab1=timeline&tab2=settings&id=' . $timeline['username']);
    $themeData['messages_tab_url'] = smoothLink('index.php?tab1=messages&recipient_id=' . $timeline['username']);

    if ($isPageAdmin)
    {
        $themeData['change_avatar_html'] = \miuan\UI::view('timeline/page/change-avatar');
        $themeData['timeline_buttons'] = \miuan\UI::view('timeline/page/timeline-buttons-admin');
    }
    elseif (isLogged())
    {
        if ($timeline['message_privacy'] == "everyone")
        {
            $themeData['message_button'] = \miuan\UI::view('timeline/page/message-button');
        }

        $themeData['timeline_buttons'] = \miuan\UI::view('timeline/page/timeline-buttons-default');
    }

    if ($timeline['verified'] == true)
    {
        $themeData['verified_badge'] = \miuan\UI::view('timeline/page/verified-badge');
    }

    $category = getPageCategoryData($timeline['category_id']);
    $themeData['category_name'] = $category['name'];

    if (!empty($timeline['about']))
    {
        $themeData['info_about_row'] = \miuan\UI::view('timeline/page/info-about-row');
    }

    if (!empty($timeline['address']))
    {
        $themeData['info_address_row'] = \miuan\UI::view('timeline/page/info-address-row');
    }

    if (!empty($timeline['awards']))
    {
        $themeData['info_awards_row'] = \miuan\UI::view('timeline/page/info-awards-row');
    }

    if (!empty($timeline['phone']))
    {
        $themeData['info_phone_row'] = \miuan\UI::view('timeline/page/info-phone-row');
    }

    if (!empty($timeline['products']))
    {
        $themeData['info_products_row'] = \miuan\UI::view('timeline/page/info-products-row');
    }

    $themeData['sidebar'] = \miuan\UI::view('timeline/page/sidebar');

    if (isLogged())
    {
        if ($isPageAdmin)
        {
            $themeData['story_postbox'] = getStoryPostBox($timeline['id']);
        }
        else
        {
            $themeData['story_postbox'] = getStoryPostBox(0, $timeline['id']);

        }
    }

    $feedObj = new \miuan\Feed($conn);
    $feedObj->setTimelineId($timeline['id']);
    $themeData['stories'] = $feedObj->getTemplate();

    $themeData['sidebar_postfilters'] = \miuan\UI::view('timeline/page/sidebar-post-filters');

    if ($sk['logged'] == true && $isPageAdmin) {
        $themeData['end'] = \miuan\UI::view('timeline/page/admin-end');
    } else {
        $themeData['end'] = \miuan\UI::view('timeline/page/default-end');
    }

    $themeData['page_content'] = \miuan\UI::view('timeline/page/content');
}