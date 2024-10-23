<?php

namespace App\Controllers\Api;

use App\Middlewares\Database;
use App\Middlewares\JsonResponse;

class UserAuthController
{
    public function authorization(array $data = [])
    {
        if (empty($data)) {
            JsonResponse::error('Request data is empty!');
            return;
        }

        $userData = [];
        if (!isset($data['login']) && empty($data['login'])) {
            JsonResponse::error('Login required!');
            return;
        }

        if (!isset($data['password']) && empty($data['password'])) {
            JsonResponse::error('Password required!');
            return;
        }

        $userData['login'] = $data['login'];
        $userData['password'] = hash('sha256', $data['password']);

        $user = Database::query("SELECT * FROM `users` WHERE `login` = '{$userData['login']}' LIMIT 1");
        $user = $user->fetch();
        if (empty($user)) {
            JsonResponse::error('User not found!');
            return;
        }

        if($user['password'] !== $userData['password']) {
            JsonResponse::error('Wrong password!');
            return;
        }

        $token = md5($user['login'] . $user['password'] . time());
        Database::query("INSERT INTO `user_tokens` (`user_id`, `token`) VALUES ('{$user['id']}', '{$token}')");
        JsonResponse::handle(['status' => 'success', 'token' => $token]);
        return;
    }

}