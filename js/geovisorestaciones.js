$(document).ready(function() {

    $("#zoom-navbar ul li a").tooltipster({
        animation: 'fade',
        delay: 200,
        theme: 'tooltipster-default',
        trigger: 'hover',
        multiple: true,
        position: "left"
    });

    geomap = new ol_map();

    geomap.map.create();
    geomap.map.createLayers();

    geomap.map.ol_object.noBaseLayers = [];

    scroll = new Jump.scroll();

    jwindow = new Jump.window();
    jwindow.initialize();

    $('.section-sticky a').on('click', function() {
        $('.section-sticky a').removeClass('selected');
        $(this).addClass('selected');

        let selector = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 200
        }, 500)
    });

    let target = $.urlParam('target');
    if (target)
        $('#link-' + target).trigger('click');

    $('.section-footer-button2').hover(
        function() {
            let key = $(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno-hover.png")')
        },
        function() {
            let key = $(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno.png")')
        }
    )

    scroll.refresh();

    $(".roverlay").each(function(i, v) { $(v).Roverlay(); });

    $(".filtro-estacion").each(function(i, v) {
        this.checked = "";
        this.checked = false;
    });

    $(".filtro-area-interes").each(function(i, v) {
        this.checked = "";
        this.checked = false;
    });

    /*Highcharts.chart('chart-sample-1', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Total fruit consumption, grouped by gender'
        },

        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            formatter: function() {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });*/


});

function reCalcPopup(idPrefix) {

    let h1 = $("#" + idPrefix + "-inner").children(".header").height();
    let h2 = $("#" + idPrefix + "-inner").children(".tabs").height();
    let h3 = $("#" + idPrefix + "-inner").children(".categories").height();

    let hp = $("#" + idPrefix).height();

    let nh = hp - (h1 + h2 + h3 + 40 /*margin*/ );

    $("#" + idPrefix + "-tab-content").css("height", nh + "px");

}

function get_li(str) {
    let strnew = str.split(",");
    let html = "";
    for (let i = 0; i < strnew.length; i++) {
        html += `<li>${strnew[i]}</li>`;
    }
    return html;
}