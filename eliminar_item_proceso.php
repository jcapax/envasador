<?php
ob_start();
?> 
<html>
<head>
<? 
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	$id_proceso = $_GET['id_proceso'];
	$tipo_nota = $_GET['tipo_nota'];
	$id_producto = $_GET['id_producto'];
?>
</head>
<body>
<?
	$elim_item_recep = mysqli_query($link,"DELETE FROM itemproceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND IdProducto = '$id_producto'");
	
//**************************************
//*********** ELIMINACION BOTELLAS
//**************************************
	if(($tipo_nota == 4)or($tipo_nota == 3)){
	
		$del_botellas = mysqli_query($link,"DELETE FROM itemProceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto = 13");
			
		$sql_bot = mysqli_query($link,"SELECT SUM(cantidad) FROM itemProceso WHERE IdProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto IN(1,2,3,17)");
		$botellas = mysqli_fetch_array($sql_bot);
		
				//echo $botellas[0];
		
		$ins_item_recep = mysqli_query($link,"INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota',13,'$botellas[0]')");
	}
//**************************************
//*********** ELIMINACION CAJAS	
//**************************************	
	if($tipo_nota == 3){
	
		$del_cajas = mysqli_query($link,"DELETE FROM itemProceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto = 14");
			
		$sql_cajas = mysqli_query($link,"SELECT SUM(cantidad) FROM itemProceso WHERE IdProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto IN(1,2,3,17)");
			$cajas = mysqli_fetch_array($sql_cajas);	

			$aux_cajas = intval($cajas[0]/12);
			
			$ins_item_prod = mysqli_query($link,"INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota',14,'$aux_cajas')");
	}
//**************************************		
	header("Location: item_proceso.php?id_proceso=$id_proceso&tipo_nota=$tipo_nota");
?>
</body>
</html>

