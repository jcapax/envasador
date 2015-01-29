<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("autenticacion.php");
	require('menu.php');
	include('conexion.php');
	$link = conexion();
?>
<html>
<head>
<title>Nuevos Usuarios</title>
</head>
<body>
<h2>Creaci&oacute;n de Nuevos Usuarios</h2>
<form name="form1" method="post" action="">
  <p>&nbsp;  </p>
  <table width="533" border="0">
    <tr>
      <td width="119">Codigo Usuario </td>
      <td colspan="3"><input name="codigo_usuario" type="text" id="codigo_usuario" size="5" maxlength="3"></td>	  
    </tr>
    <tr>
      <td>Login</td>
      <td colspan="3"><input name="login" type="text" id="login"></td>
    </tr>
    <tr>
      <td>Contrase&ntilde;a</td>
      <td width="120"><input name="contrasena1" type="password" id="contrasena1" size="20" maxlength="20"></td>
      <td width="140">Repetir Contrase&ntilde;a </td>
      <td width="126"><input name="contrasena2" type="password" id="contrasena2" size="20" maxlength="20"></td>
    </tr>
    <tr>
      <td>Nombre Usuario </td>
      <td colspan="3"><input name="nombre_usuario" type="text" id="nombre_usuario" size="40" maxlength="40"></td>
    </tr>
    <tr>
      <td>Acceso</td>
      <td colspan="3"><select name="acceso" id="acceso">
        <option value="0" selected="selected">Seleccionar</option>
        <option value="2">Recepcion Envases</option>
        <option value="3">Produccion</option>
        <option value="4">Despachos</option>
        <option value="5">Reportador</option>
      </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
