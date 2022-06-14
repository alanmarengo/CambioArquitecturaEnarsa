function onresize() {
	
	var docWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
				
	if (docWidth < 1230) {
		
		$("#navbar-main .col-nav").appendTo("#navbar-main .responsive-row");
		$("#navbar-main .col-nav").removeClass("col-md-3");
		$("#navbar-main .col-nav").removeClass("col-lg-3");
		$("#navbar-main .col-nav").addClass("col-md-12");
		$("#navbar-main .col-nav").addClass("col-lg-12");
		$("#navbar-main .col-brand").removeClass("col-md-3");
		$("#navbar-main .col-brand").removeClass("col-lg-3");
		$("#navbar-main .col-brand").addClass("col-md-12");
		$("#navbar-main .col-brand").addClass("col-lg-12");
		
	}else{
		
		$("#navbar-main .col-nav").appendTo("#navbar-main .default-row");
		$("#navbar-main .col-nav").removeClass("col-md-12");
		$("#navbar-main .col-nav").removeClass("col-lg-12");
		$("#navbar-main .col-nav").addClass("col-md-3");
		$("#navbar-main .col-nav").addClass("col-lg-3");
		$("#navbar-main .col-brand").removeClass("col-md-12");
		$("#navbar-main .col-brand").removeClass("col-lg-12");
		$("#navbar-main .col-brand").addClass("col-md-3");
		$("#navbar-main .col-brand").addClass("col-lg-3");
		
	}
	
	if (docWidth < 780) {
		
		$("#navbar-tools .col-tools").appendTo("#navbar-tools .responsive-row");
		$("#navbar-tools .col-tools").removeClass("col-md-3");
		$("#navbar-tools .col-tools").removeClass("col-lg-3");
		$("#navbar-tools .col-tools").addClass("col-md-12");
		$("#navbar-tools .col-tools").addClass("col-lg-12");
		$("#navbar-tools .col-title").removeClass("col-md-3");
		$("#navbar-tools .col-title").removeClass("col-lg-3");
		$("#navbar-tools .col-title").addClass("col-md-12");
		$("#navbar-tools .col-title").addClass("col-lg-12");
		
	}else{
		
		$("#navbar-tools .col-tools").appendTo("#navbar-tools .default-row");
		$("#navbar-tools .col-tools").removeClass("col-md-12");
		$("#navbar-tools .col-tools").removeClass("col-lg-12");
		$("#navbar-tools .col-tools").addClass("col-md-3");
		$("#navbar-tools .col-tools").addClass("col-lg-3");
		$("#navbar-tools .col-title").removeClass("col-md-12");
		$("#navbar-tools .col-title").removeClass("col-lg-12");
		$("#navbar-tools .col-title").addClass("col-md-3");
		$("#navbar-tools .col-title").addClass("col-lg-3");
		
	}
	
	flotant.fit();
	flotant.fitPosition();
	flotant.fitTopElement("#navbar-tools","#navbar-main");
	flotant.fitTopElement(".page-container",".jump-navbar");
	
	scroll.refresh();
	
}