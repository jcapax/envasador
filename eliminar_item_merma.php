<?php
ob_start();
?> 
<html>
<head>
<? 
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	$id_merma = $_GET['id_merma'];
	$tipo_merma = $_GET['tipo_merma'];
	$id_producto = $_GET['id_producto'];
?>
</head>
<body>
<?
	$elim_item_recep = mysqli_query($link,"DELETE FROM itemMermaProductos WHERE idMerma = '$id_merma' AND tipoMerma = '$tipo_merma' AND IdProducto = '$id_producto'");
	
	header("Location: item_mermas.php?id_merma=$id_merma&tipo_merma=$tipo_merma");
?>
</body>
</html>

