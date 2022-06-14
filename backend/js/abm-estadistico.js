
function abrir_en_est()
{
	var url = window.location.origin+'/estadisticas.php?mode=1&dt='+document.getElementById("current_id").id_actual+'&cid='+document.getElementById("clase_id").value;
	window.open(url,'_blank');
};

function generar_vairables()
{
	if(confirm('Esta seguro que desea registrar las variables (este proceso borrar la configuracion anterior)?'))
	{
		var retorno = $.ajax
					({
						url: "./abm-estadistico.php",
						async:false,
						data:
						{
									mode:7,
									dt_id:document.getElementById("current_id").id_actual,
									dt_titulo:document.getElementById("dt_titulo").value,
									dt_table_source:document.getElementById("dt_table_source").value								
						},
						dataType: "json"
					});
		
		s = JSON.parse(retorno.responseText); /* status */
		
		if(s.status_code=="0")
		{
			$("#grid-dt-capas").jsGrid('loadData');
			
			alert('Se guardaron correctamente los datos');		
			
			return true;
		}
		else
		{
			alert('Hubo problemas para registrar las variables. Mensaje:'+s.error_desc);
			return false;
		};
		
	}else return false;	
};

function nuevo()
{
			document.getElementById("dt_id").value='';
			document.getElementById("clase_id").value='';
			document.getElementById("dt_titulo").value='';
			document.getElementById("dt_desc").value='';
			document.getElementById("dt_table_source").value='';
			document.getElementById("dt_geom_base_table").value='';
			document.getElementById("dt_geom_column_display").value='';
			
			document.getElementById("current_id").id_actual=-1;
			document.getElementById("current_id").innerHTML = "<span>Sin dataset seleccionado</span>";
					
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

function guardar_capa_dt()
{
	var retorno = $.ajax
				({
					url: "./abm-estadistico.php",
					async:false,
					data:
					{
								mode:3,
								dt_id:document.getElementById("current_id").id_actual,
								dt_cruce_table:document.getElementById("dt_cruce_table").value,
								dt_cruce_column_display:document.getElementById("dt_cruce_column_display").value,
								dt_cruce_etiqueta:document.getElementById("dt_cruce_etiqueta").value								
					},
					dataType: "json"
				});
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		$("#grid-dt-capas").jsGrid('loadData');
		
		alert('Se guardaron correctamente los datos');		
		
		return true;
	}
	else
	{
		alert('Hubo problemas para registrar en el catalogo. Mensaje:'+s.error_desc);
		return false;
	};
	
};

