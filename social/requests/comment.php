<?php
if (! empty($_GET['comment_id']) && is_numeric($_GET['comment_id']) && $_GET['comment_id'] > 0)
{
    $commentId = (int) $_GET['comment_id'];

    $commentObj = new \miuan\Comment($conn);
    $commentObj->setId($commentId); 
    $comment = $commentObj->getRows();
}

include('requests/comment/' . $a . '.php');