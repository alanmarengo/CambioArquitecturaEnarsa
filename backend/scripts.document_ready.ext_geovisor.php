<script type="text/javascript">

	$(document).ready(function() {
		
		ol_map = new map();
		ol_map.create();
			
		<?php if (isset($_GET["dt_id"])) { ?>
		
		ol_map.createFromDataset(<?php echo $_GET["dt_id"]; ?>);
		
		<?php } ?>
		
		var baseLayerContent = "<div class=\"tooltip-white-list\">";
			baseLayerContent += "<ul>";
			baseLayerContent += "<li><a href=\"#\" onclick=\"ol_map.setBaseLayer(ol_map.baselayers.google);\" class=\"alphalink\">GOOGLE</a></li>";
			baseLayerContent += "<li><a href=\"#\" onclick=\"ol_map.setBaseLayer(ol_map.baselayers.openstreets);\" class=\"alphalink\">OPEN STREETS</a></li>";
			baseLayerContent += "<li><a href=\"#\" onclick=\"ol_map.setBaseLayer(ol_map.baselayers.argenmap);\" class=\"alphalink\">ARGEN MAP</a></li>";
			baseLayerContent += "</ul>";
			baseLayerContent += "</div>";
		
		$("#icon-zoom-layers").tooltipster({
			
			position:"left",
			trigger:"click",
			animation:"grow",
			contentAsHTML:true,
			interactive:true,
			content:baseLayerContent,
			theme:"tooltipster-shadow",
			side:["left","top"],
			zIndex:999
			
		});
		
		$("#tools-zoom [title]").tooltipster({
			
			position:"left",
			animation:"grow",
			theme:"tooltipster-shadow",
			zIndex:999
			
		});
		
	});

</script>