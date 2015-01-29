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
	
	if($_POST){	
		$fecha1 = $_POST["fecha1"];
		$fecha2 = $_POST["fecha2"];
		
		$distribuidor  = $_POST['distribuidor'];
		
		$saldo_inicial = $_POST['saldo_inicial'];
	} 
?>

<html>
<head>
<title>Estado Envases Entrada Salidas</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>
<h1>INGRESO SALIDA ENVASES</h1>
<p>
  <?
	if($distribuidor==0){
		echo "<h2>Global Distribuidores</h2>";		
	}
	else{
		$sql_dis = mysqli_query($link,"Select f_nombre_distribuidor($distribuidor)");
		$fil_dis = mysqli_fetch_array($sql_dis);
		echo "<h2>DISTRIBUIDOR:"."<input name='textfield' type='text' value='$fil_dis[0]' size='30' readonly='' style='text-align:center'></h2>";
	}
	if ($saldo_inicial == 1){
		echo "<h3>Incluye Saldos Iniciales</h3>";		
	}
?>
  Entre
  <input name="textfield" type="text" value="<? echo $fecha1;?>" size="10" readonly="" style="text-align:center"> 
  y el 
  <input name="textfield2" type="text" value="<? echo $fecha2;?>" size="10" readonly="" style="text-align:center">
</p>
<table width="696" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="22" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
    <td width="248" rowspan="2"><span class="Estilo1 Estilo1">
      <? 
		if($distribuidor == 0){ 
			echo "Distribuidor";
		}
		else{
			echo "Fecha";
		} 
      ?>
    </span> </td>
    <td colspan="2"><span class="Estilo1 Estilo1">Entregas</span><span class="Estilo1 Estilo1"></span></td>
    <td colspan="2"><span class="Estilo1 Estilo1">Recuperaciones</span><span class="Estilo1 Estilo1"></span></td>
    <td colspan="2"><span class="Estilo1 Estilo1">Papeletas</span></td>
    <td colspan="2"><span class="Estilo1 Estilo1">Saldos</span></td>
  </tr>
  <tr>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
  </tr>
  <?   	
  	if($_POST){
	    if ($saldo_inicial == 1){
			$sql_saldos = mysqli_query($link,"CALL sp_entradaSalidaEnvases('$distribuidor',1,'$fecha1','$fecha2')");
		}
		else{
			$sql_saldos = mysqli_query($link,"CALL sp_entradaSalidaEnvases('$distribuidor',0,'$fecha1','$fecha2')");
		}
		
		$c1 = 0; $c2 = 0; $c3 = 0; $c4 = 0; $c5 = 0; $c6 = 0; $c7 = 0; $c8 = 0; 
  		while($filas_saldo = mysqli_fetch_array($sql_saldos)){			
			$c1 =  $c1 +  $filas_saldo[botEnt];   
			$c2 =  $c2 +  $filas_saldo[canEnt];	
			$c3 =  $c3 +  $filas_saldo[botDev];   
			$c4 =  $c4 +  $filas_saldo[canDev];	
			$c5 =  $c5 +  $filas_saldo[botPap];   
			$c6 =  $c6 +  $filas_saldo[canPap];	
			$c7 =  $c7 +  $filas_saldo[salBot];   
			$c8 =  $c8 +  $filas_saldo[salCan];	

			$c = $c + 1;

			if($distribuidor == 0){
				echo "<tr style='font-size:12px'>";			
					echo "<td align='center'>$c</td>";
					echo "<td>$filas_saldo[0]</td>";
					echo "<td align='right'>$filas_saldo[botEnt]</td>";
					echo "<td align='right'>$filas_saldo[canEnt]</td>";
					echo "<td align='right'>$filas_saldo[botDev]</td>";
					echo "<td align='right'>$filas_saldo[canDev]</td>";
					echo "<td align='right'>$filas_saldo[botPap]</td>";
					echo "<td align='right'>$filas_saldo[canPap]</td>";
					echo "<td align='right'>$filas_saldo[salBot]</td>";
					echo "<td align='right'>$filas_saldo[salCan]</td>";
				echo "</tr>";
			}
			else{
				echo "<tr style='font-size:12px'>";
					echo "<td align='center'>$c</td>";
					echo "<td>$filas_saldo[0]</td>";
					echo "<td align='right'>$filas_saldo[botEnt]</td>";
					echo "<td align='right'>$filas_saldo[canEnt]</td>";
					echo "<td align='right'>$filas_saldo[botDev]</td>";
					echo "<td align='right'>$filas_saldo[canDev]</td>";
					echo "<td align='right'>$filas_saldo[botPap]</td>";
					echo "<td align='right'>$filas_saldo[canPap]</td>";
					echo "<td align='right'>$c7</td>";
					echo "<td align='right'>$c8</td>";
				echo "</tr>";
			}
		}
	}
	echo "<tr></tr><tr></tr><tr></tr>";
	echo "<tr style='font-size:12px' bgcolor='#CC9933'>";
		echo "<td colspan='2' align='center'><strong>TOTALES</strong></td>";
		echo "<td align='right'><strong>$c1</strong></td>";
		echo "<td align='right'><strong>$c2</strong></td>";
		echo "<td align='right'><strong>$c3</strong></td>";
		echo "<td align='right'><strong>$c4</strong>";
		echo "<td align='right'><strong>$c5</strong></td>";
		echo "<td align='right'><strong>$c6</strong></td>";
		echo "<td align='right'><strong>$c7</strong></td>";
		echo "<td align='right'><strong>$c8</strong></td>";		
	echo "</tr>";
	
?>
</table>
</body>

</html>
