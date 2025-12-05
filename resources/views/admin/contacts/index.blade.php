<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Pesan Contact</title>
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
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,138,91,0.4);
        }

        /* Stats Cards */
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

        .stat-card.total h3 { color: #5FB574; }
        .stat-card.pending h3 { color: #F9D56E; }
        .stat-card.approved h3 { color: #5FB574; }
        .stat-card.rejected h3 { color: #FF8A5B; }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Tambahan style untuk stat card yang bisa diklik */
        .stat-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .stat-card .click-hint {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 0.7rem;
            color: #999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card:hover .click-hint {
            opacity: 1;
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
        }

        .filters input[type="text"] {
            flex: 1;
            min-width: 200px;
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

        /* Table - PERBAIKAN BAGIAN INI */
        .table-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow: hidden;
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
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        /* PERBAIKAN: Efek hover yang aman - tidak membuat teks hilang */
        tr:hover td {
            background: #F7FCF9;
            color: #333;
        }

        .badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending {
            background: #FFF4E6;
            color: #C29239;
            border: 1px solid #FFE4C2;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* Alert Messages */
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
            }

            .header-actions {
                justify-content: center;
            }

            .bulk-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-container {
                border-radius: 10px;
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
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
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
        }

        .pagination .current {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
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
                <!-- TAMBAHKAN LINK KE DASHBOARD -->
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="menu-item active">
                    <span class="menu-icon">📧</span>
                    <span>Kelola Pesan</span>
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
                    <button type="submit" class="btn-logout" style="width: 100%;">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1>📧 Kelola Pesan Contact</h1>
                <div class="header-actions">
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
            @endif

            @if(session('info'))
            <div class="alert alert-info">
                ℹ {{ session('info') }}
            </div>
            @endif

            <!-- Stats Cards dengan LINK -->
            <div class="stats-grid">
                <!-- Total Pesan -->
                <a href="{{ route('admin.contacts.index') }}" class="stat-link">
                    <div class="stat-card total">
                        <h3>{{ $stats['total'] }}</h3>
                        <p>Total Pesan</p>
                        <div class="click-hint">Klik untuk lihat semua</div>
                    </div>
                </a>

                <!-- Menunggu Review -->
                <a href="{{ route('admin.contacts.index', ['status' => 'pending']) }}" class="stat-link">
                    <div class="stat-card pending">
                        <h3>{{ $stats['pending'] }}</h3>
                        <p>Menunggu Review</p>
                        <div class="click-hint">Klik untuk lihat</div>
                    </div>
                </a>

                <!-- Disetujui -->
                <a href="{{ route('admin.contacts.index', ['status' => 'approved']) }}" class="stat-link">
                    <div class="stat-card approved">
                        <h3>{{ $stats['approved'] }}</h3>
                        <p>Disetujui</p>
                        <div class="click-hint">Klik untuk lihat</div>
                    </div>
                </a>

                <!-- Ditolak -->
                <a href="{{ route('admin.contacts.index', ['status' => 'rejected']) }}" class="stat-link">
                    <div class="stat-card rejected">
                        <h3>{{ $stats['rejected'] }}</h3>
                        <p>Ditolak</p>
                        <div class="click-hint">Klik untuk lihat</div>
                    </div>
                </a>
            </div>

            <!-- Filters -->
            <div class="filters">
                <form method="GET" action="{{ route('admin.contacts.index') }}">
                    <select name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <input type="text" name="search" placeholder="Cari nama, email, atau pesan..." value="{{ request('search') }}">

                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <span id="selectedCount">0 dipilih</span>
                <button class="btn btn-success btn-sm" onclick="bulkAction('approve')">Setujui Semua</button>
                <button class="btn btn-warning btn-sm" onclick="bulkAction('reject')">Tolak Semua</button>
                <button class="btn btn-danger btn-sm" onclick="bulkAction('delete')">Hapus Semua</button>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Instansi</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr>
                            <td><input type="checkbox" class="contact-checkbox" value="{{ $contact->id }}"></td>
                            <td><strong>{{ $contact->name }}</strong></td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->institution ?? '-' }}</td>
                            <td>{{ Str::limit($contact->message, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $contact->status }}">
                                    {{ $contact->status_text }}
                                </span>
                            </td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-primary btn-sm">Detail</a>

                                    @if($contact->isPending())
                                    <form action="{{ route('admin.contacts.approve', $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <!-- TAMBAHKAN TOMBOL TOLAK DI SINI -->
                                    <form action="{{ route('admin.contacts.reject', $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Yakin ingin menolak pesan ini?')">Tolak</button>
                                    </form>
                                    @endif

                                    <!-- Tombol Hapus untuk semua status -->
                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesan ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 2rem; color: #999;">
                                Tidak ada data pesan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $contacts->links() }}
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

        // Select All Checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.contact-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActions();
        });

        // Individual Checkbox
        document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        // Update Bulk Actions Display
        function updateBulkActions() {
            const checked = document.querySelectorAll('.contact-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (checked.length > 0) {
                bulkActions.classList.add('active');
                selectedCount.textContent = checked.length + ' dipilih';
            } else {
                bulkActions.classList.remove('active');
            }
        }

        // Bulk Actions
        function bulkAction(action) {
            const checked = Array.from(document.querySelectorAll('.contact-checkbox:checked'));
            const ids = checked.map(cb => cb.value);

            if (ids.length === 0) {
                alert('Pilih minimal satu pesan');
                return;
            }

            if (!confirm(`Yakin ingin ${action} ${ids.length} pesan?`)) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/contacts/bulk-') }}${action}`;

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

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });

        // Konfirmasi untuk aksi Setujui dan Tolak
        document.addEventListener('DOMContentLoaded', function() {
            const approveForms = document.querySelectorAll('form[action*="approve"]');
            const rejectForms = document.querySelectorAll('form[action*="reject"]');

            approveForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Yakin ingin menyetujui pesan ini?')) {
                        e.preventDefault();
                    }
                });
            });

            rejectForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Yakin ingin menolak pesan ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
