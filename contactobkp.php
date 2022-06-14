<?php include("./header.php"); ?>

<div id="page_contacto" class="page" style="background-color: #fff;">
    <div class="row">
        <div class="col-md-12 page-section-1">
            Contacto
        </div>

        <div class="col-md-12 page-section-3" style="background-image: url(./images/contacto_banner.png);">
        </div>

        <div class="col-md-12 page-section-4">
            <form style="padding-left: 40px; padding: 20px 40px 40px 40px;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nombre y apellido">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Asunto">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <textarea type="text" class="form-control" placeholder="" rows="6"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">ENVIAR</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<?php include("./widget-links.php"); ?>

<script type='text/javascript'>
$(document).ready(function() {});
</script>

<?php include("./footer.php"); ?>