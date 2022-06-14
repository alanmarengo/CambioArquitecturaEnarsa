Jump.flotant = function() {
	
	this.fitAgainstRule = ".jump-navbar";
	
	this.getFitAgainstRule = function() {
		
		return this.fitAgainstRule;
		
	}
	
	this.setFitAgainstRule = function(rule) {
		
		this.fitAgainstRule = rule;
		
	}
	
	this.fit = function() {
		
		var ruleElements = $(this.getFitAgainstRule());
		var ruleTotalHeight = 0;
		
		$(ruleElements).each(function(i,v) {
			
			ruleElementHeight = $(v).height();
			ruleTotalHeight += ruleElementHeight;
			
		});
		
		$(".jump-flotant-heightfill").each(function(i,v) {
			
			$(v).css("top",ruleTotalHeight+"px");
			$(v).height((Jump.Document.height - ruleTotalHeight)+"px");
			
		});
		
		$(".jump-flotant-heightfill-top").each(function(i,v) {
			
			$(v).css("top",ruleTotalHeight+"px");
			
		});
		
	}
	
	this.fitWidth = function() {
		
		$(".jump-flotant-nav").each(function(i,v) {
			
			var navWidth = $(v).width();
			
			$(v).attr("data-width",navWidth);
			
		});
		
	}
	
	this.fitPosition = function() {
		
		$(".jump-flotant-nav").each(function(i,v) {
			
			var visible = $(v).attr("data-visible");
			var navWidth = $(v).width();
			
			if (visible == 1) {
			
				$(v).css({"left":"0px"});
			}else{
				
				$(v).css({"left":"-"+navWidth+"px"});
				
			}
			
		});
		
	}
	
	this.toggle = function(target,addBackOption) {
		
		var visible = $(target).attr("data-visible");
		var navWidth = $(target).attr("data-width");
		
		if (visible == 1) {
			
			$(target).animate({"left":"-"+navWidth+"px"},"fast");
			$(target).attr("data-visible","0");
			
		}else{
			
			$(target).animate({"left":"0px"},"fast");
			$(target).attr("data-visible","1");
			
			if (addBackOption) {
				
				var tmphash = (Date.now().toString(36) + Math.random().toString(36).substr(2, 5)).toUpperCase();
				
				$(target).find("ul").first().append(
					$("<li id='jump-back-"+tmphash+"' class='jump-sublevel-backoption'></li>").append(
						$("<a>Volver</a>")
							.attr("href","#")
							.on("click",function() { this.toggle(target,true); $("#jump-back-"+tmphash).remove(); }.bind(this))
					)
				);
				
				var height = $("#jump-back-"+tmphash).prev().height();
				
				$("#jump-back-"+tmphash).css({
					"height":height+"px",
					"line-height":height+"px"
				});
				
			}
			
		}
		
	}
	
	this.initialize = function() {
		
		this.fit();
		this.fitWidth();
		this.fitPosition();
		
	}
	
}