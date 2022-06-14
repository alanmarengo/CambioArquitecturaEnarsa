// JavaScript Document

function DirectoryReader(conf) {

	this.server_path = conf.server_path;
	this.dir = conf.dir;
	this.showListContainer = conf.showListContainer;
	this.fileInfoContainer = conf.fileInfoContainer
	
	this.Read = function() {
		
		this.showListContainer.innerHTML = "";
		
		var dirpath = this.dir;
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:this.server_path + "directory_reader.php",
			data:{
				dir:dirpath,
				id:dataset_ob[dataset_ob.id_name]
			},
			success:function(d){}
			
		});
		
		this.showListContainer.innerHTML = req.responseText;
		
		$(".directory-item").each(function(i,v) {
			
			$(v).find(".link").first().on("click",function() {
				
				var dir = $(this).attr("data-dir");
				var filetype = $(this).attr("data-filetype");
				var filename = $(this).attr("data-filename");
				var filepath = $(this).attr("data-filepath");
				
				$("#file-info-div").Roverlay("open");
				$("#file-info-div").Roverlay("refresh");
				
				$("#file-info-div").find(".file-link").val(dir+filename);
				$("#file-info-div").find(".file-open").attr("href",dir+filename);
				
			});
			
		});
		
	}
	
}