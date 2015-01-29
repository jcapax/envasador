<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	
	
	$tipo_merma = $_POST['tipo_merma'];
	$tipo_nota  = $_POST['tipo_nota'];
	
	$fecha       = $_POST["fecha"];
	$fecha_explo = explode('-',$fecha);
	
	$canno 		 = $fecha_explo[0];
	$cmes 		 = $fecha_explo[1];
	$cdia 		 = $fecha_explo[2];
	
//	echo $fecha.' '.$canno.' '.$cmes.' '.$cdia;
	
	$detalle = $_POST['detalle'];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

?>
<html>
<head>
<title>Mensaje Recpción</title>
</head>
<body>
<?
  	if(!checkdate($cmes,$cdia,$canno))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="mermas.php">volver</a><?
	  die;
	}
	//else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
	echo $fecha.' '.$tipo_nota.' '.$detalle.' '.$codigo_usuario;
	
	$ins_merma = mysqli_query($link,"INSERT INTO mermaProductos(fecha,tipoNota,detalle,codigoUsuario,fechaHoraRegistro,estado) VALUES('$fecha','$tipo_nota',UPPER('$detalle'),'$codigo_usuario',now(),0)");
	
	
	$new_merma = mysqli_query($link,"SELECT idMerma FROM mermaProductos ORDER BY idMerma DESC LIMIT 1");
	$id_merma = mysqli_fetch_array($new_merma);
	
	header("Location: item_mermas.php?id_merma=$id_merma[0]&tn=$tipo_nota");
?>
</body>
</html>
<?php
ob_end_flush();
?>