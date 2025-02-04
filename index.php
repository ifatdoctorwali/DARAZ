<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daraz Clone - Online Shopping</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
        }

        /* Header / Navbar */
        .navbar {
            background-color: #ff6700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 8px 15px;
            background-color: #d35400;
            border-radius: 5px;
        }

        .nav-links a:hover {
            background-color: #b33c00;
        }

        /* Banner */
        .banner {
            width: 100%;
            max-height: 400px;
        }

        .banner img {
            width: 100%;
            object-fit: cover;
        }

        /* Product Grid */
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .product {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product img {
            width: 100%;
            max-height: 250px;
            object-fit: contain;
            border-radius: 10px;
            display: block;
        }

        .product h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .product p {
            font-size: 16px;
            color: #ff6700;
            font-weight: bold;
        }

        .product button {
            background-color: #ff6700;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        .product button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Daraz Clone</div>
        <div class="nav-links">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner">
        <img src="https://source.unsplash.com/1200x400/?shopping,ecommerce" alt="Shopping Banner">
    </div>

    <!-- Products Section -->
    <div class="product-container">
        <?php
        // Expensive Products with Real Images
        $products = [
            ["name" => "Apple iPhone 14 Pro Max", "price" => 1499, "image" => "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-14-pro-finish-unselect-gallery-1-202209_GEO_US?wid=400&hei=400&fmt=jpeg&qlt=95&.v=1670857326129"],
            ["name" => "Samsung Galaxy S23 Ultra", "price" => 1399, "image" => "https://images.samsung.com/us/smartphones/galaxy-s23-ultra/buy/S23_Ultra_Carousel_Image1.jpg"],
            ["name" => "MacBook Pro M2", "price" => 2499, "image" => "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp16-spacegray-gallery1-202301?wid=400&hei=400&fmt=jpeg&qlt=95&.v=1671304673229"],
            ["name" => "Sony PlayStation 5", "price" => 799, "image" => "https://cdn.vox-cdn.com/thumbor/4MlK8AV0_L0kWnrs_lXjM8Oxv4k=/0x0:1320x880/1400x1400/filters:focal(660x440:661x441)/cdn.vox-cdn.com/uploads/chorus_asset/file/22276771/PS5__4_.jpg"],
            ["name" => "Rolex Submariner", "price" => 12999, "image" => "https://www.rolex.com/content/dam/rolexcom/ecom-configurator-submariner-41-black/Oyster-M-41-126610LV-0002.jpg"],
            ["name" => "Gucci Leather Handbag", "price" => 3499, "image" => "https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1661358359/726497_AABRZ_9022_001_100_0000_Light-Gucci-Bamboo-1947-mini-top-handle-bag.jpg"],
            ["name" => "Apple iPad Pro 12.9", "price" => 1199, "image" => "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/ipad-pro-12-9-2021-gallery-1?wid=400&hei=400&fmt=jpeg&qlt=95&.v=1620518077000"],
            ["name" => "Bose Noise Cancelling Headphones", "price" => 499, "image" => "https://www.bose.com/content/dam/Bose_DAM/Web/consumer_electronics/global/products/headphones/noise_cancelling_headphones_700/qc700_black_EC.psd/jcr:content/renditions/cq5dam.web.320.320.png"]
        ];

        foreach ($products as $product) {
            echo "<div class='product'>";
            echo "<img src='{$product['image']}' alt='{$product['name']}'>";
            echo "<h3>{$product['name']}</h3>";
            echo "<p>\${$product['price']}</p>";
            echo "<button>Add to Cart</button>";
            echo "</div>";
        }
        ?>
    </div>

</body>
</html>
