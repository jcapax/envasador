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
		$cmes  = $_POST['cmes'];
		$cdia  = $_POST['cdia'];

		$distribuidor  = $_POST['distribuidor'];

	  	if(! checkdate($cmes,$cdia,$canno)){ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  die;
		}
		else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}		
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
<h1>SALDOS ENVASES  </h1>
<p>
  <?
	if($distribuidor==0){
		echo "<h2>Global Distribuidores</h2>";
	}
	else{
		$sql_dis = mysqli_query($link,"Select f_nombre_distribuidor($distribuidor)");
		$fil_dis = mysqli_fetch_array($sql_dis);
		echo "<h2>DISTRIBUIDOR:"."<input name='textfield' type='text' value='$fil_dis[0]' size='55' readonly='' style='text-align:center'></h2>";
	}
?>
  Movimiento desde
  <input name="textfield" type="text" value="2009-04-01" size="10" readonly="" style="text-align:center"> 
  hasta 
  <input name="textfield2" type="text" value="<? echo $fecha;?>" size="10" readonly="" style="text-align:center">
</p>
<table width="592" border="0">
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
		$sql_saldos = mysqli_query($link,"CALL sp_saldosEnvasesDistribuidores('$distribuidor','$fecha')");
		$c1 = 0; $c2 = 0; $c3 = 0; $c4 = 0; $c5 = 0; $c6 = 0; 
  		while($filas_saldo = mysqli_fetch_array($sql_saldos)){			
			$c1 =  $c1 +  $filas_saldo[1];   
			$c2 =  $c2 +  $filas_saldo[2];	
			$c3 =  $c3 +  $filas_saldo[3];   
			$c4 =  $c4 +  $filas_saldo[4];	
			$c5 =  $c5 +  $filas_saldo[5];   
			$c6 =  $c6 +  $filas_saldo[6];	

			$c = $c + 1;
			if($distribuidor == 0){
				if(($c5<>0)or($c6<>0)){
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[0]</td><td align='right'>$filas_saldo[1]</td><td align='right'>$filas_saldo[2]</td><td align='right'>$filas_saldo[3]</td><td align='right'>$filas_saldo[4]</td><td align='right'>$filas_saldo[5]</td><td align='right'>$filas_saldo[6]</td></tr>";}
			}
			else{
				if ($filas_saldo[7]==1){
					echo "<tr style='font-size:12px' bgcolor='#CC99CC'><td align='center'>$c</td><td>Saldo Inicial Abril 2009</td><td align='right'>$filas_saldo[1]</td><td align='right'>$filas_saldo[2]</td><td align='right'>$filas_saldo[3]</td><td align='right'>$filas_saldo[4]</td><td align='right'>$c5</td><td align='right'>$c6</td></tr>";
				}
				else{
					echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$filas_saldo[0]</td><td align='right'>$filas_saldo[1]</td><td align='right'>$filas_saldo[2]</td><td align='right'>$filas_saldo[3]</td><td align='right'>$filas_saldo[4]</td><td align='right'>$c5</td><td align='right'>$c6</td></tr>";
				}
			}
		}
	}
	echo "<tr></tr><tr></tr><tr></tr><tr style='font-size:12px' bgcolor='#CC9933'><td colspan='2' align='center'><strong>TOTALES</strong></td><td align='right'><strong>$c1</strong></td><td align='right'><strong>$c2</strong></td><td align='right'><strong>$c3</strong></td><td align='right'><strong>$c4</strong></td><td align='right'><strong>$c5</strong></td><td align='right'><strong>$c6</strong></td></tr>";
?>
</table>
</body>

</html>
