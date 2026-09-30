<?php

use App\Http\Request;
use Controllers\AuthController;
use Controllers\CartController;
use Controllers\ProductController;
use Middleware\Auth;
use Middleware\Guest;
use Model\CartsRepo;
use Model\Database;
use Dotenv\Dotenv;
use Model\ProductsRepo;
use Model\UsersRepo;
use Services\AdminService;
use Services\AuthService;
use Services\CartService;
use Src\MiddlewareRegistry;
use Src\Router;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . "./../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$conn = Database::createFromEnv()->conn;

$request = Request::createFromGlobal();
$authController = new AuthController(
    $request,
    new AuthService(new UsersRepo($conn)),
);

$cartController = new CartController(
    $request,
    new CartService(new CartsRepo($conn))
);

$productController = new ProductController(
    $request,
    new AdminService(new ProductsRepo($conn))
);

MiddlewareRegistry::registerMiddleware("auth", [Auth::class, "handle"]);
MiddlewareRegistry::registerMiddleware("guest", [Guest::class, "handle"]);

Router::post("/register", function() use ($authController) {
    $response = $authController->registerNewUser();
    $response->send();
}, "guest");

Router::post("/login", function() use ($authController) {
    $response = $authController->login();
    $response->send();
}, "guest");

Router::post("/cart/add", function() use ($cartController) {
    $response = $cartController->addItem();
    $response->send();
}, "auth");

Router::post("/cart/remove", function() use ($cartController) {
    $response = $cartController->removeItem();
    $response->send();
}, "auth");

Router::get("/cart", function() use ($cartController) {
    $response = $cartController->showList();
    $response->send();
}, "auth");

Router::post("/cart/pay", function() {

}, "auth");

Router::post("/products/add", function() use ($productController) {
    $response = $productController->addProduct();
    $response->send();
}, "auth");

Router::post("/products/delete", function() use ($productController) {
    $response = $productController->deleteProduct();
    $response->send();
}, "auth");

Router::post("/products/update", function() use ($productController) {
    $response = $productController->updateProduct();
    $response->send();
}, "auth");

Router::run($request);
