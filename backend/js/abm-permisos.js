
function guardar_perfil_recurso()
{
	
	var retorno = $.ajax
				({
					url: "./abm-permisos.php",
					async:false,
					data:
					{
								mode:2,
								objeto_tipo_id:document.getElementById("current_id").objeto_tipo_id,
								objeto_id:document.getElementById("current_id").objeto_id,
								perfil_usuario_id:document.getElementById("perfil_usuario_id").value
								
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		$("#grid-perfiles-recurso").jsGrid('loadData');
		
		
		return true;
	}
	else
	{
		alert('Hubo problemas para registrar en el catalogo. Mensaje:'+s.error_desc);
		return false;
	};
	
};

function quitar_perfil_recurso(_objeto_tipo_id,_objeto_id,_perfil_id)
{
	if(confirm('Esta seguro desea quitar el perfil de los permisos?'))
	{
		
	var retorno = $.ajax
				({
					url: "./abm-permisos.php",
					async:false,
					data:
					{
								mode:3,
								objeto_tipo_id:_objeto_tipo_id,
								objeto_id:_objeto_id,
								perfil_usuario_id:_perfil_id
								
								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se quiaron correctamente los datos');
		
		$("#grid-perfiles-recurso").jsGrid('loadData');
		
		
		return true;
	}
	else
	{
		alert('Hubo problemas para quitar los datos. Mensaje:'+s.error_desc);
		return false;
	};
	
	}else return false;
	
};


$(
function() 
{
	 /**************** GRILLA DE GEOVISORES ****************/
	 
     $("#grid-buscar").jsGrid({
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
			/*document.getElementById("geovisor_id").value=args.item.geovisor_id;
			document.getElementById("geovisor_desc").value=args.item.geovisor_desc;
			document.getElementById("geovisor_extent").value=args.item.geovisor_extent;*/
			
			document.getElementById("current_id").objeto_tipo_id=args.item.origen_id;
			document.getElementById("current_id").objeto_id=args.item.origen_id_especifico;
			document.getElementById("current_id").innerHTML = "<span>Recurso Actual: " + args.item.recurso_titulo +"(ID:"+args.item.origen_id_especifico+")</span>";
					
			$("#grid-perfiles-recurso").jsGrid('loadData');
			
			document.getElementById("tab-link-c").click();
        },
		controller: 
		{
			loadData: function(filter) 
			{
				var b = document.getElementById('dtBusqueda').value;
				
				console
				
				return $.ajax
				({
					url: "./abm-permisos.php",
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
			{name: "preview",
			itemTemplate: function(val, item) 
						  {
							return $("<img>").attr("src", val).css({ height: 50, width: 50 })
                          }
			},
			{name: "origen", 					width: 100},
			{name: "recurso_titulo", 			width: 800},
			{name: "recurso_desc", 				width: 200},
			{name: "recurso_categoria_desc",	width: 200},
			{name: "origen_id",					width: 100},
			{name: "origen_id_especifico", 		width: 100}
			
		]
		});
		
	
		 /**************** GRILLA DE CAPAS DE GEOVISOR ****************/
	 
		$("#grid-perfiles-recurso").jsGrid({
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
				quitar_perfil_recurso(args.item.objeto_tipo_id,args.item.objeto_id,args.item.perfil_usuario_id);
        },
		controller: 
		{
			loadData: function(filter) 
			{
							
				return $.ajax
				({
					url: "./abm-permisos.php",
					data:
					{
								mode:1,
								objeto_id:document.getElementById("current_id").objeto_id,
								objeto_tipo_id:document.getElementById("current_id").objeto_tipo_id
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			{name: "perfil", 				width: 200},
			{name: "objeto_id", 			width: 100},
			{name: "objeto_tipo_id", 		width: 100},
			{name: "perfil_usuario_id",		width: 100}
			
		]
		});
		
		
		

});

