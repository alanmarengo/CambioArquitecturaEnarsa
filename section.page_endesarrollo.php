<link rel="stylesheet" type="text/css" href="./css/page_template.css" />

<div id="page_endesarrollo" class="page page_template" style="width: 100%;">
    <div class="row">
        <div class="col-md-12">
            <div class="leyenda-titulo">
                <?php
                    echo $_GET['q'];
                ?>
            </div>
            <p class="leyenda">
                Estamos trabajando en el desarrollo de esta sección, que estará disponible próximamente.
            </p>
        </div>
    </div>
</div>

<script type='text/javascript'>
$(document).ready(function() {
    $('.section-sticky a').on('click', function() {
        let selector = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 200
        }, 500)
    });

    let target = $.urlParam('target');
    if (target)
        $('#link-' + target).trigger('click');

    $('body').on('click', '#uxCaminito', function(e) {
        //TODO: LOAD DE JSON ARRAY BASADO EN CAMINITO
        $('#uxFicha').modal('show');
    });

    $('.pop-button2').hover( 
        function () {
            let key=$(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno-hover.png")')
        },
        function () {
            let key=$(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno.png")')
        }
    )

});
</script>