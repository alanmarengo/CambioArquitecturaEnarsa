<script type="text/javascript">
	
	$(document).ready(function() {	
	
		$(document).ajaxStart(function () {
			HoldOn.open({
				theme: "sk-rect"
			});
		}).ajaxStop(function () {
			HoldOn.close();
		});
		
		$("[title]").tooltipster({
			animation: 'fade',
			delay: 200,
			theme: 'tooltipster-default',
			trigger: 'hover'
		});
		
		indicadores = new ol_indicadores();
		indicadores.panel.start();
		indicadores.startSearch();
		
		flotant = new Jump.flotant();
		flotant.prepareToggle(".navmenu:not(#nav-panel)");
		flotant.fitTopElement("#navbar-tools","#navbar-main");
		flotant.fitTopElement(".page-container",".jump-navbar");
		flotant.fit();		
		
		jwindow = new Jump.window();
		jwindow.initialize();
		
		scroll = new Jump.scroll();
		scroll.refresh();
		
		toggleimage = new Jump.toggleimage();
		toggleimage.refresh();
		
		hovimage = new Jump.hovimage();
		hovimage.refresh();
		
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
		
		<?php
		
		if (isset($_GET["ind_id"])) {
			
		?>
		//https://observatorio.ieasa.com.ar/indicadores.php?ind_id=3&t=Empleo y Proveedores&cid=18
		
		//indicadores.loadIndicador(<?php echo $_GET["ind_id"]; ?>,'<?php echo $_GET["ind_id"]; ?>','<?php echo $_GET["cid"]; ?>');
		
		console.log(indicadores.loadIndicador(<?php echo $_GET["ind_id"]; ?>,'<?php  echo $_GET["t"]; ?>','<?php echo $_GET["cid"]; ?>'));
		
		$('.layer-label').removeClass('layer-label-active'); 
		//$(this).addClass('layer-label-active'); 
		$('#nav-panel-arrow-a').trigger('click');
		
		//document.getElementById("indicador-label-<?php echo $_GET["ind_id"]; ?>").click();
		
		<?php
			
		}
		
		?>
		
	});
			
</script>
