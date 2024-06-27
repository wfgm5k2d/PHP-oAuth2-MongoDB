<?php

// Подключаем MongoDB
require_once './core/connect_mongodb.php';

require_once './function.php';
$_ENV = parseEnvData();

// Подключаем роутер
require_once './core/router.php';