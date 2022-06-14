function setNav() {
	
	var docheight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	
		var width_nav = $("#navbarNav").width();
		$("#navbarNav").css("left","-"+width_nav+"px");
		$("#navbarNav").css("display","block");
		$("#navbarNav").height(docheight);
		
		$("#navbarNav .nav-link").bind("click",function() {			
						
			scrollbars.redrawElement(".scrollbar-content");
			
		});
	
}

function nav() {
		
	var width_nav = $("#navbarNav").width();
	
	if (document.getElementById("navbarNav").getAttribute("data-state") == "0") {
		
		$("#navbarNav").animate({left:"0px"},700);
		$("#page").animate({left:width_nav+"px"},700);
		
		document.getElementById("navbarNav").setAttribute("data-state","1");
		
		if (document.getElementById("panel-left")) {
			
			if ($("#panel-arrow-link").attr("data-state") == 0) {
				
				$("#panel-left").animate({ left:(width_nav - 370) + "px" });
				
			}else{
				
				$("#panel-left").animate({ left:width_nav + "px" });
				
			}
			
		}
		
	}else{
		
		$("#navbarNav").animate({left:"-"+width_nav+"px"},700);
		$("#page").animate({left:"0px"},700);
		
		document.getElementById("navbarNav").setAttribute("data-state","0");
		
		if (document.getElementById("panel-left")) {
			
			if ($("#panel-arrow-link").attr("data-state") == 0) {
				
				$("#panel-left").animate({ left:"-370px" });
				
			}else{
				
				$("#panel-left").animate({ left:"0px" });
				
			}
			
		}
		
	}
	
}