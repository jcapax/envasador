<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	echo "<br>";
	require('menu_reportes.php');
	include('../conexion.php');
	$link = conexion();

	if($acceso >= 8){
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}
?>
<html>
<head>
<title>Seleccion Reportes</title>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
#Layer1 {	position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
-->
</style>
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
<?
	if (($acceso == 1)or($acceso == 5)){
		echo "<br>"."<a href='recep_envases.php'>Recepción de Envases</a>";
		echo "<br>"."<a href='rep_productos.php'>Producción</a>";
		echo "<br>"."<a href='rep_despachos.php'>Despachos</a>";
		echo "<br>"."<a href='rep_mermas.php'>Mermas</a>";
		echo "<br>"."<a href='rep_stock.php'>stock</a>";
	}

	if ($acceso == 2){
		echo "<br>"."<a href='recep_envases.php'>Recepción de Envases</a>";
		echo "<br>"."<a href='rep_productos.php'>Producción</a>";
		echo "<br>"."<a href='rep_stock.php'>stock</a>";
	}

	if ($acceso == 3){
		echo "<br>"."<a href='rep_productos.php'>Producción</a>";
		echo "<br>"."<a href='rep_mermas.php'>Mermas</a>";
		echo "<br>"."<a href='rep_stock.php'>stock</a>";
	}

	if ($acceso == 4){
			echo "<br>"."<a href='rep_productos.php'>Producción</a>";
			echo "<br>"."<a href='rep_despachos.php'>Despachos</a>";
			echo "<br>"."<a href='rep_stock.php'>Stock</a>";
	}
?>
</body>
</html>
