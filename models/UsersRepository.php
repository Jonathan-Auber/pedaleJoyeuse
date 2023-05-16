<?php

namespace models;

use Exception;

class UsersRepository extends Model
{
    protected string $table = "users";

    public function login()
    {
        if (isset($_POST['username'], $_POST['password']) && !empty($_POST)) {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));
            $result = $this->findAccount($username, $password);

            if ($username === $result['username'] && password_verify($password, $result['password'])) {
                $_SESSION['id'] = $result['id'];
                $_SESSION['status'] = $result['status'];
                return TRUE;
            } else {
                throw new Exception("Votre nom d'utilisateur ou votre mot de passe est erroné !");
            }
        }
    }

    private function findAccount(string $username)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $query->execute([
            'username' => $username
        ]);
        return $query->fetch();
    }

    public function isConnected()
    {
        if (isset($_SESSION)) {
            return TRUE;
        } else {
            throw new Exception("Vous n'êtes pas connecté !");
        }
    }

    public function isAdmin()
    {
        if ($_SESSION['status'] === "boss") {
            return TRUE;
        } else {
            // A voir
            throw new Exception("Vous n'avez pas les droits pour accéder à cette page");
        }
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
