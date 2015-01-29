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
	
	$id_cliente = hexdec($_GET['id_cliente']);
	$tr = $_GET['tr'];
	
	$sel_saldo = mysqli_query($link,"SELECT f_nombre_cliente(idCliente), f_nombre_distribuidor(idDistribuidor), fecha, nota, ROUND(saldoEfectivo,2) FROM saldosinicialescomercial WHERE idCliente = '$id_cliente';");
	$saldo = mysqli_fetch_array($sel_saldo);
?>
<html>
<head>
<title>Impresion Saldos</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<br>
<table width="490" border="0">
  <tr>
    <td width="130">Nota:</td>
    <td width="350">
		<input name="textfield3" type="text" value="<? echo $saldo[3]?>" size="6" readonly="true" style="text-align:right">
    <input name="textfield32" type="text" style="text-align:center" value="<? if($tr==1){echo "CONFIRMADA";}else{echo "SIN CONFIRMAR";}?>" size="20" readonly="true"></td>
  </tr>
  <tr>
    <td>Cliente:</td>
    <td><input name="textfield" type="text" value="<? echo $saldo[0]?>" size="40" readonly="true"></td>
  </tr>
  <tr>
    <td height="23">Distribuidor:</td>
	<td height="23"><input name="textfield2" type="text" value="<? echo $saldo[1]?>" size="40" readonly="true"></td>
  </tr>
  <tr>
    <td height="23">Fecha:</td>
    <td height="23"><input name="textfield22" type="text" value="<? echo $saldo[2]?>" size="12" readonly="true"></td>
  </tr>
  <tr>
    <td height="23">Saldo Efectivo:</td>
    <td height="23"><input name="textfield222" type="text" value="<? echo $saldo[4]?>" size="8" readonly="true" style="text-align:right"></td>
  </tr>
</table>
<br>
<table width="369" border="0">
  <tr bgcolor="#CC9933">
    <td width="209"><span class="style1">Producto</span></td>
    <td width="55"><span class="style1">Cantidad</span></td>
  </tr>
  <? 
  	$reg_item = mysqli_query($link,"SELECT p.nombreProducto,cantidad,p.idProducto FROM itemSaldos i JOIN productos p ON i.idProducto = p.idProducto WHERE idCliente = '$id_cliente'");
  	while($fil_item = mysqli_fetch_array($reg_item)){
		echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td></tr>";
	}
  ?>
  <tr bgcolor="#CC9933" style="font-style:inherit">
    <td colspan="2"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
