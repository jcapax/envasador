<?php
ob_start();
?>
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	if (($acceso < 8) AND ($acceso <> 1)){
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}		
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();
	
	$id_cliente = $_GET['id_cliente'];
	$id_cliente = hexdec($id_cliente);
	
	if($_POST){
		$nota = $_POST['nota'];
		$idCliente = $_POST['idCliente'];
		$idDistribuidor = $_POST['idDistribuidor'];
		$efectivo = $_POST['efectivo'];
		$canno = $_POST['canno'];
		$cmes = $_POST['cmes'];
		$cdia = $_POST['cdia'];
		
		if(!checkdate($cmes,$cdia,$canno)){ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  echo "<a href='saldos_comercial.php'>volver</a>";
		  die;
		}
		else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
	
		if($idDistribuidor == 0){ 
		  echo '<br>'.'Seleccionar Distribuidor!!!'.'<br>';
		  echo "<a href='saldos_comercial.php'>volver</a>";
		  die;
		}

		if($idCliente == 0){ 
		  echo '<br>'.'Seleccionar Cliente!!!'.'<br>';
		  echo "<a href='saldos_comercial.php'>volver</a>";
		  die;
		}
		
		mysqli_query($link,"UPDATE saldosInicialesComercial SET idCliente = '$idCliente', idDistribuidor='$idDistribuidor', fecha='$fecha', fechaHoraRegistro = now(), codigoUsuario='$codigo_usuario', nota='$nota', saldoEfectivo='$efectivo' WHERE idCliente = '$idCliente'");
		
		echo "UPDATE saldosInicialesComercial SET idCliente = '$idCliente', idDistribuidor='$idDistribuidor', fecha='$fecha', fechaHoraRegistro = now(), codigoUsuario='$codigo_usuario', nota='$nota', saldoEfectivo='$efectivo' WHERE idCliente = '$idCliente'";
		
		header("Location: saldos_comercial.php");
	}
?>
<html>
<head>
<title>Edición Nota Saldo Comercial</title>
</head>
<body>
<?	
	$sel_saldo = mysqli_query($link,"SELECT f_nombre_cliente(idCliente), f_nombre_distribuidor(idDistribuidor), fecha, nota, saldoEfectivo FROM saldosinicialescomercial WHERE idCliente = '$id_cliente';");
	$saldo = mysqli_fetch_array($sel_saldo);
?>
<h1> EDICION SALDOS CLIENTE</h1>
<table width="597" border="0">
  <tr bgcolor="#FFCC33" align="center" >
    <td width="78">Fecha</td>
    <td width="189">Cliente</td>
    <td width="197">Distribuidor</td>
    <td width="58">Nota</td>
    <td width="83">Efectivo</td>
  </tr>
  <? echo "<tr style='font-size:12px'><td>$saldo[2]</td><td>$saldo[0]</td><td>$saldo[1]</td><td align='right'>$saldo[3]</td><td align='right'>$saldo[4]</td></tr>";?>
</table>
<p>&nbsp;</p>
<form name="form1" method="post" action="editar_saldos.php">
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
				if ($saldo[2] == $d){ echo "<option value='$d' selected='selected'>$d</option>";}
				else { echo "<option value='$d'>$d</option>";}
				$d = $d + 1;
			}
		  ?>
          </select>
          <? 
			if ($acceso<>1){echo "<input name='tipo_nota' type='hidden' id='tipo_nota' value='$tipo_nota'>";}
		?>
      </td>
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
      <td><input type="submit" name="Submit" value="Actualizar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
ob_end_flush();
?>
