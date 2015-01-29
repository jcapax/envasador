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
<title>Distribuicion Cerveza</title>
</head>

<body>
<p></p>
<?
	$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
	$fil_fecha = mysqli_fetch_row($sql_fecha);
?>
<form name="form1" method="post" action="graf.php">
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
            <option value="1"<? if($fil_fecha[2]==1){?>selected<? }?>>1</option>
            <option value="2"<? if($fil_fecha[2]==2){?>selected<? }?>>2</option>
            <option value="3"<? if($fil_fecha[2]==3){?>selected<? }?>>3</option>
            <option value="4"<? if($fil_fecha[2]==4){?>selected<? }?>>4</option>
            <option value="5"<? if($fil_fecha[2]==5){?>selected<? }?>>5</option>
            <option value="6"<? if($fil_fecha[2]==6){?>selected<? }?>>6</option>
            <option value="7"<? if($fil_fecha[2]==7){?>selected<? }?>>7</option>
            <option value="8"<? if($fil_fecha[2]==8){?>selected<? }?>>8</option>
            <option value="9"<? if($fil_fecha[2]==9){?>selected<? }?>>9</option>
            <option value="10"<? if($fil_fecha[2]==10){?>selected<? }?>>10</option>
            <option value="11"<? if($fil_fecha[2]==11){?>selected<? }?>>11</option>
            <option value="12"<? if($fil_fecha[2]==12){?>selected<? }?>>12</option>
            <option value="13"<? if($fil_fecha[2]==13){?>selected<? }?>>13</option>
            <option value="14"<? if($fil_fecha[2]==14){?>selected<? }?>>14</option>
            <option value="15"<? if($fil_fecha[2]==15){?>selected<? }?>>15</option>
            <option value="16"<? if($fil_fecha[2]==16){?>selected<? }?>>16</option>
            <option value="17"<? if($fil_fecha[2]==17){?>selected<? }?>>17</option>
            <option value="18"<? if($fil_fecha[2]==18){?>selected<? }?>>18</option>
            <option value="19"<? if($fil_fecha[2]==19){?>selected<? }?>>19</option>
            <option value="20"<? if($fil_fecha[2]==20){?>selected<? }?>>20</option>
            <option value="21"<? if($fil_fecha[2]==21){?>selected<? }?>>21</option>
            <option value="22"<? if($fil_fecha[2]==22){?>selected<? }?>>22</option>
            <option value="23"<? if($fil_fecha[2]==23){?>selected<? }?>>23</option>
            <option value="24"<? if($fil_fecha[2]==24){?>selected<? }?>>24</option>
            <option value="25"<? if($fil_fecha[2]==25){?>selected<? }?>>25</option>
            <option value="26"<? if($fil_fecha[2]==26){?>selected<? }?>>26</option>
            <option value="27"<? if($fil_fecha[2]==27){?>selected<? }?>>27</option>
            <option value="28"<? if($fil_fecha[2]==28){?>selected<? }?>>28</option>
            <option value="29"<? if($fil_fecha[2]==29){?>selected<? }?>>29</option>
            <option value="30"<? if($fil_fecha[2]==30){?>selected<? }?>>30</option>
            <option value="31"<? if($fil_fecha[2]==31){?>selected<? }?>>31</option>
        </select></td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><select name="canno2" id="canno2">
        <option value="0" selected>Selec.</option>
        <option value="2007"<? if($fil_fecha[0]==2007){?>selected<? }?>>2007</option>
        <option value="2008"<? if($fil_fecha[0]==2008){?>selected<? }?>>2008</option>
        <option value="2009"<? if($fil_fecha[0]==2009){?>selected<? }?>>2008</option>
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
            <option value="1"<? if($fil_fecha[2]==1){?>selected<? }?>>1</option>
            <option value="2"<? if($fil_fecha[2]==2){?>selected<? }?>>2</option>
            <option value="3"<? if($fil_fecha[2]==3){?>selected<? }?>>3</option>
            <option value="4"<? if($fil_fecha[2]==4){?>selected<? }?>>4</option>
            <option value="5"<? if($fil_fecha[2]==5){?>selected<? }?>>5</option>
            <option value="6"<? if($fil_fecha[2]==6){?>selected<? }?>>6</option>
            <option value="7"<? if($fil_fecha[2]==7){?>selected<? }?>>7</option>
            <option value="8"<? if($fil_fecha[2]==8){?>selected<? }?>>8</option>
            <option value="9"<? if($fil_fecha[2]==9){?>selected<? }?>>9</option>
            <option value="10"<? if($fil_fecha[2]==10){?>selected<? }?>>10</option>
            <option value="11"<? if($fil_fecha[2]==11){?>selected<? }?>>11</option>
            <option value="12"<? if($fil_fecha[2]==12){?>selected<? }?>>12</option>
            <option value="13"<? if($fil_fecha[2]==13){?>selected<? }?>>13</option>
            <option value="14"<? if($fil_fecha[2]==14){?>selected<? }?>>14</option>
            <option value="15"<? if($fil_fecha[2]==15){?>selected<? }?>>15</option>
            <option value="16"<? if($fil_fecha[2]==16){?>selected<? }?>>16</option>
            <option value="17"<? if($fil_fecha[2]==17){?>selected<? }?>>17</option>
            <option value="18"<? if($fil_fecha[2]==18){?>selected<? }?>>18</option>
            <option value="19"<? if($fil_fecha[2]==19){?>selected<? }?>>19</option>
            <option value="20"<? if($fil_fecha[2]==20){?>selected<? }?>>20</option>
            <option value="21"<? if($fil_fecha[2]==21){?>selected<? }?>>21</option>
            <option value="22"<? if($fil_fecha[2]==22){?>selected<? }?>>22</option>
            <option value="23"<? if($fil_fecha[2]==23){?>selected<? }?>>23</option>
            <option value="24"<? if($fil_fecha[2]==24){?>selected<? }?>>24</option>
            <option value="25"<? if($fil_fecha[2]==25){?>selected<? }?>>25</option>
            <option value="26"<? if($fil_fecha[2]==26){?>selected<? }?>>26</option>
            <option value="27"<? if($fil_fecha[2]==27){?>selected<? }?>>27</option>
            <option value="28"<? if($fil_fecha[2]==28){?>selected<? }?>>28</option>
            <option value="29"<? if($fil_fecha[2]==29){?>selected<? }?>>29</option>
            <option value="30"<? if($fil_fecha[2]==30){?>selected<? }?>>30</option>
            <option value="31"<? if($fil_fecha[2]==31){?>selected<? }?>>31</option>
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
</body>
</html>
