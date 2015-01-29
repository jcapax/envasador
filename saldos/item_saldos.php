<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
		
	if (!$_POST){
		$id_cliente      = $_GET['id_cliente'];		
		$id_distribuidor = $_GET['id_distribuidor'];				
	}
	else{ 
		$id_cliente      = $_POST['id_cliente'];
		$id_producto     = $_POST['id_producto'];
		$cantidad        = $_POST['cantidad'];
		$id_distribuidor = $_POST['id_distribuidor'];
	}	

	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	include('../auxiliares/funciones_varias.php');
	$link = conexion();
?>
<html>
<head>
<title>Item Mermas</title>
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
      <td colspan="2"><a href='../cambiar_contrasena.php'>Cambio Contrase&ntilde;a</a></td>
    </tr>
  </table>
</div>
<h1>DETALLE SALDOS INICIALES</h1>
  <p>
    <?	
	$cliente      = nombre_cliente($link,$id_cliente);
	$distribuidor = nombre_distribuidor($link,$id_distribuidor);
	if($id_producto <> 0){		
		$ins_itemSaldos = mysqli_query($link,"INSERT INTO itemSaldos(idCliente,idProducto, cantidad) VALUES('$id_cliente', '$id_producto', '$cantidad')");		
	}
?>
</p>
  <table width="330" border="0">
    <tr>
      <td width="74">Cliente:</td>
      <td width="240"><input name="textfield" type="text" value="<? echo $cliente?>" size="40" readonly="true"></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
      <td><input name="textfield2" type="text" value="<? echo $distribuidor?>" size="40" readonly="true"></td>
    </tr>
    <tr>
      <td height="23" colspan="2">&nbsp;</td>
    </tr>
  </table>
  <form name="form1" method="post" action="item_saldos.php">
  	<table width="246" border="0">
      <tr>
        <td width="86">Producto</td>
        <td width="150"><?
		$prod = mysqli_query($link,"SELECT IdProducto, NombreProducto, TipoProducto FROM productos WHERE idProducto NOT IN (SELECT idProducto FROM itemSaldos WHERE idCliente = '$id_cliente' AND idProducto <> 14)");
	?>
          <select name="id_producto" id="id_producto">
            <option value="0">Seleccionar</option>
            <? while($lprod = mysqli_fetch_array($prod)){
	  	echo "<option value='$lprod[0]'>$lprod[1]</option>";
	  }?>
          </select>
        <input name="id_cliente" type="hidden" id="id_cliente" value="<? echo $id_cliente?>"></td>
      </tr>
      <tr>
        <td>Cantidad</td>
        <td><input name="cantidad" type="text" id="cantidad" size="5" maxlength="5"></td>
      </tr>
      <tr>
        <td><label>
          <input name="submit" type="submit" id="submit" value="Guardar">
        </label></td>
        <td>&nbsp;</td>
      </tr>
    </table>
</form>

<table width="369" border="0">
  <tr bgcolor="#CC9933">
    <td width="209"><span class="style1">Producto</span></td>
    <td width="55"><span class="style1">Cantidad</span></td>    
    <td width="48"><span class="style1">Eliminar</span></td>
  </tr>
  <? 
  	$reg_item = mysqli_query($link,"SELECT p.nombreProducto,cantidad,p.idProducto FROM itemSaldos i JOIN productos p ON i.idProducto = p.idProducto WHERE idCliente = '$id_cliente'");
  	while($fil_item = mysqli_fetch_array($reg_item)){
		echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td align='center'><a href='elim_item.php?id_cliente=$id_cliente&id_producto=$fil_item[2]'><img src='../imagenes/eliminar.png' border='0'></a></td></tr>";
	}
  ?>
  <tr bgcolor="#CC9933" style="font-style:inherit">
    <td rowspan="3"></td>
  </tr>	
</table>
</body>
</html>
<?php
ob_end_flush();
?>