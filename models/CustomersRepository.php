<?php

namespace models;
use Exception;

class CustomersRepository extends Model {
    protected string $table = "customers";

    public function insertCustomer()
    {
        if (!empty($_POST)) {
            $data = [];
            foreach ($_POST as $customer) {
                if (isset($customer)) {
                    $data[] = htmlspecialchars(trim($customer));
                }
            }

            $query = $this->pdo->prepare("INSERT INTO customers SET firstname = :firstName, lastname = :lastName, address = :address, additional_address = :additionalAddress, zip_code = :zipCode, city = :city, email = :email, phone_number = :phoneNumber");
            $query->execute([
                'lastName' => $data[0],
                'firstName' => $data[1],
                'address' => $data[2],
                'additionalAddress' => $data[3],
                'city' => $data[4],
                'zipCode' => $data[5],
                'email' => $data[6],
                'phoneNumber' => $data[7]
            ]);
        } else {
            throw new Exception("Le remplissage des champs comporte une erreur !");
        }
    }

    public function updateCustomer(int $id)
    {
        if (!empty($_POST)) {
            $data = [];
            foreach ($_POST as $customer) {
                if (isset($customer)) {
                    $data[] = htmlspecialchars(trim($customer));
                }
            }

            $query = $this->pdo->prepare("UPDATE customers SET firstname = :firstName, lastname = :lastName, address = :address, additional_address = :additionalAddress, zip_code = :zipCode, city = :city, email = :email, phone_number = :phoneNumber WHERE id = :id");
            $query->execute([
                'id' => $id,
                'lastName' => $data[0],
                'firstName' => $data[1],
                'address' => $data[2],
                'additionalAddress' => $data[3],
                'city' => $data[4],
                'zipCode' => $data[5],
                'email' => $data[6],
                'phoneNumber' => $data[7]
            ]);
        } else {
            throw new Exception("Le remplissage des champs comporte une erreur !");
        }
    }

}


