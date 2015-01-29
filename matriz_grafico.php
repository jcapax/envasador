<?php
ob_start();
?> 
<?
	include('conexion.php');	
	require('menu.php');

	$link = conexion();

	$canno1 = $_POST['canno1'];	
	$cmes1 = $_POST['cmes1'];
	$cdia1 = $_POST['cdia1'];

	$canno2 = $_POST['canno2'];
	$cmes2 = $_POST['cmes2'];
	$cdia2 = $_POST['cdia2'];
	
	$tipo_nota = $_POST['tipo_nota'];	
	
	$distribuidor = $_POST['distribuidor'];
	
	if(! checkdate($cmes1,$cdia1,$canno1))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="distribucion.php">volver</a><?
	  die;
	}
	else { $fecha1 = $canno1.'-'.$cmes1.'-'.$cdia1;}

	if(! checkdate($cmes2,$cdia2,$canno2))
	{ 
	  echo '<br>'.'Fecha incorrecta!!!'.'<br>';
	  ?><a href="distribucion.php">volver</a><?
	  die;
	}
	else { $fecha2 = $canno2.'-'.$cmes2.'-'.$cdia2;}
	
	$sql_dist = mysqli_query($link,"SELECT f_nombre_distribuidor('$distribuidor')");
	
	$nom_dist = mysqli_fetch_array($sql_dist);
	
	$c = 0;
	$sql = mysqli_query($link,"call sp_estadistica('$tipo_nota','$fecha1','$fecha2','$distribuidor')");
	
	if($tipo_nota == 1){			
		if ($distribuidor == 0){
			$botellas = array();
			$cajas = array();
			$fecha = array();
	
			while($res = mysqli_fetch_array($sql)){	
				$botellas[$c] = $res[2];
				$cajas[$c] = $res[3];
				$fecha[$c] = $res[1];
				$c++;
			}		
			$bot = implode(",",$botellas);
			$caj = implode(",",$cajas);
			$fech = implode(",",$fecha);
			
			header("Location: estadistica_recepcion.php?bot=$bot&caj=$caj&nom_dist=-&fecha=$fech");
		}
		else{
			$botellas = array();
			$cajas = array();
			$fecha = array();
	
			while($res = mysqli_fetch_array($sql)){	
				$botellas[$c] = $res[2];
				$cajas[$c] = $res[3];
				$fecha[$c] = $res[1];
				$c++;
			}		
			$bot = implode(",",$botellas);
			$caj = implode(",",$cajas);
			$fech = implode(",",$fecha);
			
			header("Location: estadistica_recepcion.php?bot=$bot&caj=$caj&nom_dist=$nom_dist[0]&fecha=$fech");		
		}
		
	}
	
	if($tipo_nota == 3){
		$fecha = array();
		$especial = array();
		$sesqui = array();
		$stout = array();
		$b33 = array(); 		
		
		while($res = mysqli_fetch_array($sql)){	
			$fecha_[$c] = $res[1];
			$especial_[$c] = $res[2];
			$sesqui_[$c] = $res[3];
			$stout_[$c] = $res[4];
			$b33_[$c] = $res[5];
			$bic_[$c] = $res[6];
			$c++;
		}
		$fecha = implode(",",$fecha_);
		$especial = implode(",",$especial_);
		$sesqui = implode(",",$sesqui_);
		$stout = implode(",",$stout_);
		$b33 = implode(",",$b33_);
		$bic = implode(",",$bic_);

		header("Location: estadistica_produccion.php?fecha=$fecha&especial=$especial&sesqui=$sesqui&stout=$stout&b33=$b33&bic=$bic");
	}
