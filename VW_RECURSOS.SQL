 DROP VIEW mod_indicadores.vw_recursos;
 CREATE VIEW mod_indicadores.vw_recursos AS
 SELECT ind_capa.ind_id,
    ind_capa.layer_id AS resource_id,
    ind_capa.posicion,
    ind_capa.titulo,
    ''::text AS tabla_fuente,
	(SELECT layer_wms_layer FROM mod_geovisores.layer WHERE layer_id = ind_capa.layer_id) AS layer_name,
	(SELECT layer_wms_server FROM mod_geovisores.layer WHERE layer_id = ind_capa.layer_id) AS layer_server,
    'capa'::text AS resource_type
   FROM mod_indicadores.ind_capa
UNION ALL
 SELECT ind_grafico.ind_id,
    ind_grafico.grafico_id AS resource_id,
    ind_grafico.posicion,
    ind_grafico.titulo,
    ''::text AS tabla_fuente,
	''::text AS layer_name,
	''::text AS layer_server,
    'grafico'::text AS resource_type
   FROM mod_indicadores.ind_grafico
UNION ALL
 SELECT ind_recurso.ind_id,
    ind_recurso.recurso_id AS resource_id,
    ind_recurso.posicion,
    ind_recurso.titulo,
    ''::text AS tabla_fuente,
	''::text AS layer_name,
	''::text AS layer_server,
    'recurso'::text AS resource_type
   FROM mod_indicadores.ind_recurso
UNION ALL
 SELECT ind_tabla.ind_id,
    ind_tabla.ind_tabla_id AS resource_id,
    ind_tabla.posicion,
    ind_tabla.titulo,
    ind_tabla.ind_tabla_fuente AS tabla_fuente,
	''::text AS layer_name,
	''::text AS layer_server,
    'tabla'::text AS resource_type
   FROM mod_indicadores.ind_tabla;