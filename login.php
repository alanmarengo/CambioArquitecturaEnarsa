<?php


session_start();

/*
$login = "<!DOCTYPE html>";
$login .= "<html lang=\"es\">";
$login .= "<head>";
$login .= "<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700\" rel=\"stylesheet\">";
$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./fontawesome-5.8.1/css/all.min.css\" />";
$login .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/login.css\" />";
$login .= "<script type=\"text/javascript\" src=\"./js/jquery-3.2.1.min.js\"></script>";
$login .= "<script type=\"text/javascript\">";
$login .= "$(document).ready(function() { 
							$('#frm input').each(function(i,v) {
								var ph = $(v).attr('data-placeholder');
								$(v).val('');
								$(v).focusin(function() { $(this).attr('placeholder', ''); });
								$(v).focusout(function() { $(this).attr('placeholder', ph); });
								$(v).keyup(function(e) {
									
									if (e.which == 13) {
										
										document.getElementById('frm').submit();
										
									}
									
								});
							}); 
						});";
$login .= "</script>";
$login .= "</head>";
$login .= "<body>";
	$login .= "<div class=\"login-modal\"></div>";
	$login .= "<div class=\"login-window\">";
		$login .= "<div class=\"login-window-header\">";
			$login .= "<span>ACCEDER</span>";
		$login .= "</div>";
		$login .= "<div class=\"login-window-body\">";
			$login .= "<form method=\"post\" action=\"./CMD-login.php\" id=\"frm\">";
				$login .= "<div class=\"form-group\">";
					$login .= "<i class=\"fa fa-user\"></i>";
					$login .= "<input type=\"text\" placeholder=\"Usuario\" name=\"user-name\" data-placeholder=\"Usuario\">";
				$login .= "</div>";
				$login .= "<div class=\"form-group\">";
					$login .= "<i class=\"fa fa-key\"></i>";
					$login .= "<input type=\"password\" placeholder=\"Contraseña\" name=\"user-password\" data-placeholder=\"Contraseña\">";
				$login .= "</div>";
				$login .= "<div class=\"form-group form-group-button\">";
					$login .= "<a href=\"#\" class=\"login-black-button\" onclick=\"document.getElementById('frm').submit();\">INGRESAR</a>";
				$login .= "</div>";
			$login .= "</form>";
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
*/
?>
