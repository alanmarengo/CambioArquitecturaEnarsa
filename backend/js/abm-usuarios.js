

function abrir_en_est()
{
	var url = window.location.origin+'/estadisticas.php?mode=1&dt='+document.getElementById("current_id").id_actual+'&cid='+document.getElementById("clase_id").value;
	window.open(url,'_blank');
};

function nuevo()
{

			document.getElementById("user_id").value='';
			document.getElementById("user_name").value='';
			document.getElementById("user_full_name").value='';
			document.getElementById("user_estado_id").value='';
			document.getElementById("user_contra_dominio").value='';
			document.getElementById("perfil_usuario_id").value='';

			document.getElementById("current_id").id_actual=-1;
			document.getElementById("current_id").innerHTML = "<span>Sin usuario seleccionado</span>";
					
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
	var estado = document.getElementById("current_id").id_actual;
	
	var retorno = $.ajax
				({
					url: "./abm-usuarios.php",
					async:false,
					data:
					{
								mode:1,
								user_id:document.getElementById("current_id").id_actual,
								user_name:document.getElementById("user_name").value,
								user_full_name:document.getElementById("user_full_name").value,
								user_estado_id:document.getElementById("user_estado_id").value,
								user_contra_dominio:document.getElementById("user_contra_dominio").value,
								perfil_usuario_id:document.getElementById("perfil_usuario_id").value
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se guardaron correctamente los datos');
		
		document.getElementById("user_id").value=s.user_id;
		document.getElementById("current_id").id_actual=s.user_id;
		document.getElementById("current_id").innerHTML = "<span>Usuario Actual: " + document.getElementById("user_full_name").value +"("+s.user_id+")</span>";
			
		dom = document.getElementById("user_contra_dominio").value
		if((estado==-1)&&(dom=='f')) {alert('Defina la contraseña'); document.getElementById("tab-link-c").click(); };
		
		return true;
	}
	else
	{
		alert('No se puedo guardar el registro. Mensaje:'+s.error_desc);
		return false;
	};
	
};

function guardar_pw()
{
	var estado = document.getElementById("current_id").id_actual;
	
	if(document.getElementById("user_contra_dominio").value=='f')
	{
	
		var retorno = $.ajax
					({
						url: "./abm-usuarios.php",
						async:false,
						data:
						{
									mode:2,
									user_id:document.getElementById("current_id").id_actual,
									passw:document.getElementById("passw").value,
									passwc:document.getElementById("passwc").value
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
			alert('No se puedo guardar el registro. Mensaje:'+s.error_desc);
			return false;
		};
	}else{alert('El usuario ingresa contra dominio, no es necesario ingresar contraseña.');};
	
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
			document.getElementById("user_id").value=args.item.user_id;
			document.getElementById("user_name").value=args.item.user_name;
			document.getElementById("user_full_name").value=args.item.user_full_name;
			document.getElementById("user_estado_id").value=args.item.user_estado_id;
			document.getElementById("user_contra_dominio").value=args.item.user_contra_dominio;
			document.getElementById("perfil_usuario_id").value=args.item.perfil_usuario_id;

			document.getElementById("current_id").id_actual=args.item.user_id;
			document.getElementById("current_id").innerHTML = "<span>Usuario Actual: " + args.item.user_full_name +"("+args.item.user_id+")</span>";
					
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
					url: "./abm-usuarios.php",
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
		
			{name: "user_id", 			width: 100},
			{name: "user_name", 		width: 100},
			{name: "user_full_name", 	width: 300},
			{name: "user_estado_id", 	width: 100},
			{name: "user_contra_dominio", 	width: 100},
			{name: "perfil_usuario_id", 	width: 100}
			
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


