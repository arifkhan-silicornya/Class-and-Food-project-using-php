<?php
$searchQuery = $escapeObj->stringEscape($_GET['q']);
$html = '';

$html .= getHashtagSearchTemplate($searchQuery, 4);
$html .= getSearchTemplate($searchQuery, 0, 7);

$data = array(
    'status' => 200,
    'html' => $html,
    'link' => smoothLink('index.php?tab1=search&query=' . $searchQuery)
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();