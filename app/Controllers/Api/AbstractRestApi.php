<?php

namespace App\Controllers\Api;

abstract class AbstractRestApi
{

    public static function index(): void
    {}

    public static function show(string $id): void
    {}

    public static function store(array $data = []): void
    {}

    public static function update(string|int $id, array $data = []): void
    {}

    public static function destroy(string $id): void
    {}
}