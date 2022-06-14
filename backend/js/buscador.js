$(document).ready(function() {
    var model = {
        busqueda: '',
        orden: 0,
        solapa: 1,
        pagina: 0,
        paginas: 0,
        total_registros: 0,
        salto: 10,
        mode: 0,
        mode_id: null,
        recordset: null,
        tooltip: null,
        total_solapa_1: 0,
        total_solapa_2: 0,
        total_solapa_3: 0,
        total_solapa_4: 0,
    };

    initModel();
    loadData();
    renderSolapas();

    //--------------------------------------------------------
    // EVENTOS
    $('#uxOrden').on('change', function() {
        model.orden = $(this).val();
        loadData();
    });

    $('#uxQtyPagina').on('change', function() {
        model.salto = $(this).val();
        model.pagina = 0;
        loadData();
    });

    $('body').on('click', '.page-number', function() {
        model.pagina = $(this).data('page');
        loadData();
    });

    $('body').on('click', '.solapa', function() {
        model.solapa = $(this).data('solapa');
        model.pagina = 0;
        loadData();
    });

    $('body').on('click', '.resultado', function() {
        let index = $(this).data("index");
        let origen = model.recordset[index].origen;
        let href = model.recordset[index].link;
        let temasQty = model.recordset[index].temas.length;

        if (temasQty == 0)
            window.open(href, '_blank');

        if (origen != 'datasets' && origen != 'GIS') {
            window.open(href, '_blank');
        }

        // CUALQUIER OTRA COSA PIDE SUBTEMA
        selectSubTema($(this), index);
    });

    $(document).on('click', function() {
        resetTooltip();
    });

    //--------------------------------------------------------
    // FUNCIONES
    function selectSubTema(el, index) {
        let origen_id = model.recordset[index].origen_id;
        let origen_id_propio = model.recordset[index].origen_id_propio;
        let link = model.recordset[index].link;
        var url = GlobalApiUrl + `/item_subtemas.php?origen_id=${origen_id}&origen_id_propio=${origen_id_propio}`;

        $.getJSON(url, function(data) {
            if (data.length == 0)
                return;

            let html = '';
            html += '<div class="header">Ver en:</div>';
            data.forEach((value, i) => {
                html += `<div class="item"><a target="_blank" href='${link.trim()}${value.subtema_id}'>${value.tema_titulo} / ${value.subtema_titulo}</a></div>`;
            });

            resetTooltip();

            model.tooltip =
                el.tooltip({
                    html: true,
                    title: html,
                    trigger: 'manual',
                    template: `
                    <div class="tooltip2" role="tooltip">
                        <div class="arrow"></div>
                        <div class="tooltip-inner"></div>
                    </div>
                `
                }).tooltip('show');


        });
    }

    function resetTooltip() {
        if (model.tooltip != null)
            model.tooltip.tooltip('dispose');
    }

    function initModel() {
        model.busqueda = getParameterByName('s');
        $('#uxBusquedaTexto').html(model.busqueda);

        let solapa = getParameterByName('solapa');
        if (solapa)
            model.solapa = solapa;
    }

    function pagerRender(qs) {
        let html = '';

        if (model.total_registros <= model.salto) {
            $(qs).html('');
            $(qs).hide();
            return;
        }

        let rango = 8;
        let min = 0;
        let max = rango - 1;

        html = `
            <div class="row pager">
                <div class="col-md-12 pager-numbers">
        `;

        html += `
            <a href="#" class="page-number" data-page="0">
                <i class="fa fa-chevron-left"></i>            
            </a>
        `;

        min = model.pagina - (rango / 2);
        if (min < 0) min = 0;

        max = model.pagina + (rango / 2) + 1;
        if (max > model.paginas) max = model.paginas;

        if (min > 0)
            html += `...`;

        for (let x = min; x < max; x++) {
            html += htmlPagerNumber(x);
        }

        if (max < model.paginas - 1)
            html += `...`;

        html += `
            <a href="#" class="page-number" data-page="${model.paginas - 1}">
                <i class="fa fa-chevron-right"></i>            
            </a>
        `;

        html += `
                </div>
            </div>
        `;

        $(qs).html(html);
        $(qs).show();
    }

    function htmlPagerNumber(pagina) {
        return `
            <a href="#" class="page-number${pagina == model.pagina ? '-active' : ''}" data-page="${pagina}">${pagina + 1}</a>
        `;
    }

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    function loadData() {
        var url = GlobalApiUrl + '/sinia_find.php?' + makeUrlFilter();
        $.getJSON(url, function(data) {
            model.recordset = data.recordset;
            model.paginas = data.total_paginas;
            model.total_registros = data.total_registros;

            model.total_solapa_1 = data.total_solapa_1;
            model.total_solapa_2 = data.total_solapa_2;
            model.total_solapa_3 = data.total_solapa_3;
            model.total_solapa_4 = data.total_solapa_4;

            renderSolapas();
            render();
        });
    }

    function render() {
        let html = '';
        model.recordset.forEach(function(value, index) {
            var etiquetas = '<div class="etiquetas">';
            value.temas.forEach(function(value, index) {
                etiquetas += `
                    <span class="etiqueta" data-tema="${value.tema_id}" data-index="${index}" style="background-color: ${value.tema_colorhex_text}; color: #fff;">
                        ${value.tema_nombre}
                    </span>
                `;
            });
            etiquetas += "</div>";

            var fecha = '';
            if (value.fecha != '') {
                let f = moment(value.fecha, 'YYYY/MM/DD').format('DD.MM.YYYY')
                fecha = f + ' : ';
            }

            html += `
            <div class="row resultado" data-index="${index}">
                <div class="col-md-1 text-center" >
                    <img src="${value.ico_path}" class="icono" />
                </div>
                <div class="col-md-11">
                    <span class="titulo">${value.titulo}</span><br />
                    ${etiquetas}
                    <b style="font-size: .8em;">${value.categoria_interna}</b>
                    <br />
                    ${fecha}${value.descripcion}
                </div>
            </div>
            `;
        });
        $('#uxResultados').html(html);

        $('[data-toggle="tooltip"]').tooltip();

        pagerRender('#uxPager2');
    }

    function renderSolapas() {
        let html = `
            <a class="solapa text-nowrap ${model.solapa == 1 ? 'solapa-activa' : ''}" data-solapa="1">
                Ejes tem&aacute;ticos (${model.total_solapa_1})
            </a>
            <br />
            
            <a class="solapa ${model.solapa == 2 ? 'solapa-activa' : ''}" data-solapa="2">
                Geoinformaci&oacute;n (${model.total_solapa_2})
            </a>
            <br />
            
            <a class="solapa ${model.solapa == 3 ? 'solapa-activa' : ''}" data-solapa="3">
                Recursos (${model.total_solapa_3})
            </a>
            <br />
            
            <a class="solapa ${model.solapa == 4 ? 'solapa-activa' : ''}" data-solapa="4">
                Normativas (${model.total_solapa_4})
            </a>
            <br />
        `;

        $('#uxSolapas').html(html);
    }

    function makeUrlFilter() {
        let params = {
            s: model.busqueda,
            o: model.orden,
            c: model.solapa,
            p: model.pagina,
            j: model.salto,
            mode: model.mode,
            mode_id: model.mode_id,
        };
        return jQuery.param(params);
    }


});
