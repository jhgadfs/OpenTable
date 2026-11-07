USE MRestrDB;

START TRANSACTION;

-- Ingredients used by the additional dishes.
INSERT INTO ingredientes (nombre, precio_extra, activo)
VALUES
    ('Parmesan cheese', 1.50, TRUE),
    ('Chicken', 2.50, TRUE),
    ('Mushrooms', 1.00, TRUE),
    ('Rice', 1.00, TRUE),
    ('Garlic', 0.40, TRUE),
    ('Tomato', 0.60, TRUE),
    ('Feta cheese', 1.40, TRUE),
    ('Lettuce', 0.40, TRUE),
    ('Rosemary', 0.50, TRUE),
    ('Lemon', 0.50, TRUE),
    ('Cream', 0.80, TRUE),
    ('Potatoes', 1.00, TRUE),
    ('Mint', 0.50, TRUE)
ON DUPLICATE KEY UPDATE
    precio_extra = VALUES(precio_extra),
    activo = VALUES(activo);

-- Additional products. Images are intentionally left NULL for now.
INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Crispy garlic bread', 'Toasted bread with garlic, olive oil, and fresh herbs.', 5.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Starters'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Crispy garlic bread'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Mediterranean salad', 'Fresh lettuce, tomato, olives, and feta cheese.', 8.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Starters'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Mediterranean salad'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Herb roasted chicken', 'Roasted chicken with potatoes, rosemary, and seasonal vegetables.', 16.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Main courses'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Herb roasted chicken'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Creamy mushroom risotto', 'Italian rice cooked with mushrooms, cream, and parmesan.', 14.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Main courses'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Creamy mushroom risotto'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Lemon cheesecake', 'Smooth cheesecake with fresh lemon and a biscuit base.', 6.80, TRUE
FROM categorias AS c
WHERE c.nombre = 'Desserts'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Lemon cheesecake'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
SELECT c.id, 'Sparkling lemonade', 'Fresh homemade lemonade with lemon and sparkling water.', 4.00, TRUE
FROM categorias AS c
WHERE c.nombre = 'Drinks'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Sparkling lemonade'
  );

-- Link products with their default ingredients.
-- INSERT IGNORE makes this section safe to run again.
INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Garlic', 'Rosemary')
WHERE p.nombre = 'Crispy garlic bread';

INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Lettuce', 'Tomato', 'Olives', 'Feta cheese')
WHERE p.nombre = 'Mediterranean salad';

INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Chicken', 'Rosemary', 'Potatoes')
WHERE p.nombre = 'Herb roasted chicken';

INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Mushrooms', 'Cream', 'Parmesan cheese', 'Rice')
WHERE p.nombre = 'Creamy mushroom risotto';

INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Cream', 'Lemon')
WHERE p.nombre = 'Lemon cheesecake';

INSERT IGNORE INTO producto_ingrediente (producto_id, ingrediente_id, cantidad)
SELECT p.id, i.id, 1
FROM productos AS p
INNER JOIN ingredientes AS i ON i.nombre IN ('Lemon', 'Mint')
WHERE p.nombre = 'Sparkling lemonade';

COMMIT;

-- Verification query.
SELECT
    p.id,
    c.nombre AS category,
    p.nombre AS product,
    p.precio,
    GROUP_CONCAT(i.nombre ORDER BY i.nombre SEPARATOR ', ') AS ingredients
FROM productos AS p
INNER JOIN categorias AS c ON c.id = p.categoria_id
LEFT JOIN producto_ingrediente AS pi ON pi.producto_id = p.id
LEFT JOIN ingredientes AS i ON i.id = pi.ingrediente_id
WHERE p.nombre IN (
    'Crispy garlic bread',
    'Mediterranean salad',
    'Herb roasted chicken',
    'Creamy mushroom risotto',
    'Lemon cheesecake',
    'Sparkling lemonade'
)
GROUP BY p.id, c.nombre, p.nombre, p.precio
ORDER BY c.nombre, p.nombre;
