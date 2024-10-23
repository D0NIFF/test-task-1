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
