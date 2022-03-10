<?php
$data = \miuan\Addons::invoke(array('addon_ajax_request', 'array'), $conn, $data);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();