<?php
$regObj = new \miuan\registerGroup();
$regObj->setName($_POST['group_name']);
$regObj->setUsername($_POST['group_username']);
$regObj->setAbout($_POST['group_about']);
$regObj->setPrivacy($_POST['group_privacy']);

if ($register = $regObj->register())
{
    $groupObj = new \miuan\User($conn);
    $groupObj->setId($register['id']);
    $group = $groupObj->getRows();

    $data = array(
        'status' => 200,
        'url' => $group['url']
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();