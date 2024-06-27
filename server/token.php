<?php

/**
 * @var MongoDB\Database $database
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grantType = $_POST['grant_type'];
    $clientId = $_POST['client_id'];
    $clientSecret = $_POST['client_secret'];
    $code = $_POST['code'];

    if ($grantType === 'authorization_code') {
        list($userId, $clientIdFromCode) = explode(':', base64_decode($code));

        // Проверка клиента
        $collection = $database->selectCollection('clients');
        $client = $collection->findOne([
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ]);

        if (!$client) {
            handleError('invalid_client', 401);
        }

        // Проверка кода авторизации
        if ($clientId !== $clientIdFromCode) {
            handleError('invalid_grant');
        }

        // Генерация токенов
        try {
            $accessToken = generateToken();
            $refreshToken = generateToken();
        } catch (\Random\RandomException $e) {
            echo var_export(
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], true
            );
        }
        $expiresIn = 3600; // 1 час

        $collectionTokens = $database->selectCollection('tokens');
        $result = $collectionTokens->insertOne([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => $expiresIn,
            'user_id' => $userId,
            'client_id' => $clientId
        ]);

        if (!$result->isAcknowledged()) {
            // Логируем данные или обрабатываем как-то иначе возможную ошибку
            echo json_encode([
                'error' => 'Ошибка выдачи токена'
            ]);
        }

        echo json_encode([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $expiresIn,
            'refresh_token' => $refreshToken
        ]);
    } elseif ($grantType === 'refresh_token') {
        $refreshToken = $_POST['refresh_token'];

        $collectionTokens = $database->selectCollection('tokens');
        $token = $collectionTokens->findOne(['refresh_token' => $refreshToken]);

        if (!$token) {
            handleError('invalid_grant');
        }

        try {
            $newAccessToken = generateToken();
        } catch (\Random\RandomException $e) {
            echo var_export(
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], true);
        }
        $newExpiresIn = time() + 3600;

        $updateResult = $collectionTokens->updateOne(
            [
                'refresh_token' => $refreshToken,
            ],
            [
                'access_token' => $newAccessToken,
                'expires_in' => $newExpiresIn
            ]
        );

       if (!$updateResult->isAcknowledged()) {
           // Логируем данные или обрабатываем как-то иначе возможную ошибку
           echo json_encode([
               'error' => 'Ошибка обновления токена'
           ]);
       }

        echo json_encode([
            'access_token' => $newAccessToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'refresh_token' => $refreshToken
        ]);
    } else {
        echo json_encode(['error' => 'unsupported_grant_type']);
    }
} else {
    echo json_encode(['error' => 'invalid_request']);
}
