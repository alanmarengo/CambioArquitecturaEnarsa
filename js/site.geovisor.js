$(document).ready(function() {
    $('#main-search').focusin(function() {
        $(this).attr('placeholder', '');
    });

    $('#main-search').focusout(function() {
        $(this).attr('placeholder', 'Buscar en todo el sitio');
    });

    $('#main-search').on('keypress', function(e) {
        if (e.which == 13) {
			
			var flink = document.createElement("a");
				flink.setAttribute("target","_blank");
				flink.href = "./mediateca.php?s="+this.value;
				flink.id = "flink-search";
				flink.className = "flink";
			
				document.body.appendChild(flink);
				
				flink.click();
				
				$(flink).remove();
				
        }
    });

	$( document ).ajaxStart(function() {
	  alert("call up");
	});
	
});

$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
        .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}