<?php

	$_ENV['modo'] = "p"; // {d="desarrollo", p="produccion"}
	 error_reporting(E_ALL);
 	ini_set("display_errors", 1);
 	setlocale(LC_ALL,"es_ES");
	
	require 'lib/Slim/Slim.php';
	require 'Vistas/Vista.php';
	
	session_cache_limiter(FALSE);
	session_start();
	
	\Slim\Slim::registerAutoloader();
	
	$vista = new Vista();
	
	$app = new \Slim\Slim(
		array("view" => $vista)
	);
	
	Vista::set_layout("default.php");
	
	//------------------------------------------------------------------------GETS
	$app -> get('/', function() use ($app){
		$app -> render("index.php");
	});

	$app -> get('/phpinfo', function() use ($app){
		phpinfo();
	});

	$app -> get('/Registro', function() use ($app){
		$app -> render("RegistroUsuario.php");
	});

	$app -> get('/LogOut', function() use ($app){
		session_destroy();
		$app->render("avisos.php", array("Mensaje" => "", "Detalle" => "", "Tiempo" => 10));
	});

	$app -> get('/Historial/', function() use ($app){
		require("Modelos/Cuenta.php");
		$agnos = new Cuenta();
		$app->render("Historial.php", array("Agnos" => $agnos -> getAgnos($_SESSION["Usuario"])));
	});

	$app -> get('/Historial/:agno/', function($agno) use ($app){
		require("Modelos/Cuenta.php");
		$agnos = new Cuenta();
		$app->render("Historial.php", array(
			"Agnos" => $agnos -> getAgnos($_SESSION["Usuario"]),
			"Meses" => $agnos -> getMeses($_SESSION["Usuario"], $agno))
		);
	});

	$app -> get('/Historial/:agno/:mes', function($agno, $mes) use ($app){
		require "Modelos/Cuenta.php";
		$agnos = new Cuenta();
		$app->render("Historial.php", array(
			"Agnos" => $agnos -> getAgnos($_SESSION["Usuario"]),
			"Meses" => $agnos -> getMeses($_SESSION["Usuario"], $agno),
			"Cuenta" => $agnos -> getCuenta($_SESSION["Usuario"], $mes, $agno, true))
		);
	});

	//------------------------------------------------------------------------POSTs
	$app -> post('/Registro', function() use ($app){
		require 'Modelos/Usuario.php';
		$usuario = new Usuario(
			$app->request()->params("usuario"), 
			$app->request()->params("mail"), 
			$app->request()->params("pass")
		);
		$app->render("avisos.php", $usuario->putGuardar());
	});

	$app -> post('/Login', function() use ($app){
		require 'Modelos/Usuario.php';
		$usuario = new Usuario(
			null, 
			$app->request()->params("mail"), 
			$app->request()->params("pass")
		);
		$app->render("avisos.php", $usuario->getLogin());
	});

	$app -> post('/Cuenta/Nueva', function() use ($app){
		require 'Modelos/Cuenta.php';
		$cuenta = new Cuenta();
		$app->render("avisos.php", $cuenta -> putCuenta(
			$_SESSION["Usuario"],
			$app->request()->params("mes"), 
			$app->request()->params("agno"), 
			$app->request()->params("montoInicial"))
		);
	});

	$app -> post('/Cuenta/Ingreso', function() use ($app){
		require 'Modelos/Cuenta.php';
		$cuenta = new Cuenta();
		$app->render("avisos.php", $cuenta -> putIngreso(
			new MongoID($app -> request() ->params("id")),
			$_SESSION["Usuario"],
			$app->request()->params("fecha"), 
			$app->request()->params("monto"), 
			$app->request()->params("detalle"))
		);
	});

	$app -> post('/Cuenta/Egreso', function() use ($app){
		require 'Modelos/Cuenta.php';
		$cuenta = new Cuenta();
		$app->render("avisos.php", $cuenta -> putEgreso(
			new MongoID($app -> request() ->params("id")),
			$_SESSION["Usuario"],
			$app->request()->params("fecha"), 
			$app->request()->params("monto"), 
			$app->request()->params("detalle"))
		);
	});
	
	$app -> run();
?>