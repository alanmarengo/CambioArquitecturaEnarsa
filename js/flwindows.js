function ini_flwindows() {

	this.Start = function() {
		
		$(".fl-window").each(function(i,v) {
			
			$(v).children(".fl-window-header").children(".minimize").bind("click",function() {	
			
				var coord = this.parentNode.parentNode.getAttribute("data-minto").split(",");			
				
				var css_coord = { 
					top:coord[0],
					right:coord[1],
					bottom:coord[2],
					left:coord[3],
					display:"block"
				
				}
				
				$(v).children(".fl-window-header").attr("data-nodrag","1");
				
				$(this).parent().parent().removeAttr("style");
				
				$(this).parent().parent().css(css_coord);
				
				$(v).children(".fl-window-header").children(".minimize").hide();
				
				$(v).children(".fl-window-header").children(".maximize").show();
				
				$(v).toggleClass("fl-window-minimized");
				
			});
			
			$(v).children(".fl-window-header").children(".maximize").bind("click",function() {				
				
				var coord = this.parentNode.parentNode.getAttribute("data-maxto").split(",");
				
				var css_coord = { 
					top:coord[0],
					right:coord[1],
					bottom:coord[2],
					left:coord[3],
					display:"block"
				
				}
				
				$(v).children(".fl-window-header").attr("data-nodrag","0");
				
				$(this).parent().parent().removeAttr("style");
				
				$(this).parent().parent().css(css_coord);
				
				$(v).children(".fl-window-header").children(".maximize").hide();
				
				$(v).children(".fl-window-header").children(".minimize").show();
				
				$(v).toggleClass("fl-window-minimized");
				
			});
			
			$(v).children(".fl-window-header").children(".flclose").bind("click",function() {
				
				$(v).hide();
				$(v).attr("data-status","closed")
				
			});
			
		});
	
	}
	
	this.Minimize = function(node) {
		
		var coord = node.getAttribute("data-minto").split(",");			
				
		var css_coord = { 
			top:coord[0],
			right:coord[1],
			bottom:coord[2],
			left:coord[3],
			display:"block"
				
		}
			
		$(node).children(".fl-window-header").attr("data-nodrag","1");
				
		$(node).removeAttr("style");
				
		$(node).css(css_coord);
				
		$(node).children(".fl-window-header").children(".minimize").hide();
				
		$(node).children(".fl-window-header").children(".maximize").show();
		
		$(node).attr("data-status","minimized");
		
	}
	
	this.Maximize = function(node) {		
		
		if ($(node).attr("data-group-class") != '') {
			
			this.ProcessGroupClass($(node).attr("data-group-class"),$(node).attr("data-group-class-action"));
			
		}
		
		var coord = node.getAttribute("data-maxto").split(",");			
				
		var css_coord = { 
			top:coord[0],
			right:coord[1],
			bottom:coord[2],
			left:coord[3],
			display:"block"
				
		}
			
		$(node).children(".fl-window-header").attr("data-nodrag","0");
				
		$(node).removeAttr("style");
				
		$(node).css(css_coord);
				
		$(node).children(".fl-window-header").children(".minimize").show();
				
		$(node).children(".fl-window-header").children(".maximize").hide();
		
		$(node).attr("data-status","maximized");
		
	}
	
	this.Close = function(node) {
		
		$(node).attr("data-status","closed");
		$(node).hide();
		
	}
	
	this.ToggleStatus = function(node,type) {
		
		switch (type.toLowerCase().trim()) {
			
			case 'minimize':
			var fn = this.Minimize;
			break;
			
			case 'close':
			var fn = this.Close;
			break;
			
		}
		
		if (type.toLowerCase() == 'minimize') {
		
			if ($(node).attr("data-status") == "maximized") {
				
				fn(node);
				
			}else{
				
				this.Maximize(node);
				
			}
		
		}else{
			
			if ($(node).attr("data-status") == "maximized") {
				
				fn(node);
				
			}else{
				
				this.Maximize(node);
				
			}
			
		}
		
	}	
	
	this.SetMaximizeCoords = function(node,coords) {
		
		node.setAttribute("data-maxto",coords);
		
	}
	
	this.ProcessGroupClass = function(className,action) {
		
		var e = document.getElementsByClassName(className);
		
		if (e.length > 0) {
		
			switch (action.toLowerCase().trim()) {
				
				case 'minimize':
				var fn = this.Minimize;
				break;
				
				case 'close':
				var fn = this.Close;
				break;
				
			}
			
			for (var i=0; i<e.length; i++) {
				
				fn(e[i]);
				
			}
		
		}
		
	} 

}