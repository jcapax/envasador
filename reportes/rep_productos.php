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
	echo "<br>";	
	require('menu_reportes.php');
	include('../conexion.php');
	$link = conexion();

	if ($_POST){
		$canno1 = $_POST["canno1"];
		$canno2 = $_POST["canno2"];
		$cmes1 = $_POST["cmes1"];
		$cmes2 = $_POST["cmes2"];
		$cdia1 = $_POST["cdia1"];
		$cdia2 = $_POST["cdia2"];
		$tipo_nota = $_POST["tipo_nota"];
	}

?>
<html>
<head>
<title>Resporte Envases</title>
<style type="text/css">
<!--
#Layer1 {position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
.style1 {color: #FFFFFF}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
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
  </table>
</div>
<h1>REPORTE PRODUCCI&Oacute;N ENVASADO </h1>
<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<form name="form1" method="post" action="rep_productos.php">
  <table width="337" border="0">
    <tr>
      <td>Fecha Inicio:</td>
      <td><select name="canno1" id="canno1">
        <option value="0" selected>Selec.</option>        
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		<option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
        <option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
		<option value="2012"<? if($fil_fecha[0]==2012){?>selected<? }?>>2012</option>
		<option value="2013"<? if($fil_fecha[0]==2013){?>selected<? }?>>2013</option>
		<option value="2014"<? if($fil_fecha[0]==2014){?>selected<? }?>>2014</option>
		<option value="2015"<? if($fil_fecha[0]==2015){?>selected<? }?>>2015</option>
      </select>
          <select name="cmes1" id="cmes1">
            <option value="0" selected>Selec.</option>
            <option value="1"<? if($fil_fecha[1]==1){?>selected<? }?>>Enero</option>
            <option value="2"<? if($fil_fecha[1]==2){?>selected<? }?>>Febr.</option>
            <option value="3"<? if($fil_fecha[1]==3){?>selected<? }?>>Marzo</option>
            <option value="4"<? if($fil_fecha[1]==4){?>selected<? }?>>Abril</option>
            <option value="5"<? if($fil_fecha[1]==5){?>selected<? }?>>Mayo</option>
            <option value="6"<? if($fil_fecha[1]==6){?>selected<? }?>>Junio</option>
            <option value="7"<? if($fil_fecha[1]==7){?>selected<? }?>>Julio</option>
            <option value="8"<? if($fil_fecha[1]==8){?>selected<? }?>>Agosto</option>
            <option value="9"<? if($fil_fecha[1]==9){?>selected<? }?>>Sept.</option>
            <option value="10"<? if($fil_fecha[1]==10){?>selected<? }?>>Octub.</option>
            <option value="11"<? if($fil_fecha[1]==11){?>selected<? }?>>Novie.</option>
            <option value="12"<? if($fil_fecha[1]==12){?>selected<? }?>>Dicie.</option>
          </select>
          <select name="cdia1" id="cdia1">
            <option value="0" selected>Selec.</option>
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
      <td>Fecha Final:</td>
      <td><select name="canno2" id="canno2">
        <option value="0" selected>Selec.</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		<option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
        <option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
		<option value="2012"<? if($fil_fecha[0]==2012){?>selected<? }?>>2012</option>
		<option value="2013"<? if($fil_fecha[0]==2013){?>selected<? }?>>2013</option>
		<option value="2014"<? if($fil_fecha[0]==2014){?>selected<? }?>>2014</option>	
		<option value="2015"<? if($fil_fecha[0]==2015){?>selected<? }?>>2015</option>	
      </select>
          <select name="cmes2" id="select2">
            <option value="0" selected>Selec.</option>
            <option value="1"<? if($fil_fecha[1]==1){?>selected<? }?>>Enero</option>
            <option value="2"<? if($fil_fecha[1]==2){?>selected<? }?>>Febr.</option>
            <option value="3"<? if($fil_fecha[1]==3){?>selected<? }?>>Marzo</option>
            <option value="4"<? if($fil_fecha[1]==4){?>selected<? }?>>Abril</option>
            <option value="5"<? if($fil_fecha[1]==5){?>selected<? }?>>Mayo</option>
            <option value="6"<? if($fil_fecha[1]==6){?>selected<? }?>>Junio</option>
            <option value="7"<? if($fil_fecha[1]==7){?>selected<? }?>>Julio</option>
            <option value="8"<? if($fil_fecha[1]==8){?>selected<? }?>>Agosto</option>
            <option value="9"<? if($fil_fecha[1]==9){?>selected<? }?>>Sept.</option>
            <option value="10"<? if($fil_fecha[1]==10){?>selected<? }?>>Octub.</option>
            <option value="11"<? if($fil_fecha[1]==11){?>selected<? }?>>Novie.</option>
            <option value="12"<? if($fil_fecha[1]==12){?>selected<? }?>>Dicie.</option>
          </select>
          <select name="cdia2" id="select3">
            <option value="0" selected>Selec.</option>
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
      <td>Tipo Nota: </td>
      <?
			if ($acceso==1){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");				
				}

			if ($acceso==2){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 0");				
				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 3");				
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 0");				
				}
		
			if ($acceso==6){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 3");				
				}
		?>
      <td><select name="tipo_nota" id="tipo_nota">
        <option value='0'>Seleccionar</option>
        <?
			while($fil_notas = mysqli_fetch_array($sql_notas)){
				?>
        <option value='<? echo $fil_notas[0]?>'><? echo $fil_notas[1]?></option>
        <?
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p></p>
<table width="848" border="0">
  <tr align="center" bgcolor="#CC9933">
  	<td width="68" rowspan="2"><span class="style1">Fecha</span></td>
	<td width="182" rowspan="2"><span class="style1">TipoNota</span></td>
    <td colspan="4"><span class="style1">Botella</span></td>
    <td colspan="4"><span class="style1">Lata</span></td>
    <td colspan="5"><span class="style1">Botell&iacute;n</span></td>
    <td colspan="3"><span class="style1">Chopp</span></td>
	<td colspan="2"><span class="style1">Envases</span></td>	
  </tr>
  <tr>
  	<td width="23" bgcolor="#F3EA72">Esp</td>
	<td width="30" bgcolor="#F3EA72">Sesq</td>
	<td width="28" bgcolor="#F3EA72">Stou</td>
	<td width="27" bgcolor="#F3EA72">Bice</td>
  	<td width="23" bgcolor="#F3EA72">Esp</td>
	<td width="30" bgcolor="#F3EA72">Sesq</td>
	<td width="28" bgcolor="#F3EA72">Stou</td>
	<td width="27" bgcolor="#F3EA72">Bice</td>
  	<td width="23" bgcolor="#F3EA72">Esp</td>
	<td width="30" bgcolor="#F3EA72">Sesq</td>
	<td width="28" bgcolor="#F3EA72">Stou</td>
	<td width="18" bgcolor="#F3EA72">33</td>
	<td width="27" bgcolor="#F3EA72">Bice</td>
  	<td width="23" bgcolor="#F3EA72">Esp</td>
	<td width="30" bgcolor="#F3EA72">Sesq</td>
	<td width="27" bgcolor="#F3EA72">Bice</td>
	<td width="48" bgcolor="#F3EA72">Botellas</td>
	<td width="46" bgcolor="#F3EA72">Canast.</td>
  </tr>
  <?
  	$f1 = $canno1.'/'.$cmes1.'/'.$cdia1;		
	$f2 = $canno2.'/'.$cmes2.'/'.$cdia2;
	
  	$sql_sum_prod = mysqli_query($link,"SELECT p.IdProducto, SUM(Cantidad) FROM itemProceso i RIGHT JOIN productos p ON i.idProducto = p.IdProducto JOIN Procesos r ON i.IdProceso = r.IdProceso AND i.TipoNota = r.TipoNota WHERE r.fecha BETWEEN '$f1' AND '$f2' AND r.Estado = 1 AND r.TipoNota = '$tipo_nota' GROUP BY p.IdProducto;");
	$c = 1;
	while($fil_sum_prod = mysqli_fetch_array($sql_sum_prod)){
		$id_prod[] = $fil_sum_prod[0];
		$sum[] = $fil_sum_prod[1];
		//$c++;
	}
	$c = 16;
	if($_POST){
		echo 'Entre el: '.$f1.' y el: '.$f2;//.' '.$c;//.'  '.$distribuidor;

	$bot_par = 0;
	$bot_tot = 0;
	
	$bot_esp = 0;
	$bot_ses = 0;
	$bot_sto = 0;
	$bot_bic = 0;
	
	$lat_esp = 0;
	$lat_ses = 0;
	$lat_sto = 0;
	$lat_bic = 0;
	
	$bln_esp = 0;
	$bln_ses = 0;
	$bln_sto = 0;
	$bln_33  = 0;	
	$bln_bic = 0;
	
	$chp_esp = 0;
	$chp_ses = 0;
	$chp_bic = 0;
	
	$can = 0;
	
	$sql_prod = mysqli_query($link,"call sp_embotellado('$f1','$f2','$tipo_nota')");
	while($fil_prod = mysqli_fetch_row($sql_prod)){
			$bot_par = $fil_prod[2]+$fil_prod[3]+$fil_prod[4]+$fil_prod[5];
			$bot_tot = $bot_tot + $bot_par;

			$bot_esp = $bot_esp + $fil_prod[2];
			$bot_ses = $bot_ses + $fil_prod[3];
			$bot_sto = $bot_sto + $fil_prod[4];
			$bot_bic = $bot_bic + $fil_prod[5];
	
			$lat_esp = $lat_esp + $fil_prod[6];
			$lat_ses = $lat_ses + $fil_prod[7];
			$lat_sto = $lat_sto + $fil_prod[8];
			$lat_bic = $lat_bic + $fil_prod[9];
	
			$bln_esp = $bln_esp + $fil_prod[10];
			$bln_ses = $bln_ses + $fil_prod[11];
			$bln_sto = $bln_sto + $fil_prod[12];
			$bln_33  = $bln_33  + $fil_prod[13];
			$bln_bic = $bln_bic + $fil_prod[14];
	
			$chp_esp = $chp_esp + $fil_prod[15];
			$chp_ses = $chp_ses + $fil_prod[16];
			$chp_bic = $chp_bic + $fil_prod[17];	
			
			$can = $can + $fil_prod[18];
			
			
			echo "<tr align='right' style='font-size:11px'><td align='center'>$fil_prod[0]</td><td align='center'>$fil_prod[1]</td><td>$fil_prod[2]</td><td>$fil_prod[3]</td><td>$fil_prod[4]</td><td>$fil_prod[5]</td><td>$fil_prod[6]</td><td>$fil_prod[7]</td><td>$fil_prod[8]</td><td>$fil_prod[9]</td><td>$fil_prod[10]</td><td>$fil_prod[11]</td><td>$fil_prod[12]</td><td>$fil_prod[13]</td><td>$fil_prod[14]</td><td>$fil_prod[15]</td><td>$fil_prod[16]</td><td>$fil_prod[17]</td><td>$bot_par</td><td>$fil_prod[18]</td><td>$fil_prod[19]</td></tr>";	
		}	}
  ?>  
  </tr>
  <tr bgcolor="#F3EA72" align="right" style="font-size:11px">
  	<td colspan="2" align="center"><strong>Totales</strong></td>
	<td><? echo $bot_esp?></td>
	<td><? echo $bot_ses?></td>
	<td><? echo $bot_sto?></td>
	<td><? echo $bot_bic?></td>
	
	<td><? echo $lat_esp?></td>
	<td><? echo $lat_ses?></td>
	<td><? echo $lat_sto?></td>
	<td><? echo $lat_bic?></td>
	
	<td><? echo $bln_esp?></td>
	<td><? echo $bln_ses?></td>
	<td><? echo $bln_sto?></td>
	<td><? echo $bln_33 ?></td>	
	<td><? echo $bln_bic?></td>
	
	<td><? echo $chp_esp?></td>
	<td><? echo $chp_ses?></td>
	<td><? echo $chp_bic?></td>
	<td><? echo ($bot_esp+$bot_ses+$bot_sto+$bot_bic)?></td>
	<td><? echo $can?></td>
  </tr>
</table>
</body>
</html>
<?php
ob_end_flush();
?>
