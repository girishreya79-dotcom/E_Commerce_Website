<?php 
session_start(); 
if (!isset($_SESSION["xx"])) { header("Location: userlogin.php"); exit(); }

$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Collection | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fdf2f5; }
        .navbar { background-color: #ffb6c1 !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); height: 55px; }
        .navbar-brand { font-family: 'Lobster', cursive !important; font-size: 26px; }
        
        /* Smaller Category Font */
        .category-title { 
            font-weight: 600; 
            color: #4b0082; 
            border-left: 4px solid #d81b60; 
            padding-left: 12px; 
            margin: 30px 0 15px; 
            text-transform: uppercase; 
            font-size: 0.9rem; /* Smaller Font Size */
            letter-spacing: 1px;
        }

        .product-card {
            background: #fff; border-radius: 15px; overflow: hidden; border: none;
            transition: 0.3s; height: 100%; display: flex; flex-direction: column;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .product-card:hover { transform: translateY(-7px); box-shadow: 0 12px 25px rgba(216, 27, 96, 0.12); }
        
        .img-container { height: 210px; position: relative; background: #eee; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }

        .card-body { padding: 12px; flex-grow: 1; }
        .product-name { font-size: 14px; font-weight: 600; margin-bottom: 5px; color: #333; }
        .price-text { color: #d81b60; font-weight: 700; font-size: 1rem; }

        .btn-group-custom { display: flex; gap: 5px; padding: 0 12px 12px; }
        .btn-custom { font-size: 12px; font-weight: 600; border-radius: 8px; flex: 1; padding: 7px; }
        .btn-view { background: #f8f9fa; color: #333; border: 1px solid #ddd; }
        .btn-add { background: #d81b60; color: white; border: none; }
    </style>
</head>
<body>

<nav class="navbar fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="userpanel.php"><span style="color:#d81b60">Fashion</span><span style="color:#4b0082">Hub</span></a>
        <a href="usercart.php" class="text-dark"><i class="bi bi-bag-heart fs-4"></i></a>
    </div>
</nav>

<div class="container mt-5 pt-3">
    <?php
    $cat_query = mysqli_query($conn, "SELECT DISTINCT category FROM addproduct");
    while ($cat = mysqli_fetch_array($cat_query)) {
        $current_cat = $cat['category'];
        echo "<h3 class='category-title'>$current_cat</h3>";
        echo "<div class='row g-3 mb-4'>";

        $prod_query = mysqli_query($conn, "SELECT * FROM addproduct WHERE category = '$current_cat'");
        while ($prod = mysqli_fetch_array($prod_query)) {
            // Fallback Image Logic: Try image1, then 2, then 3
            $img_to_show = "placeholder.jpg";
            if(!empty($prod['image1'])) $img_to_show = $prod['image1'];
            elseif(!empty($prod['image2'])) $img_to_show = $prod['image2'];
            elseif(!empty($prod['image3'])) $img_to_show = $prod['image3'];
    ?>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product-card">
                    <div class="img-container">
        <img src="foldernew/<?php echo $img_to_show; ?>" 
     onerror="this.src='https://via.placeholder.com/300?text=Check+Folder+Name'">                    </div>
                    <div class="card-body">
                        <h6 class="product-name text-truncate"><?php echo $prod['productname']; ?></h6>
                        <span class="price-text">$<?php echo number_format($prod['price'], 2); ?></span>
                    </div>
                    <div class="btn-group-custom">
                        <a href="productdetails.php?id=<?php echo $prod['product_id']; ?>" class="btn btn-view btn-custom">View</a>
                        <a href="place_order.php?id=<?php echo $prod['product_id']; ?>" class="btn btn-add btn-custom">Order</a>
                    </div>
                </div>
            </div>
    <?php 
        }
        echo "</div>";
    } 
    ?>
</div>

</body>
</html>