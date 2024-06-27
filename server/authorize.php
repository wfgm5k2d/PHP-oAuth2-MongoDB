<?php
/** @var MongoDB\Database $database */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
    $clientId = htmlspecialchars(filter_input(INPUT_POST, 'client_id'));
    $redirectUri = filter_input(INPUT_POST, 'redirect_uri', FILTER_VALIDATE_URL);
    $responseType = htmlspecialchars(filter_input(INPUT_POST, 'response_type'));

    if (!$email || !$password || !$clientId || !$redirectUri || !$responseType) {
        handleError('Invalid input.');
    }

    $collection = $database->selectCollection('users');

    $user = $collection->findOne(['email' => $email]);

    if ($user && password_verify($password, $user['password'])) {
        $userId =$user['_id']->__toString();
        header("Location: $redirectUri?code=" . base64_encode($userId . ':' . $clientId));
    } else {
        handleError('Неверный email или пароль', 401);
    }
}