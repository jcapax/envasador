<?php
ob_start();
?> 
<?
	include('../conexion.php');
	$link = conexion();
	
	$id_cliente = $_GET['id_cliente'];

	$actualizar_saldo = mysqli_query($link,"Update saldosInicialesComercial	Set estado = 1 Where idCliente = '$id_cliente'");				
	header("Location: saldos_comercial.php");
?>
<?php
ob_end_flush();
?>