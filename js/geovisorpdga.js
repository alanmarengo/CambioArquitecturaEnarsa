$(document).ready(function() {
	
	$("[title]").tooltipster({
		animation: 'fade',
		delay: 200,
		theme: 'tooltipster-default',
		trigger: 'hover'
	});
	
	scroll = new Jump.scroll();
			
	geomap = new ol_map();	
	geomap.map.create();
	
	scroll.refresh();
	
});