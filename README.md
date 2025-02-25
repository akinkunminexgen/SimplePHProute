# SimplePHProute
This is a simple php route

This is a simple example of a PHP router that maps URL routes to specific actions or views. The router uses namespaces to organize different parts of the application.

### Middleware
To use middleware in the Route::group, it must be the same name as the filename (.php), so as to execute the task needed

# No dependencies
This simply uses the core php (without any library) by using the Routes class defined in this project and other relevant classes etc. with the aid of autoloading to properly configure all classes.


# 🚦 **SimplePHProute Library**

A **simple and flexible routing library** for **PHP** applications, following the **MVC architecture**. This library provides **support for grouping routes**, **middleware integration**, and **namespace management**.

---

## 🗂️ **Folder Structure:**

```
SimplePHPRoute/
├── Classes/
│   ├── Controller.php     # Base Controllers class
│   ├── Model.php          # Base Models class
│   ├── Views/             # Views (e.g., index.php, 404.php)
│   └── Routes/            # Application routes (e.g., routes.php)
├── config/
│   ├── Request.php        # Request handling class
│   ├── Database.php       # Database connection class
│   └── Routes.php         # This is the base route Class
├── Controllers/
│   ├── Backpages/         # folder to show how to call the class since it is not autoloaded
│   ├── Frontpages/        # folder to show how to call the class since it is not autoloaded
│   ├── ProductController  # To show how controller works inheriting from the Controller class
│   ├── View.php           # View rendering class
│   └── Middleware.php     # Middleware base class
|── Models/
|    ├── Product.php        # inheriting from Model class
├── src/
│   ├── Middleware/        # where all middleware are located
├── views/                  
│   ├── products/          # Views (e.g., index.php and other relevant files related to product)
│   ├── index.php          # Where views can begin with
│   ├── 404.php            # For handling eror not found
│─────── Routes.php        # where all routes are called (the index.php file is where execution starts from then to this Routes)
```

---

## 🚀 **Getting Started:**

### 1. **Installation:**

```bash
git clone https://github.com/akinkunminexgen/SimplePHProute.git
cd php-route-library
```

---

### 2. **Setup:**

- **Ensure the **``** file** is set up for **URL rewriting**:

```follow the one in .htaccess
```

- **Set up the front controller:**

```php
// public/index.php

require_once __DIR__ . '/index.php'; // Autoload dependencies

use Route;

// Load application routes
require_once __DIR__ . '/routes.php';

// Start the routing process
Route::populate();
```

---

## 🛠️ **Example of Route Definitions:**

```php
use Frontpages\History as FHistory;
use Backpages\History as BHistory;
use Frontpages\{AboutUs, Authors, ContactUs};

Routes::get('', function() {
    IndexController::CreateView('Index');
});

Routes::group(['prefix' => 'products'], function() {
    Routes::get('/', function($route) {
        ProductController::CreateView($route);
    });
    Routes::groupEnd();
});

Routes::enableMiddleware();
Routes::group(['prefix' => 'backpages', 'middleware' => 'auth;role'], function() {
    Routes::get('history', function($go) {
        BHistory::CreateView($go);
    });

    Routes::group(['prefix' => 'colorpatterns'], function() {
        Routes::get('red', function($go) {
            IndexController::CreateView($go);
        });
        Routes::get('blue', function($go) {
            IndexController::CreateView($go);
        });
    });

    Routes::groupEnd();
});
```

---

## 🧬 **Features:**

- **Simple and Clean Routing Syntax**
- **Route Grouping & Prefixing**
- **Middleware Support** (Multiple Middleware: `e.g auth;role`)
- **MVC Structure Compatibility**
- **Namespaces for Class Management**
- **404 Error Handling**

---

## 🛡️ **Middleware Example:**

```php
AuthMiddleware::handle($request);
```

---

## 📌 **Usage Tips:**

- **Always call **`` before declaring **middleware-based groups**.
- **To add multiple middleware**, use **semicolon-separated strings**, e.g., ``.
- **Group routes** logically using `` to maintain **clean code**.

---

## 📄 **License:**

This project is licensed under the **MIT License** - see the **LICENSE.md** file for details.

---

## 🤝 **Contributing:**

Feel free to **fork this repository**, **create a branch**, and **submit a pull request**. Your contributions are **welcome!**

---

## 🙋 **Support:**

For **issues** or **feature requests**, please **open an issue** on **GitHub**.

---

