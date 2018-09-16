# API для каталога товаров с Авторизацией через Laravel Passport

Register
-
**Route:**
`POST` - `/api/register/`

**Data:**
``
name, email, password
``

**Success Response:** `200`
```
{
    "token": "eyJ0eXAiOiJ36oNXFKwyZ5k5xoaEK...3ci-lgq0q_L6Eh1SCGt9Mjfs7BOX7LCuZBUaBLNX82kqg"
}
```

**Error Response:** `400`
```
@todo error response
```
