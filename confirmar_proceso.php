<?php
ob_start();
?> 
<?
	include('conexion.php');
	$link = conexion();
	
	$id_proceso = $_GET['id_proceso'];
	$tipo_nota = $_GET['tipo_nota'];
	
	$actualizar_procesos = mysqli_query($link,"Update procesos Set Estado = 1 Where idProceso = '$id_proceso' AND TipoNota = '$tipo_nota'");				


//*********************************************	
		
	$dist = mysqli_query($link, "SELECT idDistribuidor, nroNota FROM procesos WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota'");
	$fil_dist = mysqli_fetch_array($dist);
	
	$idDistribuidor = $fil_dist[0];
	$nroNota        = $fil_dist['nroNota'];

	if (($tipo_nota == 1)or($tipo_nota==4)or($tipo_nota==6)){
        		
		$sql_idliq = mysqli_query($link, "SELECT id FROM liquidacion2 WHERE idDistribuidor = '$idDistribuidor' and estado = 0");
		
		$cont_liq = mysqli_num_rows($sql_idliq);		
		
		if ($cont_liq <> 0){
			$idliq = mysqli_fetch_array($sql_idliq);
		}
		else{
				if($tipo_nota == 4){
//					echo "INSERT INTO liquidacion2(fechaApertura, idDistribuidor, estado) VALUES(now(),'$idDistribuidor', 0)";
					$ins_liq = mysqli_query($link, "INSERT INTO liquidacion2(fechaApertura, idDistribuidor, estado) VALUES(now(),'$idDistribuidor', 0)");
					$new_liq = mysqli_query($link, "SELECT id FROM liquidacion2 WHERE idDistribuidor = '$idDistribuidor' ORDER BY id DESC LIMIT 1");
					$idliq   = mysqli_fetch_array($new_liq);
				}
		}		
		$idLiquidacion2 = $idliq[0];
	}
	else{
		$idLiquidacion2 = 0;
	}	
	
	if ($idLiquidacion2 <> 0){
//		echo "INSERT INTO movimiento(idTipoMovimiento, idDistribuidor, idLiquidacion2) VALUES('$tipo_nota', '$idDistribuidor', '$idLiquidacion2')";
		$ins_mov = mysqli_query($link,"INSERT INTO movimiento(idTipoMovimiento, idDistribuidor, idLiquidacion2, destino) VALUES('$tipo_nota', '$idDistribuidor', '$idLiquidacion2', 'A')");
		
		$sql_idMov = mysqli_query($link,"SELECT id FROM movimiento ORDER BY id DESC LIMIT 1");
		$idMov = mysqli_fetch_array($sql_idMov);
		$idMovimiento = $idMov[0];
		
		$sql_itemProceso = mysqli_query($link, "SELECT idProceso, tipoNota, idProducto, cantidad, precio FROM itemProceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota'");
		while($fil_detProc = mysqli_fetch_array($sql_itemProceso)){
			$precUnit = $fil_detProc[precio] / $fil_detProc[cantidad];
			
			$ins_itemMov = mysqli_query($link, "INSERT INTO itemMovimiento(idMovimiento, idProducto, cantidad, precioUnitario, precioTotal) VALUES('$idMovimiento', '$fil_detProc[idProducto]', '$fil_detProc[cantidad]', '$precUnit', '$fil_detProc[precio]')");
			
		$act_proceso = mysqli_query($link,"Update procesos Set idMovimiento = '$idMovimiento' Where idProceso = '$id_proceso' AND TipoNota = '$tipo_nota'");	
		}	
	}

//*********************************************		


	header("Location: procesos.php");
?>
<?php
ob_end_flush();
?>