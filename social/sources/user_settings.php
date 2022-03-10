<?php
if ($logged != true) {
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
$themeData['general_settings_url'] = smoothLink('index.php?tab1=settings&tab2=general');
$themeData['privacy_settings_url'] = smoothLink('index.php?tab1=settings&tab2=privacy');
$themeData['email_notification_settings_url'] = smoothLink('index.php?tab1=settings&tab2=email_notifications');
$themeData['avatar_settings_url'] = smoothLink('index.php?tab1=settings&tab2=avatar');
$themeData['cover_settings_url'] = smoothLink('index.php?tab1=settings&tab2=cover');
$themeData['password_settings_url'] = smoothLink('index.php?tab1=settings&tab2=password');
$themeData['deactivate_url'] = smoothLink('index.php?tab1=settings&tab2=deactivate');

if (! isset($_GET['tab2']) or $_GET['tab2'] == "general")
{
	$birthDateOptions = '';

	for ($i=1; $i<32; $i++)
    {
        if ($i == $user['birth']['date'])
        {
            $option = '<option value="' . $i . '" selected>' . $i . '</option>';
        }
        else
        {
            $option = '<option value="' . $i . '">' . $i . '</option>';
        }
        
        $birthDateOptions .= $option;
    }

    $themeData['birth_date_options'] = $birthDateOptions;
    $birthMonthOptions = '';

    foreach (getMonths() as $month_number => $month_data)
    {
        if ($month_number == $user['birth']['month'])
        {
            $option = '<option value="' . $month_number . '" selected>' . $month_data[1] . '</option>';
        }
        else
        {
            $option = '<option value="' . $month_number . '">' . $month_data[1] . '</option>';
        }
        
        $birthMonthOptions .= $option;
    }

    $themeData['birth_month_options'] = $birthMonthOptions;
    $birthYearOptions = '';

    for ($i = date('Y')-100; $i < date('Y')-12; $i++)
    {
        if ($i == $user['birth']['year'])
        {
            $option = '<option value="' . $i . '" selected>' . $i . '</option>';
        }
        else
        {
            $option = '<option value="' . $i . '">' . $i . '</option>';
        }
        
    	$birthYearOptions .= $option;
    }

    $themeData['birth_year_options'] = $birthYearOptions;

    // Gender
    if ($user['gender'] == "male")
    {
        $themeData['gender_male_selected_attr'] = 'selected';
    } elseif ($user['gender'] == "female")
    {
        $themeData['gender_female_selected_attr'] = 'selected';
    }

    $timezoneOptions = '';
    foreach (getTimezones() as $tz_val => $tz_name)
    {
        if ($tz_val == $user['timezone'])
        {
            $option = '<option value="' . $tz_val . '" selected>' . $tz_name . '</option>';
        }
        else
        {
            $option = '<option value="' . $tz_val . '">' . $tz_name . '</option>';
        }

        $timezoneOptions .= $option;
    }

    $themeData['timezone_options'] = $timezoneOptions;

    $themeData['user_about'] = str_replace("<br>", "\n", $themeData['user_about']);

    $themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/general-settings-tab');
}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "privacy")
{

	if ($config['friends'] == true) {
        $themeData['people_i_follow_label'] = $lang['my_friends'];
        
    } else {
        $themeData['people_i_follow_label'] = $lang['people_i_follow'];
    }

	if ($config['friends'] != true) {

		if ($user['confirm_followers'] == 0) {
            $themeData['follow_request_no_selected_attr'] = 'selected';

        } elseif ($user['confirm_followers'] == 1) {
            $themeData['follow_request_yes_selected_attr'] = 'selected';
        }

        if ($user['follow_privacy'] == "everyone") {
            $themeData['follow_privacy_everyone_selected_attr'] = 'selected';

        } elseif ($user['follow_privacy'] == "following") {
            $themeData['follow_privacy_following_selected_attr'] = 'selected';
        }

        $themeData['follow_privacy_rows'] = \miuan\UI::view('timeline/user/settings/follow-privacy-rows');
	}

	if ($user['message_privacy'] == "everyone") {
        $themeData['message_privacy_everyone_selected_attr'] = 'selected';

    } elseif ($user['message_privacy'] == "following") {
        $themeData['message_privacy_following_selected_attr'] = 'selected';
    }

    if ($user['comment_privacy'] == "everyone") {
        $themeData['comment_privacy_everyone_selected_attr'] = 'selected';

    } elseif ($user['comment_privacy'] == "following") {
        $themeData['comment_privacy_following_selected_attr'] = 'selected';
    }

    if ($user['timeline_post_privacy'] == "everyone") {
        $themeData['timeline_post_privacy_everyone_selected_attr'] = 'selected';

    } elseif ($user['timeline_post_privacy'] == "following") {
        $themeData['timeline_post_privacy_following_selected_attr'] = 'selected';

    } elseif ($user['timeline_post_privacy'] == "none") {
        $themeData['timeline_post_privacy_none_selected_attr'] = 'selected';
    }

    if ($user['post_privacy'] == "everyone") {
        $themeData['post_privacy_everyone_selected_attr'] = 'selected';
    }
    
    if ($user['post_privacy'] == "following") {
        $themeData['post_privacy_following_selected_attr'] = 'selected';
    }

    $themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/privacy-settings-tab');

}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "email_notifications")
{
    if ($user['mailnotif_follow'] == true)
    {
        $themeData['follow_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_friendrequests'] == true)
    {
        $themeData['friendrequest_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_comment'] == true)
    {
        $themeData['comment_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_postlike'] == true)
    {
        $themeData['postlike_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_postshare'] == true)
    {
        $themeData['postshare_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_groupjoined'] == true)
    {
        $themeData['groupjoined_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_pagelike'] == true)
    {
        $themeData['pagelike_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_message'] == true)
    {
        $themeData['message_email_notification_checked'] = 'checked';
    }

    if ($user['mailnotif_timelinepost'] == true)
    {
        $themeData['timelinepost_email_notification_checked'] = 'checked';
    }

    if ($config['friends'] == true)
    {
        $themeData['friendrequest_email_row'] = \miuan\UI::view('timeline/user/settings/email-notifications/friendrequest-row');
    }
    else
    {
        $themeData['follow_email_row'] = \miuan\UI::view('timeline/user/settings/email-notifications/follow-row');
    }

    $themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/email-notifications-settings-tab');
}
elseif (isset($_GET['tab2']) && $_GET['tab2'] == "avatar") {
	$themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/avatar-settings-tab');

} elseif (isset($_GET['tab2']) && $_GET['tab2'] == "cover") {
	$themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/cover-settings-tab');

} elseif (isset($_GET['tab2']) && $_GET['tab2'] == "password") {
	$themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/password-settings-tab');

} elseif (isset($_GET['tab2']) && $_GET['tab2'] == "deactivate") {
    $themeData['tab_content'] = \miuan\UI::view('timeline/user/settings/deactivate-tab');

}
/* */

$themeData['page_content'] = \miuan\UI::view('timeline/user/settings/content');
