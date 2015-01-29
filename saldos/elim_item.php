<?php
ob_start();
?> 
<html>
<head>
<? 
	include('../conexion.php');
	$link = conexion();
	
	$id_cliente = $_GET['id_cliente'];
	$id_producto = $_GET['id_producto'];
?>
</head>
<body>
<?
	echo $id_cliente.' '.$id_producto.' '."DELETE FROM itemSaldos WHERE idCliente = '$id_cliente' AND idProducto = '$id_producto'";
	$elim_item_saldo = mysqli_query($link,"DELETE FROM itemSaldos WHERE idCliente = '$id_cliente' AND idProducto = '$id_producto'");	
	header("Location: ../saldos/item_saldos.php?id_cliente=$id_cliente");

echo "<a href='item_saldos.php'>../saldos/item_saldos.php?id_cliente=$id_cliente</a>"
?>
</body>
</html>
<?php
ob_end_flush();
?>