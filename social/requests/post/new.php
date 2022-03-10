<?php
userOnly();

$regObj = new \miuan\registerStory();

$regObj->setTimeline(__POST__('timeline_id'));
$regObj->setRecipient(__POST__('recipient_id'));
$regObj->setText(__POST__('text'));
$regObj->setPrivacy(__POST__('post_privacy'));
$regObj->setMapName(__POST__('google_map_name'));

if ( isset($_FILES['photos']['name']) )
{
    $regObj->setPhotos($_FILES['photos']);
}

if ( isset($_POST) )
{
	$regObj->setAdditionalData($_POST);
}

if ( isset($_FILES) )
{
	$regObj->setAdditionalFiles($_FILES);
}

if ($storyId = $regObj->register())
{
    $storyObj = new \miuan\Story();
    $storyObj->setId($storyId);
    
    $data = array(
        'status' => 200,
        'html' => $storyObj->getTemplate()
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();