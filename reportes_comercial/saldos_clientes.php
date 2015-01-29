<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];

	include("../autenticacion.php");
	require('menu.php');
	echo "<br>";
	require('menu_reporte.php');
	include('../conexion.php');
	$link = conexion();
?>
<html>
<head>
<script type="text/javascript">
	function bloqueoCliente(esto,id1,id2){
		if(esto.checked){
			id1=document.getElementById(id1);
			id1.disabled=false;
			
			id2=document.getElementById(id2);
			id2.disabled=true;
		}
		else
	 	{
			id1=document.getElementById(id1);
			id1.disabled=true;				

			id2=document.getElementById(id2);
			id2.disabled=false;				
		}
	}
</script>
<title>Saldos Clientes</title>
<style type="text/css">
<!--
#Layer1 {position:absolute;
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
<h1>
  <?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
SALDOS CLIENTES </h1>
<form action="reporte_saldos_clientes.php" method="post" name="form1" id="form1">
  <table width="634" border="0">
    <tr>
      <td>Saldo Inicial: </td>
      <td><input name="saldo_inicial" type="checkbox" id="saldo_inicial" onClick="bloqueoCliente(this,'cliente','distribuidor')" value="1"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="95">Hasta Fecha:</td>
      <td width="35">&nbsp;</td>
      <td width="490"><select name="canno" id="canno">
        <option value="0" selected="selected">Selec.</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		<option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		<option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
		<option value="2012"<? if($fil_fecha[0]==2012){?>selected<? }?>>2012</option>
    <option value="2013"<? if($fil_fecha[0]==2013){?>selected<? }?>>2013</option>
    <option value="2014"<? if($fil_fecha[0]==2014){?>selected<? }?>>2014</option>
    <option value="2015"<? if($fil_fecha[0]==2015){?>selected<? }?>>2015</option>
      </select>
          <select name="cmes" id="select2">
            <option value="0" selected="selected">Selec.</option>
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
          <select name="cdia" id="select3">
            <option value="0" selected="selected">Selec.</option>
            <?
		  	$d = 1;
			while ($d <= 31){
				if ($fil_fecha[2] == $d){ 
					echo "<option value='$d' selected='selected'>$d</option>";
				}
				else { 
					echo "<option value='$d'>$d</option>";
				}
				$d = $d + 1;
			}
		    ?>
        </select></td>
    </tr>
    <tr>
      <td>Cliente:</td>
      <td><label>
        <input name="control" type="checkbox" id="control" onClick="bloqueoCliente(this,'cliente','distribuidor')" value="1"  checked="checked">
      </label></td>
      <td>
	  <select name="cliente" id="cliente">"
		<option value="0">-</option>
	  	<?
   			$sql_cli = mysqli_query($link,"SELECT idCliente, nombreCliente, SUBSTRING(codigoCliente,4) FROM clientes WHERE codigoCliente LIKE 'CL%'ORDER BY nombreCliente");	    
			while ($fil_cli = mysqli_fetch_array($sql_cli)){
				echo "<option value='$fil_cli[0]'>$fil_cli[1]</option>";
			}
	  	?>	  
	  </select>	  </td>
    </tr>
    <tr>
      <td>Distribuidor: </td>
      <td>&nbsp;</td>
      <td><select name="distribuidor" id="distribuidor" disabled="disabled">
        <?	
	  		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE flag = 1 ORDER BY NombreDistribuidor");
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
			}
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
