(function($) {
	'use strict';
	$(function() {
		
		$("#dtBusqueda").on("keyup",function(event) {
			
			if (event.which == 13) {
				
				$("#dtBtnBusqueda").trigger("click");
				
			}
			
		});
		
		//basic config
		if ($("#grid-recursos").length) {
			$("#grid-recursos").jsGrid({
				height: "500px",
				width: "100%",
				/*filtering: true,
				editing: true,
				inserting: true,*/
				sorting: true,
				paging: true,
				autoload: true,
				pageSize: 10,
				pageButtonCount: 5,
				deleteConfirm: "Desea eliminar este recurso?",
				controller: {
					loadData: function (filter) {
						
						dataset_ob.dir_reader.Read();
						
						var busqueda = $("#dtBusqueda").val();
						
						var req = $.ajax({
							
							async:false,
							type: "POST",
							//contentType: "application/json; charset=utf-8",
							data:{
								busqueda:busqueda
							},
							url: "./php/get-recursos.php",
							datatype: "json"
							
						});
						
						var js = JSON.parse(req.responseText);
						
						return js.data;
						
					}					
					
				},
				rowClick:function(args) {
					
					var data = args.item;	

					dataset_ob.load_with_grid(document.getElementById("frm-backend-main"),data);
					
					dataset_ob[dataset_ob.id_name] = data.recurso_id;
					
					dataset_ob.dir_reader.dir = "./images/uploaded/datasets/";
					
					dataset_ob.dir_reader.Read();
					
					document.getElementById("recurso_current").innerHTML = "<span> Recurso Actual, Id:" + data.recurso_id + ", Titulo: " + data.dt_titulo + "</span>";
				
					if (data.dt_id) {
						$("#grid-dt-graficos").jsGrid("loadData");
						$("#grid-dt-layers").jsGrid("loadData");
						$("#grid-dt-subtemas").jsGrid("loadData");
					}

					$("#tab-link-dataset").trigger("click");
					
					$(".backend-files-wrapper").show();
					
				},
				onDataLoaded:function() {
				
					$(this._container).find(".jsgrid-grid-body").append($(this._container).find(".jsgrid-pager-container"));
						
					$(this._container).find(".jsgrid-cell").each(function(i,v) {
						
						var title = v.innerHTML;						
						v.setAttribute("title",title);
						
					});
					
				},
				fields: [
				{
					name: "recurso_id",
					type: "number",
					width: 80,
					readOnly:true
				},{
					name: "recurso_titulo",
					type: "text",
					width: 150,
					readOnly:true
				},
				{
					name: "recurso_desc",
					type: "text",
					width: 150
				}]
			});
			
		}
	});
	
})(jQuery);
