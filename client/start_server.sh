#!/bin/bash

# Парсинг .env файла и экспорт переменных
while IFS='=' read -r key value || [ -n "$key" ]; do
    if [[ ! $key =~ ^\s*# && ! -z $key ]]; then
        value=$(echo $value | tr -d '\r')
        export "$key"="$value"
    fi
done < .env

# Вывод значений переменных для проверки
#echo "CLIENT_SERVER_PORT: $CLIENT_SERVER_PORT"

# Запуск сервера PHP с использованием переменных из .env
php -S localhost:${CLIENT_SERVER_PORT} & server1_pid=$!

# Ожидание нажатия клавиши для завершения серверов
echo "Сервер запущен. Нажмите любую клавишу, чтобы выключить его."
read -n 1 -s

# Остановка сервера PHP
kill $server1_pid

echo "Сервер выключен."