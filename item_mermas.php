<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$producto = $_POST['producto'];	
	$cantidad = $_POST['cantidad'];
	
	if (!$_POST){
		$id_merma = $_GET['id_merma'];
		$tipo_merma = $_GET['tipo_merma'];
	}
	else{ 
		$id_merma = $_POST['id_merma'];
		$tipo_merma = $_POST['tipo_merma'];
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
<h1>MERMAS POR PRODUCTOS </h1>
<form name="form1" method="post" action="item_mermas.php">
  <table width="517" border="0">
      <tr>
        <td width="82">Tipo Merma </td>
        <td width="425">
		<? 
			if($acceso == 2){
				$mermas = mysqli_query($link,"Select tipoMerma, nombreMerma From tipoMermas WHERE tipoNota = 1");
			}
			if($acceso == 3){
				$mermas = mysqli_query($link,"Select tipoMerma, nombreMerma From tipoMermas WHERE tipoNota = 3");
			}
		?>
          <select name="tipo_merma" id="tipo_merma">
          <option value="0">Seleccionar</option>
          <? while($tmermas = mysqli_fetch_array($mermas)){
	  	echo "<option value='$tmermas[0]'>$tmermas[1]</option>";
	  }?>
        </select>
        <input name="id_merma" type="hidden" id="id_merma" value="<? echo $id_merma?>"></td>
      </tr>
      <tr>
        <td>Producto</td>
        <td><?
		if($acceso == 2){
			$prod = mysqli_query($link,'SELECT IdProducto, NombreProducto, TipoProducto FROM productos WHERE tipoProducto IN(5,6)');
		}
		else{
			$prod = mysqli_query($link,'SELECT IdProducto, NombreProducto, TipoProducto FROM productos WHERE tipoProducto NOT IN(5,6)');
		}
	?>
          <select name="producto" id="producto">
            <option value="0">Seleccionar</option>
            <? while($lprod = mysqli_fetch_array($prod)){
	  	echo "<option value='$lprod[0]'>$lprod[1]</option>";
	  }?>
          </select></td>
      </tr>
      <tr>
        <td>Cantidad</td>
        <td><input name="cantidad" type="text" id="cantidad" size="4" maxlength="4"></td>
      </tr>
      <tr>
        <td><label>
          <input name="submit" type="submit" id="submit" value="Guardar">
        </label></td>
        <td>&nbsp;</td>
      </tr>
  </table>
</form>
<p>
  <?	
	if(!(($producto == 0) or ($tipo_merma == 0))){
		$ins_mermas = mysqli_query($link,"INSERT INTO itemMermaProductos(idMerma, tipoMerma, idProducto, cantidad) VALUES('$id_merma', '$tipo_merma', '$producto', '$cantidad')");
	}
?>
</p>

<table width="485" border="0">
  <tr bgcolor="#CC9933">
    <td width="126" bgcolor="#CC9933"><span class="style1">Tipo Merma </span></td>
    <td width="214"><span class="style1">Producto</span></td>
    <td width="63"><span class="style1">Cantidad</span></td>
    <td width="52"><span class="style1">Eliminar</span></td>
  </tr>
  <? 
  	$mermas = mysqli_query($link,"SELECT idMerma,m.nombreMerma,p.nombreProducto,cantidad, i.tipoMerma,i.idProducto FROM itemMermaProductos i JOIN productos p ON i.idProducto = p.idProducto JOIN tipoMermas m ON i.tipoMerma = m.tipoMerma WHERE idMerma = '$id_merma'");
  	while($lista_mermas = mysqli_fetch_array($mermas)){
		echo "<tr style='font-size:11px'><td>$lista_mermas[1]</td><td>$lista_mermas[2]</td><td align='right'>$lista_mermas[3]</td><td align='center'><a href='eliminar_item_merma.php?id_merma=$lista_mermas[0]&tipo_merma=$lista_mermas[4]&id_producto=$lista_mermas[5]'><img src='imagenes/eliminar.png' border='0'></a></td></tr>";
	};
  ?>
</table>
</body>
</html>
<?php
ob_end_flush();
?>