<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];

	include("../autenticacion.php");
	require('menu.php');
	echo "<br>";
	require('menu_reporte.php');
	include('../conexion.php');
	$link = conexion();

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	
	echo "<br>";
?>
<html>
<head>
<title>ESTADO INGRESO - SALIDA ENVASES</title>
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<style type="text/css">@import "../js/jquery.datepick.css";</style> 
<script type="text/javascript">
$(function() {	
		$('#fecha1').datepick();
	});
$(function() {	
		$('#fecha2').datepick();
	});
</script>
</head>

<body>
<h1>ESTADO INGRESO SALIDA ENVASES</h1>
<form name="form1" method="post" action="reporte_entrada_salida_envases.php">
  <table width="595" border="0">
    <tr>
      <td width="95">Fecha Inicial:</td>
      <td width="490"><input name="fecha1" type="text" id="fecha1" size="10" maxlength="12"></td>
    </tr>
    <tr>
      <td>Fecha Final; </td>
      <td><input name="fecha2" type="text" id="fecha2" size="10" maxlength="12"></td>
    </tr>
    <tr>
      <td>Distribuidor: </td>
      <td><select name="distribuidor" id="distribuidor">
          <?	
	  		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE flag = 1 ORDER BY NombreDistribuidor");
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
			}
	  ?>
      </select></td>
    </tr>
    <tr>
      <td>Saldo Inicial: </td>
      <td><input name="saldo_inicial" type="checkbox" id="saldo_inicial" value="1" checked></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
