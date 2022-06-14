Jump.input = function() {
	
	this.initialize = function() {
		
		$('.jump-input[type=text]').focusin(function() {
			$(this).attr('placeholder', '');
		});

		$('.jump-input[type=text]').focusout(function() {
			
			var placeholder = $(this).attr("data-jump-placeholder");
			
			$(this).attr('placeholder', placeholder);
		});
		
	}
	
}