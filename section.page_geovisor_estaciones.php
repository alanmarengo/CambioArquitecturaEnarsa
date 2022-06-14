<link rel="stylesheet" type="text/css" href="./css/page_template.css" />

<!--<div id="page_proyecto" class="page page_template h100p">-->
    <div class="row h100p">
                
        <!---------------------------------------------->
        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 section-b h100p p0">     
		
            <div style="border: solid 1px #666; margin: 0; height:100%; width: 100%;">
				
				<div class="col col-xs-11 col-sm-11 col-md-3 col-lg-3" style="margin:20px 30px; position:absolute; z-index:999; text-align: left; padding: 0px; height:0px;">
                    <div class="jump-window-body p20">
        
                        <div id="filter-estaciones" class="jump-scrollble">
                    
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-tipo-1" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.openstreets);">
                                <div class="state">
                                    <label>Estaciones hidrométricas</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-tipo-2" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.opentopo);">
                                <div class="state">
                                    <label>Estaciones meteorológicas</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-tipo-3" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_roads);">
                                <div class="state">
                                    <label>Estaciones hidrometeorológicas</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-tipo-4" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
                                <div class="state">
                                    <label>Estaciones hidroambientales</label>
                                </div>
                            </div>
                            
                            <br>
                        
                        </div>
                        
                    </div>
                    <div id="uxCapa" class="jump-scroll">
                        <!--<option value="">ESCALA DE PECES</option>-->
                    </div>
                </div>

                <div class="col col-xs-11 col-sm-11 col-md-3 col-lg-3" style="margin:20px 30px; position:absolute; z-index:999; text-align: left; padding: 0px; height:0px;">
                    <div class="jump-window-body p20">                    
        
                        <div id="filter-estaciones-area" class="jump-scrollble">
                    
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-1" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.openstreets);">
                                <div class="state">
                                    <label>Cuenca alta</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-2" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.opentopo);">
                                <div class="state">
                                    <label>Cuenca media</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-3" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_roads);">
                                <div class="state">
                                    <label>Estuario</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-4" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
                                <div class="state">
                                    <label>Presa Condor Cliff</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-5" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
                                <div class="state">
                                    <label>Presa La Barrancosa</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-6" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
                                <div class="state">
                                    <label>Embalse Condor Cliff</label>
                                </div>
                            </div>
                            
                            <br>
                        
                            <div class="pretty p-default p-round" style="font-size:20px;">
                                <input type="checkbox" name="estaciones-area-7" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
                                <div class="state">
                                    <label>Embalse La Barrancosa</label>
                                </div>
                            </div>
                            
                            <br>
                        
                        </div>
                        
                    </div>
                    <div id="uxCapa" class="jump-scroll">
                        <!--<option value="">ESCALA DE PECES</option>-->
                    </div>
                </div>

                <div id="map">
				
				
					
                </div>

            </div>
			
        </div>
		
    </div>
<!--</div>-->

<div style="width:200px; bottom:15px; left:10px; font-weight:bolder;" class="jump-posabs">
			
	<a href="./geovisor.php?geovisor=14" target="_blank" class="black-button">
		<span>VER EN GEOVISOR</span>
	</a>

</div>
