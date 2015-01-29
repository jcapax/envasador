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
?>
<html>
<head>
<title>CLIENTES SIN MOVIMIENTO</title>
<style type="text/css">
<!--
#Layer1 {position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
-->
</style>
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
<div id="Layer1">
  <table width="97%" style="font-size:11px" border="0">
    <tr bgcolor="#CFDDFC">
      <td width="46%">Usuario:</td>
      <td width="54%" align="center"><? echo $login;?></td>
    </tr>
    <tr bgcolor="#CFDDFC">
      <td>Codigo:</td>
      <td align="center"><? echo $codigo_usuario;?></td>
    </tr>
    <tr>
      <td colspan="2"><a href='cambiar_contrasena.php'>Cambio Contrase&ntilde;a</a></td>
    </tr>
  </table>
</div>
<h1>CLIENTES SIN MOVIMIENTO  </h1>
<form action="sinmovimiento.php" method="post" name="form1" id="form1">
  <table width="551" border="0">
    <tr>
      <td width="88">Fecha Inicio: </td>
      <td width="453"><input name="fecha1" type="text" id="fecha1" size="12" maxlength="12"></td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><input name="fecha2" type="text" id="fecha2" size="12" maxlength="12"></td>
    </tr>
    <tr>
      <td>Tipo Local </td>
      <td><select name="tipo_local" id="tipo_local">
        <?	
		    echo "<option value='0'>-</option>";
  		    $sql_loc = mysqli_query($link,"SELECT * FROM locales ORDER BY nombreLocal");
			while($fil_loc = mysqli_fetch_array($sql_loc)){
				echo "<option value='$fil_loc[idlocal]'>$fil_loc[nombreLocal]</option>";
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td>Calle</td>
      <td><select name="calle" id="calle">
        <?	
		    echo "<option value='0'>-</option>";
		    $sql_cal = mysqli_query($link,"SELECT idcalle, nombreCalle FROM calles ORDER BY nombreCalle");
			while($fil_cal = mysqli_fetch_array($sql_cal)){
				echo "<option value='$fil_cal[0]'>$fil_cal[1]</option>";
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td>Distribuidor</td>
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
      <td><input type="submit" name="Submit" value="Reportar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
