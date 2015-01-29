<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	$id_proceso = $_GET['id_proceso'];
	$tipo_nota = $_GET['tipo_nota'];
	$conf = $_GET['conf'];
	
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
<h1>DETALLE MERMAS PRODUCTOS
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
<table width="41%" border="0">
  <tr>
    <td>Nota:</td>
      <td>
	  <? if ($conf==0){
      			$nn = $nombre_nota[0].' - '.'por conf.';}
			else {$nn = $nombre_nota[0];}
	  ?>
	  	<input type="hidden" name="tipo_nota" value="<? echo $tipo_nota?>">
		<input name="id_proceso" type="text" id="id_produccion" value="<? echo $id_proceso?>" size="3" style="text-align:right" readonly="">
		<input type='text' name='nombre_nota' value='<? echo $nn?>' size='30' readonly=''>
		<input name="acceso" type="hidden" id="id_proceso" value="<? echo $acceso?>">
	</td>
  </tr>
  <tr>
	<td>Fecha:</td>
	<?
		$datos_proc = mysqli_query($link,"Select Fecha, Detalle, IdDistribuidor, f_nombre_distribuidor(IdDistribuidor) from Procesos Where IdProceso = $id_proceso And tipoNota = $tipo_nota");
		
		$datos_proceso = mysqli_fetch_row($datos_proc);
	?>
	<td><INPUT NAME="fecha" TYPE="text" value="<? echo $datos_proceso[0]?>" size="10" readonly=""></td>
  </tr>
  <? if ($datos_proceso[2]<>0){
  echo "<tr><td>Distribuidor:</td><td><input name='distribuidor' type='text' id='distribuidor' size='30' value=' $datos_proceso[3]' readonly=''></td></tr>";
   }?>
  <tr>
    <td>Detalle:</td>
    <td><input name="detalle" type="text" value="<? echo $datos_proceso[1]?>" size="39" readonly=""></td>
  </tr>
</table>
<table width="30%" border="0">
  <tr bgcolor="#CC9933" align="center">
    <td width="10%"><span class="style2">Nº</span></td>
    <td width="50%" bgcolor="#CC9933"><span class="style2">Producto</span></td>
    <td width="20%"><span class="style2">Cantidad</span></td>
  </tr>
<?	
	$sql_item_proc = mysqli_query($link,"CALL sp_lista_item_proceso('$id_proceso','$tipo_nota')");
	$i = 1;
	while($fil_item_proc = mysqli_fetch_array($sql_item_proc)){
		echo "<tr style='font-size:11px'><td align='right'>$i</td><td>$fil_item_proc[3]</td><td align='right'>$fil_item_proc[4]</td></tr>";
		$i++;
	}
?>
<tr bgcolor='#CC9933' align='center' height='3'><td colspan='3'></td></tr>
</table>
</body>
</html>
<?php
ob_end_flush();
?>
