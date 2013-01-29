jQuery(function($){
	try{
		var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		var fecha = new Date();
		$("#mes").val(meses[fecha.getMonth()]);
		$("#agno").val(fecha.getFullYear());
		$('#dp1').datepicker();
		$('#dp2').datepicker();
		$("#leg_mes").text("Abrir Mes "+ meses[fecha.getMonth()] +" "+ fecha.getFullYear());
	} catch(e) {
		alert(e.toString());
	}
})(jQuery);