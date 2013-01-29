<h1><?php echo $Mensaje; ?></h1>
<p><?php echo $Detalle; ?></p>
<script type="text/javascript">
	setTimeout(
		function(){
			window.location.href = "/";
		},
		<?php echo $Tiempo ?>);
</script>