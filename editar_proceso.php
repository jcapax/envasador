<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];

	if (!$_POST){	
		$id_proceso = $_GET['id_proceso'];
		$tipo_nota = $_GET['tipo_nota'];
	}
	else{
		$tipo_nota = $_POST['tipo_nota'];
		$canno = $_POST['canno'];
		$cmes = $_POST['cmes'];
		$cdia = $_POST['cdia'];
		if ($tipo_nota <> 3){$distribuidor = $_POST['distribuidor'];}
		else{$distribuidor = 0;}
		$detalle = $_POST['$detalle'];
	}
	
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

?>
<html>
<head>
<title>Edición de Proceso</title>
<style type="text/css">
<!--
#Layer1 {	position:absolute;
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
<h1>EDICI&Oacute;N PROCESOS </h1>
<?
	$sql_proceso = mysqli_query($link,"SELECT idProceso, f_nombre_nota('$tipo_nota'),f_nombre_distribuidor(idDistribuidor),Fecha,Detalle FROM Procesos WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota'");
	$fil_proceso = mysqli_fetch_array($sql_proceso);
	echo "<table>";
		echo "<tr style='font-size:12px' bgcolor='#CCCCCC'>";
			echo "<td>N°</td>";
			echo "<td>Nota</td>";
			echo "<td>Dist.</td>";
			echo "<td>Fecha</td>";
			echo "<td>Detalle</td>";
		echo "</tr>";
		echo "<tr bgcolor='#FFCC99' style='font-size:9px'>";
			echo "<td>$fil_proceso[0]</td>";
			echo "<td>$fil_proceso[1]</td>";
			echo "<td>$fil_proceso[2]</td>";
			echo "<td>$fil_proceso[3]</td>";
			echo "<td>$fil_proceso[4]</td>";
		echo "</tr>";
	echo "</table>"; 
?>
<p>	</p>
<form name="form1" method="post" action="correccion_procesos.php">
  <table width="54%" border="0">
    <tr>
      <td width="24%">Tipo Nota</td>
      <td width="76%"><input name="acceso" type="hidden" id="acceso" value="<? echo $acceso?>">
	  <input name="tipo_nota_ant" type="hidden" id="tipo_nota_ant" value="<? echo $tipo_nota?>">
	  <input name="id_proceso_ant" type="hidden" id="id_proceso_ant" value="<? echo $id_proceso?>">
	  <? $nombre_nota=mysqli_fetch_array(mysqli_query($link,"SELECT f_nombre_nota('$tipo_nota')"))?>
	  <input name="nombre_nota" type="text" id="nombre_nota" value="<? echo $nombre_nota[0]?>" size="40" readonly="">
    </tr>
    <tr>
      <?
   			    $sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND IdDistribuidor > 0 ORDER BY NombreDistribuidor");
				if ($acceso <> 3){
		?>
      <td>Distribuidor</td>
      <td><select name="distribuidor" id="distribuidor">
          <option value="0">Seleccionar</option>
          <?
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				?>
          <option value='<? echo $fil_dist[0]?>'><? echo $fil_dist[1]?></option>
          <?
			}
		?>
        </select>
          <? }?>      </td>
    </tr>
    <tr>
      <?
		$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
		$fil_fecha = mysqli_fetch_row($sql_fecha);
	?>
      <td>Fecha:</td>
      <td><select name="canno" id="canno">
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
          <select name="cmes" id="cmes">
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
          <select name="cdia" id="cdia">
            <option  value="0" selected>Selec.</option>
            <option  value="1"<? if($fil_fecha[2]==1){?>selected<? }?>>1</option>
            <option  value="2"<? if($fil_fecha[2]==2){?>selected<? }?>>2</option>
            <option  value="3"<? if($fil_fecha[2]==3){?>selected<? }?>>3</option>
            <option  value="4"<? if($fil_fecha[2]==4){?>selected<? }?>>4</option>
            <option  value="5"<? if($fil_fecha[2]==5){?>selected<? }?>>5</option>
            <option  value="6"<? if($fil_fecha[2]==6){?>selected<? }?>>6</option>
            <option  value="7"<? if($fil_fecha[2]==7){?>selected<? }?>>7</option>
            <option  value="8"<? if($fil_fecha[2]==8){?>selected<? }?>>8</option>
            <option  value="9"<? if($fil_fecha[2]==9){?>selected<? }?>>9</option>
            <option value="10"<? if($fil_fecha[2]==10){?>selected<? }?>>10</option>
            <option value="11"<? if($fil_fecha[2]==11){?>selected<? }?>>11</option>
            <option value="12"<? if($fil_fecha[2]==12){?>selected<? }?>>12</option>
            <option value="13"<? if($fil_fecha[2]==13){?>selected<? }?>>13</option>
            <option value="14"<? if($fil_fecha[2]==14){?>selected<? }?>>14</option>
            <option value="15"<? if($fil_fecha[2]==15){?>selected<? }?>>15</option>
            <option value="16"<? if($fil_fecha[2]==16){?>selected<? }?>>16</option>
            <option value="17"<? if($fil_fecha[2]==17){?>selected<? }?>>17</option>
            <option value="18"<? if($fil_fecha[2]==18){?>selected<? }?>>18</option>
            <option value="19"<? if($fil_fecha[2]==19){?>selected<? }?>>19</option>
            <option value="20"<? if($fil_fecha[2]==20){?>selected<? }?>>20</option>
            <option value="21"<? if($fil_fecha[2]==21){?>selected<? }?>>21</option>
            <option value="22"<? if($fil_fecha[2]==22){?>selected<? }?>>22</option>
            <option value="23"<? if($fil_fecha[2]==23){?>selected<? }?>>23</option>
            <option value="24"<? if($fil_fecha[2]==24){?>selected<? }?>>24</option>
            <option value="25"<? if($fil_fecha[2]==25){?>selected<? }?>>25</option>
            <option value="26"<? if($fil_fecha[2]==26){?>selected<? }?>>26</option>
            <option value="27"<? if($fil_fecha[2]==27){?>selected<? }?>>27</option>
            <option value="28"<? if($fil_fecha[2]==28){?>selected<? }?>>28</option>
            <option value="29"<? if($fil_fecha[2]==29){?>selected<? }?>>29</option>
            <option value="30"<? if($fil_fecha[2]==30){?>selected<? }?>>30</option>
            <option value="31"<? if($fil_fecha[2]==31){?>selected<? }?>>31</option>
        </select></td>
    </tr>
    <tr>
      <td>Detalle</td>
      <td><input name="detalle" type="text" id="detalle" size="70" maxlength="100" value="<? echo $fil_proceso[4]?>"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Corregir"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
ob_end_flush();
?>
