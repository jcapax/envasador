<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	if($acceso >= 8){
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}
?>
<html>
<head>
<title>Distribucion Cerveza</title>
<style type="text/css">
<!--
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
<h1>GR&Aacute;FICOS ESTAD&Iacute;STICOS </h1>
<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<form name="form1" method="post" action="matriz_grafico.php">
  <table width="439" border="0">
    <tr>
      <td width="97">Fecha Inicio: </td>
      <td width="359"><select name="canno1" id="canno1">
        <option value="0" selected>Selec.</option>
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
      <td>Proceso:</td>	  
      <td><select name="tipo_nota" id="tipo_nota">
        <option value='0' selected="selected">Seleccionar</option>
        <?
			$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");
			while($fil_notas = mysqli_fetch_array($sql_notas)){
				echo "<option value='$fil_notas[0]'>$fil_notas[1]</option>";
			}
			echo "<option value='4'>SALIDA DE PRODUCTOS</option>";
		?>        
		<option value='5'>INGRESO Y SALIDA DE ENVASES BOTELLAS</option>
        <option value='6'>INGRESO Y SALIDA DE ENVASES CAJAS</option>
      </select></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
      <? $sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE flag = 1 ORDER BY NombreDistribuidor");?>
      <td><select name="distribuidor" id="distribuidor">
        <?	
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				?>
        <option value='<? echo $fil_dist[0]?>'><? echo $fil_dist[1]?></option>
        <?
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Graficar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p></p>
</body>
</html>
