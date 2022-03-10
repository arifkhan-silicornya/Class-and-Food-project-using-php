<?php
$id = 0;

if (isLogged())
{
    $id = $user['id'];
}

if (! empty($_GET['id']))
{
    if (is_numeric($_GET['id']))
    {
        $id = (int) $_GET['id'];
    }
    elseif (preg_match('/[A-Za-z0-9_]/', $id))
    {
        $escapeObj = new \miuan\Escape();
        $id = $escapeObj->stringEscape($_GET['id']);
    }
    
    $id = getUserId($conn, $id);
    
    if (! empty($id))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($id);
        $timeline = $timelineObj->getRows();
        
        if (is_array($timeline) && isset($timeline['id']))
        {
            $config['site_title'] = $timeline['name'];

            foreach ($timeline as $key => $value)
            {
                if (is_array($value))
                {
                    foreach ($value as $key2 => $value2)
                    {
                        if (is_array($value))
                        {
                            $themeData['timeline_' . $key . '_' . $key2] = $value2;
                        }
                    }
                }
                else
                {
                    $themeData['timeline_' . $key] = $value;
                }
            }
            
            if ($timeline['type'] == "user")
            {
                include('user_timeline.php');
            }
            elseif ($timeline['type'] == "page")
            {
                include('page_timeline.php');
            }
            elseif ($timeline['type'] == "group")
            {
                include('group_timeline.php');
            }
        }
    }
}
