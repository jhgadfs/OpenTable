<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ProductDAO.php';
require_once __DIR__ . '/../models/IngredientDAO.php';

class ProductController
{
    public function index(): void
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        if ($page === false || $page === null || $page < 1) {
            $page = 1;
        }

        $categoryId = filter_input(INPUT_GET, 'categoria_id', FILTER_VALIDATE_INT);
        $productsPerPage = 6;
        $offset = ($page - 1) * $productsPerPage;

        $productDAO = new ProductDAO(getDatabaseConnection());

        if ($categoryId === false || $categoryId === null) {
            $products = $productDAO->getAllActiveProducts($productsPerPage, $offset);
        } else {
            $products = $productDAO->getActiveProducts($productsPerPage, $offset, $categoryId);
        }

        require __DIR__ . '/../views/products/list.php';
    }

    public function show(): void
    {
        $productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($productId === false || $productId === null || $productId < 1) {
            header('Location: index.php?controller=product&action=index');
            exit;
        }

        $productDAO = new ProductDAO(getDatabaseConnection());
        $product = $productDAO->getById($productId);
        $ingredientDAO = new IngredientDAO(getDatabaseConnection());
        $ingredients = $ingredientDAO->getByProductId($productId);

        if ($product === null) {
            showError(404, 'Product not found');
        }

        require __DIR__ . '/../views/products/show.php';
    }
}
