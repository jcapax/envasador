<?php
ob_start();
?> 
<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	echo "<br>";
	require('menu_reportes.php');
	include('../conexion.php');
	$link = conexion();

	if ($_POST){
		$fecha1 = $_POST["fecha1"];
		$fecha2 = $_POST["fecha2"];
		$tipo_nota = $_POST["tipo_nota"];
		$distribuidor = $_POST["distribuidor"];
	}
?>
<html>
<head>
<title>Recepción de Envases</title>
<style type="text/css">
<!--
#Layer1 {	position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
.Estilo1 {color: #FFFFFF}
-->
</style>
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<style type="text/css">@import "../js/jquery.datepick.css";</style> 
<script type="text/javascript">
$(function() {	
		$('#fecha1').datepick();
	});
$(function() {	
		$('#fecha2').datepick();
	});
</script>
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
  </table>
</div>
<h1>REPORTE RECEPCI&Oacute;N DE ENVASES </h1>
<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<form name="form1" method="post" action="recep_envases.php">
  <table width="466" border="0">
    <tr>
      <td width="81">Fecha Inicio:</td>
      <td width="375"><input name="fecha1" type="text" id="fecha1" size="10" maxlength="12">
      </td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><input name="fecha2" type="text" id="fecha2" size="10" maxlength="12">
      </td>
    </tr>
    <tr>
      <td>Tipo Nota: </td>
		<?
			if ($acceso==1){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");				
				}

			if ($acceso==2){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 1 AND 2");				
				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 2");				
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 4");				
				}

			if ($acceso==6){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota IN(1,2)");				
				}
		?>
      <td><select name="tipo_nota" id="tipo_nota">
        <option value='0'>Seleccionar</option>
        <?
			while($fil_notas = mysqli_fetch_array($sql_notas)){
				?>
        <option value='<? echo $fil_notas[0]?>'><? echo $fil_notas[1]?></option>
        <?
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
	  <? $sql_dist = mysqli_query($link,"SELECT idDistribuidor, nombreDistribuidor FROM distribuidores ORDER BY nombreDistribuidor");?>
	  <td><select name="distribuidor" id="distribuidor">
        <?	
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<h3>RECEPCION DE DE ENVASES</h3>
<p>Entre: 	
  <input type="text" size="7" maxlength="10" value="<? echo $fecha1;?>" readonly="" style="text-align:right">
  y el: 
  <input type="text" size="7" maxlength="10" value="<? echo $fecha2;?>" readonly="" style="text-align:right">
</p>
<table width="900" border="0">
  <tr align="center" bgcolor="#CC9933">    
    <td width="80" rowspan="2"><span class="Estilo1">Nota</span></td>
	<td width='233' rowspan='2'><span class='Estilo1'>Distribuidor</span></td>
    <td width="80" rowspan="2"><span class="Estilo1">Fecha</span></td>
    <td width="123" rowspan="2"><span class="Estilo1">Fecha Hora Registro </span></td>
    <td width="230" rowspan="2"><span class="Estilo1">Detalle</span></td>
    <td colspan="2"><div align="center" class="Estilo1">Envases</div></td>
  </tr>
  <tr bgcolor="#F3EA72">
    <td width="46">Botel.</td>
    <td width="53">Canas.</td>
  </tr>
  <?  	 
    $s_bot = 0;
	$s_caj = 0;

  	if ($_POST){	
   		$sql_enva = mysqli_query($link,"CALL sp_envases('$fecha1','$fecha2','$tipo_nota','$distribuidor')");
	
		while($fil_enva = mysqli_fetch_array($sql_enva)){
			if($distribuidor==0){
				echo "<tr style='font-size:11px'>";
//					echo "<td>$fil_enva[1]</td>";
					echo "<td align='right'>$fil_enva[idProceso]</td>";
					echo "<td>$fil_enva[2]</td>";
					echo "<td>$fil_enva[3]</td>";
					echo "<td>$fil_enva[4]</td>";
					echo "<td>$fil_enva[5]</td>";
					echo "<td align='right'>$fil_enva[6]</td>";
					echo "<td align='right'>$fil_enva[7]</td>";
					$s_bot = $s_bot + $fil_enva[6];
					$s_caj = $s_caj + $fil_enva[7];
				echo "</tr>";
			}
			else {
				echo "<tr style='font-size:11px'>";
					echo "<td align='right''>$fil_enva[0]</td>";
					echo "<td>$fil_enva[Distribuidor]</td>";
					echo "<td>$fil_enva[2]</td>";
					echo "<td>$fil_enva[3]</td>";
					echo "<td>$fil_enva[4]</td>";
					echo "<td align='right'>$fil_enva[5]</td>";
					echo "<td align='right'>$fil_enva[6]</td>";
					//echo "<td align='right'>$fil_enva[7]</td>";
					$s_bot = $s_bot + $fil_enva[5];
					$s_caj = $s_caj + $fil_enva[6];
				echo "</tr>";
			}
	}		
		}
  ?>
  <tr bgcolor="#F3EA72" align="right" style='font-size:11px'>
    <td colspan="5"><strong>TOTAL</strong></td>
    <td><strong><? echo $s_bot?></strong></td>
    <td><strong><? echo $s_caj?></strong></td>
  </tr>
</table>
<?php
ob_end_flush();
?>
</body>
</html>

