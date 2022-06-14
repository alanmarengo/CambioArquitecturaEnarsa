/*
 * SLDLib: Simple generador de estructuras SLD (Styled Layer Descriptor) 
 * Uso
 * <script>
 *
 * function init()
 * {
 *	 s = new sldlib();
 * 
 *	 //s.set_geometria(_POINT_);
 *	 //s.set_geometria(_POLYGON_);
 *	 s.set_geometria(_LINE_);
 *	 
 *	 s.set_fill_color('#F87B5E');
 *	 s.set_border_color('#F85EC8');
 *	 s.set_border_size(4.444444);
 *	 s.set_size(8.3444);
 *	 s.set_simbolo('circle');
 *	 s.set_titulo('test sld');
 *	 
 *	 alert(s.sld_get());
 *	 //encode for wms sld_body
 *	 alert(s.sld_get_encode());
 *	 
 * };
 * 
 * </script>
 */

const _POINT_   =0;
const _LINE_    =1;
const _POLYGON_ =2;

const _HEADER_      = '<?xml version="1.0" encoding="UTF-8"?>';
const _DESCRIPTOR_  = '<StyledLayerDescriptor xmlns="http://www.opengis.net/sld" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:se="http://www.opengis.net/se" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1.0" xmlns:ogc="http://www.opengis.net/ogc" xsi:schemaLocation="http://www.opengis.net/sld http://schemas.opengis.net/sld/1.1.0/StyledLayerDescriptor.xsd">';



function sldlib()
{
        this.tipo_geometria = -1;           /* -1: NO SET, 0: POINT, 1: LINE, 2: POLIGON */
        this.simbolo        = 'circle';     /* WellKnowSimbol */
        this.fill_color     = '#ffffff';    /* Por defecto */
        this.boder_color    = '#ffffff';    /* Por defecto */
        this.boder_size     = 1.0;          /* Por defecto */
        this.titulo         = '';
        this.desc           = '';
        this.layer_name     = '';
        this.size           = 4.0;         /* Por defecto */
        
        this.xhttp = new XMLHttpRequest();
        this.sld_body		= '';
        
        this.clear = function()
        {
            this.tipo_geometria = -1;           /* -1: NO SET, 0: POINT, 1: LINE, 2: POLIGON */
            this.simbolo        = 'circle';     /* WellKnowSimbol */
            this.fill_color     = '#ffffff';    /* Por defecto */
            this.boder_color    = '#ffffff';    /* Por defecto */
            this.boder_size     = 1.0;          /* Por defecto */
            this.titulo         = '';
            this.desc           = '';
            this.size           = 4.0;         /* Por defecto */
            this.layer_name     = '';
        };
        
        this.handle_response =  function()
        {
			if (this.xhttp.readyState == 4 && this.xhttp.status == 200) 
				{
					this.sld_body = this.xhttp.responseText;
				};
		};
        
        this.sld_get = function(_layer_id)
        {
         var header = '';
         var url	= '';
          
         this.sld_body = '';
        
         header += 'layer_name='	+this.titulo;
         header += '&main_color='	+this.fill_color; //.replace("#", "");
         header += '&size='			+this.size;
         header += '&type_geom='	+this.tipo_geometria;
         header += '&border_color='	+this.boder_color; //.replace("#", "");
         header += '&border_size='	+this.boder_size;
         header += '&layer_id='		+_layer_id;
           
         header = encodeURI(header);
         
		 this.xhttp.onreadystatechange = function() 
		 {
				this.handle_response();
		 }.bind(this);
		 
		 url = "./sld/sld.php?"+header;  //alert(url);
			
		 this.xhttp.open("GET", url, false);//esperar
		 this.xhttp.send();
          
          return this.sld_body;          
        };
        
        this.sld_get_intervalos = function(id_capa_creada)
        {
         var header = '';
         var url	= '';
          
         this.sld_body = '';
        
         header = 'id='+id_capa_creada;
        
         header = encodeURI(header);
         
		 this.xhttp.onreadystatechange = function() 
		 {
				this.handle_response();
		 }.bind(this);
		 
		 url = "./sld/sld_interval.php?"+header;
			
		 this.xhttp.open("POST", url, false);//esperar
		 this.xhttp.send();
          
          return this.sld_body;          
        };
        
        this.sld_get_encode = function()
        {
			return encodeURIComponent(this.sld_get());
		};
        
        this.set_size = function(float_size)
        {
            return this.size = float_size;
        };
        
        this.set_border_size = function(float_size)
        {
            return this.boder_size = float_size;
        };
        
        this.set_fill_color = function(hex_color)
        {
            return this.fill_color = hex_color;
        };
        
        this.set_border_color = function(hex_color)
        {
            return this.boder_color = hex_color;
        };
        
        this.set_simbolo = function(str_simbolo)
        {
          return this.simbolo = str_simbolo;
        };
        
        this.set_titulo =  function(str_titulo)
        {
           return this.titulo = str_titulo;
        };
        
        this.set_geometria = function(int_geometria)
        {
          return this.tipo_geometria = int_geometria;  
        };
      
};
