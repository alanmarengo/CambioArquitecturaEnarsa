function scrollbars() {

	this.create = function() {
		
		$(".scrollbar-content").each(function(i,v) {
			
			new PerfectScrollbar(v);
			
		});
		
		$(".layer-container-body").each(function(i,v) {
			
			new PerfectScrollbar(v);
			
		});
		
	}
	
	this.updateSize = function() {
		
		$(".scrollbar-content").each(function(i,v) {
			
			var contentHeight = 0;
			
			$(v).children(".scrollbar-content-inner").children().each(function(j,x) {
				
				contentHeight += $(x).outerHeight();
				
			});
			
			$(v).children(".scrollbar-content-inner").height(contentHeight);
			
		});
		
	}
	
	this.redrawElement = function(e) {
		
		$(e).each(function(i,v) {
			
			new PerfectScrollbar(v);
			
		});
		
	}

}