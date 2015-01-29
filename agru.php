<?php
ob_start();
?> 
<?
	include('conexion.php');	
	require('menu.php');

	$link = conexion();

	$canno1 = $_POST['canno1'];	
	$cmes1 = $_POST['cmes1'];
	$cdia1 = $_POST['cdia1'];

	$canno2 = $_POST['canno2'];
	$cmes2 = $_POST['cmes2'];
	$cdia2 = $_POST['cdia2'];
	
	$tipo_nota = $_POST['tipo_nota'];	
	
	$distribuidor = $_POST['distribuidor'];
	
	if(! checkdate($cmes1,$cdia1,$canno1))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="distribucion.php">volver</a><?
	  die;
	}
	else { $fecha1 = $canno1.'-'.$cmes1.'-'.$cdia1;}

	if(! checkdate($cmes2,$cdia2,$canno2))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="distribucion.php">volver</a><?
	  die;
	}
	else { $fecha2 = $canno2.'-'.$cmes2.'-'.$cdia2;}
	
	$sql_dist = mysqli_query($link,"SELECT f_nombre_distribuidor('$distribuidor')");
	
	$nom_dist = mysqli_fetch_array($sql_dist);

	$sql = mysqli_query($link,"SELECT p.idProceso, p.tipoNota, p.fecha, SUM(IF(i.idProducto = 13,i.Cantidad,0)) 'Bot620', SUM(IF(i.idProducto = 14,i.Cantidad,0)) 'Canst.' FROM procesos p JOIN itemProceso i USING(idProceso,tipoNota) WHERE idDistribuidor = '$distribuidor' AND tipoNota = '$tipo_nota' AND fecha BETWEEN '$fecha1' AND '$fecha2' AND estado = 1 GROUP BY p.idProceso, p.tipoNota, p.fecha");
	
	$c = 0;
	$botellas = array();
	$cajas = array();
	$fecha = array();

	while($res = mysqli_fetch_array($sql)){	
		$botellas[$c] = $res[3];
		$cajas[$c] = $res[4];
		$fecha[$c] = $res[2];
		$c++;
	}
	
	$bot = implode(",",$botellas);
	$caj = implode(",",$cajas);
	$fech = implode(",",$fecha);
	
		
	header("Location: graf.php?bot=$bot&caj=$caj&nom_dist=$nom_dist[0]&fecha=$fech");
?>
<?php
ob_end_flush();
?>
