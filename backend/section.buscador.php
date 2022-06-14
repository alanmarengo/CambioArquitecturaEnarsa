<div class="row pt-3">
    <div class="col-md-6">
        <p style="padding: 10px 10px 10px 50px; color: #0072BB; font-size: 1.4em;">
            Resultados de la busqueda: <span id="uxBusquedaTexto" style="font-weight: bolder; font-style: italic;"></span>
        </p>
    </div>
    <div class="col-md-6">
        <p style="padding: 10px 10px 10px 50px;">
            Ordenar por
            <select id="uxOrden" name="uxOrden" class="selectpicker" data-width="150">
                <option value="0">T&iacute;tulo A - Z</option>
                <option value="1">T&iacute;tulo Z - A</option>
                <option value="2">Fecha A - Z</option>
                <option value="3">Fecha Z - A</option>
                <option value="4">Categor&iacute;a A - Z</option>
                <option value="5">Categor&iacute;a Z - A</option>
            </select>

            &nbsp;&nbsp;
            Resultado por p&aacute;gina
            <select id="uxQtyPagina" class="selectpicker" data-width="100">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="3">200</option>
            </select>
        </p>
    </div>
</div>

<div class="row pb-3">
    <div class="col-md-3 pr-0" style="padding-left: 50px;">
        <div id="uxSolapas" class="solapas">
        </div>
    </div>
    <div class="col-md-9 p-2" style="border-left: solid 2px #F6F6F6;">
        <div id="uxPager1" style="padding-bottom: 12px; display: none;"></div>
        <div class="resultadosContainer" data-simplebar >
            <div id="uxResultados" class="resultados"></div>
        </div>
        <div id="uxPager2" style="padding: 12px; display: none;"></div>
    </div>
</div>



