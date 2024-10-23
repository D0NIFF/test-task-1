<?php

namespace App\Controllers\Api;

use App\Middlewares\Database;
use App\Middlewares\JsonResponse;

class UserApiController extends AbstractRestApi
{

    /**
     *  Получает всех пользователей
     *
     * @return void
     */
    public static function index() : void
    {
        $users = Database::query("SELECT id, login, email, created_at FROM users");
        $users = $users->fetchAll(\PDO::FETCH_ASSOC);

        JsonResponse::handle($users);
    }

    /**
     *  Получает пользователя по id
     *
     * @param string $id
     * @return void
     */
    public static function show(string $id): void
    {
        try {
            $users = Database::query("SELECT id, login, email, created_at FROM users WHERE id = {$id}");
            $users = $users->fetch(\PDO::FETCH_ASSOC);

            JsonResponse::handle($users);
            return;
        }
        catch (\PDOException $e) {
            JsonResponse::handle($e);
        }
    }

    /**
     *  Создает нового пользователя
     *
     * @param array|null $data
     * @return void
     */
    public static function store(array|null $data = []): void
    {
        if (empty($data))
            JsonResponse::error('Request data is empty');

        $userData = [
            'login' => trim($data['login']) ?? null,
            'email' => trim($data['email']) ?? null,
            'password' => hash('SHA256', $data['password']) ?? null,
        ];

        if (empty($userData['login']))
        {
            JsonResponse::error('Login is empty');
            return;
        }

        if (empty($userData['email']))
        {
            JsonResponse::error('Email is empty');
            return;
        }

        if (empty($userData['password']))
        {
            JsonResponse::error('Password is empty');
            return;
        }

        $user = Database::query("SELECT * FROM `users` WHERE `login` = '{$userData['login']}' LIMIT 1");
        $user = $user->fetch();
        if (!empty($user)) {
            JsonResponse::error('Пользователь с таким логином уже существует!');
            return;
        }

        Database::insert('users', $userData);
        JsonResponse::handle($data);
    }

    /**
     *  Обновляет данные пользователя
     *
     * @param string|int $id
     * @param array $data
     * @return void
     */
    public static function update(string|int $id, array $data = []): void
    {
        if (empty($data))
            JsonResponse::error('Request data is empty');

        $userData = [];

        if (!empty($data['login']))
            $userData['login'] = trim($data['login']);

        if (!empty($data['email']))
            $userData['email'] = trim($data['email']);

        if (!empty($data['password']))
            $userData['password'] = hash('SHA256', $data['password']);

        $user = Database::query("SELECT * FROM `users` WHERE `login` = '{$userData['login']}' LIMIT 1");
        $user = $user->fetch();
        if (!empty($user)) {
            JsonResponse::error('Пользователь с таким логином уже существует!');
            return;
        }

        Database::update('users', $id, $userData);
        JsonResponse::handle($data);
    }

    /**
     *  Удаляет пользователя
     *
     * @param string $id
     * @return void
     */
    public static function destroy(string $id): void
    {
        if (empty($id))
        {
            JsonResponse::error('Request data is empty');
            return;
        }

        Database::query("DELETE FROM users WHERE id = {$id}");
        JsonResponse::handle(['success' => true, 'message' => 'User deleted']);
    }
}