<?php
ob_start();
?> 

<?	
    session_start();	
	include("conexion.php");
	$link = conexion();	
	
	$contrasena = $_POST['contrasena'];
	$login = $_POST['login'];
	
	//echo $login.' '.$contrasena;

    $sql_login = "SELECT u.codigoUsuario, u.login, u.acceso FROM usuarios u LEFT JOIN rolesUsuario r USING(codigoUsuario) WHERE u.login = '$login' AND u.contrasena = md5('$contrasena');";
    $reg_login = mysqli_query($link,$sql_login);
    if (mysqli_num_rows($reg_login)<>0){
        $fil_login = mysqli_fetch_array($reg_login);
        $_SESSION["codigo_usuario"] = $fil_login[0];    
        $_SESSION["login"]          = $fil_login[1];       
		$_SESSION["acceso"]         = $fil_login["acceso"];
    }    
    
    $sql_rol  = "SELECT r.idRol FROM usuarios u JOIN rolesUsuario r USING(codigoUsuario) WHERE u.login = '$login' AND u.contrasena = md5('$contrasena');";
	
	$contador = 0;
	
    $reg_rol  = mysqli_query($link,$sql_rol);
    $contador = mysqli_num_rows($reg_rol);
    
    while($matriz = mysqli_fetch_array($reg_rol)){
        $_SESSION["rol"][] = $matriz[0];
    }

//	echo "llega - ". $contador." - ".$login." ".$contrasena;
  
    print_r($matriz);
    if($contador<>0){        
        //$_SESSION["rol"][]       = $matriz;
        $_SESSION["autenticado"] = 1; 
        header("Location: procesos.php");
       
    }
    else{
        header("Location: index.php?error=1"); 
    }




/*

	$reg_login = mysqli_query($link,"Select CodigoUsuario,Login,Acceso From usuarios Where Login = '$login' And Contrasena = MD5('$contrasena') AND Estado = 1");	
	$fil_login = mysqli_fetch_array($reg_login);
	$contador = mysqli_num_rows($reg_login);
	if($contador <> 0)
	{	
		$_SESSION["autenticado"]=1; 
		$_SESSION["codigo_usuario"]=$fil_login["CodigoUsuario"];
		$_SESSION["login"]=$fil_login["Login"];
		$_SESSION["acceso"]=$fil_login["Acceso"];
		if($fil_login[2] == 6){
			header("Location: reportes_comercial/index.php");
		}
		else{
			header("Location: procesos.php");
		}
		
	}
	else 
	{
		header("Location: index.php?error=1");
	}	
	*/
?>
<?php
ob_end_flush();
?> 