$(document).ready(function() {
	
	$("[title]").tooltipster({
		animation: 'fade',
		delay: 200,
		theme: 'tooltipster-default',
		trigger: 'hover'
	});
			
	geomap = new ol_map();	
	geomap.map.create();
	
	scroll = new Jump.scroll();
	scroll.refresh();
	
});