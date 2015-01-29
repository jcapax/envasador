<?php
ob_start();
?> 
<?
	include("../conexion.php");
	$link = conexion();
	
	$distribuidor = hexdec($_GET['distribuidor']);
	
	$actualizar_saldo = mysqli_query($link,"Update saldosInicialesEnvasesDistribuidores	Set estado = 1, fechaHoraRegistro = now() Where idDistribuidor = '$distribuidor'");				

	header("Location: saldos_envases.php");
?>
<?php
ob_end_flush();
?>