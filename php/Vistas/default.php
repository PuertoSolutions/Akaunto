<!DOCTYPE html>
<html lang="es">
    <head>
		<meta charset="utf-8">
		<title>Watashi no Akaunto</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Sistema Pedidos Taxi Online">
		<meta name="author" content="Puerto Solutions">
		<link rel="stylesheet" type="text/css" href="/assets/css/cyborg_bootstrap.min.css">
		<link href="/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
		<style type="text/css">
			body {
				padding-top: 80px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			 <div class="navbar-inner">
			 	<div class="container"><!-- Collapsable nav bar -->
			 		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			 			<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		 			</a>
		 			<a class="brand" href="/">Watashi no Akaunto</a>
		 			<div class="nav-collapse">
		 				<ul class="nav">
		 					<?php 
		 						if(isset($_SESSION["Usuario"])){ ?>
		 							<li><a href="#">algo</a></li>
		 						<?php }
		 					?>
	 					</ul>
		 				<ul class="nav pull-right">
		 					<?php if(isset($_SESSION["Usuario"])){ ?>
		 						<li id="fat-menu" class="dropdown">
		 							<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["Usuario"]; ?> <b class="caret"></b></a>
		 							<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
		 								<li><a tabindex="-1" href="/Usuario/Preferencias">Preferencias</a></li>
		 								<li class="divider"></li>
		 								<li><a tabindex="-1" href="/LogOut">Cerrar Sesión</a></li>
	 								</ul>
 								</li>
		 					<?php }else{ ?>
		 						<li><a href="/Registro">Registrarse</a></li>
			 					<li class="divider-vertical"></li>
			 					<li class="dropdown">
			 						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Iniciar Sesión <strong class="caret"></strong></a>
			 						<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
			 							<form action="/Login" method="post" accept-charset="UTF-8" class="well">
			 								<input id="user_username" style="margin-bottom: 15px;" type="text" name="mail" size="30"  required placeholder="E-Mail" />
			 								<input id="user_password" style="margin-bottom: 15px;" type="password" name="pass" size="30" required placeholder="Contraseña" />
			 								<input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Ingresar" />
		 								</form>
			 						</div>
		 						</li>
		 					<?php } ?>
 						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<?php echo $_html; ?>
			<hr>
			<footer>
				<p>&copy; Puerto Solutions 2012</p>
			</footer>
		</div>
	</body>
</html>