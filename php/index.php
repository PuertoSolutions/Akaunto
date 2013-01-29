<?php

	$_ENV['modo'] = "d"; // {d="desarrollo", p="produccion"}
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

	$app -> get('/phpinfo()', function() use ($app){
		phpinfo();
	});

	$app -> get('/Registro', function() use ($app){
		$app -> render("RegistroUsuario.php");
	});

	$app -> get('/LogOut', function() use ($app){
		session_destroy();
		$app->render("avisos.php", array("Mensaje" => "", "Detalle" => "", "Tiempo" => 10));
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
		require 'modelos/Usuario.php';
		$usuario = new Usuario(
			null, 
			$app->request()->params("mail"), 
			$app->request()->params("pass")
		);
		$app->render("avisos.php", $usuario->getLogin());
	});

	$app -> post('/Cuenta/Nueva', function() use ($app){
		require 'modelos/Cuenta.php';
		$cuenta = new Cuenta();
		$app->render("avisos.php", $cuenta -> putCuenta(
			$_SESSION["Usuario"],
			$app->request()->params("mes"), 
			$app->request()->params("agno"), 
			$app->request()->params("montoInicial"))
		);
	});

	$app -> post('/Cuenta/Ingreso', function() use ($app){
		require 'modelos/Cuenta.php';
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
		require 'modelos/Cuenta.php';
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