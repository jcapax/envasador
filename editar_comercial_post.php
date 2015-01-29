<?php
ob_start();
?>
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

	if ($_POST){
		$idComercial = $_POST['id_comercial'];
		$nota_venta = $_POST['nota_venta'];
		$idCliente = $_POST['idCliente'];
		$idDistribuidor = $_POST['idDistribuidor'];
		$canno = $_POST['canno'];
		$cmes = $_POST['cmes'];
		$cdia = $_POST['cdia'];
		
		$tipoEvento		= $_POST['tipo_evento'];
		$detalle		= $_POST['detalle'];
		$tipoEntrega	= $_POST['tipoEntrega'];
		$fecha_credito  = $_POST['fecha_credito'];
		
		if(! checkdate($cmes,$cdia,$canno))
		{ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  die;
		}
		else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}


		if ($nota_venta == ''){
			echo "Nota de Venta inválida, favor revisar!!!";
			die;
		}		
		if ($idCliente == ''){
			echo "Cliente inválido, favor revisar!!!";
			die;
		}		
		if ($idDistribuidor == ''){
			echo "Distribuidor inválido, favor revisar!!!";
			die;
		}	
		
		$qq = "UPDATE comercial SET notaVenta = '$nota_venta', fecha = '$fecha', idCliente = '$idCliente', idDistribuidor = '$idDistribuidor', idTipoEvento = '$tipoEvento', tipoEntrega = '$tipoEntrega', detalle = '$detalle' WHERE idComercial = '$idComercial'";
		$sql = mysqli_query($link,$qq);				
/*		
		if ($tipoEntrega == 1){
			$qq = "UPDATE comercial SET notaVenta = '$nota_venta', fecha = '$fecha', idCliente = '$idCliente', idDistribuidor = '$idDistribuidor', idTipoEvento = '$tipoEvento', tipoEntrega = '$tipoEntrega', detalle = '$detalle' WHERE idComercial = '$idComercial'";
//			echo $qq;
			$sql = mysqli_query($link,$qq);	
		}
		else{
			$qq = "UPDATE comercial SET notaVenta = '$nota_venta', fecha = '$fecha', idCliente = '$idCliente', idDistribuidor = '$idDistribuidor', idTipoEvento = '$tipoEvento', tipoEntrega = 0, detalle = '$detalle', fechaCredito = '$fecha_credito' WHERE idComercial = '$idComercial'";
			$scr = $qq;
//			echo $qq;
			$sql = mysqli_query($link, $scr);	
						
			//echo $scr;
		}
*/		
		header("Location: comercial.php");
	}
?>
<?php
ob_end_flush();
?>