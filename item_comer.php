<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
		
	if (!$_POST){
		$id_comercial = hexdec($_GET['id_comercial']);
		$tipent       = $_GET['tipent'];		
	}
	else{ 
		$id_comercial = hexdec($_POST['id_comercial']);
		$id_producto  = $_POST['id_producto'];
		$cantidad     = $_POST['cantidad'];
		$recuperacion = $_POST['recuperacion'];
		$bonificacion = $_POST['bonificacion'];
		$efectivo     = $_POST['efectivo'];
		$tipent       = $_POST['tipent'];
	}	
	
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
<?

	$sql_ = mysqli_query($link,"SELECT notaVenta, fecha, f_nombre_cliente(idCliente), f_nombre_distribuidor(c.idDistribuidor), l.tipoPrecio, nombreTipoPrecio FROM comercial c join clientes l USING(idCliente) JOIN tipoPreciosProductos t USING(tipoPrecio) WHERE idComercial = '$id_comercial'");
	$grales = mysqli_fetch_array($sql_);
?>
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
  <?	
  	if($efectivo==1){
		$efect = 1;		
	}
	else{
		$efect = 0;
	}
	if($id_producto <> 0){		
		if($recuperacion == 1){
			if(($id_producto == 13)or($id_producto == 14)or($id_producto == 11)or($id_producto == 12)or($id_producto == 19)){
				$ins_itemComercial = mysqli_query($link,"INSERT INTO itemComercial(idComercial,idProducto, cantidad,precioTotal,recuperacion,bonificacion,efectivo) VALUES('$id_comercial', '$id_producto', '$cantidad',0,1,0,0)");
			}
		}
		else{
//			if($id_producto <> 13){				
//				$rec_precio = mysqli_query($link,"SELECT f_precioRegular('$id_producto');");
//				echo $id_producto.',,,,,,,,,,,,'.$grales[4];
				$rec_precio = mysqli_query($link,"SELECT f_precioRegular('$id_producto','$grales[4]');");
				$fil_precio = mysqli_fetch_array($rec_precio);
				$precioTotal = round(($fil_precio[0] * $cantidad),3);
//				echo '****/////////********'.$id_producto.'-'.$precioTotal.' ************';
				if(($id_producto == 14)or($id_producto == 13)){
					$precioTotal = 0;
				}					
				
				if($bonificacion == 1){					
					$ins_itemComercial = mysqli_query($link,"INSERT INTO itemComercial(idComercial,idProducto, cantidad,precioTotal,recuperacion,bonificacion,efectivo) VALUES('$id_comercial', '$id_producto', '$cantidad',0,0,1,0)");						
				}				
				else{

					$ins_itemComercial = mysqli_query($link,"INSERT INTO itemComercial(idComercial,idProducto, cantidad,precioTotal,recuperacion,bonificacion,efectivo) VALUES('$id_comercial', '$id_producto', '$cantidad', '$precioTotal',0,0,$efect)");
				}
//			}
		}		
	}
?>



  <table width="593" border="0">
    <tr>
      <td width="71">Nota Venta </td>
      <td width="210"><input name="textfield" type="text" value="<? echo $grales[0];?>" size="10" readonly style="font-size:10px"></td>
      <td width="19">&nbsp;</td>
      <td width="87">Fecha</td>
      <td width="184"><input name="textfield2" type="text" value="<? echo $grales[1];?>" size="10" readonly style="font-size:10px"></td>
    </tr>
    <tr>
      <td>Cliente</td>
      <td><input name="textfield3" type="text" value="<? echo $grales[2];?>" size="35" readonly style="font-size:10px"></td>
      <td>&nbsp;</td>
      <td>Tipo Precio </td>
      <td><input name="textfield4" type="text" value="<? echo $grales[5];?>" size="17" readonly style="font-size:10px"></td>
    </tr>
    <tr>
      <td>Distribuidor</td>
      <td><input name="textfield5" type="text" value="<? echo $grales[3];?>" size="31" readonly style="font-size:10px"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="5">&nbsp;</td>
    </tr>
  </table>
  <form name="form1" method="post" action="item_comer.php">
  	<table width="506" border="0">
      <tr>
        <td width="86">Producto</td>
        <td colspan="5"><?
		$prod = mysqli_query($link,"SELECT IdProducto, NombreProducto, TipoProducto FROM productos WHERE idProducto NOT IN (SELECT idProducto FROM itemComercial WHERE idComercial = '$id_comercial' AND idProducto <>14 AND bonificacion = 1 AND efectivo = 1)");
	?>
          <select name="id_producto" id="id_producto">
            <option value="0">Seleccionar</option>
            <? while($lprod = mysqli_fetch_array($prod)){
	  	echo "<option value='$lprod[0]'>$lprod[1]</option>";
	  }?>
          </select>
        <input name="id_comercial" type="hidden" id="id_comercial" value="<? echo dechex($id_comercial)?>">
        <input name="tipent" type="hidden" id="tipent" value="<? echo $tipent?>">
      </td>
      </tr>
      <tr>
        <td>Cantidad</td>
        <td colspan="5"><input name="cantidad" type="text" id="cantidad" size="5" maxlength="5"></td>
      </tr>
      <tr>
        <td>Recuperaci&oacute;n:</td>
        <td width="41"><input name="recuperacion" type="checkbox" id="recuperacion" value="1"></td>
        <!--<td width="74">Bonificación</td>
        <td width="48"><input name="bonificacion" type="checkbox" id="bonificacion" value="1"></td> -->       
        <?
			if($tipent == 1){
				echo "<td width='49'> Efectivo</td>";
				echo "<td width='182'>";
				echo "<input name='efectivo' type='checkbox' id='efectivo' value='1' checked>";
				echo "</td>";
			}
			else{
				echo $tipent;
			}
        ?>                
      </tr>
      <tr>
        <td><label>
          <input name="submit" type="submit" id="submit" value="Guardar">
        </label></td>
        <td colspan="5">&nbsp;</td>
      </tr>
    </table>
