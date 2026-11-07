## Versión en español

# Aplicación web para restaurantes: OpenTable

OpenTable es una aplicación web para restaurantes desarrollada como proyecto práctico para el curso DAW2. La aplicación permite a los clientes explorar los productos del restaurante, ver sus detalles, personalizar los ingredientes, añadir artículos al carrito de la compra y completar un pedido.

El proyecto se ha desarrollado utilizando PHP, MySQL, PDO, HTML, CSS, JavaScript, Bootstrap y una arquitectura MVC (Modelo-Vista-Controlador).

## Objetivos del proyecto

Los objetivos principales de este proyecto son:

- Crear un sitio web de restaurante para los clientes.
- Conectar el sitio web a una base de datos MySQL.
- Organizar el código siguiendo el patrón Modelo-Vista-Controlador (MVC).
- Utilizar PHP orientado a objetos.
- Mostrar productos y categorías provenientes de la base de datos.
- Permitir a los clientes ver los detalles de los productos y seleccionar ingredientes.
- Implementar un carrito de la compra basado en sesiones.
- Crear un proceso de realización de pedidos y pago (checkout).
- Hacer que el sitio web sea adaptable (responsive) tanto para escritorio como para dispositivos móviles.

## Tecnologías

- PHP
- MySQL
- PDO
- HTML5
- CSS3
- JavaScript
- Bootstrap
- Docker para el entorno de base de datos
- XAMPP para el desarrollo local con PHP y Apache

## Estructura MVC

El proyecto organiza sus responsabilidades según el patrón MVC de la siguiente manera:

Index.php
-> Recibe la solicitud y selecciona el controlador y la acción correspondientes.

controllers/
-> Gestiona las solicitudes y coordina la lógica de la aplicación.

models/
-> Representa los objetos de la aplicación y contiene las clases de acceso a la base de datos.

views/
-> Contiene el código HTML que se muestra al usuario.

config/
-> Contiene la configuración de la base de datos y de la aplicación.

public/
-> Contiene los recursos públicos, como archivos CSS, JavaScript e imágenes.


El flujo habitual de una solicitud es:


Solicitud desde el navegador
-> Index.php
-> Controlador
-> Modelo o DAO
-> Base de datos
-> Vista
-> Respuesta HTML


Por ejemplo, la página de productos sigue este flujo:

Index.php?controller=product&action=index
-> ProductController::index()
-> ProductDAO
-> Objetos de tipo producto creados mediante `fetchObject()`
-> views/products/list.php


## Base de datos

La aplicación utiliza la base de datos MySQL llamada `MRestrDB`. Las tablas principales de la base de datos son:

- `usuarios`
- `categorias`
- `productos`
- `ingredientes`
- `producto_ingrediente`
- `ofertas`
- `oferta_producto`
- `pedidos`
- `pedido_detalle`
- `pedido_detalle_ingrediente`

La conexión a la base de datos está configurada en:

config/Database.php


Antes de ejecutar los scripts de carga de datos (*seed scripts*), crea las tablas de la base de datos utilizando el esquema base proporcionado para el proyecto. A continuación, ejecuta dichos scripts en MySQL Workbench o en cualquier otro cliente de MySQL.

Orden recomendado:

1. Crea el esquema de la base de datos.
2. Ejecuta `categories_ingredients_load.sql`.
3. Ejecuta `product_load1.sql`.
4. Ejecuta `product_load2.sql`.

Las credenciales de la base de datos deben configurarse localmente y no deben subirse a un repositorio público.

## Ejecución del proyecto en local

1. Inicia Apache y PHP a través de XAMPP.
2. Inicia el contenedor de la base de datos MySQL o el servidor MySQL.
3. Verifica que el nombre de la base de datos y las credenciales en `config/Database.php` sean correctos.
4. Coloca el proyecto dentro del directorio `htdocs` de XAMPP.
5. Abre la aplicación en un navegador:

http://localhost/OpenTable/Index.php


La URL raíz abre la página de inicio. Actualmente, esta página contiene el encabezado y la navegación compartidos, mientras que las funcionalidades relacionadas con los productos y el carrito de compras se encuentran en desarrollo.

## Rutas principales

