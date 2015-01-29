<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$tipo_nota = $_POST['tipo_nota'];
	$nroNota = $_POST['nroNota'];
	$canno = $_POST['canno'];
	$cmes = $_POST['cmes'];
	$cdia = $_POST['cdia'];
	if ($tipo_nota <> 3){$distribuidor = $_POST['distribuidor'];}
	else{$distribuidor = 0;}
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
	if($tipo_nota == 0)
	{
		echo '<br>'.'Seleccionar Tipo de Nota'.'<br>'; 
		?><a href="procesos.php">volver</a><?
		die;
	}

	if(($tipo_nota == 1)or($tipo_nota == 4)){
		if($distribuidor == 0){
			echo '<br>'.'Seleccionar Distribuidor'.'<br>'; 
			?><a href="procesos.php">volver</a><?
			die;
		}
	}
		
  	if(! checkdate($cmes,$cdia,$canno))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="procesos.php">volver</a><?
	  die;
	}
	else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
	if($tipo_nota == 2){
			$distribuidor = 0;
		}
		
	$new = mysqli_query($link,"SELECT f_nuevo_proceso('$tipo_nota');");	
	
	$nuevo_proceso = mysqli_fetch_array($new);	

//*********************************************		
	if (($tipo_nota == 1)or($tipo_nota==4)or($tipo_nota==6)){
		$sql_idliq = mysqli_query($link, "SELECT idLiquidacion FROM liquidacion WHERE idDistribuidor = '$idDistribuidor' and estado = 0");
		
		$cont_liq = mysqli_num_rows($sql_idliq);
		if ($cont_liq <> 0){
			$idliq = mysqli_fetch_array($sql_idliq);
		}
		else{
			$ins_liq = mysqli_query($link, "INSERT INTO liquidacion(idDistribuidor, estado) VALUES('$idDistribuidor', 0)");
			$new_liq = mysqli_query($link, "SELECT idLiquidacion FROM liquidacion WHERE idDistribuidor = '$idDistribuidor' ORDER BY idLiquidacion DESC LIMIT 1");
			$idliq   = mysqli_fetch_array($new_liq);
		}
		$idLiquidacion = $idliq[0];
	}
	else{
		$idLiquidacion = 0;
	}
//*********************************************		
	
	if (($acceso == 1)or($acceso == 2)or($acceso == 4)){
		
		$insProc = "INSERT INTO Procesos(idProceso, TipoNota, IdDistribuidor, Fecha,Detalle, CodigoUsuario, FechaHoraRegistro, Estado, nroNota, idLiquidacion) VALUES('$nuevo_proceso[0]', '$tipo_nota', '$distribuidor', '$fecha', UPPER('$detalle'), '$codigo_usuario', now(), 0, '$nroNota', '$idLiquidacion')";
		
		if($tipo_nota <> 4){		
			$idProceso = mysqli_query($link, "SELECT idProceso FROM procesos WHERE nroNota = '$nroNota' AND tipoNota = 4");
			$idProcOri = mysqli_fetch_array($idProceso);
	
			$dev = "INSERT INTO procesoDevolucion(idProcesoDevolucion, tipoNotaDevolucion, idProceso) VALUES('$nuevo_proceso[0]', '$tipo_nota', '$idProcOri[0]')";
	//		echo $dev;	
			$ins_devo = mysqli_query($link, $dev);	
		}
		
		$ins_proc = mysqli_query($link,$insProc);
	}
	else{
		$insProc = "INSERT INTO Procesos(idProceso, TipoNota, IdDistribuidor, Fecha,Detalle, CodigoUsuario, FechaHoraRegistro, Estado, idLiquidacion) VALUES('$nuevo_proceso[0]', '$tipo_nota', '$distribuidor', '$fecha', UPPER('$detalle'), '$codigo_usuario', now(), 0, '$idLiquidacion')";	
		
		$ins_proc = mysqli_query($link,$insProc);
	}
		
	header("Location: item_proceso.php?id_proceso=$nuevo_proceso[0]&tipo_nota=$tipo_nota");
?>
</body>
</html>
<?php
ob_end_flush();
?>
