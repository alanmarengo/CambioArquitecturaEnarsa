Jump.nav = function() {
	
	this.hamburguer = {};
	this.hamburguer.div = document.getElementById("hamburguer");
	
	this.hamburguer.addBehavior = function(fun) {		
		
		this.div.addEventListener("click",fun);
		
	}
	
}