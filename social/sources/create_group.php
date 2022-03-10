<?php

if (! isLogged())
{
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

$themeData['page_content'] = \miuan\UI::view('timeline/group/create/content');
