<?  
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	require('menu_reporte.php');
	include('../conexion.php');
	$link = conexion();
	
	if($_POST){
		$criterio    = '%'.$_POST['criterio'].'%';
		$procedencia = $_POST['procedencia'];
		$f1          = $_POST['f1'];
		$f2          = $_POST['f2'];	
		$ro			 = $_POST['ropcion'];	

	$sql = "SELECT DISTINCT idCliente, nombreCliente, codigoCliente, nombreCalle, numero, nombreLocal FROM clientes c JOIN zonas z ON c.idZona = z.idZona JOIN calles a ON c.idCalle = a.idCalle JOIN locales l USING (idLocal) JOIN lugares u ON u.idLugar = c.idLugar JOIN canales n ON c.idCanal = n.idCanal "; 
	
	switch ($ro){
		case 0://nombre cliente
				$sql_where = "WHERE nombreCliente LIKE '$criterio'";
				break;
		case 1://lugar
				$sql_where = "WHERE nombreLugar LIKE '$criterio'";
				break;
		case 2://zona
				$sql_where = "WHERE nombreZona LIKE '$criterio'";
				break;
		case 3://calle
				$sql_where = "WHERE nombreCalle LIKE '$criterio'";
				break;
		case 4://canal
				$sql_where = "WHERE nombreCanal LIKE '$criterio'";
				break;
		case 5://tipo local
				$sql_where = "WHERE nombreLocal LIKE '$criterio'";
				break;
	}
	
	$sel_cliente = mysqli_query($link,$sql.''.$sql_where);
	
	}
	else{
		$procedencia = $_GET['procedencia'];
		$f1          = $_GET['f1'];
		$f2          = $_GET['f2'];		
	}
	
?>
<html>
<head>
<title>Buscador Clientes</title>
</head>
<body>
<h1>BUSCADOR DE CLIENTES <br>
</h1>
<form name="form1" method="post" action="buscador_clientes.php">
  <table width="630" border="0">
    <tr>
      <td colspan="2"><p>
        <label><input name="ropcion" type="radio" value="0" checked>
        Nombre Cliente</label>
        <label><input type="radio" name="ropcion" value="1">Lugar</label>
        <label><input type="radio" name="ropcion" value="2">Zona</label>
        <label><input type="radio" name="ropcion" value="3">Calle</label>
        <label><input type="radio" name="ropcion" value="4">Canal</label>
        <label><input type="radio" name="ropcion" value="5">Tipo Local</label>
        <input name="procedencia" type="hidden" id="procedencia" value="<? echo $procedencia?>">
        <input name="f1" type="hidden" id="f1" value="<? echo $f1?>">
        <input name="f2" type="hidden" id="f2" value="<? echo $f2?>">
        <br>
      </p></td>
    </tr>
    <tr>
      <td width="54">Criterio:</td>
      <td width="566"><input name="criterio" type="text" id="criterio" size="30" maxlength="30">
	  	<? //if($procedencia == 1){ echo 'Entre '.$f1.' y '.$f2;}?>
	  </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>  
</form>
<table width="654" border="0">
    <tr bgcolor="#FFCC00" align="center">
      <td width="72">C&oacute;digo</td>
      <td width="190">Nombre Cliente </td>
      <td width="249">Direcci&oacute;n</td>
      <td width="125">Tipo Local</td>
    </tr>
	<? 
	
		while($buscador = mysqli_fetch_array($sel_cliente)){
			$cli = dechex($buscador[0]);
			if($procedencia == 1){
				echo "<tr style='font-size:11px'>";
					echo "<td>";
						echo "<a href='../reportes_comercial/detalle_cliente.php?id_cliente=$cli&f1=$f1&f2=$f2'>$buscador[0]</a>";
					echo "</td>";
					echo "<td>$buscador[1]</td>";
					echo "<td>$buscador[3] Nº $buscador[4]</td>";
					echo "<td>$buscador[5]</td>";
					echo "<td align='center'>";
				echo "</tr>";
			}
			else{
 				echo "<tr style='font-size:11px'>";
					echo "<td>$buscador[2]</td>";
					echo "<td>$buscador[1]</td>";
					echo "<td>$buscador[3] Nº $buscador[4]</td>";
					echo "<td>$buscador[5]</td>";
					echo "<td align='center'>";
						
					echo "</td>";
				echo "</tr>";
			}
		}
		
	?>
</table>
</body>
</html>
