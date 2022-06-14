<html>
<head>
<title>SldLib Test</title>
<script src= './js/sldlib.js'></script>

<script>

 function init()
 {
	 s = new sldlib();
	 
	 //s.set_geometria(_POINT_);
	 //s.set_geometria(_POLYGON_);
	 s.set_geometria(_POLYGON_);
	 
	 s.set_fill_color('#33c048');
	 s.set_border_color('#232323');
	 s.set_border_size(1);
	 s.set_size(8.3444);
	 s.set_simbolo('circle');
	 s.set_titulo('arqueo_ec_areas');
	 
	 //alert(s.sld_get());
	 //encode for wms sld_body
	 
	 var domparser = new DOMParser();
	 
	 a = domparser.parseFromString(s.sld_get(), 'text/xml');
	 
	
	 
	 /*alert(s.sld_get_encode());*/
	 
	 var s = new XMLSerializer();
    	var str = s.serializeToString(a );
    	
    	alert(str);
    	
    	 alert(encodeURI(str));
	 
 };
 
 </script>


</head>

<body onload='init();' >


</body>





</html>
