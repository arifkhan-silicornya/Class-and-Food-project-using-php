<?php
userOnly();

$deactivate = $conn->query("UPDATE " . DB_ACCOUNTS . " SET active=0 WHERE id=" . $user['id']);

if ($deactivate)
{
	$data = array(
        'status' => 200,
        'url' => smoothLink('index.php?tab1=home')
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();