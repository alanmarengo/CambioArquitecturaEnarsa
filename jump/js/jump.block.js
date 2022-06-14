Jump.block = function() {
	
	this.refresh = function() {
		
		$(".jump-block-inner").each(function(i,v) {
			
			var innerElementHeight = $(v).height();			
			var blockHeight = $(v).closest(".jump-navbar").height();
			
			var margin = ((blockHeight - innerElementHeight) / 2);
			
			$(v).css({"margin":margin + "px 0px"});
			
		});
		
		$(".jump-block-inner-toolbar").each(function(i,v) {
			
			var innerElementHeight = $(v).height();			
			var blockHeight = $(v).closest(".jump-navbar").height();			
			
			var margin = ((blockHeight - innerElementHeight) / 2);
			
			$(v).css({"margin":margin + "px 0px"});
			
			$(v).find(".button").css({ "width":innerElementHeight+"px"});
			$(v).find(".button").css({"height":innerElementHeight+"px","line-height":innerElementHeight+"px" });
			$(v).find(".button").not(".button-input").parent().css({ "width":innerElementHeight+"px"});
			$(v).find(".button").parent().css({"height":innerElementHeight+"px","line-height":innerElementHeight+"px" });
			$(v).find(".input").css({ "height":innerElementHeight,"line-height":innerElementHeight});
		
		});
		
	}
	
}