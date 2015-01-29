<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

	$tamano_pagina = 25;
	
	$cliente = hexdec($_GET['cliente']);
	
	$pagina = $_GET['pagina'];
	if (!$pagina) {
	    $inicio = 0;
    	$pagina=1;
	}
	else {
    	$inicio = ($pagina - 1) * $tamano_pagina ;
	}
	
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	
	if(($acceso == 5)or($acceso == 6)){
		header("Location: reportes_comercial/index.php");
	}
	
	if (($acceso < 8) AND ($acceso <> 1)){
			echo "<h2>ZONA RESTRINGIDA!!!</h2>";
			die;
	}
	
	$registros = mysqli_query($link,"Select Count(*) From comercial");
	$total_reg = mysqli_fetch_array($registros);
	$total_paginas = ceil($total_reg[0]/$tamano_pagina);
?>
<html>
<head>
<title>COMERCIALIZACION</title>
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
.style2 {color: #FF0000}
.style3 {
	font-size: 22px;
	font-weight: bold;
}
-->
</style>
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
</head>
<body>
<div id="Layer1">
  <table width="126%" style="font-size:11px" border="0">
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
<h1>COMERCIALIZACI&Oacute;N </h1>
<h5><span class="style2"><a href="saldos/saldos_comercial.php">[Saldos Iniciales Clientes]</a></span></h5>
<form name="form1" method="post" action="msg_comercial.php">
  <table width="707" border="0">
    <tr>
      <td width="93">Fecha:</td>
      <td colspan="3"><? 
        if ($acceso == 1){ $tipo_nota = 4;} 	  
		if ($acceso == 2){ $tipo_nota = 1;}
		if ($acceso == 3){ $tipo_nota = 3;}
		if ($acceso == 4){ $tipo_nota = 4;}
	  ?>
        <select name="canno" id="canno" style="font-size:12px">
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
        <select name="cmes" id="cmes" style="font-size:12px">
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
        <select name="cdia" id="cdia" style="font-size:12px">
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
	  <? 
			if ($acceso<>1){echo "<input name='tipo_nota' type='hidden' id='tipo_nota' value='$tipo_nota'>";}
		?>	  </td>
    </tr>
    <tr>
      <td>Nota Venta: </td>
      <td><label>
        <input name="nota_venta" type="text" id="nota_venta" style="font-size:12px">
      </label></td>
      <td>N&ordm; Nota</td>
      <td><input name="nroNota" type="text" id="nroNota" value="0" size="10" maxlength="10"></td>
    </tr>
    <tr>
      <td>Cliente:</td>
      <td colspan="3">
      <?
   		$sql_cli = mysqli_query($link,"SELECT idCliente, nombreCliente, SUBSTRING(codigoCliente,4) AS codAnterior, codigoCliente, substring(codigoCliente, 1, 3) as letras FROM clientes ORDER BY nombreCliente");
//   		$sql_cli = mysqli_query($link,"SELECT idCliente, nombreCliente, SUBSTRING(codigoCliente,4) FROM clientes WHERE codigoCliente LIKE 'CL%'ORDER BY nombreCliente");
	  ?>
	    <select name="idCliente" id="idCliente" style="font-size:12px">
			<option value="0">Seleccionar</option>
			<? while ($fil_cli = mysqli_fetch_array($sql_cli)){					
				
				if($fil_cli['letras']=="CL-"){
					$cli = $fil_cli[2].' - '.$fil_cli[1];
					?>
					<option value="<? echo $fil_cli[0]?>"<? if($fil_cli[0]==$cliente){?>selected<? }?>><? echo $cli?></option>
					<?		
				}
				else{
					$cli = $fil_cli['codigoCliente'].' - '.$fil_cli['nombreCliente'];
					?>
					<option value="<? echo $fil_cli[0]?>"<? if($fil_cli[0]==$cliente){?>selected<? }?>><? echo $cli?></option>
					<?		
				}
			}
		?>
        </select>
      <a href="auxiliares/buscador_clientes.php"><img src="imagenes/buscador.JPG" alt="Buscador" width="23" height="20" border="0"></a> <a href="codificar_clientes.php"></a>	  <a href="codificar_clientes.php?tipoR=I"><img src="imagenes/mas.JPG" alt="Codificar" width="19" height="14" border="0"></a></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
	  <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	 ?>
      <td colspan="3"><select name="idDistribuidor" id="idDistribuidor" style="font-size:12px">
        <option value="0">Seleccionar</option>
		<? while ($fil_dist = mysqli_fetch_array($sql_dist)){
			echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
		}?>
      </select></td>
    </tr>
    <tr>
      <td><label>Tipo Evento </label></td>
	  <?
	  	$sql_eve = mysqli_query($link,"SELECT * FROM tipoEventos");
	  ?>
      <td colspan="3">	  	
        <?
			echo "<select name='tipo_evento' id='tipo_evento' style='font-size:12px'>";
        	echo "<option value='0'>Seleccionar</option>"; 
			while ($eve = mysqli_fetch_array($sql_eve)){
	        	echo "<option value='$eve[0]'>$eve[1]</option>";
		    }
		?>
        </select>	  </td>
    </tr>
    <tr>
      <td>Detalle</td>
      <td colspan="3"><input name="detalle" type="text" id="detalle" style="font-size:12px" size="70" maxlength="70"></td>
    </tr>
    <tr>
      <td>Contado </td>
      <td width="166"><select name="tipoEntrega" id="tipoEntrega" style="font-size:12px">
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
      <td width="72">Fecha Cr&eacute;dito</td>
      <td width="358"><input name="fecha_credito" type="text" disabled id="fecha_credito" size="8" maxlength="10"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
</form>
<? 
  	echo "Página: ";
  	if ($total_paginas > 1){
    for ($i=1;$i<=$total_paginas;$i++){
       if ($pagina == $i)
          //si muestro el índice de la página actual, no coloco enlace
		  echo "<span class='style3'>$pagina</span> ";
//          echo $pagina . " "; 		  
       else{
          //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
          echo "<a href='comercial.php?pagina=$i'  style='font-size:12px'>$i</a> ";
		}	 
    }
	} 
?>
<table width="879" border="0">
  <tr bgcolor="#CC9933">
    <td width="25"><span class="style1">N&deg;</span></td>
    <td width="111"><span class="style1">Nota Entrega</span></td>
    <td width="84"><span class="style1">Fecha</span></td>
    <td width="211" bgcolor="#CC9933"><span class="style1">Cliente</span></td>
    <td width="209"><span class="style1">Distribuidor</span></td>
    <td width="53"><span class="style1">Tipo Ent</span></td>
    <td width="51"><span class="style1">Imprimir</span></td>
	<td width="36"><span class="style1">Editar</span></td>
	<td width="61"><span class="style1">Confirmar</span></td>
  </tr>
  <?
 		$sel = "SELECT idComercial, notaVenta, fecha, nombreCliente, nombreDistribuidor, c.estado, c.tipoEntrega FROM comercial c JOIN clientes l USING(idCliente) JOIN distribuidores d ON d.idDistribuidor = c.idDistribuidor"; 
		$lim = " LIMIT $inicio,$tamano_pagina";
		$ord = " ORDER BY idComercial DESC, fecha DESC";
		
		$sql = $sel.''.$ord.''.$lim;		
		$com = mysqli_query($link,$sql);				
		while($lcom = mysqli_fetch_array($com)){
			$idCom = dechex($lcom[0]);
			if ($lcom[estado]==0){				
				echo "<tr style='font-size:11px'>";
					echo "<td><a href=editar_comercial.php?id_comercial=$idCom>$lcom[idComercial]</a></td>";
					echo "<td>$lcom[notaVenta]</td>";
					echo "<td>$lcom[fecha]</td>";
					echo "<td>$lcom[nombreCliente]</td>";
					echo "<td>$lcom[nombreDistribuidor]</td>";
					switch($lcom[tipoEntrega]){
						case 0: 
							echo "<td align='center'>Credito</td>";
							break;
						case 1: 
							echo "<td align='center'>Contado</td>";
							break;
						case 2: 
							echo "<td align='center'>Consignación</td>";
							break;							
						case 3: 
							echo "<td align='center'>Obsequios</td>";
							break;							
						case 4: 
							echo "<td align='center'>Bonificacion</td>";
							break;							
					}
					echo "<td align='center'>";
						echo "<a href='impre_comer.php?id_comercial=$idCom&nota_venta=$lcom[1]&fecha=$lcom[2]&n_cliente=$lcom[3]&n_distribuidor=$lcom[4]&estado=$lcom[5]'><img src='imagenes/impresora.gif' border='0'></a>";
					echo "</td>";
					echo "<td align='center'><a href='item_comer.php?id_comercial=$idCom&tipent=$lcom[tipoEntrega]'>";
						echo "<img src='imagenes/editar.gif' border='0'></a>";
					echo "</td>";
					echo "<td align='center'><a href='confirmar_comercial.php?id_comercial=$idCom'><img src='imagenes/ok.gif' border='0'></a></td>";
				echo "</tr>";
			}
			else{
				echo "<tr style='font-size:11px' bgcolor='#C6FBAC'>";
					echo "<td>$lcom[idComercial]</td>";
					echo "<td>$lcom[notaVenta]</td>";
					echo "<td>$lcom[fecha]</td>";
					echo "<td>$lcom[nombreCliente]</td>";
					echo "<td>$lcom[nombreDistribuidor]</td>";
					switch($lcom[tipoEntrega]){
						case 0: 
							echo "<td align='center'>Credito</td>";
							break;
						case 1: 
							echo "<td align='center'>Contado</td>";
							break;
						case 2: 
							echo "<td align='center'>Consignación</td>";
							break;							
						case 3: 
							echo "<td align='center'>Obsequios</td>";
							break;							
						case 4: 
							echo "<td align='center'>Bonificacion</td>";
							break;							
					}
/*					if ($lcom[tipoEntrega] == 1){
						
						echo "<td align='center'>X</td>";
					}
					else{
						echo "<td></td>";
					}					
*/
					echo "<td align='center'>";
						echo "<a href='impre_comer.php?id_comercial=$idCom&nota_venta=$lcom[1]&fecha=$lcom[2]&n_cliente=$lcom[3]&n_distribuidor=$lcom[4]&estado=$lcom[5]'><img src='imagenes/impresora.gif' border='0'></a>";
					echo "</td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
			}
		}
  ?>
</table>
</body>
</html>
<?php
ob_end_flush();
?>