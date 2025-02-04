<?php
session_start();
require 'db.php'; // Ensure this file contains your PDO connection (if needed for further operations)

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Initialize the cart session if not already set
if (!issaet($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// --- CART FUNCTIONALITY ---

// Add to cart (handle form POST submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = (int) $_POST['quantity'];
    
    // If product already exists in the cart, update the quantity
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'id'       => $id,
            'name'     => $name,
            'price'    => $price,
            'quantity' => $quantity
        ];
    }
    // Refresh the page to reflect changes
    header("Location: dashboard.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: dashboard.php");
    exit();
}

// Clear the entire cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: dashboard.php");
    exit();
}

// Sample product list (in a real application, these might come from a database)
$products = [
    ['id' => 1, 'name' => 'Product 1', 'price' => 10.00],
    ['id' => 2, 'name' => 'Product 2', 'price' => 20.00],
    ['id' => 3, 'name' => 'Product 3', 'price' => 30.00],
];

$username = htmlspecialchars($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard & Cart</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2, h3 {
            color: #333;
        }
        a {
            text-decoration: none;
        }
        /* Dashboard container */
        .dashboard-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #dc3545;
            color: #fff;
            border-radius: 4px;
        }
        /* Product list styling */
        .products {
            display: flex;
            justify-content: space-around;
            margin-bottom: 40px;
        }
        .product {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 28%;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .product h3 {
            margin-top: 0;
        }
        .product form input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-bottom: 10px;
        }
        .product form input[type="submit"] {
            padding: 8px 12px;
            background: #28a745;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        /* Cart styling */
        .cart-container {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .cart-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .cart-container th, .cart-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .cart-container th {
            background: #007bff;
            color: #fff;
        }
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
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome">
            <h2>Welcome, <?= $username ?>!</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Product List Section -->
        <h3>Products</h3>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p>Price: $<?= number_format($product['price'], 2) ?></p>
                    <form action="dashboard.php" method="post">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <label for="quantity_<?= $product['id'] ?>">Quantity:</label>
                        <input type="number" id="quantity_<?= $product['id'] ?>" name="quantity" value="1" min="1" required>
                        <br>
                        <input type="submit" name="add_to_cart" value="Add to Cart">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Cart Section -->
        <div class="cart-container">
            <h3>Your Shopping Cart</h3>
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
                            <a href="dashboard.php?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <h3>Total: $<?= number_format($grandTotal, 2) ?></h3>
                <a href="dashboard.php?clear=true" class="clear-btn">Clear Cart</a>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
