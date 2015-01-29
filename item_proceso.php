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
		$tipo_nota  = $_GET['tipo_nota'];

	}
	else{ 
		$id_proceso = $_POST['id_proceso'];
		$tipo_nota  = $_POST['tipo_nota'];
		$producto   = $_POST['producto'];
		$cantidad   = $_POST['cantidad'];		
	}

	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
?>
<html>
<head>
<title>Item Recepción</title>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
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
<h1>DETALLE PROCESOS
</h1>
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
<?
	$nombre_nota = mysqli_fetch_array(mysqli_query($link,"SELECT NombreNota FROM Notas WHERE TipoNota = '$tipo_nota'"));
?>
<form action="item_proceso.php" method="POST" name="form1">
  <table width="47%" border="0">
  <tr>
    <td>Id Nota </td>
    <td><input type="text" name="nombre_nota2" value="<? echo $id_proceso?>" size="5" readonly=""></td>
  </tr>
  <tr>
    <td>Tipo Nota:</td>
      <td>
	  	<input type="hidden" name="tipo_nota" value="<? echo $tipo_nota?>">
		<input name="id_proceso" type="hidden" id="id_produccion" value="<? echo $id_proceso?>">
		<input name="acceso" type="hidden" id="id_proceso" value="<? echo $acceso?>">
      <input type="text" name="nombre_nota" value="<? echo $nombre_nota[0]?>" size="30" readonly="">   </td>
    </tr>
  <tr>
  <td>
  <? 
  if($producto <> 0)
    {
		if($tipo_nota == 5){
			$cantidad = $cantidad * -1;
		}
		$sql = "INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota','$producto',$cantidad)";
		//echo $sql;
		//$ins_item_recep = mysqli_query($link,"INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota','$producto','$cantidad')");
		
		$ins_item_recep = mysqli_query($link,$sql);		

//***************************************************************************************************************
//*************** 		INGRESO AUTOMATICO CAJAS BOTELLAS		*********************************************
//***************************************************************************************************************		
		
		if(($acceso == 3)or($acceso == 4)){
			$del_botellas = mysqli_query($link,"DELETE FROM itemProceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto = 13");
			
			$sql_bot = mysqli_query($link,"SELECT SUM(cantidad) FROM itemProceso WHERE IdProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto IN(1,2,3,17)");
			$botellas = mysqli_fetch_array($sql_bot);
		
			$ins_item_recep = mysqli_query($link,"INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota',13,'$botellas[0]')");
		}

//***************************************************************************************************************			

		if($acceso == 3){
			$del_cajas = mysqli_query($link,"DELETE FROM itemProceso WHERE idProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto = 14");		
			
			$sql_cajas = mysqli_query($link,"SELECT SUM(cantidad) FROM itemProceso WHERE IdProceso = '$id_proceso' AND TipoNota = '$tipo_nota' AND idProducto IN(1,2,3,17)");
			$cajas = mysqli_fetch_array($sql_cajas);	

			$aux_cajas = intval($cajas[0]/12);
			
			$ins_item_prod = mysqli_query($link,"INSERT INTO itemproceso(idProceso,TipoNota,idProducto,Cantidad) VALUES('$id_proceso','$tipo_nota',14,'$aux_cajas')");
		}

//***************************************************************************************************************	
//***************************************************************************************************************		
	}
	if ($acceso == 2){
			$sql_productos = "SELECT IdProducto, NombreProducto, TipoProducto FROM productos p WHERE TipoProducto BETWEEN 5 AND 8 AND IdProducto NOT IN (SELECT IdProducto FROM ItemProceso WHERE IdProceso = $id_proceso AND TipoNota = $tipo_nota) ORDER BY tipoProducto";
		}

	if ($acceso == 3){
			$sql_productos = "SELECT IdProducto, NombreProducto, TipoProducto FROM productos p WHERE IdProducto NOT IN (SELECT IdProducto FROM ItemProceso WHERE IdProceso = $id_proceso AND TipoNota = $tipo_nota) ORDER BY tipoProducto";
		}
	
	if ($acceso == 4){
			$sql_productos = "SELECT IdProducto, NombreProducto, TipoProducto FROM productos p WHERE tipoProducto <> 5 AND IdProducto NOT IN (SELECT IdProducto FROM ItemProceso WHERE IdProceso = $id_proceso AND TipoNota = $tipo_nota) ORDER BY tipoProducto";
		}

	if ($acceso == 1){
			$sql_productos = "SELECT IdProducto, NombreProducto, TipoProducto FROM productos p WHERE IdProducto NOT IN (SELECT IdProducto FROM ItemProceso WHERE IdProceso = $id_proceso AND TipoNota = $tipo_nota) ORDER BY tipoProducto";
		}

