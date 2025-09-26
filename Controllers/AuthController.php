<?php

declare(strict_types=1);
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/User.php";


class AuthController
{

    public function login(string $username, string $password): bool
    {

        $user = (new User())->findByUsername($username);

        if ($user && $user->verifyPassword($password))
        {
            $_SESSION['user_id'] = $user->id;
            return true;
        }

        return false;
    }

    public function signup(string $username, string $password): bool
    {

        $userExists = (new User())->findByUsername($username);
        if($userExists)
        {
            echo "User already exists";
            return false;
        }

        $user = new User();
        $newUser = $user->create($username, $password);

        if($newUser)
        {
            $userTemp = $user->findByUsername($username);
            $_SESSION["user_id"] = $userTemp->id;
            return true;
        }

        return false;
    }
}
