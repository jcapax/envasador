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
		$res = $_POST["res"];
	}
?>
<html>
<head>
<title>Reporte Mermas Productos</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style3 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p>
  <?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
</p>
<h1>REPORTE MERMAS </h1>
<form action="rep_mermas.php" method="post" name="form1" id="form1">
  <table width="337" border="0">
    <tr>
      <td>Fecha Inicio:</td>
      <td><select name="canno1" id="canno1">
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
          <select name="cmes1" id="cmes1">
            <option value="0" selected="selected">Selec.</option>
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
      <td>Fecha Final:</td>
      <td><select name="canno2" id="canno2">
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
          <select name="cmes2" id="select2">
            <option value="0" selected="selected">Selec.</option>
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
      <td>Resumen:</td>
      <td><label>
        <input name="res" type="checkbox" id="res" value="1" checked>
      </label></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<table width="695" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="93" rowspan="2"><span class="style1">Fecha</span></td>
    <td width="157" rowspan="2"><span class="style1">Tipo Merma</span></td>
    <td colspan="3"><span class="style1">Botella</span></td>
    <td colspan="3"><span class="style1">Lata</span></td>
    <td colspan="4"><span class="style1">Botell&iacute;n</span></td>
    <td colspan="2"><span class="style1">Chopp</span></td>
  </tr>
  <tr>
    <td width="31" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="36" bgcolor="#F3EA72">Stou</td>
    <td width="27" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="38" bgcolor="#F3EA72">Stou</td>
    <td width="33" bgcolor="#F3EA72">Esp</td>
    <td width="35" bgcolor="#F3EA72">Sesq</td>
    <td width="29" bgcolor="#F3EA72">Stou</td>
    <td width="32" bgcolor="#F3EA72">33</td>
    <td width="28" bgcolor="#F3EA72">Esp</td>
    <td width="38" bgcolor="#F3EA72">Sesq</td>
  </tr>
  <?
  	$f1 = $canno1.'/'.$cmes1.'/'.$cdia1;		
	$f2 = $canno2.'/'.$cmes2.'/'.$cdia2;
	
	$be = 0;
	$bs = 0;
	$bt = 0;				
	
	$le = 0;
	$ls = 0;
	$lt = 0;				

	$te = 0;
	$ts = 0;
	$tt = 0;				
	$t3 = 0;
	
	$ce = 0;
	$cs = 0;				
	
  	if($_POST){
		echo '<h3> Entre el: '.$f1.' y el: '.$f2.'</h3>';
	
	if($res == 1){$sql_mermas = mysqli_query($link,"call sp_lista_mermas('$f1','$f2',1)");}
	else{	$sql_mermas = mysqli_query($link,"call sp_lista_mermas('$f1','$f2',0)");}

	while($fil_mermas = mysqli_fetch_row($sql_mermas)){
			if ($res){
				echo "<tr style='font-size:11px'><td>_</td><td align='right'>$fil_mermas[2]</td><td align='center'>$fil_mermas[3]</td><td align='right'>$fil_mermas[4]</td><td align='right'>$fil_mermas[5]</td><td align='right'>$fil_mermas[6]</td><td align='right'>$fil_mermas[7]</td><td align='right'>$fil_mermas[8]</td><td align='right'>$fil_mermas[9]</td><td align='right'>$fil_mermas[10]</td><td align='right'>$fil_mermas[11]</td><td align='right'>$fil_mermas[12]</td><td align='right'>$fil_mermas[13]</td><td align='right'>$fil_mermas[14]</td></tr>";				
				
				$be = $be + $fil_mermas[3];
				$bs = $bs + $fil_mermas[4];
				$bt = $bt + $fil_mermas[5];				
				
				$le = $le + $fil_mermas[6];
				$ls = $ls + $fil_mermas[7];
				$lt = $lt + $fil_mermas[8];				

				$te = $te + $fil_mermas[9];
				$ts = $ts + $fil_mermas[10];
				$tt = $tt + $fil_mermas[11];				
				$t3 = $t3 + $fil_mermas[12];
				
				$ce = $ce + $fil_mermas[13];
				$cs = $cs + $fil_mermas[14];					
			}
			else{
				echo "<tr style='font-size:11px'><td align='left'>$fil_mermas[0]</td><td align='center'>$fil_mermas[2]</td><td align='center'>$fil_mermas[3]</td><td align='right'>$fil_mermas[4]</td><td align='right'>$fil_mermas[5]</td><td align='right'>$fil_mermas[6]</td><td align='right'>$fil_mermas[7]</td><td align='right'>$fil_mermas[8]</td><td align='right'>$fil_mermas[9]</td><td align='right'>$fil_mermas[10]</td><td align='right'>$fil_mermas[11]</td><td align='right'>$fil_mermas[12]</td><td align='right'>$fil_mermas[13]</td><td align='right'>$fil_mermas[14]</td></tr>";				

				$be = $be + $fil_mermas[3];
				$bs = $bs + $fil_mermas[4];
				$bt = $bt + $fil_mermas[5];				
				
				$le = $le + $fil_mermas[6];
				$ls = $ls + $fil_mermas[7];
				$lt = $lt + $fil_mermas[8];				

				$te = $te + $fil_mermas[9];
				$ts = $ts + $fil_mermas[10];
				$tt = $tt + $fil_mermas[11];				
				$t3 = $t3 + $fil_mermas[12];
				
				$ce = $ce + $fil_mermas[13];
				$cs = $cs + $fil_mermas[14];				
			}			
		}	
	}
  ?>
  </tr>
    <?
		echo "<tr bgcolor='#F3EA72' align='right' style='font-size:11px'><td colspan='2'><span class='style3'>Totales</span></td><td>$be</td><td>$bs</td><td>$bt</td><td>$le</td><td>$ls</td><td>$lt</td><td>$te</td><td>$ts</td><td>$tt</td><td>$t3</td><td>$ce</td><td>$cs</td></tr>";
	?>
</table>
<p>&nbsp;</p>
</body>
</html>
