<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM alumnos where id_alumno = ".$_GET['id_alumno'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'nuevo_alumno.php';
?>