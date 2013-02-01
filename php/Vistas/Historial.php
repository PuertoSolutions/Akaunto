<?php
	if (isset($_SESSION["Usuario"])) {
?>
<link rel="stylesheet" href="/assets/css/datepicker.css">
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/historial.js"></script>
<div class="row">
	<div class="span6">
		<h2>A&ntilde;os</h2>
<?php
	foreach ($Agnos as $agno) {
		echo "<a href=\"".$agno["Agno"]."\">".$agno["Agno"]."</a>";
	}
?>
	</div>
<?php
	if(isset($Meses)){
?>
	<div class="span6">
			<h2>Meses</h2>
	<?php	
		foreach ($Meses as $mes) {
			echo "<a href=\"".$mes["Mes"]."\">".$mes["Mes"]."</a>";
		}
	?>		
		</div>
<?php
	}
?>
</div>
<?php
		if (isset($Cuenta)) {
			$id = $Cuenta["_id"];
			$tmp = new Cuenta();
			$sumaEgresos = $tmp -> getSumaEgresos(new MongoID($id))["result"];
			$sumaEgresos = (empty($sumaEgresos) ? 0 : $sumaEgresos[0]["suma"]);
			$sumaIngresos = $tmp -> getSumaIngresos(new MongoID($id))["result"];
			$sumaIngresos = (empty($sumaIngresos) ? 0 : $sumaIngresos[0]["suma"]);
			$actual = ($Cuenta["Monto"] + $sumaIngresos) - $sumaEgresos;
?>
<p></p>
<div class="row well">
	<div class="span12">
		<h3>Monto Inicial $ <?php echo $Cuenta["Monto"]; ?></h3>
		<h3>Monto Actual $ <?php echo $actual. " (".($actual*100)/$Cuenta["Monto"]."%)"; ?></h3>
	</div>
	<div class="span5">
		<h2>Ingresos</h2>
<?php
	if (empty($Cuenta["Ingresos"])) {
		echo "Sin Ingresos";
	}else{
?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Monto</th>
				<th>Detalle</th>
			</tr>
		</thead>
		<tbody>
<?php
		foreach ($Cuenta["Ingresos"] as $ingreso) {
			echo "<tr>";
			echo "<td>".$ingreso["Fecha"]."</td>";
			echo "<td>".$ingreso["Monto"]."</td>";
			echo "<td>".$ingreso["Detalle"]."</td>";
			echo "</tr>";
		}
	}
?>
		</tbody>
	</table>
	<h4>Total Ingresos: <?php echo $sumaIngresos; ?></h4>
	</div>
	<div class="span5">
		<h2>Egresos</h2>
<?php
	if (empty($Cuenta["Egresos"])) {
		echo "Sin Ingresos";
	}else{
?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Monto</th>
					<th>Detalle</th>
				</tr>
			</thead>
			<tbody>
<?php
		foreach ($Cuenta["Egresos"] as $egreso) {
			echo "<tr>";
			echo "<td>".$egreso["Fecha"]."</td>";
			echo "<td>".$egreso["Monto"]."</td>";
			echo "<td>".$egreso["Detalle"]."</td>";
			echo "</tr>";
		}
	}
?>
			</tbody>
		</table>
		<h4>Total Egresos: <?php echo $sumaEgresos; ?></h4>
	</div>
</div>
<?php
		}
	}else{
?>
<div class="alert alert-error">
	<strong>Atenci&oacute;</strong>
	Debes iniciar sesión para ver el contenido :(
</div>
<?php
	}
?>