function quitar_capa_dt(_cruce_id)
{
	if(confirm('Esta seguro desea quitar el dato?'))
	{
		
	var retorno = $.ajax
				({
					url: "./abm-estadistico.php",
					async:false,
					data:
					{
								mode:6,
								dt_cruce_id:_cruce_id
								
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
	
	}else return false;
	
};

function guardar()
{
	
	var retorno = $.ajax
				({
					url: "./abm-estadistico.php",
					async:false,
					data:
					{
								mode:1,
								dt_id:document.getElementById("current_id").id_actual,
								clase_id:document.getElementById("clase_id").value,
								dt_titulo:document.getElementById("dt_titulo").value,
								dt_desc:document.getElementById("dt_desc").value,
								dt_table_source:document.getElementById("dt_table_source").value,
								dt_geom_base_table:document.getElementById("dt_geom_base_table").value,
								dt_geom_column_display:document.getElementById("dt_geom_column_display").value
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		document.getElementById("dt_id").value=s.dt_id;
		document.getElementById("current_id").id_actual=s.dt_id;
		document.getElementById("current_id").innerHTML = "<span>Dataset Actual: " + document.getElementById("dt_titulo").value +"("+s.dt_id+")</span>";
			
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
	 
     $("#grid-busqueda").jsGrid({
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
			document.getElementById("dt_id").value=args.item.dt_id;
			document.getElementById("clase_id").value=args.item.clase_id;
			document.getElementById("dt_titulo").value=args.item.dt_titulo;
			document.getElementById("dt_desc").value=args.item.dt_desc;
			document.getElementById("dt_table_source").value=args.item.dt_table_source;
			document.getElementById("dt_geom_base_table").value=args.item.dt_geom_base_table;
			document.getElementById("dt_geom_column_display").value=args.item.dt_geom_column_display;
			
			document.getElementById("current_id").id_actual=args.item.dt_id;
			document.getElementById("current_id").innerHTML = "<span>Dataset Actual: " + args.item.dt_titulo +"("+args.item.dt_id+")</span>";
					
			//$("#grid-geovisores-capas").jsGrid('loadData');
			$("#grid-dt-capas").jsGrid('loadData');
			$("#grid-dt-variables").jsGrid('loadData');
			
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
					url: "./abm-estadistico.php",
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
			{name: "dt_id", 				width: 100},
			{name: "clase_id", 				width: 100},
			{name: "dt_titulo", 			width: 300},
			{name: "dt_desc", 				width: 800},
			{name: "dt_table_source", 		width: 400},
			{name: "dt_geom_base_table", 	width: 400},
			{name: "dt_geom_column_display",width: 400}	
		]
		});
		
		 /**************** GRILLA DE CAPAS ****************/
	 
		$("#grid-dt-capas").jsGrid({
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
			quitar_capa_dt(args.item.dt_cruce_id);
			$("#grid-dt-capas").jsGrid('loadData');
		
        },
		controller: 
		{
			loadData: function(filter) 
			{
					
				return $.ajax
				({
					url: "./abm-estadistico.php",
					data:
					{
								mode:4,
								dt_id:document.getElementById("current_id").id_actual
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			{name: "dt_cruce_table", 		width: 200},
			{name: "dt_cruce_column_display", 	width: 200},
			{name: "dt_cruce_etiqueta", 		width: 200},
			{name: "dt_cruce_id", 				width: 100},
			{name: "dt_id", 					width: 100}
		]
		});
		
		 /**************** GRILLA DE CAPAS DE GEOVISOR ****************/
	 
		$("#grid-dt-variables").jsGrid({
		width: "100%",
		height: "auto",
		autoload:   true,
		paging:     true,
		pageSize:   10,
		sorting: true,
		pageButtonCount: 5,
		pageIndex:  1,
		rowClick: function(args) 
		{
			document.getElementById("dt_variable_id").value=args.item.dt_variable_id;
			document.getElementById("dt_variable_nombre").value=args.item.dt_variable_nombre;
			document.getElementById("dt_variable_defincion").value=args.item.dt_variable_defincion;
			document.getElementById("dt_variable_origen").value=args.item.dt_variable_origen;
	
        },
		controller: 
		{
			loadData: function(filter) 
			{
							
				return $.ajax
				({
					url: "./abm-estadistico.php",
					data:
					{
								mode:8,
								dt_id:document.getElementById("current_id").id_actual
					},
					dataType: "json"
				});
			}
		},
		fields: 
		[
			
			{name: "dt_variable_nombre", 	width: 200},
			{name: "dt_variable_defincion", width: 200},
			{name: "dt_variable_origen", 	width: 200},
			{name: "dt_variable_cod_var", 	width: 200},
			{name: "dt_id_ref", 			width: 100},
			{name: "dt_variable_id", 		width: 100}
			
		]
		});
		
		
		

});


function guardar_variable()
{
	var retorno = $.ajax
				({
					url: "./abm-estadistico.php",
					async:false,
					data:
					{
								mode:9,
								dt_variable_id:document.getElementById("dt_variable_id").value,
								dt_variable_nombre:document.getElementById("dt_variable_nombre").value,
								dt_variable_defincion:document.getElementById("dt_variable_defincion").value,
								dt_variable_origen:document.getElementById("dt_variable_origen").value
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		$("#grid-dt-variables").jsGrid('loadData');
		
		return true;
	}
	else
	{
		alert('No se puedo guardar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
	
};


function borrar_variable()
{
	var retorno = $.ajax
				({
					url: "./abm-estadistico.php",
					async:false,
					data:
					{
								mode:10,
								dt_variable_id:document.getElementById("dt_variable_id").value
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se borraron correctamente los datos');
		
		$("#grid-dt-variables").jsGrid('loadData');
		
		return true;
	}
	else
	{
		alert('No se puedo guardar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
	
};

