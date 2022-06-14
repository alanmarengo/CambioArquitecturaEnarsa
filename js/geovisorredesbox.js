$(document).ready(function() {

    //apiUrl = "http://observatorio.atic.com.ar/red_api.php";
    //apiGraficosUrl = "http://observatorio.atic.com.ar/graficos_red/get_graficos.php";
    
    apiUrl = "./red_api.php";
    apiGraficosUrl = "./graficos_red/get_graficos.php";

    updateDatepicker();

    currentTab = 1;

    $(".btn-tab").on("click", function() {

        let tabNum = $(this).attr("data-tab");

        currentTab = tabNum;

        getParametros();
        getEstaciones();

    });

    $("#combo-parametros-redes").on("change", function() {

        getData();

    });

    $("#tab-redes-fdesde").on("change", function() {

        getData();

    });

    $("#tab-redes-fhasta").on("change", function() {

        getData();

    });

    getParametros();
    getEstaciones();

});

function updateDatepicker() {

    var date = new Date();

    var year = date.getFullYear();

    $(".datepicker").val("");

    $(".datepicker").datepicker({
        defaultDate: null,
        format: 'dd/mm/yyyy',
        firstDay: 0,
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        yearRange: (year - 100) + ':' + (year),
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"],
        onSelect: function() {}

    }).datepicker("setDate", new Date());

}

function getParametros() {

    let url = apiUrl + "?tipo_estaciones=" + (currentTab - 1) + "&mode=13";
    let js = this.requestApi(url);
	
	$("#combo-parametros-redes").on("change",()=>{getEstaciones();});

    $("#combo-parametros-redes").empty();

    for (let i = 0; i < js.length; i++) {
        let item = `
            <option value="${js[i].parametro_id}">${js[i].parametro_desc}</option>
        `;

        $("#combo-parametros-redes").append(item);
    }

    getData();

}

function getEstaciones() {

	let param
    //let url = apiUrl + "?tipo_estaciones=" + (currentTab - 1) + "&mode=10";
    let url = apiUrl + "?tipo_estaciones=" + (currentTab - 1) + "&parametro_id=" + $("#combo-parametros-redes").val() + "&mode=15";
    let js = this.requestApi(url);

    $("#estaciones-lista").empty();
    $("#estaciones-lista-seleccionadas").empty();

    for (let i = 0; i < js.length; i++) {
        let item = `
            <div class="switcher-item"  data-estacion-id="${js[i].estacion_id}" onclick="est_select(this);">${js[i].estacion_nombre}</div>
        `;

        $("#estaciones-lista").append(item);
    }

    getData();

}

function est_select(node, estacion_id) {

    if ($("#estaciones-lista-seleccionadas").children(".switcher-item").length < 5) {

        $(node).appendTo("#estaciones-lista-seleccionadas");

        node.onclick = function() {
            est_unselect(this);
        }

    }

    getData();

}

function est_unselect(node, estacion_id) {

    $(node).appendTo("#estaciones-lista");

    node.onclick = function() {
        est_select(this);
    }

    getData();

}

