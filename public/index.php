<?php

use App\Http\Request;
use Controllers\AuthController;
use Controllers\CartController;
use Controllers\ProductController;
use Model\CartsRepo;
use Model\UsersRepo;
use Services\AuthService;
use Services\CartService;
use Src\Router;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . "./../vendor/autoload.php";

$request = Request::createFromGlobal();
$authController = new AuthController(
    $request,
    new AuthService(new UsersRepo),
);

$cartController = new CartController(
    $request,
    new CartService(new CartsRepo)
);

$productController = new ProductController();

Router::post("/register", function() use ($authController) {
    $response = $authController->registerNewUser();
    $response->send();
});

Router::post("/login", function() use ($authController) {
    $response = $authController->login();
    $response->send();
});

Router::post("/cart/add", function() use ($cartController) {
    $response = $cartController->addItem();
    $response->send();
}, "auth");

Router::post("/cart/remove", function() use ($cartController) {
    $response = $cartController->removeItem();
    $response->send();
}, "auth");

Router::post("/cart", function() use ($cartController) {
    $response = $cartController->showList();
    $response->send();
}, "auth");

Router::post("/cart/pay", function() {

}, "auth");

Router::post("/poducts/add", function() use ($productController) {
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

Router::run();
