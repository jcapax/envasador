<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login = $_SESSION["login"];
	$acceso = $_SESSION["acceso"];
	
	include("../autenticacion.php");
	require('menu.php');
	include('../conexion.php');
	$link = conexion();
	
	$id_cliente  = hexdec($_GET['id_cliente']);
	$f1          = $_GET['f1'];
	$f2          = $_GET['f2'];
	
	$sql_dis = mysqli_query($link,"SELECT c.idCliente,f_nombre_cliente(c.idCliente),c.idDistribuidor,f_nombre_distribuidor(c.idDistribuidor),nombreLugar,nombreZona,nombreCalle,numero,nombreLocal, COUNT(*) FROM itemComercial i JOIN comercial c USING(idComercial) JOIN clientes l ON c.idCliente = l.idCliente JOIN lugares u ON l.idLugar = u.idLugar JOIN zonas z ON l.idZona = z.idZona JOIN calles a ON l.idCalle = a.idcalle JOIN locales o ON l.idLocal = o.idLocal WHERE fecha BETWEEN '$f1' AND '$f2' AND bonificacion = 0 AND recuperacion = 0 AND c.estado = 1  AND c.idCLiente = '$id_cliente' GROUP BY c.idCliente,f_nombre_cliente(c.idCliente),c.idDistribuidor, f_nombre_distribuidor(c.idDistribuidor) , nombreLugar, nombreZona, nombreCalle, numero,nombreLocal;");

	$sql_prod =  mysqli_query($link,"SELECT fecha,SUM(IF(IdProducto = 1,Cantidad,0)) 'BotEsp',SUM(IF(IdProducto = 2,Cantidad,0)) 'BotSesq',SUM(IF(IdProducto = 3,Cantidad,0)) 'BotStou',SUM(IF(IdProducto = 17,Cantidad,0)) 'BotBic',SUM(IF(IdProducto = 4,Cantidad,0)) 'LatEsp',SUM(IF(IdProducto = 5,Cantidad,0)) 'LatSesq',SUM(IF(IdProducto = 6,Cantidad,0)) 'LatStou',SUM(IF(IdProducto = 20,Cantidad,0)) 'latBic',SUM(IF(IdProducto = 7,Cantidad,0)) 'BlinEsp',SUM(IF(IdProducto = 8,Cantidad,0)) 'BlinSesq',SUM(IF(IdProducto = 9,Cantidad,0)) 'BlinStou',SUM(IF(IdProducto = 10,Cantidad,0)) 'Blin33',SUM(IF(IdProducto = 18,Cantidad,0)) 'blinBic',SUM(IF(IdProducto = 11,Cantidad,0)) 'ChopEsp',SUM(IF(IdProducto = 12,Cantidad,0)) 'ChopSes',SUM(IF(IdProducto = 19,Cantidad,0)) 'chopBic', ROUND(SUM(IF(idProducto<>14,precioTotal,0)),2) as Precio FROM itemComercial i JOIN comercial c USING(idComercial) WHERE fecha BETWEEN '$f1' AND '$f2' AND bonificacion = 0 AND recuperacion = 0 AND c.estado = 1 AND c.idCLiente = '$id_cliente' GROUP BY fecha;");
?>
<html>
<head>
<title>Venta Cliente</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<h1>DETALLE VENTA CERVEZA CLIENTE</h1>
<p><? echo "<h2>Entre $f1 y $f2</h2>";?></p>
<table width="448" border="0">
  <tr bgcolor="#FFCC00">
    <td width="177">Cliente</td>
    <td width="211">Distribuidor</td>
    <td width="46">Visitas</td>
  </tr>
<?
	$visitas = mysqli_num_rows($sql_prod);
	while($fil_dis = mysqli_fetch_array($sql_dis)){
		echo "<tr style='Font-size:12px'>";
			echo "<td>$fil_dis[1]</td>";
			echo "<td>$fil_dis[3]</td>";
			echo "<td align='center'>$visitas</td>";
		echo "</tr>";
	}
