<?php
require './vendor/autoload.php';
require './function.php';

$_ENV = parseEnvData();

$client = new MongoDB\Client("mongodb://mongodb:27017");

$database = $client->selectDatabase('oauth');

// Регистрируем клиента
$collectionClients = $database->selectCollection('clients');

$clientId = md5(uniqid(rand(), true) . ':pinkedin_client');
$clientSecret = md5(uniqid(rand(), true) . '::secret');

$document = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'redirect_uri' => env('REDIRECT_URI')
];

$result = $collectionClients->insertOne($document);
echo "Новый id клиента '{$result->getInsertedId()}'" . PHP_EOL;

// Регистрируем пользователя
$collectionClients = $database->selectCollection('users');

$email = env('USER_EMAIL');
$password = password_hash(env('PASSWORD'), PASSWORD_BCRYPT);

$document = [
    'email' => $email,
    'password' => $password
];

$result = $collectionClients->insertOne($document);
echo "Пользователь успешно зарегистрирован! '{$result->getInsertedId()}'" . PHP_EOL;

echo "client_id: $clientId" . PHP_EOL;
echo "client_secret: $clientSecret" . PHP_EOL;