<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Testimoni</title>
    <style>
        /* ===== RESET & BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #E8F4F8;
            color: #333;
            line-height: 1.5;
        }

        /* ===== LAYOUT ===== */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background: #5FB574;
            color: #fff;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-square {
            width: 30px;
            height: 30px;
            background: #fff;
            display: inline-block;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.9);
            margin-left: 38px;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 1rem;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.15);
            border-left-color: #F9D56E;
            color: #fff;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            font-weight: 600;
        }

        .menu-icon {
            font-size: 1.5rem;
            width: 30px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1.5rem;
            background: rgba(0,0,0,0.1);
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #F9D56E;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: #5FB574;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .user-info h4 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .user-info p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            width: calc(100% - 280px);
            transition: margin-left 0.3s ease;
        }

        /* ===== HEADER ===== */
        .page-header {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            text-align: center;
            font-size: 0.95rem;
        }

        .btn-primary { background: #5FB574; color: #fff; }
        .btn-success { background: #5FB574; color: #fff; }
        .btn-danger  { background: #FF8A5B; color: #fff; }
        .btn-warning { background: #F9D56E; color: #333; }
        .btn-secondary { background: #95a5a6; color: #fff; }
        .btn-info { background: #3498db; color: #fff; }

        .btn-primary:hover { background: #4FA564; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(95,181,116,0.4); }
        .btn-success:hover { background: #4FA564; transform: translateY(-2px); }
        .btn-danger:hover  { background: #E67A4B; transform: translateY(-2px); }
        .btn-warning:hover { background: #E9C55E; transform: translateY(-2px); }
        .btn-secondary:hover { background: #7f8c8d; transform: translateY(-2px); }
        .btn-info:hover { background: #2980b9; transform: translateY(-2px); }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .btn-logout {
            background: #FF8A5B;
            color: #fff;
            padding: 0.7rem 1.8rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,138,91,0.4);
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 2rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-card.total h3    { color: #5FB574; }
        .stat-card.approved h3 { color: #5FB574; }
        .stat-card.rejected h3 { color: #FF8A5B; }

        /* ===== FILTERS ===== */
        .filters {
            background: #fff;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .filters form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filters select,
        .filters input {
            padding: 0.7rem 1rem;
            border: 2px solid #E8F4F8;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
            min-width: 150px;
        }

        .filters select:focus,
        .filters input:focus {
            outline: none;
            border-color: #5FB574;
        }

        .filters input[type="text"] {
            flex: 1;
            min-width: 200px;
        }

        /* ===== TABLE CONTAINER ===== */
        .table-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        thead {
            background: linear-gradient(135deg, #5FB574 0%, #4FA564 100%);
            color: #fff;
        }

        th {
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: none;
            white-space: nowrap;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            vertical-align: top;
        }

        tr:hover td {
            background: #F7FCF9;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-approved {
            background: #E8F5EC;
            color: #4FA564;
            border: 1px solid #D4EDDA;
        }

        .badge-rejected {
            background: #FFE8E1;
            color: #D96F4A;
            border: 1px solid #FFD1C4;
        }

        /* ===== ACTION BUTTONS ===== */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-form {
            display: inline;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background: #E8F5EC;
            color: #4FA564;
            border: 2px solid #5FB574;
        }

        .alert-info {
            background: #E8F4F8;
            color: #3498db;
            border: 2px solid #3498db;
        }

        /* ===== MODAL TAMBAH TESTIMONI ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            padding: 1rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-form {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .modal-form h2 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #E8F4F8;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #5FB574;
            background: #F7FCF9;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Style untuk email generation */
        .email-generation {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 0.8rem;
            margin-top: 0.5rem;
            border: 1px dashed #ddd;
        }

        .email-generation p {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .generated-email-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .generated-email-display input {
            flex: 1;
            padding: 0.5rem;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.9rem;
        }

        .btn-copy-email {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 0.8rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-copy-email:hover {
            background: #5a6268;
        }

        .btn-copy-email.copied {
            background: #28a745;
        }

        .copy-status {
            color: #28a745;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: none;
        }

        .copy-status.show {
            display: block;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .modal-actions .btn {
            flex: 1;
        }

        /* ===== MOBILE MENU TOGGLE ===== */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: #5FB574;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* ===== OVERLAY FOR MOBILE ===== */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            gap: 1.5rem;
        }

        .pagination .results-info {
            font-size: 0.9rem;
            color: #666;
            margin-right: auto;
        }

        .pagination .btn-prev,
        .pagination .btn-next {
            padding: 0.6rem 1.2rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: #fff;
        }

        .pagination .btn-prev:hover:not(.disabled),
        .pagination .btn-next:hover:not(.disabled) {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
            transform: translateY(-2px);
        }

        .pagination .btn-prev.disabled,
        .pagination .btn-next.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
            background: #f5f5f5;
        }

        /* ===== TYPE BADGE ===== */
        .type-badge {
            background: #7cb342;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .mobile-menu-toggle {
                display: block;
            }

            .page-header {
                padding: 1rem;
                margin-top: 3rem;
            }

            .filters form {
                flex-direction: column;
                align-items: stretch;
            }

            .filters input[type="text"],
            .filters select {
                width: 100%;
                min-width: auto;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .pagination .results-info {
                order: 1;
                width: 100%;
                text-align: center;
                margin: 0 0 1rem 0;
            }

            .pagination .btn-prev,
            .pagination .btn-next {
                order: 2;
            }

            .table-container {
                overflow-x: auto;
                border-radius: 10px;
            }

            table {
                min-width: 800px;
            }

            th, td {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem 1rem;
            }

            .stat-card h3 {
                font-size: 2rem;
            }

            .page-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .header-actions {
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons .btn {
                width: 100%;
                text-align: center;
            }

            .modal-form {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .modal-actions {
                flex-direction: column;
            }

            .pagination .btn-prev,
            .pagination .btn-next {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            .email-generation {
                padding: 0.6rem;
            }

            .generated-email-display {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.5rem;
            }

            .page-header {
                padding: 1rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .filters {
                padding: 1rem;
            }

            .btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .stat-card {
                padding: 1.2rem 0.8rem;
            }

            .stat-card h3 {
                font-size: 1.8rem;
            }

            th, td {
                padding: 0.6rem 0.8rem;
                font-size: 0.8rem;
            }

            .badge {
                padding: 0.3rem 0.8rem;
                font-size: 0.75rem;
            }

            .type-badge {
                padding: 0.2rem 0.6rem;
                font-size: 0.7rem;
            }

            .mobile-menu-toggle {
                top: 0.5rem;
                left: 0.5rem;
                padding: 0.5rem;
                font-size: 1.3rem;
            }

            .modal-form {
                padding: 1.2rem;
            }

            .modal-form h2 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 360px) {
            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .header-actions .btn {
                width: 100%;
            }

            .stats-grid {
                gap: 0.8rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .action-buttons {
                width: 100%;
            }

            .pagination {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
            }

            .pagination .results-info {
                order: 1;
                margin-bottom: 0.5rem;
            }

            .pagination .btn-prev,
            .pagination .btn-next {
                order: 2;
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <div class="overlay" id="overlay"></div>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><span class="logo-square"></span> <span>WALUYA LAND</span></h2>
                <p>Admin Panel</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="menu-item">
                    <span class="menu-icon">📧</span>
                    <span>Kelola Pesan</span>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="menu-item active">
                    <span class="menu-icon">⭐</span>
                    <span>Kelola Testimoni</span>
                </a>
                <a href="{{ route('admin.media.index') }}" class="menu-item">
                    <span class="menu-icon">🖼️</span>
                    <span>Media Library</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">AM</div>
                    <div class="user-info">
                        <h4>Admin Malaya</h4>
                        <p>Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1>⭐ Kelola Testimoni</h1>
                <div class="header-actions">
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <button onclick="openAddModal()" class="btn btn-success">+ Tambah Testimoni</button>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">ℹ {{ session('info') }}</div>
            @endif

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <p>Total Testimoni</p>
                </div>

                <div class="stat-card approved">
                    <h3>{{ $stats['approved'] ?? 0 }}</h3>
                    <p>Disetujui</p>
                </div>

                <div class="stat-card rejected">
                    <h3>{{ $stats['rejected'] ?? 0 }}</h3>
                    <p>Ditolak</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <form method="GET" action="{{ route('admin.testimonials.index') }}">
                    <select name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <input type="text" name="search" placeholder="Cari nama atau testimoni..." value="{{ request('search') }}">

                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Instansi</th>
                            <th>Testimoni</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                        <tr>
                            <td><strong>{{ $testimonial->name }}</strong></td>
                            <td>{{ $testimonial->email }}</td>
                            <td>
                                <span class="type-badge">{{ $testimonial->type_text }}</span>
                            </td>
                            <td>{{ $testimonial->institution ?? '-' }}</td>
                            <td style="max-width: 300px;">{{ Str::limit($testimonial->message, 100) }}</td>
                            <td>
                                <span class="badge badge-{{ $testimonial->status }}">
                                    @if($testimonial->status == 'approved')
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            </td>
                            <td>{{ $testimonial->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <!-- Toggle Approval Status -->
                                    @if($testimonial->status == 'approved')
                                        <form action="{{ route('admin.testimonials.reject', $testimonial->id) }}" method="POST" class="action-form">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Tandai sebagai Ditolak?')">✕ Tolak</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST" class="action-form">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tandai sebagai Disetujui?')">✓ Setujui</button>
                                        </form>
                                    @endif

                                    <!-- Hapus Testimoni -->
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="action-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus testimoni ini?')">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 2rem; color: #999;">
                                Belum ada testimoni
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($testimonials->hasPages())
                <div class="pagination">
                    @php
                        $start = ($testimonials->currentPage() - 1) * $testimonials->perPage() + 1;
                        $end = min($testimonials->currentPage() * $testimonials->perPage(), $testimonials->total());
                    @endphp

                    <span class="results-info">
                        {{ $start }} to {{ $end }} of {{ $testimonials->total() }} results
                    </span>

                    @if(!$testimonials->onFirstPage())
                        <a href="{{ $testimonials->previousPageUrl() }}" class="btn-prev">← Previous</a>
                    @else
                        <span class="btn-prev disabled">← Previous</span>
                    @endif

                    @if($testimonials->hasMorePages())
                        <a href="{{ $testimonials->nextPageUrl() }}" class="btn-next">Next →</a>
                    @else
                        <span class="btn-next disabled">Next →</span>
                    @endif
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Modal Tambah Testimoni -->
    <div class="modal-overlay" id="addModal">
        <div class="modal-form">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>➕ Tambah Testimoni Baru</h2>
                <button onclick="closeAddModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">×</button>
            </div>

            <form action="{{ route('admin.testimonials.store') }}" method="POST" id="testimoniForm">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" required
                           oninput="generateEmailFromName()"
                           placeholder="Contoh: Yoga Pratama">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required
                           placeholder="Email akan digenerate otomatis">

                    <!-- Email Generation Section -->
                    <div class="email-generation" id="emailGenerationSection" style="display: none;">
                        <p><strong>Email otomatis dari nama:</strong></p>
                        <div class="generated-email-display">
                            <input type="text" id="generatedEmail" readonly>
                            <button type="button" class="btn-copy-email" onclick="copyGeneratedEmail()" id="copyEmailBtn">
                                📋 Copy
                            </button>
                        </div>
                        <div class="copy-status" id="copyStatus">✓ Email berhasil disalin!</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="institution">Instansi / Sekolah</label>
                    <input type="text" id="institution" name="institution"
                           placeholder="Contoh: SMAN 1 Bandung">
                </div>

                <div class="form-group">
                    <label for="message">Testimoni *</label>
                    <textarea id="message" name="message" required
                              placeholder="Tuliskan testimoni di sini..."></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="approved" selected>Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <input type="hidden" name="type" value="testimonial">

                <div class="modal-actions">
                    <button type="button" class="btn btn-warning" onclick="fillRandomData()">
                        🎲 Isi Data Random
                    </button>
                    <button type="submit" class="btn btn-success">Simpan Testimoni</button>
                    <button type="button" onclick="closeAddModal()" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===== MOBILE MENU FUNCTIONALITY =====
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        }

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // ===== MODAL FUNCTIONS =====
        function openAddModal() {
            document.getElementById('addModal').classList.add('active');
            document.body.style.overflow = 'hidden';

            // Reset form saat modal dibuka
            document.getElementById('testimoniForm').reset();
            document.getElementById('emailGenerationSection').style.display = 'none';
            document.getElementById('copyStatus').classList.remove('show');

            // Set default status to "approved"
            document.getElementById('status').value = 'approved';

            // Focus ke input nama
            setTimeout(() => {
                document.getElementById('name').focus();
            }, 100);
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
            }
        });

        // ===== EMAIL GENERATION FUNCTIONS =====
        function generateEmailFromName() {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const generatedEmailInput = document.getElementById('generatedEmail');
            const emailGenerationSection = document.getElementById('emailGenerationSection');

            const name = nameInput.value.trim();

            if (name.length >= 2) {
                // Clean the name
                let cleanName = name.toLowerCase()
                    .replace(/[^a-z0-9\s]/g, '') // Remove special characters
                    .replace(/\s+/g, ' ') // Normalize spaces
                    .trim();

                // Replace spaces with dots
                let emailName = cleanName.replace(/\s+/g, '.');

                // If name is too short, add random number
                if (emailName.length < 3) {
                    emailName += Math.floor(Math.random() * 100);
                }

                // Add @gmail.com domain
                const generatedEmail = emailName + '@gmail.com';

                // Update both email fields
                emailInput.value = generatedEmail;
                generatedEmailInput.value = generatedEmail;

                // Show email generation section
                emailGenerationSection.style.display = 'block';
            } else {
                // Hide email generation section if name is too short
                emailGenerationSection.style.display = 'none';
                emailInput.value = '';
            }
        }

        function copyGeneratedEmail() {
            const generatedEmailInput = document.getElementById('generatedEmail');
            const copyBtn = document.getElementById('copyEmailBtn');
            const copyStatus = document.getElementById('copyStatus');

            generatedEmailInput.select();
            generatedEmailInput.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(generatedEmailInput.value)
                .then(() => {
                    // Update button appearance
                    copyBtn.textContent = '✓ Disalin!';
                    copyBtn.classList.add('copied');

                    // Show success message
                    copyStatus.classList.add('show');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        copyBtn.textContent = '📋 Copy';
                        copyBtn.classList.remove('copied');
                        copyStatus.classList.remove('show');
                    }, 2000);
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                    alert('Gagal menyalin email ke clipboard');
                });
        }

        function fillRandomData() {
            // List of random names
            const randomNames = [
                "Yoga Pratama", "Budi Santoso", "Sari Wijaya", "Dewi Lestari",
                "Ahmad Fauzi", "Maya Sari", "Rudi Hartono", "Linda Susanti",
                "Hendra Gunawan", "Rina Permata", "Joko Widodo", "Ani Rahayu",
                "Tono Sugiharto", "Mila Anggraini", "Rizki Maulana", "Dina Fitriani"
            ];

            // List of random institutions
            const randomInstitutions = [
                "SMAN 1 Bandung", "SMKN 2 Jakarta", "Universitas Indonesia",
                "Universitas Gadjah Mada", "SMA Negeri 3 Surabaya",
                "SMK Muhammadiyah 1", "SMP Negeri 5 Yogyakarta",
                "MTs Negeri 2", "SMA Taruna Nusantara"
            ];

            // List of random testimonials
            const randomTestimonials = [
                "Sangat membantu dalam memahami kewirausahaan dengan cara yang menyenangkan!",
                "Game-nya interaktif sekali, anak-anak jadi lebih antusias belajar bisnis.",
                "Materi kewirausahaan yang biasanya sulit menjadi mudah dipahami melalui permainan ini.",
                "Alat pembelajaran yang inovatif, cocok untuk siswa SMA/SMK.",
                "Permainannya seru dan mendidik, rekomendasi untuk sekolah-sekolah!",
                "Membantu mengembangkan keterampilan problem solving dengan cara yang kreatif.",
                "Siswa lebih aktif berpartisipasi dalam pembelajaran kewirausahaan.",
                "Board game yang edukatif dan menghibur sekaligus."
            ];

            // Get random items
            const randomName = randomNames[Math.floor(Math.random() * randomNames.length)];
            const randomInstitution = randomInstitutions[Math.floor(Math.random() * randomInstitutions.length)];
            const randomTestimonial = randomTestimonials[Math.floor(Math.random() * randomTestimonials.length)];

            // Fill the form
            document.getElementById('name').value = randomName;
            document.getElementById('institution').value = randomInstitution;
            document.getElementById('message').value = randomTestimonial;

            // Generate email from random name
            generateEmailFromName();

            // Set status to approved (default)
            document.getElementById('status').value = 'approved';

            // Show success message
            alert('Data random telah diisi! Silakan periksa dan sesuaikan jika perlu.');
        }

        // ===== FORM VALIDATION =====
        document.getElementById('testimoniForm').addEventListener('submit', function(e) {
            const name = this.name.value.trim();
            const email = this.email.value.trim();
            const message = this.message.value.trim();

            if(!name || !email || !message) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib (Nama, Email, Testimoni)!');
                return false;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid!');
                return false;
            }

            return true;
        });

        // Auto-generate email when name input loses focus
        document.getElementById('name').addEventListener('blur', function() {
            if (this.value.trim().length >= 2) {
                generateEmailFromName();
            }
        });

        // Allow manual email editing without overriding
        document.getElementById('email').addEventListener('input', function() {
            const emailGenerationSection = document.getElementById('emailGenerationSection');
            emailGenerationSection.style.display = 'none';
        });

        // ===== RESPONSIVE HANDLING =====
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 992 &&
                !sidebar.contains(event.target) &&
                !mobileMenuToggle.contains(event.target) &&
                sidebar.classList.contains('mobile-open')) {
                toggleMobileMenu();
            }
        });

        // Keyboard shortcut for closing mobile menu (ESC key)
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                toggleMobileMenu();
            }
        });

        // ===== INITIALIZATION =====
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are validation errors
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error')) {
                // If there's an error, open the modal to show the form again
                openAddModal();
            }
        });
    </script>
</body>
</html>
