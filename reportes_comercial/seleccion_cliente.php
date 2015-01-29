<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="seleccion_cliente.php">
  <table width="630" border="0">
    <tr>
      <td colspan="2"><p>
          <label>
            <input name="ropcion" type="radio" value="0" checked="checked" />
            Nombre Cliente</label>
          <label>
            <input type="radio" name="ropcion" value="1" />
            Lugar</label>
          <label>
            <input type="radio" name="ropcion" value="2" />
            Zona</label>
          <label>
            <input type="radio" name="ropcion" value="3" />
            Calle</label>
          <label>
            <input type="radio" name="ropcion" value="4" />
            Canal</label>
          <label>
            <input type="radio" name="ropcion" value="5" />
            Tipo Local</label>
          <br />
      </p></td>
    </tr>
    <tr>
      <td width="54">Criterio:</td>
      <td width="566"><input name="criterio" type="text" id="criterio" size="30" maxlength="30" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<table width="766" border="0">
  <tr bgcolor="#FFCC00" align="center">
    <td width="62">C&oacute;digo</td>
    <td width="144">Nombre Cliente </td>
    <td width="104">Lugar</td>
    <td width="104">Zona</td>
    <td width="130">Direcci&oacute;n</td>
    <td width="83">Canal</td>
    <td width="109">Tipo Local </td>
  </tr>
  <?
		while($buscador = mysqli_fetch_array($sel_cliente)){
			$cli = dechex($buscador[0]);
			echo "<tr style='font-size:11px'><td><a href='../comercial.php?cliente=$cli'>$buscador[2]</a></td><td>$buscador[1]</td><td>$buscador[3] N&ordm; $buscador[4]</td><td>$buscador[5]</td><td align='center'><a href='../codificar_clientes.php?id_cliente=$cli&tipoR=E'><img src='../imagenes/editar.gif' border='0'></a></td></tr>";
		}
	?>
</table>
</body>
</html>
