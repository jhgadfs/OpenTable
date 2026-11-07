<?php
function escapeProductValue(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$imageName = $product->getName() . '.jpg';
$imagePath = __DIR__ . '/../../public/img/productos/' . $imageName;
$imageUrl = 'public/img/productos/' . rawurlencode($imageName);
?>
<!DOCTYPE html>
<html lang="en">
<script src="public/js/main.js" defer></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escapeProductValue($product->getName()) ?> | OpenTable</title>
    <link rel="stylesheet" href="public/css/products.css">
</head>
<body>
    <?php require_once __DIR__ . '/../templates/header.php'; ?>

    <main class="product-detail">
        <a href="index.php?controller=product&action=index">← Back to menu</a>

        <section class="product-detail-layout">
            <div class="product-detail-image">
                <?php if (file_exists($imagePath)): ?>
                    <img src="<?= $imageUrl ?>" alt="<?= escapeProductValue($product->getName()) ?>">
                <?php else: ?>
                    <div class="image-placeholder">Image coming soon</div>
                <?php endif; ?>
            </div>

            <div class="product-detail-info">
                <p class="category-name"><?= escapeProductValue($product->getCategory()) ?></p>
                <h1><?= escapeProductValue($product->getName()) ?></h1>
                <p class="product-price" id="price"><?= number_format($product->getPrice(), 2) ?>€</p>
                <p><?= escapeProductValue($product->getDescription()) ?></p>

                <form action="index.php?controller=cart&action=add" method="post">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

                    <fieldset>
                        <legend>Choose your ingredients</legend>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <div class="ingredient-option">
                                <input type="checkbox" id="ingredient_<?= $ingredient->getId() ?>" name="ingredients[]" value="<?= $ingredient->getId() ?>">
                                <label for="ingredient_<?= $ingredient->getId() ?>"><?= escapeProductValue($ingredient->getName()) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>

                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1">

                    <button type="submit" class="cart-button">Add to cart</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
