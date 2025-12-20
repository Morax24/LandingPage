<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media - Admin</title>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .admin-header {
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

        .admin-header h1 {
            font-size: 1.8rem;
            color: #333;
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

        .btn-secondary {
            background: #95a5a6;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
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

        .btn-primary:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }

        .btn-primary:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-danger {
            background: #FFE8E1;
            color: #D96F4A;
            border: 2px solid #FF8A5B;
        }

        .alert-success {
            background: #E8F5EC;
            color: #4FA564;
            border: 2px solid #5FB574;
        }

        .upload-form {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #E8F4F8;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #5FB574;
            background: #F7FCF9;
        }

        .form-help {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.3rem;
            display: block;
        }

        .error-text {
            color: #FF8A5B;
            font-size: 0.85rem;
            display: block;
            margin-top: 0.3rem;
            font-weight: 500;
        }

        /* Container untuk multiple upload items */
        .upload-items-container {
            display: none;
            margin-top: 1.5rem;
        }

        .upload-items-container.active {
            display: block;
        }

        .upload-item {
            background: #F7FCF9;
            border: 2px solid #E8F4F8;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .upload-item:last-child {
            margin-bottom: 0;
        }

        .upload-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid #E8F4F8;
        }

        .upload-item-title {
            font-weight: 600;
            color: #5FB574;
            font-size: 1.1rem;
        }

        .upload-item-index {
            background: #5FB574;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .upload-item-content {
            display: grid;
            gap: 1.5rem;
        }

        .file-upload-area-small {
            border: 3px dashed #E8F4F8;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            background: #fff;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .file-upload-area-small:hover {
            border-color: #5FB574;
            background: #F7FCF9;
        }

        .file-upload-area-small.dragover {
            border-color: #5FB574;
            background: #E8F5EC;
        }

        .file-upload-icon-small {
            font-size: 2.5rem;
            color: #5FB574;
            margin-bottom: 0.8rem;
        }

        .file-upload-text-small {
            color: #555;
            margin-bottom: 0.3rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .file-preview-small {
            margin-top: 1rem;
            display: none;
        }

        .file-preview-small.active {
            display: block;
        }

        .preview-container-small {
            max-width: 100%;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 1rem;
            border: 2px solid #E8F4F8;
        }

        .preview-container-small img,
        .preview-container-small video {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .file-info-small {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 0.8rem;
            border: 2px solid #E8F4F8;
            font-size: 0.85rem;
        }

        .section-info {
            background: #E8F5EC;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin: 1rem 0;
            border-left: 4px solid #5FB574;
            display: none;
        }

        .section-info.active {
            display: block;
        }

        .section-info h4 {
            color: #4FA564;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .section-info ul {
            margin-left: 1.5rem;
            color: #555;
        }

        .section-info li {
            margin-bottom: 0.3rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #E8F4F8;
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

        .overlay.active {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                max-width: 90%;
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

            .admin-header {
                padding: 1rem;
                margin-top: 3rem;
            }

            .upload-form {
                padding: 1.5rem;
            }

            .file-upload-area-small {
                padding: 1.5rem 1rem;
            }

            .upload-item-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                text-align: center;
            }

            .admin-header h1 {
                font-size: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .file-upload-icon-small {
                font-size: 2rem;
            }

            .file-upload-text-small {
                font-size: 0.9rem;
            }

            .upload-form {
                padding: 1.2rem;
            }

            .form-group {
                margin-bottom: 1.2rem;
            }

            .upload-item {
                padding: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.5rem;
            }

            .admin-header {
                padding: 1rem;
                border-radius: 10px;
            }

            .admin-header h1 {
                font-size: 1.3rem;
            }

            .upload-form {
                padding: 1rem;
                border-radius: 10px;
            }

            .file-upload-area-small {
                padding: 1.2rem 0.8rem;
                border-radius: 10px;
                min-height: 120px;
            }

            .file-upload-icon-small {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
            }

            .file-upload-text-small {
                font-size: 0.85rem;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 0.7rem 0.8rem;
                font-size: 0.9rem;
            }

            .file-info-small {
                padding: 0.8rem;
                font-size: 0.8rem;
            }

            .upload-item-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .upload-item-index {
                align-self: flex-end;
            }

            .mobile-menu-toggle {
                top: 0.5rem;
                left: 0.5rem;
                padding: 0.5rem;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 360px) {
            .admin-header h1 {
                font-size: 1.2rem;
            }

            .upload-form {
                padding: 0.8rem;
            }

            .file-upload-area-small {
                padding: 1rem 0.5rem;
            }

            .btn {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }

            .form-help {
                font-size: 0.8rem;
            }

            .upload-item {
                padding: 1rem;
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
        <!-- =========================================== -->
        <!-- TAMBAH MENU TESTIMONI DI SINI -->
        <!-- =========================================== -->
        <a href="{{ route('admin.testimonials.index') }}" class="menu-item">
            <span class="menu-icon">⭐</span>
            <span>Kelola Testimoni</span>
        </a>
        <!-- =========================================== -->
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
            <div class="container">
                <!-- Header -->
                <div class="admin-header">
                    <h1>📤 Upload Media</h1>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <!-- Alert Messages -->
                @if(session('error'))
                <div class="alert alert-danger">
                    ✗ {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="upload-form" id="uploadForm">
                    @csrf

                    <!-- Section Selection -->
                    <div class="form-group">
                        <label for="section">Section *</label>
                        <select name="section" id="section" required onchange="updateSectionForm()">
                            <option value="">-- Pilih Section --</option>
                            <option value="hero" {{ old('section') == 'hero' ? 'selected' : '' }}>Intro (1 gambar)</option>
                            <option value="story" {{ old('section') == 'story' ? 'selected' : '' }}>Background (1 gambar)</option>
                            <option value="whylearn" {{ old('section') == 'whylearn' ? 'selected' : '' }}>Fitur 3 (1 gambar)</option>
                            <option value="features" {{ old('section') == 'features' ? 'selected' : '' }}>Fitur Unggulan (4 gambar)</option>
                            <option value="aktivitas" {{ old('section') == 'aktivitas' ? 'selected' : '' }}>Aktivitas & Tutorial (6 gambar)</option>
                            <option value="products" {{ old('section') == 'products' ? 'selected' : '' }}>Products (2 gambar)</option>
                        </select>
                        @error('section')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <small class="form-help" id="sectionHelp">Pilih di section mana media ini akan ditampilkan</small>
                    </div>

                    <!-- Section Info Box -->
                    <div class="section-info" id="sectionInfo">
                        <h4>📋 Informasi Section</h4>
                        <div id="sectionInfoContent"></div>
                    </div>

                    <!-- Container untuk multiple upload items -->
                    <div class="upload-items-container" id="uploadItemsContainer">
                        <!-- Items akan di-generate oleh JavaScript -->
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>📤 Upload Media</button>
                    </div>
                </form>
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

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });

        // KONFIGURASI SECTION YANG DIPERBAIKI:
        const sectionConfig = {
            'hero': { count: 1, name: 'Intro' },
            'story': { count: 1, name: 'Background' },
            'whylearn': { count: 1, name: 'Fitur 3' },
            'features': { count: 4, name: 'Fitur Unggulan' },
            'aktivitas': { count: 6, name: 'Aktivitas & Tutorial' },
            'products': { count: 2, name: 'Products' }
        };

        // Fungsi untuk update form berdasarkan section
        function updateSectionForm() {
            const section = document.getElementById('section').value;
            const container = document.getElementById('uploadItemsContainer');
            const sectionInfo = document.getElementById('sectionInfo');
            const sectionInfoContent = document.getElementById('sectionInfoContent');
            const submitBtn = document.getElementById('submitBtn');

            // Reset container
            container.innerHTML = '';
            sectionInfoContent.innerHTML = '';

            if (!section || !sectionConfig[section]) {
                container.classList.remove('active');
                sectionInfo.classList.remove('active');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '📤 Upload Media';
                return;
            }

            const config = sectionConfig[section];

            // Tampilkan info section
            sectionInfo.classList.add('active');
            sectionInfoContent.innerHTML = `
                <p><strong>${config.name}</strong> membutuhkan <strong>${config.count} gambar</strong>.</p>
                <p>Harap upload semua gambar berikut:</p>
                <ul>
                    ${Array.from({length: config.count}, (_, i) =>
                        `<li>Gambar ${i + 1}: ${getImageDescription(section, i)}</li>`
                    ).join('')}
                </ul>
            `;

            // Generate upload items
            container.classList.add('active');

            for (let i = 0; i < config.count; i++) {
                const itemNumber = i + 1;
                const itemId = `uploadItem${itemNumber}`;
                const fileInputId = `fileInput${itemNumber}`;
                const previewId = `preview${itemNumber}`;
                const fileInfoId = `fileInfo${itemNumber}`;

                // Di dalam fungsi updateSectionForm(), UBAH bagian Description agar selalu ada untuk semua section:

const itemHTML = `
    <div class="upload-item" id="${itemId}">
        <div class="upload-item-header">
            <div class="upload-item-title">${getItemTitle(section, i)}</div>
            <div class="upload-item-index">${itemNumber}</div>
        </div>

        <div class="upload-item-content">
            <!-- Type Selection -->
            <div class="form-group">
                <label for="type${itemNumber}">Tipe Media *</label>
                <select name="items[${i}][type]" id="type${itemNumber}" class="item-type" required onchange="updateFileAccept(this, '${fileInputId}')">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="image">Image</option>
                    <option value="video" ${section === 'products' ? 'disabled' : ''}>Video</option>
                </select>
                <small class="form-help">Format: JPEG, PNG, JPG, WEBP | Max: 5MB</small>
            </div>

            <!-- File Upload -->
            <div class="form-group">
                <label>File *</label>
                <div class="file-upload-area-small" id="uploadArea${itemNumber}" onclick="document.getElementById('${fileInputId}').click()">
                    <div class="file-upload-icon-small">📁</div>
                    <div class="file-upload-text-small">Klik atau drag & drop</div>
                    <small class="form-help">Max 10MB</small>
                </div>
                <input type="file" name="items[${i}][file]" id="${fileInputId}" class="item-file" accept="image/*" style="display: none;" onchange="handleFileSelect(event, '${previewId}', '${fileInfoId}', 'type${itemNumber}', 'uploadArea${itemNumber}')">

                <!-- File Preview -->
                <div class="file-preview-small" id="${previewId}">
                    <div class="preview-container-small" id="previewContainer${itemNumber}"></div>
                    <div class="file-info-small" id="${fileInfoId}"></div>
                </div>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="title${itemNumber}">Judul *</label>
                <input type="text" name="items[${i}][title]" id="title${itemNumber}" class="item-title" required placeholder="Masukkan judul">
            </div>

            <!-- Description - SELALU ADA UNTUK SEMUA SECTION -->
            <div class="form-group">
                <label for="description${itemNumber}">Deskripsi</label>
                <textarea name="items[${i}][description]"
                          id="description${itemNumber}"
                          class="item-description"
                          placeholder="Masukkan deskripsi (akan ditampilkan di website)"
                          rows="3">{{ old(`items.${i}.description`) }}</textarea>
                <small class="form-help">Deskripsi akan ditampilkan di landing page</small>
            </div>

            ${section === 'products' ? `
            <!-- Price Field (hanya untuk products) -->
            <div class="form-group">
                <label for="price${itemNumber}">Harga Produk (Rp) *</label>
                <input type="number"
                       name="items[${i}][price]"
                       id="price${itemNumber}"
                       class="item-price"
                       required
                       min="0"
                       max="9999999999.99"
                       step="0.01"
                       placeholder="Contoh: 300000">
                <small class="form-help">Harga maksimal: Rp 9.999.999.999,99</small>
            </div>
            ` : ''}

            <!-- Hidden section field -->
            <input type="hidden" name="items[${i}][section]" value="${section}">
            <input type="hidden" name="items[${i}][order]" value="${i}">
        </div>
    </div>
`;

                container.innerHTML += itemHTML;

                // Setup drag and drop untuk area kecil
                setupDragAndDrop(fileInputId, `uploadArea${itemNumber}`);

                // Setup price validation untuk products
                if (section === 'products') {
                    setupPriceValidation(`price${itemNumber}`, itemNumber);
                }
            }

            // Update submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = `📤 Upload ${config.count} Media`;
        }

        // Setup price validation
        function setupPriceValidation(priceInputId, itemNumber) {
            const priceInput = document.getElementById(priceInputId);
            if (!priceInput) return;

            priceInput.addEventListener('input', function(e) {
                let value = e.target.value;

                // Remove non-numeric characters except decimal point
                value = value.replace(/[^\d.]/g, '');

                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limit to 2 decimal places
                if (parts.length === 2 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                }

                // Check max value
                const numericValue = parseFloat(value);
                if (!isNaN(numericValue) && numericValue > 9999999999.99) {
                    alert(`Harga Produk ${itemNumber} terlalu besar! Maksimal Rp 9.999.999.999,99`);
                    value = '9999999999.99';
                }

                e.target.value = value;
            });

            priceInput.addEventListener('blur', function(e) {
                let value = parseFloat(e.target.value);
                if (!isNaN(value)) {
                    // Format to 2 decimal places
                    e.target.value = value.toFixed(2);
                }
            });
        }

        // Fungsi helper untuk deskripsi gambar
        function getImageDescription(section, index) {
            const descriptions = {
                'hero': ['Gambar utama board game'],
                'story': ['Gambar box di samping cerita'],
                'whylearn': ['Gambar Fitur 3'],
                'features': ['Fitur 1', 'Fitur 2', 'Fitur 3', 'Fitur 4'],
                'aktivitas': ['Aktivitas 1', 'Aktivitas 2', 'Aktivitas 3', 'Aktivitas 4', 'Aktivitas 5', 'Aktivitas 6'],
                'products': ['Produk 1', 'Produk 2']
            };
            return descriptions[section] ? descriptions[section][index] : `Gambar ${index + 1}`;
        }

        // Fungsi helper untuk judul item
        function getItemTitle(section, index) {
            const titles = {
                'hero': 'Gambar Hero',
                'story': 'Gambar Story',
                'whylearn': 'Gambar Fitur 3',
                'features': ['Fitur 1', 'Fitur 2', 'Fitur 3', 'Fitur 4'],
                'aktivitas': ['Aktivitas 1', 'Aktivitas 2', 'Aktivitas 3', 'Aktivitas 4', 'Aktivitas 5', 'Aktivitas 6'],
                'products': ['Produk 1', 'Produk 2']
            };

            if (section === 'hero' || section === 'story' || section === 'whylearn') {
                return titles[section];
            } else {
                return titles[section][index];
            }
        }

        // Update file accept berdasarkan tipe
        function updateFileAccept(selectElement, fileInputId) {
            const type = selectElement.value;
            const fileInput = document.getElementById(fileInputId);

            if (type === 'image') {
                fileInput.accept = 'image/jpeg,image/png,image/jpg,image/webp';
            } else if (type === 'video') {
                fileInput.accept = 'video/mp4,video/webm,video/ogg';
            } else {
                fileInput.accept = '';
            }
        }

        // Handle file selection untuk item kecil
        function handleFileSelect(event, previewId, fileInfoId, typeId, uploadAreaId) {
            const file = event.target.files[0];
            if (!file) return;

            const previewDiv = document.getElementById(previewId);
            const previewContainer = document.getElementById(previewId.replace('preview', 'previewContainer'));
            const fileInfo = document.getElementById(fileInfoId);
            const typeSelect = document.getElementById(typeId);
            const uploadArea = document.getElementById(uploadAreaId);

            // Validasi tipe file
            const type = typeSelect.value;
            if (!type) {
                alert('Pilih tipe media terlebih dahulu!');
                event.target.value = '';
                return;
            }

            // Validasi ukuran file
            const maxSize = type === 'image' ? 10 * 1024 * 1024 : 50 * 1024 * 1024; // 10MB untuk image, 50MB untuk video
            if (file.size > maxSize) {
                alert(`Ukuran file terlalu besar! Maksimal ${formatFileSize(maxSize)}`);
                event.target.value = '';
                return;
            }

            previewDiv.classList.add('active');

            // Display file info
            fileInfo.innerHTML = `
                <p><strong>Nama:</strong> ${file.name}</p>
                <p><strong>Ukuran:</strong> ${formatFileSize(file.size)}</p>
                <p><strong>Tipe:</strong> ${file.type}</p>
            `;

            // Display preview
            const reader = new FileReader();
            reader.onload = function(e) {
                if (type === 'image') {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-height: 200px;">`;
                } else if (type === 'video') {
                    previewContainer.innerHTML = `
                        <video controls style="max-height: 200px; width: 100%;">
                            <source src="${e.target.result}" type="${file.type}">
                        </video>
                    `;
                }
            };
            reader.readAsDataURL(file);

            // Auto-fill title
            const titleInput = event.target.closest('.upload-item').querySelector('.item-title');
            if (titleInput && !titleInput.value) {
                const filename = file.name.replace(/\.[^/.]+$/, "");
                titleInput.value = filename;
            }

            // Update upload area text
            if (uploadArea) {
                uploadArea.querySelector('.file-upload-text-small').textContent = 'File terpilih ✓';
                uploadArea.style.borderColor = '#5FB574';
                uploadArea.style.backgroundColor = '#E8F5EC';
            }
        }

        // Setup drag and drop untuk area kecil
        function setupDragAndDrop(fileInputId, uploadAreaId) {
            const uploadArea = document.getElementById(uploadAreaId);
            if (!uploadArea) return;

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const fileInput = document.getElementById(fileInputId);

                    // Create new DataTransfer to set file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    fileInput.files = dataTransfer.files;

                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            });
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Auto-call saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            // Jika ada old section, update form
            const oldSection = document.getElementById('section').value;
            if (oldSection && sectionConfig[oldSection]) {
                updateSectionForm();
            }

            // Setup form validation
            const form = document.getElementById('uploadForm');
            form.addEventListener('submit', function(e) {
                const section = document.getElementById('section').value;
                if (!section || !sectionConfig[section]) {
                    e.preventDefault();
                    alert('Pilih section terlebih dahulu!');
                    return;
                }

                // Validasi semua file sudah diupload
                const fileInputs = form.querySelectorAll('.item-file');
                let allFilesUploaded = true;
                let missingFiles = [];

                fileInputs.forEach((input, index) => {
                    if (!input.files || input.files.length === 0) {
                        allFilesUploaded = false;
                        missingFiles.push(index + 1);
                    }
                });

                if (!allFilesUploaded) {
                    e.preventDefault();
                    alert(`Harap upload semua file yang dibutuhkan untuk section ini!\n\nFile yang belum diupload: ${missingFiles.join(', ')}`);
                    return;
                }

                // Validasi semua tipe sudah dipilih
                const typeSelects = form.querySelectorAll('.item-type');
                let allTypesSelected = true;

                typeSelects.forEach((select, index) => {
                    if (!select.value) {
                        allTypesSelected = false;
                    }
                });

                if (!allTypesSelected) {
                    e.preventDefault();
                    alert('Harap pilih tipe media untuk semua file!');
                    return;
                }

                // Validasi semua title sudah diisi
                const titleInputs = form.querySelectorAll('.item-title');
                let allTitlesFilled = true;

                titleInputs.forEach((input, index) => {
                    if (!input.value.trim()) {
                        allTitlesFilled = false;
                    }
                });

                if (!allTitlesFilled) {
                    e.preventDefault();
                    alert('Harap isi judul untuk semua media!');
                    return;
                }

                // Validasi price untuk products
                if (section === 'products') {
                    const priceInputs = form.querySelectorAll('.item-price');
                    let allPricesValid = true;
                    let priceError = '';

                    priceInputs.forEach((input, index) => {
                        const price = parseFloat(input.value);
                        if (!input.value || isNaN(price) || price < 0) {
                            allPricesValid = false;
                            priceError = 'Harap isi harga yang valid untuk semua produk!';
                        } else if (price > 9999999999.99) {
                            allPricesValid = false;
                            priceError = `Harga Produk ${index + 1} terlalu besar! Maksimal Rp 9.999.999.999,99`;
                        }
                    });

                    if (!allPricesValid) {
                        e.preventDefault();
                        alert(priceError);
                        return;
                    }
                }
            });
        });
    </script>
</body>
</html>
