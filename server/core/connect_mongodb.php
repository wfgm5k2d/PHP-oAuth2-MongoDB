<?php
require_once './vendor/autoload.php';

// Подключение к MongoDB
$client = new MongoDB\Client("mongodb://mongodb:27017");

$database = $client->selectDatabase('oauth');