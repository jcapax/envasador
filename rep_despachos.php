<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	if ($_POST){
		$canno1 = $_POST["canno1"];
		$canno2 = $_POST["canno2"];
		$cmes1 = $_POST["cmes1"];
		$cmes2 = $_POST["cmes2"];
		$cdia1 = $_POST["cdia1"];
		$cdia2 = $_POST["cdia2"];
		$tipo_nota = $_POST["tipo_nota"];
		$distribuidor = $_POST["distribuidor"];
	}
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();

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
<p></p>
<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<form name="form1" method="post" action="rep_despachos.php">
  <table width="337" border="0">
    <tr>
      <td>Fecha Inicio:</td>
      <td><select name="canno1" id="canno1">
          <option value="0" selected>Selec.</option>
          <option value="2007"<? if($fil_fecha[0]==2007){?>selected<? }?>>2007</option>
          <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
          <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>		  
        </select>
          <select name="cmes1" id="cmes1">
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
          <select name="cdia1" id="cdia1">
            <option value="0" selected>Selec.</option>
            <?
		  	$d = 1;
			while ($d <= 31){
				if ($fil_fecha[2] == $d){ echo "<option value='$d' selected='selected'>$d</option>";}
				else { echo "<option value='$d'>$d</option>";}
				$d = $d + 1;
			}
		  ?>
        </select></td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><select name="canno2" id="canno2">
          <option value="0" selected>Selec.</option>
          <option value="2007"<? if($fil_fecha[0]==2007){?>selected<? }?>>2007</option>
          <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
          <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>		  
        </select>
          <select name="cmes2" id="select2">
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
          <select name="cdia2" id="select3">
            <option value="0" selected>Selec.</option>
            <?
		  	$d = 1;
			while ($d <= 31){
				if ($fil_fecha[2] == $d){ echo "<option value='$d' selected='selected'>$d</option>";}
				else { echo "<option value='$d'>$d</option>";}
				$d = $d + 1;
			}
		  ?>
        </select></td>
    </tr>
    <tr>
      <td>Tipo Nota: </td>
		<?
			if ($acceso==1){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");				
				}

			if ($acceso==2){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 0");				
				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 0");				
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 3 AND 4");				
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
	  <? $sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores ORDER BY NombreDistribuidor");?>
	  <td><select name="distribuidor" id="distribuidor">
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
      <td><input type="submit" name="Submit" value="Buscar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p></p>

<table width="851" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="164" rowspan="2"><span class="Estilo1 Estilo1">Distribuidor</span></td>
    <td width="57" rowspan="2"><span class="Estilo1">Fecha</span></td>
    <td width="76" rowspan="2"><span class="Estilo1 Estilo1">TipoNota</span></td>
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
	echo 'Entre el: '.$f1.' y el: '.$f2;//.'  '.$distribuidor;

	$sql_desp = mysqli_query($link,"call sp_despachos('$f1','$f2','$tipo_nota','$distribuidor')");
	while($fil_desp = mysqli_fetch_row($sql_desp)){
			echo "<tr align='right' style='font-size:11px'><td align='left'>$fil_desp[0]</td><td align='left'>$fil_desp[1]</td><td align='left'>$fil_desp[2]</td><td>$fil_desp[3]</td><td>$fil_desp[4]</td><td>$fil_desp[5]</td><td>$fil_desp[6]</td><td>$fil_desp[7]</td><td>$fil_desp[8]</td><td>$fil_desp[9]</td><td>$fil_desp[10]</td><td>$fil_desp[11]</td><td>$fil_desp[12]</td><td>$fil_desp[13]</td><td>$fil_desp[14]</td><td>$fil_desp[15]</td><td>$fil_desp[16]</td><td>$fil_desp[17]</td></tr>";	
		}	
  ?>
  </tr>
  
  <tr bgcolor="#F3EA72" align="right" style="font-size:11px">
    <td colspan="3"><strong>Totales</strong></td>
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
	<td><? echo $sum[0]+$sum[1]+$sum[2]?></td>
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

