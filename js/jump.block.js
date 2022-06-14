Jump.block = function() {
	
	this.refresh = function() {
		
		$(".jump-block-inner").each(function(i,v) {
			
			var innerElementHeight = $(v).height();			
			var blockHeight = $(v).closest(".jump-block").height();
			
			var margin = ((blockHeight - innerElementHeight) / 2);
			
			$(v).css({"margin":margin + "px 0px"});
			
		});
		
		/*$(".jump-block-inner-toolbar").each(function(i,v) {
			
			if ($(v).closest(".jump-block").hasClass("jump-block-horizontal")) {
			
				var innerElementWidth = $(v).height();			
				var blockWidth = $(v).closest(".jump-block").width();			
				
				var margin = ((blockWidth - innerElementWidth) / 2);
				
				$(v).css({"margin":"0px " + margin + "px"});
				
				$(v).find(".button").css({ "width":innerElementWidth+"px"});
				$(v).find(".button").css({"height":innerElementWidth+"px","line-height":innerElementWidth+"px" });
				$(v).find(".button").not(".button-input").parent().css({ "width":innerElementWidth+"px"});
				$(v).find(".button").parent().css({"height":innerElementWidth+"px","line-height":innerElementWidth+"px" });
				$(v).find(".input").css({ "height":innerElementWidth,"line-height":innerElementWidth});
			
			}else{
			
				var innerElementHeight = $(v).height();			
				var blockHeight = $(v).closest(".jump-block").height();			
				
				var margin = ((blockHeight - innerElementHeight) / 2);
				
				$(v).css({"margin":margin + "px 0px"});
				
				$(v).find(".button").css({ "width":innerElementHeight+"px"});
				$(v).find(".button").css({"height":innerElementHeight+"px","line-height":innerElementHeight+"px" });
				$(v).find(".button").not(".button-input").parent().css({ "width":innerElementHeight+"px"});
				$(v).find(".button").parent().css({"height":innerElementHeight+"px","line-height":innerElementHeight+"px" });
				$(v).find(".input").css({ "height":innerElementHeight,"line-height":innerElementHeight});				
				
			}
		
		});*/
		
	}
	
}