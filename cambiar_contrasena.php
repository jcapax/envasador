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
	
	if ($_POST){
		$cactual = $_POST['cactual'];
		$cnueva  = $_POST['cnueva'];
		$crepite = $_POST['crepite'];	
		
		if ($crepite == $cnueva){
			if ($cactual <> $cnueva){
				$ca = mysqli_query($link,"SELECT contrasena FROM usuarios WHERE codigoUsuario = '$codigo_usuario'");
				$pass_acctual = mysqli_fetch_array($ca);

				$cf = mysqli_query($link,"SELECT MD5('$cactual')");
				$pass_form = mysqli_fetch_array($cf);
				
				echo $pass_form[0].' '.$pass_acctual[0];
				
				if($pass_form[0] == $pass_acctual[0]){
					mysqli_query($link,"UPDATE usuarios SET contrasena = MD5('$cnueva') WHERE codigoUsuario = '$codigo_usuario'");
					header("Location: cerrarsesion.php");
				}
				else{
					echo "<h3>La contraseña original, no coincide con la proporcionada!!!</h3>";
				}
			}			
			else{
				echo "<h3>La nueva contraseña proporcionada debe ser diferente a la contraseña anterior!!!</h3>";
			}
		}
		else{
			echo "<h3>La contraseña nueva no coincide, repetir!!!</h3>";
		}
	}
?>
<html>
<head>
<title>Cambio Contraseña</title>
<style type="text/css">
<!--
#Layer1 {	position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
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
<h2>CAMBIO CONTRASE&Ntilde;A</h2>
<?
	$sql = mysqli_query($link,"Select nombreUsuario FROM usuarios WHERE codigoUsuario = '$codigo_usuario'");
	$usuario = mysqli_fetch_array($sql);
?>
<form name="form1" method="post" action="cambiar_contrasena.php">
  <table width="440" border="0">
    <tr>
      <td width="198">Usuario</td>
      <td width="232"><input name="textfield" type="text" value="<? echo $usuario[0]?>" size="35" maxlength="35" readonly=""></td>
    </tr>
    <tr>
      <td>Contase&ntilde;a Actual </td>
      <td><input name="cactual" type="password" id="cactual" size="15"></td>
    </tr>
    <tr>
      <td>Nueva Contrase&ntilde;a </td>
      <td><input name="cnueva" type="password" id="cnueva" size="15"></td>
    </tr>
    <tr>
      <td>Repetir Nueva Contrase&ntilde;a </td>
      <td><input name="crepite" type="password" id="crepite" size="15"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
ob_end_flush();
?>