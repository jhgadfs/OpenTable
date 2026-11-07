<?php

$counter = count($products);
$selectedCategory = $categoryId ?? null;

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$categoryQuery = $selectedCategory !== null ? '&categoria_id=' . $selectedCategory : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our menu | OpenTable</title>
    <link rel="stylesheet" href="public/css/products.css">
</head>
<body>
    <?php require_once __DIR__ . '/../templates/header.php';?>

    <main>
        <section class="intro">
            <p>Explore your menu</p>
            <h1>Something for every appetite</h1>
            <span>From comforting classics to flavours from around the world.</span>
        </section>

        <div class="categories">
            <a href="index.php?controller=product&action=index&page=1" class="category-button <?= $selectedCategory === null ? 'active' : '' ?>">All dishes</a>
            <a href="index.php?controller=product&action=index&page=1&categoria_id=1" class="category-button <?= $selectedCategory === 1 ? 'active' : '' ?>">Starters</a>
            <a href="index.php?controller=product&action=index&page=1&categoria_id=2" class="category-button <?= $selectedCategory === 2 ? 'active' : '' ?>">Main courses</a>
            <a href="index.php?controller=product&action=index&page=1&categoria_id=3" class="category-button <?= $selectedCategory === 3 ? 'active' : '' ?>">Desserts</a>
            <a href="index.php?controller=product&action=index&page=1&categoria_id=4" class="category-button <?= $selectedCategory === 4 ? 'active' : '' ?>">Drinks</a>
        </div>

        <section class="products-grid">
            <?php foreach ($products as $product):
                $imgName = $product->getName() . '.jpg';
                $imgLink = 'public/img/productos/' . rawurlencode($imgName);
                $imgLocation = __DIR__ . '/../../public/img/productos/' . $imgName;
            ?>
                <article class="product-card">
                    <?php if (file_exists($imgLocation)): ?>
                        <img src="<?= $imgLink ?>" alt="<?= escape($product->getName()) ?>">
                    <?php else: ?>
                        <div class="image-placeholder">Image coming soon</div>
                    <?php endif; ?>
                    <p class="category-name"><?= escape($product->getCategory()) ?></p>
                    <h2><?= escape($product->getName()) ?></h2>
                    <p><?= escape($product->getDescription()) ?></p>
                    <div class="product-bottom">
                        <strong><?= number_format($product->getPrice(), 2) ?>€</strong>
                        <a href="index.php?controller=product&action=show&id=<?= $product->getId() ?>" class="cart-button">Add to cart</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <?php if ($counter === 0): ?>
            <div class="more"><p>No products found in this category.</p></div>
            <div class="more"><?php if ($page > 1): ?>
                    <a href="index.php?controller=product&action=index&page=<?= $page - 1 ?><?= $categoryQuery ?>" class="cart-button">Previous page</a>
            <?php endif; ?></div>
        <?php else: ?>
            <div class="more">
                <?php if ($page > 1): ?>
                    <a href="index.php?controller=product&action=index&page=<?= $page - 1 ?><?= $categoryQuery ?>" class="cart-button">Previous page</a>
                <?php endif; ?>
                <?php if ($counter === $productsPerPage): ?>
                    <a href="index.php?controller=product&action=index&page=<?= $page + 1 ?><?= $categoryQuery ?>" class="cart-button">Next page</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
