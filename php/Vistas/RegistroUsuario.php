<h1>Registro Usuarios</h1>
<div class="row">
	<div class="span12">
		<br />
		<form class="form-horizontal" method="post" action="/Registro">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="usuario">Nombre Usuario</label>
					<div class="controls">
						<input type="text" name="usuario" class="input-xlarge" required="required">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mail">E-Mail</label>
					<div class="controls">
						<input type="text" name="mail" class="input-xlarge" required="required">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="pass">Contrase&ntilde;a</label>
					<div class="controls">
						<input type="password" name="pass" class="input-xlarge" required="required">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-success">Registrar</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>