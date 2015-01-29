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
	
	$calle       = $_POST["calle"];
	$distribuidor= $_POST["distribuidor"];
	$tipo_local  = $_POST["tipo_local"];
	
	
	$fecha1       = $_POST["fecha1"];
	$fecha2       = $_POST["fecha2"];
	
//	echo $fecha1.' <> '.$fecha2;
	$fecha_explo1 = explode('-',$fecha1);
	
	$anno1 		 = $fecha_explo1[0];
	$mes1 		 = $fecha_explo1[1];
	$dia1 		 = $fecha_explo1[2];

//	echo $mes1.' '.$dia1.'  '.$anno1;

	$fecha_explo2 = explode('-',$fecha2);
	
	$anno2 		 = $fecha_explo2[0];
	$mes2 		 = $fecha_explo2[1];
	$dia2 		 = $fecha_explo2[2];
	
	if(! checkdate($mes1,$dia1,$anno1))
	{ 	  
	  echo '<br>'.'Fecha 1 incorrecta!!!'.'<br>';
	  ?><a href="../distribucion.php">volver</a><?
	  die;
	}
	
	if(! checkdate($mes2,$dia2,$anno2))
	{ 
	  echo '<br>'.'Fecha 2 incorrecta!!!'.'<br>';
	  ?><a href="../distribucion.php">volver</a><?
	  die;
	}		
?>
<html>
<head>
<title>Bonificaciones</title>
<style type="text/css">
<!--
#Layer1 {position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
.style5 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<body>
<h1>CLIENTES SIN MOVIMIENTO  </h1>
<?
  	echo '<h3>'.'Entre '.$fecha1.' y el '.$fecha2.'</h3>'.'<p></p>';
	
	if ($calle == 0){
		$sql_calles = '';
	}
	else{
		$sql_calles = " AND idCalle = '$calle'";
	}
	
	if ($tipo_local == 0){
		$sql_tipo_local = "";
	}
	else{
	    $sql_tipo_local = " AND idLocal = '$tipo_local'";		
	}
	
	if ($distribuidor == 0){
		$sql_dist = '';
	}
	else{
		$sql_dist = " AND idDistribuidor = '$distribuidor'";
		$sql_nom  = mysqli_query($link,"SELECT f_nombre_distribuidor($distribuidor)");;
		$fil_nom  = mysqli_fetch_array($sql_nom);
		echo "<h4>$fil_nom[0]</h4>";
	}
	$sql = "SELECT DISTINCT nombreCliente, nombreLugar, nombrezona, nombreCalle, numero, nombreCanal, nombreLocal, nombreDistribuidor FROM v_clientes v JOIN comercial c USING(idCliente) JOIN distribuidores d USING (idDistribuidor) WHERE v.idCliente NOT IN (SELECT idCliente FROM comercial WHERE fecha BETWEEN '$fecha1' AND '$fecha2')".$sql_dist.$sql_calles.$sql_tipo_local."ORDER BY nombreDistribuidor, nombreCalle";
//	echo $sql;
	$sql_sinmov = mysqli_query($link,$sql);
?>
<table width="965" border="0">
  <tr bordercolor="#CC9933" bgcolor="#CC9933">
    <td width="25" bordercolor="#CC9933"><div align="center" class="style5">Nro</div></td>
    <td width="224" bordercolor="#CC9933"><div align="center" class="style5">Nombre Cliente </div></td>
    <td width="65" bordercolor="#CC9933"><div align="center" class="style5">Lugar</div></td>
    <td width="139" bordercolor="#CC9933"><div align="center" class="style5">Zona</div></td>
    <td width="123" bordercolor="#CC9933"><div align="center" class="style5">Calle</div></td>
    <td width="25" bordercolor="#CC9933"><div align="center" class="style5">Nro</div></td>
    <td width="107" bordercolor="#CC9933"><div align="center" class="style5">Canal</div></td>
    <td width="93" bordercolor="#CC9933"><div align="center" class="style5">Local</div></td>
	<? if ($distribuidor == 0){?>
	<td width="126" bordercolor="#CC9933"><div align="center" class="style5">Distribuidor</div></td>
	<? }?>
  </tr>
<?
	$cont = 1;
	while ($fil_sinmov = mysqli_fetch_array($sql_sinmov)){
	   echo "<tr style='font-size:10px'>";
		echo "<td align='right'>$cont</td>";
		echo "<td>$fil_sinmov[nombreCliente]</td>";
		echo "<td>$fil_sinmov[nombreLugar]</td>";
		echo "<td>$fil_sinmov[nombrezona]</td>";
		echo "<td>$fil_sinmov[nombreCalle]</td>";
		echo "<td align='right'>$fil_sinmov[numero]</td>";
		echo "<td>$fil_sinmov[nombreCanal]</td>";
		echo "<td>$fil_sinmov[nombreLocal]</td>";
		if ($distribuidor == 0){
    		echo "<td>$fil_sinmov[nombreDistribuidor]</td>";
		}
	   echo "<tr>";
		
		$cont = $cont + 1;
	}
?>
</table>

</body>
</html>
