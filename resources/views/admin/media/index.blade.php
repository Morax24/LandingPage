<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Library - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #E8F4F8;
            color: #333;
        }

        /* Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
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
            vertical-align: middle;
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

        .menu-item:hover {
            background: rgba(255,255,255,0.15);
            border-left-color: #F9D56E;
            color: #fff;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            border-left-color: #F9D56E;
            color: #fff;
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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            width: calc(100% - 280px);
            transition: margin-left 0.3s ease;
        }

        /* Header */
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
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

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
        }

        .btn-primary {
            background: #5FB574;
            color: #fff;
        }

        .btn-primary:hover {
            background: #4FA564;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(95,181,116,0.4);
        }

        .btn-success {
            background: #5FB574;
            color: #fff;
        }

        .btn-success:hover {
            background: #4FA564;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #FF8A5B;
            color: #fff;
        }

        .btn-danger:hover {
            background: #E67A4B;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #F9D56E;
            color: #333;
        }

        .btn-warning:hover {
            background: #E9C55E;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #95a5a6;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .btn-info {
            background: #3498db;
            color: #fff;
        }

        .btn-info:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        /* Status Tabs */
        .status-tabs {
            display: flex;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .status-tab {
            flex: 1;
            padding: 1rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            color: #666;
        }

        .status-tab:hover {
            background: #f8f9fa;
        }

        .status-tab.active {
            background: #5FB574;
            color: #fff;
            border-bottom-color: #F9D56E;
        }

        .status-tab-count {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: #5FB574;
            font-weight: 700;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Filters */
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
            background: #F7FCF9;
        }

        .filters input[type="text"] {
            flex: 1;
            min-width: 200px;
        }

        /* Alert */
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

        .alert-danger {
            background: #FFE8E1;
            color: #D96F4A;
            border: 2px solid #FF8A5B;
        }

        /* Media List */
        .media-list {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 2rem;
        }

        .media-item {
            display: flex;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            align-items: flex-start;
            gap: 1rem;
        }

        .media-item:last-child {
            border-bottom: none;
        }

        .media-checkbox {
            margin-top: 0.5rem;
        }

        .media-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #5FB574;
        }

        .media-preview {
            width: 80px;
            height: 80px;
            background: #F7FCF9;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #E8F4F8;
            flex-shrink: 0;
        }

        .media-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .media-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .media-preview .icon {
            font-size: 2rem;
            color: #5FB574;
        }

        .media-details {
            flex: 1;
            min-width: 0;
        }

        .media-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
            font-size: 1.1rem;
            word-wrap: break-word;
        }

        .media-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .media-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.3rem;
        }

        .badge-image {
            background: #E8F4F8;
            color: #5FB574;
        }

        .badge-video {
            background: #FFE8E1;
            color: #FF8A5B;
        }

        .badge-active {
            background: #E8F5EC;
            color: #4FA564;
        }

        .badge-inactive {
            background: #FFE8E1;
            color: #D96F4A;
        }

        .media-section {
            font-weight: 600;
            color: #5FB574;
        }

        .media-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        /* Bulk Actions */
        .bulk-actions {
            background: #fff;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
            display: none;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .bulk-actions.active {
            display: flex;
        }

        .bulk-actions span {
            font-weight: 600;
            color: #5FB574;
            margin-right: 1rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 0;
            margin-top: 2rem;
            border-top: 1px solid #E8F4F8;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #666;
        }

        .pagination-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination-links a,
        .pagination-links span {
            padding: 0.7rem 1.2rem;
            border: 2px solid #E8F4F8;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }

        .pagination-links a:hover {
            background: #5FB574;
            color: #fff;
            border-color: #5FB574;
            transform: translateY(-2px);
        }

        .pagination-links .active {
            background: #5FB574;
            color: #fff;
            border-color: #5FB574;
        }

        .pagination-links .disabled {
            color: #ccc;
            cursor: not-allowed;
            border-color: #eee;
        }

        .pagination-links .disabled:hover {
            background: transparent;
            color: #ccc;
            border-color: #eee;
            transform: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .empty-state a {
            color: #5FB574;
            font-weight: 600;
            text-decoration: none;
        }

        .empty-state a:hover {
            text-decoration: underline;
        }

        /* Mobile Menu Toggle */
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

        /* Overlay for mobile */
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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

            .status-tabs {
                flex-direction: column;
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

            .bulk-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .media-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .media-preview {
                width: 100%;
                height: 200px;
            }

            .media-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .pagination {
                flex-direction: column;
                text-align: center;
            }

            .pagination-info {
                order: 2;
            }

            .pagination-links {
                order: 1;
                justify-content: center;
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

            .media-item {
                padding: 1rem;
            }

            .media-preview {
                height: 150px;
            }

            .media-actions {
                flex-direction: column;
                width: 100%;
            }

            .media-actions .btn {
                width: 100%;
                text-align: center;
            }

            .pagination-links a,
            .pagination-links span {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
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

            .media-badge {
                display: block;
                margin-right: 0;
                margin-bottom: 0.2rem;
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
                <a href="{{ route('admin.media.index') }}" class="menu-item active">
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
            <!-- Header -->
            <div class="page-header">
                <h1>📁 Media Library</h1>
                <div class="header-actions">
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <a href="{{ route('admin.media.create') }}" class="btn btn-primary">+ Upload Media</a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                ✗ {{ session('error') }}
            </div>
            @endif

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Media</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['images'] }}</h3>
                    <p>Images</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['videos'] }}</h3>
                    <p>Videos</p>
                </div>
                <div class="stat-card">
                    <h3>{{ number_format($stats['total_size'] / 1024 / 1024, 2) }} MB</h3>
                    <p>Total Size</p>
                </div>
            </div>

            <!-- Status Tabs -->
            <div class="status-tabs">
                <div class="status-tab {{ request('status', 'all') == 'all' ? 'active' : '' }}" onclick="changeStatus('all')">
                    Semua Media
                    <span class="status-tab-count">{{ $stats['total'] }}</span>
                </div>
                <div class="status-tab {{ request('status') == 'active' ? 'active' : '' }}" onclick="changeStatus('active')">
                    Aktif
                    <span class="status-tab-count">{{ $stats['active'] ?? 0 }}</span>
                </div>
                <div class="status-tab {{ request('status') == 'inactive' ? 'active' : '' }}" onclick="changeStatus('inactive')">
                    Nonaktif
                    <span class="status-tab-count">{{ $stats['inactive'] ?? 0 }}</span>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <form method="GET" action="{{ route('admin.media.index') }}" id="filterForm">
                    <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'all') }}">

                    <select name="type">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Type</option>
                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>

                    <select name="section">
                    <option value="all" {{ request('section') == 'all' ? 'selected' : '' }}>Semua Section</option>
                    <option value="hero" {{ request('section') == 'hero' ? 'selected' : '' }}>Intro</option>
                    <option value="story" {{ request('section') == 'story' ? 'selected' : '' }}>Background</option>
                    <option value="features" {{ request('section') == 'features' ? 'selected' : '' }}>Fitur Unggulan</option>
                    <option value="whylearn" {{ request('section') == 'whylearn' ? 'selected' : '' }}>Fitur 3</option>
                    <option value="aktivitas" {{ request('section') == 'aktivitas' ? 'selected' : '' }}>Aktivitas & Tutorial</option>
                    <option value="products" {{ request('section') == 'products' ? 'selected' : '' }}>Products</option> <!-- TAMBAHKAN INI -->
                </select>

                    <input type="text" name="search" placeholder="Cari media..." value="{{ request('search') }}">

                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <span id="selectedCount">0 dipilih</span>
                <button class="btn btn-secondary btn-sm" id="selectAllBtn" onclick="toggleSelectAll()">Pilih Semua</button>
                <button class="btn btn-danger btn-sm" onclick="bulkDelete()">Hapus</button>
                <button class="btn btn-warning btn-sm" onclick="bulkToggleActive(false)">Nonaktifkan</button>
                <button class="btn btn-success btn-sm" onclick="bulkToggleActive(true)">Aktifkan</button>
                <button class="btn btn-secondary btn-sm" onclick="cancelBulkActions()">Batal</button>
            </div>

            <!-- Media List -->
            <div class="media-list">
                @forelse($media as $item)
                <div class="media-item">
                    <div class="media-checkbox">
                        <input type="checkbox" class="media-check" value="{{ $item->id }}">
                    </div>

                    <div class="media-preview">
    @if($item->isImage())
        @php
            // Debug: lihat path aktual
            // dd($item->file_path, asset($item->file_path));
        @endphp

        <img src="{{ asset($item->file_path) }}"
             alt="{{ $item->title }}"
             loading="lazy"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/80/7cb342/ffffff?text=Error';">
    @elseif($item->isVideo())
        <video controls style="width: 100%; height: 100%;">
            <source src="{{ asset($item->file_path) }}" type="{{ $item->mime_type }}">
            Browser tidak mendukung video.
        </video>
    @else
        <div class="icon">📄</div>
    @endif
