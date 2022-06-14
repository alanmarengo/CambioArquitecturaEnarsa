<script type="text/javascript">
	
	$(document).ready(function() {
		
		$("[title]").tooltipster({
			animation: 'fade',
			delay: 200,
			theme: 'tooltipster-default',
			trigger: 'hover'
		});
		
		stats = new ol_stats();
		stats.panel.start();
		stats.panel.startSearch();
		
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
		
		<?php if (isset($_GET["cid"])) { ?>
		
		$(".abr[data-cid=<?php echo $_GET["cid"]; ?>]").trigger("click");
		
		<?php } ?>
		
		<?php if (isset($_GET["dt_id"])) { ?>
		
		$(".layer-label[data-dt=<?php echo $_GET["dt_id"]; ?>]").trigger("click");
		
		var cid = $(".layer-label[data-dt=<?php echo $_GET["dt_id"]; ?>]").closest(".layer-container").attr("data-cid");
		
		$(".abr[data-cid=" + cid + "]").trigger("click");
		
		<?php } ?>
		
	});
			
</script>