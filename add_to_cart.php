<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['products'])) {
        echo "No products selected. <a href='milk_products.php'>Go back</a>";
        exit();
    }

    // Initialize the cart if not already
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_POST['products'] as $productId) {
        $quantity = $_POST['quantity'][$productId];
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    header("Location: view_cart.php");
    exit();
}
