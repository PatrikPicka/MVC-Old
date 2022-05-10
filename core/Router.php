<?php

class Router
{


	public static function rout($url)
	{

		//controller
		$controller = (isset($url[0]) && isset($url[0]) != '') ? ucwords($url[0]) . 'Controller' : DEFAULT_CONTROLLER . 'Controller';
		$controller_name = str_replace('Controller', '', $controller);
		array_shift($url);

		//action 
		$action = (isset($url[0]) && isset($url[0]) != '') ? $url[0] : 'index';
		$action_name = (isset($url[0]) && isset($url[0]) != '') ? $url[0] . 'Action' : 'indexAction';
		array_shift($url);

		//acl check
		$permissions = self::hasAccess($controller_name, $action);
		if (!$permissions) {
			$controller = ACCESS_RESTRICTED . 'Controller';
			$controller_name = ACCESS_RESTRICTED;
			$action_name = 'indexAction';
		}

		//params
		$queryParams = $url;

		$dispatch = new $controller($controller_name, $action_name);

		if (method_exists($controller, $action_name)) {
			call_user_func_array([$dispatch, $action_name], $queryParams);
		} else {
			die('That method does not exists in the controller \"' . $controller_name . '\"');
		}
	}


	public static function redirect($location)
	{
		if (!headers_sent()) {
			header('Location: ' . PROOT . $location);
			exit();
		} else {
			echo '<script type = "text/javascript">';
			echo 'window.location.href="' . PROOT . $location . '"';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
			echo '<noscript>';
			exit;
		}
	}

	public static function hasAccess($controller, $action = 'index')
	{
		$acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json', true);
		$acl = json_decode($acl_file, true);
		$current_acls = ["Guest"];
		$grantAccess = false;
		$user = Users::curretUserLoggedIn();
		if (Session::exists(USER_SESSION_NAME)) {
			$current_acls[] = "LoggedIn";
			foreach (Users::acls($user->id) as $a) {
				$current_acls[] = $a;
			}
		}
		foreach ($current_acls as $level) {
			if (array_key_exists($level, $acl) && array_key_exists($controller, $acl[$level])) {
				if (in_array($action, $acl[$level][$controller]) || in_array("*", $acl[$level][$controller])) {
					$grantAccess = true;
					break;
				}
			}
		}
		//check for denied
		foreach ($current_acls as $level) {
			$denied = $acl[$level]["denied"];
			if (!empty($denied) && array_key_exists($controller, $denied) && in_array($action, $denied[$controller])) {
				$grantAccess = false;
				break;
			}
		}
		return $grantAccess;
	}


	public static function getMenu($name)
	{
		$menuArr = [];
		$menuFile = file_get_contents(ROOT . DS . 'app' . DS . 'menu_acl.json', true);
		$acls = json_decode($menuFile, true);
		//dnd($acls);
		$sub = [];
		foreach ($acls as $key => $value) {
			if (is_array($value)) {

				foreach ($value as $k => $v) {
					if ($k != "separator") {
						if ($finalVal = self::get_link($v)) {
							$sub[$k] = $finalVal;
						}
					} elseif ($k == "separator" && !empty($sub)) {
						$sub[$k] = '';
					}
				}
				if (!empty($sub)) {
					$menuArr[$key] = $sub;
				}
			} else {
				if ($finalVal = self::get_link($value)) {
					$menuArr[$key] = $finalVal;
				}
			}
		}
		return $menuArr;
	}

	private static function get_link($link)
	{
		//kontrola externího linku

		if (preg_match('/https?:\/\//', $link) == 1) {
			return $link;
		} else {
			$uAry = explode("/", $link);
			$controller_name = ucwords($uAry[0]);
			$action_name = (isset($uAry[1])) ? $uAry[1] : '';
			if (self::hasAccess($controller_name, $action_name)) {
				return PROOT . $link;
			} else {
				return false;
			}
		}
	}
}
