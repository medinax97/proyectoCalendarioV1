<?php

header('Content-Type: application/json');
$pdo = new PDO("mysql:dbname=bd_calendario;host=127.0.0.1","root","");



$accion=(isset($_GET['accion']))?$_GET['accion']:'leer';

switch ($accion) {
	case 'agregar':
		$sentenciaSQL = $pdo->prepare("INSERT INTO eventos(title, color, tipo_equipo, numero_inventario, nombre_departamento, descripcion, textColor, start, equipos_idequipos, tipoequipos_idtipoequipos, departamentos_iddepartamentos)
			VALUES(:title,:color,:tipo_equipo,:numero_inventario,:nombre_departamento,:descripcion,:textColor,:start, :numero_inventario2, :tipo_equipo2, :nombre_departamento2)");

		$respuesta=$sentenciaSQL->execute(array(

			"title"=>$_POST['title'],
			"color"=>$_POST['color'],
			"tipo_equipo"=>$_POST['tipo_equipo'],
			"numero_inventario"=>$_POST['numero_inventario'],
			"nombre_departamento"=>$_POST['nombre_departamento'],
			"descripcion"=>$_POST['descripcion'],
			"textColor"=>$_POST['textColor'],
			"start"=>$_POST['start'],
			"numero_inventario2"=>$_POST['numero_inventario2'],
			"tipo_equipo2"=>$_POST['tipo_equipo2'],
			"nombre_departamento2"=>$_POST['nombre_departamento2']

		));

		echo json_encode($respuesta);
		break;

	case 'eliminar':

		$respuesta=false;

		if (isset($_POST['id'])){

		$sentenciaSQL = $pdo->prepare("DELETE FROM eventos WHERE ID=:ID");

		$respuesta=$sentenciaSQL->execute(array("ID"=>$_POST['id']));

		}

		echo json_encode($respuesta);
		break;

	case 'modificar':

		$sentenciaSQL = $pdo->prepare("UPDATE eventos SET title=:title,color=:color,tipo_equipo=:tipo_equipo,numero_inventario=:numero_inventario,nombre_departamento=:nombre_departamento, descripcion=:descripcion,textColor=:textColor,start=:start,equipos_idequipos=:numero_inventario2,tipoequipos_idtipoequipos=:tipo_equipo2,departamentos_iddepartamentos=:nombre_departamento2 WHERE ID=:ID");

		$respuesta=$sentenciaSQL->execute(array(
			"ID"=>$_POST['id'],
			"title"=>$_POST['title'],
			"color"=>$_POST['color'],
			"tipo_equipo"=>$_POST['tipo_equipo'],
			"numero_inventario"=>$_POST['numero_inventario'],
			"nombre_departamento"=>$_POST['nombre_departamento'],
			"descripcion"=>$_POST['descripcion'],
			"textColor"=>$_POST['textColor'],
			"start"=>$_POST['start'],
			"numero_inventario2"=>$_POST['numero_inventario2'],
			"tipo_equipo2"=>$_POST['tipo_equipo2'],
			"nombre_departamento2"=>$_POST['nombre_departamento2']

		));
		
		echo json_encode($respuesta);
		break;
	
	
	default:

	//Seleccionar los eventos del calendario

	$sentenciaSQL=$pdo->prepare("select*from eventos");
	$sentenciaSQL->execute();
	$resultado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($resultado);
	break;
}




?>