<?php
	function conexion()
	{
		if (!($link = mysqli_connect("192.168.1.194","root","mysqlroot"))) 
  		 { 
     		echo "Error conectando al servidor."; 
	      	exit(); 
	   	 }	 
	   if (!mysqli_select_db($link,"envasador_pluss")) 	   
   		{	 
      		echo "Error seleccionando la base de datos.."; 
		    exit(); 
	    } 
	   return $link; 
	} 
?> 