<?php

    require_once __DIR__ . '/Ingredient.php';

        class IngredientDAO {
        private PDO $database;

        public function __construct(PDO $database) {
            $this->database = $database;
        }

        public function getAllIngredients(): array {
            $sql = "SELECT id, nombre, precio_extra, activo 
                    FROM ingredientes 
                    ORDER BY nombre";
            $statement = $this->database->prepare($sql);
            $statement->execute();

            return $this->fetchIngredients($statement);    
        }
        public function getAllActiveIngredients(): array {
            $sql = "SELECT id, nombre, precio_extra, activo 
                    FROM ingredientes 
                    WHERE activo = TRUE 
                    ORDER BY nombre";
            $statement = $this->database->prepare($sql);
            $statement->execute();

            return $this->fetchIngredients($statement);
        }
        public function getById(int $ingredientId): ?Ingredient {
            $sql = "SELECT id, nombre, precio_extra, activo 
                    FROM ingredientes 
                    WHERE id = :ingredient_id 
                    AND activo = TRUE";
            $statement = $this->database->prepare($sql);
            $statement->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
            $statement->execute();
            $ingredient = $statement->fetchObject(Ingredient::class);

            return $ingredient ?: null;
        }
        public function getByProductId(int $productId): array{
            $sql = "SELECT
                        i.id,
                        i.nombre,
                        i.precio_extra,
                        i.activo
                    FROM ingredientes AS i
                    INNER JOIN producto_ingrediente AS pi
                        ON i.id = pi.ingrediente_id
                    WHERE pi.producto_id = :product_id
                        AND i.activo = TRUE
                    ORDER BY i.nombre";

            $statement = $this->database->prepare($sql);
            $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);
            $statement->execute();

            return $this->fetchIngredients($statement);
        }
        private function fetchIngredients(PDOStatement $statement): array 
        {
            $ingredients = [];
            while ($ingredient = $statement->fetchObject(Ingredient::class)) {
                $ingredients[] = $ingredient;
            }
            return $ingredients;
        }
    }
        