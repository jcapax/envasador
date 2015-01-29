<?  
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();
	
	if($_POST){	
		$canno1 = $_POST['canno1'];
		$cmes1 = $_POST['cmes1'];
		$cdia1 = $_POST['cdia1'];
		
		$canno2 = $_POST['canno2'];
		$cmes2 = $_POST['cmes2'];
		$cdia2 = $_POST['cdia2'];
		
		$cantidad = $_POST['cantidad'];
		
	  	if(! checkdate($cmes1,$cdia1,$canno1)){ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  echo"<a href='../comercial.php'>volver</a>";
		  die;
		}
		else { $fecha1 = $canno1.'-'.$cmes1.'-'.$cdia1;}

	  	if(! checkdate($cmes2,$cdia2,$canno2)){ 
		  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
		  echo"<a href='../comercial.php'>volver</a>";
		  die;
		}
		else { $fecha2 = $canno2.'-'.$cmes2.'-'.$cdia2;}	
		
		$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
		$fil_fecha = mysqli_fetch_row($sql_fecha);	
	} 
?>
<html>
<head>
<title>Ranking Clientes</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>
<h1>RANKING CLIENTES</h1>
<form name="form1" method="post" action="ranking_clientes.php">
  <table width="497" border="0">
    <tr>
      <td width="137">Fecha Inicio:</td>
      <td width="370"><select name="canno1" id="canno1" style="text-align:right">
          <option value="0" selected>Selec.</option>
          <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
          <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		  <option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		  <option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
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
          <select name="cdia1" id="cdia1" style="text-align:right">
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
      <td><select name="canno2" id="canno2" style="text-align:right">
          <option value="0" selected>Selec.</option>
          <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
          <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
		  <option value="2010"<? if($fil_fecha[0]==2010){?>selected<? }?>>2010</option>
		  <option value="2011"<? if($fil_fecha[0]==2011){?>selected<? }?>>2011</option>
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
          <select name="cdia2" id="select3" style="text-align:right">
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
      <td>Cantidad Registros  </td>
      <td><input name="cantidad" type="text" id="cantidad" value="<? echo $cantidad?>" size="6" maxlength="3" style="text-align:right"></td>
    </tr>

    <tr>
      <td><input type="submit" name="Submit" value="Consultar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?
  echo "<h2>ENTRE $fecha1 y el $fecha2</h2>"."<br>";
?>
<table width="1194" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="25" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
    <td width="219" rowspan="2"><span class="Estilo1 Estilo1">Cliente</span></td>
    <td width="35" rowspan="2"><span class="Estilo1 Estilo1">Lugar</span></td>
    <td width="115" rowspan="2"><span class="Estilo1">Zona</span></td>
    <td width="206" rowspan="2"><span class="Estilo1 Estilo1">Calle</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Botella</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Lata</span></td>
    <td colspan="5"><span class="Estilo1">Botellin</span></td>
    <td colspan="3"><span class="Estilo1 Estilo1">Chopp</span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="38" bgcolor="#F3EA72"><div align="right">Bicent</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="28" bgcolor="#F3EA72"><div align="right">Stou</div></td>
    <td width="25" bgcolor="#F3EA72"><div align="right">33</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="42" bgcolor="#F3EA72"><div align="right">Canast</div></td>
    <td width="39" bgcolor="#F3EA72"><div align="right">Precio</div></td>
  </tr>
  <? 
  	if($_POST){
		$sql_l = mysqli_query($link,"CALL sp_ranking_clientes('$fecha1','$fecha2')");
	  	$c = 0;
		$c4 = 0; $c5 = 0; $c6 = 0; $c7 = 0; $c8 = 0; $c9 = 0;
		$c10 = 0; $c11 = 0; $c12 = 0; $c13 = 0; $c14 = 0; $c15 = 0;
		$c16 = 0; $c17 = 0;$c18 = 0; $c19 = 0; $c20 = 0;
		
  		while(($lista = mysqli_fetch_array($sql_l))and($c < $cantidad)){
			$c = $c + 1;
			$c5 = $c5 +   $lista[5];    $c6 =  $c6 +  $lista[6];	    $c7 =  $c7 +  $lista[7];
			$c8 = $c8 +   $lista[8];	$c9 = $c9 +   $lista[9];   $c10 = $c10 + $lista[10];	$c11 = $c11 + $lista[11];
			$c12 = $c12 + $lista[12];	$c13 = $c13 + $lista[13];  $c14 = $c14 + $lista[14];	$c15 = $c15 + $lista[15];
			$c16 = $c16 + $lista[16];	$c17 = $c17 + $lista[17];  $c18 = $c18 + $lista[18];	$c19 = $c19 + $lista[19];
			$c20 = $c20 + $lista[20];	$c21 = $c21 + $lista[21];  $c22 = $c22 + $lista[22];		
			
	  		echo "<tr style='font-size:12px'><td align='center'>$c</td><td>$lista[0]</td><td>$lista[1]</td><td>$lista[2]</td><td>$lista[3] Nº $lista[4]</td><td align='right'>$lista[5]</td><td align='right'>$lista[6]</td><td align='right'>$lista[7]</td><td align='right'>$lista[8]</td><td align='right'>$lista[9]</td><td align='right'>$lista[10]</td><td align='right'>$lista[11]</td><td align='right'>$lista[12]</td><td align='right'>$lista[13]</td><td align='right'>$lista[14]</td><td align='right'>$lista[15]</td><td align='right'>$lista[16]</td><td align='right'>$lista[17]</td><td align='right'>$lista[18]</td><td align='right'>$lista[19]</td><td align='right'>$lista[20]</td><td align='right'>$lista[21]</td><td align='right'>$lista[22]</td></tr>";
		}
	}
  echo "<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr bgcolor='#F3EA72' align='right' style='font-size:12px'><td colspan='5' align = 'center'><strong>Totales</strong></td><td align='right'>$c5</td><td align='right'>$c6</td><td align='right'>$c7</td><td align='right'>$c8</td><td align='right'>$c9</td><td align='right'>$c10</td><td align='right'>$c11</td><td align='right'>$c12</td><td align='right'>$c13</td><td align='right'>$c14</td><td align='right'>$c15</td><td align='right'>$c16</td><td align='right'>$c17</td><td align='right'>$c18</td><td align='right'>$c19</td><td align='right'>$c20</td><td align='right'>$c21</td><td align='right'>$c22</td></tr>";

  ?>
</table>
</body>
</html>
