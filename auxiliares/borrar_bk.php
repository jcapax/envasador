<?
	include('../conexion.php');
	$link = conexion();
	
	$archivo = "/procesos.env";

	if(file_exists($archivo)){
		unlink($archivo);
		echo "existe";
	}
	else{
		echo "no existe"."<br>";
	}
	
	$sql = mysqli_query($link,"CALL sp_bk()");
//	$sql = mysqli_query($link,"SELECT * INTO OUTFILE 'c:/procesos.env' fields terminated by '|' lines terminated by '\r\n' FROM comercial c JOIN itemComercial i USING(idComercial) JOIN clientes l USING(idCliente) JOIN distribuidores d ON c.idDistribuidor = d.idDistribuidor WHERE c.fecha BETWEEN '2009-08-01' AND '2009-08-18' AND c.estado = 1;");
	echo mysqli_num_rows($sql).'>>>><<<<< '.$archivo;
	
	if(file_exists($archivo)){
		echo "existe";
	}
	else{
		echo " no existe";
	}

?>