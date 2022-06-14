$(document).ready(function() {
				
	$(".datepicker").val("");
	
	$(".datepicker").datepicker({
		defaultDate:null,
		dateFormat: "yy-mm-dd",
		firstDay:0,
		changeMonth:true,
		changeYear:true,
		monthNames:[ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		monthNamesShort:[ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
		dayNamesShort:[ "Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
		dayNamesMin:[ "Do","Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		dayNames:[ "Domingo","Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "SÃ¡bado" ],
		onSelect:function(d) {
			console.log(d);
		}
		
	});

});