<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\UsersService;

class UserController
{
    private UsersService $userService;

    public function __construct()
    {
        $this->userService = new UsersService();
    }

    public function list(Request $request)
    {
        $users = $this->userService->getListOfUsers();

        Response::respondAndDie($users);
    }

    public function create(Request $request)
    {
        $data = $request->params();

        [$userName, $userEmail, $password] = [$data['name'], $data['email'], $data['password']];

        $isCreated = $this->userService->create([
            'name' => $userName,
            'email' => $userEmail,
            'password' => $password
        ]);

        if (!$isCreated) {
            Response::respondAndDie([], Response::HTTP_NOT_FOUND);
        }

        Response::respondAndDie(['User Created.']);
    }

    public function update(Request $request)
    {
        $data = $request->params();
        
        [$userId, $userName, $userEmail] = [$data['id'], $data['name'], $data['email']];

        $isUpdated = $this->userService->update($userId, [
            'name' => $userName,
            'email' => $userEmail,
        ]);

        if (!$isUpdated) {
            Response::respondAndDie([], Response::HTTP_NOT_FOUND);
        }

        Response::respondAndDie(['User Updated.']);
    }

    public function delete(Request $request)
    {
        $data = $request->params();
        
        [$userId] = [$data['id']];

        $isDeleted = $this->userService->delete($userId);

        if (!$isDeleted) {
            Response::respondAndDie([], Response::HTTP_NOT_FOUND);
        }

        Response::respondAndDie(['User Deleted.']);
    }
}
