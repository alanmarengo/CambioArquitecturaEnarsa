

function abrir_en_est()
{
	var url = window.location.origin+'/estadisticas.php?mode=1&dt='+document.getElementById("current_id").id_actual+'&cid='+document.getElementById("clase_id").value;
	window.open(url,'_blank');
};

function nuevo()
{

			document.getElementById("grafico_id").value='';
			document.getElementById("grafico_tipo_id").value='';
			document.getElementById("grafico_desc").value='';
			document.getElementById("grafico_titulo").value='';
			document.getElementById("grafico_data_schema").value='';
			document.getElementById("grafico_data_tabla").value='';
			
			document.getElementById("current_id").id_actual=-1;
			document.getElementById("current_id").innerHTML = "<span>Sin Grafico seleccionado</span>";
					
			document.getElementById("tab-link-b").click();
};

function borrar()
{
	if(confirm('Esta seguro desea eliminar el grafico?'))
	{
		
	var retorno = $.ajax
				({
					url: "./abm-graficos.php",
					async:false,
					data:
					{
								mode:2,
								grafico_id:document.getElementById("current_id").id_actual
					},
					dataType: "json"
				});
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		//alert('Se guardo el registro correctamente');
		nuevo();
		
		return true;
	}
	else
	{
		alert('No se pudo borrar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
	}return false;

};

function guardar()
{
	
	var retorno = $.ajax
				({
					url: "./abm-graficos.php",
					async:false,
					data:
					{
								mode:1,
								grafico_id:document.getElementById("current_id").id_actual,
								grafico_tipo_id:document.getElementById("grafico_tipo_id").value,
								grafico_desc:document.getElementById("grafico_desc").value,
								grafico_titulo:document.getElementById("grafico_titulo").value,
								grafico_data_schema:document.getElementById("grafico_data_schema").value,
								grafico_data_tabla:document.getElementById("grafico_data_tabla").value
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		document.getElementById("dt_id").value=s.grafico_id;
		document.getElementById("current_id").id_actual=s.grafico_id;
		document.getElementById("current_id").innerHTML = "<span>Dataset Actual: " + document.getElementById("grafico_desc").value +"("+s.grafico_id+")</span>";
			
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
			document.getElementById("grafico_id").value=args.item.grafico_id;
			document.getElementById("grafico_tipo_id").value=args.item.grafico_tipo_id;
			document.getElementById("grafico_desc").value=args.item.grafico_desc;
			document.getElementById("grafico_titulo").value=args.item.grafico_titulo;
			document.getElementById("grafico_data_schema").value=args.item.grafico_data_schema;
			document.getElementById("grafico_data_tabla").value=args.item.grafico_data_tabla;

			document.getElementById("current_id").id_actual=args.item.grafico_id;
			document.getElementById("current_id").innerHTML = "<span>Dataset Actual: " + args.item.grafico_titulo +"("+args.item.grafico_id+")</span>";
					
			//$("#grid-geovisores-capas").jsGrid('loadData');
			//$("#grid-dt-capas").jsGrid('loadData');
			//$("#grid-dt-variables").jsGrid('loadData');
			
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
					url: "./abm-graficos.php",
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
		
			{name: "grafico_id", 			width: 100},
			{name: "grafico_tipo_id", 		width: 100},
			{name: "grafico_desc", 			width: 300},
			{name: "grafico_titulo", 		width: 800},
			{name: "grafico_data_schema", 	width: 400},
			{name: "grafico_data_tabla", 	width: 400}
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


