<?php 

class Input {

	public static function sanitize($value){
		return htmlentities($value, ENT_QUOTES, "UTF-8");
	}

	public static function get($value){
		if (isset($_POST[$value])) {
			return self::sanitize($_POST[$value]);
		}elseif (isset($_GET[$value])) {
			return self::sanitize($_GET[$value]);
		}
	}
}