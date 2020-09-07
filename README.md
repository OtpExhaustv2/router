# Router

## Installation
```bash
composer require svv/router:^1.0.5
```

## Arborescence

- public
  - index.php
- src
  - Controller
    - HomeController.php
    
## Usage

1. First param is the url that will be matched and the second is the namespace of your classes
2. First param is the path, second the callback and the third is the name
   - If the name is null, then the name of the route will be the callback
3. You can change the regular expression for type hinting with the method ***with***
```php
$router = new Svv\Router($_SERVER["REQUEST_URI"], "App\\");

$router->get("/home", "Home#index");
$router->post("/home", "Home#index");

$router->get("/post/{slug}-{id}", "Post#show", "post.show")
       ->with("id", "[0-9]+")
       ->with("slug", "[a-zA-Z0-9\-]+");

$router->run();
```

