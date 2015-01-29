<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$nota = $_POST['nota'];
	$idCliente = $_POST['idCliente'];
	$idDistribuidor = $_POST['idDistribuidor'];
	$efectivo = $_POST['efectivo'];
	$canno = $_POST['canno'];
	$cmes = $_POST['cmes'];
	$cdia = $_POST['cdia'];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();

?>
<html>
<head>
<title>Mensaje Saldos Iniciales</title>
</head>
<body>
<?
  	if(! checkdate($cmes,$cdia,$canno))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="saldos_comercial.php">volver</a><?
	  die;
	}
	else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
	if($idDistribuidor == 0){ 
	  echo '<br>'.'Seleccionar Distribuidor!!!'.'<br>';
	  ?><a href="saldos_comercial.php">volver</a><?
	  die;
	}

	if($idCliente == 0){ 
	  echo '<br>'.'Seleccionar Cliente!!!'.'<br>';
	  ?><a href="saldos_comercial.php">volver</a><?
	  die;
	}
	
	$cl_reg = mysqli_query($link,"SELECT idCliente FROM  saldosInicialesComercial WHERE idCliente = '$idCliente'");
	if(mysqli_num_rows($cl_reg) == 1){	
	  echo '<br>'.'EL CLIENTE YA SE ENCUENTRA REGISTRADO, FAVOR REVISAR!!!'.'<br>';
	  ?><a href="saldos_comercial.php">volver</a><?
	  die;
	}

		$ins_comer = mysqli_query($link,"INSERT INTO saldosInicialesComercial(nota,fecha,idCliente,idDistribuidor,fechaHoraRegistro,codigoUsuario,estado,saldoEfectivo) VALUES('$nota','$fecha','$idCliente','$idDistribuidor',now(),'$codigo_usuario',0,'$efectivo')");		
		header("Location: item_saldos.php?id_cliente=$idCliente&id_distribuidor=$idDistribuidor");
	
?>
</body>
</html>
<?php
ob_end_flush();
?>