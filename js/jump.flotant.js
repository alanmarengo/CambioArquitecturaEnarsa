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
			
			$(v).height((Jump.Document.height - ruleTotalHeight)+"px");
			
		});
		
		$(".jump-flotant-heightfill-top").each(function(i,v) {
			
			$(v).css("top",ruleTotalHeight+"px");
			
		});
		
		$(".jump-flotant-height-transform").each(function(i,v) {
			
			var height = $(v).height();
			
			$(v).css("height",height+"px");
			
		});
		
	}
	
	this.fitTopElement = function(e,fitAgainstRule) {
		
		var ruleElements = $(fitAgainstRule);
		var ruleTotalHeight = 0;
		
		$(ruleElements).each(function(i,v) {
			
			ruleElementHeight = $(v).height();
			ruleTotalHeight += ruleElementHeight;
			
		});
			
		$(e).css("top",ruleTotalHeight+"px");
		
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
	
	this.prepareToggle = function(target) {
		
		var visible = $(target).attr("data-visible");
		var navWidth = $(target).width();
		
		if (visible == 0) {
			
			$(target).css({"left":"-"+navWidth+"px"});
			
		}
		
	}
	
	this.toggle = function(target,addBackOption,onAnimateEnd,addSectionTitle) {
		
		var visible = $(target).attr("data-visible");
		var navWidth = $(target).width();
		
		$(target).show();
		
		if (visible == 1) {
			
			if (onAnimateEnd) {
			
				$(target).animate({"left":"-"+navWidth+"px"},"fast",onAnimateEnd);
			
			}else{
				
				$(target).animate({"left":"-"+navWidth+"px"},"fast");
				
			}
			
			$(target).attr("data-visible","0");
			
		}else{
			
			if (onAnimateEnd) {
				
				$(target).animate({"left":"0px"},"fast",onAnimateEnd);
			
			}else{
			
				$(target).animate({"left":"0px"},"fast");
			
			}
			
			$(target).attr("data-visible","1");
			
			if (addBackOption) {
				
				var tmphash = (Date.now().toString(36) + Math.random().toString(36).substr(2, 5)).toUpperCase();
				
				$(target).find("ul").first().append(
					$("<li id='jump-back-"+tmphash+"' class='jump-sublevel-backoption'></li>").append(
						$("<a>Volver</a>")
							.attr("href","#")
							.on("click",function() { 
							
								$("#nav-main").animate({"left":"0px"},"fast");
								$("#nav-main").attr("data-visible","1");
								
								this.toggle(target,true);
								
								$(target).find("ul").find(".jump-sublevel-backoption").remove(); 
								$(target).find("ul").find(".jump-sublevel-labeloption").remove(); 
								
							}.bind(this))
					)
				);
				
			}
			
			if (addSectionTitle) {
				
				var tmphash = (Date.now().toString(36) + Math.random().toString(36).substr(2, 5)).toUpperCase();
				var text = $(addSectionTitle).text();
					text = text.split("(");
					text = text[0].trim();
					text = text.split(">");
					text = text[0];
				
				$(target).find("ul").first().children("li").first().prepend(
					$("<li id='jump-back-"+tmphash+"' class='jump-sublevel-labeloption'></li>").append(
						$("<a>"+text+"</a>")
							.attr("href","#")							
							.attr("class","jump-link-death")
					)
				);
				
			}
			
			if ($(target).attr("id") != "nav-main") {
			
				$("#nav-main").animate({"left":"-"+navWidth+"px"},"fast");
				$("#nav-main").attr("data-visible","0");
			
			}
			
		}
		
	}
	
	this.initialize = function() {
		
		this.fit();
		this.fitWidth();
		this.fitPosition();
		
	}
	
}