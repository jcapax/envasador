<?  
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	echo "<br>";
	include('../conexion.php');
	$link = conexion();
	
	if($_POST){	
		$canno = $_POST['canno'];
		$cmes = $_POST['cmes'];
		$cdia = $_POST['cdia'];
		
		$distribuidor  = $_POST['distribuidor'];
		$cliente       = $_POST['cliente'];
		$control       = $_POST['control'];
		$saldo_inicial = $_POST['saldo_inicial'];
		
		if($control==1){
			$distribuidor = 0;
		}
		else{
			$control = 0;
			$cliente = 0;
		}
		
		if(!$saldo_inicial==1){
			$saldo_inicial = 0;
		}
		
	  	if(! checkdate($cmes,$cdia,$canno)){ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  echo"<a href='../comercial.php'>volver</a>";
		  die;
		}
		else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}	
	} 
?>
<html>
<head>
<title>Reporte Saldos Cliente</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>
<? 
	if($control == 1){
		echo "<h1>SALDOS CLIENTES ENVASES </h1>";
	}
	else{
		echo "<h1>SALDOS DISTRIBUIDORES ENVASES </h1>";
	}
	
	echo "<h3>Reporte Saldos Hasta $fecha</h3>";
	
	if(($control == 1)and($cliente<>0)){
		$sql_cli = mysqli_query($link,"Select f_nombre_cliente('$cliente')");
		$fil_cli = mysqli_fetch_array($sql_cli);
		echo "<h3>CLIENTE: $fil_cli[0]</h3>";
	}
	if(($control == 0)and($distribuidor<>0)){
		$sql_dis = mysqli_query($link,"Select f_nombre_distribuidor('$distribuidor')");
		$fil_dis = mysqli_fetch_array($sql_dis);
		echo "<h3>DISTRIBUIDOR: $fil_dis[0]</h3>";
	}
	
?>
<table width="781" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="22" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
    <td width="248" rowspan="2">
		<span class="Estilo1 Estilo1">
			<? 
				if(($control == 1)and($cliente == 0)){ 
					echo "Distribuidores";	
				}			
				if(($control == 0)and($distribuidor == 0)){ 
					echo "Distribuidor";
				}
				if(($control == 0)and($distribuidor <> 0)){ 
					echo "Clientes";
				}
				if(($control == 1)and($cliente<>0)){ 
					echo "Distribuidor";	
				}
			?>
		</span>	</td>
    <td width="185" rowspan="2">
		<span class="Estilo1 Estilo1">
			<? 
				if(($control == 1)and($cliente == 0)){ 
					echo "Clientes";	
				}
				if(($control == 1)and($cliente<>0)){ 
					echo "Fecha";	
				}		
						
				if(($control == 0)and($distribuidor <> 0)){ 
					echo "";
				}	
			?>
		</span>	</td>
    <td colspan="2"><span class="Estilo1 Estilo1">Entregas</span><span class="Estilo1 Estilo1"></span></td>
	<td colspan="2"><span class="Estilo1 Estilo1">Recuperaciones</span><span class="Estilo1 Estilo1"></span></td>
	<td colspan="2"><span class="Estilo1 Estilo1">Saldos</span><span class="Estilo1 Estilo1"></span></td>
  </tr>
  <tr>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Botellas</div></td>
    <td width="48" bgcolor="#F3EA72"><div align="center">Cajas</div></td>
  </tr>
  <?   	
  	if($_POST){
		$sql_saldos = mysqli_query($link,"CALL sp_ListaSaldosGlobales('$fecha','$saldo_inicial','$control','$cliente','$distribuidor')");
		$c1 = 0; $c2 = 0; $c3 = 0; $c4 = 0; $c5 = 0; $c6 = 0; 
  		while($filas_saldo = mysqli_fetch_array($sql_saldos)){			
			$c1 =  $c1 +  $filas_saldo[5];   
			$c2 =  $c2 +  $filas_saldo[6];	
			$c3 =  $c3 +  $filas_saldo[7];   
			$c4 =  $c4 +  $filas_saldo[8];	
			$c5 =  $c5 +  $filas_saldo[9];   
			$c6 =  $c6 +  $filas_saldo[10];	

				// cliente seleccionado
				if(($control == 1)and($cliente<>0)){ 	
				    $c = $c + 1;				
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[2]</td><td>$filas_saldo[4]</td><td align='right'>$filas_saldo[5]</td><td align='right'>$filas_saldo[6]</td><td align='right'>$filas_saldo[7]</td><td align='right'>$filas_saldo[8]</td><td align='right'>$filas_saldo[9]</td><td align='right'>$filas_saldo[10]</td></tr>";
				}


			if(($filas_saldo[9]<>0)or($filas_saldo[10]<>0)){		
				$c = $c + 1;
				
				// cliente global
				if(($control == 1)and($cliente == 0)){ 
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[2]</td><td>$filas_saldo[3]</td><td align='right'>$filas_saldo[5]</td><td align='right'>$filas_saldo[6]</td><td align='right'>$filas_saldo[7]</td><td align='right'>$filas_saldo[8]</td><td align='right'>$filas_saldo[9]</td><td align='right'>$filas_saldo[10]</td></tr>";
				}
				
				// distribuidores globales
				if(($control == 0)and($distribuidor == 0)){ 
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[2]</td><td>$filas_saldo[4]</td><td align='right'>$filas_saldo[5]</td><td align='right'>$filas_saldo[6]</td><td align='right'>$filas_saldo[7]</td><td align='right'>$filas_saldo[8]</td><td align='right'>$filas_saldo[9]</td><td align='right'>$filas_saldo[10]</td></tr>";
				}
				
				// distribuidor seleccionado
				if(($control == 0)and($distribuidor <> 0)){ 
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[2]</td><td>$filas_saldo[4]</td><td align='right'>$filas_saldo[5]</td><td align='right'>$filas_saldo[6]</td><td align='right'>$filas_saldo[7]</td><td align='right'>$filas_saldo[8]</td><td align='right'>$filas_saldo[9]</td><td align='right'>$filas_saldo[10]</td></tr>";
				}
			}	
		}
	}
	echo "<tr></tr><tr></tr><tr></tr><tr style='font-size:12px' bgcolor='#CC9933'><td colspan='3' align='center'><strong>TOTALES</strong></td><td align='right'><strong>$c1</strong></td><td align='right'><strong>$c2</strong></td><td align='right'><strong>$c3</strong></td><td align='right'><strong>$c4</strong></td><td align='right'><strong>$c5</strong></td><td align='right'><strong>$c6</strong></td></tr>";
?>
</table>
</body>
</html>
