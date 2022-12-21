<script type="text/javascript">
	
	$(document).ready(function() {
		
		$(document).ajaxStart(function () {
			HoldOn.open({
				theme: "sk-rect"
			});
		}).ajaxStop(function () {
			HoldOn.close();
		});
		
		/* statsIniQueryString = "https://observatorio.ieasa.com.ar/estadisticas-vista.php?<?php /* echo $_SERVER["QUERY_STRING"]; */ ?>"; */
		statsIniQueryString = "https://observatorio.energia-argentina.com.ar/estadisticas-vista.php?<?php echo $_SERVER["QUERY_STRING"]; ?>";
		
		stats = new ol_stats();
		stats.view.start();
		stats.view.resetSelects();
		stats.view.getGMCombo('<?php echo $dt_variables; ?>');
		stats.view.getTableHeader(1);
		stats.view.getTable(1,true);
		stats.view.setLabels("<?php echo $dt_titulo; ?>");
		
		flotant = new Jump.flotant();
		flotant.prepareToggle(".navmenu:not(#nav-panel)");
		flotant.fitTopElement("#navbar-tools","#navbar-main");
		flotant.fitTopElement(".page-container",".jump-navbar");
		flotant.fit();
		
		scroll = new Jump.scroll();
		scroll.refresh();
		
		hovimage = new Jump.hovimage();
		hovimage.refresh();
		
		jwindow = new Jump.window();
		jwindow.initialize();
		jwindow.setAllWindowsDraggable();
		jwindow.initMinimizing();
		
		nav = new Jump.nav();
		nav.hamburguer.addBehavior(function() {
			
			var addBackOptionSize = $(".jump-sublevel-backoption:visible").length;
			
			if (addBackOptionSize > 0) {
				
				$(".jump-sublevel-backoption:visible a").trigger("click");
				
			}else{
			
				$("#hamburguer").toggleClass('open');
				flotant.toggle('#nav-main',false,false,false);
			
			}
			
		});	

		window.addEventListener("resize",onresize);
		onresize();
		
	});
			
</script>
