<?php
ob_start();
date_default_timezone_set("America/Tegucigalpa");

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
if($action == 'guardar_examen'){
	$save = $crud->guardar_examen();
	if($save)
		echo $save;
}
if($action == 'eliminar_examen'){
	$save = $crud->eliminar_examen();
	if($save)
		echo $save;
}
if($action == 'guardar_evento'){
	$save = $crud->guardar_evento();
	if($save)
		echo $save;
}
if($action == 'eliminar_evento'){
	$save = $crud->eliminar_evento();
	if($save)
		echo $save;
}
if($action == 'save_student'){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == 'eliminar_alumno'){
	$save = $crud->eliminar_alumno();
	if($save)
		echo $save;
}
if($action == 'guardar_calificacion'){
	$save = $crud->guardar_calificacion();
	if($save)
		echo $save;
}
if($action == 'delete_result'){
	$save = $crud->delete_result();
	if($save)
		echo $save;
}
ob_end_flush();
?>
