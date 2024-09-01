<?php

namespace App\Services;

use App\Models\UserModel;

class UsersService
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getListOfUsers(): array
    {
        return $this->userModel->findAll();
    }

    public function create(array $data): bool
    {
        [$name, $email, $password] = [$data['name'], $data['email'], $data['password']];

        $password = password_hash($password, PASSWORD_BCRYPT);

        return $this->userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function update(int $userId, array $data): bool
    {
        [$name, $email] = [$data['name'], $data['email']];

        return $this->userModel->update($userId, [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function delete(int $userId): bool
    {
        return $this->userModel->delete($userId);
    }
}
