<?php
ob_start();
?> 
<?
	include('conexion.php');
	$link = conexion();
	
	$id_comercial = hexdec($_GET['id_comercial']);
		
	$actualizar_comercial = mysqli_query($link,"Update comercial Set Estado = 1 Where idComercial = '$id_comercial'");				
	
//*********************************************	
		
	$dist = mysqli_query($link, "SELECT idDistribuidor, tipoEntrega, nroNota FROM comercial WHERE idComercial = '$id_comercial'");
	$fil_dist = mysqli_fetch_array($dist);
	$idDistribuidor = $fil_dist['idDistribuidor'];
	$tipoEntrega = $fil_dist['tipoEntrega'] + 7;
	$nroNota = $fil_dist['nroNota'];
	
	$sql_idliq = mysqli_query($link, "SELECT id FROM liquidacion2 WHERE idDistribuidor = '$idDistribuidor' and estado = 0");
	
	$cont_liq = mysqli_num_rows($sql_idliq);
	if ($cont_liq <> 0){
		$idliq = mysqli_fetch_array($sql_idliq);
		$idLiquidacion2 = $idliq[0];
	}
	else{
//		$ins_liq = mysqli_query($link, "INSERT INTO liquidacion2(idDistribuidor, estado) VALUES('$idDistribuidor', 0)");
//		$new_liq = mysqli_query($link, "SELECT id FROM liquidacion2 WHERE idDistribuidor = '$idDistribuidor' ORDER BY id DESC LIMIT 1");
//		$idliq   = mysqli_fetch_array($new_liq);
		
		$idLiquidacion2 = 0;
	}

//	$idLiquidacion2 = $idliq[0];

	if($idLiquidacion2 <> 0){
		$ins_mov = mysqli_query($link,"INSERT INTO movimiento(idTipoMovimiento, idDistribuidor, idLiquidacion2, destino) VALUES('$tipoEntrega', '$idDistribuidor', '$idLiquidacion2', 'A')");
		
		$sql_idMov = mysqli_query($link,"SELECT id FROM movimiento ORDER BY id DESC LIMIT 1");
		$idMov = mysqli_fetch_array($sql_idMov);
		$idMovimiento = $idMov[0];
		
		$sql_itemComercial = mysqli_query($link, "SELECT idcomercial, idProducto, cantidad, precioTotal FROM itemComercial WHERE idComercial = '$id_comercial'");
		while($fil_detCom = mysqli_fetch_array($sql_itemComercial)){
			$precUnit = $fil_detCom[precioTotal] / $fil_detCom[cantidad];
			$ins_itemMov = mysqli_query($link, "INSERT INTO itemMovimiento(idMovimiento, idProducto, cantidad, precioUnitario, precioTotal) VALUES('$idMovimiento', '$fil_detCom[idProducto]', '$fil_detCom[cantidad]', '$precUnit', '$fil_detCom[precioTotal]')");
		}
	
		
		$act_comercial = mysqli_query($link,"Update comercial Set idMovimiento = '$idMovimiento' Where idComercial = '$id_comercial'");	
	}
	

//*********************************************		

	header("Location: comercial.php");
?>
<?php
ob_end_flush();
?>