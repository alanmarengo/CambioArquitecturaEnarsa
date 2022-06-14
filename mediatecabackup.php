<?php include("./header.php"); ?>

<div class="row" id="page_mediateca">
    <div class="col-md-12 page-title">
        Recursos en Mediateca
    </div>
    <div class="col-md-12 page-search">
        <div class="row">

            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input id="uxSearchText" name="uxSearchText" type="text" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text" id="uxSearchButton">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
                <div id="uxUrl"></div>
            </div>

            <div class="col-md-8 text-right">
                Ordenar por:
                <select id="uxOrden" class="selectpicker">
                    <option value="0">A - Z</option>
                    <option value="1">Z - A</option>
                    <option value="2">Más vistos</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12 page-tabs">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-tab="0" href="#">DOCUMENTOS <span id="uxQtyDocs"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="1" href="#">RECURSOS AUDIOVISUALES <span id="uxQtyMedias"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="2" href="#">RECURSOS TÉCNICOS <span id="uxQtyTechs"></span></a>
            </li>
        </ul>

        <div class="row">
            <div id="x0" class="col-md-3">
                <div class="filters-header">Refina sus resultados</div>
                <div id="uxFilters"></div>
            </div>
            <div class="col-md-9">
                <div id="uxFiltersChecked"></div>
                <div id="uxData"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uxFicha" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("./widget-links.php"); ?>

