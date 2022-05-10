<?php 

function dnd($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	die();
}
function currentUser(){
	return Users::curretUserLoggedIn();
}

function escape($string){
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function posted_values($post){
	$array = [];
	foreach ($post as $key => $value) {
		$array[$key] = Input::sanitize($value);
	}
	return $array;
}

function isLoggedIn(){
	return Users::isLoggedIn();
}
function currentPage(){
	$currentPage = $_SERVER['REQUEST_URI'];
	if ($currentPage == PROOT || $currentPage == PROOT . '/home/index') {
			$currentPage = PROOT . 'home';
	}
	return $currentPage;
}
function passwordHash($password){
	return password_hash($password, PASSWORD_DEFAULT);
}