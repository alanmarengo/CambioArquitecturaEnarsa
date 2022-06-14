Jump.window = function() {
	
	this.initialize = function() {
		
		
		
	}
	
	this.setAllWindowsDraggable = function() {
		
		$(".jump-window").each(function(i,v) {
			
			var header = $(v).find(".jump-window-header");
			
			$(v).draggable({handle:header});
			
			$(v).find(".jump-window-close").on("click",function() {
				
				$(this).closest(".jump-window").hide();
				
			});
			
		});
		
	}
	
}