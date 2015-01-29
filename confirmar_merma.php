<?php
ob_start();
?> 
<?
	include('conexion.php');
	$link = conexion();
	
	$id_merma = $_GET['id_merma'];
		
		$actualizar_merma = mysqli_query($link,"Update mermaProductos Set Estado = 1 Where idMerma = '$id_merma'");				
	header("Location: mermas.php");
?>
<?php
ob_end_flush();
?>