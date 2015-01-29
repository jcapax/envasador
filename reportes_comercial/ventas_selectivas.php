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

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);			
	
	echo "<br>";
?>
<html>
<head>
<title>Ventas Selectivas</title>
</head>

<body>
<h1>VENTAS SELECTIVAS</h1>
<form name="form1" method="post" action="reporte_ranking.php">
  <table width="648" border="0">
    <tr>
      <td width="111">Fecha Inicio:</td>
      <td width="259"><select name="canno1" id="canno1" style="text-align:right">
        <option value="0" selected>Selec.</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
        <option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		<option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
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
        <select name="cdia1" id="cdia1" style="text-align:right">
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
      <td width="264">&nbsp;</td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><select name="canno2" id="canno2" style="text-align:right">
        <option value="0" selected>Selec.</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
        <option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		<option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
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
        <select name="cdia2" id="select3" style="text-align:right">
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cantidad Registros: </td>
      <td><input name="cantidad" type="text" id="cantidad" value="25" size="6" maxlength="3" style="text-align:right"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tipo Reporte: </td>
      <td><select name="tipo_reporte" id="tipo_reporte">
        <option value="1" selected>Ranking de Clientes</option>
        <option value="2">Ranking por Calles</option>
        <option value="3">Ranking por Zonas</option>
        <option value="4">Ranking por Canal</option>
        <option value="5">Ranking por Tipo Local</option>
      </select></td>
      <td><select name="sub_reporte" id="sub_reporte">
      </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Consultar"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
