function abrir_en_geobi()
{
	var url = window.location.origin+'/geovisor.php?geovisor='+document.getElementById("current_geovisor_id").geovisor_id;
	window.open(url,'_blank');
};

function cargar_preview()
{
	var url = window.location.origin+'/mediateca_preview.php?origen_id=0&r='+document.getElementById("current_capa_id").layer_id;
	document.getElementById("preview_id").src=url;
};


function nuevo_geovisor()
{
			document.getElementById("geovisor_id").value='';
			document.getElementById("geovisor_desc").value='';
			document.getElementById("geovisor_extent").value='';
			
			document.getElementById("current_geovisor_id").geovisor_id=-1;
			document.getElementById("current_geovisor_id").innerHTML = "<span>Sin Geovisor Seleccionado</span>";
					
		
			document.getElementById("tab-link-b").click();
};

function borrar_geovisor()
{
	if(confirm('Esta seguro desea eliminar el geovisor?'))
	{
		
	var retorno = $.ajax
				({
					url: "./abm-geovisores.php",
					async:false,
					data:
					{
								mode:2,
								geovisor_id:document.getElementById("current_geovisor_id").geovisor_id
					},
					dataType: "json"
				});
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		//alert('Se guardo el registro correctamente');
		nuevo_geovisor();
		
		return true;
	}
	else
	{
		alert('No se pudo borrar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
	}return false;

};

function guardar_capa_geovisor(_layer_id)
{
	
	var retorno = $.ajax
				({
					url: "./abm-geovisores.php",
					async:false,
					data:
					{
								mode:3,
								geovisor_id:document.getElementById("current_geovisor_id").geovisor_id,
								iniciar_visible:document.getElementById("iniciar_visible").value,
								layer_id:_layer_id
								
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

function quitar_capa_geovisor(_layer_id,_geovisor_id)
{
	
	var retorno = $.ajax
				({
					url: "./abm-geovisores.php",
					async:false,
					data:
					{
								mode:6,
								geovisor_id:_geovisor_id,
								layer_id:_layer_id
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se quitaron correctamente los datos');
		
		return true;
	}
	else
	{
		alert('No se pudo quitar el dato. Mensaje:'+s.error_desc);
		return false;
	};
	
};

function guardar_geovisor()
{
	
	var retorno = $.ajax
				({
					url: "./abm-geovisores.php",
					async:false,
					data:
					{
								mode:1,
								geovisor_id:document.getElementById("current_geovisor_id").geovisor_id,
								geovisor_desc:document.getElementById("geovisor_desc").value,
								geovisor_extent:document.getElementById("geovisor_extent").value
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		document.getElementById("geovisor_id").value=s.geovisor_id;
		document.getElementById("current_geovisor_id").geovisor_id=s.geovisor_id;
		document.getElementById("current_geovisor_id").innerHTML = "<span>Geovisor Actual: " + document.getElementById("geovisor_desc").value +"("+s.geovisor_id+")</span>";
		
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
	 /**************** GRILLA DE GEOVISORES ****************/
	 
     $("#grid-geovisores").jsGrid({
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
			document.getElementById("geovisor_id").value=args.item.geovisor_id;
			document.getElementById("geovisor_desc").value=args.item.geovisor_desc;
			document.getElementById("geovisor_extent").value=args.item.geovisor_extent;
			
			document.getElementById("current_geovisor_id").geovisor_id=args.item.geovisor_id;
			document.getElementById("current_geovisor_id").innerHTML = "<span>Geovisor Actual: " + args.item.geovisor_desc +"("+args.item.geovisor_id+")</span>";
					
			$("#grid-geovisores-capas").jsGrid('loadData');
			
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
					url: "./abm-geovisores.php",
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
			{name: "geovisor_id", 				width: 100},
			{name: "geovisor_desc", 			width: 200},
			{name: "geovisor_extent", 			width: 400}
			
		]
		});
		
		 /**************** GRILLA DE CAPAS ****************/
	 
		$("#grid-capas").jsGrid({
		width: "100%",
		height: "auto",
		autoload:   true,
		paging:     true,
		pageSize:   20,
		sorting: true,
		pageButtonCount: 5,
		pageIndex:  1,
		rowClick: function(args) 
		{
			guardar_capa_geovisor(args.item.layer_id);
			$("#grid-geovisores-capas").jsGrid('loadData');
        },
		controller: 
		{
			loadData: function(filter) 
			{
				var b = document.getElementById('layersBusqueda').value;
				
				console
				
				return $.ajax
				({
					url: "./abm-geovisores.php",
					data:
					{
								mode:4,
								s:b
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			{name: "layer_id", 				width: 100},
			{name: "layer_desc", 			width: 300},
			{name: "preview_titulo", 		width: 800},
			{name: "preview_desc", 			width: 800}
		]
		});
		
		 /**************** GRILLA DE CAPAS DE GEOVISOR ****************/
	 
		$("#grid-geovisores-capas").jsGrid({
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
			
				quitar_capa_geovisor(args.item.layer_id,args.item.geovisor_id);
				$("#grid-geovisores-capas").jsGrid('loadData');
		
        },
		controller: 
		{
			loadData: function(filter) 
			{
							
				return $.ajax
				({
					url: "./abm-geovisores.php",
					data:
					{
								mode:5,
								geovisor_id:document.getElementById("current_geovisor_id").geovisor_id
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			{name: "layer_id", 				width: 100},
			{name: "nombre_capa", 			width: 200},
			{name: "geovisor_id", 			width: 100},
			{name: "iniciar_visible", 		width: 100}
			
		]
		});
		
		
		

});
