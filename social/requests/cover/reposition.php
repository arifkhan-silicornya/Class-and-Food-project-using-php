<?php
$_POST['pos'] = $escapeObj->stringEscape($_POST['pos']);
$reposition = false;
$position = preg_replace('/[^0-9]/', '', $_POST['pos']);
$width = 920;

if (isset($_POST['width']))
{
	$width = (int) $_POST['width'];
}

$timelineId = (int) $_POST['timeline_id'];
$timelineObj = new \miuan\User($conn);
$timelineObj->setId($timelineId);
$timeline = $timelineObj->getRows();

if (isset($timeline['id']))
{
    $cover_id = $timeline['cover']['id'];
    
    if ($timelineObj->isAdmin())
    {
        $reposition = true;
    }
}

if ($reposition == true)
{
    $cover_url = createCover($cover_id, ($position / $width));
    
    if ($cover_url)
    {
        $query = $conn->query("UPDATE " . DB_ACCOUNTS . " SET cover_position=$position WHERE id=$timelineId AND active=1");
        
        if ($query)
        {
            unset($_SESSION['tempche']['user'][$timelineId]);
            $data = array(
                'status' => 200,
                'url' => $config['site_url'] . '/' . $cover_url
            );
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();