<?php


require_once('assets/includes/core.php');

function userOnly()
{
    if (! isLogged())
    {
        global $conn;
        $conn->close();
        exit("Please log in to continue!");
    }
}

$t = (! isset($_GET['t'])) ? "" : $escapeObj->stringEscape($_GET['t']);
$a = (! isset($_GET['a'])) ? "" : $escapeObj->stringEscape($_GET['a']);

$data = array(
    'status' => 417
);

if (empty($t))
{
	exit('a');
}

include('requests/' . $t . '.php');