<?php

if (! isset($_GET['tab1']))
{
    $_GET['tab1'] = 'welcome';
}

$PLUGINS = array();
$PLUGINS['MediaElementJs'] = false;

require_once('assets/includes/core.php');
$isLogged = isLogged();

foreach ($_GET as $key => $value)
{
    $themeData['get_' . $escapeObj->stringEscape(strtolower($key))] = $escapeObj->stringEscape($value);
}


require_once('index/header_tags.php');
require_once('index/header.php');
require_once('index/page.php');
require_once('index/footer.php');

echo \miuan\UI::view('container');
$conn->close();

?>