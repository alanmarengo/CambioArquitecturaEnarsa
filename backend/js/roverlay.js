$.fn.Roverlay = function(param) {
	
	if (param == undefined) {
	
		if ($(this[0]).attr("data-col") == undefined) {
		
			$(this[0]).attr("data-col","4")
		
		}
		
		var inner = $("<div></div>").addClass("roverlay-inner");	
			
		if ($(this[0]).attr("data-header") != undefined) {
			
			var header_row = $("<div></div>").addClass("row");
			
			var header_close = $("<div></div>").append("<a class='close'><i class='fa fa-times'></i></a>").on("click",function() {
				
				$(this).closest(".roverlay").css("display","none");
				
			});
			
			var header = $("<div></div>").attr("class","roverlay-header col col-xs-12 col-sm-12 col-md-" + $(this[0]).attr("data-col") + " col-lg-" + $(this[0]).attr("data-col")).html("<span>" + $(this[0]).attr("data-header") + "</span>");
						
			$(header_row).append(header);			
			$(header).append(header_close);			
			$(inner).append(header_row);
			
		}	
			
		var body_row = $("<div></div>").addClass("row");
		var body = $("<div></div>").attr("class","roverlay-body col col-xs-12 col-sm-12 col-md-" + $(this[0]).attr("data-col") + " col-lg-" + $(this[0]).attr("data-col"));
		
		$(this[0]).children().not(".roverlay-inner").each(function(i,v) {
			
			$(body).append($(v));
			
		});
		
		$(body_row).append(body);
		
		$(inner).append(body_row);
			
		$(this[0]).append(inner);
	
	}else{
		
		switch(param) {
			
			case 'refresh':
			
			var h = $(this[0]).find(".roverlay-inner").first().height();
	
			if ($(this[0]).find(".roverlay-header").length>0) {
			
				var hh = $(this[0]).find(".roverlay-header").first().height();
				
				var nh = h - hh - 20;
			
			}
			
			$(this[0]).find(".roverlay-body").height(nh);
			
			break;
			
			case 'open':
			
			$(this[0]).css("display","flex");
			
			break;
			
			case 'close':
			
			$(this[0]).css("display","none");
			
			break;
			
		}
		
	}

}

$.fn.iFlex = function() {
	
	$(this).css("display","inline-flex");
	
}

$.fn.Flex = function() {
	
	$(this).css("display","flex");
	
}

$.fn.Hide = function() {
	
	$(this).css("display","none");
	
}