<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$id_comercial = hexdec($_GET['id_comercial']);
	$nota_venta = $_GET['nota_venta'];
	$fecha = $_GET['fecha'];
	$cliente = $_GET['n_cliente'];
	$distribuidor = $_GET['n_distribuidor'];
	$estado = $_GET['estado'];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
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
      <td colspan="2"><a href='cambiar_contrasena.php'>Cambio Contrase&ntilde;a</a></td>
    </tr>
  </table>
</div>
<h1>DETALLE COMERCIALIZACI&Oacute;N </h1>
  <table width="479" border="0">
    <tr>
      <td width="159"><strong>ID Comercializaci&oacute;n: </strong></td>
      <td width="304"><input name="textfield" type="text" value="<? echo $id_comercial?>" size="5" style="background:#FFFFCC">
        - 
      <input name="textfield6" type="text" value="<? if($estado == 1){echo "Confirmada";}else{ echo "Nota por Confirmar";}?>" size="19" style="background:#FFFFCC"></td>
    </tr>
    <tr>
      <td><strong>Nota Venta: </strong></td>
      <td><input name="textfield2" type="text" value="<? echo $nota_venta?>" size="15" style="background:#FFFFCC"></td>
    </tr>
    <tr>
      <td><strong>Fecha:</strong></td>
      <td><input name="textfield3" type="text" value="<? echo $fecha?>" size="10" style="background:#FFFFCC"></td>
    </tr>
    <tr>
      <td><strong>Cliente:</strong></td>
      <td><input name="textfield4" type="text" value="<? echo $cliente?>" size="49" maxlength="40" style="background:#FFFFCC"></td>
    </tr>
    <tr>
      <td><strong>Distribuidor:</strong></td>
      <td><input name="textfield5" type="text" value="<? echo $distribuidor?>" size="40" style="background:#FFFFCC"></td>
    </tr>
  </table>
  <p><em><strong>PRODUCTOS</strong></em></p>
<table width="535" border="0">
  <tr bgcolor="#CC9933">
    <td width="245"><span class="style1">Producto</span></td>
    <td width="55"><span class="style1">Cantidad</span></td>
    <td width="43"><span class="style1">Recup.</span></td>
    <td width="36"><span class="style1">Bonif.</span></td>
    <td width="39"><span class="style1">Efecti.</span></td>
    <td width="39"><span class="style1">Precio</span></td>
  </tr>
  <? 
/*
  	$reg_item = mysqli_query($link,"SELECT p.nombreProducto,cantidad,precioTotal,p.idProducto, i.recuperacion FROM itemComercial i JOIN productos p ON i.idProducto = p.idProducto WHERE idComercial = '$id_comercial'");
	$prec_tot = 0;
  	while($fil_item = mysqli_fetch_array($reg_item)){
		$precio = round($fil_item[2],2);
		$prec_tot = $prec_tot + $precio;
		if($fil_item[4]==1){
			echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td align='center'>X</td><td align='right'>$precio</td></tr>";
		}
		else{
			echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td align='center'></td><td align='right'>$precio</td></tr>";
		}		
	};
*/
  	$reg_item = mysqli_query($link,"SELECT p.nombreProducto,cantidad,precioTotal,p.idProducto, i.recuperacion, i.bonificacion, i.efectivo FROM itemComercial i JOIN productos p ON i.idProducto = p.idProducto WHERE idComercial = '$id_comercial'");
	$prec_tot = 0;
  	while($fil_item = mysqli_fetch_array($reg_item)){
		$precio = number_format($fil_item[2], 2, '.',',');
		$prec_tot = $prec_tot + $fil_item[2];

		if($fil_item[6]==1){
			$aux = '-X-';}else{$aux = '';
		}
		if(($fil_item[4] == 0)and($fil_item[5] == 0)){
				echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td></td><td></td><td align='center'>$aux</td><td align='right'>$precio</td></tr>";
		}
		if($fil_item[4] == 1){
			echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td bgcolor='#99CC33' align='center'>-X-</td><td align='center'>-</td><td align='center'>$aux</td><td align='center'>-</td></tr>";
		}
		if($fil_item[5] == 1){
			echo "<tr style='font-size:11px'><td>$fil_item[0]</td><td align='right'>$fil_item[1]</td><td></td><td bgcolor='#00CC66' align='center'>-X-</td><td align='center'>$aux</td><td align='center'>-</td></tr>";
		}
	};

  ?>
  <tr bgcolor="#CC9933" style="font-style:inherit">
    <td colspan="2"><div align="right" class="style1">Total:</div></td>
    <td width="43" align="right" style="font-size:12px">&nbsp;</td>
    <td width="36" align="right" style="font-size:12px">&nbsp;</td>
    <td width="39" align="right" style="font-size:12px">&nbsp;</td>
    <td width="39" align="right" style="font-size:12px"><span class="style1"><? $prec_tot = number_format($prec_tot, 2, '.',',');; echo $prec_tot?></span></td>   
  </tr>	
</table>
</body>
</html>
<?php
ob_end_flush();
?>