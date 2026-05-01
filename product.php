<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: productlogin.html");
    exit();
}
$uid = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FashionHub | Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; margin: 0; padding: 0; }
        
        .top-nav {
            background: #1e293b;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #fbbf24;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .welcome-text { color: #f8fafc; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; }
        .welcome-text span { color: #fbbf24; }

        .cart-link { 
            color: #1e293b; 
            text-decoration: none; 
            font-weight: 800; 
            font-size: 0.8rem; 
            display: flex; 
            align-items: center; 
            gap: 8px;
            background: #fbbf24;
            padding: 8px 20px;
            border-radius: 4px;
            transition: 0.3s;
        }
        .cart-link:hover { background: #ffffff; color: #1e293b; }

        .hero {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('perfume1.jpg');
            background-size: cover;
            background-position: center;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fbbf24;
            text-align: center;
            margin-bottom: 40px;
        }
        .hero h1 { font-size: 3rem; margin: 0; letter-spacing: 2px; text-transform: uppercase; font-weight: 800; }
        .hero p { font-size: 1.1rem; opacity: 0.9; margin-top: 10px; color: #fff; }
        
        .container { padding: 0 40px 40px 40px; }

        .category-section { margin-bottom: 50px; }
        .category-title { 
            font-size: 1.1rem;
            border-bottom: 3px solid #1e293b;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 25px; 
            color: #1e293b;
            font-weight: 800;
            text-transform: uppercase;
        }

        .product-grid { 
            display: grid; 
            grid-template-columns: repeat(5, 1fr); 
            gap: 20px; 
        }

        .card { 
            background: #fff; 
            border-radius: 12px; 
            padding: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 12px 20px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
        
        .product-name { font-size: 0.9rem; font-weight: 700; margin: 10px 0 5px 0; height: 40px; overflow: hidden; color: #1e293b; }
        .price { color: #f43f5e; font-weight: 800; font-size: 1.1rem; margin-bottom: 10px; }

        .stock-info { font-size: 0.75rem; margin-bottom: 15px; font-weight: 600; }
        .in-stock { color: #10b981; }
        .out-of-stock { color: #ef4444; }

        .btn-group { display: flex; flex-direction: column; gap: 8px; margin-top: auto; }
        .btn { 
            text-decoration: none; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 0.75rem; 
            font-weight: 800;
            transition: 0.3s;
            text-align: center;
            text-transform: uppercase;
        }
        .btn-view { background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; }
        .btn-cart { background: #1e293b; color: #fbbf24; border: none; cursor: pointer; width: 100%; }
        .btn-cart:hover { background: #0f172a; color: #fff; }

        @media (max-width: 1200px) { .product-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width: 900px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

<div class="top-nav">
    <div class="welcome-text">
        <i class="bi bi-person-circle me-1"></i> WELCOME TO <span>FASHIONHUB</span>
    </div>
    <a href="cart.php" class="cart-link">
        <i class="bi bi-bag-heart-fill"></i> MY BAG
    </a>
</div>

<div class="hero">
    <h1>FashionHub</h1>
    <p>Discover the Latest Trends & Styles</p>
</div>

<div class="container">
<?php
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

$folder = "foldernew/"; 
$cat_query = mysqli_query($conn, "SELECT DISTINCT category FROM addproduct");

while ($cat_row = mysqli_fetch_assoc($cat_query)) {
    $current_cat = $cat_row['category'];
?>
    <div class="category-section">
        <h2 class="category-title"><?php echo htmlspecialchars($current_cat); ?></h2>
        
        <div class="product-grid">
            <?php
            $safe_cat = mysqli_real_escape_string($conn, $current_cat);
            $prod_query = mysqli_query($conn, "SELECT * FROM addproduct WHERE category = '$safe_cat' ORDER BY product_id DESC");
            
            while ($di = mysqli_fetch_assoc($prod_query)) {
                $stock_status = ($di['stock'] > 0) ? '<span class="in-stock">● In Stock</span>' : '<span class="out-of-stock">● Out of Stock</span>';
                $final_src = $folder . basename(trim($di['image1']));
            ?>
                <div class="card">
                    <img src="<?php echo $final_src; ?>" alt="Product" onerror="this.src='https://via.placeholder.com/200x180?text=No+Image';">
                    
                    <div class="product-name"><?php echo htmlspecialchars($di['productname']); ?></div>
                    <div class="price">$<?php echo number_format($di['price'], 2); ?></div>
                    
                    <div class="stock-info"><?php echo $stock_status; ?></div>

                    <div class="btn-group">
                        <a href="productdetails.php?id=<?php echo $di['product_id']; ?>" class="btn btn-view">View Details</a>
                        
                        <form action="addtocart.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="id" value="<?php echo $di['product_id']; ?>">
                            <button type="submit" class="btn btn-cart" <?php echo ($di['stock'] <= 0) ? 'disabled style="opacity:0.5;"' : ''; ?>>
                                <?php echo ($di['stock'] > 0) ? 'Add To Cart' : 'Sold Out'; ?>
                            </button>
                        </form>
                    </div>
                </div>   
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
mysqli_close($conn);
?>
</div>

</body>
</html>