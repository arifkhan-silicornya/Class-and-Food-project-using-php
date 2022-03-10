<?php
userOnly();

if (updateTimeline($_POST))
{
    $data = array(
        'status' => 200,
        'url' => smoothLink('index.php?tab1=timeline&id=' . $_POST['username'])
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();