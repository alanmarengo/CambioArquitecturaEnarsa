<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: pg_query(): Query failed: ERROR:  error de sintaxis en o cerca de «=»
LINE 1: ... = '',territorio_id = '',recurso_preview_path = '' WHERE  = 
                                                                     ^ in C:\wamp64\www\eiasa_backend\fn.grid.php on line <i>169</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0012</td><td bgcolor='#eeeeec' align='right'>410184</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp64\www\eiasa_backend\php\save-recurso.php' bgcolor='#eeeeec'>...\save-recurso.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0021</td><td bgcolor='#eeeeec' align='right'>410928</td><td bgcolor='#eeeeec'>save_item(  )</td><td title='C:\wamp64\www\eiasa_backend\php\save-recurso.php' bgcolor='#eeeeec'>...\save-recurso.php<b>:</b>9</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1182</td><td bgcolor='#eeeeec' align='right'>411776</td><td bgcolor='#eeeeec'><a href='http://www.php.net/function.pg-query' target='_new'>pg_query</a>
(  )</td><td title='C:\wamp64\www\eiasa_backend\fn.grid.php' bgcolor='#eeeeec'>...\fn.grid.php<b>:</b>169</td></tr>
</table></font>
{"status":0,"msg":"Se produjo un error al guardar este elemento"}UPDATE mod_mediateca.recurso SET recurso_id = '5',recurso_categoria_id = '',estudios_id = '',tipo_recurso_id = '',formato_id = '',recurso_titulo = '',recurso_desc = '',recurso_fecha = '',recurso_autores = '',url_recurso = '',tamano_recurso = '',sub_proyecto_id = '',subclase_id = '',cod_temporalidad_id = '',territorio_id = '',recurso_preview_path = '' WHERE  = 