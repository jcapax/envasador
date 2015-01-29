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
		
		$fecha1       = $_POST["fecha1"];
		$fecha2       = $_POST["fecha2"];
		
		
		$cantidad = $_POST['cantidad'];
		
		$tipo_reporte = $_POST['tipo_reporte'];
		$sub_reporte  = $_POST['sub_reporte'];
		$distribuidor = $_POST['distribuidor'];
	} 

	if(($sub_reporte == 1)and($tipo_reporte == 1)){
		header("Location: ../auxiliares/buscador_clientes.php?procedencia=1&f1=$fecha1&f2=$fecha2");
	}	

?>
<html>
<head>
<title>RANKING - SIDS S.A.</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>
<?
	//echo $fecha1.'*'.$fecha2.'*'.$tipo_reporte.'*'.$sub_reporte;
	switch($tipo_reporte){
		case 1:	
			echo "<h2 align='center'>RANKING DE CLIENTES</h2>";				
			break;
		case 2:	
			echo "<h2 align='center'>RANKING POR CALLES</h2>";
			break;
		case 3:	
			echo "<h2 align='center'>RANKING POR ZONAS</h2>";
			$sql_zona = mysqli_query($link,"SELECT nombreZona FROM zonas WHERE idZona = '$sub_reporte'");
			$zona = mysqli_fetch_array($sql_zona);
			echo "<h3 align='center'>ZONA $zona[0]</h3>";
			break;
		case 4:	
			echo "<h2 align='center'>RANKING POR CANAL</h2>";
			$sql_sr = mysqli_query($link,"SELECT nombreCanal FROM canales WHERE idCanal = '$sub_reporte'");
			$sr = mysqli_fetch_array($sql_sr);
			echo "<h3 align='center'>$sr[0]</h3>";
			break;
		case 5:	
			echo "<h2 align='center'>RANKING POR TIPO LOCAL</h2>";
			break;
		case 6:	
			echo "<h2 align='center'>RANKING POR RUTAS</h2>";
			break;
	}
//	echo "<h3>ENTRE $fecha1 y el $fecha2</h3>"."<br>";
?>
<table width="651" border="0">
  <tr>
    <td width="48"><strong>Entre</strong></td>
    <td width="59"><input name="textfield" type="text" value="<? echo $fecha1?>" size="8" maxlength="8" readonly=""></td>
    <td width="379"><strong>y
      <input name="textfield2" type="text" value="<? echo $fecha2?>" size="8" maxlength="8" readonly="">
    </strong></td>
    <td width="147">&nbsp;</td>
  </tr>
  <tr>
    <?
		if ($distribuidor <> 0){
	 		$dis = mysqli_query($link,"Select f_nombre_distribuidor('$distribuidor')");
    		$nom_dis = mysqli_fetch_array($dis);
	
	    	echo "<td colspan='3'><h4>"."DISTRIBUIDOR: ".$nom_dis[0]."</h4></td>";
		}
		else{
			echo "<td colspan='3'><h4>"."GLOBAL - DISTRIBUIDORES"."</h4></td>";
		}
	?>
  </tr>
