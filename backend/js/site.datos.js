$(document).ready(function() {
    var model = {
        temas: [
            { numero: 1, nombre: 'AGUA', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 2, nombre: 'ATM&Oacute;SFERA', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 3, nombre: 'SUELO', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 4, nombre: 'BIODIVERSIDAD', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 5, nombre: 'BOSQUES', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 6, nombre: '&Aacute;REAS PROTEGIDAS', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 7, nombre: 'ACTIVIDADES PRODUCTIVAS', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 8, nombre: 'RESIDUOS', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 9, nombre: 'CAMBIO CLIM&Aacute;TICO', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 10, nombre: 'TRANSPARENCIA', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 11, nombre: 'PARTICIPACI&Oacute;N CIUDADANA', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 12, nombre: 'PUEBLOS ORIGINARIOS', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 13, nombre: 'EDUCACI&Oacute;N AMBIENTAL', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 14, nombre: 'AGENDA GLOBAL', datasets: 28, mapas: 5, recursos: 9 },
            { numero: 15, nombre: 'ORDENAMIENTO TERRITORIAL', datasets: 28, mapas: 5, recursos: 9 },
        ]
    };

    temasLoad();

    function temasLoad() {
        $.ajax({
            dataType: 'json',
            url: GlobalApiUrl + '/temas_stats.php',
            success: function(data) {
                model.temas = data;
                render();
            }
        });
    }

    function render() {
        let html = '';

        html += `<div class="row">`;
        $.each(model.temas, function(index, tema) {
            html += `
				<div class="col-lg-4 col-md-6 col-sm-12">
					<a href="./repositorio.php?tid=${tema.numero}" class="tema tema-${tema.numero} d-block">
						<div class="tema-fila-1">
							<div class="row">
								<div class="col-10 tema-nombre">
									${tema.nombre}
								</div>
								<div class="col-2 tema-icono">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12 tema-cantidad">
								Datasets: <b>${tema.datasets}</b>
							</div>
							<div class="col-md-4 col-sm-12 tema-cantidad">
								Mapas: <b>${tema.mapas}</b>
							</div>
							<div class="col-md-4 col-sm-12 tema-cantidad">
								Recursos: <b>${tema.recursos}</b>
							</div>
						</div>
					</a>
				</div>
			`;
        });
        html += `</div>`;

        $('#uxTemas').html(html);

    }



});