//  	$sql_prod = mysqli_query($link,"CALL sp_lista_productos($acceso,$id_proceso,$tipo_nota)");
	$sql_prod = mysqli_query($link,$sql_productos);	
	?>
Producto:</td>
    <td><select name="producto" id="producto">
      <option value="0">Seleccionar</option>
      <?
		while($fil_prod = mysqli_fetch_array($sql_prod)){
		  echo "<option value='$fil_prod[0]'>$fil_prod[1]</option>";
		}
	?>
    </select></td>
    </tr>
  <tr>
    <td>Cantidad:</td>
    <td><input name="cantidad" type="text" id="cantidad"></td>
  </tr>
  <tr>
    <td><input name="submit" type="submit" id="submit" value="enviar"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<table width="38%" border="0">
  <tr bgcolor="#CC9933" align="center">
    <td width="61%" bgcolor="#CC9933"><span class="style2">Producto</span></td>
    <td width="21%"><span class="style2">Cantidad</span></td>
    <td width="18%"><span class="style2">Eliminar</span></td>
  </tr>
<?	
	$sql_item_proc = mysqli_query($link,"SELECT IdProceso, TipoNota, i.IdProducto, p.NombreProducto, i.Cantidad, p.TipoProducto FROM itemproceso i JOIN productos p ON i.IdProducto = p.IdProducto WHERE IdProceso = '$id_proceso' AND TipoNota = '$tipo_nota';");
	while($fil_item_proc = mysqli_fetch_array($sql_item_proc)){
		if (($acceso == 4)or($acceso == 3)){
			if ($acceso == 4){
					if($fil_item_proc[2]==13){
						echo "<tr style='font-size:11px'><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td><td align='center'></td></tr>";
					}
					else{
						echo "<tr style='font-size:11px'><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td><td align='center'><a href='eliminar_item_proceso.php?id_proceso=$id_proceso&tipo_nota=$tipo_nota&id_producto=$fil_item_proc[2]'><img src='imagenes/eliminar.png' border='0'></a></td></tr>";
					}						
			}
			if ($acceso == 3){
					if(($fil_item_proc[2]==13)or($fil_item_proc[2]==14)){
						echo "<tr style='font-size:11px'><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td><td align='center'></td></tr>";
					}
					else{
						echo "<tr style='font-size:11px'><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td><td align='center'><a href='eliminar_item_proceso.php?id_proceso=$id_proceso&tipo_nota=$tipo_nota&id_producto=$fil_item_proc[2]'><img src='imagenes/eliminar.png' border='0'></a></td></tr>";
					}						
			}
		}
		else{
			echo "<tr style='font-size:11px'><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td><td align='center'><a href='eliminar_item_proceso.php?id_proceso=$id_proceso&tipo_nota=$tipo_nota&id_producto=$fil_item_proc[2]'><img src='imagenes/eliminar.png' border='0'></a></td></tr>";

		}
	}

?>
<tr bgcolor="#CC9933" align="center" height="3"><td colspan="3"></td></tr>
</table>
<?php
ob_end_flush();
?>
</body>
</html>
