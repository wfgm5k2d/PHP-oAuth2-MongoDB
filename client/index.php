<?php
require_once './function.php';
$_ENV = parseEnvData();

$params = [
    'response_type' => 'code',
    'client_id' => env('CLIENT_ID'),
    'redirect_uri' => env('REDIRECT_URI'),
];

$redirectUri = 'http://localhost:' . env('REMOTE_SERVER_PORT') . '/oauth2/auth?' . urldecode(http_build_query($params));
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>DemoApp</title>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css">
</head>

<body class="text-center">
<form class="form-signin" action="http://localhost:<?= env('REMOTE_SERVER_PORT') ?>">
    <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72"
         height="72">
    <label for="inputEmail" class="sr-only">Email</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
    <div class="d-flex justify-content-center">
        <a href="<?=$redirectUri?>" class="pinkedin mb-2" title="PinkedIn">in</a>
    </div>

    <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y') ?></p>
</form>
</body>
</html>

<style>
    .pinkedin {
        background-color: #004182;
        color: #fff;
        font-weight: 600;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        text-align: center;
        line-height: 38px;
        font-size: 30px;
        cursor: pointer;
    }

    .pinkedin:hover {
        color: #fff;
        text-decoration: none;
    }
</style>