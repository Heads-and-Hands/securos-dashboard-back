### Перед разворачиванием проекта отключите антивирус

## Установка переменных приложения
* Создать в директории **app** файл .env, скопировав содержание .env.win.example
* Прописать следующие переменные
    * `ASSET_URL` абсолютный url сайта (http://localhost)
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
    * `init_database.vbs` - Создает пустую базу данных. Процесс может занять несколько минут и завершается диалоговым окном "Database initialization successful".
    * `migrate.vbs` - Создаёт/обновляет таблицы в базе данных. Если база данных создана с помощью скрипта `init_database.vbs`, то прежде необходимо запустить `start_database.vbs`.
    * `setRoot.vbs` - Создаёт конфигурационный файл для сервера nginx. Выполняется почти мгновенно.
    
## Запуск и остановка приложения
* Для старта базы данных запустить скрипт `start_database.vbs`. Обязательно при выполнении `init_database.vbs`.
* Для старта приложения запустить скрипт `start.vbs`
* Для остановки приложения запустить скрипт `stop.vbs`. Завершить 4 процесса php
* Для остановки базы данных запустить скрипт `stop_database.vbs`. Обязательно при выполнении `start_database.vbs`.

## Проект доступен по адресу `http://localhost`
