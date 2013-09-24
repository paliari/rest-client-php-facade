<?php
require_once __DIR__."/../vendor/autoload.php";

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$config = json_decode(file_get_contents(__DIR__."/config.json"), true);
$rest = new \Paliari\RestClientFacade\ClientFacade($config);
