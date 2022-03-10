<?php
if (! empty($_GET['post_id']) && is_numeric($_GET['post_id']) && $_GET['post_id'] > 0)
{
    $postId = (int) $_GET['post_id'];

    $storyObj = new \miuan\Story($conn);
    $storyObj->setId($postId); 
    $story = $storyObj->getRows();
}

include('requests/post/' . $a . '.php');