La aplicación utiliza los parámetros de consulta (*query parameters*) `controller` y `action`. ### Inicio

http://localhost/OpenTable/index.php?controller=home&action=index


### Productos


[Index.php?controller=product&action=index](http://localhost/OpenTable/index.php?controller=product&action=index)
[Index.php?controller=product&action=index&page=1](http://localhost/OpenTable/index.php?controller=product&action=index&page=1)
[Index.php?controller=product&action=index&categoria_id=2](http://localhost/OpenTable/index.php?controller=product&action=index&page=1&categoria_id=2)


### Detalles del producto


[Index.php?controller=product&action=show&id=1](http://localhost/OpenTable/index.php?controller=product&action=show&id=7)



## English version

# OpenTable Restaurant Web Application

OpenTable is a restaurant web application developed as a DAW2 practice project. The application allows customers to browse restaurant products, view product details, customise ingredients, add products to a shopping cart, and complete an order.

The project is being developed using PHP, MySQL, PDO, HTML, CSS, JavaScript, Bootstrap, and an MVC architecture.

## Project goals

The main goals of this project are:

- Build a restaurant website for customers.
- Connect the website to a MySQL database.
- Organise the code using the Model-View-Controller pattern.
- Use object-oriented PHP.
- Display products and categories from the database.
- Allow customers to view product details and select ingredients.
- Create a session-based shopping cart.
- Create an order and checkout process.
- Make the website responsive for desktop and mobile screens.

## Technologies

- PHP
- MySQL
- PDO
- HTML5
- CSS3
- JavaScript
- Bootstrap
- Docker for the database environment
- XAMPP for local PHP and Apache development

## MVC structure

The project uses the following MVC responsibilities:

Index.php
    -> Receives the request and selects a controller and action.

controllers/
    -> Handles requests and coordinates the application logic.

models/
    -> Represents application objects and contains database-access classes.

views/
    -> Contains the HTML shown to the user.

config/
    -> Contains database and application configuration.

public/
    -> Contains public assets such as CSS, JavaScript, and images.


The normal request flow is:


Browser request
    -> Index.php
    -> Controller
    -> Model or DAO
    -> Database
    -> View
    -> HTML response


For example, the products page follows this flow:

Index.php?controller=product&action=index
    -> ProductController::index()
    -> ProductDAO
    -> Product objects created with fetchObject()
    -> views/products/list.php


## Database

The application uses the `MRestrDB` MySQL database.

The main database tables are:

- `usuarios`
- `categorias`
- `productos`
- `ingredientes`
- `producto_ingrediente`
- `ofertas`
- `oferta_producto`
- `pedidos`
- `pedido_detalle`
- `pedido_detalle_ingrediente`

The database connection is configured in:

config/Database.php


Before running the seed scripts, create the database tables using the base database schema supplied for the project. Then execute the seed scripts in MySQL Workbench or another MySQL client.

Recommended order:

1. Create the database schema.
2. Run `categories_ingredients_load.sql`.
3. Run `product_load1.sql`.
4. Run `product_load2.sql`.

Database credentials should be configured locally and should not be committed to a public repository.

## Running the project locally

1. Start Apache and PHP through XAMPP.
2. Start the MySQL database container or MySQL server.
3. Confirm that the database name and credentials in `config/Database.php` are correct.
4. Place the project inside the XAMPP `htdocs` directory.
5. Open the application in a browser:

http://localhost/OpenTable/Index.php


The root URL opens the home page. The home page currently contains the shared header and navigation while the product and cart features are being developed.

## Main routes

The application uses the `controller` and `action` query parameters.

### Home

http://localhost/OpenTable/index.php?controller=home&action=index


### Products


[Index.php?controller=product&action=index](http://localhost/OpenTable/index.php?controller=product&action=index)
[Index.php?controller=product&action=index&page=1](http://localhost/OpenTable/index.php?controller=product&action=index&page=1)
[Index.php?controller=product&action=index&categoria_id=2](http://localhost/OpenTable/index.php?controller=product&action=index&page=1&categoria_id=2)


### Product details


[Index.php?controller=product&action=show&id=1](http://localhost/OpenTable/index.php?controller=product&action=show&id=7)

