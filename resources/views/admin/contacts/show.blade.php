<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesan - {{ $contact->name }} | Waluya Land Admin</title>
    <style>
        /* ===========================================
           RESET & VARIABLES
        =========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #5FB574;
            --primary-dark: #4FA564;
            --secondary: #F9D56E;
            --secondary-dark: #E9C55E;
            --danger: #FF8A5B;
            --danger-dark: #E67A4B;
            --gray-light: #F7FCF9;
            --gray-border: #E8F4F8;
            --text-dark: #333;
            --text-gray: #666;
            --shadow: 0 2px 15px rgba(0,0,0,0.08);
            --shadow-hover: 0 5px 20px rgba(0,0,0,0.12);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-border);
            color: var(--text-dark);
        }

        /* ===========================================
           LAYOUT
        =========================================== */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===========================================
           SIDEBAR
        =========================================== */
        .sidebar {
            width: 280px;
            background: var(--primary);
            color: #fff;
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
            background: rgba(255,255,255,0.2);
            border-left-color: var(--secondary);
            color: #fff;
        }

        .menu-item.active {
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
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: var(--primary);
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
            background: var(--danger);
            color: #fff;
            padding: 0.7rem 1.8rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,138,91,0.4);
        }

        /* ===========================================
           MAIN CONTENT
        =========================================== */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            width: calc(100% - 280px);
            transition: margin-left 0.3s ease;
        }

        /* ===========================================
           HEADER
        =========================================== */
        .header {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h1 {
            font-size: 1.8rem;
            color: var(--text-dark);
        }

        /* ===========================================
           BUTTONS
        =========================================== */
        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-back {
            background: #95a5a6;
            color: #fff;
        }

        .btn-back:hover {
            background: #7f8c8d;
        }

        .btn-primary,
        .btn-success {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-success:hover {
            background: var(--primary-dark);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: var(--danger-dark);
        }

        .btn-warning {
            background: var(--secondary);
            color: var(--text-dark);
        }

        .btn-warning:hover {
            background: var(--secondary-dark);
        }

        /* ===========================================
           ALERTS
        =========================================== */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background: #E8F5EC;
            color: var(--primary-dark);
            border: 2px solid var(--primary);
        }

        .alert-info {
            background: var(--gray-border);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        /* ===========================================
           CARDS & CONTENT
        =========================================== */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 2rem;
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .card h2 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-border);
            color: var(--primary);
        }

        .info-row {
            margin-bottom: 1.5rem;
        }

        .info-row label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .info-row .value {
            padding: 1rem;
            background: var(--gray-light);
            border-radius: 10px;
            font-size: 0.95rem;
            border: 1px solid var(--gray-border);
        }

        .message-box {
            padding: 1.2rem;
            background: var(--gray-light);
            border-radius: 10px;
            line-height: 1.8;
            min-height: 150px;
            white-space: pre-wrap;
            border: 1px solid var(--gray-border);
        }

        .meta-info {
            background: var(--gray-light);
            padding: 1.2rem;
            border-radius: 10px;
            font-size: 0.85rem;
            color: #666;
            line-height: 1.8;
            border: 1px solid var(--gray-border);
        }

        .meta-info strong {
            color: var(--primary);
        }

        /* ===========================================
           BADGES
        =========================================== */
        .badge {
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending {
            background: #FFF4E6;
            color: #C29239;
        }

        .badge-approved {
            background: #E8F5EC;
            color: var(--primary-dark);
        }

        .badge-rejected {
            background: #FFE8E1;
            color: var(--danger-dark);
        }

        /* ===========================================
           ACTION SECTION
        =========================================== */
        .action-card {
            position: sticky;
            top: 2rem;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-buttons form,
        .action-buttons .btn {
            width: 100%;
        }

        .action-buttons .btn {
            justify-content: center;
        }

        .info-box {
            padding: 1rem;
            background: var(--gray-light);
            border-radius: 10px;
            text-align: center;
            color: #666;
            border: 1px solid var(--gray-border);
        }

        .meta-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--gray-border);
        }

        .meta-section h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .meta-text {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.8;
        }

        .meta-text strong {
            color: var(--text-dark);
        }

        /* ===========================================
           MODAL
        =========================================== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .modal-content h3 {
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .modal-content label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }

        .modal-content textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-border);
            border-radius: 10px;
            font-family: inherit;
            min-height: 100px;
            resize: vertical;
            margin-bottom: 1rem;
        }

        .modal-content textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* ===========================================
           MOBILE MENU
        =========================================== */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--primary);
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

        /* ===========================================
           RESPONSIVE DESIGN
        =========================================== */
        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 1.5fr 1fr;
                gap: 1.5rem;
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

            .header {
                margin-top: 3rem;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .action-card {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .card {
                padding: 1.2rem;
            }

            .card h2 {
                font-size: 1.2rem;
            }

            .btn {
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .modal-buttons .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.5rem;
            }

            .header {
                padding: 1rem;
            }

            .header h1 {
                font-size: 1.3rem;
            }

            .card {
                padding: 1rem;
            }

            .card h2 {
                font-size: 1.1rem;
            }

            .badge {
                padding: 0.4rem 1rem;
                font-size: 0.8rem;
            }

            .btn {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
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
                <h2>
                    <span class="logo-square"></span>
                    <span>WALUYA LAND</span>
                </h2>
                <p>Admin Panel</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="menu-item active">
                    <span class="menu-icon">📧</span>
                    <span>Kelola Pesan</span>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="menu-item">
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
            <!-- Header -->
            <div class="header">
                <h1>📧 Detail Pesan Contact</h1>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-back">← Kembali</a>
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

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Left Column - Informasi Pengirim -->
                <div>
                    <div class="card">
                        <h2>Informasi Pengirim</h2>

                        <div class="info-row">
                            <label>Nama Lengkap</label>
                            <div class="value">{{ $contact->name }}</div>
                        </div>

                        <div class="info-row">
                            <label>Email</label>
                            <div class="value">
                                <a href="mailto:{{ $contact->email }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>

                        <div class="info-row">
                            <label>Nomor HP / WhatsApp</label>
                            <div class="value">
                                @if($contact->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}"
                                       target="_blank"
                                       style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                        {{ $contact->phone }}
                                    </a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="info-row">
                            <label>Instansi / Sekolah</label>
                            <div class="value">{{ $contact->institution ?? '-' }}</div>
                        </div>

                        <div class="info-row">
                            <label>Status</label>
                            <div>
                                <span class="badge badge-{{ $contact->status }}">
                                    {{ $contact->status_text }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <label>Pesan</label>
                            <div class="message-box">{{ $contact->message }}</div>
                        </div>

                        @if($contact->approved_by)
                        <div class="meta-info">
                            <strong>Ditinjau oleh:</strong> {{ $contact->approver->name ?? 'Admin' }}<br>
                            <strong>Waktu:</strong> {{ $contact->approved_at->format('d/m/Y H:i') }}
                        </div>
                        @endif

                        @if($contact->admin_notes)
                        <div class="meta-info" style="margin-top: 1rem;">
                            <strong>Catatan Admin:</strong><br>
                            {{ $contact->admin_notes }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Aksi -->
                <div>
                    <div class="card action-card">
                        <h2>Aksi</h2>

                        <div class="action-buttons">
                            @if($contact->isPending())
                            <!-- Approve Button -->
                            <form action="{{ route('admin.contacts.approve', $contact->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menyetujui pesan ini?')">
                                    ✓ Setujui Pesan
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button type="button" class="btn btn-warning" onclick="openRejectModal()">
                                ✕ Tolak Pesan
                            </button>
                            @else
                            <div class="info-box">
                                ℹ️ Pesan sudah ditinjau
                            </div>
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')">
                                    🗑️ Hapus Pesan
                                </button>
                            </form>
                        </div>

                        <!-- Meta Information -->
                        <div class="meta-section">
                            <h3>Informasi Tambahan</h3>
                            <div class="meta-text">
                                <strong>📅 Diterima:</strong><br>
                                {{ $contact->created_at->format('d F Y, H:i') }}<br>
                                ({{ $contact->created_at->diffForHumans() }})<br><br>

                                <strong>🆔 ID Pesan:</strong><br>
                                #{{ $contact->id }}<br><br>

                                <strong>📝 Tipe:</strong><br>
                                {{ ucfirst($contact->type) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <h3>Tolak Pesan</h3>
            <form action="{{ route('admin.contacts.reject', $contact->id) }}" method="POST">
                @csrf
                <label>Alasan penolakan (opsional):</label>
                <textarea name="admin_notes" placeholder="Masukkan alasan penolakan..."></textarea>

                <div class="modal-buttons">
                    <button type="button" class="btn btn-back" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn btn-warning">Tolak Pesan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===========================================
        // MOBILE MENU FUNCTIONALITY
        // ===========================================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // Close mobile menu on window resize if screen becomes desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });

        // ===========================================
        // MODAL FUNCTIONS
        // ===========================================
        function openRejectModal() {
            document.getElementById('rejectModal').classList.add('active');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });
    </script>
</body>
</html>
