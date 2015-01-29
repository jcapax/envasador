<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();

	if (($acceso < 8) AND ($acceso <> 1)){
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}
?>
<html>
<head>
<title>Saldos Comercial</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<h1>SALDOS INICIALES CLIENTES</h1>
<p><a href="../reportes_comercial/saldos_clientes.php">Reportes</a></p>
<form name="form1" method="post" action="msg_saldos.php">
  <table width="510" border="0">
    <tr>
      <td>Nota</td>
      <td><input name="nota" type="text" id="nota" size="7" maxlength="5"></td>
    </tr>
    <tr>
      <td width="99">Fecha:</td>
      <td width="401"><? 
        if ($acceso == 1){ $tipo_nota = 4;} 	  
		if ($acceso == 2){ $tipo_nota = 1;}
		if ($acceso == 3){ $tipo_nota = 3;}
		if ($acceso == 4){ $tipo_nota = 4;}
	  ?>
          <select name="canno" id="canno">
            <option value="0">Selec.</option>
            <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
			<option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
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
		?>      </td>
    </tr>
    <tr>
      <td>Cliente:</td>
      <td><label>
        <?
   		$sql_cli = mysqli_query($link,"SELECT idCliente, nombreCliente, SUBSTRING(codigoCliente,4) FROM clientes WHERE codigoCliente LIKE 'CL%'ORDER BY nombreCliente");
	  ?>
        <select name="idCliente" id="idCliente">
          <option value="0">Seleccionar</option>
          <? while ($fil_cli = mysqli_fetch_array($sql_cli)){
					$cli = $fil_cli[2].' - '.$fil_cli[1];
			echo "<option value='$fil_cli[0]'>$cli</option>";
				}?>
        </select>
        <a href="../codificar_clientes.php"></a> <a href="../codificar_clientes.php"></a></label></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
      <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	 ?>
      <td><select name="idDistribuidor" id="idDistribuidor">
        <option value="0">Seleccionar</option>
        <? while ($fil_dist = mysqli_fetch_array($sql_dist)){
			echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
		}?>
      </select></td>
    </tr>
    <tr>
      <td><label>Saldo Efectivo: </label></td>
      <td><input name="efectivo" type="text" id="efectivo" size="9" maxlength="7"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<table width="718" border="0">
  <tr bgcolor="#CC9933" align="center">
    <td width="53" height="21"><span class="style1">Nota</span></td>
    <td width="201"><span class="style1">Cliente</span></td>
    <td width="210"><span class="style1">Distribuidor</span></td>
    <td width="37"><span class="style1">Fecha</span></td>
    <td width="35"><span class="style1">Saldo</span></td>
    <td width="36"><span class="style1">Editar</span></td>
    <td width="51"><span class="style1">Imprimir</span></td>
	<td width="61"><span class="style1">Confirmar</span></td>
  </tr>
<?
	$sel_saldos = mysqli_query($link,"SELECT nota, idCliente, f_nombre_cliente(idCliente), idDistribuidor, f_nombre_distribuidor(idDistribuidor), fecha, saldoEfectivo, estado
FROM saldosinicialescomercial s ORDER BY f_nombre_cliente(idCliente);");
	while($reg_saldos = mysqli_fetch_array($sel_saldos)){
		$bin = dechex($reg_saldos[1]);
		if($reg_saldos[7]==0){			
			echo "<tr style='font-size:12px'><td align='right'><a href='editar_saldos.php?id_cliente=$bin'>$reg_saldos[0]</a></td><td>$reg_saldos[2]</td><td>$reg_saldos[4]</td><td>$reg_saldos[5]</td><td align='right'>$reg_saldos[6]</td><td align='center'><a href='item_saldos.php?id_cliente=$reg_saldos[1]&id_distribuidor=$reg_saldos[3]'><img src='../imagenes/editar.png' border='0'></a></td><td align='center'><a href='impresion_saldos_cliente.php?id_cliente=$bin&tr=$reg_saldos[7]'><img src='../imagenes/impresora.gif' border='0'></a></td><td align='center'><a href='confirmar_saldo.php?id_cliente=$reg_saldos[1]'><img src='../imagenes/ok.gif' border='0'></a></td></tr>";
		}
		else{
			echo "<tr style='font-size:12px' bgcolor='#BBF7CA'><td align='right'>$reg_saldos[0]</td><td>$reg_saldos[2]</td><td>$reg_saldos[4]</td><td>$reg_saldos[5]</td><td align='right'>$reg_saldos[6]</td><td align='center'></td><td align='center'><a href='impresion_saldos_cliente.php?id_cliente=$bin&tr=$reg_saldos[7]'><img src='../imagenes/impresora.gif' border='0'></a></td><td align='center'></td></tr>";
		}
	}
?>
</table>
</body>
</html>

