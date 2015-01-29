<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$nota_venta 	= $_POST['nota_venta'];
	$nroNota     	= $_POST['nroNota'];
	$idCliente 		= $_POST['idCliente'];
	$idDistribuidor = $_POST['idDistribuidor'];
	$canno 			= $_POST['canno'];
	$cmes 			= $_POST['cmes'];
	$cdia 			= $_POST['cdia'];
	$tipoEvento		= $_POST['tipo_evento'];
	$detalle		= $_POST['detalle'];
	$tipoEntrega	= $_POST['tipoEntrega'];
	$fecha_credito  = $_POST['fecha_credito'];
		
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

?>
<html>
<head>
<title>Mensaje Comercial</title>
</head>
<body>
<?
  	if(! checkdate($cmes,$cdia,$canno))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="comercial.php">volver</a><?
	  die;
	}
	else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
	if($idDistribuidor == 0){ 
	  echo '<br>'.'Seleccionar Distribuidor!!!'.'<br>';
	  ?><a href="comercial.php">volver</a><?
	  die;
	}

	if($idCliente == 0){ 
	  echo '<br>'.'Seleccionar Cliente!!!'.'<br>';
	  ?><a href="comercial.php">volver</a><?
	  die;
	}

	if($tipoEvento == 0){ 
	  echo '<br>'.'Seleccionar el tipo de Evento que se atiendió con la nota de entrega!!!'.'<br>';
	  ?><a href="comercial.php">volver</a><?
	  die;
	}
	
//	echo $nota_venta.''.$fecha.''.$idCliente.''.$idDistribuifdor.''.$codigo_usuario;
	$ins_comer = mysqli_query($link,"INSERT INTO comercial(notaVenta, nroNota, fecha, idCliente, idDistribuidor, fechaHoraRegistro, codigoUsuario, estado, idTipoEvento, detalle, tipoEntrega) VALUES('$nota_venta', '$nroNota', '$fecha','$idCliente', '$idDistribuidor', now(), '$codigo_usuario', 0, '$tipoEvento', '$detalle', '$tipoEntrega')");
	
	$new_comer = mysqli_query($link,"SELECT idComercial FROM comercial ORDER BY idComercial DESC LIMIT 1");
	$id_comer = mysqli_fetch_array($new_comer);

	$idProc    = mysqli_query($link, "SELECT idProceso FROM procesos WHERE nroNota = '$nroNota' AND tipoNota = 4");
	$idProcOri = mysqli_fetch_array($idProc);

	$dev = "INSERT INTO procesoComercial(idComercial, idProceso) VALUES('$id_comer[0]', '$idProcOri[0]')";
//	echo $nroNota.' **** '.$dev;
	$ins_devo = mysqli_query($link, $dev);	
	


	$id = dechex($id_comer[0]);
	
	if($idDistribuidor == 3350){
		$upd_cl = mysqli_query($link,"UPDATE clientes SET tipoPrecio = 2 WHERE idCliente = '$idCliente'");
	}
	
	if($idDistribuidor == 14){
		$upd_cl = mysqli_query($link,"UPDATE clientes SET tipoPrecio = 11 WHERE idCliente = '$idCliente'");
	}

//   ********************** LIQUIDACION	****************************

	$sql_idliq = mysqli_query($link, "SELECT idLiquidacion FROM liquidacion WHERE idDistribuidor = '$idDistribuidor' and estado = 0");
	
	$cont_liq = mysqli_num_rows($sql_idliq);
	if ($cont_liq <> 0){
		$idliq = mysqli_fetch_array($sql_idliq);
//		$ins_itemliq = mysqli_query($link, "INSERT INTO itemLiquidacion(idLiquidacion, idComercial) VALUES('$idliq[0]','$id_comer[0]')");
//		echo "hastaqui";	
	}
	else{
		$ins_liq = mysqli_query($link, "INSERT INTO liquidacion(idDistribuidor, estado) VALUES('$idDistribuidor', 0)");
		$new_liq = mysqli_query($link, "SELECT idLiquidacion FROM liquidacion WHERE idDistribuidor = '$idDistribuidor' ORDER BY idLiquidacion DESC");
		$idliq   = mysqli_fetch_array($new_liq);
//		$ins_itemliq = mysqli_query($link, "INSERT INTO itemLiquidacion(idLiquidacion, idComercial) VALUES('$idliq[0]','$id_comer[0]')");
//		echo "masaqui";	
	}
//	echo "SELECT idLiquidacion FROM liquidacion WHERE idDistribuidor = '$idDistribuidor' and estado = 0";
//	echo $cont_liq.' - '.$idliq[0].' - '.$id_comer[0].' **** '.$fecha_credito;
	
	header("Location: item_comer.php?id_comercial=$id&tipent=$tipoEntrega");
?>
</body>
</html>
<?php
ob_end_flush();
?>
