<?php
ob_start();
?> 
<?
	include('../conexion.php');	
	require('../menu.php');

	$link = conexion();

	$fi = $_GET['fi'];	
	$ff = $_GET['ff'];
	$dist = $_GET['dist'];

	//echo $fi.' '.$ff.' '.$dist;

	$crit_dist = " AND idDistribuidor  = $dist";
	
	$sum_tot = "SELECT SUM(IF(IdProducto=1,Cantidad,0)) 'BotEsp',	SUM(IF(IdProducto = 2,Cantidad,0)) 'BotSesq.',			SUM(IF(IdProducto = 3,Cantidad,0)) 'Botstou', SUM(IF(IdProducto = 17,Cantidad,0)) 'BotBic',	SUM(IF(IdProducto = 4,Cantidad,0)) 'LatEsp', SUM(IF(IdProducto = 5,Cantidad,0)) 'LatSesq.', SUM(IF(IdProducto = 6,Cantidad,0)) 'LatStou', SUM(IF(IdProducto = 20,Cantidad,0)) 'LatBic', SUM(IF(IdProducto = 7,Cantidad,0)) 'BlinEsp', SUM(IF(IdProducto = 8,Cantidad,0)) 'BlinSesq.', SUM(IF(IdProducto = 9,Cantidad,0)) 'Blinstou', SUM(IF(IdProducto = 10,Cantidad,0)) 'Blin33', SUM(IF(IdProducto = 18,Cantidad,0)) 'BlinBic', SUM(IF(IdProducto = 11,Cantidad,0)) 'ChopEsp', SUM(IF(IdProducto = 12,Cantidad,0)) 'ChopSesq', SUM(IF(IdProducto = 19,Cantidad,0)) 'ChopBic' FROM itemComercial i JOIN comercial c USING(idComercial) WHERE fecha BETWEEN '$fi' AND '$ff' AND bonificacion = 0";
	
	if ($dist <> 0){
		$sql_dist = mysqli_query($link,"SELECT f_nombre_distribuidor('$dist')");	
		$nom_dist = mysqli_fetch_array($sql_dist);
		
		$sum_tot = $sum_tot.' '.$crit_dist;
	}

	$res_tot = mysqli_query($link,$sum_tot);
	$tot = mysqli_fetch_array($res_tot);	
	$sql = mysqli_query($link,"call sp_resumenComercial('$fi','$ff','$dist')");
?>
<html>
<head>
<title>Resumen Comercial</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<h3>RESUMEN COMERCIALIZACI&Oacute;N  </h3>
<?
  echo "<h4>Entre el: $fi y el $ff</h4>";
  if($dist<>0){
  	echo "<h5>$nom_dist[0]</h5>";
  }
  
?>
<table width="788" border="0">
  <tr bgcolor="#CC9933">
    <td width="191" rowspan="2"><div align="center">
	   <span class="style1">
		  <? 
		  	if($dist==0){
				echo "Distribuidor";
			}
			else{ 
				echo "Cliente";
			}
		  ?>
	   </span></div></td>
    <td colspan="4"><div align="center" class="style1">Botella</div></td>
    <td colspan="4"><div align="center" class="style1">Lata</div></td>
    <td colspan="5"><div align="center" class="style1">Botellin</div></td>
    <td colspan="3"><div align="center" class="style1">Chop</div></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="42"><span class="style1">Esp</span></td>
    <td width="39"><span class="style1">Ses</span></td>
    <td width="28"><span class="style1">Sto</span></td>
    <td width="28"><span class="style1">Bic</span></td>
    <td width="30"><span class="style1">Esp</span></td>
    <td width="33"><span class="style1">Ses</span></td>
    <td width="29"><span class="style1">Sto</span></td>
    <td width="29"><span class="style1">Bic</span></td>
    <td width="35"><span class="style1">Esp</span></td>
    <td width="29"><span class="style1">Ses</span></td>
    <td width="28"><span class="style1">Sto</span></td>
    <td width="26"><span class="style1">33</span></td>
    <td width="26"><span class="style1">Bic</span></td>
    <td width="42"><span class="style1">Esp</span></td>
    <td width="40"><span class="style1">Ses</span></td>
    <td width="42"><span class="style1">Bic</span></td>
  </tr>
<?	
	while($sql_comer = mysqli_fetch_array($sql)){
		if($dist==0){
			echo "<tr style='font-size:11px'><td>$sql_comer[1]</td><td align='right'>$sql_comer[3]</td><td align='right'>$sql_comer[4]</td><td align='right'>$sql_comer[5]</td><td align='right'>$sql_comer[6]</td><td align='right'>$sql_comer[7]</td><td align='right'>$sql_comer[8]</td><td align='right'>$sql_comer[9]</td><td align='right'>$sql_comer[10]</td><td align='right'>$sql_comer[11]</td><td align='right'>$sql_comer[12]</td><td align='right'>$sql_comer[13]</td><td align='right'>$sql_comer[14]</td><td align='right'>$sql_comer[15]</td><td align='right'>$sql_comer[16]</td><td align='right'>$sql_comer[17]</td><td align='right'>$sql_comer[18]</td></tr>";
		}
		else{
			echo "<tr style='font-size:11px'><td>$sql_comer[2]</td><td align='right'>$sql_comer[3]</td><td align='right'>$sql_comer[4]</td><td align='right'>$sql_comer[5]</td><td align='right'>$sql_comer[6]</td><td align='right'>$sql_comer[7]</td><td align='right'>$sql_comer[8]</td><td align='right'>$sql_comer[9]</td><td align='right'>$sql_comer[10]</td><td align='right'>$sql_comer[11]</td><td align='right'>$sql_comer[12]</td><td align='right'>$sql_comer[13]</td><td align='right'>$sql_comer[14]</td><td align='right'>$sql_comer[15]</td><td align='right'>$sql_comer[16]</td><td align='right'>$sql_comer[17]</td><td align='right'>$sql_comer[18]</td></tr>";
		}
	}
	echo "<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr style='font-size:14px' align='right' bgcolor='#CC9933'><td align='center'>TOTALES</td><td>$tot[0]</td><td>$tot[1]</td><td>$tot[2]</td><td>$tot[3]</td><td>$tot[4]</td><td>$tot[5]</td><td>$tot[6]</td><td>$tot[7]</td><td>$tot[8]</td><td>$tot[9]</td><td>$tot[10]</td><td>$tot[11]</td><td>$tot[12]</td><td>$tot[13]</td><td>$tot[14]</td><td>$tot[15]</td></tr>";
?> 
</table>

</body>
</html>
<?
ob_end_flush();
?>