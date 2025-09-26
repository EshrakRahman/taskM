<?php

declare(strict_types=1);
require_once __DIR__ . "/../config/Database.php";

class User
{
    public int $id;
    public string $username;
    public string $password;


    public function create(string $username, string $password): bool
    {
        $hassedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "insert into users (username, password) values (:username, :password)";
        $stmt = Database::getInstance()->prepare($sql);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hassedPass);

        return $stmt->execute();
    }

    public function findByUsername(string $username): ?self
    {

        $sql = "select * from users where username = :username";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();


        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data)
        {
            $user = new self();
            $user->id = (int)$data['id'];
            $user->username = $data['username'];
            $user->password = $data['password'];
            return $user;
        }


        return null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
