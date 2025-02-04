<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $item = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ];

    $_SESSION['cart'][$id] = $item;
    header("Location: cart.php");
    exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Reset some styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Cart Container Styling */
        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .cart-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table Styling */
        .cart-container table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-container table th,
        .cart-container table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .cart-container table th {
            background: #007bff;
            color: #fff;
        }

        /* Action Buttons Styling */
        .remove-btn, .clear-btn {
            display: inline-block;
            padding: 8px 12px;
            background: red;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .clear-btn {
            background: #555;
            margin: 0 auto;
            display: block;
            width: fit-content;
        }

        .cart-container p {
            text-align: center;
            font-size: 16px;
        }

        .cart-container h3 {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Shopping Cart</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php 
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $total = $item['price'] * $item['quantity'];
                    $grandTotal += $total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>$<?= number_format($total, 2) ?></td>
                    <td>
                        <a href="cart.php?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3>Total: $<?= number_format($grandTotal, 2) ?></h3>
            <a href="cart.php?clear=true" class="clear-btn">Clear Cart</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