//*********************************************************	
	if($tipo_nota == 4){
		$fecha = array();
		
		$botEsp = array();
		$botSes = array();
		$botSto = array();
		
		$latEsp = array();
		$latSes = array();
		$latSto = array();
		
		$bllEsp = array();
		$bllSes = array();
		$bllSto = array();
		$bll33 = array();
			
		$choEsp = array();
		$choSes = array();
		
		while($res = mysqli_fetch_array($sql)){	
			$fecha_[$c] = $res[0];			
			$botEsp_[$c] = $res[1];
			$botSes_[$c] = $res[2];
			$botSto_[$c] = $res[3];			
			$latEsp_[$c] = $res[4];
			$latSes_[$c] = $res[5];
			$latSto_[$c] = $res[6];		
			$bllEsp_[$c] = $res[7];
			$bllSes_[$c] = $res[8];
			$bllSto_[$c] = $res[9];
			$bll33_[$c]  = $res[10];			
			$choEsp_[$c] = $res[11];
			$choSes_[$c] = $res[12];
			$botBic_[$c] = $res[13];
			$bllBic_[$c] = $res[14];
				
			$c++;		
		}
		$fecha = implode(",",$fecha_);
		$botEsp = implode(",",$botEsp_);
		$botSes = implode(",",$botSes_);
		$botSto = implode(",",$botSto_);			
		$latEsp = implode(",",$latEsp_);
		$latSes = implode(",",$latSes_);
		$latSto = implode(",",$latSto_);	
		$bllEsp = implode(",",$bllEsp_);
		$bllSes = implode(",",$bllSes_);
		$bllSto = implode(",",$bllSto_);
		$bll33  = implode(",",$bll33_);		
		$choEsp = implode(",",$choEsp_);
		$choSes = implode(",",$choSes_);
		$botBic = implode(",",$botBic_);
		$bllBic = implode(",",$bllBic_);		

		if($distribuidor == 0){
			header("Location: estadistica_despacho.php?fecha=$fecha&nom_dist=&botEsp=$botEsp&botSes=$botSes&botSto=$botSto&latEsp=$latEsp&latSes=$latSes&latSto=$latSto&bllEsp=$bllEsp&bllSes=$bllSes&bllSto=$bllSto&bll33=$bll33&choEsp=$choEsp&choSes=$choSes&botBic=$botBic&bllBic=$bllBic");
		}
		else{
			header("Location: estadistica_despacho.php?fecha=$fecha&nom_dist=$nom_dist[0]&botEsp=$botEsp&botSes=$botSes&botSto=$botSto&latEsp=$latEsp&latSes=$latSes&latSto=$latSto&bllEsp=$bllEsp&bllSes=$bllSes&bllSto=$bllSto&bll33=$bll33&choEsp=$choEsp&choSes=$choSes&botBic=$botBic&bllBic=$bllBic");
		}		
	}	
//*********************************************************	
	if(($tipo_nota == 5) or ($tipo_nota == 6)){
		$fecha = array();
		$botRec = array();
		$cajRec = array();
		$botDes = array();
		$cajRes = array(); 		
		
		while($res = mysqli_fetch_array($sql)){	
			$fecha_[$c] = $res[0];
			$botRec_[$c] = $res[1];
			$cajRec_[$c] = $res[2];
			$botDes_[$c] = $res[3];
			$cajRes_[$c] = $res[4];
			$c++;
		}
		$fecha = implode(",",$fecha_);
		$botRec = implode(",",$botRec_);
		$cajRec = implode(",",$cajRec_);
		$botDes = implode(",",$botDes_);
		$cajRes = implode(",",$cajRes_);

		if($distribuidor == 0){
			header("Location: estadistica_rec_des.php?tn=$tipo_nota&fecha=$fecha&nom_dist=&botRec=$botRec&cajRec=$cajRec&botDes=$botDes&cajRes=$cajRes");
		}
		else{
			header("Location: estadistica_rec_des.php?tn=$tipo_nota&fecha=$fecha&nom_dist=$nom_dist[0]&botRec=$botRec&cajRec=$cajRec&botDes=$botDes&cajRes=$cajRes");
		}
	}	
?>
<?php
ob_end_flush();
?>
