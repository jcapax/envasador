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

	if($_POST){	
		$tipo_nota = $_POST['tipo_nota'];
		$canno = $_POST['canno'];
		$cmes = $_POST['cmes'];
		$cdia = $_POST['cdia'];
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Stock</title>
<style type="text/css">
<!--
#Layer1 {position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
.Estilo1 {color: #FFFFFF}
.style2 {color: #FFFFFF; font-weight: bold; }
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
  </table>
</div>
<h1>STOCK</h1>
<form action="rep_stock.php" method="post" name="form1" id="form1">
  <table width="337" border="0">
    <tr>
      <td>Tipo Nota:</td>
	        <?
			if (($acceso == 1)or($acceso == 5)){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");				
				}

			if ($acceso==2){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 1 AND 2");				
				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 1 AND 4");				
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 3 AND 4");				
				}
		
		?>
      <td><select name="tipo_nota" id="tipo_nota">
        <option value='0'>Seleccionar</option>
        <?
			if ($acceso==6){
				$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");				
			}
		
			while($fil_notas = mysqli_fetch_array($sql_notas)){
				?>
        <option value='<? echo $fil_notas[0]?>'><? echo $fil_notas[1]?></option>
        <?
			}
		?>
      </select></td>
    </tr>
	<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	?>

    <tr>
      <td>Hasta Fecha:</td>
      <td><select name="canno" id="canno">
        <option value="0" selected="selected">Selec.</option>
        <option value="2007"<? if($fil_fecha[0]==2007){?>selected<? }?>>2007</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		<option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		<option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
		<option value="2012"<? if($fil_fecha[0]==2012){?>selected<? }?>>2012</option>
		<option value="2013"<? if($fil_fecha[0]==2013){?>selected<? }?>>2013</option>
		<option value="2014"<? if($fil_fecha[0]==2014){?>selected<? }?>>2014</option>
		<option value="2015"<? if($fil_fecha[0]==2015){?>selected<? }?>>2015</option>
      </select>
        <select name="cmes" id="cmes">
          <option value="0" selected="selected">Selec.</option>
          <option value="1"<? if($fil_fecha[1]==1) {?>selected<? }?>>Enero</option>
          <option value="2"<? if($fil_fecha[1]==2) {?>selected<? }?>>Febr.</option>
          <option value="3"<? if($fil_fecha[1]==3) {?>selected<? }?>>Marzo</option>
          <option value="4"<? if($fil_fecha[1]==4) {?>selected<? }?>>Abril</option>
          <option value="5"<? if($fil_fecha[1]==5) {?>selected<? }?>>Mayo</option>
          <option value="6"<? if($fil_fecha[1]==6) {?>selected<? }?>>Junio</option>
          <option value="7"<? if($fil_fecha[1]==7) {?>selected<? }?>>Julio</option>
          <option value="8"<? if($fil_fecha[1]==8) {?>selected<? }?>>Agosto</option>
          <option value="9"<? if($fil_fecha[1]==9) {?>selected<? }?>>Sept.</option>
          <option value="10"<? if($fil_fecha[1]==10){?>selected<? }?>>Octub.</option>
          <option value="11"<? if($fil_fecha[1]==11){?>selected<? }?>>Novie.</option>
          <option value="12"<? if($fil_fecha[1]==12){?>selected<? }?>>Dicie.</option>
        </select>
        <select name="cdia" id="cdia">
          <option value="0" selected="selected">Selec.</option>
          <?
		  	$d = 1;
			while ($d <= 31){
				if ($fil_fecha[2] == $d){ echo "<option value='$d' selected='selected'>$d</option>";}
				else { echo "<option value='$d'>$d</option>";}
				$d = $d + 1;
			}
		  ?>
        </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>
  <?  	
    if($tipo_nota == 0){
		die;
	}
	$nota = mysqli_fetch_row(mysqli_query($link,"Select f_nombre_nota($tipo_nota)"));
	$fecha = $canno.'-'.$cmes.'-'.$cdia;
	
//	$sql_diferencias = mysqli_query($link,"SELECT fecha, detalle, botellas, cajas FROM diferenciasenvases WHERE estado = 1 AND fecha = $fechaORDER BY fecha DESC LIMIT 4;");
	$sql_diferencias = mysqli_query($link,"SELECT fecha, detalle, botellas, cajas FROM diferenciasenvases WHERE estado = 1 AND fecha <= '$fecha' ORDER BY iddiferenciasEnvases DESC LIMIT 4;");
	
	$sql_stock = mysqli_query($link,"call sp_stock('$fecha')");
	
	while($fil_stock = mysqli_fetch_array($sql_stock)){
		
		if ($fil_stock[0] == 1){
			$i = 0;
			while($i <= 18){
				$recepcion[] = $fil_stock[$i];
				$i++;
			}
		}
		
		if ($fil_stock[0] == 2){
			$i = 0;
			while($i <= 18){
				$prod_proceso[] = $fil_stock[$i];
				$i++;
			}
		}

		if ($fil_stock[0] == 3){
			$i = 0;
			while($i <= 20){
				$envase[] = $fil_stock[$i];
				$i++;
			}
		}
			
		if ($fil_stock[0] == 4){
			$i = 0;
			while($i <= 18){
				$despacho[] = $fil_stock[$i];
				$i++;
			}
		}

		if ($fil_stock[0] == 6){
			$i = 0;
			while($i <= 18){
				$devolucion[] = $fil_stock[$i];
				$i++;
			}
		}
	}	
	
	if($tipo_nota == 1){
		$i = 0;
		while($i <= 18){
			$stock[] =  $recepcion[$i] - $prod_proceso[$i];
			$i++;
		}
	}
	
	if($tipo_nota == 2){
		$i = 12;
		while($i <= 18){
			$stock[] = $prod_proceso[$i] - $envase[$i];
			$i++;
		}
	}

	if($tipo_nota == 4){
		$i = 0;
		while($i <= 18){
			$stock[] = $envase[$i] - $despacho[$i] + $devolucion[$i];
			$i++;
		}
	}

?>
</p>
<h2>&nbsp;</h2>
<table width="851" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td colspan="2" rowspan="2"><span class="Estilo1 Estilo1"><strong>Hasta Fecha </strong></span></td>
    <td width="136" rowspan="2"><span class="Estilo1 Estilo1"><strong>Nota</strong></span></td>
    <td colspan="4"><span class="Estilo1 Estilo1"><strong>Botella</strong></span></td>
    <td colspan="4"><span class="Estilo1 Estilo1"><strong>Lata</strong></span></td>
    <td colspan="5"><span class="style2">Botellin</span></td>
    <td colspan="3"><span class="Estilo1 Estilo1"><strong>Chopp</strong></span></td>
    <td colspan="2"><span class="Estilo1 Estilo1"><strong>Envases</strong></span></td>
  </tr>
  <tr>
    <td width="23" bgcolor="#F3EA72"><strong>Esp</strong></td>
    <td width="30" bgcolor="#F3EA72"><strong>Sesq</strong></td>
    <td width="28" bgcolor="#F3EA72"><strong>Stou</strong></td>
    <td width="28" bgcolor="#F3EA72"><strong>Bic</strong></td>
    <td width="23" bgcolor="#F3EA72"><strong>Esp</strong></td>
    <td width="30" bgcolor="#F3EA72"><strong>Sesq</strong></td>
    <td width="28" bgcolor="#F3EA72"><strong>Stou</strong></td>
    <td width="28" bgcolor="#F3EA72"><strong>Bic</strong></td>
    <td width="23" bgcolor="#F3EA72"><strong>Esp</strong></td>
    <td width="30" bgcolor="#F3EA72"><strong>Sesq</strong></td>
    <td width="28" bgcolor="#F3EA72"><strong>Stou</strong></td>
    <td width="17" bgcolor="#F3EA72"><strong>33</strong></td>
    <td width="17" bgcolor="#F3EA72"><strong>Bic</strong></td>
    <td width="23" bgcolor="#F3EA72"><strong>Esp</strong></td>
    <td width="30" bgcolor="#F3EA72"><strong>Sesq</strong></td>
    <td width="30" bgcolor="#F3EA72"><strong>Bic</strong></td>
    <td width="26" bgcolor="#F3EA72"><strong>Bot.</strong></td>
    <td width="46" bgcolor="#F3EA72"><strong>Canast.</strong></td>
  </tr>
  <?
  if ($tipo_nota <= 2 ){
  	echo "<tr align='right' style='font-size:11px'>";
		echo "<td align='center' colspan='2'>$fecha</td>";
		echo "<td align='left'>$nota[0]</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td bgcolor='#BFCAEE'>$stock[17]</td>";
		echo "<td bgcolor='#BFCAEE'>$stock[18]</td>";
	echo "</tr>";
  }
  else{
	$bo_esp = $stock[1];		$bo_esp_ = round($stock[1]/12,0);
	$bo_ses = $stock[2];		$bo_ses_ = round($stock[2]/12,0);
	$bo_sto = $stock[3];		$bo_sto_ = round($stock[3]/12,0);
	$bo_bic = $stock[4];		$bo_bic_ = round($stock[4]/12,0);
	
	$la_esp = $stock[5];		$la_esp_ = round($stock[5]/24,0);
	$la_ses = $stock[6];		$la_ses_ = round($stock[6]/24,0);
	$la_sto = $stock[7];		$la_sto_ = round($stock[7]/24,0);
	$la_bic = $stock[8];		$la_bic_ = round($stock[8]/24,0);
	
	$bn_esp = $stock[9];		$bn_esp_ = round($stock[9]/24,0);
	$bn_ses = $stock[10];		$bn_ses_ = round($stock[10]/24,0);
	$bn_sto = $stock[11];		$bn_sto_ = round($stock[11]/24,0);
	$bn_33  = $stock[12];		$bn_33_  = round($stock[12]/24,0);
	$bn_bic = $stock[13];		$bn_bic_ = round($stock[13]/24,0);
	
	$ch_esp = $stock[14];
	$ch_ses = $stock[15];
	$ch_bic = $stock[16];
	
	$botella= $stock[17];
	//$botella = $stock[1]+$stock[2]+$stock[3]+$stock[4];
	$caja   = $stock[18];	
	
	echo "<tr align='right' style='font-size:11px'>";
		echo "<td align='center' colspan='2' align='center'><strong>$fecha</strong></td>";
		echo "<td align='left'><strong>$nota[0]</strong></td>";
		echo "<td>$bo_esp</td>";
		echo "<td>$bo_ses</td>";
		echo "<td>$bo_sto</td>";
		echo "<td>$bo_bic</td>";
		
		echo "<td>$la_esp</td>";
		echo "<td>$la_ses</td>";
		echo "<td>$la_sto</td>";
		echo "<td>$la_bic</td>";
		
		echo "<td>$bn_esp</td>";
		echo "<td>$bn_ses</td>";
		echo "<td>$bn_sto</td>";
		echo "<td>$bn_33 </td>";
		echo "<td>$bn_bic</td>";
		
		echo "<td>$ch_esp</td>";
		echo "<td>$ch_ses</td>";
		echo "<td>$ch_bic</td>";
		
		echo "<td>$botella</td>";
		echo "<td>$caja</td>";
	echo "</tr>";	
	
	echo "<tr><td></td></tr>";
	echo "<tr><td></td></tr>";
	
	echo "<tr align='right' style='font-size:11px'>";
		echo "<td align='CENTER' colspan='3'><strong>CAJAS COMPLETAS</strong></td>";
//		echo "<td align='left'></td>";
		echo "<td>$bo_esp_</td>";
		echo "<td>$bo_ses_</td>";
		echo "<td>$bo_sto_</td>";
		echo "<td>$bo_bic_</td>";
		
		echo "<td>$la_esp_</td>";
		echo "<td>$la_ses_</td>";
		echo "<td>$la_sto_</td>";
		echo "<td>$la_bic_</td>";
		
		echo "<td>$bn_esp_</td>";
		echo "<td>$bn_ses_</td>";
		echo "<td>$bn_sto_</td>";
		echo "<td>$bn_33_ </td>";
		echo "<td>$bn_bic_</td>";
		
		echo "<td>$ch_esp</td>";
		echo "<td>$ch_ses</td>";
		echo "<td>$ch_bic</td>";
		
		echo "<td>$botella</td>";
		echo "<td>$caja</td>";
	echo "</tr>";	
	
  }
  ?>
  <td width="136"></tr>
</table>
<p>
</p>
<?
//	if($acceso==2){
	if($tipo_nota==1){
?>
<table width="482" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="249" bgcolor="#CC9933"><span class="Estilo1 Estilo1">Detalle</span></td>
    <td width="86"><span class="Estilo1 Estilo1">Fecha</span></td>
    <td width="69"><span class="Estilo1 Estilo1">Botellas</span></td>
    <td width="60"><span class="Estilo1 Estilo1">Cajas</span></td>	
  </tr>
  <tr style='font-size:12px'>
  	<td width="249" bgcolor="#BFCAEE">TOTAL RECUENTO</td>
    <td width="86" bgcolor="#BFCAEE"><? echo $fecha;?></td>
    <td width="69" align="right" bgcolor="#BFCAEE"><? echo $stock[17];?></td>
    <td width="60" align="right" bgcolor="#BFCAEE"><? echo $stock[18];?></td>	  	
  </tr>
<?
	$dif_bot = 0;
	$dif_caj = 0;
	while($sql_res_diferencias = mysqli_fetch_array($sql_diferencias)){
	  	echo "<tr style='font-size:12px'>";
			echo "<td width='249'>$sql_res_diferencias[1]</td>";
			echo "<td width='86'>$sql_res_diferencias[0]</td>";
			echo "<td width='69' align='right'>$sql_res_diferencias[2]</td>";
    	    echo "<td width='60' align='right'>$sql_res_diferencias[3]</td>";		
			$dif_bot = $dif_bot - $sql_res_diferencias[2];
			$dif_caj = $dif_caj - $sql_res_diferencias[3];
		echo "</tr>";	
  	}

?>  
  <tr style='font-size:12px'>
    <td colspan="2" bgcolor="#CC9933"><strong>DISPONIBLE PARA EMBOTELLADO</strong></td>
    <td align="right" bgcolor="#CC9933"><strong><? echo $stock[17] + $dif_bot;?></strong></td>
    <td align="right" bgcolor="#CC9933"><strong><? echo $stock[18] + $dif_caj;?></strong></td>
  </tr>
</table>
<?
	}
?>
<p>&nbsp; </p>

</body>
</html>
