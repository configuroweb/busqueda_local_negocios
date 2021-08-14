<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_area'){
	$save = $crud->save_area();
	if($save)
		echo $save;
}
if($action == 'delete_area'){
	$save = $crud->delete_area();
	if($save)
		echo $save;
}

if($action == 'save_service'){
	$save = $crud->save_service();
	if($save)
		echo $save;
}
if($action == 'delete_service'){
	$save = $crud->delete_service();
	if($save)
		echo $save;
}
if($action == 'save_persons_companies'){
	$save = $crud->save_persons_companies();
	if($save)
		echo $save;
}
if($action == 'delete_persons_companies'){
	$save = $crud->delete_persons_companies();
	if($save)
		echo $save;
}
if($action == 'save_about'){
	$save = $crud->save_about();
	if($save)
		echo $save;
}
if($action == 'save_image'){
	$save = $crud->save_image();
	if($save)
		echo $save;
}
if($action == 'save_system_settings'){
	$save = $crud->save_system_settings();
	if($save)
		echo $save;
}
if($action == 'find_sp'){
	$get = $crud->find_sp();
	if($get)
		echo $get;
}
ob_end_flush();
?>
