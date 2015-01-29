<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<html>
<head>
<title>COMERCIALIZACION</title>
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
-->
</style>
</head>
<body>
<div id="Layer1">
  <table width="97%" style="font-size:11px"border="0">
    <tr bgcolor="#CFDDFC" >
      <td width="46%">Usuario:</td>
      <td width="54%" align="center"><? echo $login;?></td>
    </tr>
    <tr bgcolor="#CFDDFC" >
      <td>Codigo:</td>
      <td align="center"><? echo $codigo_usuario;?></td>
    </tr>
  </table>
</div>
<h1>COMERCIALIZACI&Oacute;N  </h1>
<form name="form1" method="post" action="msg_comercial.php">
  <table width="568" border="0">
    <tr>
      <td width="103">Fecha:</td>
      <td width="497"><? 
        if ($acceso == 1){ $tipo_nota = 4;} 	  
		if ($acceso == 2){ $tipo_nota = 1;}
		if ($acceso == 3){ $tipo_nota = 3;}
		if ($acceso == 4){ $tipo_nota = 4;}
	  ?>
        <select name="canno" id="canno">
        <option value="0" selected>Selec.</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
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
		  <option value="0" selected>Selec.</option>
		  <?
		  	$d = 1;
			while ($d <= 31){
				if ($fil_fecha[2] == $d){ echo "<option value='$d' selected='selected'>$d</option>";}
				else { echo "<option value='$d'>$d</option>";}
				$d = $d + 1;
			}
		  ?>
        </select>
		<? 
			if ($acceso<>1){echo "<input name='tipo_nota' type='hidden' id='tipo_nota' value='$tipo_nota'>";}
		?>	  </td>
    </tr>
    <tr>
      <td>Nota Venta: </td>
      <td><label>
        <input type="text" name="textfield">
      </label></td>
    </tr>
    <tr>
      <td>Cliente:</td>
      <td><label>
      <?
   		$sql_cli = mysqli_query($link,"SELECT idCliente, nombreCliente FROM clientes ORDER BY nombreCliente");
	  ?>
	    <select name="select">
			<option value="0">Seleccionar</option>
			<? while ($fil_cli = mysqli_fetch_array($sql_cli)){
			echo "<option value='$fil_cli[0]'>$fil_cli[1]</option>";
				}?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
	  <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	 ?>
      <td><select name="select2">
        <option value="0">Seleccionar</option>
		<? while ($fil_dist = mysqli_fetch_array($sql_dist)){
			echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
		}?>
      </select></td>
    </tr>
    <tr>
      <td><label>
        <input type="submit" name="Submit" value="Enviar">
      </label></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<table width="421" border="0">
  <tr bgcolor="#CC9933">
    <td width="23"><span class="style1">N&deg;</span></td>
    <td width="63"><span class="style1">Fecha</span></td>
    <td width="267"><span class="style1">Detalle</span></td>
    <td width="8"><span class="style1">Imprimir</span></td>
    <td width="10"><span class="style1">Confirmar</span></td>
    <td width="10"><span class="style1">Editar</span></td>
  </tr>
  <?
		if($acceso == 1){
			$mer = mysqli_query($link,"SELECT * FROM comercial ORDER BY fecha DESC");			
		}
		else{
			$mer = mysqli_query($link,"SELECT * FROM comercial WHERE tipoNota = $tipo_nota ORDER BY fecha DESC");
		}
		while($lmer = mysqli_fetch_array($mer)){
			if ($lmer[6]==0){
				echo "<tr style='font-size:11px'><td>$lmer[0]</td><td>$lmer[1]</td><td>$lmer[3]</td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]'><img src='imagenes/impresora.gif' border='0'></a></td><td align='center'><a href='confirmar_merma.php?id_merma=$lmer[0]'><img src='imagenes/ok.gif' border='0'></a></td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]'><img src='imagenes/editar.gif' border='0'></a></td></tr>";

			}
			else{
				echo "<tr style='font-size:11px' bgcolor='#C6FBAC'><td>$lmer[0]</td><td>$lmer[1]</td><td>$lmer[3]</td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]'><img src='imagenes/impresora.gif' border='0'></a></td><td align='center'></td><td></td></tr>";

			}
		}
  ?>
</table>
</body>
</html>