<?php

if (isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

if (isset($_SESSION['user_pass']))
{
    unset($_SESSION['user_pass']);
}

if (isset($_SESSION['_cache_']))
{
    unset($_SESSION['_cache_']);
}

if (isset($_SESSION['hook_logic']))
{
    unset($_SESSION['hook_logic']);
}

if (isset($_SESSION['tempche']))
{
    unset($_SESSION['tempche']);
}

if (isset($_SESSION['tempche_user_ownfollowing']))
{
    unset($_SESSION['tempche_user_ownfollowing']);
}

setcookie('sk_u_i', 0, time()-60);
setcookie('sk_u_p', 0, time()-60);

header('Location: ' . smoothLink('index.php?tab1=welcome'));
