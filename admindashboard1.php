<?php 
session_start(); 
if (!isset($_SESSION["xx"])) {
 header("Location: login.php");
 exit();
}
$username = $_SESSION["xx"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub | Premium Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --nav-bg: #fff0f3; 
            --sidebar-bg: #2d3436; 
            --accent-pink: #ff75a0;
            --nav-height: 70px;
            --sidebar-width: 240px;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #fdfbfb;
            /* Changed overflow to allow page movement on small screens */
            overflow-x: hidden; 
        }

        /* --- NAVBAR --- */
        .navbar-custom {
            height: var(--nav-height);
            background: var(--nav-bg);
            border-bottom: 1px solid rgba(255, 117, 160, 0.2);
            padding: 0 2rem;
            z-index: 1030;
        }

        .navbar-brand { font-family: 'Lobster', cursive; font-size: 1.8rem; }
        .brand-fashion { color: var(--accent-pink); }
        .brand-hub { color: #6c5ce7; }

        /* --- SIDEBAR: Fixed & Scrollable --- */
        .sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - var(--nav-height));
            background: var(--sidebar-bg);
            position: fixed;
            top: var(--nav-height);
            left: 0;
            padding-top: 10px;
            z-index: 1000;
            /* THIS FIXES YOUR SCROLL ISSUE */
            overflow-y: auto; 
            padding-bottom: 30px;
        }

        /* Hide scrollbar for Chrome/Safari but keep functionality */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        .nav-section-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #b2bec3;
            padding: 20px 25px 8px;
            font-weight: 700;
            opacity: 0.6;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: #dfe6e9;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 4px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a i { margin-right: 12px; font-size: 1.1rem; color: var(--accent-pink); }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.05); color: white; }
        .sidebar a.active { background: var(--accent-pink); color: white; box-shadow: 0 4px 15px rgba(255, 117, 160, 0.3); }
        .sidebar a.active i { color: white; }

        /* --- CONTENT AREA --- */
        .content {
            margin-left: var(--sidebar-width);
            margin-top: var(--nav-height);
            padding: 30px;
            min-height: calc(100vh - var(--nav-height));
        }

        .dashboard-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }

        /* RESPONSIVE FIXES */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar a span, .nav-section-label, .sidebar-welcome { display: none; }
            .content { margin-left: 70px; padding: 15px; }
            .sidebar a { justify-content: center; margin: 4px 5px; }
            .sidebar a i { margin-right: 0; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <span class="brand-fashion">Fashion</span><span class="brand-hub">Hub</span>
        </a>
        
        <div class="ms-auto d-flex align-items-center">
            <div class="me-3 text-end d-none d-md-block">
                <small class="text-muted d-block" style="font-size: 10px; font-weight: 700; color: #ff75a0 !important;">PREMIUM ADMIN</small>
                <span class="fw-bold" style="font-size: 14px; color: #2d3436;"><?php echo htmlspecialchars($username); ?></span>
            </div>
            <img src="admin.png" class="rounded-circle shadow-sm border border-2 border-white" width="40" height="40">
        </div>
    </div>
</nav>

<div class="sidebar">
    <div class="sidebar-welcome px-4 mb-4">
        <small style="color: var(--accent-pink); font-size: 10px; font-weight: 700; text-transform: uppercase;">System Operator</small>
        <p style="color: white; font-weight: 600; font-size: 15px; margin: 0;"><?php echo htmlspecialchars($username); ?></p>
    </div>

    <div class="nav-section-label">General</div>
    <a href="admindashboar1.php" class="active" onclick="setActive(this)">
        <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
    </a>

    <div class="nav-section-label">Inventory Management</div>
    <a href="addcategory1.html" onclick="setActive(this)">
        <i class="bi bi-tag-fill"></i> <span>Add Category</span>
    </a>
    <a href="removecategory.html" onclick="setActive(this)">
        <i class="bi bi-bookmark-x-fill"></i> <span>Remove Category</span>
    </a>
    <a href="addproduct.html" onclick="setActive(this)">
        <i class="bi bi-plus-square-fill"></i> <span>Add Product</span>
    </a>
    <a href="removeproduct.html" onclick="setActive(this)">
        <i class="bi bi-trash3-fill"></i> <span>Remove Product</span>
    </a>
    <a href="viewproduct.php" onclick="setActive(this)">
        <i class="bi bi-eye-fill"></i> <span>View Catalog</span>
    </a>

    <div class="nav-section-label">Sales & People</div>
    <a href="vieworder.php" onclick="setActive(this)">
        <i class="bi bi-cart-check-fill"></i> <span>Order List</span>
    </a>
    <a href="confirmorder.php" onclick="setActive(this)">
        <i class="bi bi-patch-check-fill"></i> <span>Confirmations</span>
    </a>
    <a href="viewuser.php" onclick="setActive(this)">
        <i class="bi bi-people-fill"></i> <span>View Customer</span>
    </a>

    <div class="nav-section-label">Authentication</div>
    <a href="adminlogin.html" class="text-danger">
        <i class="bi bi-box-arrow-left" style="color: #ff7675;"></i> <span>Logout System</span>
    </a>
</div>


<div class="content">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold" style="color: #2d3436; letter-spacing: -1px;">Dashboard Summary</h2>
                <p class="text-muted">Hello <?php echo htmlspecialchars($username); ?>, here is your store's performance.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="stat-icon" style="background: #fff0f3; color: #ff75a0;"><i class="bi bi-graph-up-arrow"></i></div>
                    <h6 class="text-muted fw-bold small">Monthly Revenue</h6>
                    <h2 class="fw-bold mb-0">$24,150.00</h2>
                </div>
            </div>
            </div>
    </div>
</div>

<script>
    function setActive(el) {
        let links = document.querySelectorAll('.sidebar a');
        links.forEach(link => link.classList.remove('active'));
        el.classList.add('active');
    }
</script>

</body>
</html>