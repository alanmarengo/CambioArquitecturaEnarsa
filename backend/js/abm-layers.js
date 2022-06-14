
function abrir_en_geobi()
{
	var url = window.location.origin+'/geovisor.php?source=1&id='+document.getElementById("current_capa_id").layer_id;
	window.open(url,'_blank');
};

function cargar_preview()
{
	var url = window.location.origin+'/mediateca_preview.php?origen_id=0&r='+document.getElementById("current_capa_id").layer_id;
	document.getElementById("preview_id").src=url;
};


function nueva_capa()
{
			document.getElementById("layer_id").value='';
			document.getElementById("layer_desc").value='';
			document.getElementById("layer_wms_server").value='';
			document.getElementById("layer_wms_layer").value='';
			document.getElementById("layer_wms_server_alter").value='';
			document.getElementById("layer_wms_layer_alter").value=''; 
			document.getElementById("layer_alter_activo").value=''; 	
			document.getElementById("layer_metadata_url").value=''; 	
			document.getElementById("layer_schema").value=''; 			
			document.getElementById("layer_table").value=''; 			
			document.getElementById("tipo_layer_id").value=''; 		
			document.getElementById("preview_desc").value=''; 			
			document.getElementById("preview_titulo").value='';
	
			document.getElementById("current_capa_id").innerHTML = "<span>Sin Capa Seleccionada</span>";
			document.getElementById("current_capa_id").layer_id = -1;/* -1 = nueva capa */
		
			document.getElementById("tab-link-b").click();
};

function borrar_capa()
{
	if(confirm('Esta seguro desea eliminar la capa?'))
	{
		
	var retorno = $.ajax
				({
					url: "./abm-layers.php",
					async:false,
					data:
					{
								mode:2,
								layer_id:document.getElementById("current_capa_id").layer_id
					},
					dataType: "json"
				});
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		//alert('Se guardo el registro correctamente');
		nueva_capa();
		
		return true;
	}
	else
	{
		alert('No se pudo borrar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
	}return false;

};

function guardar_catalogo()
{
	
	var retorno = $.ajax
				({
					url: "./abm-layers.php",
					async:false,
					data:
					{
								mode:3,
								layer_id:document.getElementById("current_capa_id").layer_id,
								layer_desc:document.getElementById("layer_desc").value,
								layer_wms_server:document.getElementById("layer_wms_server").value,
								layer_wms_layer:document.getElementById("layer_wms_layer").value,
								layer_wms_server_alter:document.getElementById("layer_wms_server_alter").value,
								layer_wms_layer_alter:document.getElementById("layer_wms_layer_alter").value,
								layer_alter_activo:document.getElementById("layer_alter_activo").value,	
								layer_metadata_url:document.getElementById("layer_metadata_url").value,	
								layer_schema:document.getElementById("layer_schema").value,		
								layer_table:document.getElementById("layer_table").value,			
								tipo_layer_id:document.getElementById("tipo_layer_id").value,		
								preview_desc:document.getElementById("preview_desc").value, 			
								preview_titulo:document.getElementById("preview_titulo").value
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		return true;
	}
	else
	{
		alert('Hubo problemas para registrar en el catalogo. Mensaje:'+s.error_desc);
		return false;
	};
	
};

function guardar_capa()
{
	
	var retorno = $.ajax
				({
					url: "./abm-layers.php",
					async:false,
					data:
					{
								mode:1,
								layer_id:document.getElementById("current_capa_id").layer_id,
								layer_desc:document.getElementById("layer_desc").value,
								layer_wms_server:document.getElementById("layer_wms_server").value,
								layer_wms_layer:document.getElementById("layer_wms_layer").value,
								layer_wms_server_alter:document.getElementById("layer_wms_server_alter").value,
								layer_wms_layer_alter:document.getElementById("layer_wms_layer_alter").value,
								layer_alter_activo:document.getElementById("layer_alter_activo").value,	
								layer_metadata_url:document.getElementById("layer_metadata_url").value,	
								layer_schema:document.getElementById("layer_schema").value,		
								layer_table:document.getElementById("layer_table").value,			
								tipo_layer_id:document.getElementById("tipo_layer_id").value,		
								preview_desc:document.getElementById("preview_desc").value, 			
								preview_titulo:document.getElementById("preview_titulo").value
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		document.getElementById("layer_id").value=s.layer_id;
		document.getElementById("current_capa_id").layer_id=s.layer_id;
		document.getElementById("current_capa_id").innerHTML = "<span>Capa Actual: " + document.getElementById("layer_desc").value +"("+s.layer_id+")</span>";
		
		cargar_preview();
		
		return true;
	}
	else
	{
		alert('No se puedo guardar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
};


$(
function() 
{
	 /**************** GRILLA DE MAPAS ****************/
	 
     $("#grid-layers").jsGrid({
		width: "100%",
		height: "auto",
		autoload:   true,
		paging:     true,
		pageSize:   5,
		sorting: true,
		pageButtonCount: 5,
		pageIndex:  1,
		rowClick: function(args) 
		{
			document.getElementById("layer_id").value=args.item.layer_id;
			document.getElementById("layer_desc").value=args.item.layer_desc;
			document.getElementById("layer_wms_server").value=args.item.layer_wms_server;
			document.getElementById("layer_wms_layer").value=args.item.layer_wms_layer;
			document.getElementById("layer_wms_server_alter").value=args.item.layer_wms_server_alter;
			document.getElementById("layer_wms_layer_alter").value=args.item.layer_wms_layer_alter; 
			document.getElementById("layer_alter_activo").value=args.item.layer_alter_activo; 	
			document.getElementById("layer_metadata_url").value=args.item.layer_metadata_url; 	
			document.getElementById("layer_schema").value=args.item.layer_schema; 			
			document.getElementById("layer_table").value=args.item.layer_table; 			
			document.getElementById("tipo_layer_id").value=args.item.tipo_layer_id; 		
			document.getElementById("preview_desc").value=args.item.preview_desc; 			
			document.getElementById("preview_titulo").value=args.item.preview_titulo;
			
			document.getElementById("current_capa_id").layer_id=args.item.layer_id;
			document.getElementById("current_capa_id").innerHTML = "<span>Capa Actual: " + args.item.layer_desc +"("+args.item.layer_id+")</span>";
					
			cargar_preview();
			
			document.getElementById("tab-link-b").click();
        },
		controller: 
		{
			loadData: function(filter) 
			{
				var b = document.getElementById('dtBusqueda').value;
				
				console
				
				return $.ajax
				({
					url: "./abm-layers.php",
					data:
					{
								mode:0,
								s:b
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			{name: "layer_id", 				width: 100},
			{name: "layer_desc", 			width: 200},
			{name: "layer_wms_server", 		width: 200},
			{name: "layer_wms_layer", 		width: 200},
			{name: "layer_wms_server_alter",width: 200},
			{name: "layer_wms_layer_alter", width: 200},
			{name: "layer_alter_activo", 	width: 200},
			{name: "layer_metadata_url", 	width: 200},
			{name: "layer_wms_sld", 		width: 200},
			{name: "layer_schema", 			width: 200},
			{name: "layer_table", 			width: 200},
			{name: "tipo_layer_id", 		width: 200},
			{name: "tipo_origen_id", 		width: 200},
			{name: "preview_desc", 			width: 200},
			{name: "preview_link", 			width: 200},
			{name: "preview_titulo", 		width: 800}
		]
		});
		
		

});
