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
	
	$tamano_pagina = 50;
	$pagina = $_GET['pagina'];
	if (!$pagina) {
    $inicio = 0;
    $pagina=1;
	}
	else {
    $inicio = ($pagina - 1) * $tamano_pagina ;
	}
	
	
	if($acceso >= 5){
		header("Location: comercial.php");
		echo "<h2>ZONA RESTRINGIDA !!!</h2>";
		die;
	}
?>
<html>
<head>
<title>Recepción de Envases</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
#Layer1 {
	position:absolute;
	left:515px;
	top:8px;
	width:110px;
	height:54px;
	z-index:1;
}
.style2 {
	font-size: 22px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<h1>PROCESOS</h1>
<?
	if (($acceso == 1)or($acceso == 2)) {
		echo "<a href='saldos/saldos_envases.php'>Saldos Iniciales Envases Distribuidores</a>";
	}
?>
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
    <tr>
      <td colspan="2"><a href='cambiar_contrasena.php'>Cambio Contraseña</a></td>
    </tr>
  </table>
</div>
<form name="form1" method="post" action="msg_procesos.php">
  <table width="54%" border="0">
    <tr>
		<?
			if ($acceso==1){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas");		
					$registros = mysqli_query($link,'Select Count(*) From procesos');	
					//$sql_where = ' WHERE P.estado = 0';
					$sql_where = ' ';
				}

			if ($acceso==2){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE ((TipoNota BETWEEN 1 AND 2)or(TipoNota = 5))");				
					$registros = mysqli_query($link,'Select Count(*) From procesos Where ((TipoNota BETWEEN 1 AND 2)or(TipoNota = 5))');
					$sql_where = ' WHERE ((p.TipoNota IN(1,2,5))) ';

				}

			if ($acceso==3){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota = 3");	
					$registros = mysqli_query($link,'Select Count(*) From procesos Where TipoNota = 3');			
					$sql_where = ' WHERE (p.TipoNota = 2 AND p.Estado = 1) or (p.TipoNota = 3) ';	
				}
		
			if ($acceso==4){
					$sql_notas = mysqli_query($link,"SELECT TipoNota, NombreNota FROM Notas WHERE TipoNota IN(4,6)");				
					$registros = mysqli_query($link,'Select Count(*) From procesos Where TipoNota IN(4,6)');
					$sql_where = ' WHERE (p.TipoNota =3 AND p.Estado = 1)OR(p.TipoNota  IN(4,6)) ';
				}
			$total_reg = mysqli_fetch_array($registros);
			$total_paginas = ceil($total_reg[0]/$tamano_pagina);		
		?>
      <td width="20%">Tipo Nota</td>	  
      <td width="22%">
      <input name="acceso" type="hidden" id="acceso" value="<? echo $acceso?>">
      <select name="tipo_nota" id="tipo_nota">
        <option value='0'>Seleccionar</option>
		<?
			while($fil_notas = mysqli_fetch_array($sql_notas)){
				?><option value='<? echo $fil_notas[0]?>'><? echo $fil_notas[1]?></option><?
			}
		//	if($acceso==2){
		//		echo "<option value='5'>DESCUENTOS ENVASES DISTRIBUIDOR</option>";
		//	}			
		?>
        </select></td>
      <? if (($acceso == 1)or($acceso == 2)or($acceso == 4)){	  
	  ?>  
      <td width="10%">N&ordm; Nota</td>      
      <td width="48%"><input name="nroNota" type="text" id="nroNota" value="0" size="10" maxlength="10"></td>
      <? }?>
    </tr>
    <tr>
		<?
   			 $sql_dist = mysqli_query($link,"SELECT IdDistribuidor, NombreDistribuidor FROM Distribuidores WHERE Estado = 1 AND IdDistribuidor > 0 AND flag = 1 ORDER BY NombreDistribuidor");
			 if ($acceso <> 3){
		?>
      <td>Distribuidor</td>	  
      <td colspan="3"><select name="distribuidor" id="distribuidor">
        <option value="0">Seleccionar</option>
		<?
			while($fil_dist = mysqli_fetch_array($sql_dist)){
				?><option value='<? echo $fil_dist[0]?>'><? echo $fil_dist[1]?></option><?
			}
		?>
            </select>
		<? }?>      </td>
    </tr>
    <tr>
	<?
		$sql_fecha = mysqli_query($link,"SELECT YEAR(NOW()),MONTH(NOW()),DAY(NOW())");
		$fil_fecha = mysqli_fetch_row($sql_fecha);
	?>
      <td>Fecha:</td>
      <td colspan="3">
      	<select name="canno" id="canno">
          <option value="0">Selec.</option>
          <option value="2009">2009</option>		  
          <option value="2010">2010</option>
          <option value="2011">2011</option>
	  	  <option value="2012">2012</option>
	  	  <option value="2013">2013</option>
	  	  <option value="2014">2014</option>
	  	  <option value="2015" selected="selected">2015</option>
        </select>
        <select name="cmes" id="cmes">
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
        <select name="cdia" id="cdia">
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
      <td>Detalle</td>
      <td colspan="3"><input name="detalle" type="text" id="detalle" size="70" maxlength="100"></td>
    </tr>
    <tr>
      <td><strong>
        <input type="submit" name="Submit" value="Enviar">
      </strong></td>
      <td colspan="3"></td>
    </tr>
  </table>
</form>
  <p></p>
  <? 
  	echo "Página: ";
  	if ($total_paginas > 1){
    for ($i=1;$i<=$total_paginas;$i++){
       if ($pagina == $i)
          //si muestro el índice de la página actual, no coloco enlace
		  echo "<span class='style2'>$pagina</span> ";
//          echo $pagina . " "; 		  
       else{
          //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
          echo "<a href='procesos.php?pagina=$i'>$i</a> ";
		}	 
    }
	} 

  ?>
  <table width="857" border="0">
    <tr bgcolor="#CC9933">
	  <td width="34"><span class="style1">Proc.</span></td>
      <td width="64"><span class="style1">Fecha</span></td>
      <td width="186"><span class="style1">Tipo Nota</span></td>
      <td width="211"><span class="style1">Distribuidor</span></td>
      <td width="204"><span class="style1">Detalle</span></td>
      <td width="33"><span class="style1">Impr.</span></td>
      <td width="42"><span class="style1">Confir.</span></td>
      <td width="28"><span class="style1">Edit.</span></td>
      <td width="17">&nbsp;</td>
    </tr>
    <?	
		$sql_sf = 'SELECT p.IdProceso, p.TipoNota, n.NombreNota, d.NombreDistribuidor, p.Fecha, p.Estado, p.Detalle FROM procesos p JOIN Notas n ON p.TipoNota = n.TipoNota LEFT JOIN Distribuidores d ON p.IdDistribuidor = d.IdDistribuidor';
		$sql_lim = "LIMIT $inicio,$tamano_pagina";
		$sql_ord = ' ORDER BY p.fecha DESC, p.idProceso DESC ';
		$sql_tot = $sql_sf.''.$sql_where.''.$sql_ord.''.$sql_lim;
		
//		echo $sql_tot;
		
		//echo $sql_tot;
//		echo $sql_tot.' *** '.$inicio.' *** '.$tamano_pagina.'%%%%%';
//  	$sql_lista_proc = mysqli_query($link,"CALL sp_lista_procesos($acceso,$inicio,$tamano_pagina);");
//	$sql_lista_proc = mysqli_query($link,"CALL sp_lista_procesos($acceso);");
	$sql_proc = mysqli_query($link,$sql_tot)
	or die("Error: ".mysqli_error($link));
	while($fil_lista_proc = mysqli_fetch_array($sql_proc)){
		if($fil_lista_proc[5]==0){
			echo "<tr style='font-size:11px'><td bgcolor='#FFCC00'><a href=editar_proceso.php?id_proceso=$fil_lista_proc[0]&tipo_nota=$fil_lista_proc[1]>$fil_lista_proc[0]</a></td><td>$fil_lista_proc[4]</td><td>$fil_lista_proc[2]</td><td>$fil_lista_proc[3]</td><td>$fil_lista_proc[6]</td><td align='center'><a href='impre_item_proceso.php?id_proceso=$fil_lista_proc[0]&tipo_nota=$fil_lista_proc[1]&conf=0'><img src='imagenes/impresora.gif' border='0'></a></td><td align='center'><a href='confirmar_proceso.php?id_proceso=$fil_lista_proc[0]&tipo_nota=$fil_lista_proc[1]'><img src='imagenes/ok.gif' border='0'></td><td align='center'><a href='item_proceso.php?id_proceso=$fil_lista_proc[0]&tipo_nota=$fil_lista_proc[1]&acceso=$acceso'><img src='imagenes/editar.gif' border='0'></a></td><td align='center'><img src='imagenes/eliminar.png' border='0'></td></tr>";
		}
		else{
			echo "<tr style='font-size:11px' bgcolor='#C6FBAC'><td bgcolor='#FFCC00'>$fil_lista_proc[0]</td><td>$fil_lista_proc[4]</td><td>$fil_lista_proc[2]</td><td>$fil_lista_proc[3]</td><td>$fil_lista_proc[6]</td><td align='center'><a href='impre_item_proceso.php?id_proceso=$fil_lista_proc[0]&tipo_nota=$fil_lista_proc[1]&conf=1'><img src='imagenes/impresora.gif' border='0'></a><td></tr>";	
		}		
	}
  ?>
</table>
<p></p>
</body>
</html>
<?php
ob_end_flush();
?> 