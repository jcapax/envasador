<?
	require('menu.php');
	echo "<br>";
	require('menu_reporte.php');
	echo "<br>";
	include('../conexion.php');
	$link = conexion();
?>
<html>
<head>
<title>Créditos de Distribuidores Pendientes</title>
<style type="text/css">
.style5 {font-size: 12px; font-weight: bold; }
</style>
</head>

<body>
<?
	$sel = "select  v.idComercial,	v.`idDistribuidor`,	v.`nombreDistribuidor`, v.`nombreCliente`, CAST(v.`fechaCredito` AS DATE) AS fechaCredito, v.`precioTotal` as credito, sum(COALESCE(pc.importePago, 0)) as cancelado, (v.`precioTotal` - sum(COALESCE(pc.importePago, 0))) as diferencia  ";
	
	$fro = "from `v_creditoscomercial` v join itemLiquidacion `il` on `il`.idcomercial = v.idComercial left join pagoCredito pc on pc.`idComercial` = v.idComercial ";
	
	$gro = "group by  v.idComercial, v.`idDistribuidor`, v.`nombreDistribuidor`, v.`nombreCliente`, v.`fechaCredito`, v.`precioTotal` ";
	
	$hav = "HAVING (v.`precioTotal` - sum(COALESCE(pc.importePago, 0))) <> 0 order by v.idComercial";
?>

<table width="814" border="0">
  <tr bordercolor="#CC9933" bgcolor="#CC9933">
    <td width="22" bordercolor="#CC9933"><div align="center" class="style5">Id.</div></td>
    <td width="228" bordercolor="#CC9933"><div align="center" class="style5">Distribuidor</div></td>
    <td width="254" bordercolor="#CC9933"><div align="center" class="style5">Cliente</div></td>
    <td width="80" bordercolor="#CC9933"><div align="center" class="style5">Fecha Credito</div></td>
    <td width="66" bordercolor="#CC9933"><div align="center" class="style5">Credito</div></td>
    <td width="66" bordercolor="#CC9933"><div align="center" class="style5">Cancelado</div></td>
    <td width="68" bordercolor="#CC9933"><div align="center" class="style5">Diferencia</div></td>
  </tr>
  <?
  	$cre = 0;
	$can = 0;
	$dif = 0;
	
  	$sql = mysqli_query($link, $sel.$fro.$gro.$hav);
  	while ($fil = mysqli_fetch_array($sql)){
		echo "<tr style='font-size:11px'>";
			echo "<td align='right'>$fil[idComercial]</td>";
			echo "<td>$fil[nombreDistribuidor]</td>";
			echo "<td>$fil[nombreCliente]</td>";
			echo "<td>$fil[fechaCredito]</td>";
			echo "<td align='right'>$fil[credito]</td>";
			echo "<td align='right'>$fil[cancelado]</td>";
			echo "<td align='right'>$fil[diferencia]</td>";
		echo "</tr>";

		$cre = $cre + $fil[credito];
		$can = $can + $fil[cancelado];
		$dif = $dif + $fil[diferencia];
	}
  ?>
  <tr bordercolor="#CC9933" bgcolor="#CC9933" align="center" style='font-size:15px'>
    <td colspan="4" bordercolor="#CC9933"><span class="style5">Totales</span></td>
    <td align="right"><? echo $cre?></td>
    <td align="right"><? echo $can?></td>
    <td align="right"><? echo $dif?></td>
  </tr>
</table>
</body>
</html>