<div id="page_contacto" class="page" style="max-width: 1400px; margin: auto; width: 100%; background-color: #fff;">
    <div class="row">
        <div class="col-md-12 page-title">
            Contacto
        </div>

        <div class="col-md-12 page-section-3" style="background-image: url(./images/contacto_bannerv2.png); background-size:cover;">
        </div>

        <div class="col-md-12 page-section-4" style="background-color: #fff;">
            <form id="contacto" style="padding-left: 40px; padding: 20px 40px 40px 40px;">
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
                            <textarea type="text" class="form-control" placeholder="Comentarios" rows="6"></textarea>
                        </div>
                        <!--<button type="submit" class="btn btn-primary">Enviar</button>-->

                       <button class="g-recaptcha btn btn-primary" 
                                data-sitekey="6LejbP0UAAAAAEtu681Yypx4F2kHrkQOpxl3JmhA" 
                                data-callback='onSubmit' 
                                data-action='submit'>Enviar</button>
                       

                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
   function onSubmit(token) {
	      document.getElementById("contacto").submit();
   }
 </script>
