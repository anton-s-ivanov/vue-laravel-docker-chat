## REST API приложения обмена сообщениями
*  Laravel + Sanctum REST API

# Необходимо выполнить:
* В файле .env настроить подключение к БД
* Запустить команду: php artisan migrate --seed
* В файле .env указать QUEUE_CONNECTION=database
* Запустить команду: php artisan queue:work 
* В файле .env настроить MAIL (для уведомлений о новых сообщениях в чате)


