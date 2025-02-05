<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use App\Models\User\User;
use Illuminate\Console\Command;
use App\Services\UserService;
use Illuminate\Http\Request;

class CreateUserSDK extends Command
{
    protected $signature = 'system:user-create';

    protected $description = 'Create a new user in system';

    public function handle()
    {
        $name = fake()->name();
        $email = fake()->email();

        if (User::where('email', $email)->exists()) {
            $this->error("User with email '$email' already exists in this system.");
            return;
        }

        $userService = app(UserService::class);
        $controller = new UserController($userService);

         $user = $controller->store(new Request([
             'name' => $name,
             'email' => $email,
         ]));

        $this->info("User {$user} created successfully in system.");
    }
}
