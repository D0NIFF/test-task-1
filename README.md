# REST API для пользователей

## Краткое описание проекта

`app/Controllers/Api` - Содержит основную логику REST API, состоит из 3 файлов: <br>
<div style="margin-left: 40px">
    <div><code>AbstractRestApi</code> - абстрактный класс, в котором находятся 5 методов для CRUD операций</div>
    <div><code>UserApiController</code> - в этом классе реализованы эти методы для сущности Пользователь</div>
    <div><code>UserAuthController</code> - один метод, который реализует простую авторизацию и выдает ключ</div>
</div>
<br>
<br>

`app/Middlewares` - Содержит необходимые системные компоненты:
<div style="margin-left: 40px">
    <div><code>Route</code> - отвечает за маршрутизацию</div>
    <div><code>Configuration</code> - отвечает за доступ к конфигу <strong>.env</strong></div>
    <div><code>Database</code> - отвечает за запросы к бд</div>
    <div><code>JsonResponse</code> - отвечает за вывод результата в виде json</div>
</div>

## Роуты


Роуты настраиваются в файле `routes.php`
<br>

**`[GET] /api/users`** - возвращает всех пользователей <br>
_Пример_: 
```
{
    "data": [
        {
            "id": 1,
            "login": "test1",
            "email": "test1@example.com",
            "created_at": "2024-10-23 20:03:21"
        },
        {
            "id": 2,
            "login": "test2",
            "email": "test2@example.com",
            "created_at": "2024-10-23 20:03:21"
        },
        {
            "id": 4,
            "login": "test4",
            "email": "test4@example.com",
            "created_at": "2024-10-23 20:03:21"
        },
        {
            "id": 5,
            "login": "tesf",
            "email": "testffsd",
            "created_at": "2024-10-23 20:03:21"
        }
    ]
}
```
<br>
<br>

**`[GET] /api/users/{id}`** - возвращает пользователя по *id* <br>
_Пример:_
```
{
    "data": {
        "id": 1,
        "login": "test1",
        "email": "test1@example.com",
        "created_at": "2024-10-23 20:03:21"
    },
}
```
<br>
<br>

**`[POST] /api/users`** - регистрирует / создает пользователя <br>
_Входные данные_: массив с следующими ~~(обязательными)~~ полями: <br>
`login` - логин пользователя <br>
`email` - почта пользователя <br>
`password` - пароль пользователя <br>
<br>
<br>

**`[POST] /api/auth`** - авторизирует пользователя и возваращает ключ <br>
_Входные данные_: массив с следующими ~~(обязательными)~~ полями: <br>
`login` - логин пользователя <br>
`password` - пароль пользователя <br>

_Выходные данные_: <br>
```
{
    "data": {
        "status": "success",
        "token": "156896e877d3caf6a2e383e5330f6fb5"
    }
}
```
<br>
<br>

**`[PATCH] /api/users/{id}`** - обновляет пользователя по *id* <br>
_Входные данные_: массив с следующими ~~(необязательными)~~ полями: <br>
`login` - логин пользователя <br>
`email` - почта пользователя <br>
`password` - пароль пользователя <br>
<br>
<br>

**`[DELETE] /api/users/{id}`** - удаляет пользователя по *id* <br>