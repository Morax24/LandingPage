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
            background: #f5f5f5;
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
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.8);
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
            border-left-color: #fff;
            color: #fff;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            border-left-color: #fff;
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
            background: rgba(0,0,0,0.2);
            border-top: 1px solid rgba(255,255,255,0.1);
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
            background: rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .user-info h4 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .user-info p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
        }

        /* Header */
        .page-header {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: #333;
        }

        .btn-logout {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 0.7rem 1.8rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102,126,234,0.4);
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
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-card.total h3 { color: #3498db; }
        .stat-card.pending h3 { color: #f39c12; }
        .stat-card.approved h3 { color: #27ae60; }
        .stat-card.rejected h3 { color: #e74c3c; }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Filters */
        .filters {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            padding: 0.6rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        .filters input[type="text"] {
            flex: 1;
            min-width: 250px;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #3498db;
            color: #fff;
        }

        .btn-success {
            background: #27ae60;
            color: #fff;
        }

        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }

        .btn-warning {
            background: #f39c12;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Bulk Actions */
        .bulk-actions {
            background: #fff;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            display: none;
        }

        .bulk-actions.active {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .bulk-actions span {
            font-weight: 500;
        }

        /* Table */
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e9ecef;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d4edda;
            color: #155724;
        }

        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-header h2,
            .sidebar-header p,
            .menu-item span,
            .user-info,
            .sidebar-footer form {
                display: none;
            }

            .menu-item {
                justify-content: center;
                padding: 1.2rem;
            }

            .main-content {
                margin-left: 80px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>🏢 Admin Panel</h2>
                <p>Malaya Land Management</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.contacts.index') }}" class="menu-item active">
                    <span class="menu-icon">📧</span>
                    <span>Kelola Pesan</span>
                </a>
                <a href="http://127.0.0.1:8000/admin/media" class="menu-item">
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
                <div class="user-info">
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

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Pesan</p>
                </div>
                <div class="stat-card pending">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>Menunggu Review</p>
                </div>
                <div class="stat-card approved">
                    <h3>{{ $stats['approved'] }}</h3>
                    <p>Disetujui</p>
                </div>
                <div class="stat-card rejected">
                    <h3>{{ $stats['rejected'] }}</h3>
                    <p>Ditolak</p>
                </div>
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

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.contacts.index') }}" class="btn" style="background: #95a5a6; color: #fff;">Reset</a>
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
                                    @endif
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
                <div style="padding: 1.5rem; display: flex; justify-content: center;">
                    {{ $contacts->links() }}
                </div>
            </div>
        </main>
    </div>

    <script>
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
    </script>
</body>
</html>
