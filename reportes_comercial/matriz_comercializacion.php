<?php
ob_start();
?> 
<?
	include('../conexion.php');	
	require('../menu.php');

	$link = conexion();

	$canno1 = $_POST['canno1'];	
	$cmes1 = $_POST['cmes1'];
	$cdia1 = $_POST['cdia1'];

	$canno2 = $_POST['canno2'];
	$cmes2 = $_POST['cmes2'];
	$cdia2 = $_POST['cdia2'];
	
	$distribuidor = $_POST['distribuidor'];
	
	$graficar = $_POST['graficar'];	
	
	if(! checkdate($cmes1,$cdia1,$canno1))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="../distribucion.php">volver</a><?
	  die;
	}
	else { $fecha1 = $canno1.'-'.$cmes1.'-'.$cdia1;}

	if(! checkdate($cmes2,$cdia2,$canno2))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="../distribucion.php">volver</a><?
	  die;
	}
	else { $fecha2 = $canno2.'-'.$cmes2.'-'.$cdia2;}
	
	if($graficar == 1){
		$sql_dist = mysqli_query($link,"SELECT f_nombre_distribuidor('$distribuidor')");	
		$nom_dist = mysqli_fetch_array($sql_dist);
		
		$c = 0;
		$sql = mysqli_query($link,"call sp_control_BotellasLiquidacion('$fecha1','$fecha2','$distribuidor')");
	
		$botellasRecepcion = array();
		$botellasDespacho  = array();
		$botellasVendidas  = array();
		$fecha = array();
	
		while($res = mysqli_fetch_array($sql)){	
			$fecha[$c] = $res[0];
			$botellasRecepcion[$c] = $res[1];
			$botellasDespacho[$c]  = $res[2];
			$botellasVendidas[$c]  = $res[3];
			$c++;
		}		
		$botRec = implode(",",$botellasRecepcion);
		$botDes = implode(",",$botellasDespacho);
		$botVen = implode(",",$botellasVendidas);
		$fech = implode(",",$fecha);
	
		header("Location: estadistica_comercializacion.php?botR=$botRec&botD=$botDes&botV=$botVen&nom_dist=$nom_dist[0]&fecha=$fech");
	}
	else{
		header("Location: resumen_comercializacion.php?fi=$fecha1&ff=$fecha2&dist=$distribuidor");
	}	
?>
<?
ob_end_flush();
?>