?>
</table>
<hr>
<table width="670" border="0">
  <tr align="center" bgcolor="#CC9933">
    <td width="18" rowspan="2"><span class="Estilo1 Estilo1">N&ordm;</span></td>
    <td width="125" rowspan="2"><span class="Estilo1 Estilo1">Fecha<br>
    </span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Botella</span></td>
    <td colspan="4"><span class="Estilo1 Estilo1">Lata</span></td>
    <td colspan="5"><span class="Estilo1">Botellin</span></td>
    <td colspan="3"><span class="Estilo1 Estilo1">Chopp</span></td>
    <td width="39" rowspan="2"><div align="right" class="Estilo1">
      <div align="center">Precio</div>
    </div></td>
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
    <td width="16" bgcolor="#F3EA72"><div align="right">33</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
    <td width="23" bgcolor="#F3EA72"><div align="right">Esp</div></td>
    <td width="30" bgcolor="#F3EA72"><div align="right">Sesq</div></td>
    <td width="20" bgcolor="#F3EA72"><div align="right">Bic</div></td>
  </tr>
  <? 
	  	$c = 0;
		$c1 = 0;  $c2 = 0; $c3 = 0; 
		$c4 = 0;  $c5 = 0; $c6 = 0; $c7 = 0; $c8 = 0; $c9 = 0;
		$c10 = 0; $c11 = 0; $c12 = 0; $c13 = 0; $c14 = 0; $c15 = 0;
		$c16 = 0; $c17 = 0;$c18 = 0; $c19 = 0; $c20 = 0.0;
		
  		while($lista = mysqli_fetch_array($sql_prod)){
			$c = $c + 1;

			$c1 = $c1 +   $lista[1];    $c2 = $c2 +   $lista[2];   $c3 = $c3 +   $lista[3];    $c4 =  $c4 +  $lista[4];	    
			$c5 = $c5 +   $lista[5];    $c6 =  $c6 +  $lista[6];   $c7 =  $c7 +  $lista[7];
			$c8 = $c8 +   $lista[8];	$c9 = $c9 +   $lista[9];   $c10 = $c10 + $lista[10];	$c11 = $c11 + $lista[11];
			$c12 = $c12 + $lista[12];	$c13 = $c13 + $lista[13];  $c14 = $c14 + $lista[14];	$c15 = $c15 + $lista[15];
			$c16 = $c16 + $lista[16];	$c17 = $c17 + $lista[17];  $c18 = $c18 + $lista[18];	$c19 = $c19 + $lista[19];
			
			$pre_ind = number_format($lista[17], 2, '.', ',');
			
	  		echo "<tr style='font-size:12px' align='right'><td align='center'>$c</td><td align='left'>$lista[0]</td><td align='right'>$lista[1]</td><td>$lista[2]</td><td>$lista[3]</td><td align='right'>$lista[4]</td><td align='right'>$lista[5]</td><td align='right'>$lista[6]</td><td align='right'>$lista[7]</td><td align='right'>$lista[8]</td><td align='right'>$lista[9]</td><td align='right'>$lista[10]</td><td align='right'>$lista[11]</td><td align='right'>$lista[12]</td><td align='right'>$lista[13]</td><td align='right'>$lista[14]</td><td align='right'>$lista[15]</td><td align='right'>$lista[16]</td><td align='right'>$pre_ind</td></tr>";
		}

	$c17 = number_format($c17, 2, '.', ',');
  echo "<tr><td colspan='19'><hr></td></tr><tr bgcolor='#F3EA72' align='right' style='font-size:12px'><td colspan='2' align='center'><strong>Totales</strong></td><td align='right'>$c1</td><td align='right'>$c2</td><td align='right'>$c3</td><td align='right'>$c4</td><td align='right'>$c5</td><td align='right'>$c6</td><td align='right'>$c7</td><td align='right'>$c8</td><td align='right'>$c9</td><td align='right'>$c10</td><td align='right'>$c11</td><td align='right'>$c12</td><td align='right'>$c13</td><td align='right'>$c14</td><td align='right'>$c15</td><td align='right'>$c16</td><td align='right'>$c17</td></tr>";

  ?>
</table>
<hr>
</body>
</html>
