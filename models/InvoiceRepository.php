<?php
namespace models;
use Exception;

class InvoiceRepository extends Model {
    protected string $table = "invoices";
    protected string $usersTable;
    protected string $customersTable;

    public function __construct(){
        parent::__construct();
        $this->usersTable = "users";
        $this->customersTable = "customers";
    }
}