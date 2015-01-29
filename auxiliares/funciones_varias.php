<?
	function nombre_cliente($link,$id_cliente){
		$sel_cliente = mysqli_query($link,"SELECT f_nombre_cliente('$id_cliente')");
		$reg_cliente = mysqli_fetch_array($sel_cliente);
		$nombre_cliente = $reg_cliente[0];
		
		return $nombre_cliente;
	};

	function nombre_distribuidor($link,$id_distribuidor){
		$sel_distribuidor = mysqli_query($link,"SELECT f_nombre_distribuidor('$id_distribuidor')");
		$reg_distribuidor = mysqli_fetch_array($sel_distribuidor);
		$nombre_distribuidor = $reg_distribuidor[0];
		
		return $nombre_distribuidor;
	};
?>