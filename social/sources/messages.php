<?php

if (! isLogged())
{
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
if (! empty($_GET['recipient_id']))
{
	if (! is_numeric($_GET['recipient_id']))
	{
		$recipientId = (int) getUserId($conn, $_GET['recipient_id']);
	}
	else
	{
		$recipientId = (int) $_GET['recipient_id'];
	}

    $recipientObj = new \miuan\User();
    $recipientObj->setId($recipientId);
    $recipient = $recipientObj->getRows();
}

if (! isset($recipient['id']))
{
	$recipient['id'] = 0;
}

foreach ($recipient as $key => $value) {

	if (is_array($value)) {

		foreach ($value as $key2 => $value2) {
			
			if (! is_array($value2)) {
				$themeData['recipient_' . $key . '_' . $key2] = $value2;
			}
		}

	} else {
		$themeData['recipient_' . $key] = $value;
	}
}

$prev_msg_recipient_id = 0;

if (isset($recipient['id']))
{
    $prev_msg_recipient_id = $recipient['id'];
}

$themeData['prev_msg_recipient_id'] = $prev_msg_recipient_id;

$listRecipients = '';
$i = 0;

foreach (getMessageRecipients() as $eachRecipient)
{
	$themeData['list_recipient_id'] = $eachRecipient['id'];
	$themeData['list_recipient_name'] = $eachRecipient['name'];
	$themeData['list_recipient_thumbnail_url'] = $eachRecipient['thumbnail_url'];
	$themeData['list_recipient_online_class'] = '';

	if ($eachRecipient['online'] == true)
	{
		$themeData['list_recipient_online_class'] = 'active';
	}

	$themeData['list_recipient_message_num'] = countMessages(0, $eachRecipient['id'], true);

    $listRecipients .= \miuan\UI::view('messages/recipient-list');
    $i++;
}

$listRecipients .= \miuan\UI::view('messages/view-more-recipients');
$themeData['list_recipients'] = $listRecipients;
/* */

$themeData['page_content'] = \miuan\UI::view('messages/content');
