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

	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
	
	if (($acceso < 8) AND ($acceso <> 1)){
		echo "<h2>Zona restringida!!!</h2>";
		die;
	}
	if($_GET){
		$tipoR      = $_GET['tipoR'];
		$id_cliente = hexdec($_GET['id_cliente']);
		
	}
	else{
		$tipoR  = $_POST['tipoR'];
	}
	
	$id_cliente = hexdec($_GET['id_cliente']);
	
	if(($tipoR <> 'I')and($tipoR <> 'E')){
		echo '<br>'."Verificar Información!!!";
		die;
	}

	if ($_POST){
		$nombre_cliente = $_POST["cliente"];
		$lugar  = $_POST["lugar"];
		$zona   = $_POST["zona"];
		$calle  = $_POST["calle"];
		$numero = $_POST["numero"];
		$canal  = $_POST["canal"];
		$local  = $_POST["local"];
		$ruta   = $_POST["ruta"];		
		$id_cliente = $_POST['id_cliente'];
		
		if($lugar==0){
			echo "SELECCIONAR LUGAR!!!";
			die;
		}
		if($zona==0){
			echo "SELECCIONAR ZONA!!!";
			die;
		}
		if($calle==0){
			echo "SELECCIONAR CALLE!!!";
			die;
		}
		if($canal==0){
			echo "SELECCIONAR CANAL!!!";
			die;
		}
		if($local==0){
			echo "SELECCIONAR TIPO LOCAL!!!";
			die;
		}
		
		if($tipoR=='I'){
			$cc = mysqli_query($link,"SELECT (SUBSTRING(codigoCliente,4)+1) FROM clientes ORDER BY SUBSTRING(codigoCliente,4)+1 DESC LIMIT 1");
			$codaux = mysqli_fetch_array($cc);
			$codigo_cliente = 'CL-'.$codaux[0];
		
			mysqli_query($link,"INSERT INTO clientes(nombreCliente, codigoCliente, idLugar, idZona, idCalle, numero, idCanal, idlocal, tipoPrecio, fechaHoraRegistro, codigoUsuario, estado) VALUES('$nombre_cliente','$codigo_cliente','$lugar','$zona','$calle','$numero','$canal','$local',1,now(),'$codigo_usuario',0)");
		}
		
		if($tipoR=='E'){
			mysqli_query($link,"UPDATE clientes SET nombreCliente='$nombre_cliente',idLugar='$lugar',idZona='$zona',idCalle='$calle',numero='$numero',idCanal='$canal',idLocal='$local',ruta='$ruta' WHERE idCliente='$id_cliente'");
		}
		header("Location: comercial.php");
	}
?>
<html>
<head>
<?
echo "<script language='JavaScript'>";
echo "function LugarPadre(){";
	echo "document.forms.form1.zona.length = 0;";
	echo "opcion0=new Option('-','0','defauldSelected');";	
	
	$cont_zonas = 0;
	$cont_for   = 0;
	echo "contador_registros = 0;";
	
	$sql_zonas = mysqli_query($link,"SELECT idZona, nombreZona, idLugar FROM zonas WHERE idZona BETWEEN 60 AND 63;");
	
	echo "var index = document.forms.form1.lugar.selectedIndex;";
		
	echo "var arrayIdZona = new Array();";
	echo "var arrayNombreZona = new Array();";
	echo "var arrayIdLugar = new Array();";
	
	while ($zonas = mysqli_fetch_array($sql_zonas)){
		echo "arrayIdZona[".$cont_zonas."]=".$zonas[0].";";
		echo "arrayNombreZona[".$cont_zonas."]='".$zonas[1]."';";
		echo "arrayIdLugar[".$cont_zonas."]=".$zonas[2].";";
		$cont_zonas ++;
	}	

	for($i=0;$i<$cont_zonas;$i++){
		echo "if(arrayIdLugar[".$i."]==index){ contador_registros++; }";
	}

	echo "document.forms.f1.zona.length = contador_registros;";
	
	for($i=0;$i<$cont_zonas;$i++){
		echo "if(arrayIdLugar[".$i."]==index){";
				echo "document.forms.form1.zona[".$i."].value= arrayIdZona[".$i."];";
				echo "document.forms.form1.zona[".$i."].text = arrayNombreZona[".$i."];";				
				$cont_for++;
			echo "}";
	}	
