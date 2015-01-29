<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();
?>
<html>
<head>
<title>Reporte por Tipo Local</title>
</head>

<body>
</body>
</html>
