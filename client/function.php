<?php
function parseEnvData(): array
{
    $envFile = '.env';
    $envVariables = [];

    if (file_exists($envFile)) {
        $envContent = file_get_contents($envFile);
        $lines = explode("\n", $envContent);

        foreach ($lines as $line) {
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);
            $envVariables[$key] = $value;
        }
    } else {
        echo "Файл $envFile не существует.";
    }

    return $envVariables;
}

function env(string $key)
{
    return $_ENV[$key];
}

function pre($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}