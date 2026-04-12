<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Testimoni</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            font-size: 1.2rem;
            width: 24px;
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

        .btn-primary {
            background: #5FB574;
            color: #fff;
        }

        .btn-success {
            background: #5FB574;
            color: #fff;
        }

        .btn-danger {
            background: #FF8A5B;
            color: #fff;
        }

        .btn-secondary {
            background: #95a5a6;
            color: #fff;
        }

        .btn-primary:hover {
            background: #4FA564;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(95,181,116,0.4);
        }

        .btn-success:hover {
            background: #4FA564;
            transform: translateY(-2px);
        }

        .btn-danger:hover {
            background: #E67A4B;
            transform: translateY(-2px);
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem auto;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 8px solid #5FB574;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(95,181,116,0.15);
        }

        .stat-content {
            display: flex;
            flex-direction: column;
            z-index: 2;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #5FB574;
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #555;
            font-weight: 500;
        }

        /* ===== FILTERS ===== */
        .filters {
            background: #fff;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .status-buttons {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .rating-filter {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .rating-filter select {
            padding: 0.5rem 1rem;
            border: 2px solid #E8F4F8;
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
        }

        .rating-filter select:focus {
            outline: none;
            border-color: #5FB574;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            padding-top: 1rem;
        }

        .search-form input[type="text"] {
            flex: 1;
            min-width: 250px;
            padding: 0.7rem 1rem;
            border: 2px solid #E8F4F8;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .search-form input:focus {
            outline: none;
            border-color: #5FB574;
        }

        /* ===== BULK ACTION BAR ===== */
        .bulk-action-bar {
            background: #fff;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: none;
        }

        .bulk-action-bar.show {
            display: flex;
        }

        .selected-count {
            font-weight: 600;
            color: #5FB574;
        }

        .bulk-buttons {
            display: flex;
            gap: 0.8rem;
        }

        /* ===== TABLE CONTAINER ===== */
        .table-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow-x: auto;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
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

        th.checkbox-col {
            width: 40px;
            text-align: center;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            vertical-align: middle;
        }

        td.checkbox-col {
            text-align: center;
        }

        tr:hover td {
            background: #F7FCF9;
        }

        .select-all-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .row-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* ===== RATING STYLES ===== */
        .rating-stars {
            display: inline-flex;
            gap: 2px;
            align-items: center;
        }

        .star {
            font-size: 1.1rem;
            cursor: default;
        }

        .star.filled {
            color: #FFC107;
            text-shadow: 0 0 2px rgba(255,193,7,0.5);
        }

        .star.empty {
            color: #ddd;
        }

        .rating-value {
            margin-left: 6px;
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
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
            border: 1px solid #FFD4C4;
        }

        .badge-pending {
            background: #FFF4D6;
            color: #B58B00;
            border: 1px solid #FFE8A4;
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
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #E8F5EC;
            color: #4FA564;
            border: 2px solid #5FB574;
        }

        .alert-error {
            background: #FFE8E1;
            color: #D96F4A;
            border: 2px solid #FF8A5B;
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
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination .results-info {
            font-size: 0.9rem;
            color: #666;
        }

        .pagination .pagination-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
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
            background: #fff;
        }

        .pagination .btn-prev:hover:not(.disabled),
        .pagination .btn-next:hover:not(.disabled) {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
        }

        .pagination .btn-prev.disabled,
        .pagination .btn-next.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination .page-numbers {
            display: flex;
            gap: 0.3rem;
        }

        .pagination .page-number {
            padding: 0.5rem 0.9rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .pagination .page-number.active {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
        }

        .pagination .page-number:hover:not(.active) {
            background: #f0f0f0;
        }

        /* ===== RESPONSIVE ===== */
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
                margin-top: 3rem;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .search-form {
                flex-direction: column;
            }

            .search-form input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn-sm {
                width: 100%;
            }

            .bulk-action-bar {
                flex-direction: column;
                text-align: center;
            }
        }

        .btn-warning {
            background: #F9D56E;
            color: #333;
        }

        .btn-warning:hover {
            background: #e6c65c;
        }

        .clear-filter-btn {
            background: #FF8A5B;
            color: white;
        }

        .clear-filter-btn:hover {
            background: #E67A4B;
        }

        .fade-in {
            animation: fadeInRow 0.3s ease;
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #5FB574;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 10000;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .toast-notification.error {
            background: #FF8A5B;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .btn-download {
            background: #3498db;
            color: white;
        }

        .btn-download:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>
    <!-- Mobile Menu Components -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <div class="overlay" id="overlay"></div>

    <!-- Admin Layout -->
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>
                    <span class="logo-square"></span>
                    WALUYA LAND
                </h2>
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
                        <h4>{{ Auth::user()->name }}</h4>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1>⭐ Kelola Testimoni</h1>

                <div class="header-actions">
                    <!--<button onclick="downloadCSV()" class="btn btn-download">
                        📥 Download CSV
                    </button>-->
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
                        <div class="stat-label">Total Testimoni</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['approved'] ?? 0 }}</div>
                        <div class="stat-label">Disetujui</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['rejected'] ?? 0 }}</div>
                        <div class="stat-label">Ditolak</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <form method="GET" action="{{ route('admin.testimonials.index') }}" id="filterForm">
                    <div class="status-buttons">
                        <button type="submit" name="status" value="all" class="btn {{ request('status') == 'all' || request('status') == null ? 'btn-primary' : 'btn-secondary' }}">
                            Semua
                        </button>
                        <button type="submit" name="status" value="approved" class="btn {{ request('status') == 'approved' ? 'btn-success' : 'btn-secondary' }}">
                            Disetujui
                        </button>
                        <button type="submit" name="status" value="rejected" class="btn {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-secondary' }}">
                            Ditolak
                        </button>
                        <button type="submit" name="status" value="pending" class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-secondary' }}">
                            Menunggu
                        </button>
                    </div>

                    <div class="rating-filter">
                        <select name="rating" onchange="this.form.submit()">
                            <option value="all">Semua Rating</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang</option>
                            <option value="null" {{ request('rating') == 'null' ? 'selected' : '' }}>Belum Ada Rating</option>
                        </select>
                    </div>

                    <div class="search-form">
                        <input type="text" name="search" placeholder="Cari nama, email, atau testimoni..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        @if(request('search') || request('status') || request('rating'))
                            <a href="{{ route('admin.testimonials.index') }}" class="btn clear-filter-btn">Reset Filter</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Bulk Action Bar -->
            <div class="bulk-action-bar" id="bulkActionBar">
                <div>
                    <span class="selected-count" id="selectedCount">0</span> testimoni dipilih
                </div>
                <div class="bulk-buttons">
                    <button onclick="selectAll()" class="btn btn-secondary btn-sm">Pilih Semua</button>
                    <button onclick="deselectAll()" class="btn btn-secondary btn-sm">Batal Pilih</button>
                    <button onclick="bulkDelete()" class="btn btn-danger btn-sm">
                        🗑️ Hapus yang Dipilih
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <form id="bulkDeleteForm" action="{{ route('admin.testimonials.bulk-delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                </form>

                <table id="testimonialsTable">
                    <thead>
                        <tr>
                            <th class="checkbox-col">
                                <input type="checkbox" class="select-all-checkbox" id="selectAllCheckbox" onclick="toggleSelectAll()">
                            </th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Pesan Testimoni</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($testimonials as $testimonial)
                        <tr class="fade-in" data-id="{{ $testimonial->id }}">
                            <td class="checkbox-col">
                                <input type="checkbox" class="row-checkbox" data-id="{{ $testimonial->id }}" onclick="updateBulkActionBar()">
                            </td>
                            <td>
                                <strong>{{ $testimonial->name }}</strong>
                            </td>
                            <td>{{ $testimonial->email }}</td>
                            <td>
                                @php
                                    $rating = $testimonial->rating ?? 0;
                                @endphp
                                @if($rating > 0)
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $rating ? 'filled' : 'empty' }}">★</span>
                                        @endfor
                                        <span class="rating-value">({{ $rating }})</span>
                                    </div>
                                @else
                                    <span style="color: #999; font-size: 0.85rem;">Belum ada rating</span>
                                @endif
                             </td>
                            <td style="max-width: 250px;">
                                <div style="word-wrap: break-word; white-space: normal;">
                                    {{ Str::limit($testimonial->message, 80) }}
                                </div>
                            </td>
                            <td>{{ $testimonial->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($testimonial->status == 'approved')
                                    <span class="badge badge-approved">Disetujui</span>
                                @elseif($testimonial->status == 'rejected')
                                    <span class="badge badge-rejected">Ditolak</span>
                                @else
                                    <span class="badge badge-pending">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($testimonial->status == 'pending')
                                        <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui testimoni ini?')">
                                                ✅ Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.testimonials.reject', $testimonial->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Tolak testimoni ini?')">
                                                ❌ Tolak
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem; color: #999;">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                                <p>Belum ada testimoni</p>
                                <p style="font-size: 0.9rem; margin-top: 0.5rem;">Testimoni akan muncul setelah pengguna memberikan ulasan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($testimonials->hasPages())
                <div class="pagination">
                    <span class="results-info">
                        Menampilkan {{ $testimonials->firstItem() }} - {{ $testimonials->lastItem() }}
                        dari {{ $testimonials->total() }} data
                    </span>
                    <div class="pagination-links">
                        {{ $testimonials->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        // Mobile Menu
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        }
        if (overlay) {
            overlay.addEventListener('click', toggleMobileMenu);
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Toast notification
        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification' + (isError ? ' error' : '');
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // ==================== BULK ACTION FUNCTIONS ====================
        function updateBulkActionBar() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            const count = checkboxes.length;
            const bulkBar = document.getElementById('bulkActionBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const allCheckboxes = document.querySelectorAll('.row-checkbox');

            if (count > 0) {
                bulkBar.classList.add('show');
                selectedCountSpan.textContent = count;
            } else {
                bulkBar.classList.remove('show');
            }

            const totalCheckboxes = allCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked').length;

            if (checkedCheckboxes === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCheckboxes === totalCheckboxes) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.row-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateBulkActionBar();
        }

        function selectAll() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateBulkActionBar();
        }

        function deselectAll() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateBulkActionBar();
        }

        // ==================== BULK DELETE ====================
        function bulkDelete() {
            const selectedIds = [];
            document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });

            if (selectedIds.length === 0) {
                showToast('Tidak ada testimoni yang dipilih', true);
                return;
            }

            if (confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} testimoni yang dipilih?`)) {
                const form = document.getElementById('bulkDeleteForm');
                const idsInput = document.getElementById('bulkDeleteIds');
                idsInput.value = JSON.stringify(selectedIds);
                form.submit();
            }
        }

        // ==================== DOWNLOAD CSV ====================
        function downloadCSV() {
            const currentUrl = new URL(window.location.href);
            currentUrl.pathname = '{{ route("admin.testimonials.download-csv") }}';
            window.location.href = currentUrl.toString();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateBulkActionBar();

            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionBar);
            });
        });
    </script>
</body>
</html>
