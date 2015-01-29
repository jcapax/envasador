<?
//	session_start();
//	$codigo_usuario = $_SESSION["codigo_usuario"];
//	$login = $_SESSION["login"];
//	$acceso = $_SESSION["acceso"];
	
//	include("autenticacion.php");
//	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	
	if($_POST){
		$mes = $_POST['cmes'];
		$anno = $_POST['canno'];
		$monto = $_POST['monto'];
		
		$sql_rango = mysqli_query($link,"SELECT f_primerDia('$mes','$anno'),f_ultimoDia(f_primerDia('$mes','$anno')),now()");
		$fil_rango = mysqli_fetch_array($sql_rango);			
		
		$auxAnno = $anno - 1;
		$sql_venAnt = mysqli_query($link,"SELECT totalBotella, totalDinero FROM ventasAnteriores WHERE anno = '$auxAnno' AND mes='$mes'");
		$fil_venAnt	= mysqli_fetch_array($sql_venAnt);	
		
		$totalBotella = round($fil_venAnt[0]);
		$totalDinero  = round($fil_venAnt[1]);
	}
?>
<html>
<head>
<title>Control Cerveza</title>
</head>

<body>
<h2>CONTROL VENTA CERVEZA</h2>
<form name="form1" method="post" action="control_salida.php">
  <table width="200" border="0">
    <tr>
      <td>Mes:</td>
      <td><select name="canno" id="canno">
        <option value="0">Selec.</option>                		
		<option value="2014">2014</option>
		<option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>

      </select></td>
    </tr>
    <tr>
      <td>A&ntilde;o:</td>
      <td><select name="cmes" id="cmes">
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
      </select></td>
    </tr>
    <!--
    <tr>
      <td>Monto Bs. </td>
      <td><input name="monto" type="text" id="monto" size="10" maxlength="10"></td>
    </tr>
-->
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Consultar"></td>
    </tr>
  </table>
</form>
<table width="1100" border="0">
  <tr>
    <td width="354"><? echo '<h3>'.'Consulta entre: '.$fil_rango[0].' y '.$fil_rango[1].'</h3>';?></td>
    <td width="744"><? echo '<h4>Fecha Hora Actual: '.$fil_rango[2].'</h4>';?></td>
  </tr>
</table>

<table width="826" border="0">
  <tr bgcolor="#FFCC00">
    <td width="249" rowspan="2"><div align="center">Distribuidor</div></td>
    <td colspan="3"><div align="center">Venta Acumulada</div></td>
    <td colspan="2"><div align="center">Meta Mensual</div></td>
    <td width="46" rowspan="2"><div align="center">% Avance</div></td>
    <td colspan="3"><div align="center">Por Vender  </div></td>
	<td colspan="2">Tendencia</td>	
  </tr>
  <tr bgcolor="#FFCC00">
    <td width="55">Prom/d&iacute;a</td>
    <td width="48"><div align="center">Botellas</div></td>
    <td width="35"><div align="center">Cajas</div></td>
    <td width="48"><div align="center">Botellas</div></td>
    <td width="35"><div align="center">Cajas</div></td>
    <td width="55">Prom/d&iacute;a</td>
    <td width="48"><div align="center">Botellas</div></td>
    <td width="35"><div align="center">Cajas</div></td>
	<td width="52">a Llegar</td>	
	<td width="70">% Llegar</td>	
  </tr>
  <?	
  	if($_POST){		
		
		$sql_dias = mysqli_query($link,"SELECT DAY(NOW()),(DATEDIFF(f_ultimoDia(f_primerDia('$mes','$anno')),f_primerDia('$mes','$anno'))+1)-(DAY(NOW()))");
		$fil_dias = mysqli_fetch_array($sql_dias);
		$dia_actual = $fil_dias[0];
		$dia_resto_mes = $fil_dias[1];
		
		$sql = mysqli_query($link,"call sp_ventaCerveza(f_primerDia('$mes','$anno'),f_ultimoDia(f_primerDia('$mes','$anno')))");

//***********************************    LOCAL

		while($control = mysqli_fetch_array($sql)){

			if($control[0] == 1){

				echo "<tr style='font-size:12px'>
						<td>$control[1]</td>
						<td align='right'>$control[9]</td>
						<td align='right'>$control[2]</td>
						<td align='right'>$control[3]</td>
						<td align='right'>$control[4]</td>
						<td align='right'>$control[5]</td>
						<td align='right' bgcolor='#C7C7C7'><strong>$control[6]%</strong></td>
						<td align='right'>$control[10]</td>
						<td align='right'>$control[7]</td>
						<td align='right'>$control[8]</td>
						<td align='right'>$control[11]</td>
						<td align='right' bgcolor='#C7C7C7'><strong>$control[12]%</strong></td>
					</tr>";

				$botA = $botA + $control[2];
				$cajA = $cajA + $control[3];
			
				$botM = $botM + $control[4];
				$cajM = $cajM + $control[5];
				
				$promA = $promA + $control[6];
				
				$botR = $botR + $control[7];
				$cajR = $cajR + $control[8];
				
				$cajasAcum = $cajasAcum +  $control[9];
				$cajasXvender = $cajasXvender +  $control[10];
				
				$tendAc = $tendAc + $control[11];
				$tendPor = $tendPor + $control[12];
			
				$cont = $cont + 1;
			}
		}

		echo "<tr style='font-size:12px' bgcolor='#CCCCFF'>
				<td align='center'><strong>TOTAL LOCAL</strong></td>
				<td align='right'><strong>$cajasAcum</strong></td>
				<td align='right'><strong>$botA</strong></td>
				<td align='right'><strong>$cajA</strong></td>
				<td align='right'><strong>$botM</strong></td>
				<td align='right'><strong>$cajM</strong></td>
				<td align='right'><strong>$aux%</strong></td>
				<td align='right'><strong>$cajasXvender</strong></td>
				<td align='right'><strong>$botR</strong></td>
				<td align='right'><strong>$cajR</strong></td>
				<td align='right'><strong>$tendAc</strong></td>
				<td align='right'><strong>$auxTend%</strong></td>
			</tr>";


  ?>
</table>
<p>&nbsp;</p>

</body>
</html>
