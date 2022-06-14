// JavaScript Document

Jump.resizer = function(element) {
	
	this.element = element;
	this.element.do_resize = true;
	
	this.resizing = false;
	
	this.current_anchor = 0;
	
	//this.add_corners = function() {
	
		/* RESIZERS LATERALES */
		
		var top_res = document.createElement("div");
		var bottom_res = document.createElement("div");
		var left_res = document.createElement("div");
		var right_res = document.createElement("div");
		
		/* RESIZERS ANGULARES :: SE AÑADEN DESPUES DE LOS LATERALES PARA QUE QUEDEN POR ENCIMA */
		
		var left_top = document.createElement("div");
		var left_bottom = document.createElement("div");
		var right_top = document.createElement("div");
		var right_bottom = document.createElement("div");
		
		/* APLICACION DE CLASES */ 
		
		top_res.className = "resizer_bar_h";
		bottom_res.className = "resizer_bar_h";
		left_res.className = "resizer_bar_v";
		right_res.className = "resizer_bar_v";
		
		left_top.className = "resizer_corner";
		left_bottom.className = "resizer_corner";
		right_top.className = "resizer_corner";
		right_bottom.className = "resizer_corner";
		
		/* ESTILO DE LOS CURSORES */
		
		left_top.style.cursor = "nw-resize";
		left_bottom.style.cursor = "sw-resize";
		right_top.style.cursor = "ne-resize";
		right_bottom.style.cursor = "se-resize";
		
		/* LOS AÑADO A LA VENTANA : IMPORTANTE: SOLO SIRVE PARA POPUPS O ELEMENTOS ABSOLUTOS AL DOCUMENTO */

		this.element.appendChild(top_res);
		this.element.appendChild(bottom_res);
		this.element.appendChild(left_res);
		this.element.appendChild(right_res);
		
		this.element.appendChild(left_top);
		this.element.appendChild(left_bottom);
		this.element.appendChild(right_top);
		this.element.appendChild(right_bottom);
		
		/* POSICIONO CADA ITEM */
		
		top_res.style.left = 20 + "px";
		top_res.style.top = 20 + "px";
		
		bottom_res.style.left = "20px";
		bottom_res.style.bottom = "20px";	
		
		left_res.style.left = "20px";
		left_res.style.top = "20px";
		
		right_res.style.right = "20px";
		right_res.style.bottom = "20px";	
	
		left_top.style.left = 20 + "px";
		left_top.style.top = 20 + "px";
		
		left_bottom.style.left = "20px";
		left_bottom.style.bottom = "20px";	
		
		right_top.style.right = "20px";
		right_top.style.top = "20px";
		
		right_bottom.style.right = "20px";
		right_bottom.style.bottom = "20px";	
		
		/* VARIABLES USADAS PARA DIMENSIONAR */		
		
		this.window_left = this.element.offsetLeft;
		this.window_top = this.element.offsetTop;
		this.capture_width = this.element.offsetWidth;
		this.capture_height = this.element.offsetHeight;
		
		this.capture_left = this.element.offsetLeft;
		this.capture_top = this.element.offsetTop;
		this.capture_width = this.element.offsetWidth;
		this.capture_height = this.element.offsetHeight;
		
		/* EVENTOS */
		
		left_top.onmousedown = function() {	this.init_resizing(1); }.bind(this);
		
		left_bottom.onmousedown = function() { this.init_resizing(2); }.bind(this);
		
		right_top.onmousedown = function() { this.init_resizing(3); }.bind(this);
		
		right_bottom.onmousedown = function() {	this.init_resizing(4); }.bind(this);
		
		top_res.onmousedown = function() {	this.init_resizing(5); }.bind(this);
		
		bottom_res.onmousedown = function() { this.init_resizing(6); }.bind(this);
		
		left_res.onmousedown = function() {	this.init_resizing(7); }.bind(this);
		
		right_res.onmousedown = function() { this.init_resizing(8); }.bind(this);
		
		window.addEventListener('mouseup',function() {
			
			this.current_anchor = 0;
			
			this.capture_left = this.element.offsetLeft;
			this.capture_top = this.element.offsetTop;
			this.capture_width = this.element.offsetWidth;
			this.capture_height = this.element.offsetHeight;
			
			window.removeEventListener('mousemove',this.mouse_move);
			
		}.bind(this));		
		
	//}.bind(this);
	
	
	this.init_resizing = function(anchor_index) {
		
		this.current_anchor = anchor_index;
		
		window.addEventListener('mousemove',this.mouse_move);
		
	}
	
	
	this.mouse_move = function(event) {
		
		if (this.element.do_resize) {
		
			var mouse_x = event.clientX;
			var mouse_y = event.clientY;
			
			switch(this.current_anchor) {
						
				case 1:
						
				var mouse_x = mouse_x;
						
				var new_width = this.capture_left - mouse_x + this.capture_width;
						
				this.element.style.width = new_width + "px";
				
				this.element.style.left = mouse_x + "px"
						
				var new_top = mouse_y - this.capture_top;
						
				var new_height = this.capture_height - new_top;
						
				this.element.style.top = mouse_y + "px";
						
				this.element.style.height = new_height + "px";
						
				break;
						
				case 2:
						
				var new_left = mouse_x - this.capture_left;
					
				var new_width = this.capture_width - new_left;
						
				this.element.style.left = mouse_x + "px";
						
				this.element.style.width = new_width + "px";
						
				var mouse_y = mouse_y;
						
				var new_height = mouse_y - (this.capture_top + this.capture_height) + this.capture_height;
						
				this.element.style.height = new_height + "px";
						
				break;
						
				case 3:
						
				var new_top = mouse_y - this.capture_top;
						
				var new_height = this.capture_height - new_top;
						
				this.element.style.top = mouse_y + "px";
						
				this.element.style.height = new_height + "px";
						
				var mouse_x = mouse_x;
						
				var new_width = mouse_x - (this.capture_left + this.capture_width) + this.capture_width;
						
				this.element.style.width = new_width + "px";
						
				break;
						
				case 4:
						
				var mouse_x = mouse_x;
						
				var new_width = mouse_x - (this.capture_left + this.capture_width) + this.capture_width;
						
				this.element.style.width = new_width + "px";
						
				var mouse_y = mouse_y;
						
				var new_height = mouse_y - (this.capture_top + this.capture_height) + this.capture_height;
						
				this.element.style.height = new_height + "px";
						
				break;
						
				case 5:
						
				var new_top = mouse_y - this.capture_top;
						
				var new_height = this.capture_height - new_top;
					
				this.element.style.top = mouse_y + "px";
						
				this.element.style.height = new_height + "px";
						
				break;
						
				case 6:
						
				var mouse_y = mouse_y;
						
				var new_height = mouse_y - (this.capture_top + this.capture_height) + this.capture_height;
						
				this.element.style.height = new_height + "px";
						
				break;
						
				case 7:
						
				var new_left = mouse_x - this.capture_left;
						
				var new_width = this.capture_width - new_left;
					
				this.element.style.left = mouse_x + "px";
						
				this.element.style.width = new_width + "px";
						
				break;
						
				case 8:
						
				var mouse_x = mouse_x;
						
				var new_width = mouse_x - (this.capture_left + this.capture_width) + this.capture_width;
						
				this.element.style.width = new_width + "px";
						
				break;
					
			}	// END OF SELECT
		
		}
		
	}.bind(this); // END OF METHOD
	
	
} // END OF CLASS