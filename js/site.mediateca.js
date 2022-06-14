$(document).ready(function() {
    moment.locale('es');
    var model = {
        apiUrlBase: GlobalApiUrl,
        tab: 0,
        paginas: 0,
        qty0: 0,
        qty1: 0,
        qty2: 0,
        qty3: 0,
        stopLoad: false,
        filters: {
            pagina: 0,
            salto: 20,
            orden: 4,
            searchText: '',
            dateStart: '',
            dateEnd: '',
            dateTemporalidad: 2,
            mode: -1,
            mode_id: 0,
            tipo_elemento: '',
            mode_label: '',
            groups: initFiltersGroups(),
            url_filters_temporal: null
        },
        data: {
            docs: [],
            medias: [],
            techs: [],
            news: []
        },
        ficha: null
    };
 
    init();

    $('.pinned').hcSticky({
        stickTo: '.x0',
        top: 160
    });

    // POP IMAGE
    $('body').on('click', '.preview-pop', function() {
        let media = $(this).data('media');
        let src = $(this).attr('src');
        let html = '';

        if (media == 2) {
            html = `                
                <video width="800" height="450" controls poster="image">
                    <source src="${src}" type="video/mp4" />
                    Tu navegador no soporta reproducir este archivo.
                </video>
            `;
        } else if (media == 3) {
            html = `                
                <video width="800" height="450" controls poster="image">
                    <source src="${src}" type="audio/mpeg" />
                    Tu navegador no soporta reproducir este archivo.
                </video>
            `;
        } else {
            // SI NO SE ESPECIFICA ASUME IMAGEN
            html = `<img src='${src}' class="imgExtendPreview">`;
        }

        $('#preview').html(html);
        $('#previewmodal').modal('show');
        $('#previewmodal').css({
                'position' : 'absolete', 
                'display' : 'flex', 
                'justifyContent' : 'center',
                'alignItems' : 'center',
                'backgroundColor' : 'rgba(0, 0, 0, 0.7)',
                'marginTop' : '0',
                'height' : '100vh',
                'width' : '100vw',
                'padding' : '0px'
            });

        if (media == 2) {
            $('video')[0].play();
        } else if (media == 3) {
            $('video')[0].play();
        } else {
            //
        }

        $('#previewmodal').on('hidden.bs.modal', function() {
            $('video')[0].pause();
        })

        $('#uxPreviewClose').on('click', function() {
            $('video')[0].pause();
            //$('#previewmodal').modal('hide');
        });


    });

    // CHANGE PAGE
    $('body').on('click', '.page-number', function() {
        let pagina = $(this).data('page');
        model.pagina = pagina;
        dataLoad();
        dataRender();
    });

    // REMOVE FILTER
    $('body').on('click', '.filters-clear', function() {
        filtersReset();    
       /*  return; */
    });

    // REMOVE FILTER
    $('body').on('click', '.filters-checked', function() {
        let estudio = $(this).data('estudio');
        let group = $(this).data('group');
        let item = $(this).data('item');
        let urlActual = window.location.href.split("mediateca.php")
        let urlCompleta = urlActual[0]+"mediateca.php"

        if (estudio == -1) {
            model.filters.searchText = '';
            $('#main-search').val('');
            history.pushState(null, "", urlCompleta);
            filtersReset();
        } else if (estudio == -2) {
            model.filters.searchText = '';
            $('#main-search').val('');
            filtersReset();
        } else if (estudio == 1) {
            model.filters.mode = -1;
            model.filters.mode_id = 0;

            model.filters.mode_label = '';
            filtersReset();
        } else {
            model.filters.groups[group].items[item].checked = false;
        }
        if($(this).data('fecha')){
            $('#uxDesde').datepicker('clearDates');
            $('#uxHasta').datepicker('clearDates');
        }

        filtersRender();
        model.pagina = 0;
        dataLoad();
    });
    /*** SEARCH PREVIEW ***/
    let previewSearchRender = false;
    $('#main-search').on('keyup', function(){        
        const contenedor = $('#UxPrevSearch')
        let busqueda = this.value

        
        if(this.value.length > 0){

            let busquedaMinuscula = busqueda.toLowerCase()
            let url = './busqueda-mediateca.php?FiltroMediateca='+busquedaMinuscula;
            $.getJSON(url, function(data){   
                let urlActual = window.location.href.split("mediateca.php")
           
                let htmlResult = '<div class="titulosRel"> Quizas estes buscando: </div>'
                if(data.length > 0){
                    if(previewSearchRender === false){
                        previewSearchRender = true;
        
                    //Html principal del conetenedor
                        let html = `
                            <div class="searPrev-container">
                                <div class="loading-container">
                                    <div class="loading">
                                    </div>
                                    <div class="loading2">
                                    </div>  
                                </div>                       
                            </div>
                            <div class="closeSearchPrev"> Cerrar X </div> 
                            
                        `
                        //FIN de html principal
        
                    // Esto es todo para mostrar los resultados
                        contenedor.hide()
                        contenedor.removeClass('d-none')               
                        contenedor.css('z-index', '999999')
                        contenedor.html(html)
                        contenedor.show('fast')
                        // FIN mostrar los resultados      
        
                    }else{
                        let html = `
                        <div class="searPrev-container">
                            <div class="loading-container">
                                <div class="loading">
                                </div>
                                <div class="loading2">
                                </div>  
                            </div>                      
                        </div>
                        <div class="closeSearchPrev"> Cerrar X </div>                 
                    `
                        contenedor.html(html)
                    } 
                    for(let i=0; data.length > i; i++){
                        htmlResult += `
                            <a href="${urlActual[0]+"mediateca.php?s="+data[i].palabra_clave}" data-titulo="${data[i].titulo}" class="resultSearch"> 
                                    <div class="textPrev col-10"> <p>  ${data[i].alias}        </p> </div>
                            </a>                            
                        `
                    } 
                    $('.closeSearchPrev').click(function(){
                        previewSearchRender = false;
                        contenedor.hide("fast")
                        contenedor.remove(".searPrev-container") 
                    })                 
                }else{
                    /* htmlResult = '<span class="noResult"><i> No se encontraron resultados para: </i>"'+busqueda+'"</span>'; */
                    previewSearchRender = false;
                    contenedor.hide("fast")
                    contenedor.remove(".searPrev-container")  
                }

                $('.searPrev-container').html(htmlResult)

            })



        }else if(this.value.length === 0){
                previewSearchRender = false;
                contenedor.hide("fast")
                contenedor.remove(".searPrev-container")                
        }

        $('.closeSearchPrev').click(function(){
            previewSearchRender = false;
            contenedor.hide("fast")
            contenedor.remove(".searPrev-container") 
        })



    })




    // ADD FILTER
    $('body').on('click', '.filters-group-item', function(e) {
        closeHerramientas()
        let group = $(this).data('group');
        let item = $(this).data('item');
        model.filters.groups[group].items[item].checked = true;
        filtersRender();
        model.pagina = 0;
        dataLoad();
    });

    // GROUP COLLAPSE
    $('body').on('click', '.group-title', function() {
        let index = $(this).data('group');
        let collapsed = $($(this).data('target')).hasClass('show');
        let group = model.filters.groups[index];

        collapseAllGroups();
        group.collapsed = collapsed;
        filtersRender();
    });

    // ORDEN 
/*     $('#uxOrden').on('change', function() {
        model.filters.orden = $('#uxOrden').val();
        dataLoad();
    }); */ 
    // ------->>  ESTE ORDEN QUEDA EN DESUSO EN LA NUEVA MAQUETACION septiembre 2021  <<---------

    // CLICK ON TAB
    $('a[data-tab]').on('click', function(e) {
        setSolapa($(this).data('tab'));

        model.filters.groups[1].visible = false;
        model.filters.groups[2].visible = false;
        model.filters.groups[3].visible = false;
        model.filters.groups[model.tab + 1].visible = true;

        filtersRender();
        model.pagina = 0;
        dataLoad();
    });

    // CLICK EN LINKS DE FICHA
    $('body').on('click', '.estudios-link, .media-preview-link', function(e) {
        e.stopPropagation();
        $('#infoIndicadores').remove()
        let solapa = $(this).data('solapa');
        let mode = $(this).data('mode');
        let mode_id = $(this).data('mode_id');

        setSolapa(solapa);
        model.stopLoad = true;
        model.filters.mode = mode;
        model.filters.mode_id = mode_id;
        model.stopLoad = false;
        model.pagina = 0;

        if($('.media-preview')){
            $('.media-preview').removeClass('show');
        }

        filtersRender();
        dataLoad();
    });

    // CLICK EN DOC PARA POPUP FICHA
    $('body').on('click', '.doc, .tech, .news', function(e) {
        let id = $(this).data('id');
        let origen_id = $(this).data('origen');
        let desdePanel = null
        if($(this).data('element')){
            desdePanel= $(this).data('element');
        }
        fichaLoad(id, origen_id, function() {
            fichaRender();
            $('#uxFicha').modal('show');
        }, desdePanel);
    });

    // CLICK EN MEDIA-PREVIEW
    $('body').on('click', '.media', function(e) {
        let id = $(this).data('id');
        let origen_id = $(this).data('origen');
        let row = $(this).data('row');
        $('.media-preview').removeClass('show');

        $('.media-border-active').toggleClass('media-border-active media-border');
        $(this).find('.media-border').toggleClass('media-border media-border-active');

        fichaLoad(id, origen_id, function() {
            let imagenes = ``;
            $.each(model.ficha.linkimagenes, function(index, value) {
                if (index > 4)
                    return;

                let linkimg = value.recurso_path_url;
                imagenes += `
            <div style="width: 18%; display: inline-block;">
                <div 
                    class="media-extra" 
                    data-link="${linkimg}" 
                    data-target="#uxPreview_${row}" 
                    data-media="1"
                    style="
                        cursor: pointer;
                        width: 100%;
                        height:60px;
                        background-image: url('${linkimg}');
                        background-repeat: no-repeat;
                        background-position: center center;
                        background-size: cover;    
                    "></div>
            </div>
        `
            });
            
            /*  Si el recurso es formato video o audio no tiene preview, se asigna una por defecto  
             *  background-image: url('${model.ficha.linkimagen}');
             * */
            
            preview_media = '';
            console.log('categoria_media:'+model.ficha.categoria_media);
            
            tipos = ['2','3'];//audio o video
            
            if((model.ficha.categoria_media == 2)||(model.ficha.categoria_media == 3))
            {
                preview_media = './images/play.png';
            }
            else
            {
                preview_media = model.ficha.linkimagen;
            };
            
            
            let html = `
        <div class="row">
            <div class="closeMedia"> Cerrar </div>
            <div class="col-sm-6">
                <div class="preview-image preview-pop"
                title="Ver imagen"
                src="${model.ficha.linkimagen}" 
                data-media="${model.ficha.categoria_media}"
                style="
                    width: 100%;
                    height:260px;
                    cursor: pointer;
                    background-image: url('${preview_media}');
                    background-repeat: no-repeat;
                    background-position: center center;
                    background-size: cover;    
                "></div>
            </div>
            <div class="col-sm-6" style="max-height: 220px; overflow-y: auto;">
                <div class="preview-datos">
                    <div class="preview-title">${model.ficha.title}</div>
                    <div class="preview-estudio">${model.ficha.estudio}</div>
                    <div class="preview-autores">Autores: ${model.ficha.autores}</div>
                    <div class="preview-fecha">Fecha: ${model.ficha.fecha}</div>
                    <div class="preview-tema-subtema">Área/Tema: ${model.ficha.tema_subtema}</div>
                    <div class="preview-proyecto">Proyecto: ${model.ficha.proyecto}</div>
                    <div class="preview-imagenes" style="overflow: hide;">
                        ${imagenes}
                    </div>
                    <a class="media-preview-link btn btn-warning btn-xs" data-solapa="1" data-mode="0" data-mode_id="${model.ficha.estudio_id}">Imagenes asociadas</a>
                    </div>
                </div>
        </div>
    `;


            $('#uxPreview_' + row).html(html);

            $('body, html').animate({
                scrollTop: $('#uxPreview_' + row).offset().top - 300
            }, 500);

            $("[title]").tooltipster({
                animation: 'fade',
                delay: 200,
                theme: 'tooltipster-default',
                trigger: 'hover'
            });

            $('.closeMedia').on('click', function(){
                $('.media-preview').removeClass('show');
            })
        });
    });

    $('body').on('click', '.media-extra', function(e) {
        let target = $(this).data('target');
        let linkcss = $(this).css('background-image');
        let link = $(this).data('link');
        let media = $(this).data('media');
        $(target).find('.preview-image').css('background-image', linkcss);
        $(target).find('.preview-image').attr('src', link);
        $(target).find('.preview-image').data('media', media);
    });

    //-----------------------------------------------------
    function init() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('s')) {
            let s = urlParams.get('s');
            model.filters.searchText = s;
            $('#main-search').val(s);
            $('#main-search').focus();
        }
        if (urlParams.has('o')) {
            let o = urlParams.get('o');
            model.filters.orden = o;
            /* $('#uxOrden').selectpicker('val', o); */ //EN DESUSO POR NUEVO MAQUETADO
            let orderOpt = $('.ordenar_option')
            for(let i=0;i < orderOpt.length; i++){
                if($(orderOpt[i]).data('value') == o){
                    $(orderOpt[i]).addClass('active')
                }else{
                    $(orderOpt[i]).removeClass('active')
                }
            }
        }
        /* volver aca */
        if(urlParams.has('proyecto') || urlParams.has('documento') || urlParams.has('tema') || urlParams.has('subtema') || urlParams.has('mod') || urlParams.has('modeid') ){
            model.filters.url_filters_temporal = {}
            //Proyecto
            if (urlParams.has('proyecto')) {
                let p= parseInt(urlParams.get('proyecto'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }          
                model.filters.url_filters_temporal.p = p    
            }
            //Documento
            if (urlParams.has('documento')) {
                let p= parseInt(urlParams.get('documento'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }                
                model.filters.url_filters_temporal.d = p    
            }
            //Tema
            if (urlParams.has('tema')) {
                let p= parseInt(urlParams.get('tema'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }                
                model.filters.url_filters_temporal.t = p    
            }
            //Subtema
            if (urlParams.has('subtema')) {
                let p= parseInt(urlParams.get('subtema'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }                
                model.filters.url_filters_temporal.st = p    
            }
            //mode
            if (urlParams.has('mod')) {
                let p= parseInt(urlParams.get('mod'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }                
                model.filters.url_filters_temporal.mode = p    
            }
            //mode_id
            if (urlParams.has('modeid')) {
                let p= parseInt(urlParams.get('modeid'));   
                if(isNaN(p) || p === null || p === '' || p === undefined){
                    p = ''
                }                
                model.filters.url_filters_temporal.modeid = p    
            }


        }


        if (urlParams.has('solapa')) {
            let n = parseInt(urlParams.get('solapa'));
            setSolapa(n);
        }

        if (urlParams.has('mode')) {
            model.filters.mode = urlParams.get('mode');
        }

        if (urlParams.has('mode_id')) {
            model.filters.mode_id = urlParams.get('mode_id');
        }

        if (urlParams.has('tipo_elemento')) {
            model.filters.tipo_elemento = urlParams.get('tipo_elemento');
        }

        model.filters.groups = initFiltersGroups();
        dataLoad();
    }

    function getQty() {
        // DEVUELVE EL VALOR DEL MODELO DE ACUERDO A LA SOLAPA ACTIVA
        if (model.tab == 0) return model.qty0;
        else if (model.tab == 1) return model.qty1;
        else if (model.tab == 2) return model.qty2;
        else return model.qty3;
    }

    /*     function filtersLoad() {
            model.filters.groups = initFiltersGroups();
            $.getJSON(model.apiUrlBase + '/mediateca_filtros.php', function(data) {
                $.each(data, function(index, value) {
                    let gindex = 0;

                    if (value.filtro_id == 0) gindex = 0; //'Proyecto'
                    else if (value.filtro_id == 1) gindex = 1; //'Área de gestion'
                    else if (value.filtro_id == 5) gindex = 2; //'Recursos Audiovisuales'
                    else if (value.filtro_id == 2) gindex = 3; //'Recursos tecnicos'
                    else if (value.filtro_id == 3) gindex = 4; //'tema'
                    else if (value.filtro_id == 4) gindex = 5; //'subtema'

                    model.filters.groups[gindex].items.push({
                        id: value.valor_id,
                        label: value.valor_desc,
                        checked: false,
                        parentId: value.parent_valor_id,
                        total: value.total
                    });
                });

                filtersRender();
            });
        }
     */
    function filtersMerge(data) {
        $.each(data, function(index, value) {
            let gindex = 0;
            if (value.filtro_id == 0) gindex = 0; //'Proyecto'
            else if (value.filtro_id == 1) gindex = 1; //'Área de gestion'
            else if (value.filtro_id == 5) gindex = 2; //'Recursos Audiovisuales'
            else if (value.filtro_id == 2) gindex = 3; //'Recursos tecnicos'
            else if (value.filtro_id == 3) gindex = 4; //'tema'
            else if (value.filtro_id == 4) gindex = 5; //'subtema'

            let key = `[${gindex}][${value.valor_id}][${value.valor_desc}]`;
            let item = getFilterItemIndex(gindex, key);

            if (item == null) {
                // ITEM NO EXISTE, LO AGREGA
                model.filters.groups[gindex].items.push({
                    key: key,
                    id: value.valor_id,
                    label: value.valor_desc,
                    checked: false,
                    parentId: value.parent_valor_id,
                    total: value.total
                });
            } else {
                // ITEM SI EXISTE, SOLO ACTUALIZA TOTALES
                item.total = value.total;
            }
        });

        filtersRender();
    }

    //##########################
    function getFilterItemIndex(group, key) {
        let qty = model.filters.groups[group].items.length;
        for (var i = 0; i < qty; i++) {
            let value = model.filters.groups[group].items[i];
            if (value.key == key) {
                return model.filters.groups[group].items[i];
            }
        }

        return null;
    }
    let desdeIndicador = false;
    function dataLoad() {
        if (model.stopLoad)
            return;

        // VALIDACION FECHAS CARGADAS
        if (model.filters.dateStart == '' && model.filters.dateEnd != '')
            return;
        if (model.filters.dateStart != '' && model.filters.dateEnd == '')
            return;


        let desdePanel = false
        let panel_id = ''   
        if($('#infoIndicadores').length > 0) {
            desdePanel = true
            const elemento_id = $('#infoIndicadores').data('elemento_id')
            const tipo_elemento = $('#infoIndicadores').data('tipo_elemento')
            panel_id = $('#infoIndicadores').data('panel_id')
           
            var url = model.apiUrlBase + '/mediateca_find_pag.php?'+'elemento_id='+elemento_id+'&tipo_elemento='+tipo_elemento+'&panel_id='+panel_id 
            model.tab = 0
            setSolapa(2)

        }else{          
            var url = model.apiUrlBase + '/mediateca_find_pag.php?' + makeUrlFilter();
        }
        console.log(url);

        let checkedFilter = false
        if(url.indexOf("&cheackearFiltros=true") > -1){
            checkedFilter = true
        }

        

        // BLOCK UI
        HoldOn.open({ theme: "sk-rect" });

        $.getJSON(url, function(data) {
            HoldOn.close();
            if (data == null) {
                return;
            }

            filtersMerge(data.filtros);
            model.tab = data.solapa;
            model.paginas = data.paginas;
            model.pagina = data.pagina;
            model.salto = data.rec_per_page;
            model.qty0 = data.registros_total_0;
            model.qty1 = data.registros_total_1;
            model.qty2 = data.registros_total_2;
            model.qty3 = data.registros_total_3;
            model.filters.mode_label = data.mode_label;
            model.data.docs = [];
            model.data.medias = [];
            model.data.techs = [];
            model.data.news = [];
            $.each(data.recordset, function(index, value) {  
                /* console.log(value)  */             
                let origenID = value.origen_id
                let autores = value.Autores
                let descripcion = value.Descripcion
                if(origenID === 6){
                    desdeIndicador = true;
                    origenID = 3
                    autores = ''
                    descripcion = ''
                }else{
                    desdeIndicador = false;
                }
                let idInd = '';
                let valEstudios = '';
                let panelesIndicadores = '';
                let estudioDoc = '';
                if(desdePanel == true){
                    idInd = panel_id;
                    valEstudios = value.estudios[0].Estudio_ID
                    panelesIndicadores = value.paneles
                }else{
                    idInd = value.Id;
                    valEstudios = value.estudios_id
                }                    
                if (value.Solapa == 0) {
                    model.data.docs.push({
                        id: value.Id,
                        origen_id: origenID,
                        link_preview: model.apiUrlBase + '/mediateca_preview.php?r=' + value.Id + '&origen_id=' + origenID,
                        title: value.Titulo,
                        autores: value.Autores,
                        description: value.Descripcion,
                        estudio: value.estudios_id,
                        ico: value.ico,
                        estudios: value.estudios,
                        fecha: value.fecha
                    });
                } else if (value.Solapa == 1) {
                    model.data.medias.push({
                        id: value.Id,
                        origen_id: origenID,
                        link_preview: model.apiUrlBase + '/mediateca_preview.php?r=' + value.Id + '&origen_id=' + origenID,
                        link: value.LinkImagen,
                        title: value.Titulo,
                        estudio: value.estudios_id,
                        tema: value.tema,
                        autores: value.Autores,
                        fecha: value.Fecha
                    });
                } else if (value.Solapa == 2) {
                    model.data.techs.push({                       
                        /* id: value.Id */
                        id: idInd,
                        origen_id: origenID,
                        link_preview: model.apiUrlBase + '/mediateca_preview.php?r=' + idInd + '&origen_id=' + origenID,
                        title: value.Titulo,
                        autores: autores,
                        description: descripcion,
                        estudio: valEstudios,
                        ico: value.ico,
                        estudios: value.estudios,
                        panelesIndicadores: panelesIndicadores,
                        desdeIndicador : desdeIndicador,
                        fecha: value.fecha
                    });
                } else if (value.Solapa == 3) {
                    model.data.news.push({
                        id: value.Id,
                        origen_id: origenID,
                        link_preview: model.apiUrlBase + '/mediateca_preview.php?r=' + value.Id + '&origen_id=' + origenID,
                        title: value.Titulo,
                        fecha: value.fecha,
                        description: value.Descripcion,
                        estudio: value.estudios_id,
                        ico: value.ico
                    });
                }
            });
            closeHerramientas()
            console.log(model)
            dataRender();

        
        if(checkedFilter === true){
            function checkURLfiltros(){
                var urlParams = new URLSearchParams(window.location.search);
                //Proyecto
                if (urlParams.has('proyecto')) {
                    let p = parseInt(urlParams.get('proyecto'));
                
                    $.each(model.filters.groups[0].items, function (iindex, item) {
                        if (item.id == p) {
                            model.filters.groups[0].items[iindex].checked = true
                        }
                    });
                }
                //Documento
                if (urlParams.has('documento')) {
                    let d = parseInt(urlParams.get('documento'));
                
                    $.each(model.filters.groups[1].items, function (iindex, item) {
                        if (item.id == d) {
                            model.filters.groups[1].items[iindex].checked = true
                        }
                    });
                }
                //Tema
                if (urlParams.has('tema')) {
                    let d = parseInt(urlParams.get('tema'));
                
                    $.each(model.filters.groups[4].items, function (iindex, item) {
                        if (item.id == d) {
                            model.filters.groups[4].items[iindex].checked = true
                        }
                    });
                }
                //SubTema
                if (urlParams.has('subtema')) {
                    let d = parseInt(urlParams.get('subtema'));
                
                    $.each(model.filters.groups[5].items, function (iindex, item) {
                        if (item.id == d) {
                            model.filters.groups[5].items[iindex].checked = true
                        }
                    });
                }
                //Mode
                if (urlParams.has('mod')) {
                    let d = parseInt(urlParams.get('mode'));
                    

                }
                //Mode_id
                if (urlParams.has('modeid')) {
                    let d = parseInt(urlParams.get('modeid'));
                    

                }

                model.filters.url_filters_temporal = null
                checkedsRender()            
            }
            checkURLfiltros()
        }




        });
    }

    function fichaLoad(id, origen_id, callbackRender, element) {
            let qs = {
                id: id,
                origen_id: origen_id
            };
            let url = model.apiUrlBase + '/mediateca_ficha.php?' + jQuery.param(qs);
            
            $.getJSON(url, function(data) {
                let title = data.titulo
                if(element != null){
                    title = 'Panel vinculado: <br><h4>'+ data.titulo+'</h4>';
                }else{
                    title = data.titulo
                }
                model.ficha = {
                    id: data.id,
                    link_preview: model.apiUrlBase + '/mediateca_preview.php?r=' + data.id + '&origen_id=' + data.origen_id,
                    origen_id: data.origen_id,
                    title: title,
                    temporal: data.temporal,
                    autores: data.autores,
                    description: data.descripcion,
                    estudio: data.estudio,
                    linkimagen: data.linkdescarga,
                    linkvisor: data.linkvisor,
                    linkdescarga: data.linkdescarga,
                    fecha: data.fecha,
                    tema_subtema: data.tema_subtema,
                    proyecto: data.proyecto,
                    estudio_id: data.estudio_id,
                    linkimagenes: data.linkimagenes,
                    categoria_media: data.categoria_media
                };

                callbackRender();
            });
        
    }

    function setSolapa(solapa) {
        $(`a[data-tab="${model.tab}"]`).removeClass('active');
        $(`a[data-tab="${model.tab}"]`).parent().removeClass('nav-item-active');
        model.tab = solapa;
        $(`a[data-tab="${model.tab}"]`).addClass('active');
        $(`a[data-tab="${model.tab}"]`).parent().addClass('nav-item-active');
    }

    function filtersReset() {
        model.filters.searchText = '';
        model.filters.mode = -1;
        model.filters.mode_id = 0;
        model.filters.mode_label = '';

        uncheckAllGroups();
        
        $('#uxSearchText').val('');
        console.log($('#uxDesde').val())
        if($('#uxDesde').val()){
            $('#uxDesde').datepicker('clearDates');
            $('#uxHasta').datepicker('clearDates');
        }else{
            dataLoad()
        }

        /* dataLoad() */
        /* uncheckAllGroups(); */
        
    }

    function dataRender() {
        if (model.tab == 0) {
            docsRender();
        } else if (model.tab == 1)
            mediasRender();
        else if (model.tab == 2)
            techsRender();
        else if (model.tab == 3)
            newsRender();

        $('#uxQtyDocs').html(`(${model.qty0})`);
        $('#uxQtyMedias').html(`(${model.qty1})`);
        $('#uxQtyTechs').html(`(${model.qty2})`);
        $('#uxQtyNews').html(`(${model.qty3})`);

        checkedsRender();
        pagerRender('#uxPager1');
        pagerRender('#uxPager2');

        $('.pinned').hcSticky('refresh');

        $("[title]").tooltipster({
            animation: 'fade',
            delay: 200,
            theme: 'tooltipster-default',
            trigger: 'hover'
        });
    }

    function clearPage() {
        model.pagina == 0;
    }

    function pagerRender(qs) {
        let html = '';

        if (getQty() <= model.filters.salto) {
            $(qs).html('');
            $(qs).hide();
            return;
        }

        let rango = 8;
        let min = 0;
        let max = rango - 1;

        html = `
    <div class="row pager">
        <div class="pager-numbers">
`;

        html += `
    <a href="#" class="page-number" data-page="0">
        <i class="fa fa-angle-double-left"></i>            
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
        <i class="fa fa-angle-double-right"></i>            
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
    

    function filtersRender() {
        let html = '';
        html += `<div class="accordion" id="uxFilters" class="pinned">`;
        $.each(model.filters.groups, function(gindex, group) {
            if (group.visible) {
                html += `
            <div class="card">
                <div class="card-header" id="group-${gindex}-header">
                    <button 
                        id="group-${gindex}-title" 
                        class="group-title btn btn-link" type="button" 
                        data-target="#group-${gindex}-body" 
                        data-group="${gindex}"
                        >
                    </button>
                </div>

                <div id="group-${gindex}-body" class="collapse ${group.collapsed ? '' : 'show'}"
                    data-parent="#uxFilters">
                    <div data-simplebar class="card-body group-container-items">
                        <ul class="list-group">
        `;

                $.each(group.items, function(iindex, item) {
                    if (!item.checked && item.total > 0) {
                        html += `
                <button type="button" class="filters-group-item list-group-item list-group-item-action" 
                    data-group="${gindex}" 
                    data-item="${iindex}">${item.label} <span>(${item.total})</span></button>
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
        <div class="card-header" id="group-hasta-header">
            <button class="btn btn-link temporalidadFilter" id="temporalidadFilter" data-active=false>
                <div id="contenedorBTN"> 
                    <div class="filter-title">                        
                        Temporalidad                        
                    </div>    
                    <i class="fa fa-plus-circle"></i> 
                    <i class="fa fa-minus-circle d-none"></i>               
                </div>
            </button>
        </div>
    
        <div class="temporalidad-container d-none"> 

            <div class="row nowrap">
                <div class="col-md-4" id="asdDesde">
                    Periodo:
                </div>
                <div class="col-md-8 text-right">
                    <select class="selectPeriodo" id="periodoTemp">
                        <option value=2> Fecha documento </option>
                        <option value=1> Fecha publicacion </option>
                        <option value=0> Fecha ejecucion de estudio </option>
                    </select>
                </div>
            </div>
            <div class="row nowrap">
                <div class="col-md-4" id="asdDesde">
                    Desde:
                </div>
                <div class="col-md-8 text-right">
                    <input id="uxDesde" value="${model.filters.dateStart}" type="text" class="date" style='border: none; width: 100px;'>
                    <span id="uxDesdeIcon" style="cursor: pointer;"><i class="fa fa-calendar"></i></span>
                </div>
            </div>

            <div class="row nowrap">
                <div class="col-md-4">
                    Hasta:
                </div>
                <div class="col-md-8 text-right">
                    <input id="uxHasta" value="${model.filters.dateEnd}" type="text" class="date" style='border: none; width: 100px;'>
                    <span id="uxHastaIcon" style="cursor: pointer;"><i class="fa fa-calendar"></i></span>
                </div>
            </div> 

        </div>

    </div>
`

        html += `</div>`;
        $('#uxFilters-box').html(html);

        $('#temporalidadFilter').on('click', function(){
            let tempActivado = $(this).data('active')
            if(tempActivado == false){
                $(this).data('active', true)
                $('.temporalidad-container').removeClass('d-none')
                $('#contenedorBTN').children('.fa-plus-circle').addClass('d-none')
                $('#contenedorBTN').children('.fa-minus-circle').removeClass('d-none')
            }else if(tempActivado == true){
                $(this).data('active', false)
                $('.temporalidad-container').addClass('d-none')
                $('#contenedorBTN').children('.fa-plus-circle').removeClass('d-none')
                $('#contenedorBTN').children('.fa-minus-circle').addClass('d-none')
            }
        })

        groupsTitleRender();

        // BIND EVENTS DATE PICKER
        $('.date').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            clearBtn: true,
            todayHighlight:true,
            toggleActive: true
        });

        $('#uxDesdeIcon').on('click', function() {
            $('#uxDesde').focus();
            $('#uxDesde').datepicker('show');
        });

        $('#uxHastaIcon').on('click', function() {
            $('#uxHasta').focus();
            $('#uxHasta').datepicker('show');
        });

        $('#uxDesde').on('changeDate', function(e) {
            let d = moment($('#uxDesde').val(), 'DD/MM/YYYY');
            let h = moment($('#uxHasta').val(), 'DD/MM/YYYY');

            if (d.isValid() && h.isValid() && d > h) {
                alert('La fecha desde no puede ser superior a la fecha hasta!');
                $('#uxDesde').val('');
                return;
            }else{
                let d2 = $('#uxDesde').val();
                let h2 = $('#uxHasta').val();
                if(d2 !== '' & h2 !== ''){ 
                    closeHerramientas()            
                }
            }

            model.filters.dateStart = $('#uxDesde').val();
            dataLoad();
        });

        $('#uxHasta').on('changeDate', function(e) {
            let d = moment($('#uxDesde').val(), 'DD/MM/YYYY');
            let h = moment($('#uxHasta').val(), 'DD/MM/YYYY');

            if (d.isValid() && h.isValid() && h < d) {
                alert('La fecha hasta no puede ser inferior a la fecha desde!');
                $('#uxHasta').val('');
                return;
            }else{
                let d2 = $('#uxDesde').val();
                let h2 = $('#uxHasta').val();
                if(d2 !== '' & h2 !== ''){ 
                    closeHerramientas()            
                }
            }

            model.filters.dateEnd = $('#uxHasta').val();
            dataLoad();
        });
        $('#periodoTemp').on('change', function(e) {   
            let d = $('#uxDesde').val();
            let h = $('#uxHasta').val();
            model.filters.dateTemporalidad = this.value
            
            if(d !== '' & h !== ''){ 
                closeHerramientas()            
                dataLoad();
            }

        });
    }

    function checkedsRender() {
        $('#uxFiltersChecked').html('');


        if (model.filters.searchText) {
            let nombre = '';
            let title = model.filters.searchText;

            if (title.length > 20) {
                nombre = title.substr(0, 20) + '...';
            } else {
                nombre = title;
            }
            $('#uxFiltersChecked').append(`
            <div class="btn btn-warning btn-xs btn-filtros">
                <div class="text-filter" data-text="${title}">
                   <b class="mr-1"> Busqueda: </b> ${nombre}
                </div>
                <a class="filters-checked"
                data-estudio="-1">                     
                    <i class="fa fa-times" style="padding-right: 6px;"></i>
                </a>
            </div>
            `)
        }

        // FECHAS
        if (model.filters.dateStart != '') {
            $('#uxFiltersChecked').append(`
        
                <div class="btn btn-warning btn-xs btn-filtros">
                    <div class="text-filter" data-text="Fecha: ${model.filters.dateStart} - ${model.filters.dateEnd}">
                    <b class="mr-1"> Fecha: </b> ${model.filters.dateStart} - ${model.filters.dateEnd}
                    </div>
                    <a class="filters-checked"
                    data-estudio="-2" data-fecha=true>                     
                        <i class="fa fa-times" style="padding-right: 6px;"></i>
                    </a>
                </div>
            `)
        }

        if (model.filters.mode_label) {
            let nombre = '';
            let title = model.filters.mode_label;

            if (title.length > 20) {
                nombre = title.substr(0, 20) + '...';
            } else {
                nombre = title;
            }

            $('#uxFiltersChecked').append(`
            <div class="btn btn-warning btn-xs btn-filtros">
                <div class="text-filter" data-text="${title}">
                    <b class="mr-1"> Estudio: </b> ${nombre}
                </div>
                <a class="filters-checked" data-estudio="1"> 
                    <i class="fa fa-times"></i>
                </a>
            </div>
    `)

}

$.each(model.filters.groups, function (gindex, group) {
    $.each(group.items, function (iindex, item) {
        if (item.checked) {
            let nombre = '';
            let title = `${item.label} (${item.total})`;

            if (title.length > 25) {
                nombre = title.substr(0, 25) + '...';
            } else {
                nombre = title;
            }

            $('#uxFiltersChecked').append(`
            <div class="btn btn-warning btn-xs btn-filtros">
                <div class="text-filter" data-text="${title}">
                    <b class="mr-1"> Filtro: </b> ${nombre}
                </div>
                <a class="filters-checked" data-group="${gindex}" data-item="${iindex}">
                    <i class="fa fa-times"></i>                
                </a>
            </div>
            `)
        }
    });
});

// RESET FILTROS, TODOS
if ($('#uxFiltersChecked').html()) {
    $('#uxFiltersChecked').append(`
        <a class="filters-clear btn btn-danger btn-xs" style="color: #fff;"> Limpiar filtros </a>
    `)
    
}

$('.text-filter').on('click', function(){
    const checkChild = $('#uxFiltersChecked').children('.tooltip-text').length
    const dataAmostrar = $(this).data('text')

    const quitarTooltip = () =>{
        $('.tooltip-text').hide(200)
        setTimeout(function(){
            $('.tooltip-text').remove()
        },200)        
    }

    if(checkChild === 0){
        $('#uxFiltersChecked').append(`<div class="tooltip-text" onclick=quitarTooltip()>${dataAmostrar}</div>`)
        $('.tooltip-text').hide()
        $('.tooltip-text').show('fast')
    }else{
        const dataActual = $('.tooltip-text').html()
        if(dataActual === dataAmostrar){
            quitarTooltip()
        }else{
            quitarTooltip()
            setTimeout(function(){
                $('#uxFiltersChecked').append(`<div class="tooltip-text" onclick=quitarTooltip()>${dataAmostrar}</div>`)
                $('.tooltip-text').hide()
                $('.tooltip-text').show('fast')
            },210)
        }
    }

    $('.tooltip-text').on('click', function(){
        quitarTooltip()
    })

})


}

function fichaRender() {

    //Esta ficha se renderiza cuando viene de un elemento de indicadores
if($('#infoIndicadores').length > 0) {

    let title = model.data.techs[0].title
    if(model.data.techs[0].title.includes('- Estudio:')){
        let titleDiv = model.ficha.title.split('- Estudio:')
        title = titleDiv[0];
    }    

    let htmlLinkVisor = '';
    let cantidadPaneles = model.data.techs[0].panelesIndicadores.length;
    if (cantidadPaneles > 0){
        if(cantidadPaneles > 1){

            let optionEstudios = ''    
            $.each(model.data.techs[0].panelesIndicadores, function (index, panel) {
                    optionEstudios += `<option value=${panel.Panel_ID} data-title="${panel.Titulo}"> ${panel.Titulo}</option>`        
            })
    
    
            selects =`
                <select class="form-select-sm custom-select select-estudios" id="select-panel" style="width: 80%;">
                    <option selected disabled> Seleccione un panel... </option>
                    ${optionEstudios}
                </select>
            `;
            htmlLinkVisor = `
            <div class="ficha-description">
            <b style="color:grey"> Paneles: </b> <br> ${selects} 
            </div>
            <a href=""
             target="_blank" class="btn btn-xs btn-ficha-color disabled" id="btn-visual">
             Abrir</a>`;
             //${model.apiUrlBase}/indicadores.php?ind_id=${model.data.techs[0].panelesIndicadores[0].Panel_ID}&t=${model.data.techs[0].panelesIndicadores[0].Titulo}

        }else{
            htmlLinkVisor = `
            <div class="ficha-description">
            <p><b style="color:grey"> Panel: </b>  ${model.data.techs[0].panelesIndicadores[0].Titulo} 
            </p>
            <a href="${model.apiUrlBase}/indicadores.php?ind_id=${model.data.techs[0].panelesIndicadores[0].Panel_ID}&t=${model.data.techs[0].panelesIndicadores[0].Titulo}"
             target="_blank" class="btn btn-xs btn-ficha-color">
             Abrir</a> </div>`;
        }

    }
        

    let htmlLinkDescarga = '';
    if (model.ficha.linkdescarga != '' && model.ficha.linkdescarga != model.ficha.linkvisor)
        htmlLinkDescarga = `<a href="${model.ficha.linkdescarga}" target="_blank" class="btn btn-xs btn-warning">Descargar</a>`;

        let html = '';
        html += `
            <div class="row">
                <div class="col-md-4">
                    <div class="ficha-preview">
                        <img src="${model.ficha.link_preview}" class="pop" />
                    </div>
                </div>
                <div class="col-md-8"> 
                
                    <div class="ficha-title">${title}</div>
                    <div class="ficha-description">${model.data.techs[0].description}</div>
                    ${htmlLinkVisor}
                </div>
            </div>
        `;
        $('#uxFicha .modal-body').html(html);

        $('#select-panel').on('change', function(e){ 
            
            let Panel_ID = $(this).find("option:selected").val()
            let Panel_TITLE = $(this).find("option:selected").data('title')

            $('#btn-visual').removeClass('disabled')
            $('#btn-visual').attr('href',`${model.apiUrlBase}/indicadores.php?ind_id=${Panel_ID}&t=${Panel_TITLE}`)

        })
}else{ //FIN de elemento de indicadores
//ESTO PASA CUANDO ES UNA FICHA NORMAL
    let title = model.ficha.title
    if(model.ficha.title.includes('- Estudio:')){
        let titleDiv = model.ficha.title.split('- Estudio:')
        title = titleDiv[0];
    }

    let htmlLinkVisor = '';
    if (model.ficha.linkvisor != '')
        htmlLinkVisor = `<a href="${model.ficha.linkvisor}" target="_blank" class="btn btn-xs btn-ficha-color">Abrir</a>`;

    let htmlLinkDescarga = '';
    if (model.ficha.linkdescarga != '' && model.ficha.linkdescarga != model.ficha.linkvisor)
        htmlLinkDescarga = `<a href="${model.ficha.linkdescarga}" target="_blank" class="btn btn-xs btn-ficha-color">Descargar</a>`;

    let html = '';
    html += `
        <div class="container-ficha-data">
            <div class="col-12 content-data">
                <div class="ficha-title">${title}</div>
                <div class="ficha-description">${model.ficha.description}</div>
            </div>
            <div class="col-12 content-preview">
                <div class="ficha-preview">
                    <img src="${model.ficha.link_preview}" class="pop" />
                </div>
                <div class="ficha-info-extra"> 
                    <div class="ficha-temporal">${model.ficha.temporal ? '<u>Fecha:</u> '+model.ficha.temporal : ''}</div>
                    <div class="ficha-autores">${model.ficha.autores ? '<u>Autor:</u> '+model.ficha.autores : ''}</div>
                </div>
            </div>
            <div class="ficha-links">
                ${htmlLinkVisor}
                ${htmlLinkDescarga}
            </div>
        </div>
    `;
    $('#uxFicha .modal-body').html(html);

    }
}

function docsRender() {

let html = '';
let tituloTmp = ''
$.each(model.data.docs, function (index, doc) {

    let selects = ''
    let links = '';
    let title = doc.title
    if(title.includes('- Estudio:')){
        let titleDiv = doc.title.split('- Estudio:')
        title = titleDiv[0];
    }
if(doc.estudios.length > 1){

        let optionEstudios = ''    
        $.each(doc.estudios, function (index, estudio) {
                optionEstudios += `<option value=${estudio.Estudio_ID}> ${estudio.Estudio}</option>`        
        })


        selects =`
            <select class="form-select-sm custom-select select-estudios select-stop-propagation" id="select-estudios${doc.id}" data-id="${doc.id}" style="width: 80%;">
                <option selected disabled> Seleccione un estudio... </option>
                ${optionEstudios}
            </select>
        `;

        links = `
            <div class="doc-links">
                <div class="content-v2">
                    <div class="container-btn-real">
                        <div class="content-select">
                            ${selects}
                        </div>
                        <a data-solapa="1" data-mode="0" data-mode_id="${doc.estudio}" class="btn btn-dark text-white estudios-link links-modal${doc.id}" title="Fotos, videos, imágenes">
                            RECURSOS AUDIOVISUALES <span> Fotos, videos, imágenes </span>
                        </a>
                        <a data-solapa="2" data-mode="0" data-mode_id="${doc.estudio}" class="btn btn-dark text-white estudios-link links-modal${doc.id}" title="Capas geográficas, indicadores, planos">
                            RECURSOS TÉCNICOS <span> Capas geográficas, indicadores, planos </span>
                        </a>
                        <a data-solapa="0" data-mode="1" data-mode_id="${doc.estudio}" class="btn btn-dark text-white estudios-link links-modal${doc.id}" title="Informes y estudios relacionados">
                            RECURSOS ASOCIADOS <span> Informes y estudios relacionados </span>
                        </a>
                    </div>
                    <div class="img-content">
                        <img src="./images/mediateca-filter-plus.svg">
                    </div>
                    <div class="img-content-mobile">
                        <img src="./images/mediateca-filter-plus.svg">
                    </div>
                </div>
            </div>
    `;

    html += `
        <div id="ficha">
            <div class="doc-fecha">
                ${doc.fecha != null ? '<i class="fas fa-calendar"></i>'+doc.fecha : ''}     
            </div>
            <div class="doc" data-id="${doc.id}" data-origen="${doc.origen_id}">
                <div class="col-preview">
                    <div class="doc-preview">
                        <img src="${doc.link_preview}" />
                    </div>
                </div>
                <div class="col-info">
                    <div class="doc-title">
                        <div class="doc-title-icon">
                            <img src="${doc.ico}" />
                        </div>
                        <div class="doc-title-text">
                            ${title}
                        </div>
                    </div>
                    <div class="doc-autores">${doc.autores}</div>
                    <div class="doc-description">${doc.description}</div>
                </div>
            </div>
                ${links}
            </div>
        </div>
        `;
 }else{
    links = `
        <div class="container-btn">
            <div class="content-v2">
                <div class="container-btn-real">
                    <a data-solapa="1" data-mode="0" data-mode_id="${doc.estudio}" class="btn btn-dark estudios-link links-modal${doc.id}" title="Fotos, videos, imágenes">
                        RECURSOS AUDIOVISUALES <span> Fotos, videos, imágenes </span>
                    </a>
                    <a data-solapa="2" data-mode="0" data-mode_id="${doc.estudio}" class="btn btn-dark estudios-link links-modal${doc.id}" title="Capas geográficas, indicadores, planos">
                        RECURSOS TÉCNICOS <span> Capas geográficas, indicadores, planos </span>
                    </a>
                    <a data-solapa="0" data-mode="1" data-mode_id="${doc.estudio}" class="btn btn-dark estudios-link links-modal${doc.id}" title="Informes y estudios relacionados">
                        RECURSOS ASOCIADOS <span> Informes y estudios relacionados </span>
                    </a>                    
                </div>
                <div class="img-content">
                    <img src="./images/mediateca-filter-plus.svg">
                </div>
                <div class="img-content-mobile">
                    <img src="./images/mediateca-filter-plus.svg">
                </div>
            </div>
        </div>
            
    `;
    html += `
    <div id="ficha">
        <div class="doc-fecha">
            ${doc.fecha != null ? '<i class="fas fa-calendar"></i> '+doc.fecha : ''}             
        </div>
        <div class="doc" data-id="${doc.id}" data-origen="${doc.origen_id}">
            <div class="col-preview">
                <div class="doc-preview">
                    <img src="${doc.link_preview}" />
                </div>
            </div>
            <div class="col-info">
                <div class="doc-title">
                    <div class="doc-title-icon">
                        <img src="${doc.ico}" />
                    </div>
                    <div class="doc-title-text">
                        ${title}
                    </div>
                </div>
                <div class="doc-autores">${doc.autores}</div>
                <div class="doc-description">${doc.description}</div>
                <div class="doc-links"> 
                    ${links}
                </div>
            </div>
        </div>
    </div>
    `;
    }   
    


});

if (html == '') {
    html = '<h2 class="sin-resultados">No se encontraron resultados con los filtros seleccionados</h2>'
}

$('#uxData').html(html);

//CHANGE DEL SELECT DEL ESTUDIO EN MODAL
$('.select-estudios').on('change', function() {
    let docEstudio = $(this).val()
    let dataId = $(this).data('id')

    if(docEstudio > 0){
        $('.links-modal'+dataId).removeClass('disabled')
        $('.links-modal'+dataId).attr('data-mode_id', docEstudio)
    }else{
        $('.links-modal'+dataId).addClass('disabled')
    }
    
});
$('.select-stop-propagation').on('click', function(e){
    e.stopPropagation();
})

}//FIN DE FUNCION DOCS

function mediasRender() {
let html = '';
html += `<div class="container">`;
html += `<div class="row">`;

let row = 0;
let col = 0;
$.each(model.data.medias, function (index, item) {
    let i = `
        <div class="media col-sm-2" data-toggle="collapse" href="#uxPreview_${row}" data-id="${item.id}" data-origen="${item.origen_id}" data-row="${row}">
            <div class="media-border">
                <div class="media-img" style="background-image: url('${item.link_preview}');">
                </div>
                <div class="media-info">
                    ${item.title.substr(0, 40)}<br />
                    ${item.tema.substr(0, 40)}<br />
                </div>
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

if (row == 0 && col == 0) {
    html = '<h2 class="sin-resultados">No se encontraron resultados con los filtros seleccionados</h2>'
}

$('#uxData').html(html);
}

function techsRender() {
    
let html = '';
let tituloTmp = ''
$.each(model.data.techs, function (index, doc) {

    let selects = '';
    let links = '';
    let title = doc.title


    if(doc.estudios.length > 1){

        if(title !== tituloTmp){
            tituloTmp = title
            console.log(tituloTmp)
            let optionEstudios = ''    
            $.each(doc.estudios, function (index, estudio) {
                    optionEstudios += `<option value=${estudio.Estudio_ID}> ${estudio.Estudio}</option>`    
            })

            selects = `                    
                <select class="form-select-sm custom-select select-estudios select-stop-propagation" id="select-estudios${doc.id}" data-id="${doc.id}">
                    <option selected disabled> Seleccione un estudio... </option>
                    ${optionEstudios}
                </select>
            `
            links = `
                        <div class="doc-links">
                            <div class="container-btn">
                                <div class="content-v2">
                                    <div class="container-btn-real">
                                        <div class="content-select">
                                            ${selects}
                                        </div>
                                        <a data-solapa="0" data-mode="0" data-mode_id="${doc.estudio}" class="disabled btn btn-dark text-white estudios-link links-modal${doc.id}" title="Informes y documentos relacionados">
                                            DOCUMENTOS ASOCIADOS <span> Informes y documentos relacionados </span>
                                        </a>
                                        <a data-solapa="2" data-mode="1" data-mode_id="${doc.estudio}" class="disabled btn btn-dark text-white estudios-link links-modal${doc.id}" title="Informes y estudios relacionados">
                                            RECURSOS ASOCIADOS <span> Informes y estudios relacionados </span>
                                        </a>
                                    </div>
                                    <div class="img-content">
                                        <img src="./images/mediateca-filter-plus.svg">
                                    </div>
                                    <div class="img-content-mobile">
                                        <img src="./images/mediateca-filter-plus.svg">
                                    </div>
                                </div>
                            </div>
                        </div>                    

            `;
            html += `
            <div id="ficha">
                <div class="doc-fecha">
                    ${doc.fecha != null ? '<i class="fas fa-calendar"></i>'+doc.fecha : ''} 
                </div>
                <div class="doc" data-id="${doc.id}" data-origen="${doc.origen_id}" data-element="${doc.desdeIndicador}">
                    <div class="col-preview">
                        <div class="doc-preview">
                            <img src="${doc.link_preview}" />
                        </div>
                    </div>
                    <div class="col-info">
                        <div class="doc-title">
                            <div class="doc-title-icon"> 
                                <img src="${doc.ico}" /> 
                            </div>
                            <div class="doc-title-text"> 
                                ${title}  
                            </div>
                        </div>             
                        <div class="doc-autores">${doc.autores == null ? '' : doc.autores}</div>
                        <div class="doc-description">${doc.description}</div>
                            ${links}
                    </div>
                </div>
            </div>
            `;   
        }
}else{
    if (doc.estudio > 0) {
            links = `
            <div class="container-btn"> 
                <div class="content-v2">
                    <div class="container-btn-real">
                        <a data-solapa="0" data-mode="0" data-mode_id="${doc.estudio}" class="mt-1 btn btn-dark estudios-link text-white links-modal${doc.id}" title="Informes y documentos relacionados">
                            DOCUMENTOS ASOCIADOS <span> Informes y documentos relacionados </span>
                        </a>
                        <a data-solapa="2" data-mode="1" data-mode_id="${doc.estudio}" class="mt-1 btn btn-dark text-white estudios-link links-modal${doc.id}" title="Informes y estudios relacionados">
                            RECURSOS ASOCIADOS <span> Informes y estudios relacionados </span>
                        </a>   
                    </div>
                    <div class="img-content">
                        <img src="./images/mediateca-filter-plus.svg">
                    </div>
                    <div class="img-content-mobile">
                        <img src="./images/mediateca-filter-plus.svg">
                    </div>
                </div>         
            </div>

        `;
    }
    
        html += `
        <div id="ficha">
            <div class="doc-fecha">
                ${doc.fecha != null ? '<i class="fas fa-calendar"></i>'+doc.fecha : ''} 
            </div>
            <div class="doc" data-id="${doc.id}" data-origen="${doc.origen_id}" data-element="${doc.desdeIndicador}">
                <div class="col-preview">
                    <div class="doc-preview">
                        <img src="${doc.link_preview}" />
                    </div>
                </div>
                <div class="col-info">
                    <div class="doc-title">
                        <div class="doc-title-icon"> 
                            <img src="${doc.ico}" /> 
                        </div>
                        <div class="doc-title-text"> 
                            ${title}  
                        </div>
                    </div>
                    <div class="doc-autores">${doc.autores == null ? '<br>' : doc.autores}</div>
                    <div class="doc-description">${doc.description}</div>
                    <div class="doc-links">
                        ${links}
                    </div>
                </div>
            </div>
        </div>
        `;
    }

});

if (html == '') {
    html = '<h2 class="sin-resultados">No se encontraron resultados con los filtros seleccionados</h2>'
}

$('#uxData').html(html);

//CHANGE DEL SELECT DEL ESTUDIO EN MODAL
$('.select-estudios').on('change', function() {
    let docEstudio = $(this).val()
    let dataId = $(this).data('id')

    if(docEstudio > 0){
        $('.links-modal'+dataId).removeClass('disabled')
        $('.links-modal'+dataId).attr('data-mode_id', docEstudio)
    }else{
        $('.links-modal'+dataId).addClass('disabled')
    }
    
});
$('.select-stop-propagation').on('click', function(e){
    e.stopPropagation();
})

}

function newsRender() {
let html = '';

$.each(model.data.news, function (index, news) {
    html += `
        <div id="ficha" class="news" data-id="${news.id}" data-origen="${news.origen_id}">
            <div class="doc">
                <div class="col-preview">
                    <div class="doc-preview">
                        <img src="${news.link_preview}" />
                    </div>
                </div>
                <div class="col-info">
                    <div class="doc-title">
                        <div class="doc-title-icon">
                            <img src="${news.ico}" />
                        </div>
                        <div class="doc-title-text">
                            ${news.title}
                        </div>
                    </div>
                    <div class="doc-autores">${moment(news.fecha).format('DD [de] MMMM [de] YYYY')}</div>
                    <div class="doc-description">${news.description}</div>
                </div>
            </div>
        </div>
    `;
});

if (html == '') {
    html = '<h2 class="sin-resultados">No se encontraron resultados con los filtros seleccionados</h2>'
}

$('#uxData').html(html);
}

function uncheckAllGroups() {
$.each(model.filters.groups, function (gindex, group) {
    $.each(group.items, function (iindex, item) {
        item.checked = false;
    });
});
}

function collapseAllGroups() {
$.each(model.filters.groups, function (gindex, group) {
    group.collapsed = true;
});
}

function qtyItemsVisibles(group) {
let qty = 0;
$.each(group.items, function (iindex, item) {
    qty = qty + ((!item.checked && item.total > 0) ? 1 : 0);
});
return qty;
}

function idItemsChecked(group) {
let qs = '';
$.each(group.items, function (iindex, item) {
    if (item.checked) {
        qs += item.id + ',';
    }
});

if (qs != '')
    qs = qs.substr(0, qs.length - 1);

return qs;
}

function groupsTitleRender() {
$.each(model.filters.groups, function (gindex, group) {
    let html = `
        <div class="row nowrap">
            <div class="col-sm-10 col-md-10 filter-title">
                ${group.title} (${qtyItemsVisibles(group)})
            </div>
            <div class="col-sm-2 col-md-2 text-right filter-title btnExtend-filter">
                ${group.collapsed ? '<i class="fa fa-plus-circle"></i>' : '<i class="fa fa-minus-circle"></i>'}
            </div>
        </div>
    `;
    $(`#group-${gindex}-title`).html(html);
});
}

function makeUrlFilter() {
let params = null
if(model.filters.url_filters_temporal != null){
    params = {
        s: model.filters.searchText,
        o: model.filters.orden,
        ds: model.filters.dateStart != '' ? moment(model.filters.dateStart, 'DD/MM/YYYY').format(
            'DD/MM/YYYY') : '',
        de: model.filters.dateEnd != '' ? moment(model.filters.dateEnd, 'DD/MM/YYYY').format(
            'DD/MM/YYYY') : '',
        ft: model.filters.dateTemporalidad,    
        proyecto: model.filters.url_filters_temporal.p,
        documento: model.filters.url_filters_temporal.d,
        tema: model.filters.url_filters_temporal.t,
        subtema: model.filters.url_filters_temporal.st,
        mode: model.filters.url_filters_temporal.mode,
        mode_id: model.filters.url_filters_temporal.modeid,
        solapa: model.tab,
        pagina: model.pagina,
        salto: model.salto,
        cheackearFiltros : true,
        tipo_elemento: "'"+model.filters.tipo_elemento+"'"
    };
}else{
    params = {
        s: model.filters.searchText,
        o: model.filters.orden,
        ds: model.filters.dateStart != '' ? moment(model.filters.dateStart, 'DD/MM/YYYY').format(
            'DD/MM/YYYY') : '',
        de: model.filters.dateEnd != '' ? moment(model.filters.dateEnd, 'DD/MM/YYYY').format(
            'DD/MM/YYYY') : '',
        ft: model.filters.dateTemporalidad,    
        proyecto: idItemsChecked(model.filters.groups[0]),
        documento: idItemsChecked(model.filters.groups[model.tab + 1]),
        tema: idItemsChecked(model.filters.groups[4]),
        subtema: idItemsChecked(model.filters.groups[5]),
        mode: model.filters.mode,
        mode_id: model.filters.mode_id,
        solapa: model.tab,
        pagina: model.pagina,
        salto: model.salto,
        tipo_elemento: "'"+model.filters.tipo_elemento+"'"
    };
}
/* var urlParams = new URLSearchParams(window.location.search); */

return jQuery.param(params);
}

function initFiltersGroups() {
return [{
        title: 'Obra/Proyecto',
        collapsed: false,
        visible: true,
        items: []
    },
    {
        title: '&Aacute;rea de Gestión',
        collapsed: true,
        visible: true,
        items: []
    },
    {
        title: 'Recursos Audiovisuales',
        collapsed: true,
        visible: false,
        items: []
    },
    {
        title: 'Recursos Técnicos',
        collapsed: true,
        visible: false,
        items: []
    },
    {
        title: 'Área Temática',
        collapsed: true,
        visible: true,
        items: []
    },
    {
        title: 'Tema',
        collapsed: true,
        visible: true,
        items: []
    },
];
}

//FUNCIONES NUEVA. PARTE DE NUEVAS INTEGRACIONES DE SEPTIEMBRE 2021

        //BARRA DE HERRAMIENTAS

$('.toolbar-items').children('i').on('click', function(){   
    herramientasMediateca(this)
})
const activarBackground = (metodo, herramienta) => {
    const backgroundFiltro = $('#background-herramientas')
    const backgroundOrden = $('#background_orden')
    const backgroundCompartir = $('#background_compartir')


if(metodo === 'activar'){
    switch(herramienta){
        case 'filtrar':
            backgroundFiltro.hide()    
            backgroundFiltro.removeClass('d-none')
            backgroundFiltro.show('fast')
        case 'ordenar':
            backgroundOrden.hide()    
            backgroundOrden.removeClass('d-none')
            backgroundOrden.show('fast')
        case 'compartir':
            backgroundCompartir.hide()    
            backgroundCompartir.removeClass('d-none')
            backgroundCompartir.show('fast')
    }


}else if(metodo === "desactivar"){

        backgroundFiltro.hide('fast')  
        setTimeout(function(){
            backgroundFiltro.addClass('d-none')
        },100) 
        backgroundOrden.hide('fast')  
        setTimeout(function(){
            backgroundOrden.addClass('d-none')
        },100)   
        backgroundCompartir.hide('fast')  
        setTimeout(function(){
            backgroundCompartir.addClass('d-none')
        },100)       

}

}

const herramientasMediateca = (btn) => {
    const btnHerramientas = $('.toolbar-items').children('i')
    const btnClickeado = $(btn)

    if(btnClickeado.hasClass('active')){
        btnHerramientas.removeClass('active')
    }else{
        btnHerramientas.removeClass('active')
        btnClickeado.addClass('active')
    }
    


    for(let i=0; i < btnHerramientas.length; i++){

        const  btnInfo = $(btnHerramientas[i]).data('btn')

        switch(btnInfo){
            case 'compartir':
                if($('#iconoCompartir').hasClass('active')){    
                    activarBackground('activar', 'compartir')                 
                    $('#compartir_container').hide()    
                    $('#compartir_container').removeClass('d-none')
                    $('#compartir_container').show('fast')
                    $('#compartir_input').val(window.location.href+'&solapa='+model.tab)
                }else{
                    $('#compartir_container').hide('fast')  
                    setTimeout(function(){
                        $('#compartir_container').addClass('d-none')
                    },100)                    
                }

            case 'ordenar':
                if($('#iconoOrdenar').hasClass('active')){   
                    activarBackground('activar', 'ordenar')             
                    $('#ordenar_container').hide()
                    $('#ordenar_container').removeClass('d-none')
                    $('#ordenar_container').show('fast')
                }else{
                    $('#ordenar_container').hide('fast')  
                    setTimeout(function(){
                        $('#ordenar_container').addClass('d-none')
                    },100) 
                }

            case 'filtrar':
                if($('#iconoFiltrar').hasClass('active')){
                    activarBackground('activar', 'filtrar')
                    $('#filtrar_container').hide()
                    $('#filtrar_container').removeClass('d-none')
                    $('#filtrar_container').show('fast')
                }else{
                    setTimeout(function(){
                        $('#filtrar_container').addClass('d-none')
                    },100) 
                }

        }
    }
}
    //ORDENAR OPCIONES 
$('.ordenar_option').on('click',function(){

   $('.ordenar_option').removeClass('active')
   $(this).addClass('active')

   model.filters.orden = $(this).data('value');
   closeHerramientas();
   dataLoad();

})


    //COMPARTIR (BTN DE COPIAR ENLACE)
$('#compartir_btn').on('click', function(){
    let params = {
        proyecto: idItemsChecked(model.filters.groups[0]),
        documento: idItemsChecked(model.filters.groups[model.tab + 1]),
        tema: idItemsChecked(model.filters.groups[4]),
        subtema: idItemsChecked(model.filters.groups[5]),
        s: model.filters.searchText,
        solapa: model.tab,
        mod: model.filters.mode,
        modeid: model.filters.mode_id,
    }
    console.log(jQuery.param(params))
    
    let urlActual = window.location.href.split("mediateca.php")
    let urlCompleta = urlActual[0]+"mediateca.php?"+jQuery.param(params)
    console.log(urlCompleta)

    $('#compartir_input').val(urlCompleta)
    $('#compartir_input').select()
    document.execCommand("copy");  
    $('#compartir_copy_success').hide()
    $('#compartir_copy_success').removeClass('d-none')
    $('#compartir_copy_success').show('fast')
    setTimeout(function(){
        $('#compartir_copy_success').hide('low')
        setTimeout(function(){
            $('#compartir_copy_success').addClass('d-none')
        },100)
    },2000)
})

    //BTN CERRAR
const closeHerramientas = () => {
    const btnHerramientas = $('.toolbar-items').children('i')
    activarBackground('desactivar', 'todos')

    for(let i=0; i < btnHerramientas.length; i++){

        const  btnInfo = $(btnHerramientas[i]).data('btn')
        

        switch(btnInfo){
            case 'compartir':
                    if($('#iconoCompartir').hasClass('active')){
                    $('#compartir_container').hide('fast')
                    setTimeout(function(){
                        $('#compartir_container').addClass('d-none')
                    },100)
                }

            case 'ordenar':
                if($('#iconoOrdenar').hasClass('active')){
                    $('#ordenar_container').hide('fast')
                    setTimeout(function(){
                        $('#ordenar_container').addClass('d-none')
                    },100)
                }

            case 'filtrar':
                if($('#iconoFiltrar').hasClass('active')){
                    $('#filtrar_container').hide('fast')
                    setTimeout(function(){
                        $('#filtrar_container').addClass('d-none')
                    },100)                    
                }

        }
    }   
    btnHerramientas.removeClass('active') 
}
$('.closeBTN').on('click', function(){
    closeHerramientas()
})


$('body').on('click', '.img-content-mobile', function(e) {
    e.stopPropagation();
    if($(this).hasClass('active')){
        $(this).removeClass('active')
        $(this).siblings('.container-btn-real').attr('style','display: none !important;')   
            
    }else{
        $(this).addClass('active')
        $(this).siblings('.container-btn-real').attr('style','display: flex !important;')

        
    }
   
});
$('body').on('click', '.img-content', function(e) {
    e.stopPropagation();   
});

//PARA MOSTRAR EL BOTON PARA SUBIR ARRIBA CUANDO SE HACE SCROLL
$('#page').scroll(function() {

    let footerPosition = $('.footer').position();
    let footerHeight = $('.footer').height();
    let cuentaFooter = footerPosition.top - footerHeight - 300

    if($(this).scrollTop() >= 400 && $('#page').scrollTop() < cuentaFooter) {
        $('#btnUpTop').removeClass('d-none')
        $('#btnUpTop').show('fast')
        $('#btnUpTop').css('display', 'flex')
    }else if($(this).scrollTop() < 400 || $('#page').scrollTop() > cuentaFooter){
        $('#btnUpTop').hide('fast')
        $('#btnUpTop').addClass('d-none')
    }

});

$('#main-search').attr('autocomplete', 'off')
$('.class-input').on('click', function(e){
    e.stopPropagation()
})

});

const quitarTooltip = () =>{
    $('.tooltip-text').hide(200)
    setTimeout(function(){
        $('.tooltip-text').remove()
    },200)        
}
