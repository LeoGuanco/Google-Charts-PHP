<?php
	include 'conexion.php';

	$conexion = new conexion_DB('localhost','CEBADA_SQL','root','');
	$conexion->conectar();
	
	$query = "SELECT a.`fecha`, s1.temperatura, s2.temperatura 
							FROM dato a, 
							(SELECT `temperatura`, `fecha` FROM dato WHERE `id_sensor` = 1) s1, 
							(SELECT `temperatura`,`fecha` FROM dato WHERE `id_sensor` = 2) s2 
							WHERE s1.`fecha` = a.`fecha` AND s2.`fecha` = a.`fecha`
							GROUP BY a.`fecha`";

	$datos = $conexion->seleccionar($query);

	echo json_encode($datos);

	$conexion->cerrarConexion();
?>