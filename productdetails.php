<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) { 
    header("Location: productlogin.html"); 
    exit(); 
}
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$pid = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if ($pid) {
    $res = mysqli_query($conn, "SELECT * FROM addproduct WHERE product_id = '$pid'");
    $p = mysqli_fetch_assoc($res);
} else {
    $p = null;
}
if (!$p) { 
    die("<div class='text-center mt-5'><h3>Product not found.</h3><a href='product.php' class='btn btn-dark'>Return to Shop</a></div>"); 
}

$folder = "foldernew/"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($p['productname']); ?> | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f1f5f9; font-family: 'Poppins', sans-serif; overflow: hidden; height: 100vh; }
        .navbar { background: #0f172a !important; height: 55px; }
        .navbar-brand { font-weight: 800; color: #fbbf24 !important; font-size: 18px; }
        .wrapper { height: calc(100vh - 55px); display: flex; align-items: center; justify-content: center; padding: 15px; }
        .detail-card { background: #fff; border-radius: 12px; max-width: 950px; height: 480px; width: 100%; display: flex; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .img-section { width: 40%; height: 100%; background: #f8fafc; position: relative; border-right: 1px solid #f1f5f9; }
        .main-img-container { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .main-img { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease; }
        .thumb-nav { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; background: rgba(255,255,255,0.7); padding: 5px; border-radius: 8px; backdrop-filter: blur(4px); }
        .thumb-nav img { width: 60px; height: 60px; border-radius: 4px; cursor: pointer; border: 2px solid transparent; object-fit: cover; transition: 0.2s; }
        .thumb-nav img:hover { border-color: #fbbf24; }
        .info-section { width: 60%; padding: 30px; display: flex; flex-direction: column; justify-content: center; }
        .cat { font-size: 10px; font-weight: 700; color: #f43f5e; text-transform: uppercase; letter-spacing: 1px; }
        .title { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 4px 0; }
        .price { font-size: 1.3rem; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
        .desc { font-size: 12px; color: #64748b; line-height: 1.6; margin: 10px 0 20px 0; }
        .button-group { display: flex; gap: 10px; width: 100%; }
        .btn-sm-custom { font-size: 11px; font-weight: 700; padding: 8px 10px; border-radius: 8px; text-transform: uppercase; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px; height: 38px; border: none; }
        .btn-order { background: #0f172a; color: #fbbf24; }
        .btn-cart { background: transparent; border: 2px solid #0f172a; color: #0f172a; }
        .btn-order:hover { background: #1e293b; color: #fff; transform: translateY(-2px); }
        .btn-cart:hover { background: #0f172a; color: #fff; transform: translateY(-2px); }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="userpanel.php">FashionHub</a>
        <a href="product.php" class="btn btn-sm btn-outline-warning rounded-pill px-3">Exit</a>
    </div>
</nav>

<div class="wrapper">
    <div class="detail-card">
        <div class="img-section">
            <div class="main-img-container">
                <?php 
                    $img1 = $p['image1'];
           $display_path = (strpos($img1, $folder) !== false) ? $img1 : $folder . basename($img1);
                ?>
                <img src="<?php echo $display_path; ?>" id="mainView" class="main-img">
            </div>
            <div class="thumb-nav shadow-sm">
                <?php for($i=1; $i<=3; $i++): $k="image".$i; if(!empty($p[$k])): 
           $t_path = (strpos($p[$k], $folder) !== false) ? $p[$k] : $folder . basename($p[$k]);
                ?>
                    <img src="<?php echo $t_path; ?>" onclick="updateImage(this.src)">
                <?php endif; endfor; ?>
            </div>
        </div>

        <div class="info-section">
            <span class="cat"><?php echo htmlspecialchars($p['category']); ?></span>
            <h1 class="title"><?php echo htmlspecialchars($p['productname']); ?></h1>
            <div class="price">$<?php echo number_format($p['price'], 2); ?></div>
            
            <p class="desc text-secondary">
                <?php echo nl2br(htmlspecialchars(substr($p['description'], 0, 250))); ?>
            </p>

            <div class="button-group">
                
                <form action="orderproduct.php" method="POST" style="flex:1;">
                    <input type="hidden" name="id" value="<?php echo $pid; ?>">
                    <button type="submit" class="btn-sm-custom btn-order w-100" <?php echo ($p['stock'] <= 0) ? 'disabled' : ''; ?>>
                        <i class="bi bi-lightning-fill"></i> <?php echo ($p['stock'] > 0) ? 'Order Now' : 'Sold Out'; ?>
                    </button>
                </form>

                
                <form action="addtocart.php" method="POST" style="flex:1;">
                    <input type="hidden" name="id" value="<?php echo $pid; ?>">
                    <button type="submit" class="btn-sm-custom btn-cart w-100" <?php echo ($p['stock'] <= 0) ? 'disabled' : ''; ?>>
                        <i class="bi bi-cart3"></i> Add to Cart
                    </button>
                </form>
            </div>
            
            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                <small style="font-size: 10px;" class="text-muted fw-bold">STOCK: <?php echo $p['stock']; ?> LEFT</small>
                <div class="text-warning" style="font-size: 12px;">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateImage(src) {
        const main = document.getElementById('mainView');
        main.style.opacity = '0.4';
        setTimeout(() => {
            main.src = src;
            main.style.opacity = '1';
        }, 150);
    }
</script>

</body>
</html>