function getData() {

    let lista_estaciones = getEstacionesSeleccionadas();
    let url = apiUrl + "?lista_estaciones=" + lista_estaciones.join(",") + "&parametro_id=" + $("#combo-parametros-redes").val() + "&fd=" + $("#tab-redes-fdesde").val() + "&fh=" + $("#tab-redes-fhasta").val() + "&mode=11";
    let js = this.requestApi(url);
	
	let paramtext = $("#combo-parametros-redes option:selected").text();

    $("#est-tabla-inner").empty();

    let html = `
        <div class="row">
				
            <div class="form-group form-group-header">
                <label>Tabla de valores de ${paramtext}</label>
                <a href="javascript:void(0);" class="linkaux" onclick="getDataCsv();">Descarga de serie de datos</a>
            </div>
                    
        </div>

        <div class="row row-header">

            <div class="col-md-6 col-lg-6 p0">
                <div class="column">
                    <div class="cell header">Estaciones</div>		
                </div>
            </div>

            <div class="col-md-2 col-lg-2 p0">
                <div class="column">
                    <div class="cell header">Valor Mínimo</div>
                </div>
            </div>

            <div class="col-md-2 col-lg-2 p0">
                <div class="column">
                    <div class="cell header">Valor Máximo</div>
                </div>
            </div>

            <div class="col-md-2 col-lg-2 p0">
                <div class="column">
                    <div class="cell header">Promedio</div>
                </div>
            </div>

        </div>
    `;

    let serieMin = [];
    let serieMed = [];
    let serieMax = [];
    let serieEstacion = [];
    let serieEstacionVal = []

    for (let i = 0; i < js.length; i++) {

        //serieEstacion.push(js[i].estacion_nombre);
        serieEstacion[i] = js[i].estacion_nombre;
        serieEstacionVal[i] = [];

        if (js[i].estacion_nombre == "") { js[i].estacion_nombre = "-"; }

        if (js[i].min_dato == "") {
            js[i].min_dato = "-";
            serieMin.push(0);
        } else {
            serieMin.push(parseFloat(js[i].min_dato));
        }

        if (js[i].med_dato == "") {
            js[i].med_dato = "-";
            serieMed.push(0);
        } else {
            serieMed.push(parseFloat(js[i].med_dato));
        }

        if (js[i].max_dato == "") {
            js[i].max_dato = "-";
            serieMax.push(0);
        } else {
            serieMax.push(parseFloat(js[i].max_dato));
        }

        html += `
            <div class="row" data-row-estacion-id="${js.estacion_id}">

                <div class="col-md-6 col-lg-6 p0">
                    <div class="column">
                        <div class="cell">${js[i].estacion_nombre}</div>		
                    </div>
                </div>

                <div class="col-md-2 col-lg-2 p0">
                    <div class="column">
                        <div class="cell">${js[i].min_dato}</div>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2 p0">
                    <div class="column">
                        <div class="cell">${js[i].max_dato}</div>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2 p0">
                    <div class="column">
                        <div class="cell">${js[i].med_dato}</div>
                    </div>
                </div>

            </div>
        `;

    }

    let series = [];
    let xaxis = [paramtext];

    /*for (let i = 0; i < serieEstacion.length; i++) {

        xaxis[i] = serieEstacion[i];

    }*/
	
	console.log(serieEstacion);
	
    series = [{
            name: "Mínimo",
            data: serieMin
        },
        {
            name: "Promedio",
            data: serieMed
        },
        {
            name: "Máximo",
            data: serieMax
        },
    ];

    $("#est-tabla-inner").html(html);

    Highcharts.chart('est-chart-inner', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Gráfico de ' + $("#combo-parametros-redes option:selected").text()
        },

        xAxis: {
            categories: serieEstacion
        },

        yAxis: {
            allowDecimals: true,
            title: {
                text: 'Valores'
            }
        },

        tooltip: {
            formatter: function() {
                return this.series.name + ': ' + this.y + '<br/>';
            }
        },

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        series: series
    });

    console.log(series);

}

function getDataCsv() {

    let lista_estaciones = getEstacionesSeleccionadas();
    let url = "./csv_redes.php?lista_estaciones=" + lista_estaciones + "&parametro_id=" + $("#combo-parametros-redes").val() + "&fd=" + $("#tab-redes-fdesde").val() + "&fh=" + $("#tab-redes-fhasta").val();

    $("#tab-redes-fhasta").val();

    let flink = document.createElement("a");
    flink.target = "_blank";
    flink.href = url;

    document.body.appendChild(flink);

    flink.click();

    $(flink).remove();

    /*let req = $.ajax({
        async: false,
        url: "./csv_redes.php",
        data: {
            lista_estaciones: lista_estaciones.join(","),
            parametro_id: $("#combo-parametros-redes").val(),
            fd: $("#tab-redes-fdesde").val(),
            fh: $("#tab-redes-fhasta").val()
        },
        type: "GET",
        success: function(d) {}
    });*/

    // console.log(req.responseText);

}


function getEstacionesSeleccionadas() {

    let selected = [];

    $("#estaciones-lista-seleccionadas").children(".switcher-item").each(function(i, v) {

        selected.push($(this).attr("data-estacion-id"));

    });

    return selected;

}

function requestApi(url) {

    var req = $.ajax({

        async: false,
        url: url,
        type: "GET",
        success: function(d) {}

    });

    var js = JSON.parse(req.responseText);

    return js;

}
