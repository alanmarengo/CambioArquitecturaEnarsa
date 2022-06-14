<?php

session_start();

$login = "<!DOCTYPE html>";
$login .= "<html lang=\"es\">";
	$login .= "<head>";

		$login .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";

		$login .= "<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700\" rel=\"stylesheet\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./fontawesome-5.8.1/css/all.min.css\">";

		$login .= "<link rel=\"stylesheet\" href=\"./css/ti-icons/css/themify-icons.css\">";

		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/bootstrap.min.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/bootstrap-datepicker.min.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/bootstrap-select.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/HoldOn.min.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/site.css\">";

		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/flex.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/margins.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/sizes.css\">";
		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/backend.css\">";

		$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/jquery_ui.css\">";
		$login .= "<script type=\"text/javascript\" src=\"./js/jquery-3.2.1.min.js\"></script>";
		$login .= "<script type=\"text/javascript\" src=\"./js/jquery-ui/jquery-ui.min.js\"></script>";

		$login .= "<script type=\"text/javascript\" src=\"./js/bootstrap.bundle.min.js\"></script>";
		$login .= "<script src=\"./js/bootstrap-select.js\"></script>";
		$login .= "<script src=\"./js/HoldOn.min.js\"></script>";
		$login .= "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.js\"></script>";
		$login .= "<script src=\"./js/moment.js\"></script>";
		$login .= "<script src=\"./js/moment-es.js\"></script>";
		$login .= "<script src=\"./js/site.js\" type=\"text/javascript\"></script>";
		$login .= "<script src=\"./js/datepicker.js\" type=\"text/javascript\"></script>";

		$login .= "<script type=\"text/javascript\">";
		$login .= "$(document).ready(function() { 
					$('#frm-backend-main input').each(function(i,v) {
						var ph = $(v).attr('data-placeholder');
						$(v).val('');
						$(v).focusin(function() { $(this).attr('placeholder', ''); });
						$(v).focusout(function() { $(this).attr('placeholder', ph); });
						$(v).keyup(function(e) {
							
							if (e.which == 13) {
								
								document.getElementById('frm-backend-main').submit();
								
							}
							
						});
					}); 
				});";
		$login .= "</script>";
	$login .= "</head>";
	$login .= "<body style=\"overflow-x:hidden\">";

		$login .= "<div class=\"row h100-p\">";
			$login .= "<div class=\"col col-xs-12 col-sm-12 col-md-4 col-lg-4 h100-p\"></div>";
				$login .= "<div class=\"col col-xs-12 col-sm-12 col-md-4 col-lg-4 h100-p\" style=\"display:flex; align-items:center;\">";
		
					$login .= "<div class=\"login-form\">";
					
						$login .= "<p><img src=\"./images/logologin.png\" height=\"128\"></p>";
					
						$login .= "<form name=\"frm-backend-main\" id=\"frm-backend-main\" class=\"mt-20\" action=\"../CMD-login.php\" method=\"post\">";
							
							$login .= "<div class=\"form-group\">";
								$login .= "<label for=\"usuario_login_name\">Usuario</label>";
								//$login .= "<input type=\"text\" class=\"form-control\" name=\"usuario_login_name\" id=\"usuario_login_name\" aria-describedby=\"usuario_login_name\" placeholder=\"Usuario...\">";
								$login .= "<input type=\"text\" class=\"form-control\" name=\"user-name\" id=\"usuario_login_name\" aria-describedby=\"usuario_login_name\" placeholder=\"Usuario...\">";

							$login .= "</div>";
						
							$login .= "<div class=\"form-group\">";
								$login .= "<label for=\"usuario_pass\">Contraseña</label>";
								//$login .= "<input type=\"password\" class=\"form-control\" name=\"usuario_pass\" id=\"usuario_pass\" aria-describedby=\"usuario_pass\" placeholder=\"Contraseña...\">";
								$login .= "<input type=\"password\" class=\"form-control\" name=\"user-password\" id=\"usuario_pass\" aria-describedby=\"usuario_pass\" placeholder=\"Contraseña...\">";

							$login .= "</div>";
						
							$login .= "<div class=\"form-group\">";
								$login .= "<button class=\"btn btn-primary\" onclick=\"document.getElementById('frm-backend-main').submit();\">Ingresar</button>";
							$login .= "</div>";
								
						$login .= "</form>";
					
					$login .= "</div>";
						
				$login .= "</div>";			
			$login .= "</div>";
		$login .= "</div>";
		
	$login .= "</body>";
$login .= "</html>";


if (isset($_SESSION)) {

	if (sizeof($_SESSION) == 0) {
		
		die($login);

	}
	
}else{
		
	die($login);

}

?>
