<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('../menu.php');
	include('../conexion.php');
	$link = conexion();
?>
<html>
<head>
<title>Detalle Stock Envases Productos</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<h1>Stock Evases Productos </h1>
<table width="542" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td colspan="3"><span class="Estilo1 Estilo1">Botella</span></td>
    <td colspan="3"><span class="Estilo1 Estilo1">Lata</span></td>
    <td colspan="4"><span class="Estilo1">Botellin</span></td>
    <td colspan="2"><span class="Estilo1 Estilo1">Chopp</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Envases</span></td>
  </tr>
  <tr>
    <td width="23" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="28" bgcolor="#F3EA72">Stou</td>
    <td width="23" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="28" bgcolor="#F3EA72">Stou</td>
    <td width="23" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="28" bgcolor="#F3EA72">Stou</td>
    <td width="17" bgcolor="#F3EA72">33</td>
    <td width="23" bgcolor="#F3EA72">Esp</td>
    <td width="30" bgcolor="#F3EA72">Sesq</td>
    <td width="26" bgcolor="#F3EA72">Bot.</td>
    <td width="46" bgcolor="#F3EA72">Canast.</td>
    <td width="45" bgcolor="#F3EA72">Rotura Bot</td>
    <td width="46" bgcolor="#F3EA72">Rotura Canast.</td>
  </tr>
  <?
if($tipo_nota > 0){	
  	$f1 = $canno1.'/'.$cmes1.'/'.$cdia1;		
	$f2 = $canno2.'/'.$cmes2.'/'.$cdia2;
	
	if($distribuidor == 0){
	  		$sql_sum_prod = mysqli_query($link,"SELECT p.IdProducto, SUM(Cantidad) FROM productos p LEFT JOIN  itemProceso i USING(idProducto) JOIN Procesos r USING(IdProceso,TipoNota) WHERE r.fecha BETWEEN '$f1' AND '$f2' AND r.Estado = 1 AND r.TipoNota = '$tipo_nota' GROUP BY p.IdProducto;");
		}
	else {
	  		$sql_sum_prod = mysqli_query($link,"SELECT p.IdProducto, SUM(Cantidad) FROM productos p LEFT JOIN  itemProceso i USING(IdProducto) JOIN Procesos r USING(IdProceso,TipoNota) WHERE r.fecha BETWEEN '$f1' AND '$f2' AND r.Estado = 1 AND r.TipoNota = '$tipo_nota' AND idDistribuidor = '$distribuidor' GROUP BY p.IdProducto;");
		}	
		//$c = 1;
	while($fil_sum_prod = mysqli_fetch_array($sql_sum_prod)){
		$id_prod[] = $fil_sum_prod[0];
		$sum[] = $fil_sum_prod[1];
		//$c++;
	}
	$c = 16;
	echo "nada";
	echo "Entre el:"."<input name='f1' type='text' value='$f1'>"."y el:"."<input name='f2' type='text' value='$f2'>";
	echo 'Entre el: '.$f1.' y el: '.$f2;//.'  '.$distribuidor;

	$sql_desp = mysqli_query($link,"call sp_despachos('$f1','$f2','$tipo_nota','$distribuidor')");
	while($fil_desp = mysqli_fetch_row($sql_desp)){
			echo "<tr align='right' style='font-size:11px'>";
				echo "<td align='left'>$fil_desp[0]</td>";
				echo "<td align='left'>$fil_desp[1]</td>";
				echo "<td align='left'>$fil_desp[2]</td>";
				echo "<td>$fil_desp[3]</td>";
				echo "<td>$fil_desp[4]</td>";
				echo "<td>$fil_desp[5]</td>";
				echo "<td>$fil_desp[6]</td>";
				echo "<td>$fil_desp[7]</td>";
				echo "<td>$fil_desp[8]</td>";
				echo "<td>$fil_desp[9]</td>";
				echo "<td>$fil_desp[10]</td>";
				echo "<td>$fil_desp[11]</td>";
				echo "<td>$fil_desp[12]</td>";
				echo "<td>$fil_desp[13]</td>";
				echo "<td>$fil_desp[14]</td>";
				echo "<td>$fil_desp[15]</td>";
				echo "<td>$fil_desp[16]</td>";
				echo "<td>$fil_desp[17]</td>";
			echo "</tr>";	
		}	
  ?>
  
  <tr bgcolor="#F3EA72" align="right" style="font-size:11px">
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 1){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 2){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 3){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 4){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 5){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 6){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 7){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 8){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 9){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 10){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 11){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 12){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 13){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 14){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 15){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 16){echo $sum[$i];}$i++;}?>*****</td>
  </tr>
  <tr><td>**************************************</td></tr>
  <tr bgcolor="#F3EA72" align="right" style="font-size:11px">
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 1){echo $sum[$i]/12;}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 2){echo $sum[$i]/12;}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 3){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 4){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 5){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 6){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 7){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 8){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 9){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 10){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 11){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 12){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 13){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 14){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 15){echo $sum[$i];}$i++;}?></td>
    <td><? $i=0; while($i < $c){if($id_prod[$i] == 16){echo $sum[$i];}$i++;}?></td>
  </tr>
  
  <?
}
?>
</table>
</body>
</html>
