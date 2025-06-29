<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Navbar Styles */
        .navbar {
            background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%);
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-title {
            color: white;
            font-size: 20px;
            font-weight: 600;
            margin-left: 15px;
        }
        
        .navbar-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        
        /* Main Layout */
        .main-container {
            display: flex;
            margin-top: 60px; /* Tinggi navbar */
            flex: 1;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            width: 280px;
            min-height: calc(100vh - 60px); /* Sesuaikan dengan tinggi navbar */
            color: white;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 60px; /* Mulai di bawah navbar */
            left: 0;
            z-index: 900;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 1.5rem 0;
            padding: 0 20px;
        }
        
        .logo-image {
            height: 130px;
            width: auto;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background: white;
            padding: 10px;
        }
        
        .profile-section {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            margin: 0 20px 20px;
            padding: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .profile-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .profile-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            font-size: 20px;
        }
        
        .profile-text {
            flex: 1;
        }
        
        .profile-name {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 3px;
        }
        
        .profile-role {
            font-size: 12px;
            color: #94a3b8;
        }
        
        .nav-links {
            padding: 0 20px;
            flex: 1;
        }
        
        .nav-item {
            margin-bottom: 8px;
            position: relative;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
        }
        
        .nav-link:hover {
            background: rgba(74, 85, 104, 0.5);
            color: white;
        }
        
        .nav-link.active {
            background: rgba(59, 130, 246, 0.25);
            color: white;
            border-left: 4px solid #3b82f6;
        }
        
        .nav-icon {
            font-size: 20px;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }
        
        .dropdown-icon {
            transition: transform 0.3s ease;
            font-size: 20px;
        }
        
        .nav-item:hover .dropdown-icon {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            min-width: 240px;
            background: rgba(30, 41, 59, 0.95);
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-item:hover .dropdown-menu {
            display: block;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 8px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        
        .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.2);
            color: white;
            padding-left: 20px;
        }
        
        .dropdown-icon-small {
            font-size: 18px;
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .logout-section {
            padding: 20px;
            margin-top: auto;
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            color: #fecaca;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 15px;
        }
        
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.35);
        }
        
        .logout-icon {
            font-size: 20px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px; /* Lebar sidebar */
            padding: 30px;
            background: #f5f7fa;
            min-height: calc(100vh - 60px); /* Tinggi navbar */
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .dashboard-title {
            font-size: 28px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-title {
            font-size: 16px;
            color: #64748b;
            font-weight: 500;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
        }
        
        .change-up {
            color: #10b981;
        }
        
        .change-down {
            color: #ef4444;
        }
        
        .activity-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .activity-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-text {
            font-weight: 500;
            margin-bottom: 3px;
        }
        
        .activity-desc {
            font-size: 14px;
            color: #64748b;
        }
        
        .activity-time {
            text-align: right;
            min-width: 80px;
        }
        
        .time-text {
            font-size: 14px;
            color: #64748b;
        }
        
        .time-badge {
            display: inline-block;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 20px;
            margin-top: 5px;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 250px;
            }
            
            .main-content {
                margin-left: 250px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 250px;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 99;
                background: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="menu-toggle" id="menuToggle">
            <span class="material-icons">menu</span>
        </div>
        <div class="navbar-title">Admin Dashboard</div>
        
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="logo-container">
                <img src="\img\Logo proyek pemrograman.png" alt="Logo" class="logo-image">
            </div>

            

            <!-- Navigation Links -->
            <div class="nav-links">
                <!-- Home -->
                <div class="nav-item">
                    <a href="/home" class="nav-link active">
                        <span class="material-icons nav-icon">home</span>
                        Home
                    </a>
                </div>
                
                <!-- Barang -->
                <div class="nav-item">
                    <a href="/barang" class="nav-link">
                        <span class="material-icons nav-icon">inventory_2</span>
                        Barang
                    </a>
                </div>
                
                <!-- Peminjaman with Dropdown -->
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-icons nav-icon">shopping_cart</span>
                        Peminjaman
                        <span class="material-icons dropdown-icon ml-auto">expand_more</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/transaksi" class="dropdown-item">
                            <span class="material-icons dropdown-icon-small">assignment</span>
                            Form Peminjaman
                        </a>
                        <a href="/peminjaman/log" class="dropdown-item">
                            <span class="material-icons dropdown-icon-small">history</span>
                            Log Peminjaman
                        </a>
                    </div>
                </div>
                
                <!-- Customers with Dropdown -->
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-icons nav-icon">groups</span>
                        Customers
                        <span class="material-icons dropdown-icon ml-auto">expand_more</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/formcustomer" class="dropdown-item">
                            <span class="material-icons dropdown-icon-small">person_add</span>
                            Form Customer
                        </a>
                        <a href="/listcustomer" class="dropdown-item">
                            <span class="material-icons dropdown-icon-small">list_alt</span>
                            Daftar Customer
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <div class="logout-section">
                <button class="logout-btn">
                    <span class="material-icons logout-icon">logout</span>
                    LogOut
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        
    </div>

    <script>
        // Menu toggle for mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Add active class to clicked nav items
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
            });
        });
        
        // Handle dropdown links
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                // Set parent link as active
                const parentLink = this.closest('.nav-item').querySelector('.nav-link');
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                parentLink.classList.add('active');
            });
        });
        
        // Handle logout button
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Apakah Anda yakin ingin keluar?')) {
                alert('Anda telah logout');
                // window.location.href = '/logout';
            }
        });
    </script>
</body>
</html>