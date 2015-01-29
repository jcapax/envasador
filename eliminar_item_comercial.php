<?php
ob_start();
?> 
<html>
<head>
<? 
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	$id_comercial = $_GET['id_comercial'];
	$id_producto = $_GET['id_producto'];
	$rec = $_GET['recuperacion'];
	$bon = $_GET['bonificacion'];
	$efe = $_GET['efectivo'];
	$tipent = $_GET['tipent'];
	
	$id_return = dechex($id_comercial);
?>
</head>
<body>
<?
	$elim_item_recep = mysqli_query($link,"DELETE FROM itemComercial WHERE idComercial = '$id_comercial' AND IdProducto = '$id_producto' AND recuperacion = '$rec' AND bonificacion = '$bon' AND efectivo = '$efe'");
	
	header("Location: item_comer.php?id_comercial=$id_return&tipent=$tipent");
?>
</body>
</html>

