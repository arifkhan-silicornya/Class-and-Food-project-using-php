<?php

namespace miuan;

class Addons
{
	public static function get_addons($type)
	{
		if (! isset($_SESSION['addons'][$type]))
		{
			return false;
		}

		$get = $_SESSION['addons'][$type];

		if ( !is_array($get) )
		{
			return false;
		}

		return $get;
	}

	public static function invoke()
	{
		$params = func_get_args();
		$countParams = func_num_args();
		$type = $params[0];
		$args = "";
		unset($params[0]);

		if (is_array ($type))
		{
			$return_type = $type[1];

			if (isset ($type[2]))
			{
				if ($type[2] == "no_append")
				{
					$noAppend = true;
				}
			}

			$type = $type[0];
		}

		if ( isset($params[1]) )
		{
			$args = $params[1];
		}

		if ($countParams > 2)
		{
			$args = $params[($countParams - 1)];
		}
		
		$get_addons = self::get_addons($type);

		if ( is_array($get_addons) )
		{
			foreach ($get_addons as $name)
			{
				$adds = call_user_func_array($name, $params);

				if ( !empty($adds) )
				{
					if ( $return_type == "string" )
					{
						if ( is_array($args) )
						{
							$args = "";
						}

						if (isset ($noAppend))
						{
							$args = "";
						}
						
						$args .= $adds;
					}
					elseif ( $return_type == "array" )
					{
						$args = array_merge($args, $adds);
					}
					else
					{
						return false;
					}
				}
			}
		}

		return $args;
	}

	public static function register($type, $func)
	{
		$name = $func;
		$func_invalid = (preg_match('/[A-Za-z0-9_]/i', $name)) ? false : true;

		if ( isset($_SESSION['addons'][$type][$name]) )
		{
			return false;
		}
		
		if ( !preg_match('/[A-Za-z0-9_]/i', $type) or $func_invalid)
		{
			return false;
		}

		$type = strtolower($type);
		$_SESSION['addons'][$type][$name] = $func;
	}

	public static function call()
	{
		$args = func_get_args();
		$type = $args[0];
		$func = $args[1];
		unset($args[0], $args[1]);

		return call_user_func_array($func, $args);
	}
}