</form>

<table width="535" border="0">
  <tr bgcolor="#CC9933">
    <td width="245"><span class="style1">Producto</span></td>
    <td width="55"><span class="style1">Cantidad</span></td>
    <td width="43"><span class="style1">Recup.</span></td>
    <td width="36"><span class="style1">Bonif.</span></td>
    <td width="39"><span class="style1">Efecti.</span></td>
    <td width="39"><span class="style1">Precio</span></td>
    <td width="48"><span class="style1">Eliminar</span></td>
  </tr>
  <? 
  	$reg_item = mysqli_query($link,"SELECT p.nombreProducto,cantidad,precioTotal,p.idProducto, i.recuperacion, i.bonificacion, i.efectivo FROM itemComercial i JOIN productos p ON i.idProducto = p.idProducto WHERE idComercial = '$id_comercial'");
	$prec_tot = 0;
  	while($fil_item = mysqli_fetch_array($reg_item)){
		$precio = number_format($fil_item[2], 2, '.',',');
		$prec_tot = $prec_tot + $fil_item[2];

		if($fil_item[6]==1){
			$aux = '-X-';}else{$aux = '';
		}
		if(($fil_item[4] == 0)and($fil_item[5] == 0)){
				echo "<tr style='font-size:11px'>";
					echo "<td>$fil_item[0]</td>";
					echo "<td align='right'>$fil_item[1]</td>";
					echo "<td></td><td></td>";
					echo "<td align='center'>$aux</td>";
					echo "<td align='right'>$precio</td>";
					echo "<td align='center'>";
						echo "<a href='eliminar_item_comercial.php?id_comercial=$id_comercial&id_producto=$fil_item[3]&tipent=$tipent&recuperacion=$fil_item[4]&bonificacion=$fil_item[5]&efectivo=$fil_item[6]'><img src='imagenes/eliminar.png' border='0'></a>";
					echo "</td>";
				echo "</tr>";
		}
		if($fil_item[4] == 1){
			echo "<tr style='font-size:11px'>";
				echo"<td>$fil_item[0]</td>";
				echo"<td align='right'>$fil_item[1]</td>";
				echo"<td bgcolor='#FF8282' align='center'>-X-</td>";
				echo"<td align='center'>-</td>";
				echo"<td align='center'>$aux</td>";
				echo"<td align='center'>-</td>";
				echo"<td align='center'><a href='eliminar_item_comercial.php?id_comercial=$id_comercial&id_producto=$fil_item[3]&tipent=$tipent&recuperacion=$fil_item[4]&bonificacion=$fil_item[5]&efectivo=$fil_item[6]'><img src='imagenes/eliminar.png' border='0'></a></td>";
			echo"</tr>";
		}
		if($fil_item[5] == 1){
			echo "<tr style='font-size:11px'>";
				echo "<td>$fil_item[0]</td>";
				echo "<td align='right'>$fil_item[1]</td>";
				echo "<td></td>";
				echo "<td bgcolor='#00CC66' align='center'>-X-</td>";
				echo "<td align='center'>$aux</td>";
				echo "<td align='center'>-</td>";
				echo "<td align='center'>";
					echo "<a href='eliminar_item_comercial.php?id_comercial=$id_comercial&id_producto=$fil_item[3]&tipent=$tipent&recuperacion=$fil_item[4]&bonificacion=$fil_item[5]&efectivo=$fil_item[6]'><img src='imagenes/eliminar.png' border='0'></a>";
				echo "</td>";
			echo "</tr>";
		}
	};
  ?>
  <tr bgcolor="#CC9933" style="font-style:inherit">
    <td colspan="2"><div align="right" class="style1">Total:</div></td>
    <td width="43" align="right" style="font-size:12px">&nbsp;</td>
    <td width="36" align="right" style="font-size:12px">&nbsp;</td>
    <td width="39" align="right" style="font-size:12px">&nbsp;</td>
    <td width="39" align="right" style="font-size:12px"><span class="style1"><? $prec_tot = number_format($prec_tot, 2, '.',',');; echo $prec_tot?></span></td>
    <td width="48"><span class="style1"></span></td>
  </tr>	
</table>
</body>
</html>
<?php
ob_end_flush();
?>