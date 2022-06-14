<div class="header">


    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-top">
        <a class="navbar-brand" href="#">
            <img class="logo" style="height:auto;" src="./images/logo_observatorio_ieasa.png" />
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    
                </li>
            </ul>

            <div class="form-inline my-2 my-lg-0" id="uxFormBuscar">
				<?php if ((isset($_SESSION)) && (sizeof($_SESSION) > 0)) { ?>
					<a class="nav-link2" href="./CMD-logout.php" title="Cerrar Sesión" alt="Cerrar Sesión"><i class="fas fa-sign-out-alt"></i></a>
				<?php } ?>
            </div>
        </div>
    </nav>
	
</div>





<script type='text/javascript'>
$(document).ready(function() {
    $('#uxBusquedaButton').on('click', function() {
        buscar($('#uxBusqueda').val())
    });
    $('#uxBusqueda').on('keypress',function(e) {
        if(e.which == 13) {
            buscar($('#uxBusqueda').val())
        }
    });

    function buscar(texto) {
        window.location.href = "buscador.php?s=" + texto;
    }
})
</script>
