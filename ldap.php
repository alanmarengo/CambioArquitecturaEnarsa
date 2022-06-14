<?php


function ldap_login($usu,$pass)
{
	$server_ad= "ldap://idmc-01.ieasa.com.ar";
	$dominio  = 'ieasa\\';
	$ldaprdn  = $dominio.$usu; 
	$ldappass = $pass;

	$ldapconn = ldap_connect($server_ad);

	if ($ldapconn) 
	{
		$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

		if($ldapbind) 
		{
			return true;
		} 
		else 
		{
			return false;
		};
	}
	else
	{
		return false;
	};

};

?>
