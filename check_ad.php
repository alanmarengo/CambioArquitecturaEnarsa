<?php
/*

ieasa\ldap
pass C0nnect1068

idmc-01.ieasa.com.ar
192.168.10.30

*/

$ldaprdn  = 'ieasa\ldap'; 
$ldappass = 'C0nnect1068';

$ldapconn = ldap_connect("ldap://idmc-01.ieasa.com.ar") or die("Could not connect to LDAP server.");

if ($ldapconn) 
{
    	$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    	if($ldapbind) 
    	{
        	echo "Login OK";
	} 
	else 
	{
        	echo "Login Error";
    	};
}
else
{
	echo "Login Error";
};

?>
