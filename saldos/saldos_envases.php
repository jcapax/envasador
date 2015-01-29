<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();

	if (!($acceso == 1)and!($acceso == 2)) {
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}

	if($_POST){
		
		$canno        = $_POST['canno'];
		$cmes         = $_POST['cmes'];
		$cdia         = $_POST['cdia'];
		$distribuidor = $_POST['distribuidor'];
		$detalle      = $_POST['detalle'];
		$canastillos  = $_POST['canastillos'];
		$botellas     = $_POST['botellas'];
	  	if(!checkdate($cmes,$cdia,$canno))
		{ 
			  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
			  echo"<a href='saldos_envases.php'>Volver</a>";
			  die;
		}
		else { $fecha = $canno.'-'.$cmes.'-'.$cdia;}
		
		if($distribuidor == 0){
			  echo '<br>'.'Seleccionar Distribuidor!!!'.'<br>';
			  echo"<a href='saldos_envases.php'>Volver</a>";
			  die;			
		}
		
		$sql_dist_reg = mysqli_query($link,"SELECT * FROM saldosinicialesenvasesdistribuidores WHERE idDistribuidor='$distribuidor'");
		$fil_dist_reg = mysqli_num_rows($sql_dist_reg);
		
		if($fil_dist_reg==1){
			  echo '<br>'.'El Distribuidor Seleccionado ya se Encuentra Registrado, Favor Revisar!!!'.'<br>';
			  echo"<a href='saldos_envases.php'>Volver</a>";
			  die;								
		}
		
		echo $distribuidor.'>>>'.$fecha.'>>>'.$detalle.'>>>'.$canastillos.'>>>'.$botellas.'>>>'.$codigo_usuario;
		mysqli_query($link,"INSERT INTO saldosInicialesEnvasesDistribuidores(idDistribuidor,fecha,detalle,canastillos,botellas,estado,codigoUsuario,fechaHoraRegistro) VALUES('$distribuidor','$fecha','$detalle','$canastillos','$botellas',0,'$codigo_usuario',now());");
	}
?>
<html>
<head>
<title>Saldos Iniciales Envases Clientes</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<h1>SALDOS INICIALES ENVASES DISTRIBUIDORES
</h1>
<form action="saldos_envases.php" method="post" name="form1" id="form1">
  <table width="614" border="0">
    <tr>
      <td width="86">Fecha:</td>
      <td colspan="3">
          <select name="canno" id="canno">
            <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2009</option>
        </select>
          <select name="cmes" id="cmes">
            <option value="0" selected="selected">Selec.</option>
            <option value="1">Enero</option>
            <option value="2">Febr.</option>
            <option value="3">Marzo</option>
            <option value="4" selected="selected">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Sept.</option>
            <option value="10">Octub.</option>
            <option value="11">Novie.</option>
            <option value="12">Dicie.</option>
        </select>
          <select name="cdia" id="cdia">
            <option value="1">1</option>
            <?
		  	$d = 2;
			while ($d <= 31){
				echo "<option value='$d'>$d</option>";
				$d = $d + 1;
			}
		  ?>
        </select>
    </td>
    </tr>
    <tr>
      <td>Distribuidor:</td>
	  <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	  ?>
      <td colspan="3"><select name="distribuidor" id="distribuidor">
        <option value="0">Seleccionar</option>
        <? 
			while ($fil_dist = mysqli_fetch_array($sql_dist)){
				echo "<option value='$fil_dist[0]'>$fil_dist[1]</option>";
			}
		?>
      </select></td>
      <?
   		$sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND flag = 1 ORDER BY NombreDistribuidor");
	  ?>
    </tr>
    <tr>
      <td>Detalle</td>
      <td colspan="3"><input name="detalle" type="text" id="detalle" size="45"></td>
    </tr>
    <tr>
      <td><label>Canastillos: </label></td>
      <td width="93"><input name="canastillos" type="text" id="canastillos" size="5" maxlength="5" /></td>
      <td width="48">Botellas</td>
      <td width="369"><input name="botellas" type="text" id="botellas" size="5" maxlength="5" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
</form>

<table width="732" border="0">
  <tr bgcolor="#CC9933" align="center">
    <td width="254" height="21"><span class="style1">Distribuidor</span></td>
    <td width="77"><span class="style1">Fecha</span></td>
    <td width="134"><span class="style1">Detalle</span></td>
    <td width="65"><span class="style1">Canastillos</span></td>
    <td width="48"><span class="style1">Botellas</span></td>
    <td width="62"><span class="style1">Editar</span></td>
    <td width="62"><span class="style1">Confirmar</span></td>
  </tr>
  <?
	$sel_saldos = mysqli_query($link,"SELECT idDistribuidor,f_nombre_distribuidor(idDistribuidor), fecha, detalle, canastillos, botellas, estado FROM saldosInicialesEnvasesDistribuidores ORDER BY f_nombre_distribuidor(idDistribuidor);");
	$sbot = 0;
	$scan = 0;
	while($reg_saldos = mysqli_fetch_array($sel_saldos)){
		$bin = dechex($reg_saldos[0]);
		if($reg_saldos[6]==0){	
			echo "<tr style='font-size:12px'><td>$reg_saldos[1]</td><td>$reg_saldos[2]</td><td>$reg_saldos[3]</td><td align='right'>$reg_saldos[4]</td><td align='right'>$reg_saldos[5]</td><td align='center'><a href=''><img src='../imagenes/editar.gif' border='0'></a></td><td align='center'><a href='confirmar_saldo_envase.php?distribuidor=$bin'><img src='../imagenes/ok.gif' border='0'></a></td></tr>";
		}
		else{	 
			echo "<tr bgcolor='#C6FBAC' style='font-size:12px'><td>$reg_saldos[1]</td><td>$reg_saldos[2]</td><td>$reg_saldos[3]</td><td align='right'>$reg_saldos[4]</td><td align='right'>$reg_saldos[5]</td><td></td><td></td></tr>";
			$sbot = $sbot + $reg_saldos[5];
			$scan = $scan + $reg_saldos[4];
		}
	}
	echo "<tr bgcolor='#CC9933'><td colspan='3' align='center'>Totales Confirmados</td><td align='right'>$scan</td><td align='right'>$sbot</td><td colspan='2'></td></tr>";
?>
</table>
</body>
</html>
