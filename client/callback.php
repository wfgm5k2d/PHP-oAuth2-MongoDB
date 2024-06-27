<?php
require_once './function.php';
$_ENV = parseEnvData();

if (!isset($_GET['code'])) {
    die('Код авторизации не предоставлен.');
}

$code = $_GET['code'];
$clientId = env('CLIENT_ID');
$clientSecret = env('CLIENT_SECRET');

$data = [
    'grant_type' => 'authorization_code',
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'code' => $code
];

$options = [
    'http' => [
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$remoteServerPort = env('REMOTE_SERVER_PORT');
$context = stream_context_create($options);
$response = file_get_contents("http://localhost:$remoteServerPort/token", false, $context);

if ($response === false) {
    die('Произошла ошибка при получении токена.');
}

$responseData = json_decode($response, true);

echo 'Получили токен и время жизни токена <br>';
echo 'Теперь можно получать данные пользователя или писать свою логику использующую эти параметры <br>';
echo 'К примеру, авторизовать пользователя на портале <br>';
echo '<br>';
echo '<br>';
echo 'Access Token: ' . $responseData['access_token'] . '<br>';
echo 'Refresh Token: ' . $responseData['refresh_token'] . '<br>';
echo 'Expires In: ' . $responseData['expires_in'] . '<br>';