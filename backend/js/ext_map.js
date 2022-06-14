function map() {		
	
	this.baselayers = {};
	
	this.create = function() {
	
		this.baselayers.google = new ol.layer.Tile({
			name:'google_base',
			visible:true,
			source: new ol.source.TileImage({ 
				url: 'http://mt{0-3}.googleapis.com/vt?&x={x}&y={y}&z={z}&hl=es&gl=AR',
				crossOrigin: 'anonymous'
			})
		})	
		
		this.baselayers.openstreets = new ol.layer.Tile({
			name: 'openstreets',
			title: 'OSM',
			type: 'base',
			visible: false,
			source: new ol.source.XYZ({
				url: '//{a-c}.tile.openstreetmaps.org/{z}/{x}/{y}.png',
				crossOrigin: 'anonymous'
			})
		})	
	
		this.baselayers.argenmap = new ol.layer.Tile({
			name:"capabaseargenmap",
			visible:false,
			source: new ol.source.TileWMS({
				url: "https://wms.ign.gob.ar/geoserver/ows",
				params: {
					'LAYERS': 'capabaseargenmap',
					'VERSION': '1.1.1',
					'FORMAT': 'image/png',
					'TILED': false
				}/*,
				crossOrigin: 'anonymous'*/
			})
		})
		
		this.ol_object = new ol.Map({
			layers:this.baselayers.collection,
			target: 'ext_map',
			extent: [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727],
			controls: [],
			view: new ol.View({
				center: [-7176058.888636417,-4680928.505993671],
				zoom:3.8,
				minZoom: 3.8,
				maxZoom: 21
			})
		});
		
		this.baselayers.collection = [this.baselayers.google,this.baselayers.openstreets,this.baselayers.argenmap];
		
		this.ol_object.addLayer(this.baselayers.google);
		this.ol_object.addLayer(this.baselayers.openstreets);
		this.ol_object.addLayer(this.baselayers.argenmap);
	
	}
	
	this.createFromDataset = function(dt_id) {
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			url:"./php/get-dataset-layers.php",
			data:{dt_id:dt_id},
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		var baseLayerContent = document.createElement("div");
			baseLayerContent.className = "tooltip-white-list";
			
		var ul = document.createElement("ul");
			ul.className = "wms-layer-list";
			
		baseLayerContent.appendChild(ul);
		
		for (var i=0; i<js.layers.length; i++) {
			
			var layer = new ol.layer.Tile({
				visible:true,
				source: new ol.source.TileWMS({
					url: js.layers[i].layer_wms_server,
					params: {
						'LAYERS': js.layers[i].layer_wms_layer,
						'VERSION': '1.1.1',
						'FORMAT': 'image/png',
						'TILED': false
					}
				})
			});
			
			var node_li = document.createElement("li");
			
			var node_layer_check = document.createElement("input");
				node_layer_check.type = "checkbox";
				node_layer_check.layer = layer;
				node_layer_check.checked = true;
				node_layer_check.onclick = function() {
					
					this.layer.setVisible(this.checked);
					
				}
			
			var node_layer_name = document.createElement("span");
				node_layer_name.innerHTML = js.layers[i].layer_wms_layer;
				node_layer_name.className = "ml-5";
				
			node_li.appendChild(node_layer_check);
			node_li.appendChild(node_layer_name);				
				
			ul.appendChild(node_li);
			
			this.ol_object.addLayer(layer);
			
		}
		
		$("#icon-baselayer").tooltipster({
			
			position:"left",
			trigger:"click",
			animation:"grow",
			contentAsHTML:true,
			interactive:true,
			content:baseLayerContent,
			theme:"tooltipster-shadow",
			side:["left","top"],
			zIndex:999
			
		});
		
	}
	
	this.setBaseLayer = function(layerObj) {
		
		for (var i=0; i<this.baselayers.collection.length; i++) {
				
			this.baselayers.collection[i].setVisible(false);
		
		}
		
		layerObj.setVisible(true);
		this.baseLayer = layerObj;
		
	}	
		
}