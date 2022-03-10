<?php
function addon_autoloader($conn)
{
	if (isset($_SESSION['load_addons']) && is_array($_SESSION['load_addons']))
	{
		foreach ($_SESSION['load_addons'] as $init_addon)
		{
			$init = $init_addon . "/init.php";
			require $init;

		}
		return true;
	}

	if ( !isset ($_SESSION['addons']) )
	{
		$_SESSION['addons'] = array();
	}

	$_SESSION['load_addons'] = array();
	$addons = glob("addons/add.*", GLOB_ONLYDIR);
	usort($addons, create_function('$a,$b', 'return filectime($a) - filectime($b);'));
	
	foreach ($addons as $addOn)
	{
		$init = $addOn . "/init.php";
		if ( file_exists($addOn . "/enabled.html") )
		{
			require $init;
			$_SESSION['load_addons'][] = $addOn;
		}
	}
}

addon_autoloader($conn);