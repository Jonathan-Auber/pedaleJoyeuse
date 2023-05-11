<?php

namespace models;

class UsersRepository extends Model
{
    protected string $table = "users";

    public function login()
    {
        if (isset($_POST['username'], $_POST['password']) && !empty($_POST)) {
            $username = htmlspecialchars(trim($_POST[['username']]));
            $password = htmlspecialchars(trim($_POST['password']));
        }
    }
}
