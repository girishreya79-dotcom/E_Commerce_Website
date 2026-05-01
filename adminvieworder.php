<?php
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['approve_id'])) {
    $oid = mysqli_real_escape_string($conn, $_GET['approve_id']);
    mysqli_query($conn, "UPDATE orderproduct SET status = 'Confirmed' WHERE order_id = '$oid'");
    header("Location: adminvieworder.php");
    exit();
}

if (isset($_GET['cancel_id'])) {
    $oid = mysqli_real_escape_string($conn, $_GET['cancel_id']);
    mysqli_query($conn, "UPDATE orderproduct SET status = 'Cancelled' WHERE order_id = '$oid'");
    header("Location: adminvieworder.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; padding: 40px 0; }
        .container { max-width: 1100px; }
        
        .order-row {
            display: grid;
            grid-template-columns: 80px 2fr 1.5fr 100px 180px;
            align-items: center;
            gap: 20px;
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eef0f2;
            transition: transform 0.2s;
        }
        .order-row:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        .img-container { width: 60px; height: 60px; border-radius: 8px; overflow: hidden; background: #f8fafc; border: 1px solid #ddd; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }

        .label { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
        .data-main { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
        .data-sub { font-size: 12px; color: #64748b; }

        .status-pill { font-size: 10px; padding: 3px 10px; border-radius: 20px; font-weight: 800; display: inline-block; margin-top: 5px; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .btn-action { font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 6px; text-decoration: none; transition: 0.2s; }
        .btn-confirm { background: #10b981; color: white; border: none; }
        .btn-confirm:hover { background: #059669; }
        .btn-refuse { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .btn-refuse:hover { background: #e2e8f0; }

        @media (max-width: 992px) {
            .order-row { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0" style="color: #0f172a;">Order Management</h2>
        <span class="badge bg-dark px-3 py-2 rounded-pill">Total Orders: <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orderproduct")); ?></span>
    </div>

    <?php
    $sql = "SELECT o.*, p.productname, p.image1 
            FROM orderproduct o 
            JOIN addproduct p ON o.product_id = p.product_id 
            ORDER BY o.order_id DESC";
            
    $res = mysqli_query($conn, $sql);
    $folder = "foldernew/"; 

    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $status = $row['status'];
            
            $db_filename = basename($row['image1']); 
            $fullImagePath = $folder . trim($db_filename);
    ?>
        <div class="order-row">
            
            <div class="img-container">
                <img src="<?php echo $fullImagePath; ?>" 
                     onerror="this.src='https://via.placeholder.com/60?text=Error'">
            </div>

            <div>
                <div class="label">Product Details</div>
                <p class="data-main"><?php echo htmlspecialchars($row['productname']); ?></p>
                <div class="data-sub">Qty: <?php echo $row['quantity']; ?> | Order #<?php echo $row['order_id']; ?></div>
            </div>

            <div>
                <div class="label">Customer Info</div>
                <p class="data-main"><?php echo htmlspecialchars($row['customer_name']); ?></p>
                <div class="data-sub"><i class="bi bi-telephone"></i> <?php echo $row['contact_number']; ?></div>
            </div>

            <div>
                <div class="label">Actual Total</div>
                <p class="data-main text-success">$<?php echo number_format($row['total_price'], 2); ?></p>
                <span class="status-pill status-<?php echo strtolower($status); ?>"><?php echo strtoupper($status); ?></span>
            </div>

            <div class="text-end">
                <?php if($status == 'Pending'): ?>
                    <a href="adminvieworder.php?approve_id=<?php echo $row['order_id']; ?>" class="btn-action btn-confirm me-1">Confirm</a>
                    <a href="adminvieworder.php?cancel_id=<?php echo $row['order_id']; ?>" class="btn-action btn-refuse" onclick="return confirm('Cancel order?')">Cancel</a>
                <?php elseif($status == 'Confirmed'): ?>
                    <a href="adminvieworder.php?cancel_id=<?php echo $row['order_id']; ?>" class="btn-action btn-refuse" onclick="return confirm('Change status to Cancelled?')">Refuse Order</a>
                <?php else: ?>
                    <span class="text-muted small fw-bold">No Action Needed</span>
                <?php endif; ?>
            </div>

        </div>
    <?php 
        }
    } else {
        echo "<div class='text-center p-5 bg-white rounded-3 shadow-sm'>
                <i class='bi bi-inbox text-muted display-1'></i>
                <p class='mt-3 text-muted fw-bold'>No orders found.</p>
              </div>";
    }
    ?>
</div>

</body>
</html>