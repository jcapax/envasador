<?php
ob_start();
?> <?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();
	
	$id_comercial = hexdec($_GET['id_comercial']);
	
	if ($_POST){
		
	}

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	
	if (($acceso < 8) AND ($acceso <> 1)){
		echo "<h2>Zona restringida!!!</h2>";
		die;
	}
?>
<html>
<head>
<title>Edición Nota Comercial</title>
</head>

<script type="text/javascript">
	function bloqueoFechaCredito(esto,id1){
		if(esto.checked){
			id1=document.getElementById(id1);
			id1.disabled=true;
		}
		else
	 	{
			id1=document.getElementById(id1);
			id1.disabled=false;				
		}
	}
</script>

<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<style type="text/css">
@import "js/jquery.datepick.css";.style1 {color: #993366}
</style> 
<script type="text/javascript">
$(function() {	
		$('#fecha_credito').datepick();
	});
</script>

<body>
        <p>
          <?
	$ant = mysqli_query($link,"SELECT c.idComercial,c.notaVenta,c.fecha,f_nombre_cliente(c.idCliente) cliente,f_nombre_distribuidor(c.idDistribuidor) distribuidor, nombreTipoEvento, c.tipoEntrega, c.fechacredito FROM comercial c join tipoEventos t on c.idtipoEvento = t.idTipoEvento WHERE c.idComercial = '$id_comercial' AND c.estado = 0;");
	echo "<br>";
	echo "<table border = '0'>";
	echo "<tr bgcolor='#CCCCCC' style='font-size:14px'>";
		echo "<td>ID</td>";
		echo "<td>Nota Venta</td>";
		echo "<td>Fecha</td>";
		echo "<td>Cliente</td>";
		echo "<td>Distribuidor</td>";
		echo "<td>Tipo Evento</td>";
		echo "<td>Detalle</td>";
		echo "<td>Contado</td>";
		echo "<td>Fecha Credito</td>";
	echo "</tr>";
	while($det_comercial = mysqli_fetch_array($ant)){
		echo "<tr style='font-size:10px'>";
			echo "<td>$det_comercial[idComercial]</td>";
			echo "<td>$det_comercial[notaVenta]</td>";
			echo "<td>$det_comercial[fecha]</td>";
			echo "<td>$det_comercial[cliente]</td>";
			echo "<td>$det_comercial[distribuidor]</td>";
			echo "<td>$det_comercial[nombreTipoEvento]</td>";
			echo "<td>$det_comercial[detalle]</td>";
			if ($det_comercial[tipoEntrega] == 1){echo "<td align='center'> X </td>";}
			else{echo "<td></td>";}
			echo "<td>$det_comercial[fechacredito]</td>";
		echo "</tr>";
	}	
	echo "</table>"."<br>";
?>
        </p>
        <form name="form1" method="post" action="editar_comercial_post.php">
          <table width="705" border="0">
            <tr>
              <td width="98">Fecha:</td>
              <td colspan="3">
                  <select name="canno" id="canno">
                    <option value="0" selected>Selec.</option>
                    <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
                    <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
					           <option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
                    <option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
					          <option value="2012"<? if($fil_fecha[0]==2012){?>selected<? }?>>2012</option>
                    <option value="2013"<? if($fil_fecha[0]==2013){?>selected<? }?>>2013</option>
                    <option value="2014"<? if($fil_fecha[0]==2014){?>selected<? }?>>2014</option>
                    <option value="2015"<? if($fil_fecha[0]==2015){?>selected<? }?>>2015</option>
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
              </td>
            </tr>
            <tr>
              <td>Nota Venta: </td>
              <td colspan="3"><label>
                <input name="nota_venta" type="text" id="nota_venta">
                <input name="id_comercial" type="hidden" id="id_comercial" value="<? echo $id_comercial?>">
              </label></td>
            </tr>
            <tr>
              <td>Cliente:</td>
              <td colspan="3"><label>
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
              <a href="codificar_clientes.php"></a> <a href="codificar_clientes.php"><img src="imagenes/llave.png" width="30" height="27" border="0"></a></label></td>
            </tr>
            <tr>
              <td>Distribuidor:</td>
              <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	 ?>
              <td colspan="3"><select name="idDistribuidor" id="idDistribuidor">
                  <option value="0">Seleccionar</option>
                  <? while ($fil_dist = mysqli_fetch_array($sql_dist)){
			echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
		}?>
              </select></td>
            </tr>
            <tr>
              <td>Tipo Evento</td>
              <td colspan="3">
              	<?
					$sql_eve = mysqli_query($link,"SELECT * FROM tipoEventos");
					echo "<select name='tipo_evento' id='tipo_evento' style='font-size:12px'>";
        			echo "<option value='0'>Seleccionar</option>"; 
					while ($eve = mysqli_fetch_array($sql_eve)){
	    		    	echo "<option value='$eve[0]'>$eve[1]</option>";
				    }
				?>
              </td>
            </tr>
            <tr>
              <td>Detalle</td>
              <td colspan="3"><input name="detalle" type="text" id="detalle" style="font-size:12px" size="70" maxlength="70"></td>
            </tr>
            <tr>
              <td>Contado</td>
              <td width="44"><select name="tipoEntrega" id="tipoEntrega" style="font-size:12px">
                <option value="0">Cr&eacute;dito</option>
                <option value="1" selected>Contado</option>
                <option value="2">Consignaci&oacute;n</option>
                <option value="3">Obsequios</option>
                <option value="4">Bonificacion</option>
                <option value="5">Prestamo Barriles</option>
                <option value="6">Prestamo de Activos</option>
                <? while ($fil_dist = mysqli_fetch_array($sql_dist)){
			echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
		}?>
              </select></td>
              <td width="110">Fecha Cr&eacute;dito</td>
              <td width="435"><input name="fecha_credito" type="text" disabled id="fecha_credito" size="8" maxlength="10"></td>
            </tr>
            <tr>
              <td><input type="submit" name="Submit" value="Actualizar"></td>
              <td colspan="3">&nbsp;</td>
            </tr>
          </table>
</form>
</body>
</html>
<?php
ob_end_flush();
?>