<?php

try {


include 'db_connect.php';
$cantidad = $_POST['cantidad'];
$idalumnop = $_POST['student_id'];
$idevento = $_POST['subject_id'];
$porcentaje = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$sqla = $conn->query("SELECT id_genero, edad FROM alumnos WHERE id_alumno = '$idalumnop'");
    // Codigo para buscar en tu base de datos acá
	$datoa = $sqla->fetch_assoc();
	$idgenero = $datoa['id_genero'];
	$edada = $datoa['edad'];

   switch ($idevento){

	case 1:

		$sqlveri = $conn->query("SELECT max(repeticiones) as maximo FROM dominadas WHERE edad = '$edada' and id_genero = '$idgenero'");
		$datodoveri = $sqlveri->fetch_assoc();
		$max1 = $datodoveri['maximo'];

		if ($cantidad > $max1){
        $porcentaje = 100;

		}
		else {

			$sqldomi =  $conn->query("SELECT porcentaje FROM dominadas WHERE id_genero = '$idgenero' and edad = '$edada' and repeticiones= '$cantidad'");
			$datodomi = $sqldomi->fetch_assoc();
			$porcentaje = $datodomi['porcentaje'];
		}
		break;
	case 2:

		$sqlveriabdo =  $conn->query("SELECT max(repeticiones) as maximo FROM abdominales WHERE edad = '$edada' and id_genero = '$idgenero'");
		$datoveriabdo = $sqlveriabdo->fetch_assoc();
		$max2 = $datoveriabdo['maximo'];

		if ($cantidad > $max2){
        $porcentaje = 100;

		}
		else {

			$sqlabdo =  $conn->query("SELECT porcentaje FROM abdominales WHERE id_genero = '$idgenero' and edad = '$edada' and repeticiones= '$cantidad'");
			$datoabdo = $sqlabdo->fetch_assoc();
			$porcentaje = $datoabdo['porcentaje'];
		}
		break;
	case 3:

		$sqlverica =  $conn->query("SELECT min(tiempo) as minimo FROM carrera WHERE edad = '$edada' and id_genero = '$idgenero'");
		$datoverica = $sqlverica->fetch_assoc();
		$min = $datoverica['minimo'];

		$hora1 = strtotime($min);
		$horan1 = date('H:i',$hora1);
		//$hora1 = strtotime(date('H:i',$min));
		//$hora2 = strtotime(date('H:i',$cantidad));
		//$hora2 = strtotime($cantidad);
		
		//$hora2 = strtotime($cantidad);
		//$horan2 = date('H:i',$hora2);

		if ($cantidad < $min){
        $porcentaje = 100;

		}
		else {
			//$hora2 = date_format($cantidad, 'H:i');
			//$date = new DateTime($cantidad);
			//$horan2 = $date->format('H:i');
			$horan2 = $cantidad;
			$sqlca =  $conn->query("SELECT porcentaje FROM carrera WHERE edad = '$edada' and id_genero = '$idgenero' and tiempo = '$horan2'");
			$datoca = $sqlca->fetch_assoc();
			$porcentaje = $datoca['porcentaje'];
			//$porcentaje = implode(",",$valorporce);
		}

   }

    echo $porcentaje;
  
} else {
    echo "<p>Error al mostarr el porcentaje!!</p>";
}

 
} catch(ex){
	console.error("Se encontró un error:", ex.message);
 
}
?>