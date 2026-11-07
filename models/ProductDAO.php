<?php

require_once __DIR__ . '/Product.php';
class ProductDAO{
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getAllActiveProducts(int $limit, int $offset): array
    {
        $sql = "SELECT p.id, p.categoria_id, p.nombre, p.descripcion,
                       p.precio, p.imagen, p.activo, c.nombre AS categoria
                FROM productos AS p
                INNER JOIN categorias AS c ON p.categoria_id = c.id
                WHERE p.activo = TRUE AND c.activa = TRUE
                ORDER BY c.nombre, p.nombre
                LIMIT :limit OFFSET :offset";

        return $this->executeListQuery($sql, $limit, $offset);
    }

    public function getActiveProducts(int $limit, int $offset, int $categoryId): array
    {
        $sql = "SELECT p.id, p.categoria_id, p.nombre, p.descripcion,
                       p.precio, p.imagen, p.activo, c.nombre AS categoria
                FROM productos AS p
                INNER JOIN categorias AS c ON p.categoria_id = c.id
                WHERE p.activo = TRUE AND c.activa = TRUE
                    AND p.categoria_id = :category_id
                ORDER BY c.nombre, p.nombre
                LIMIT :limit OFFSET :offset";

        $statement = $this->database->prepare($sql);
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $this->fetchProducts($statement);
    }

    public function getById(int $productId): ?Product{
        $sql = "SELECT p.id, p.categoria_id, p.nombre, p.descripcion,
                       p.precio, p.imagen, p.activo, c.nombre AS categoria
                FROM productos AS p
                INNER JOIN categorias AS c ON p.categoria_id = c.id
                WHERE p.id = :product_id
                    AND p.activo = TRUE
                    AND c.activa = TRUE";

        $statement = $this->database->prepare($sql);
        $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $statement->execute();

        $product = $statement->fetchObject(Product::class);

        return $product ?: null;
    }

    private function executeListQuery(string $sql, int $limit, int $offset): array
    {
        $statement = $this->database->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchProducts($statement);
    }

    private function fetchProducts(PDOStatement $statement): array
    {
        $products = [];
        while ($product = $statement->fetchObject(Product::class)) {
            $products[] = $product;
        }
        return $products;
    }
}

