<?php

namespace models;

use Exception;

class ProductsRepository extends Model
{
    protected string $table = "products";

    public function updateProduct(int $id)
    {
        if (!empty($_POST)) {
            $data = [];
            foreach ($_POST as $product) {
                if (isset($product)) {
                    $data[] = htmlspecialchars(trim($product));
                }
            }

            $query = $this->pdo->prepare("UPDATE products SET name = :name, reference = :reference, stock = :stock, stock_alert = :stock_alert, price_ht = :price_ht WHERE id = :id");
            $query->execute([
                'id' => $id,
                'name' => $data[0],
                'reference' => $data[1],
                'stock' => $data[2],
                'stock_alert' => $data[3],
                'price_ht' => $data[4]
            ]);
        } else {
            throw new Exception("400 : Le remplissage des champs comporte une erreur !");
        }
    }
    public function getStock(int $productId) 
    {
        $query = $this->pdo->prepare("SELECT stock 
        FROM products 
        WHERE id = :productId");
        $query->execute([
            "productId" => $productId
        ]);
        return $query->fetch();
    }

    public function updateStock(int $productId, int $numberOfProduct)
    {
        $stock = $this->getStock($productId);
        $newStock = $stock["stock"] - $numberOfProduct;
        $query = $this->pdo->prepare("UPDATE products
            SET stock = :newStock
            WHERE id = :productId");
            $query->execute([
                'productId' => $productId,
                'newStock' => $newStock
            ]);
    }
}
