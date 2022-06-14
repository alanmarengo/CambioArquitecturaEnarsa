$(document).ready(function() {

    updateDatepicker();

    currentTab = 1;

});

function updateDatepicker() {

    var date = new Date();

    var year = date.getFullYear();

    $(".datepicker").val("");

    $(".datepicker").datepicker({
        defaultDate: null,
        format: 'dd/mm/yyyy',
        firstDay: 0,
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        yearRange: (year - 100) + ':' + (year),
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"],
        onSelect: function() {}

    }).datepicker("setDate", new Date());

}