USE MRestrDB;

START TRANSACTION;

-- Categories used by the products page.
-- The UNIQUE constraint on categorias.nombre prevents duplicates.
INSERT INTO categorias (nombre, descripcion, activa)
VALUES
    ('Starters', 'Small dishes to share before the main course.', TRUE),
    ('Main courses', 'Hearty dishes inspired by different cuisines.', TRUE),
    ('Desserts', 'Sweet dishes to finish the meal.', TRUE),
    ('Drinks', 'Cold and hot drinks.', TRUE)
ON DUPLICATE KEY UPDATE
    descripcion = VALUES(descripcion),
    activa = VALUES(activa);

-- Base ingredients for future product customization.
-- The UNIQUE constraint on ingredientes.nombre prevents duplicates.
INSERT INTO ingredientes (nombre, precio_extra, activo)
VALUES
    ('Parmesan cheese', 1.50, TRUE),
    ('Mozzarella cheese', 1.25, TRUE),
    ('Avocado', 1.80, TRUE),
    ('Chicken', 2.50, TRUE),
    ('Prawns', 3.00, TRUE),
    ('Mushrooms', 1.00, TRUE),
    ('Caramelized onion', 1.20, TRUE),
    ('Olives', 0.80, TRUE),
    ('Hot sauce', 0.50, TRUE),
    ('Toasted bread', 0.75, TRUE)
ON DUPLICATE KEY UPDATE
    precio_extra = VALUES(precio_extra),
    activo = VALUES(activo);

COMMIT;

-- Verification queries.
SELECT id, nombre, descripcion, activa
FROM categorias
ORDER BY nombre;

SELECT id, nombre, precio_extra, activo
FROM ingredientes
ORDER BY nombre;
