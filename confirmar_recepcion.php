<?
	include('conexion.php');
	$link = conexion();
	
	if (!empty($_POST['id_recepcion']))
	{
		$lista_numero_egreso = array_keys($_POST['id_recepcion']);
		$lista = implode(",",$lista_numero_egreso);
		$actualizar_egreso = mysqli_query($link,"Update recepciones Set Estado = 1 Where IdRecepcion In ($lista)");
	}	
	header("Location: recepcion.php");
?>