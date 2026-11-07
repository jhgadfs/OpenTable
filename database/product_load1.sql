USE MRestrDB;

START TRANSACTION;

-- Categories are required because productos.categoria_id is a foreign key.
INSERT INTO categorias (nombre, descripcion, activa)
VALUES
    ('Starters', 'Small dishes to share before the main course.', TRUE),
    ('Main courses', 'Hearty dishes inspired by different cuisines.', TRUE),
    ('Desserts', 'Sweet dishes to finish the meal.', TRUE),
    ('Drinks', 'Cold and hot drinks.', TRUE)
ON DUPLICATE KEY UPDATE
    descripcion = VALUES(descripcion),
    activa = VALUES(activa);

-- imagen is intentionally omitted. It will remain NULL until images are added.
-- Each INSERT checks the product name so the script can be run again safely.
INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Mediterranean hummus', 'Creamy hummus with olive oil, paprika, and toasted bread.', 7.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Starters'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Mediterranean hummus'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Creamy chicken curry', 'Spiced chicken with rice, fresh vegetables, and coriander.', 13.90, TRUE
FROM categorias AS c
WHERE c.nombre = 'Main courses'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Creamy chicken curry'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Creamy basil pasta', 'Fresh pasta with creamy sauce, basil, and parmesan.', 12.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Main courses'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Creamy basil pasta'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Asian vegetable bowl', 'Rice, crunchy vegetables, and a lightly sweet soy sauce.', 11.90, TRUE
FROM categorias AS c
WHERE c.nombre = 'Main courses'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Asian vegetable bowl'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Chocolate cake', 'Rich chocolate cake with a soft and creamy texture.', 6.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Desserts'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Chocolate cake'
  );

INSERT INTO productos (categoria_id, nombre, descripcion, precio, activo)
    SELECT c.id, 'Homemade lemonade', 'Fresh lemonade made with natural lemon and mint.', 3.50, TRUE
FROM categorias AS c
WHERE c.nombre = 'Drinks'
  AND NOT EXISTS (
      SELECT 1 FROM productos WHERE nombre = 'Homemade lemonade'
  );

COMMIT;

-- Verification query: image should be NULL for these seed products.
SELECT
    p.id,
    c.nombre AS categoria,
    p.nombre,
    p.precio,
    p.imagen,
    p.activo
FROM productos AS p
INNER JOIN categorias AS c ON c.id = p.categoria_id
WHERE p.nombre IN (
    'Mediterranean hummus',
    'Creamy chicken curry',
    'Creamy basil pasta',
    'Asian vegetable bowl',
    'Chocolate cake',
    'Homemade lemonade'
)
ORDER BY c.nombre, p.nombre;
