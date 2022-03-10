<?php
$html = '';
$stories = new \miuan\Feed();

empty($_GET['type']) ? "" : $stories->setType($_GET['type']);
empty($_GET['timeline_id']) ? "" : $stories->setTimelineId($_GET['timeline_id']);
empty($_GET['exclude_activity']) ? "" : $stories->setExclude(true);

if (! empty($_GET['start_row']) && $_GET['start_row'] > 0)
{
    $stories->setStart($_GET['start_row']);
}
elseif (! empty($_GET['after_id']) && $_GET['after_id'] > 0)
{
    $stories->setAfterId($_GET['after_id']);
}
elseif (! empty($_GET['before_id']) && is_numeric($_GET['before_id']))
{
    $stories->setBeforeId($_GET['before_id']);
}

foreach ($stories->getFeed() as $storyId) {
    $story = new \miuan\Story($conn);
    $story->setId($storyId);
    $html .= $story->getTemplate();
}

$data = array(
    'status' => 200,
    'html' => $html
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();