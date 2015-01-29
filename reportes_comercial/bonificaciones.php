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
	
	$distribuidor = $_POST['distribuidor'];

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
.style1 {color: #FFFFFF}
#Layer1 {position:absolute;
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
<h1>BONIFICACIONES </h1>
<?
	if($distribuidor == '0'){
?>
<table width="781" border="0">
  <tr bgcolor="#CC9933"> 
	<td width='216' rowspan='2'><span class='style1'>Distribuidor</span></td>
	<td colspan="4" align="center"><span class="style1">Botella</span></td>
    <td colspan="4" align="center"><span class="style1">Lata</span></td>
    <td colspan="5" align="center"><span class="style1">Botellin</span></td>
    <td colspan="3" align="center"><span class="style1">Chop</span></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">33</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
  </tr>
  <?
  	echo '<h3>'.'Entre '.$fecha1.' y el '.$fecha2.'</h3>';
	$gr_sel_bonifi = mysqli_query($link,"SELECT idDistribuidor, distribuidor,  SUM(botEsp),SUM(botSesq),SUM(botStou),SUM(botBic),  SUM(latEsp),SUM(latSesq),SUM(latStou),SUM(latBic),SUM(blinEsp),SUM(blinSesq),SUM(blinStou),SUM(blin33),SUM(blinBic),  SUM(chopEsp),SUM(chopSes),SUM(chopBic) FROM v_bonificacionproductos v WHERE fecha BETWEEN '$fecha1' AND '$fecha2' GROUP BY idDistribuidor, distribuidor;");
	
	$gr_sel_bonifi_total = mysqli_query($link,"SELECT SUM(botEsp),SUM(botSesq),SUM(botStou),SUM(botBic),  SUM(latEsp),SUM(latSesq),SUM(latStou),SUM(latBic),SUM(blinEsp),SUM(blinSesq),SUM(blinStou),SUM(blin33),SUM(blinBic),  SUM(chopEsp),SUM(chopSes),SUM(chopBic) FROM v_bonificacionproductos v WHERE fecha BETWEEN '$fecha1' AND '$fecha2'");
	
	$tot = mysqli_fetch_array($gr_sel_bonifi_total);	
	
	while($gr_boni = mysqli_fetch_array($gr_sel_bonifi)){
		echo "<tr style='font-size:11px'>";
			echo "<td align='left'>$gr_boni[1]</td>";
			echo "<td align='right'>$gr_boni[2]</td>";
			echo "<td align='right'>$gr_boni[3]</td>";
			echo "<td align='right'>$gr_boni[4]</td>";
			echo "<td align='right'>$gr_boni[5]</td>";
			echo "<td align='right'>$gr_boni[6]</td>";
			echo "<td align='right'>$gr_boni[7]</td>";
			echo "<td align='right'>$gr_boni[8]</td>";
			echo "<td align='right'>$gr_boni[9]</td>";
			echo "<td align='right'>$gr_boni[10]</td>";
			echo "<td align='right'>$gr_boni[11]</td>";
			echo "<td align='right'>$gr_boni[12]</td>";
			echo "<td align='right'>$gr_boni[13]</td>";
			echo "<td align='right'>$gr_boni[14]</td>";
			echo "<td align='right'>$gr_boni[15]</td>";
			echo "<td align='right'>$gr_boni[16]</td>";
			echo "<td align='right'>$gr_boni[17]</td>";
			echo "<td align='right'>$gr_boni[18]</td>";
		echo "</tr>";
	}	
	echo "<tr></tr>";
		echo "<td colspan='7'></td>";
		echo "<td colspan='17'></td>";
		echo "<tr>";
			echo "<td colspan='17'></td>";
		echo "</tr>";
		echo "<tr style='font-size:11px' bgcolor='#CC9933'>";
			echo "<td align='center'>TOTALES</td>";
			echo "<td align='right'>$tot[0]</td>";
			echo "<td align='right'>$tot[1]</td>";
			echo "<td align='right'>$tot[2]</td>";
			echo "<td align='right'>$tot[3]</td>";
			echo "<td align='right'>$tot[4]</td>";
			echo "<td align='right'>$tot[5]</td>";
			echo "<td align='right'>$tot[6]</td>";
			echo "<td align='right'>$tot[7]</td>";
			echo "<td align='right'>$tot[8]</td>";
			echo "<td align='right'>$tot[9]</td>";
			echo "<td align='right'>$tot[10]</td>";
			echo "<td align='right'>$tot[11]</td>";
			echo "<td align='right'>$tot[12]</td>";
			echo "<td align='right'>$tot[13]</td>";
			echo "<td align='right'>$tot[14]</td>";
			echo "<td align='right'>$tot[15]</td>";
		echo "</tr>";
  ?>  
</table>
<?
	}
	else{
?>
<table width="854" border="0">
  <tr bgcolor="#CC9933">
    <td width='220' rowspan='2'><span class='style1'>Cliente</span></td>
    <td width='65' rowspan='2' align="center"><span class="style1">Fecha</span></td>
    <td colspan="4" align="center"><span class="style1">Botella</span></td>
    <td colspan="4" align="center"><span class="style1">Lata</span></td>
    <td colspan="5" align="center"><span class="style1">Botellin</span></td>
    <td colspan="3" align="center"><span class="style1">Chop</span></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="32"><span class="style1">Stou.</span></td>
    <td width="31"><span class="style1">33</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
    <td width="27"><span class="style1">Esp.</span></td>
    <td width="34"><span class="style1">Sesq.</span></td>
    <td width="31"><span class="style1">Bice.</span></td>
  </tr>
  <?
  	echo '<h3>'.'Entre '.$fecha1.' y el '.$fecha2.'</h3>'.'<p></p>';
	$dis = mysqli_query($link,"Select f_nombre_distribuidor('$distribuidor')");
	$nom_dis = mysqli_fetch_array($dis);
	echo '<h3>'.'Distribuidor: '.$nom_dis[0].'</h3>';	
	$gr_sel_bonifi = mysqli_query($link,"SELECT * FROM v_bonificacionproductos v WHERE fecha BETWEEN '$fecha1' AND '$fecha2'  AND idDistribuidor = '$distribuidor'");
	
	$gr_sel_bonifi_total = mysqli_query($link,"SELECT SUM(botEsp),SUM(botSesq),SUM(botStou),SUM(botBic),  SUM(latEsp),SUM(latSesq),SUM(latStou),SUM(latBic),SUM(blinEsp),SUM(blinSesq),SUM(blinStou),SUM(blin33),SUM(blinBic),  SUM(chopEsp),SUM(chopSes),SUM(chopBic) FROM v_bonificacionproductos v WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND idDistribuidor = '$distribuidor' ");
	
	$tot = mysqli_fetch_array($gr_sel_bonifi_total);	
	
	while($gr_boni = mysqli_fetch_array($gr_sel_bonifi)){
			echo "<tr style='font-size:11px'>";
				echo "<td align='left'>$gr_boni[3]</td>";
				echo "<td align='right'>$gr_boni[4]</td>";
				echo "<td align='right'>$gr_boni[5]</td>";
				echo "<td align='right'>$gr_boni[6]</td>";
				echo "<td align='right'>$gr_boni[7]</td>";
				echo "<td align='right'>$gr_boni[8]</td>";
				echo "<td align='right'>$gr_boni[9]</td>";
				echo "<td align='right'>$gr_boni[10]</td>";
				echo "<td align='right'>$gr_boni[11]</td>";
				echo "<td align='right'>$gr_boni[12]</td>";
				echo "<td align='right'>$gr_boni[13]</td>";
				echo "<td align='right'>$gr_boni[14]</td>";
				echo "<td align='right'>$gr_boni[15]</td>";
				echo "<td align='right'>$gr_boni[16]</td>";
				echo "<td align='right'>$gr_boni[17]</td>";
				echo "<td align='right'>$gr_boni[18]</td>";
				echo "<td align='right'>$gr_boni[19]</td>";
				echo "<td align='right'>$gr_boni[20]</td>";
			echo "</tr>";
	}	
	echo "<tr bordercolor='#000000'>";
		echo "<td colspan='7'></td>";
		echo "<td colspan='17'></td>";
		echo "<tr>";
			echo "<td colspan='17'></td>";
		echo "</tr>";
	echo "</tr>";
	echo "<tr style='font-size:11px' bgcolor='#CC9933'>";
		echo "<td align='center'>TOTALES</td>";
		echo "<td></td>";
		echo "<td align='right'>$tot[0]</td>";
		echo "<td align='right'>$tot[1]</td>";
		echo "<td align='right'>$tot[2]</td>";
		echo "<td align='right'>$tot[3]</td>";
		echo "<td align='right'>$tot[4]</td>";
		echo "<td align='right'>$tot[5]</td>";
		echo "<td align='right'>$tot[6]</td>";
		echo "<td align='right'>$tot[7]</td>";
		echo "<td align='right'>$tot[8]</td>";
		echo "<td align='right'>$tot[9]</td>";
		echo "<td align='right'>$tot[10]</td>";
		echo "<td align='right'>$tot[11]</td>";
		echo "<td align='right'>$tot[12]</td>";
		echo "<td align='right'>$tot[13]</td>";
		echo "<td align='right'>$tot[14]</td>";
		echo "<td align='right'>$tot[15]</td>";
	echo "</tr>";
  ?>
</table>
<?
	}
?>
</body>
</html>
