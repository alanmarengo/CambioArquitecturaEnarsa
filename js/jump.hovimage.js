Jump.hovimage = function() {
	
	this.refresh = function() {		
		
		$(".jump-hovimage").each(function(i,v) {
			
			$(v).hover(function() {
					
				var end = $(v).attr("data-end-src");
					
				$(v).children("img").attr("src",end);
				
			},function() {
					
				var ini = $(v).attr("data-ini-src");
					
				$(v).children("img").attr("src",ini);
				
			});
			
		});
		
	}
	
}