### Перед разворачиванием проекта отключите антивирус

## Установка переменных приложения
* Создать в директории **app** файл .env, скопировав содержание .env.win.example
* Прописать следующие переменные
    * `APP_URL` абсолютный url сайта (http://localhost)
    * `NGINX_PORT` порт сервера nginx, на котором будет доступен проект
    * `SECUROS_DASHBOARD_DB_CONNECTION` тип соединения (`pgsql`, подробнее `https://laravel.com/docs/6.x/database`)
    * `SECUROS_DASHBOARD_DB_HOST` хост базы данных (`127.0.0.1` по-умолчанию)
    * `SECUROS_DASHBOARD_DB_PORT` порт базы данных (`5432` по-умолчанию)
    * `SECUROS_DASHBOARD_DB_DATABASE` имя базы данных
    * `SECUROS_DASHBOARD_DB_USERNAME` пользователь базы данных
    * `SECUROS_DASHBOARD_DB_PASSWORD` пароль базы данных
    * `SECUROS_DASHBOARD_URL` url для получения камер
    * `SECUROS_DASHBOARD_URL_PHOTO` url для получения фото с камер

## Инициализация приложения
* Выполнить скрипты из директории app/windows
    * `generate_key.vbs` - Генерирует app key. Процесс завершается диалоговым окном "Key is generated".
    * `migrate.vbs` - Создаёт/обновляет таблицы в базе данных.
    * `setRoot.vbs` - Создаёт конфигурационный файл для сервера nginx. Выполняется почти мгновенно.

## Запуск и остановка приложения
* Для старта приложения запустить скрипт `start.vbs`
* Для остановки приложения запустить скрипт `stop.vbs`. Завершить процесс php

## Проект доступен по адресу `http://localhost`
