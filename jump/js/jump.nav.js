Jump.nav = function() {
	
	this.hamburguer = {};
	this.hamburguer.div = document.getElementById("jump-hamburguer");
	
	this.hamburguer.fit = function() {
		
		var hamburguer_height = $(this.div).height();
		var hamburguer_parent_navbar_height = $(this.div).closest(".jump-navbar").height();
		
		var hamburguer_mtop = ((hamburguer_parent_navbar_height - hamburguer_height) / 2);
		
		this.div.style.marginTop = hamburguer_mtop + "px";
		
	}
	
	this.hamburguer.addBehavior = function(fun) {		
		
		this.div.addEventListener("click",fun);		
		
	}
	
	this.fitNavLinks = function() {
		
		var height = ((8*Jump.Document.height)/100);
		
		$(".jump-nav-default li").css({
			"height":height+"px",
			"line-height":height+"px"
		});
		
		Jump.Document.linksHeight = height;
		
	}
	
}