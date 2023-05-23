<?php

namespace models;

use Exception;
use LengthException;

class InvoiceRepository extends Model
{
    protected string $table = "invoices";
    protected string $invoiceLinesTable;
    protected string $usersTable;
    protected string $customersTable;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceLinesTable = "invoice_lines";
        $this->usersTable = "users";
        $this->customersTable = "customers";
    }

    public function insertInvoice(int $id)
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} 
        SET customer_id = :customer, user_id = :user, amount_et = :excluded_tax, amount_it = :included_tax");
        $query->execute([
            'customer' => $id,
            'user' => $_SESSION['id'],
            'excluded_tax' => 0,
            'included_tax' => 0
        ]);
        $invoiceId = $this->pdo->lastInsertId();
        return $invoiceId;
    }

    public function updateInvoice($invoiceId)
    {
        $queryData = $this->pdo->prepare("SELECT p.name, p.price_ht, l.quantity, v.rate
        FROM products p 
        JOIN invoice_lines l ON p.id = l.product_id 
        JOIN vat v ON p.vat_id = v.id 
        WHERE l.invoice_id = :invoiceId;
        ");
        $queryData->execute([
            'invoiceId' => $invoiceId
        ]);
        $invoiceData = $queryData->fetchAll();

        $invoiceLines = [];
        $totalInvoice = 0;
        $totalInvoiceVat = 0;
        foreach ($invoiceData as $line) {
            $invoiceLines[] = [
                'name' => $line['name'],
                'quantity' => $line['quantity'],
                'unit_price' => $line['price_ht'],
                'total_price' => $line['quantity'] * $line['price_ht'],
                // 'line_vat' => (($line['quantity'] * $line['price_ht']) * $line['rate']) / 100
            ];
            $totalInvoice += intval($line['quantity'] * $line['price_ht']);
            $totalInvoiceVat += intval((($line['quantity'] * $line['price_ht']) * $line['rate']) / 100);
        }

        $totalWithVat = intval($totalInvoice) + intval($totalInvoiceVat);

        // Update
        $query = $this->pdo->prepare("UPDATE {$this->table} 
            SET amount_et = :excluded_tax, amount_it = :included_tax
            WHERE id = :invoiceId");
        $query->execute([
            'invoiceId' => $invoiceId,
            'excluded_tax' => $totalInvoice,
            'included_tax' => $totalWithVat
        ]);

        return compact('invoiceLines', 'totalInvoice', 'totalInvoiceVat', 'totalWithVat');
    }

    public function customerData(int $invoiceId) {
        $query = $this->pdo->prepare(" SELECT c.firstname, c.lastname, c.address, c.additional_address,c.zip_code, c.city,c.email, c.phone_number, i.creation_date 
        FROM customers c 
        JOIN invoices i ON i.customer_id = c.id 
        WHERE i.id = :invoiceId");
        $query->execute([
            'invoiceId' => $invoiceId
        ]);
        return $query->fetch();
    }

    public function postDataProcessing()
    {
        $result = [];
        for ($i = 1; $i <= count($_POST) / 2; $i++) {
            $result[] = [
                'productId' => $_POST["product_$i"],
                'numberOfProducts' => $_POST["numberOfProducts_$i"]
            ];
        }
        return $result;
    }

    public function insertInvoiceLines(array $results, int $invoiceId)
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->invoiceLinesTable} SET invoice_id = :invoiceId, product_id = :productId, quantity = :quantity");
        foreach ($results as $line) {
            $query->execute([
                'invoiceId' => $invoiceId,
                'productId' => $line['productId'],
                'quantity' => $line['numberOfProducts']
            ]);
            // Retirer le stock de la table produit
        }
    }

    public function updateStock($productID)
    {
        $query = $this->pdo->prepare("SELECT quantity FROM products WHERE id = :id");
    }
}
