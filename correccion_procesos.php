<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];

	$id_proceso_ant = $_POST['id_proceso_ant'];
	$tipo_nota_ant = $_POST['tipo_nota_ant'];
	
	$canno = $_POST['canno'];
	$cmes = $_POST['cmes'];
	$cdia = $_POST['cdia'];
	
	if ($tipo_nota_ant <> 3){$distribuidor = $_POST['distribuidor'];}
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
	if(($tipo_nota == 1)or($tipo_nota == 4)){
		if($distribuidor == 0){
			echo '<br>'.'Seleccionar Distribuidor'.'<br>'; 
			echo "<a href='editar_proceso.php?id_proceso=$id_proceso_ant&tipo_nota=$tipo_nota_ant'>volver</a>";
			die;
		}
	}
		
  	if(! checkdate($cmes,$cdia,$canno))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  echo "<a href='editar_proceso.php?id_proceso=$id_proceso_ant&tipo_nota=$tipo_nota_ant'>volver</a>";
	  die;
	}
	else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
	if($tipo_nota == 2){
			$distribuidor = 0;
		}
		
	$sql = "UPDATE Procesos SET idDistribuidor = '$distribuidor',Fecha = '$fecha', Detalle = UPPER('$detalle') WHERE idProceso = '$id_proceso_ant' AND TipoNota = '$tipo_nota_ant'";

//	echo $sql;
	$up_proceso = mysqli_query($link, $sql);
	
	header("Location: procesos.php");
?>
<?php
ob_end_flush();
?>
</body>
</html>
