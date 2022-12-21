function ol_indicadores() {

	this.panel = {};
	this.panel.div = document.getElementById("nav-panel");
	
	this.current_ind = 0;
	this.current_ind_title = "";
	this.current_cid = 0;
	
	this.panel.start = function() {
		
		$(".panel-abr").on("click",function() {
			
			if (this.getAttribute("data-active") == 0) {
					
				$(".panel-abr").attr("data-active","0");
				//$(".panel-abr").css("border-color","transparent");
				//$(".panel-abr").css("background-color","transparent");
				$(".panel-abr").css("background-color","#F5F5F5");
				$(".panel-abr").css("color","#888888");
				
				$(this).attr("data-active","1");
				//$(this).css("border-color",this.getAttribute("data-color"));
				//$(this).css("background-color",this.getAttribute("data-bgcolor"));
				$(this).css("background-color","#31cbfd");
				$(this).css("color","#FFFFFF");
					
				$(".layer-container").not(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").hide();
				$(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").show();
				//$("#abr-container").first(".panel-abr").prepend(this);			
				scroll.refresh();
					
			}
			
		});
	
	}

	this.loadIndicador = function(ind_id,titulo,clase_id) {
		
		var req = $.ajax({
			
			async:false,
			url:"./indicadores.template.php",
			type:"post",
			data:{
				ind_id:ind_id
			},
			success:function(d){}			
			
		});		
		
		this.current_ind = ind_id;
		this.current_title = titulo;
		this.current_cid = clase_id;
		
		$("#navbar-tools h3").html("Indicadores / " + titulo);
		
		$("#template-wrapper").html("<h3 style='display:none;' id='titulo-indicador-"+ind_id+"'>"+titulo+"</h3>"+req.responseText);
		
		$("#template-wrapper .resource-col").each(function(i,v) {
			
			var pos = $(v).children(".resource-inner").attr("data-pos");
			this.loadIndicadorResource(ind_id,pos);
			
		}.bind(this));
		
		scroll.refresh();
		
		if (clase_id) {
			
			$(".abr[data-cid="+clase_id+"]").trigger("click");
			
		}
		
	}
	
	this.loadIndicadorResource = function(ind_id,pos) {
		
		var ind_inner = document.createElement("div");
			ind_inner.id = "indicador-inner-"+pos;
			
		var container = document.getElementById("indicador-col-pos-"+pos);
		
		container.appendChild(ind_inner);
		
		var notitle = false;
		
		if (container.getAttribute("data-notitle") == 1) {
			
			notitle = true;
			
		}
		
		var req = $.ajax({
			
			async:false,
			url:"./indicadores.get-recurso.php",
			type:"post",
			data:{
				ind_id:ind_id,
				pos:pos
			},
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		console.log(js)
		
		switch(js.type) {		

			case "layer":
				var height = $("#indicador-col-pos-"+pos).height();
				
				var map_layers = [];

				map_layers[0] = new ol.layer.Tile({
					name:'google_base',
					visible:true,
					source: new ol.source.TileImage({ 
						url: 'https://mt{0-3}.googleapis.com/vt?&x={x}&y={y}&z={z}&hl=es&gl=AR',
						crossOrigin: 'anonymous'
					})
				});
				
				for (var i=0; i<js.layers.length; i++) {

					let espacioDeTrabajo = js.layers[0].split(':')

					let urlPrepareLayer = js.layers_server[i] //Url original (http://192.168.11.10:8080/geoserver/ows?)
					let urlLayer = ''
					let urlSplitLayer = urlPrepareLayer.split('/geoserver/') // Divido Url desde "/geoserver/"

					if(urlSplitLayer[0] == 'https://observatorio.energia-argentina.com.ar'){  // Si la primera parte es de produccion, lo dejamos tal cual
						/* urlLayer = urlPrepareLayer; */
						urlLayer = urlSplitLayer[0]+'/geoserver/'+espacioDeTrabajo[0]+'/'+urlSplitLayer[1]
					}else{
						urlLayer = 'https://observatorio-dev.energia-argentina.com.ar/geoserver/'+espacioDeTrabajo[0]+'/'+urlSplitLayer[1]; //Si no, le ponemos la url del dev de ieasa
					}


/* 					console.log('######### ACA ###########')
					console.log(js.layers[0])
					console.log(espacioDeTrabajo[0])
					console.log(urlPrepareLayer)
					console.log(urlSplitLayer[0])
					console.log(urlLayer)
					console.log('######### FIN ###########') */
					
					
				
					map_layers[i+1] = new ol.layer.Tile({
						name:js.layers[i],
						visible:true,
						source: new ol.source.TileWMS({
							url: urlLayer,
							params: {
								'LAYERS': js.layers[i],
								'VERSION': '1.1.1',
								'FORMAT': 'image/png',
								'TILED': false
							}
						})
					});
				}
				

				//console.log('extent: '+js.extent);
				var extent_indi = '';
				if(js.extent=='')
				{
					//console.log('extent por defecto');
					extent_indi = [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727];
				}else
				{
					//console.log('extent de usuario: '+js.extent);
					extent_indi = JSON.parse(js.extent);
					//console.log('extent de usuario obj: '+extent_indi);
				}
				
				
				var indMap = new ol.Map({
					layers:map_layers,
					target: "indicador-inner-"+pos,
					extent: [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727],
					controls: [],
					view: new ol.View({
						center: [-7176058.888636417,-4680928.505993671],
						zoom:3.8,
						minZoom: 3.8,
						maxZoom: 21
					})
				});
				
				indMap.getView().fit(extent_indi,{duration:1000});
				indMap.updateSize();
				indMap.render();
				setTimeout(function(){
					
					$("#indicador-inner-"+pos).css("height",height+"px");

					indMap.updateSize();
					indMap.render();

				},1000); 
				
				
				indMap.addEventListener("click",function(evt) {

					var view =  indMap.getView();
					var viewResolution = (view.getResolution());


					urlPrepare = map_layers[1].getSource().getGetFeatureInfoUrl(evt.coordinate, viewResolution, 'EPSG:3857', {
						'INFO_FORMAT': 'application/json',
						'FEATURE_COUNT': '300'
					});	
					let url = ''
					let urlSplit = urlPrepare.split('/geoserver/')
					if(urlSplit[0] == 'https://observatorio.energia-argentina.com.ar'){
						url = urlPrepare;
					}else{
						url = 'https://observatorio-dev.energia-argentina.com.ar/geoserver/'+urlSplit[1];
					}
					

					var req = $.ajax({								
						async:false,
						type:"GET",
						url:url,
						//url:"urldeprueba.php",
						success:function(d){}						
					})

					
					if(req.responseJSON.features.length > 0){

					
					
					let htmlDatos = '<div id="pDatos">';

					for(var i = 0; i<req.responseJSON.features.length; i++){

						let data = req.responseJSON.features[i].properties;
						let keyData = ''
						let valueData = ''
						htmlDatos += '<div id="xId">';
						let keyNames = Object.keys(data);
						for(var key in keyNames){
							//console.log(data[keyNames[key]])
							keyData = keyNames[key]
							valueData = data[keyNames[key]]
							htmlDatos += 
							`
							<p class="infoData"><span class="keyData"> ${keyData}:</span> ${valueData} </p>
							`;
						}
						htmlDatos += '</div>';
					}

					htmlDatos += '</div>';

					const htmlModal =
					`
						<div class="containerModal">
							<div class="paperModal">
									<div class="headerModal"> 
										<span class="titleGFI"> Datos de la capa </span>
										<i id="cerrarModal" class="cerrarModal fa fa-times"> </i>
									</div>
									<div class="bodyModal"> ${htmlDatos}</div>
									<div class="footerModal"> </div>
							</div>	
						</div>
					`
						$('#indicador-inner-'+pos).append(htmlModal);

					}else{
						$('.containerModal').remove()
					}//Cierra el if de .length

						$('.cerrarModal').on('click', function(){
							$('.containerModal').remove()
						})
						
				}) 			


				const zoom = `
				<div class="jump-block" id="zoom-navbar-indicadores">		
					<div class="jump-block-inner-toolbar">
						<ul>
							<li>
								<a href="javascript:void(0);" title="Acercar" 
								class="button"
								id="btn-zoom-in-${pos}">
									<i class="fa fa-plus"></i>
								</a>
							</li>	
							<li>								
								<a href="javascript:void(0);" title="Alejar" 
								class="button"
								id="btn-zoom-out-${pos}">
									<i class="fa fa-minus"></i>
								</a>  
							</li> 

						</ul>						
					</div>		
				</div>
				`
				$('#indicador-inner-'+pos).append(zoom);
				$('#btn-zoom-in-'+pos).on('click', function(){
					indMap.getView().setZoom(indMap.getView().getZoom() + 1);
				})
				$('#btn-zoom-out-'+pos).on('click', function(){
					indMap.getView().setZoom(indMap.getView().getZoom() - 1);
				})
				//$('#indicador-col-pos-'+pos).parent().css('min-height', '300px')

				break;
	
			
			case "table":
			console.log('grafico_id:'+js.grafico_id+'| grafico_tipo_id:'+js.grafico_tipo_id)
			var table = document.createElement("table");
				table.className = "indicadores-table";
				
			var headRow = document.createElement("tr");
			
			for (var i=0; i<js.columns.length; i++) {
				
				var td = document.createElement("th");
					td.innerHTML = js.columns[i];
			
					headRow.appendChild(td);
				
			}
			
			table.appendChild(headRow);
			
			for (var i=0; i<js.data.length; i++) {
				
				var tr = document.createElement("tr");
				
				for (var j=0; j<js.data[i].length; j++) {
					
					var td = document.createElement("td");
						td.innerHTML = js.data[i][j];
						
					tr.appendChild(td);
					
				}
				
				table.appendChild(tr);
				
			}
			
			$("#indicador-inner-"+pos).empty();
			document.getElementById("indicador-inner-"+pos).appendChild(table);
			
			var fichaIcon = document.createElement("a");
				fichaIcon.className = "indicador-icono-ficha";
				fichaIcon.href = "javascript:void(0);";
				fichaIcon.style.right = "50px";
				fichaIcon.onclick = function() {
					
					var req = $.ajax({
				
						async:false,
						data:{
							ind_id:ind_id,
							pos:pos
						},
						type:"POST",
						url:"./php/get-stats-table-csv-indicador.php",
						success:function(d){}
						
					});
					
					var blob = new Blob([req.responseText], { type: 'text/csv;charset=utf-8;' });
					var filename = "webexport.csv";
					if (navigator.msSaveBlob) { // IE 10+
						navigator.msSaveBlob(blob, filename);
					} else {
						var link = document.createElement("a");
						if (link.download !== undefined) { // feature detection
							// Browsers that support HTML5 download attribute
							var url = URL.createObjectURL(blob);
							link.setAttribute("href", url);
							link.setAttribute("download", filename);
							link.style.visibility = 'hidden';
							document.body.appendChild(link);
							link.click();
							document.body.removeChild(link);
						}
					}					
					
				}.bind(this);
				
			var fichaImg = document.createElement("img");
				fichaImg.src = "./images/ficha-icono-descarga.png";
				$(fichaImg).css('marginRight', '20px')
				
			fichaIcon.appendChild(fichaImg);
			
			document.getElementById("indicador-col-pos-"+pos).appendChild(fichaIcon);


			
		
			$('#indicador-col-pos-'+pos).parent().css('min-heigh', '350px')

			$( document ).ready(function() { //Modifica su tamaño una vez cargada la pagina
							
				let buscadorTabla = $('#indicador-col-pos-'+pos).parent().siblings('.resource-col').children('.resource-inner').find('table').length;
				let buscadorMapa = $('#indicador-col-pos-'+pos).parent().siblings('.resource-col').children('.resource-inner').find('canvas').length;
				let buscadorSvg = $('#indicador-col-pos-'+pos).parent().siblings('.resource-col').children('.resource-inner').find('svg').length;
				let buscadorGrNum = $('#indicador-col-pos-'+pos).parent().siblings('.resource-col').children('.resource-inner').find('h3').length;
				console.log(buscadorGrNum)
				if(buscadorTabla == 1 && buscadorSvg == 0 && buscadorGrNum == 0){
					//Si tiene un hermano que es otra tabla
					$('#indicador-col-pos-'+pos).parent().css('min-height', '330px')

				}else{
					if(buscadorMapa == 1){
						//Busca que no tenga un elemento tipo Layer como hermano
					}else{
						if(($('#indicador-col-pos-'+pos).parent().siblings('.resource-col').children('.resource-inner').find('div').length == 0)){
							//Busca que no tenga un elemento vacio como hermano
						}else{
							$('#indicador-col-pos-'+pos).parent().css('height', '330px')
							let alturaHermano = $('#indicador-col-pos-'+pos).parent().siblings('.resource-col').innerHeight();
							$('#indicador-col-pos-'+pos).parent().css('height', alturaHermano)
						}
					}
				}
			})
			//$('#indicador-col-pos-'+pos).parent()
			$('#indicador-col-pos-'+pos).css('max-height', '500px')			
			
			break;
			
			case "grafico":
			console.log(js)
			console.log('posicion: '+pos)
			console.log('grafico_id:'+js.grafico_id+'| grafico_tipo_id:'+js.grafico_tipo_id)
			$("#indicador-inner-"+pos).empty();
			$("#indicador-inner-"+pos).html(js.type);
			
			eval("draw_grafico_"+js.grafico_tipo_id+"('indicador-inner-"+pos+"',js)");
			
			break;
			
			case "slider":
			console.log('grafico_id:'+js.grafico_id+'| grafico_tipo_id:'+js.grafico_tipo_id)	
			var carouselIndicators = document.createElement("ol");
				carouselIndicators.className = "carousel-indicators";
				
			var carouselSlide = document.createElement("div");
				carouselSlide.id = "carousel-"+pos;
				carouselSlide.className = "carousel slide";
				carouselSlide.setAttribute("data-ride","carousel");
				
			var carouselInner = document.createElement("div");
				carouselInner.className = "carousel-inner";
				
				carouselSlide.appendChild(carouselIndicators);
				carouselSlide.appendChild(carouselInner);
			
			var startClass = "carousel-item active";
			
			for (var i=0; i<js.images.length; i++) {
				
				var carouselIndicatorItem = document.createElement("li");
					carouselIndicatorItem.setAttribute("data-target","#carousel-"+pos);
					carouselIndicatorItem.setAttribute("data-slide-to",i);
				
				var carouselItem = document.createElement("div");
					carouselItem.className = startClass;
					
				var carouselImg = document.createElement("img");
					carouselImg.className = "d-block ml-auto mr-auto";
					carouselImg.setAttribute("src",js.images[i]);
					
					carouselIndicators.appendChild(carouselIndicatorItem);
					carouselItem.appendChild(carouselImg);
					carouselInner.appendChild(carouselItem);
					
				startClass = "carousel-item";
				
			}
			
			var alto = $("#indicador-col-pos-"+pos).height();
			
			document.getElementById("indicador-inner-"+pos).innerHTML = "";
			document.getElementById("indicador-inner-"+pos).style.height = alto - 40 + "px";
			document.getElementById("indicador-inner-"+pos).appendChild(carouselSlide);
			
			$(carouselSlide).carousel({
				interval: 3000,
				full_height:true
			})
				
			$(".carousel").css("height","100%");
			$(".carousel-inner").css("height","100%");
			$(".carousel-item").css("height","100%");
			$(".carousel-item img").attr("height","100%");
			
			break;
			
			case "noresource":	
			$("#indicador-inner-"+pos).parent().empty().css("visibility","hidden");
			break;
			
		}
		
		if (js.type != "noresource") {
			let id_btn = '';
			switch(js.type) {		

				case "layer":
					id_btn = js.ind_btn;
					break;
				case 'grafico':
					id_btn = js.grafico_id;
					break;
				case 'table':
					id_btn = js.ind_btn;
					break;
				case 'slider':
					id_btn = js.recurso_id;
					break;
			}
		
			//Icono targeta
			var fichaIcon = document.createElement("a"); 
				fichaIcon.className = "indicador-icono-ficha";
				fichaIcon.href = "javascript:void(0);";
				fichaIcon.onclick = function() {
					
					jwindow.open("popup-fmetodologica");
					$(".jump-alert-modal").show();
					this.loadFichaMetodologica(ind_id,pos, id_btn, js.type);
					
				}.bind(this);
				
			var fichaImg = document.createElement("img");
				fichaImg.src = "./images/ficha-icono.png";
				
			fichaIcon.appendChild(fichaImg);
			
			document.getElementById("indicador-col-pos-"+pos).appendChild(fichaIcon);	

/* 		//Icono a Mediateca
			// 1) Se crea el elemento que nos redirigirá
			let mediatecaIcon = document.createElement("a");  
				mediatecaIcon.className = "indicador-icono-mediateca"; // Archivo Css = indicadores.css

			// 2) Se crea la imagen y se inserta en "a" que nos redirige
			let mediatecaImg = document.createElement("img");
				mediatecaImg.src = "./images/mediatecaInd.png";
				mediatecaIcon.appendChild(mediatecaImg);

			// 3) Se inserta todo en el elemento según su posición
			document.getElementById("indicador-col-pos-"+pos).appendChild(mediatecaIcon);	 */
		
		}	
		
		if (!notitle) {
			
			$("#indicador-col-pos-"+pos).children().first().before("<p>"+js.ind_titulo+"</p>");
			
		}
		
	}
	
	this.loadFichaMetodologica = function(ind_id,pos, elemento_id, tipo_elemento) {
		
		var req = $.ajax({
			
			async:false,
			url:"./indicadores.get-labels.php",
			type:"post",
			data:{
				ind_id:ind_id,
				pos:pos
			},
			success:function(d){}
			
		});
		var reqBtn = $.ajax({
			
			async:false,
			url:"./Verificacion_Estudio_Indicador.php",
			type:"post",
			data:{
				elemento_id: elemento_id,
				tipo_elemento : tipo_elemento,
			},
			success:function(d){}
			
		});	

		console.log(reqBtn)
		if(reqBtn.status === 200){
			const elementoJson = JSON.parse(reqBtn.responseText)
			console.log(elementoJson.Elemento_Id)
/* 			html = `<form action="./mediateca.php?" method="post" target="_blank">
				<input type="hidden" name="elemento_id" value="${elemento_id}">
				<input type="hidden" name="tipo_elemento" value="${tipo_elemento}">
				<input type="hidden" name="panel_id" value="${ind_id}">
				<button type="submit" id="btnFormMediateca"> 
					<img src="./images/icono-mediateca-br.png" class="tooltipstered" title="VER RECURSO ASOCIADO EN MEDIATECA"> 
				</button>
			</form>
			` */
			html = `
			<a href="./mediateca.php?mode=15&mode_id=${elementoJson.Elemento_Id}&tipo_elemento=${elementoJson.Tipo_Elemento}" target="_blank">
				<img src="./images/icono-mediateca-br.png" class="tooltipstered" title="VER RECURSO ASOCIADO EN MEDIATECA"> 
			</a>
			`
			
/* 			<a href="./mediateca.php?elemento_id=${elemento_id}&tipo_elemento=${tipo_elemento}&panel_id=${ind_id}&solapa=2" target="_blank">
			<img src="./images/icono-mediateca-br.png" class="tooltipstered" title="VER RECURSO ASOCIADO EN MEDIATECA">
			</a> */

			$('#btnMediateca').removeClass('d-none')
			$('#btnMediateca').html(html)
		}else{
			console.log('no lo estoy')
			$('#btnMediateca').addClass('d-none')
		}

		
		var js = JSON.parse(req.responseText);
		
		document.getElementById("ficha-metodologica-titulo-reborn").innerHTML = js.titulo;
		document.getElementById("ficha-metodologica-desc").innerHTML = js.desc;
		document.getElementById("ficha-metodologica-view").href = js.ficha_metodo_path;
		document.getElementById("ficha-metodologica-download").href = js.ficha_metodo_path;
		
	}
	
	
	this.startSearch = function() {
		
		$("#panel-seach-input-layers").val("");
		
		$("#panel-seach-input-layers").bind("focus",function() {
			
			$(this).parent().animate({
				
				"background-color":"#31cbfd"
				
			},"fast");
			
		});
		
		$("#panel-seach-input-layers").bind("blur",function() {
			
			$(this).parent().animate({
				
				"background-color":"#4c4b4b"
				
			},"fast");
			
		});
		
		$("#panel-seach-input-layers").bind("keyup",function(e) {
			
			if ($("#panel-seach-input-layers").val().trim() == "") {
				
				$("#nav-panel").hide();
				
			}else{
				
				if (e.which == 13) {
					
					this.searchInLayers($("panel-seach-input-layers").val());				
					$("#nav-panel").css("display","flex");
					
				}
				
			}
			
		}.bind(this));
		
	}
	
	this.searchInLayers = function(pattern) {
		
		$("#panel-busqueda-geovisor").css("display","flex");
		$("#panel-busqueda-geovisor .panel-header").html("Resultados de Búsqueda");
		
		var req = $.ajax({
			
			async:false,
			url:"./php/get-indicadores-search.php",
			type:"post",
			data:{
				pattern:pattern
			},
			success:function(d){}
			
		});		
		
		$("#panel-busqueda-geovisor .panel-body").html(req.responseText);
		
		scroll.refresh();
		
	}
	
	
	this.share = function() {
		
		/* $("#input-share").val("https://observatorio.ieasa.com.ar/indicadores.php?ind_id="+this.current_ind+"&t="+this.current_title+"&cid="+this.current_cid); */
		$("#input-share").val("https://observatorio.energia-argentina.com.ar/indicadores.php?ind_id="+this.current_ind+"&t="+this.current_title+"&cid="+this.current_cid);
		
		$(".popup").not("#popup-busqueda").hide();
		jwindow.open("popup-share");
		
	}
	
	
	this.print = function() {
		
		$("#template-wrapper").children().show();
		
		var oldHeight = $("#template-wrapper").height();
		var newHeight = $("#template-wrapper").children(".template-indicador-container").height();
		
		$("#template-wrapper").css("height",newHeight+"px");
		window.scrollTo(0,0);		
		
		html2canvas(document.querySelector("#template-wrapper")).then(canvas => {
						
			var a = document.createElement('a');
			// toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
			a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
			a.download = 'captura.jpg';
			
			document.body.appendChild(a);
			
			a.click();
			
			$(a).remove();
			
			//$("#print-legend-wrapper").hide();
			
			$("#template-wrapper").css("height",oldHeight+"px");
		
			$("#titulo-indicador-"+this.current_ind).hide();
			
		});
		
	}
		
}
