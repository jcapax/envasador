<?php
ob_start();
?> 
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
<form name="form1" method="post" action="recep_envases.php">
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
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota BETWEEN 1 AND 2");				
				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 2");				
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 4");				
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
<p></p>
<table width="737" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="148" rowspan="2"><span class="Estilo1">Nota</span></td>
	<td width='151' rowspan='2'><span class='Estilo1'>Distribuidor</span></td>
    <td width="63" rowspan="2"><span class="Estilo1">Fecha</span></td>
    <td width="185" rowspan="2"><span class="Estilo1">Detalle</span></td>
    <td colspan="2"><div align="center" class="Estilo1">Envases</div></td>
    <td colspan="2"><div align="center" class="Estilo1">Roturas  </div></td>
  </tr>
  <tr bgcolor="#F3EA72">
    <td width="36">Botel.</td>
    <td width="42">Canas.</td>
    <td width="36">Botel.</td>
    <td width="42">Canas.</td>
  </tr>
  <?  	    
	$f1 = $canno1.'/'.$cmes1.'/'.$cdia1;
		
	$f2 = $canno2.'/'.$cmes2.'/'.$cdia2;

  	if(checkdate($cmes1,$cdia1,$canno1)){
		if($distribuidor==0){
				$sum_enva = mysqli_query($link,"Select i.idProducto,SUM(Cantidad) From itemProceso i JOIN Procesos p ON i.idProceso = p.idProceso AND i.TipoNota = p.TipoNota WHERE (i.idProducto BETWEEN 13 AND 16) AND (Fecha BETWEEN '$f1' AND '$f2') AND p.estado = 1 AND p.TipoNota = $tipo_nota GROUP BY i.idProducto");}
		else{
				$sum_enva = mysqli_query($link,"Select i.idProducto,SUM(Cantidad) From itemProceso i JOIN Procesos p USING(idProceso,TipoNota) WHERE (i.idProducto BETWEEN 13 AND 16) AND (Fecha BETWEEN '$f1' AND '$f2') AND p.estado = 1 AND p.IdDistribuidor = $distribuidor AND p.TipoNota = $tipo_nota GROUP BY i.idProducto");}

	$a = mysqli_fetch_array($sum_enva);
	$b = mysqli_fetch_array($sum_enva);
	$c = mysqli_fetch_array($sum_enva);
	$d = mysqli_fetch_array($sum_enva);
	}

  	if ($_POST){	
		echo 'Entre el: '.$f1.' y el: '.$f2;
	
   		$sql_enva = mysqli_query($link,"CALL sp_envases('$f1','$f2','$tipo_nota','$distribuidor')");
	
	
		while($fil_enva = mysqli_fetch_array($sql_enva)){
			if($distribuidor==0){
				echo "<tr style='font-size:11px'><td>$fil_enva[1]</td><td>$fil_enva[2]</td><td>$fil_enva[3]</td><td>$fil_enva[4]</td><td align='right'>$fil_enva[5]</td><td align='right'>$fil_enva[6]</td><td align='right'>$fil_enva[7]</td><td align='right'>$fil_enva[8]</td></tr>";
			}
			else {
				echo "<tr style='font-size:11px'><td>$fil_enva[1]</td><td>$distribuidor</td><td>$fil_enva[2]</td><td>$fil_enva[3]</td><td>$fil_enva[4]</td><td align='right'>$fil_enva[5]</td><td align='right'>$fil_enva[6]</td><td align='right'>$fil_enva[7]</td><td align='right'>$fil_enva[8]</td></tr>";
			}
	}		
		}
  ?>
  <tr bgcolor="#F3EA72" align="right" style='font-size:11px'>
    <td colspan="4">Total</td>
    <td><? echo $a[1]?></td>
    <td><? echo $b[1]?></td>
    <td><? echo $c[1]?></td>
    <td><? echo $d[1]?></td>
  </tr>
</table>
<?php
ob_end_flush();
?>
</body>
</html>

