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
		$zona = $_POST['zona'];
		$calle= $_POST['calle'];
		$tipoR = $_POST['tipoR'];
		
		if($zona==0){
			echo "Es requerido el registro del nombre de la Zona!!!";
			header ("Location: registro_calles.php");
		}		
		if($calle==''){
			echo "Favor revisar el registro de la calle!!!";
			die;
		}
		else{
			mysqli_query($link,"INSERT INTO calles(idZona,nombreCalle) VALUES('$zona','$calle')");
			header ("Location: ../codificar_clientes.php?tipoR=$tipoR");
		}		
	}
	else{
		$tipoR = $_GET['tipoR'];
	}
?>
<html>
<head>
<title>Registro Calles</title>
</head>
<body>
<h1>REGISTRO DE CALLES POR ZONAS</h1>
<form name="form1" method="post" action="">
  <table width="383" border="0">
    <tr>
      <td width="65">Lugar: </td>
      <td width="308"><input name="textfield" type="text" value="SUCRE" readonly="">
      <input type="hidden" name="tipoR" value="<? echo $tipoR?>"></td>
    </tr>
    <tr>
      <td>Zona:</td>
      <td>
	  	<? 
				$sel_zonas = mysqli_query($link,"Select idZona, nombreZona From zonas WHERE idLugar = 1 Order  By nombreZona");
				echo "<select name='zona' id='zona'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_zonas = mysqli_fetch_array($sel_zonas)){
					echo "<option value='$fil_zonas[0]'>$fil_zonas[1]</option>";
				}
				echo "</select>";
		?>
	  </td>
    </tr>
    <tr>
      <td>Calle:</td>
      <td><input name="calle" type="text" id="calle" size="45" maxlength="45"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
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