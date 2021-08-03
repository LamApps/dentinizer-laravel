<?php
if($_SERVER['SERVER_NAME'] != 'dentinizer.local'){
    include('config-prod.php');
}else{
    include('config-dev.php');
}
try
{
	$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}