$(document).ready(function () {

	var width = $("#navigation").width();
	
	$("#navigation").css("right","-" + width + "px");
	
	$("#navigation").on("click",function() {

		var width = $(this).width();
		
		if ($(this).hasClass("open")) {
			
			$("#navigation").animate({right:"-" + width + "px"},"fast",function() { $(this).toggleClass("open"); });
			
		}else{
			
			$("#navigation").animate({right:"0px"},"fast",function() { $(this).toggleClass("open"); });
			
		}
		
	});

});