echo "}";
echo "</script>";
?>
<title>Codificador de Clientes</title>
</head>
<body>
<br>
<?
	if($tipoR == 'I'){echo '<h1>'.'CODIFICADOR CLIENTES'.'</h1>';}
	else{
		if($tipoR == 'E'){
		echo '<h1>'.'EDICION CLIENTE'.'</h1>';
	
		$sel_cliente = mysqli_query($link,"SELECT idCliente, nombreCliente, nombreLugar, nombreZona, nombreCalle, numero, nombreCanal, nombreLocal, ruta FROM clientes c JOIN lugares USING(idLugar) JOIN zonas USING (idZona) JOIN calles USING (idCalle) JOIN canales USING (idCanal) JOIN locales USING (idLocal) WHERE idCliente = $id_cliente");
		
		echo "<table width='729' border='0'><tr bgcolor='#FFCC00' align='center'><td width='110'>Nombre Cliente</td><td width='87'>Lugar</td><td width='143'>Zona</td><td width='160'>Calle</td><td width='23'>N&ordm;</td><td width='57'>Canal</td><td width='81'>Tipo Local</td><td width='34'>Ruta</td></tr>";
		while($fil_cliente = mysqli_fetch_array($sel_cliente)){
			echo "<tr style='font-size:11px'><td>$fil_cliente[1]</td><td>$fil_cliente[2]</td><td>$fil_cliente[3]</td><td>$fil_cliente[4]</td><td align='right'>$fil_cliente[5]</td><td>$fil_cliente[6]</td><td>$fil_cliente[7]</td><td align='right'>$fil_cliente[8]</td></tr>";
		}
		echo "</table>".'<br>';
		
	}}	
?>
<form name="form1" method="post" action="codificar_clientes.php">
  <table width="576" border="0">
    <tr>
      <td width="129">Nombre Cliente 
      <input name="tipoR" type="hidden" id="tipoR" value="<? echo $tipoR;?>">
      <input name="id_cliente" type="hidden" id="id_cliente" value="<? echo $id_cliente;?>"></td>
      <td colspan="3"><input name="cliente" type="text" id="cliente" size="65"></td>
    </tr>
    <tr>
      <td>Lugar</td>
      <td colspan="3">
	  <? 
				$sel_lugares = mysqli_query($link,"Select idLugar, nombreLugar From lugares");
				//echo "<select name='lugar' id='lugar' onChange='LugarPadre()'>";
				echo "<select name='lugar' id='lugar'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_lugares = mysqli_fetch_array($sel_lugares)){
					echo "<option value='$fil_lugares[0]'>$fil_lugares[1]</option>";
				}
				echo "</select>";
			?>      <input name="controlador" type="text" id="controlador" size="5" maxlength="5" readonly="">
	  <input name="contador" type="text" id="contador" size="5" maxlength="5" readonly=""></td>
    </tr>
    <tr>
      <td>Zona</td>
      <td colspan="3"><? 
				$sel_zonas = mysqli_query($link,"Select idZona, nombreZona From zonas Order By nombreZona");
				echo "<select name='zona' id='zona'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_zonas = mysqli_fetch_array($sel_zonas)){
					echo "<option value='$fil_zonas[0]'>$fil_zonas[1]</option>";
				}
				echo "</select>";
			?> <a href="auxiliares/registro_zonas.php<? echo "?tipoR=$tipoR";?>"><img src="imagenes/mas.JPG" width="19" height="14" border="0"></a></td>
    </tr>
    <tr>
      <td>Calle</td>
      <td width="312"><? 
				$sel_calles = mysqli_query($link,"Select idCalle, nombreCalle From calles Order By nombreCalle");
				echo "<select name='calle' id='calle'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_calles = mysqli_fetch_array($sel_calles)){
					echo "<option value='$fil_calles[0]'>$fil_calles[1]</option>";
				}
				echo "</select>";
			?>
        <a href="auxiliares/registro_calles.php<? echo "?tipoR=$tipoR";?>"><img src="imagenes/mas.JPG" width="19" height="14" border="0"></a></td>
      <td width="56"> N&uacute;mero</td>
      <td width="61"><input name="numero" type="text" id="numero" size="6" maxlength="10"> </td>
    </tr>
    <tr>
      <td>Canal</td>
      <td><? 
				$sel_canal = mysqli_query($link,"Select idCanal, nombreCanal From canales Order By nombreCanal");
				echo "<select name='canal' id='canal'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_canal = mysqli_fetch_array($sel_canal)){
					echo "<option value='$fil_canal[0]'>$fil_canal[1]</option>";
				}
				echo "</select>";
			?></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Tipo Local</td>
      <td><? 
				$sel_local = mysqli_query($link,"Select idLocal, nombreLocal From locales Order By nombreLocal");
				echo "<select name='local' id='local'>";
				echo "<option value='0'>Selec.</option>";
				while($fil_local = mysqli_fetch_array($sel_local)){
					echo "<option value='$fil_local[0]'>$fil_local[1]</option>";
				}
				echo "</select>";
			?></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Ruta</td>
      <td><input name="ruta" type="text" id="ruta" size="4" maxlength="1"></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Guardar"></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
ob_end_flush();
?>