<script type='text/javascript'>
$(document).ready(function() {
    var model = {
        apiUrlBase: 'http://observatorio.atic.com.ar',
        tab: 0,
        stopLoad: false,
        filters: {
            orden: 0,
            searchText: '',
            dateStart: '',
            dateEnd: '',
            estudio: null,
            groups: initFiltersGroups()
        },
        data: {
            docs: [],
            medias: [],
            techs: [],
        },
        ficha: null
    };

    init();

    // TEXT SEARCH
    $('#uxSearchText').on('focusout', function() {
        refreshSearchText();
    });

    $('#uxSearchText').on('keypress', function(e) {
        if (e.which == 13) {
            refreshSearchText();
        }
    });

    // REMOVE FILTER
    $('body').on('click', '.filters-checked', function() {
        let group = $(this).data('group');
        let item = $(this).data('item');
        model.filters.groups[group].items[item].checked = false;
        setEstudio(null);
        filtersRender();
        dataLoad()
    });

    // ADD FILTER
    $('body').on('click', '.filters-group-item', function(e) {
        let group = $(this).data('group');
        let item = $(this).data('item');
        model.filters.groups[group].items[item].checked = true;
        setEstudio(null);
        filtersRender();
        dataLoad()
    });

    // GROUP COLLAPSE
    $('body').on('click', '.group-title', function() {
        let index = $(this).data('group');
        let collapsed = $($(this).data('target')).hasClass('show');
        let group = model.filters.groups[index];

        collapseAllGroups();
        group.collapsed = collapsed;
        groupsTitleRender();
    });

    // ORDEN
    $('#uxOrden').on('change', function() {
        model.filters.orden = $('#uxOrden').val();
        dataLoad()
    });

    // CLICK ON TAB
    $('a[data-tab]').on('click', function(e) {
        setSolapa($(this).data('tab'));

        if (model.tab == 2) {
            model.filters.groups[1].visible = false;
            model.filters.groups[2].visible = true;
        } else {
            model.filters.groups[1].visible = true;
            model.filters.groups[2].visible = false;
        }

        filtersRender();
        dataRender();
    })

    // CLICK EN LINKS DE FICHA
    $('body').on('click', '.estudios-link, .media-preview-link', function(e) {
        model.stopLoad = true;
        setSolapa($(this).data('solapa'));
        setEstudio($(this).data('estudio'));
        model.stopLoad = false;

        if (model.tab == 0)
            model.ra = 1;

        filtersRender();
        dataLoad()
    });

    // CLICK EN DOC PARA POPUP FICHA
    $('body').on('click', '.doc-title, .tech', function(e) {
        let id = $(this).data('id');
        let origen_id = $(this).data('origen');
        fichaLoad(id, origen_id, function() {
            fichaRender();
            $('#uxFicha').modal('show');
        });
    });

    // CLICK EN MEDIA-PREVIEW
    $('body').on('click', '.media', function(e) {
        let id = $(this).data('id');
        let origen_id = $(this).data('origen');
        let row = $(this).data('row');
        $('.media-preview').removeClass('show')

        fichaLoad(id, origen_id, function() {
            let imagenes = ``;
            $.each(model.ficha.linkimagenes, function(index, value) {
                if (index > 4)
                    return;

                //TODO: REEMPLAZAR CUANDO LA DATA ESTE LISTA
                let linkimg = value.recurso_path_url;
                //let linkimg = `./sga/${index}.jpg`;
                imagenes += `
                    <div style="width: 18%; display: inline-block;">
                        <div class="media-extra" data-target="#uxPreview_${row}" style="
                                cursor: pointer;
                                width: 100%;
                                height:60px;
                                background-image: url(${linkimg});
                                background-repeat: no-repeat;
                                background-position: center center;
                                background-size: cover;    
                            "></div>
                    </div>
                `
            });

            let html = `
                <div class="row">
                    <div class="col-sm-6">
                        <div class="preview-image" 
                        style="
                            width: 100%;
                            height:260px;
                            background-image: url(${model.ficha.linkimagen});
                            background-repeat: no-repeat;
                            background-position: center center;
                            background-size: cover;    
                        "></div>
                    </div>
                    <div class="col-sm-6 preview-datos">
                        <div class="preview-title">${model.ficha.title}</div>
                        <div class="preview-estudio">${model.ficha.estudio}</div>
                        <div class="preview-autores">Autores: ${model.ficha.authors}</div>
                        <div class="preview-fecha">Fecha: ${model.ficha.fecha}</div>
                        <div class="preview-tema-subtema">Tema/Subtema: ${model.ficha.tema_subtema}</div>
                        <div class="preview-proyecto">Proyecto: ${model.ficha.proyecto}</div>
                        <div class="preview-imagenes" style="overflow: hide;">
                            ${imagenes}
                        </div>
                        <a class="media-preview-link btn btn-warning btn-xs" data-solapa="1" data-estudio="${model.ficha.estudio_id}">Imagenes asociadas</a>
                    </div>
                </div>
            `
            $('#uxPreview_' + row).html(html);
        });
    });

    $('body').on('click', '.media-extra', function(e) {
        let target = $(this).data('target')
        let link = $(this).css('background-image');
        $(target).find('.preview-image').css('background-image', link);
    });



    //-----------------------------------------------------
    function init() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('s'))
            $('#uxSearchText').val(urlParams.get('s'))

        filtersLoad();
        dataLoad();
    }

    function refreshSearchText() {
        model.filters.searchText = $('#uxSearchText').val();
        setEstudio(null);
        dataLoad();
    }

    function filtersLoad() {
        model.filters.groups = initFiltersGroups();
        $.getJSON(model.apiUrlBase + '/mediateca_filtros.php', function(data) {
            $.each(data, function(index, value) {
                let gindex = value.filtro_id;
                model.filters.groups[gindex].items.push({
                    id: value.valor_id,
                    label: value.valor_desc,
                    checked: false
                });
            });
            filtersRender();
        });
    }

    function dataLoad() {
        if (model.stopLoad)
            return;

        let url = model.apiUrlBase + '/mediateca_find.php?' + makeUrlFilter();
        //TODO: SACAR EN PRODUCCION
        //$('#uxUrl').html(url);

        $.getJSON(url, function(data) {
            model.ra = 0;
            model.data.docs = [];
            model.data.medias = [];
            model.data.techs = [];
            $.each(data, function(index, value) {
                if (value.Solapa == 0) {
                    model.data.docs.push({
                        id: value.Id,
                        origen_id: value.origen_id,
                        title: value.Titulo,
                        authors: value.Autores,
                        description: value.Descripcion,
                        estudio: value.estudios_id
                    });
                } else if (value.Solapa == 1) {


                    let item = {
                        id: value.Id,
                        origen_id: value.origen_id,
                        //TODO: USAR value.LinkImagen
                        link: value.LinkImagen,
                        //link: `./sga/${value.Id}.jpg`,
                        title: value.Titulo,
                        estudio: value.estudios_id
                    };
                    model.data.medias.push(item);

                    //TODO: ELIMINAR PUSH ADICIONALES
                    //model.data.medias.push(item);
                    //model.data.medias.push(item);
                    //model.data.medias.push(item);
                    //model.data.medias.push(item);


                } else if (value.Solapa == 2) {
                    model.data.techs.push({
                        id: value.Id,
                        origen_id: value.origen_id,
                        metatag: value.MetaTag,
                        title: value.Titulo,
                        description: value.Descripcion,
                        estudio: value.estudios_id,
                    });
                }
            });

            dataRender();
        });
    }

    function fichaLoad(id, origen_id, callbackRender) {
        let qs = {
            id: id,
            origen_id: origen_id
        };
        let url = model.apiUrlBase + '/mediateca_ficha.php?' + jQuery.param(qs);
        
        $.getJSON(url, function(data) {
            model.ficha = {
                id: data.id,
                origen_id: data.origen_id,
                title: data.titulo,
                temporal: data.temporal,
                authors: data.autores,
                description: data.descripcion,
                estudio: data.estudio,
            
                //TODO: CAMBIAR CUANDO LO ARREGLE MARTIN, DEBE VENIR EL DATO EN EL JSON
                linkimagen: data.linkdescarga, 
                //linkimagen: `./sga/${data.id}.jpg`,

                linkvisor: data.linkvisor,
                linkdescarga: data.linkdescarga,
                fecha: data.fecha,
                tema_subtema: data.tema_subtema,
                proyecto: data.proyecto,
                estudio_id: data.estudio_id,
                linkimagenes: data.linkimagenes
            };

            callbackRender();
        });
    }

    function setSolapa(solapa) {
        $(`a[data-tab="${model.tab}"]`).removeClass('active');
        model.tab = solapa;
        $(`a[data-tab="${model.tab}"]`).addClass('active');
    }

    function setEstudio(estudio) {
        if (estudio)
            filtersReset();

        model.filters.estudio = estudio;
    }

    function filtersReset() {
        $('#uxSearchText').val('');
        $('#uxDesde').datepicker('clearDates');
        $('#uxHasta').datepicker('clearDates');
        uncheckAllGroups();
    }

    function dataRender() {
        if (model.tab == 0)
            docsRender();
        else if (model.tab == 1)
            mediasRender();
        else if (model.tab == 2)
            techsRender();

        $('#uxQtyDocs').html(`(${model.data.docs.length})`);
        $('#uxQtyMedias').html(`(${model.data.medias.length})`);
        $('#uxQtyTechs').html(`(${model.data.techs.length})`);
    }

    function filtersRender() {
        let html = '';
        html += `<div class="accordion" id="uxFilters">`;
        $.each(model.filters.groups, function(gindex, group) {
            if (group.visible) {
                html += `
                    <div class="card">
                        <div class="card-header" id="group-${gindex}-header">
                            <button id="group-${gindex}-title" class="group-title btn btn-link" type="button" data-toggle="collapse"
                                data-target="#group-${gindex}-body" data-group="${gindex}">
                                ...
                            </button>
                        </div>

                        <div id="group-${gindex}-body" class="collapse ${group.collapsed ? '' : 'show'}"
                            data-parent="#uxFilters">
                            <div data-simplebar class="card-body group-container-items" style="max-height: 14em; overflow-y: auto;">
                                <ul class="list-group">
                `;

                $.each(group.items, function(iindex, item) {
                    if (!item.checked) {
                        html += `
                            <button type="button" class="filters-group-item list-group-item list-group-item-action" 
                                data-group="${gindex}" 
                                data-item="${iindex}">${item.label}</button>
                        `;
                    }
                });

                html += `
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        html += `
            <div class="card">
                <div class="card-header" id="group-desde-header" style="padding: 5px 4px 5px 16px;">
                    <div class="row">
                        <div class="col-md-4">
                            Desde:
                        </div>
                        <div class="col-md-8 text-right">
                            <input id="uxDesde" value="${model.filters.dateStart}" type="text" class="date" style='border: none; width: 100px;'>
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        `

        html += `
            <div class="card">
                <div class="card-header" id="group-hasta-header" style="padding: 5px 4px 5px 16px;">
                    <div class="row">
                        <div class="col-md-4">
                            Hasta:
                        </div>
                        <div class="col-md-8 text-right">
                            <input id="uxHasta" value="${model.filters.dateEnd}" type="text" class="date" style='border: none; width: 100px;'>
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        `
        html += `</div>`;
        $('#uxFilters').html(html);

        groupsTitleRender();
        checkedsRender();

        // BIND EVENTS DATE PICKER
        $('.date').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            clearBtn: true,
            toggleActive: true
        });

        $('#uxDesde').on('changeDate', function(e) {
            model.filters.dateStart = $('#uxDesde').val();
            dataLoad()
        });

        $('#uxHasta').on('changeDate', function(e) {
            model.filters.dateEnd = $('#uxHasta').val();
            dataLoad()
        });
    }

    function checkedsRender() {
        $('#uxFiltersChecked').html('');
        $.each(model.filters.groups, function(gindex, group) {
            $.each(group.items, function(iindex, item) {
                if (item.checked) {
                    $('#uxFiltersChecked').append(`
                        <a class="filters-checked btn btn-warning" data-group="${gindex}" data-item="${iindex}">${item.label} <i class="fa fa-times"></i></a>
                    `)
                }
            });
        });
    }

    function fichaRender() {
        let htmlLinkVisor = '';
        if (model.ficha.linkvisor != '')
            htmlLinkVisor = `<a href="${model.ficha.linkvisor}" target="_blank" class="btn btn-warning">Visualizar</a>`;

        let htmlLinkDescarga = '';
        if (model.ficha.linkdescarga != '')
            htmlLinkDescarga = `<a href="${model.ficha.linkdescarga}" target="_blank" class="btn btn-warning">Descargar</a>`;
        
        let html = '';
        html += `
            <div class="ficha-title">${model.ficha.title}</div>
            <div class="ficha-temporal">${model.ficha.temporal}</div>
            <div class="ficha-estudio">${model.ficha.estudio}</div>
            <div class="ficha-authors">${model.ficha.authors}</div>
            <div class="ficha-description">${model.ficha.description}</div>
            ${htmlLinkVisor}
            ${htmlLinkDescarga}
        `;
        $('#uxFicha .modal-body').html(html);
    }

    function docsRender() {
        let html = '';
        $.each(model.data.docs, function(index, doc) {
            html += `
                <div class="doc">
                    <div class="doc-title" data-id="${doc.id}" data-origen="${doc.origen_id}">
                        <img class="doc-icon" src="./images/icon-pdf-file.png" />
                        ${doc.title}
                    </div>
                    <div class="doc-authors">${doc.authors}</div>
                    <div class="doc-description">${doc.description}</div>
                    <div class="doc-links">
                        <a data-solapa="1" data-estudio="${doc.estudio}" class="btn btn-dark estudios-link">RECURSOS AUDIOVISUALES</a>
                        <a data-solapa="2" data-estudio="${doc.estudio}" class="btn btn-dark estudios-link">RECURSOS TÉCNICOS</a>
                        <a data-solapa="0" data-estudio="${doc.estudio}" class="btn btn-dark estudios-link">RECURSOS ASOCIADOS</a>
                    </div>
                </div>
            `;
        });
        $('#uxData').html(html);
    }

    function mediasRender() {
        let html = '';
        html += `<div class="container">`;
        html += `<div class="row">`;
        
        let row = 0;
        let col = 0;
        $.each(model.data.medias, function(index, item) {
            let i = `
                <div class="media col-sm-2" data-toggle="collapse" href="#uxPreview_${row}" data-id="${item.id}" data-origen="${item.origen_id}" data-row="${row}" style="display: block;">
                    <div style="
                        height:100px;
                        background-image: url(${item.link});
                        background-repeat: no-repeat;
                        background-position: center center;
                        background-size: cover;    
                        cursor: pointer;                    
                    ">
                    </div>
                    <div style="font-size: .6em; padding: 4px 0px 4px; min-height: 40px;">
                        ${item.title.substr(0, 40)} 
                    </div>
                </div>
            `;
            html += i;

            col++;
            if (col == 6) {
                html += `
                    <div id="uxPreview_${row}" class="collapse col-sm-12 media-preview">
                    </div>
                `;
                row++;
                col = 0;
            }
        });

        html += `
            <div id="uxPreview_${row}" class="collapse col-sm-12 media-preview">
            </div>
        `;
        html += `</div>`;
        html += `</div>`;

        $('#uxData').html(html);
    }

    function techsRender() {
        let html = '';
        $.each(model.data.techs, function(index, item) {
            html += `
                <div class="tech row" data-id="${item.id}" data-origen="${item.origen_id}" style="margin-bottom: 6px; margin-left: 0px; cursor: pointer;">
                    <span class="badge badge-warning" style="color: #fff; font-size: 100%; padding: 8px; margin-right: 6px;">${item.metatag}</span>
                    ${item.title}
                </div>
            `;
        });
        $('#uxData').html(html);
    }

    function uncheckAllGroups() {
        $.each(model.filters.groups, function(gindex, group) {
            $.each(group.items, function(iindex, item) {
                item.checked = false;
            });
        });
    }

    function collapseAllGroups() {
        $.each(model.filters.groups, function(gindex, group) {
            group.collapsed = true;
        });
    }

    function qtyItemsNotChecked(group) {
        let qty = 0;
        $.each(group.items, function(iindex, item) {
            qty = qty + (!item.checked ? 1 : 0);
        });
        return qty;
    }

    function idItemsChecked(group) {
        let qs = '';
        $.each(group.items, function(iindex, item) {
            if (item.checked) {
                qs += item.id + ',';
            }
        });

        if (qs != '')
            qs = qs.substr(0, qs.length - 1);

        return qs;
    }

    function groupsTitleRender() {
        $.each(model.filters.groups, function(gindex, group) {
            let html =
                `${group.title} (${qtyItemsNotChecked(group)}) <i class="fa fa-${group.collapsed ? 'plus' : 'minus'}-circle"></i>`;
            $(`#group-${gindex}-title`).html(html);
        });
    }

    function makeUrlFilter() {
        let params = {
            s: model.filters.searchText,
            o: model.filters.orden,
            ds: model.filters.dateStart != '' ? moment(model.filters.dateStart, 'DD/MM/YYYY').format(
                'DD/MM/YYYY') : '',
            de: model.filters.dateEnd != '' ? moment(model.filters.dateEnd, 'DD/MM/YYYY').format(
                'DD/MM/YYYY') : '',
            proyecto: idItemsChecked(model.filters.groups[0]),
            documento: idItemsChecked(model.filters.groups[model.tab == 0 ? 1 : 2]),
            tema: idItemsChecked(model.filters.groups[3]),
            subtema: idItemsChecked(model.filters.groups[4]),
            estudio_id: model.filters.estudio,
            ra: model.ra
        };

        return jQuery.param(params);
    }

    function initFiltersGroups() {
        return [{
                title: 'Proyecto',
                collapsed: false,
                visible: true,
                items: []
            },
            {
                title: 'Area de Gestión',
                collapsed: true,
                visible: true,
                items: []
            },
            {
                title: 'Recursos técnicos',
                collapsed: true,
                visible: false,
                items: []
            },
            {
                title: 'Tema',
                collapsed: true,
                visible: true,
                items: []
            },
            {
                title: 'Subtema',
                collapsed: true,
                visible: true,
                items: []
            },
        ];
    }
});
</script>

<?php include("./footer.php"); ?>