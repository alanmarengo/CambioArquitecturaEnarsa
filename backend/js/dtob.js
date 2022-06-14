function dtob(conf) {

	this.id = null;
	this.id_name = conf.id_name;
	
	if (conf.dir_reader) {
		
		this.dir_reader = new DirectoryReader(conf.dir_reader);
		console.log(conf.dir_reader);
		
	}
	
	if (conf.file_dropper) {
		
		if (conf.dir_reader) { conf.file_dropper.dir_reader = this.dir_reader; }
		this.file_dropper = new FileDropper(conf.file_dropper);
		
	}
	
	this.get_new_id = function() {
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:conf.urls.new_id,
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		$("input[name=" + this.id_name + "]").val(js[this.id_name]);
		
		this[this.id_name] = js[this.id_name];
		this.id = js[this.id_name];
		
		if (conf.onNewId) { conf.onNewId(this.id) }
		
		return js[this.id_name];
		
	}
	
	this.load = function(id) {
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:conf.urls.load,
			data:{
				id:id,
			},
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		this[this.id_name] = js[this.id_name];
		this.id = js[this.id_name];
		
		if (conf.onLoad) { conf.onLoad(js); }
		
		return js;
		
	}
	
	this.load_with_grid = function(frm,data) {
		
		for (key in data) {
			
			if (frm.elements.namedItem(key)) {
			
				frm.elements.namedItem(key).value = data[key];
			
			}
			
		}
		
		this[this.id_name] = data[this.id_name];
		this.id = data[this.id_name];
		
	}
	
	this.save = function(frm) {
		
		var data = {};
		
		for (var i=0; i<frm.elements.length; i++) {
			
			data[frm.elements[i].name] = frm.elements[i].value;
			
		}
		
		data.id_name = this.id_name;
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:conf.urls.save,
			data:data,
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		if (js.status) {
			
			if (conf.onSave) { conf.onSave(); }			
			
		}
		
		alert(js.msg);
		
	}
	
	this.drop = function() {
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:conf.urls.drop,
			data:{
				id:this.id,
				id_name:this.id_name
			},
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		if (js.status) {
			
			if (conf.onDrop) { conf.onDrop(); }
			
			this[this.id_name] = null;
			this.id = null;
			
			
		}
		
		alert(js.msg);
		
	}
	
	return this;

}