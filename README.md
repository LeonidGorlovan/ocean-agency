Для запуска проекта необходимо выполнить следующие шаги

1. настроить .env в корне проекта copy .env.example .env
1. установить php компоненты composer install
1. установить node компоненты npm i && npm run build
1. выполнить миграцию php artisan migrate
1. создать пользователя для админки php artisan make:filament-user этот же пользователь используется для аутентификации в API
1. наполнить базу демо данными php artisan db:seed

Проект локально запускался в среде Vite, по желанию можно обвернуть в докер

В корне проекта есть два файла для Postman

- Api.postman\_collection.json - ендпоинты
- Local.postman\_environment.json - переменные среды

Админка находиться по пути /admin
