<?php
$content = $userObj->getFollowers($escapeObj->stringEscape($_GET['q']));
$get = array();

foreach ($content as $each)
{
    $get[] = array(
        'id' => $each['id'],
        'name' => $each['name']
    );
}

$data = array(
    'status' => 200,
    'data' => $get
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();