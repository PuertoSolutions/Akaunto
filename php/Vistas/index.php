<?php
	if(isset($_SESSION["Usuario"])){
		require "Cuenta.php";
	}else{
		require "Bienvenida.php";
	}
?>