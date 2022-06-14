$(document).ready(function() {
    var model = {
        tid: null,
        stid: null,
        dsid: null,
        temas: [],
        dataset: null
    };

    init();

    // AGREGADO DE TEMAS
    $('[data-tema]').on('click', function() {
        let id = $(this).data('tema');

        if (!temaExiste(id)) {
            temaAgregar(
                id,
                function(tema) {
                    model.temas.unshift(tema);
                    panelRender();
                    showInfo(0);
                }
            );
        }

        return false;
    });

    $('[href="#uxGrafico"]').on('shown.bs.tab', function(e) {
        if ($('#uxIGrafico').attr('src') == '') {
            showGrafico(0);
        }
    });








    function init() {
        model.tid = $.urlParam('tid');
        if (!model.tid)
            window.location.href = "./datos.php";

        model.stid = $.urlParam('stid');
        model.dsid = $.urlParam('dsid');

        temaAgregar(
            model.tid,
            function(tema) {
                model.temas.unshift(tema);
                panelRender();
                showInfo(0);

                if (model.dsid != 0) {
                    // EL INDEX DEL TEMA SIEMPRE SERA 0
                    // PORQUE LA ACTIVACION AUTOMATICA POR
                    // LINK SIEMPRE QUEDA EN LA POSICION DE 
                    // ARRIBA DE TODO, OSEA INDEX 0
                    $.each(model.temas[0].subtemas, function(sindex, subtema) {
                        if (subtema.id == model.stid) {
                            $.each(model.temas[0].subtemas[sindex].datasets, function(dindex, dataset) {
                                if (dataset.id == model.dsid) {
                                    // APERTURA AUTOMATICA DEL DATASET
                                    datasetLoad(model.dsid, 0, sindex, dindex);
                                }
                            });
                        }
                    });
                }
            }
        );
    }

    function temaExiste(id) {
        let exists = false;
        $.each(model.temas, function(index, value) {
            if (value.id == id) {
                exists = true;
            }
        });
        return exists;
    }

    function temaAgregar(id, callback) {
        temaLoad(id, callback);
        return;
    }

    function temaEliminar(tindex) {
        model.temas.splice(tindex, 1);
    }

    function temaLoad(id, callback) {
        $.ajax({
            dataType: 'json',
            url: GlobalApiUrl + '/get_datasets.php',
            data: {
                tema_id: id,
                mode: 1
            },
            success: function(data) {
                // COLLAPSE DE TODOS LOS TEMAS EXCEPTO QUE COINCIDA
                // CON EL DE LA URL SI ES QUE LO MANDAN
                $.each(data.subtemas, function(index, value) {
                    value.collapsed = model.stid != value.id;
                });
                callback(data);
            }
        });
    }

    function panelRender() {
        let html = '';
        html += `<div class="list-group" style="border: solid 2px #ccc;">`;

        $.each(model.temas, function(tindex, tema) {
            html += `
                <div class="item-tema item-tema-${tema.id} list-group-item list-group-item-action">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="./images/tema${tema.id}over.png" class="icono-tema" />
                        </div>
                        <div class="col" style="padding-left: 0px; text-transform: uppercase;">
                            ${tema.nombre}
                        </div>
                        <div class="col barra-iconos">
                            <a href="#" class="icono tema-buscar" data-tindex="${tindex}">
                                <img src="./images/icono-buscar.png" />
                            </a>
                            <a href="#" class="icono tema-info" data-tindex="${tindex}">
                                <img src="./images/icono-info.png" />
                            </a>
                            <a href="#" class="icono tema-eliminar" data-tindex="${tindex}">
                                <img src="./images/icono-cerrar.png"  />
                            </a>
                        </div>
                    </div>
                </div>
            `;
            $.each(tema.subtemas, function(sindex, subtema) {
                if (subtema.datasets.length == 0)
                    return;

                html += `
                <div class="item-subtema list-group-item list-group-item-action">
                    <div class="row">
                        <div class="col-md-10">
                            ${subtema.nombre}
                        </div>
                        <div class="col-md-2 barra-iconos">
                            <a href="#" class="icono subtema-collapse" data-tindex="${tindex}" data-sindex="${sindex}">
                                <img src="./images/icono-${subtema.collapsed ? 'mas' : 'menos'}.png" style="margin-left: 6px;" />
                            </a>
                        </div>
                    </div>
                </div>
                `;
                if (!subtema.collapsed) {
                    $.each(subtema.datasets, function(dindex, dataset) {
                        html += `
                            <a href="#" class="item-dataset list-group-item list-group-item-action" data-tindex="${tindex}" data-sindex="${sindex}" data-dindex="${dindex}" data-id="${dataset.id}">${dataset.nombre}</a>
                        `;
                    });
                }
            });
        });

        html += `</div>`;

        $('#uxTemas').html(html);

        $(document)
            .off('click', '.tema-info')
            .on('click', '.tema-info', function() {
                let tindex = $(this).data('tindex');
                showInfo(tindex);
            });

        $(document)
            .off('click', '.tema-eliminar')
            .on('click', '.tema-eliminar', function() {
                let tindex = $(this).data('tindex');
                temaEliminar(tindex);

                if (model.temas.length == 0) {
                    window.location.href = "./datos.php";
                } else {
                    panelRender();
                    showInfo(0);
                }
            });

        $(document)
            .off('click', '.subtema-collapse')
            .on('click', '.subtema-collapse', function() {
                let tindex = $(this).data('tindex');
                let sindex = $(this).data('sindex');
                model.temas[tindex].subtemas[sindex].collapsed = !model.temas[tindex].subtemas[sindex].collapsed;
                panelRender();
            });

        $(document)
            .off('click', '.item-dataset')
            .on('click', '.item-dataset', function() {
                let id = $(this).data('id');
                let tindex = $(this).data('tindex');
                let sindex = $(this).data('sindex');
                let dindex = $(this).data('dindex');
                datasetLoad(id, tindex, sindex, dindex);
            });
    }

    function datasetLoad(id, tindex, sindex, dindex) {
        $.ajax({
            dataType: 'json',
            url: GlobalApiUrl + '/get_datasets.php',
            data: {
                dt_id: id,
                mode: 2
            },
            success: function(data) {
                model.dataset = data;
                showDataset(tindex, sindex, dindex);
            }
        });
    }

    function showDataset(tindex, sindex, dindex) {
        $('#uxDataTitulo .tema').html(model.temas[tindex].nombre);
        $('#uxDataTitulo .tema').attr('class', 'tema');
        $('#uxDataTitulo .tema').addClass('tema-' + model.temas[tindex].id);
        $('#uxDataTitulo .subtema').html(model.temas[tindex].subtemas[sindex].nombre);
        $('#uxDataTitulo .dataset').html(model.temas[tindex].subtemas[sindex].datasets[dindex].nombre);

        let dsid = model.temas[tindex].subtemas[sindex].datasets[dindex].id;
        $('#uxTablaDownload').attr('href', './dt_csv.php?dt_id=' + dsid);




        renderTabla(model.dataset.tab_datos);

        $('#uxTabGrafico').html(`GR&Aacute;FICO`);
        $('#uxTabGrafico').attr('class', 'nav-link');
        if (model.dataset.tab_graficos.length == 0) {
            $('#uxTabGrafico').addClass('disabled');
        }

        $('#uxGraficoTipo').selectpicker('destroy');
        let html = '';
        for (let x = 0; x < model.dataset.tab_graficos.length; x++) {
            let value = model.dataset.tab_graficos[x];
            html += `<option value="${value.link}">${value.nombre} - ${value.desc}</option>`;
        }
        $('#uxGraficoTipo').html(html);
        $('#uxGraficoTipo').selectpicker();

        $('#uxGraficoTipo').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            showGrafico(clickedIndex);
        });

        $('#uxTabMapa').html(`MAPA`);
        $('#uxTabMapa').attr('class', 'nav-link');
        if (model.dataset.tab_geovisor.total_Capas == 0) {
            $('#uxTabMapa').addClass('disabled');
        }
        $('#uxIMapa').attr('src', GlobalApiUrl + '/' + model.dataset.tab_geovisor.link);

        $('#uxDataContainer').show();
        $('#uxInfoContainer').hide();

        $('#uxData li:first-child a').tab('show');
        showGrafico(0);

        let titulo = model.temas[tindex].subtemas[sindex].datasets[dindex].nombre;
        let descripcion = '';
        renderMetaDatos(model.dataset.tab_metadatos);

    }

    function renderMetaDatos(data) {
        $('#uxMeta #uxTitulo').html(data.titulo);
        $('#uxMeta #uxDescripcion').html(data.descripcion);
        $('#uxMeta #uxFuente').html(data.fuente);
        $('#uxMeta #uxFecha').html(moment(data.fecha_ultima_act, 'YYYY-MM-DD').format('DD/MM/YYYY'));
        $('#uxMeta #uxDesde').html('Desde: ' + moment(data.fecha_desde, 'YYYY-MM-DD').format('DD/MM/YYYY'));
        $('#uxMeta #uxHasta').html('Hasta: ' + moment(data.fecha_hasta, 'YYYY-MM-DD').format('DD/MM/YYYY'));
        $('#uxMeta #uxImagen').attr('src', data.image);

        let links = data.link_interes.split(' ');
        let html = '';
        for (let i = 0; i < links.length; i++) {
            html += `<a target="_blank" href="${links[i]}">${links[i]}</a><br />`;
        }
        $('#uxMeta #uxLinks').html(html);
    }

    function renderTabla(data) {
        let html = '';

        if (data.columnas.length > 0) {
            html = '<table class="table table-sm table-striped table-hover">';
            html += '<thead><tr>';

            for (let c = 0; c < data.columnas.length; c++) {
                html += `<th>${data.columnas[c]}</th>`;
            }

            html += '</tr></thead><tbody>';

            for (let f = 0; f < data.recordset.length; f++) {
                html += `<tr>`;
                for (let c = 0; c < data.recordset[f].length; c++) {
                    html += `<td>${data.recordset[f][c]}</td>`;
                }
                html += `</tr>`;
            }

            html += '</tbody></table>';
        }

        $('#uxTablaContainer').html(html);

        var myElement = document.getElementById('uxTablaContainer');
        new SimpleBar(myElement, { autoHide: true });

    }

    function showInfo(tindex) {
        if (model.temas.length <= tindex)
            return;

        $('#uxInfo #uxTitulo')
            .html(model.temas[tindex].info.titulo)
            .attr('class', `color-${model.temas[tindex].id}`);

        $('#uxInfo #uxCantidades')
            .attr('class', `color-${model.temas[tindex].id}`);

        $('#uxInfo #uxDescripcion').html(model.temas[tindex].info.descripcion);
        $('#uxInfo img').attr('src', model.temas[tindex].info.imagen);
        $('#uxInfo #uxDatasets').html(model.temas[tindex].info.datasets);
        $('#uxInfo #uxMapas').html(model.temas[tindex].info.mapas);
        $('#uxInfo #uxRecursos').html(model.temas[tindex].info.recursos);

        $('#uxDataContainer').hide();
        $('#uxInfoContainer').show();
    }

    function showGrafico(index) {
        $('#uxIGrafico').attr('src', '');
        if (model.dataset.tab_graficos.length <= index)
            return;

        let url = model.dataset.tab_graficos[index].link;
        $('#uxIGrafico').attr('src', GlobalApiUrl + '/' + url);
    }
});