</table>
<? if($tipo_reporte==1){?>
<table width="1294" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="23" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
    <td width="180" rowspan="2"><span class="Estilo1 Estilo1">Cliente</span></td>
    <td width="56" rowspan="2">
		<span class="Estilo1 Estilo1">Lugar-Dist. 
		</span>
	</td>
    <td width="114" rowspan="2"><span class="Estilo1">Zona</span></td>
    <td width="169" rowspan="2"><span class="Estilo1 Estilo1">Calle</span></td>
    <td width="146" rowspan="2"><span class="Estilo1 Estilo1">Tipo Local</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Botella</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Lata</span></td>
    <td colspan="5"><span class="Estilo1">Botellin</span></td>
    <td colspan="3"><span class="Estilo1 Estilo1">Chopp</span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="16" bgcolor="#F3EA72"><div align="right">33</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="42" bgcolor="#F3EA72"><div align="right">Cajas</div></td>
    <td width="54" bgcolor="#F3EA72"><div align="right">Precio</div></td>
  </tr>
  <?   
  	if($_POST){		
		$sql_l = mysqli_query($link,"CALL sp_ranking_ventas('$fecha1','$fecha2',$tipo_reporte,$sub_reporte, $distribuidor)");
		
	  	$c = 0;
		$c6 = 0; $c7 = 0; $c8 = 0; $c9 = 0;
		$c10 = 0; $c11 = 0; $c12 = 0; $c13 = 0; $c14 = 0; $c15 = 0;
		$c16 = 0; $c17 = 0;$c18 = 0; $c19 = 0; $c20 = 0; $c21 = 0; $c22 = 0; $c23 = 0;
		
  		while(($lista = mysqli_fetch_array($sql_l))and($c < $cantidad)){
			$c = $c + 1;
			$c6 =  $c6 +  $lista[6];   $c7 =  $c7 +  $lista[7];
			$c8 = $c8 +   $lista[8];	$c9 = $c9 +   $lista[9];   $c10 = $c10 + $lista[10];	$c11 = $c11 + $lista[11];
			$c12 = $c12 + $lista[12];	$c13 = $c13 + $lista[13];  $c14 = $c14 + $lista[14];	$c15 = $c15 + $lista[15];
			$c16 = $c16 + $lista[16];	$c17 = $c17 + $lista[17];  $c18 = $c18 + $lista[18];	$c19 = $c19 + $lista[19];
			$c20 = $c20 + $lista[20];	$c21 = $c21 + $lista[21];  $c22 = $c22 + $lista[22];	$c23 = $c23 + $lista[23];		
			
	  		echo "<tr style='font-size:12px'>";
				echo "<td align='center'>$c</td>";
				echo "<td>$lista[0]</td>";
				echo "<td>$lista[1]</td>";
				echo "<td>$lista[2]</td>";
				echo "<td>$lista[3] Nº $lista[4]</td>";
				echo "<td align='left'>$lista[5]</td>";
				echo "<td align='right'>$lista[6]</td>";
				echo "<td align='right'>$lista[7]</td>";
				echo "<td align='right'>$lista[8]</td>";
				echo "<td align='right'>$lista[9]</td>";
				echo "<td align='right'>$lista[10]</td>";
				echo "<td align='right'>$lista[11]</td>";
				echo "<td align='right'>$lista[12]</td>";
				echo "<td align='right'>$lista[13]</td>";
				echo "<td align='right'>$lista[14]</td>";
				echo "<td align='right'>$lista[15]</td>";
				echo "<td align='right'>$lista[16]</td>";
				echo "<td align='right'>$lista[17]</td>";
				echo "<td align='right'>$lista[18]</td>";
				echo "<td align='right'>$lista[19]</td>";
				echo "<td align='right'>$lista[20]</td>";
				echo "<td align='right'>$lista[21]</td>";
				echo "<td align='right'>$lista[22]</td>";
				echo "<td align='right'>$lista[23]</td>";
			echo "</tr>";
		}
	}
  $c23 = number_format($c23, 2, '.', ',');
	echo "<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>";
  	echo "<tr bgcolor='#F3EA72' align='right' style='font-size:12px'>";
		echo "<td colspan='6' align = 'center'><strong>Totales</strong></td>";
		echo "<td align='right'>$c6</td>";
		echo "<td align='right'>$c7</td>";
		echo "<td align='right'>$c8</td>";
		echo "<td align='right'>$c9</td>";
		echo "<td align='right'>$c10</td>";
		echo "<td align='right'>$c11</td>";
		echo "<td align='right'>$c12</td>";
		echo "<td align='right'>$c13</td>";
		echo "<td align='right'>$c14</td>";
		echo "<td align='right'>$c15</td>";
		echo "<td align='right'>$c16</td>";
		echo "<td align='right'>$c17</td>";
		echo "<td align='right'>$c18</td>";
		echo "<td align='right'>$c19</td>";
		echo "<td align='right'>$c20</td>";
		echo "<td align='right'>$c21</td>";
		echo "<td align='right'>$c22</td>";
		echo "<td align='right'>$c23</td>";
	echo "</tr>";
  }
  else{?>
</table>
<table width="1058" border="0">
    <tr align="center" bgcolor="#CC9933">
      <td width="34" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
	  <td width="80" rowspan="2"><span class="Estilo1 Estilo1">Lugar<br>
	  </span></td>
	  <?
		switch($tipo_reporte){
			case 2:	
				echo "<td width='98' rowspan='2'><span class='Estilo1 Estilo1'>Calle</span></td>";
				echo "<td width='252' rowspan='2'><span class='Estilo1 Estilo1'>Cliente</span></td>";
				break;
			case 3:	
				if($sub_reporte==0){
					echo "<td width='128' rowspan='2'><span class='Estilo1 Estilo1'>Zona</span></td>";
					echo "<td width='102' rowspan='2'><span class='Estilo1 Estilo1'>Canal</span></td>";
				}
				else{
					echo "<td width='150' rowspan='2'><span class='Estilo1 Estilo1'>Cliente</span></td>";
					echo "<td width='180' rowspan='2'><span class='Estilo1 Estilo1'>Dirección</span></td>";
				}
				break;
			case 4:	
				if($sub_reporte==0){
					echo "<td width='248' rowspan='2'><span class='Estilo1 Estilo1'>Canal</span></td>";
				}
				else{
					echo "<td width='248' rowspan='2'><span class='Estilo1 Estilo1'>Cliente</span></td>";	
				}
				echo "<td width='1' rowspan='2'><span class='Estilo1 Estilo1'></span></td>";
				break;
			case 5:	
				echo "<td width='128' rowspan='2'><span class='Estilo1 Estilo1'>Tipo Local</span></td>";
				if($sub_reporte == 0){
					echo "<td width='1' rowspan='2'><span class='Estilo1 Estilo1'></span></td>";
				}
				else{
					echo "<td width='350' rowspan='2'><span class='Estilo1 Estilo1'>Cliente</span></td>";
				}				
				break;
			case 6:	
				if($sub_reporte==0){
					echo "<td width='128' rowspan='2'><span class='Estilo1 Estilo1'>Ruta</span></td>";
					echo "<td width='102' rowspan='2'><span class='Estilo1 Estilo1'>Canal</span></td>";
				}
				else{
					echo "<td width='30' rowspan='2'><span class='Estilo1 Estilo1'>Ruta</span></td>";
					echo "<td width='300' rowspan='2'><span class='Estilo1 Estilo1'>Cliente - Dirección</span></td>";
				}
				break;
		}
	  ?>
      <td colspan="4"><span class="Estilo1 Estilo1">Botella</span></td>
      <td colspan="4"><span class="Estilo1 Estilo1">Lata</span></td>
      <td colspan="5"><span class="Estilo1">Botellin</span></td>
      <td colspan="3"><span class="Estilo1 Estilo1">Chopp</span></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="26" bgcolor="#F3EA72"><div align="right">Esp</div></td>
      <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
      <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
      <td width="38" bgcolor="#F3EA72"><div align="right">Bicent</div></td>
      <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
      <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
      <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
      <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
      <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
      <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
      <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
      <td width="16" bgcolor="#F3EA72"><div align="right">33</div></td>
      <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
      <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
      <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
      <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
      <td width="47" bgcolor="#F3EA72"><div align="right">Canast</div></td>
      <td width="63" bgcolor="#F3EA72"><div align="right">Precio</div></td>
    </tr>
    <? 
  	if($_POST){
		$sql_l = mysqli_query($link,"CALL sp_ranking_ventas('$fecha1','$fecha2',$tipo_reporte,$sub_reporte, $distribuidor)");
	  	$c = 0;
		$c3 = 0; 
		$c4 = 0; $c5 = 0; $c6 = 0; $c7 = 0; $c8 = 0; $c9 = 0;
		$c10 = 0; $c11 = 0; $c12 = 0; $c13 = 0; $c14 = 0; $c15 = 0;
		$c16 = 0; $c17 = 0;$c18 = 0; $c19 = 0; $c20 = 0.0;
		
  		while(($lista = mysqli_fetch_array($sql_l))and($c < $cantidad)){
			$c = $c + 1;
			$c3 = $c3 +   $lista[3];    $c4 =  $c4 +  $lista[4];	    
			$c5 = $c5 +   $lista[5];    $c6 =  $c6 +  $lista[6];   $c7 =  $c7 +  $lista[7];
			$c8 = $c8 +   $lista[8];	$c9 = $c9 +   $lista[9];   $c10 = $c10 + $lista[10];	$c11 = $c11 + $lista[11];
			$c12 = $c12 + $lista[12];	$c13 = $c13 + $lista[13];  $c14 = $c14 + $lista[14];	$c15 = $c15 + $lista[15];
			$c16 = $c16 + $lista[16];	$c17 = $c17 + $lista[17];  $c18 = $c18 + $lista[18];	$c19 = $c19 + $lista[19];
			$c20 = $c20 + $lista[20];	
			
	  		echo "<tr style='font-size:11px' align='right'>";
				echo "<td align='center'>$c</td>";
				echo "<td align='left'>$lista[0]</td>";
				echo "<td align='left'>$lista[1]</td>";
				echo "<td align='left'>$lista[2]</td>";
				echo "<td>$lista[3]</td>";
				echo "<td align='right'>$lista[4]</td>";
				echo "<td align='right'>$lista[5]</td>";
				echo "<td align='right'>$lista[6]</td>";
				echo "<td align='right'>$lista[7]</td>";
				echo "<td align='right'>$lista[8]</td>";
				echo "<td align='right'>$lista[9]</td>";
				echo "<td align='right'>$lista[10]</td>";
				echo "<td align='right'>$lista[11]</td>";
				echo "<td align='right'>$lista[12]</td>";
				echo "<td align='right'>$lista[13]</td>";
				echo "<td align='right'>$lista[14]</td>";
				echo "<td align='right'>$lista[15]</td>";
				echo "<td align='right'>$lista[16]</td>";
				echo "<td align='right'>$lista[17]</td>";
				echo "<td align='right'>$lista[18]</td>";
				echo "<td align='right'>$lista[19]</td>";
				$prec = number_format($lista[20], 2, '.', ',');
				echo "<td align='right'>$prec</td>";
			echo "</tr>";
		}
	}
	$c20 = number_format($c20, 2, '.', ',');
  echo "<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>";
  echo "<tr bgcolor='#F3EA72' align='right' style='font-size:11px'>";
  	echo "<td colspan='4' align='center'><strong>Totales</strong></td>";
	echo "<td align='right'>$c3</td>";
	echo "<td align='right'>$c4</td>";
	echo "<td align='right'>$c5</td>";
	echo "<td align='right'>$c6</td>";
	echo "<td align='right'>$c7</td>";
	echo "<td align='right'>$c8</td>";
	echo "<td align='right'>$c9</td>";
	echo "<td align='right'>$c10</td>";
	echo "<td align='right'>$c11</td>";
	echo "<td align='right'>$c12</td>";
	echo "<td align='right'>$c13</td>";
	echo "<td align='right'>$c14</td>";
	echo "<td align='right'>$c15</td>";
	echo "<td align='right'>$c16</td>";
	echo "<td align='right'>$c17</td>";
	echo "<td align='right'>$c18</td>";
	echo "<td align='right'>$c19</td>";
	echo "<td align='right'>$c20</td>";
  echo "</tr>";

  ?>
</table>
<? }?>
</body>
</html>
<?php
ob_end_flush();
?>