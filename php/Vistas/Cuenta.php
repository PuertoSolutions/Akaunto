<link rel="stylesheet" type="text/css" href="/assets/css/datepicker.css">
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/cuenta.js"></script>
<?php
	if (isset($_SESSION["Usuario"])) {
		require "Modelos/Cuenta.php";
		$cuenta = new Cuenta();
		$existe = $cuenta -> getCuenta($_SESSION["Usuario"], date("F"), date("Y"));
		if(empty($existe)){
?>
<!-- ABRIR MES -->
<form class="form-horizontal" method="post" action="/Cuenta/Nueva" id="formAbreMes">
	<fieldset>
		<div id="legend" class="">
			<legend class="" id="leg_mes"></legend>
		</div>
		<div class="control-group">
			<label class="control-label" for="input01">Monto Inicial</label>
			<div class="controls">
				<input type="text" placeholder="$$$" class="input-xlarge" name="montoInicial">
				<p class="help-block">Monto Inicial del mes. Sin puntos</p>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<input type="hidden" name="mes" id="mes" />
				<input type="hidden" name="agno" id="agno" />
				<button class="btn btn-primary" type="button" id="btn_abrir" >Abrir Mes</button>
			</div>
		</div>
	</fieldset>
</form>
<?php
		}else{
?>
<div class="row-fluid">
	<div class="span-12">
		<h2><?php echo $existe["Mes"] ." ". $existe["Agno"];?></h2>
		<h3>Monto Inicial $<?php echo $existe["Monto"]; ?></h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<form class="form-horizontal" action="/Cuenta/Ingreso" method="post">
			<fieldset>
				<div id="legend" class="">
					<legend class="">Ingresos</legend>
				</div>
				<div class="control-group">
					<label class="control-label" for="input01">Fecha</label>
					<div class="controls">
						<div class="input-append date" id="dp1" data-date="<?php echo date("d-m-Y"); ?>" 
							data-date-format="dd-mm-yyyy">
							<input  size="16" type="text" value="<?php echo date("d-m-Y"); ?>" 
								name="fecha">
							<span class="add-on"><i class="icon-th"></i></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input01">Monto</label>
					<div class="controls">
						<input type="text" placeholder="Monto en $" class="input-xlarge" name="monto">
						<p class="help-block">Sin separador de miles</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Detalle</label>
					<div class="controls">
						<div class="textarea">
							<textarea type="" class="" name="detalle"></textarea>
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="<?php echo $existe["_id"]; ?>">
						<button class="btn btn-success">Agregar Ingreso</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="span6">
		<form class="form-horizontal" action="/Cuenta/Egreso" method="post">
			<fieldset>
				<div id="legend" class="">
					<legend class="">Egresos</legend>
				</div>
				<div class="control-group">
					<label class="control-label" for="input01">Fecha</label>
					<div class="controls">
						<div class="input-append date" id="dp2" data-date="<?php echo date("d-m-Y"); ?>" 
							data-date-format="dd-mm-yyyy">
							<input  size="16" type="text" value="<?php echo date("d-m-Y"); ?>" 
								name="fecha">
							<span class="add-on"><i class="icon-th"></i></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input01">Monto</label>
					<div class="controls">
						<input type="text" placeholder="Monto en $" class="input-xlarge" name="monto">
						<p class="help-block">Sin separador de miles</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Detalle</label>
					<div class="controls">
						<div class="textarea">
							<textarea type="" class="" name="detalle"></textarea>
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="<?php echo $existe["_id"]; ?>">
						<button class="btn btn-danger">Agregar Egreso</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php
		}
	}else{
?>
<div class="alert alert-error">
  <strong>Alerta !</strong> No tienes permiso para estar aqu&iacute;.
</div>
<?php
	}
?>