<?php
$reaction = "";

if (! empty($_GET['reaction_type']))
{
	$reaction = $escapeObj->stringEscape($_GET['reaction_type']);
}

$data = array(
    'status' => 200,
    'html' => $storyObj->getReactionsTemplate($reaction)
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();