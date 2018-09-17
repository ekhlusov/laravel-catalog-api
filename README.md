## API для каталога товаров с Авторизацией через Laravel Passport
# Развертывание проекта
```
Для теста:
1) Переходим в папку app в корне сервиса 
2) Настраиваем БД и прописываем данные в .env файле
3) php artisan migrate
4) php artisan serve
5) Сервис будет доступен по адресу: http://127.0.0.1:8000
```
В докере
-
Для работы проекта необходим `docker`.

`make start` - развертывание окружения в режиме продакшена

`make shell` или  - для входа в PHP-Cli проекта

`make shell-node` - для входа в node-cli

`make scheduler-run` - запуск планировщика в контейнере

и много еще чего полезного можно найти в `Makefile`

После изменений в конфиге nginx выполнить `make stop && docker-compose build nginx && make start`

Для разварачивания проекта первый раз необходимо выполнить
`make start && make shell`

#### Настройка nginx для доступа к сайту по нормальному имени
```
server {
    server_name catalog-api;
    listen 80;

    location / {
        proxy_pass              http://localhost:54380;
        proxy_set_header Host   catalog-api.loc;
    }
}
```

### Настройка дебаг сессии
PhpStorm перейдите во вкладку Language & frameworks -> php -> servers
Для localhost настройки mapping. app/app -> app/htdocs/

### Пример запуска задач из очереди по крону
```*  *  *  *  *       cd /home/deploy/laravel-catalog-api && /usr/bin/make scheduler-run >> /dev/null 2>&1```

# API
## Пользователь

POST /api/register | Регистрация пользователя
-

**Data:**
``
name, email, password
``

**Response:** `200`
```
{
    "token": "eyJ0eXAiOiJ36oNXFKwyZ5k5xoaEK...3ci-lgq0q_L6Eh1SCGt9Mjfs7BOX7LCuZBUaBLNX82kqg"
}
```

POST /api/login | Авторизация пользователя
-

**Data:**
``
email, password
``

**Response:** `200`
```
{
    "token": "eyJ0eXAiOiJ36oNXFKwyZ5k5xoaEK...3ci-lgq0q_L6Eh1SCGt9Mjfs7BOX7LCuZBUaBLNX82kqg"
}
```


GET /api/user | Данные пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "token": "eyJ0eXAiOiJ36oNXFKwyZ5k5xoaEK...3ci-lgq0q_L6Eh1SCGt9Mjfs7BOX7LCuZBUaBLNX82kqg"
}
```

## Товары

GET /api/products | Отображает все товары авторизованного пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

POST /api/products | Добавляет товар от авторизованного пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Data:**
```
title, price, category_id
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

GET /api/products/[id] | Отображает конкретный товар по id
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

PUT /api/products/[id] | Редактирование товара
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true
}
```


DELETE /api/products/[id] | Удаление товара
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
}
```

GET /api/products/all | Отображает список всех товаров
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

## Категории

GET /api/categories | Показывает список категорий для авторизованного пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

POST /api/categories | Добавляет категорию от авторизованного пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Data:**
```
title
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

GET /api/categories/[id] | Отображает конкретную категорию по id
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

PUT /api/categories/[id] | Редактирование категории для авторизованного пользователя
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
}
```


DELETE /api/categories/[id] | Удаление категории
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
}
```

GET /api/categories/all | Показывает список всех категорий
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

GET /api/category/[id] | Показывает список товаров в конкретной категории по id
-

**Headers:**
```
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

**Response:** `200`
```
{
    "success": true,
    "data" []
}
```

Регистрация пользователей через artisan
-


```
php artisan user:register
```
