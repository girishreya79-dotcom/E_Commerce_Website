<?php 
session_start(); 
if (!isset($_SESSION["xx"])) { header("Location: userlogin.php"); exit(); }
$conn = mysqli_connect("localhost", "root", "", "shopping");

if (isset($_GET['id'])) {
    $pid = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM addproduct WHERE product_id = '$pid'");
    $p = mysqli_fetch_array($res);
}

if (!$p) { die("Product not found."); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $p['productname']; ?> | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; font-family: 'Poppins', sans-serif; }
        .detail-box { margin-top: 80px; padding: 20px; }
        .main-img { width: 100%; height: 450px; object-fit: cover; border-radius: 15px; border: 1px solid #eee; }
        .thumb-img { width: 100%; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; opacity: 0.7; }
        .thumb-img:hover { opacity: 1; border: 2px solid #d81b60; }
        
        /* Smaller Category Font */
        .cat-badge { font-size: 11px; text-transform: uppercase; color: #d81b60; font-weight: 700; letter-spacing: 1px; }
        
        .price { font-size: 2rem; color: #d81b60; font-weight: 700; }
        .btn-order { background: #4b0082; color: white; border-radius: 50px; padding: 12px 40px; }
        .btn-order:hover { background: #32005a; color: white; }
    </style>
</head>
<body>

<div class="container detail-box">
    <div class="row">
        <div class="col-md-6">
            <?php 
                $main = !empty($p['image1']) ? $p['image1'] : (!empty($p['image2']) ? $p['image2'] : $p['image3']);
            ?>
            <img src="foldernew/<?php echo $main; ?>" id="viewPane" ...>

            <div class="row g-2 mt-2">
                <?php if(!empty($p['image1'])): ?>
                <div class="col-3"><img src="uploads/<?php echo $p['image1']; ?>" class="thumb-img" onclick="document.getElementById('viewPane').src=this.src"></div>
                <?php endif; ?>
                <?php if(!empty($p['image2'])): ?>
                <div class="col-3"><img src="uploads/<?php echo $p['image2']; ?>" class="thumb-img" onclick="document.getElementById('viewPane').src=this.src"></div>
                <?php endif; ?>
                <?php if(!empty($p['image3'])): ?>
                <div class="col-3"><img src="uploads/<?php echo $p['image3']; ?>" class="thumb-img" onclick="document.getElementById('viewPane').src=this.src"></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6 ps-md-5 mt-4 mt-md-0">
            <span class="cat-badge"><?php echo $p['category']; ?></span>
            <h1 class="fw-bold mt-2"><?php echo $p['productname']; ?></h1>
            <p class="price mb-4">$<?php echo number_format($p['price'], 2); ?></p>
            
            <h6 class="fw-bold text-muted small">About this item:</h6>
            <p class="text-secondary"><?php echo $p['description']; ?></p>
            
            <p><strong>Available Stock:</strong> <?php echo $p['stock']; ?></p>

            <div class="d-flex gap-3 mt-5">
                <a href="addtocart.php?id=<?php echo $p['product_id']; ?>" class="btn btn-outline-danger btn-lg rounded-pill px-4">Add To Cart</a>
                <a href="place_order.php?id=<?php echo $p['product_id']; ?>" class="btn btn-order btn-lg shadow">Order Now</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>