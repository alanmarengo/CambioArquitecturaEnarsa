// JavaScript Document

function FileDropper(conf) {
	
	this.drop_zone = conf.drop_zone;		// DROP ZONE: ELEMENTO HTML DONDE SON SOLTADOS LOS ARCHIVOS
	
	this.drop_zone.draggable = true;	// PARA QUE LOS EVENTOS DRAG AND DROP HTML 5 FUNCIONEN EL ELEMENTO DROP ZONE DEBE TENER LA PROPIEDAD DRAGGABLE EN TRUE
	
	this.server_path = conf.server_path;
	
	this.global_folder = conf.global_folder;

	this.photo_path = conf.photo_path;
	
	if (conf.dir_reader) { this.dir_reader = conf.dir_reader; }

	this.drop_zone.addEventListener('dragover',function(event) { 
	
		event.stopPropagation();
		event.preventDefault();
		event.dataTransfer.dropEffect = 'copy';
		
	}.bind(this),false); 
	
	
	this.drop_zone.addEventListener('drop',function(event) { 	
		
		event.stopPropagation();
		event.preventDefault();
		
		var files = event.dataTransfer.files;	// ARRAY DE ARCHIVOS SOLTADOS EN EL ELEMENTO DROP ZONE
		
		var files_number = files.length;		// CANTIDAD DE ARCHIVOS
		
		if (files_number > 1) {
		
			alert("Solo se puede cargar una imagen");
			
		}else{
		
			var _console = document.getElementById("console");	// DIV DE TESTEO Y DEPURACION DE ERRORES
			
			this.reader = new FileReader();			// DECLARO EL OBJETO FILE READER QUE MANEJARA TODOS LOS PROCESOS DE LECTURA DE ARCHIVOS
			
			this.reader.drop_zone = this.drop_zone;
			
			this.reader.server_path = this.server_path;

			this.reader.photo_path = this.photo_path;
	
			this.reader.global_folder = this.global_folder;
			
			if (conf.dir_reader) { this.reader.dir_reader = this.dir_reader; }

			this.reader.index_file = 0;				// CREO UN INDICE COMO EL i DEL FOR, PARA RECORRER LOS ARCHIVOS A MEDIDA QUE FINALIZA LA LECTURA DE CADA UNO
			this.reader.bunch_size = 3000000;
			
			this.reader.part = 0;
			
			this.reader.parts = 0;
			
			this.reader.onloadstart = function() {
					
					// EVENTO LANZADO AL INICIAR LA CARGA DEL ARCHIVO
					
					this.div_file.status_span.innerHTML = "Cargando: " + this.file_object.name.substring(0,15) + "..." + "0%";
					
						
				}
					
			this.reader.onerror = function(event) {
					
					//alert(event.target.error.code);
						
				}
					
			this.reader.onprogress = function(event) {
					
					// EVENTO LANZADO MIENTRAS SE ESTA CARGANDO EL ARCHIVO progressevent
					
					// DEFINO EL PORCENTAJE TOTAL DEL ARCHIVO
					// DEFINO EL PORCENTAJE ACTUAL CARGADO DEL ARCHIVO
					
					var perc_100 = event.total;
					var perc_x = Math.round((event.loaded * 100) / event.total);
					
					// CALCULO EL ANCHO DE LA BARRA DE CARGA TOTAL
					
					var div_width = this.div_file.offsetWidth;
					
					// CALCULO EL ANCHO DE LA BARRA DE PROGRESO EN BASE AL PORCENTAJE DE LA CARGA DEL ARCHIVO
					
					var new_width = perc_x * div_width / 100;
					
					this.div_file.bar.style.width = new_width + "px";
					
					// ETIQUETO LA BARRA CON LA LEYENDA CARGANDO ARCHIVO "FILE NAME" %
					
					if (this.ajax_file_name) {
					
						var ajax_file_name = this.ajax_file_name;
						
					}else{
					
						var ajax_file_name = String(this.file_object.name);
					
					}
					
					this.div_file.status_span.innerHTML = 
						"Cargando Archivo " + 
						ajax_file_name.substring(0,15) + 
						"... Parte [ " + this.part + " de " + this.parts + " ]" + perc_x + "%";
						
				}
					
			this.reader.onload = function(element) {
				
					// EVENTO LANZADO AL FINALIZAR ( CON EXITO ) LA CARGA DEL ARCHIVO
						
					// GUARDO EL OBJETO DE LA CLASE EN UNA VARIABLE PARA PODER ACCEDER A SUS METODOS Y PROPIEDADES DENTRO DE $.AJAX	
					
					// LO MISMO HAGO CON EL DIV.FILE
					
					// CADA OBJETO READER TIENE SU PROPIO DIV DE PRECARGA Y ESTADO DE SUBIDA.
					
					READER_OBJ = this;
						
					var div_file = this.div_file;
					
					// AL FINALIZAR LA CARGA DEL ARCHIVO IGUALO EL ANCHO DE LA BARRA DE CARGA AL ANCHO TOTAL
					
					this.div_file.bar.style.width = this.div_file.offsetWidth + "px";	
					
					// AJAX_FILE GUARDA EL FRAGMENTO DE ARCHIVO QUE SERA ENVIADO DECODIFICADO COMO DATA URL
					// AJAX FILE NAME ES EL NOMBRE DEL ARCHIVO, SE OBTIENE DEL OBJETO DE ARCHIVO DEL READER
					
					var ajax_file = element.target.result;
					
					if (READER_OBJ.ajax_file_name) {
					
						var ajax_file_name = READER_OBJ.ajax_file_name;
						
					}else{
					
						var ajax_file_name = String(READER_OBJ.file_object.name);
					
					}
					
					// DEFINO LA CANTIDAD DE PARTES DEL ARCHIVO
					
					this.parts = Math.ceil(this.file_object.size / this.bunch_size);
					
					var apply_sql = 0;
					
					if ((this.file_object.size - this.end_bytes) <= this.bunch_size) {
					
						apply_sql = 1;
							
					}
					
					this.part ++;
					
					var part = this.part;

					var server_path = this.server_path;
					
					var global_folder = this.global_folder;

					var photo_path = this.photo_path;
					
					if (conf.dir_reader) { var dir_reader = this.dir_reader; }
					
					$.ajax({
							
						// !IMPORTANTE QUE ESTE async:false, ASI NO EMPIEZA A HACER NADA HASTA FINALIZADA LA LLAMADA AL SERVER Y TERMINADA LA TRANSACCION
							
						async : false,	
						url : server_path + "file_dropper.php",
						type : "POST",
						data : { 
							
							id:dataset_ob[dataset_ob.id_name],
							global_folder:global_folder,
							file:ajax_file,
							file_name:ajax_file_name, 
							PHP_write_mode:'a', 					// MODE 'a' HACE UN APPEND DEL FRAGMENTO AL ARCHIVO QUE SE ESTA SUBIENDO
							apply_sql:apply_sql,
							part:part
						
						},
						dataType : "text",
						error:function(a,b,c) {
							//alert(a + "\n" + b + "\n" + c);
						},
						beforeSend:function() {
							//alert("Before Send: File:" + this.data.file);	
						},
						success:function(js) {
							
							js = JSON.parse(js);
									
							div_file.status_div.src = conf.server_path + "images/" + js.icon;
							
							if (js.message) {
								div_file.status_span.innerHTML = js.message;
								dir_reader.Read();
							}
							
							if (js.status == 1) {								

								//lightbox.Close();
								
							}
							
								READER_OBJ.ajax_file_name = js.file_name;
							
								if (READER_OBJ.file_size > 0) {
						
									READER_OBJ.init_bytes = READER_OBJ.end_bytes;
									READER_OBJ.end_bytes = READER_OBJ.end_bytes + 3000000;
									
									READER_OBJ.file_size = Number(READER_OBJ.file_size) - 3000000;
									
									READER_OBJ.load_next();	
									
								}else{
									
									READER_OBJ.load_next(true);	
									
								}
									
							}
								
					});
					
					
											
						
				}
			
		
			this.reader.load_next = function(pop_do) {
				
				// FUNCION QUE CARGA ARCHIVOS
				
				// EL PARAMETRO POP_DO LE DICE AL READER SI DEBE INCREMENTAR EL INDICE index_file PARA PASAR A LEER EL PROXIMO ARCHIVO
				// ESTA FUNCION PUEDE SER LLAMADA MUCHAS VECES PARA SUBIR 1 SOLO ARCHIVO SI ESTE NECESITA SER FRAGMENTADO
				// EN SU PRIMERA LLAMADA EL VALOR DE POP_DO ES FALSE ASI SE COMIENZA LEYENDO EL PRIMER ARCHIVO ( files[0] )
				
				if (pop_do) {
				
					// PARA UN NUEVO ARCHIVO REINICIO TODAS LAS VARIABLES QUE SE NECESITAN PARA SU LECTURA
					// TAMAÑO DE ARCHIVO TEMPORAL HASTA LLEGAR A MENOS DE 0 (FRAGMENTACION COMPLETA)
					// INCREMENTO EN 1 EL index_file PARA PASAR AL PROXIMO ARCHIVO
					
					this.file_size = undefined;
					
					this.init_bytes = undefined;
					this.end_bytes == undefined
				
					this.index_file ++;
					
				}
				
				// SI EXISTE EL ARCHIVO SOLICITADO LO PROCESO, SINO AQUI TERMINARA LA CARGA DE ARCHIVOS YA QUE EL index_file LLEGO A UN NUMERO IGUAL
				// AL ARRAY FILES.LENGTH LO QUE IMPLICA QUE YA NO HAY ARCHIVOS POR LEER.
				
				if (files[this.index_file]) {
					
					// CADA ELEMENTO DEL TIPO FILE OBJECT TIENE SUS PROPIEDADES, EN SI COMO LO DICE LA PALABRA ES UN OBJETO
					// LA VARIABLE FILE_OBJECT DEL READER GUARDARA EL OBJETO DE TIPO ARCHIVO ACTUAL ( FILE_OBJECT) QUE SE ESTA PROCESANDO
					
					this.file_object = files[this.index_file];
					
					// SI NO ESTA DEFINIDA LA VARIABLE DE TAMAÑO TEMPORAL DE ARCHIVO (file_size) SIGNIFICA QUE SE SUBIRA EL PRIMER FRAGMENTO DEL ARCHIVO
					// SIN IMPORTAR SI UN FRAGMENTO ALCANZA PARA CUBRIR TODO EL ARCHIVO O SE NECESITAN MAS FRAGMENTOS-
					
					if (this.file_size == undefined) {			
						
						// EL METODO CREATE LOADER, CREA EL DIV Y LA BARRA DE PRECARGA QUE MUESTRA LA INFORMACION SOBRE LA SUBIDA DE LOS ARCHIVOS
						// QUE APARECE DEBAJO DEL DROP ZONE
						
						this.create_loader(this.file_object.name);
						
						// ASIGNO LA VARIABLE file_size DEL READER, AL TAMAÑO REAL DEL ARCHIVO.
						// ESTA VARIABLE SE IRA DECREMENTANDO EN 3000000 (TAMAÑO DE FRAGMENTACION DE MI CLASE POR DEFECTO)
						// HASTA SER MENOR A 0 LO CUAL ME INFORMARÁ QUE EL ARCHIVO SE TERMINO DE LEER
						
						this.file_size = files[this.index_file].size;
						
					}				
					
					if ((this.init_bytes == undefined) && (this.end_bytes == undefined)) {
						
						// AQUI DEFINO LAS VARIABLES INIT BYTES Y END BYTES LAS MISMAS IRAN DETERMINANDO LA PORCION DE ARCHIVO QUE SE ESTARA SUBIENDO
						// SINO SE DEFINIERON AUN SIGNIFICA QUE SE ESTA POR SUBIR EL PRIMER FRAGMENTO DEL ARCHIVO ENTONCES DECLARO INIT BYTES EN 0
						// Y END BYTES EN 3000000 (TAMAÑO DE FRAGMENTACION DE MI CLASE POR DEFECTO) ASI FRAGMENTA DE 0 A 3000000 BYTES A MEDIDA QUE SE
						// VAN CARGANDO ARCHIVOS INIT BYTES TOMA EL VALOR DE END BYTES, Y END BYTES SE INCREMENTA EN 3000000, ASI LOS VALORES DE UN ARCHIVO
						// DE 5 FRAGMENTOS SERIAN:
						// 0 - 3000000
						// 3000000 - 6000000
						// 6000000 - 9000000
						// 9000000 - 12000000
						// 12000000 - 15000000
						
						this.init_bytes = 0;
						this.end_bytes = 3000000;
					
					}
					
					// SI LA VARIABLE FILE_SIZE SIGUE SIENDO MAYOR A 0 SIGNIFICA QUE DEBO CARGAR OTRA PORCION DE ARCHIVO
					// PARA ESO USO EL METODO DEL FILE READER readAsDataURL
					// Y LE PASO COMO PARAMETRO EL ARCHIVO ACTUAL FRAGMENTADO CON EL METODO slice Y PASANDOLE POR PARAMETROS LAS VARIABLES
					// INIT BYTES Y END BYTES
					
					if (this.file_size > 0) {
						
						this.readAsDataURL(files[this.index_file].slice(this.init_bytes,this.end_bytes));
						
					}else{
					
					// EN CASO DE QUE FILE_SIZE SEA MENOR A 0 SIGNIFICA QUE EL ARCHIVO ACTUAL YA FUE LEIDO Y PUEDO PASAR AL PROXIMO
					// PARA ESO LLAMO A LA FUNCION LOAD NEXT Y ESTA VEZ EL PARAMETRO POP_DO LO DEFINO COMO TRUE
					
						this.load_next(true);
						
					}	
						
					
					
				}	// END IF EXISTS FILE
			
			} // END READER FUNCTION
			
			
			this.reader.create_loader = function(file_name) {
				
				this.show_file = document.createElement("span");
				this.show_file.appendChild(document.createTextNode(file_name));
				this.show_file.className = "show_file_label";
					
				this.div_file = document.createElement("div");
				this.div_file.setAttribute("name","up_result");
					
				this.div_file.bar_container = document.createElement("div");
				this.div_file.bar_container.className = "file_dropper_bar_container";
					
				this.div_file.bar = document.createElement("div");
				this.div_file.bar.className = "file_dropper_bar";
					
				this.div_file.status_span = document.createElement("span");
				this.div_file.status_span.className = "show_file_label";
					
				this.div_file.status_div = document.createElement("img");
				this.div_file.status_div.className = "status_icon";
				this.div_file.status_div.src = this.server_path + "images/loading_file.gif";			
				
				this.div_file.bar_container.appendChild(this.div_file.bar);
				this.div_file.bar_container.appendChild(this.div_file.status_div);
				this.div_file.bar_container.appendChild(this.div_file.status_span);
				
				this.div_file.appendChild(this.div_file.bar_container);
						
				this.div_file.className = "file_show";
				
				if (document.getElementsByName('up_result')[0]) {
				
					this.drop_zone.removeChild(document.getElementsByName('up_result')[0]);			
				
				}
				
				this.drop_zone.appendChild(this.div_file);
				
			}
			
			
			// ESTA ES LA PRIMERA LLAMADA DE TODA LA CLASE QUE LEERA EL PRIMER FRAGMENTO DEL PRIMER ARCHIVO POR ESO EL PARAMETRO POP_DO VA EN FALSE
			
			this.reader.load_next(false);
					
		}// END OF IF FILES_NUMBER.LENGTH
		
	}.bind(this),false); // END OF DROPZONE ADD EVENT LISTENER
	
	
}