</div>

                    <div class="media-details">
                        <div class="media-title" title="{{ $item->title }}">{{ $item->title }}</div>

                        <div class="media-meta">
                            <span class="media-badge badge-{{ $item->type }}">{{ strtoupper($item->type) }}</span>
                            <span class="media-badge badge-{{ $item->is_active ? 'active' : 'inactive' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="media-meta">
                            Section: <strong>{{ ucfirst($item->section) }}</strong><br>
                            Size: {{ $item->file_size_formatted }}<br>
                            Uploaded: {{ $item->created_at->diffForHumans() }}
                        </div>

                        <div class="media-actions">
                            <a href="{{ route('admin.media.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus media ini?')">
    @csrf
    @method('DELETE')
    <!-- Sembunyikan parameter filter -->
    <input type="hidden" name="status" value="{{ request('status', 'all') }}">
    <input type="hidden" name="type" value="{{ request('type', 'all') }}">
    <input type="hidden" name="section" value="{{ request('section', 'all') }}">
    <input type="hidden" name="search" value="{{ request('search') }}">

    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>

                            <form action="{{ route('admin.media.toggle-active', $item->id) }}" method="POST" style="display:inline;">
    @csrf
    <!-- Sembunyikan parameter filter -->
    <input type="hidden" name="status" value="{{ request('status', 'all') }}">
    <input type="hidden" name="type" value="{{ request('type', 'all') }}">
    <input type="hidden" name="section" value="{{ request('section', 'all') }}">
    <input type="hidden" name="search" value="{{ request('search') }}">

    <button type="submit" class="btn btn-{{ $item->is_active ? 'secondary' : 'success' }} btn-sm">
        {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
    </button>
</form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    @if(request('status') == 'active')
                        Tidak ada media aktif.
                    @elseif(request('status') == 'inactive')
                        Tidak ada media nonaktif.
                    @else
                        Belum ada media. <a href="{{ route('admin.media.create') }}">Upload sekarang</a>
                    @endif
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">
                    @if($media->count() > 0)
                        Showing {{ $media->firstItem() }} to {{ $media->lastItem() }} of {{ $media->total() }} results
                    @else
                        Showing 0 results
                    @endif
                </div>

                <div class="pagination-links">
                    {{-- Previous Page Link --}}
                    @if ($media->onFirstPage())
                        <span class="disabled">&laquo; Previous</span>
                    @else
                        <a href="{{ $media->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($media->getUrlRange(1, $media->lastPage()) as $page => $url)
                        @if ($page == $media->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($media->hasMorePages())
                        <a href="{{ $media->nextPageUrl() }}" rel="next">Next &raquo;</a>
                    @else
                        <span class="disabled">Next &raquo;</span>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // Status tabs functionality
        function changeStatus(status) {
            document.getElementById('statusInput').value = status;
            document.getElementById('filterForm').submit();
        }

        // Checkbox handling
        let allSelected = false;
        document.querySelectorAll('.media-check').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.media-check:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const selectAllBtn = document.getElementById('selectAllBtn');

            if (checked.length > 0) {
                bulkActions.classList.add('active');
                selectedCount.textContent = checked.length + ' dipilih';

                // Update teks tombol Pilih Semua
                if (checked.length === document.querySelectorAll('.media-check').length) {
                    selectAllBtn.textContent = 'Batal Pilih Semua';
                    allSelected = true;
                } else {
                    selectAllBtn.textContent = 'Pilih Semua';
                    allSelected = false;
                }
            } else {
                bulkActions.classList.remove('active');
                selectAllBtn.textContent = 'Pilih Semua';
                allSelected = false;
            }
        }

        function toggleSelectAll() {
            const checkboxes = document.querySelectorAll('.media-check');

            if (allSelected) {
                // Batal pilih semua
                checkboxes.forEach(cb => cb.checked = false);
                allSelected = false;
                document.getElementById('selectAllBtn').textContent = 'Pilih Semua';
            } else {
                // Pilih semua
                checkboxes.forEach(cb => cb.checked = true);
                allSelected = true;
                document.getElementById('selectAllBtn').textContent = 'Batal Pilih Semua';
            }

            updateBulkActions();
        }

        function bulkDelete() {
            const checked = Array.from(document.querySelectorAll('.media-check:checked'));
            const ids = checked.map(cb => cb.value);

            if (ids.length === 0) {
                alert('Pilih minimal satu media');
                return;
            }

            if (!confirm(`Yakin ingin menghapus ${ids.length} media?`)) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.media.bulk-delete") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        function bulkToggleActive(isActive) {
    const checked = Array.from(document.querySelectorAll('.media-check:checked'));
    const ids = checked.map(cb => cb.value);

    if (ids.length === 0) {
        alert('Pilih minimal satu media');
        return;
    }

    const action = isActive ? 'mengaktifkan' : 'menonaktifkan';
    if (!confirm(`Yakin ingin ${action} ${ids.length} media?`)) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.media.bulk-toggle-active") }}';

    // Ambil filter status saat ini
    const currentStatus = document.getElementById('statusInput').value;
    const currentType = document.querySelector('select[name="type"]').value;
    const currentSection = document.querySelector('select[name="section"]').value;
    const currentSearch = document.querySelector('input[name="search"]').value;

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'is_active';
    statusInput.value = isActive ? '1' : '0';
    form.appendChild(statusInput);

    // Tambahkan parameter filter ke form
    const filterStatus = document.createElement('input');
    filterStatus.type = 'hidden';
    filterStatus.name = 'filter_status';
    filterStatus.value = currentStatus;
    form.appendChild(filterStatus);

    const filterType = document.createElement('input');
    filterType.type = 'hidden';
    filterType.name = 'filter_type';
    filterType.value = currentType;
    form.appendChild(filterType);

    const filterSection = document.createElement('input');
    filterSection.type = 'hidden';
    filterSection.name = 'filter_section';
    filterSection.value = currentSection;
    form.appendChild(filterSection);

    const filterSearch = document.createElement('input');
    filterSearch.type = 'hidden';
    filterSearch.name = 'filter_search';
    filterSearch.value = currentSearch;
    form.appendChild(filterSearch);

    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = id;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

function bulkDelete() {
    const checked = Array.from(document.querySelectorAll('.media-check:checked'));
    const ids = checked.map(cb => cb.value);

    if (ids.length === 0) {
        alert('Pilih minimal satu media');
        return;
    }

    if (!confirm(`Yakin ingin menghapus ${ids.length} media?`)) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.media.bulk-delete") }}';

    // Ambil filter saat ini
    const currentStatus = document.getElementById('statusInput').value;
    const currentType = document.querySelector('select[name="type"]').value;
    const currentSection = document.querySelector('select[name="section"]').value;
    const currentSearch = document.querySelector('input[name="search"]').value;

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Tambahkan parameter filter
    const filterStatus = document.createElement('input');
    filterStatus.type = 'hidden';
    filterStatus.name = 'filter_status';
    filterStatus.value = currentStatus;
    form.appendChild(filterStatus);

    const filterType = document.createElement('input');
    filterType.type = 'hidden';
    filterType.name = 'filter_type';
    filterType.value = currentType;
    form.appendChild(filterType);

    const filterSection = document.createElement('input');
    filterSection.type = 'hidden';
    filterSection.name = 'filter_section';
    filterSection.value = currentSection;
    form.appendChild(filterSection);

    const filterSearch = document.createElement('input');
    filterSearch.type = 'hidden';
    filterSearch.name = 'filter_search';
    filterSearch.value = currentSearch;
    form.appendChild(filterSearch);

    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = id;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

        function cancelBulkActions() {
            // Reset semua checkbox
            document.querySelectorAll('.media-check').forEach(cb => cb.checked = false);
            // Sembunyikan bulk actions
            document.getElementById('bulkActions').classList.remove('active');
            // Reset status
            allSelected = false;
            document.getElementById('selectAllBtn').textContent = 'Pilih Semua';
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>
