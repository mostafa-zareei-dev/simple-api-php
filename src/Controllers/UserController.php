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
        Response::respondAndDie([]);
    }

    public function create()
    {
        echo "users create resource";
    }
}
