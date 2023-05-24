<?php

namespace models;

use Exception;
use IntlDateFormatter;
use DateTime;

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

    // En cours

    public function salesBy(string $period, ?string $and = "", ?int $userId = null)
    {
        $query = $this->pdo->prepare("SELECT p.name, SUM(l.quantity * p.price_ht) AS total_price
        FROM invoices i
        JOIN invoice_lines l ON i.id = l.invoice_id
        JOIN products p ON p.id = l.product_id
        WHERE $period(i.creation_date) = $period(NOW()) $and
        GROUP BY l.product_id");

        if ($userId) {
            $query->execute([
                $userId
            ]);
        } else {
            $query->execute();
        }

        $period = $query->fetchAll();
        $totalByPeriod = 0;
        foreach ($period as $total) {
            $totalByPeriod += $total['total_price'];
        }

        return compact("period", "totalByPeriod");
    }

    public function productByMonthWithVAT()
    {
        $query = $this->pdo->prepare("SELECT p.name, v.rate,
        MONTH(i.creation_date) AS month,
        SUM(l.quantity * p.price_ht) AS total_price
        FROM invoices i
        JOIN invoice_lines l ON i.id = l.invoice_id
        JOIN products p ON p.id = l.product_id
        JOIN vat v ON v.id = p.vat_id
        WHERE YEAR(i.creation_date) = YEAR(NOW())
        GROUP BY p.name, v.rate, MONTH(i.creation_date)
        ");

        $query->execute();
        $results = $query->fetchAll();

        $productsVAT = [];
        $totalVAT = 0;
        foreach ($results as &$result) {
            $result["month"] = $this->convertMonth($result["month"]);
            $productsVAT[] = [
                'VAT' => ($result["total_price"] * $result['rate']) / 100
            ];
            $totalVAT += ($result["total_price"] * $result['rate']) / 100;
        }

        return compact("results", "productsVAT", "totalVAT");
    }



    public function salesBySeller(int $userId)
    {
        $query = $this->pdo->prepare("SELECT u.username, 
        MONTH(i.creation_date) AS month,
        SUM(i.amount_et) AS total 
        FROM invoices i 
        JOIN users u ON u.id = i.user_id 
        WHERE YEAR(i.creation_date) = YEAR(NOW()) AND u.id = :userId
        GROUP BY u.username, month");

        $query->execute([
            'userId' => $userId
        ]);

        $resultByMonth = $query->fetchAll();
        $resultByYear = 0;
        foreach ($resultByMonth as &$result) {
            $result["month"] = $this->convertMonth($result["month"]);
            $resultByYear += $result["total"];
        }

        return compact("resultByMonth", "resultByYear");
    }

    public function convertMonth(int $monthNumber)
    {
        switch ($monthNumber) {
            case 1:
                return $result["month"] = "Janvier";
            case 2:
                return $result["month"] = "Février";
            case 3:
                return $result["month"] = "Mars";
            case 4:
                return $result["month"] = "Avril";
            case 5:
                return $result["month"] = "Mai";
            case 6:
                return $result["month"] = "Juin";
            case 7:
                return $result["month"] = "Juillet";
            case 8:
                return $result["month"] = "Aout";
            case 9:
                return $result["month"] = "Septembre";
            case 10:
                return $result["month"] = "Octobre";
            case 11:
                return $result["month"] = "Novembre";
            case 12:
                return $result["month"] = "Décembre";
        }
    }
}
