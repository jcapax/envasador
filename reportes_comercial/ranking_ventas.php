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

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);			
	
?>

<?
echo "<script language='JavaScript'>";

echo "function cambiar(){";
	echo " var index=document.forms.form1.tipo_reporte.selectedIndex; ";
	echo " form1.sub_reporte.length=0;";
	echo " if(index==0) clientes();";
	echo " if(index==1) calles();"; 
	echo " if(index==2) zonas();";
	echo " if(index==3) canal();";
	echo " if(index==4) tipo_local();";
	echo " if(index==5) rutas();";
echo "}";

echo "function clientes(){ opcion0=new Option('-','0','defauldSelected'); opcion1=new Option('Detalle Individual','1'); document.forms.form1.sub_reporte.options[0]=opcion0; document.forms.form1.sub_reporte.options[1]=opcion1; }";


//******************************************************************************************

echo "function rutas(){ "; 
echo "opcion0=new Option('-','0','defauldSelected');";
$cont_rutas = 1;
$sql_rutas = mysqli_query($link,"select ruta from clientes group by ruta order by ruta;");
while ($rutas = mysqli_fetch_array($sql_rutas)){
	echo "opcion".$cont_rutas."=new Option('$rutas[0]','$rutas[0]');";
	$cont_rutas ++;
}
echo "document.forms.form1.sub_reporte.options[0]=opcion0;";
for($i = 0; $i <= $cont_rutas; $i ++){
	echo "document.forms.form1.sub_reporte.options[$i]=".opcion.$i.";";
}

echo "}";

//******************************************************************************************

echo "function calles(){ "; 
echo "opcion0=new Option('-','0','defauldSelected');";
$cont_calles = 1;
$sql_calles = mysqli_query($link,"SELECT c.idCalle, CONCAT(c.nombreCalle,' - ',nombreZona) FROM calles c JOIN zonas z USING(idZona) GROUP BY c.idCalle, CONCAT(c.nombreCalle,' ',nombreZona) ORDER BY nombreCalle;");
while ($calles = mysqli_fetch_array($sql_calles)){
	echo "opcion".$cont_calles."=new Option('$calles[1]','$calles[0]');";
	$cont_calles ++;
}
echo "document.forms.form1.sub_reporte.options[0]=opcion0;";
for($i = 0; $i <= $cont_calles; $i ++){
	echo "document.forms.form1.sub_reporte.options[$i]=".opcion.$i.";";
}

echo "}";

//******************************************************************************************
echo "function zonas(){ "; 
echo "opcion0=new Option('-','0','defauldSelected');";
$cont_zonas = 1;
$sql_zonas = mysqli_query($link,"SELECT idZona, CONCAT(nombreZona,' - ',nombreLugar) FROM zonas z JOIN lugares l USING(idLugar) ORDER BY CONCAT(nombreZona,' - ',nombreLugar);");
while ($zonas = mysqli_fetch_array($sql_zonas)){
	echo "opcion".$cont_zonas."=new Option('$zonas[1]','$zonas[0]');";
	$cont_zonas ++;
}
echo "document.forms.form1.sub_reporte.options[0]=opcion0;";
for($i = 0; $i <= $cont_zonas; $i ++){
	echo "document.forms.form1.sub_reporte.options[$i]=".opcion.$i.";";
}

echo "}";
//******************************************************************************************

//echo "function zonas(){ opcion0=new Option('-','0','defauldSelected'); document.forms.form1.sub_reporte.options[0]=opcion0; }";
 
echo "function canal(){opcion0=new Option('-','0','defauldSelected'); opcion1=new Option('Comidas y Bebidas','1'); opcion2=new Option('Hogar','2'); opcion3=new Option('Servicios','3'); opcion4=new Option('Otros','4'); document.forms.form1.sub_reporte.options[0]=opcion0; document.forms.form1.sub_reporte.options[1]=opcion1; document.forms.form1.sub_reporte.options[2]=opcion2; document.forms.form1.sub_reporte.options[3]=opcion3;  document.forms.form1.sub_reporte.options[4]=opcion4; }";

