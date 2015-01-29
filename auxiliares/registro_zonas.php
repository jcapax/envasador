<?php
ob_start();
?>
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();
	
	if($_POST){
		$nombre_zona = $_POST['nombre_zona'];
		$tipoR = $_POST['tipoR'];
		
		if($nombre_zona==''){
			echo "Favor revisar el registro de la zona!!!";
			die;
		}
		else{
			mysqli_query($link,"INSERT INTO zonas(nombreZona,idLugar) VALUES('$nombre_zona',1)");
			header ("Location: ../codificar_clientes.php?tipoR=$tipoR");
		}		
	}
	else{
		$tipoR = $_GET['tipoR'];
	}
?>
<html>
<head>
<title>Registro Zonas</title>
</head>
<body>
<h1>REGISTRO ZONAS</h1>
<form name="form1" method="post" action="registro_zonas.php">
  <table width="453" border="0">
    <tr>
      <td width="112">Lugar</td>
      <td width="331"><input name="textfield" type="text" value="SUCRE" readonly="">
      <input type="hidden" name="tipoR" value="<? echo $tipoR?>"></td>
    </tr>
    <tr>
      <td><label>Nombre Zona: </label></td>
      <td><input name="nombre_zona" type="text" id="nombre_zona" size="45" maxlength="45"></td>
    </tr>
    <tr>
      <td><input name="Submit" type="submit" id="Submit" value="Enviar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp; </p>
</body>
</html>
<?php
ob_end_flush();
?>