<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	$fecha = $fil_fecha[0].'-'.$fil_fecha[1].'-'.$fil_fecha[2];
?>
<html>
<head>
<title>Descuento de Productos</title>
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
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<style type="text/css">@import "js/jquery.datepick.css";</style> 
<script type="text/javascript">
$(function() {	
		$('#fecha').datepick();
	});
</script>
</head>
<body>
<?
    $flag = 0;
    for($i=0;$i<count($rol);$i++){
        if(($rol[$i] == '9')or($rol[$i] == '10')){
            //echo "exito";	
			$acceso = $rol[$i];					
            $flag = 1;
        }
    }
    if($flag == 1){
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
<h1>MERMAS - DESCUENTOS RECEP.</h1>

<form name="form1" method="post" action="msg_mermas.php">
  <table width="568" border="0">
    <tr>
      <td>Tipo Nota </td>
      <td><select name="tipo_nota" id="tipo_nota">
		<?
			if($acceso == 9){echo "<option value='3'>MERMAS</option>";}
			if($acceso == 10){echo "<option value='1'>DESCUENTOS RECEP.</option>";}
		?>		
          </select>
    </tr>
    <tr>
      <td width="103">Fecha</td>
      <td width="497"><input name="fecha" type="text" id="fecha" value="<? echo $fecha?>" size="10" maxlength="10" style="text-align:right"></td>
    </tr>
    <tr>
      <td>Detalle</td>
      <td><input name="detalle" type="text" id="detalle" size="75" maxlength="100"></td>
    </tr>
    <tr>
      <td><label>
        <input type="submit" name="Submit" value="Enviar">
      </label></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<table width="492" border="0">
  <tr bgcolor="#CC9933">
    <td width="33"><span class="style1">N&deg;</span></td>
    <td width="63"><span class="style1">Fecha</span></td>
    <td width="191"><span class="style1">Detalle</span></td>
    <td width="60"><span class="style1">Imprimir</span></td>
    <td width="72"><span class="style1">Confirmar</span></td>
    <td width="47"><span class="style1">Editar</span></td>
  </tr>
  <?
		if($acceso == 9){
			$mer = mysqli_query($link,"SELECT * FROM mermaproductos ORDER BY fecha DESC");			
		}
		else{
			$mer = mysqli_query($link,"SELECT * FROM mermaproductos WHERE tipoNota = $tipo_nota ORDER BY fecha DESC");
		}
		while($lmer = mysqli_fetch_array($mer)){
			if ($lmer[6]==0){
				echo "<tr style='font-size:11px'><td>$lmer[0]</td><td>$lmer[1]</td><td>$lmer[3]</td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]'><img src='imagenes/impresora.gif' border='0'></a></td><td align='center'><a href='confirmar_merma.php?id_merma=$lmer[0]'><img src='imagenes/ok.gif' border='0'></a></td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]&tn=$lmer[tipoNota]'><img src='imagenes/editar.gif' border='0'></a></td></tr>";

			}
			else{
				echo "<tr style='font-size:11px' bgcolor='#C6FBAC'><td>$lmer[0]</td><td>$lmer[1]</td><td>$lmer[3]</td><td align='center'><a href='item_mermas.php?id_merma=$lmer[0]'><img src='imagenes/impresora.gif' border='0'></a></td><td align='center'></td><td></td></tr>";

			}
		}
  ?>
</table>
<?
    } //CON PERMISOS NECESARIOS PARA EJECUTAR
    else{
        echo "<h2>¡¡¡ZONA RESTRINGIDA!!!</h2>";
    }
?>
</body>
</html>