echo "function tipo_local(){ opcion0=new Option('-','0','defauldSelected'); opcion1=new Option('Agencias','26'); opcion2=new Option('Bar','3'); opcion3=new Option('Chicharronerias','18'); opcion4=new Option('Cliente Particular','1'); opcion5=new Option('Karaokes','25'); opcion6=new Option('Licoreria','13'); opcion7=new Option('Mayorista','15'); opcion8=new Option('Pensión','20'); opcion9=new Option('Restaurant','24'); opcion10=new Option('Salon de Fiesta','2'); opcion11=new Option('Supermercado','19'); opcion12=new Option('Tienda','28');document.forms.form1.sub_reporte.options[0]=opcion0; document.forms.form1.sub_reporte.options[1]=opcion1; document.forms.form1.sub_reporte.options[2]=opcion2; document.forms.form1.sub_reporte.options[3]=opcion3; document.forms.form1.sub_reporte.options[4]=opcion4; document.forms.form1.sub_reporte.options[5]=opcion5; document.forms.form1.sub_reporte.options[6]=opcion6; document.forms.form1.sub_reporte.options[7]=opcion7; document.forms.form1.sub_reporte.options[8]=opcion8; document.forms.form1.sub_reporte.options[9]=opcion9; document.forms.form1.sub_reporte.options[10]=opcion10; document.forms.form1.sub_reporte.options[11]=opcion11; document.forms.form1.sub_reporte.options[12]=opcion12; document.forms.form1.sub_reporte.options[13]=opcion12;}";

echo "</script>";
//******************************************************************************************
?>
<html>
<head>
<title>Ranking Ventas - SIDS S.A.</title>
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
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<style type="text/css">
@import "../js/jquery.datepick.css";.style1 {color: #993366}
</style> 
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
    <tr>
      <td colspan="2"><a href='cambiar_contrasena.php'>Cambio Contrase&ntilde;a</a></td>
    </tr>
  </table>
</div>
<h1>RANKING DE VENTAS</h1>
<form name="form1" method="post" action="reporte_ranking.php">
  <table width="820" border="0">
    <tr>
      <td width="135"><span class="style1">Fecha Inicio:</span></td>
      <td width="220"><input name="fecha1" type="text" id="fecha1" size="8" maxlength="10"></td>
      <td width="165">&nbsp;</td>
      <td width="282">&nbsp;</td>
    </tr>
    <tr>
      <td class="style1">Fecha Final:</td>
      <td><input name="fecha2" type="text" id="fecha2" size="8" maxlength="10"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style1">Cantidad Registros  </td>
      <td><input name="cantidad" type="text" id="cantidad" value="25" size="8" maxlength="3" style="text-align:right"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td class="style1">Tipo Reporte </td>
      <td><select name="tipo_reporte" id="tipo_reporte" onChange="cambiar()">
        <option value="1" selected>Ranking de Clientes</option>
        <option value="2">Ranking por Calles</option>
        <option value="3">Ranking por Zonas</option>
        <option value="4">Ranking por Canal</option>
        <option value="5">Ranking por Tipo Local</option>
        <option value="6">Ranking por Ruta</option>
      </select></td>
      <td><select name="sub_reporte" id="sub_reporte">
        <option value="0">-</option>
        <option value="1">Detalle Individual</option>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style1">Distribuidor</td>
      <td colspan="3">
	  <? $sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE flag = 1 ORDER BY NombreDistribuidor");?>
	  <select name="distribuidor" id="distribuidor">
      <option value="0">-</option>
        <?	
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				?>
        <option value='<? echo $fil_dist[0]?>'><? echo $fil_dist[1]?></option>
        <?
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Consultar"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

