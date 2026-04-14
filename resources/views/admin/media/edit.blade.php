<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Media - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .btn-danger {
            background: #FF8A5B;
            color: #fff;
        }

        .btn-danger:hover {
            background: #E67A4B;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,138,91,0.4);
        }

        .btn-warning {
            background: #f39c12;
            color: #fff;
        }

        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }

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

        .alert-warning {
            background: #FFF3E0;
            color: #E67E22;
            border: 2px solid #F9D56E;
        }

        .edit-form {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .form-group { margin-bottom: 1.5rem; }

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

        .form-group input:disabled {
            background-color: #F0F0F0;
            color: #666;
            cursor: not-allowed;
            border-color: #E0E0E0;
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

        /* Media Upload Section */
        .media-upload-section {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .media-preview {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .media-preview img,
        .media-preview video {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            border: 2px solid #E8F4F8;
        }

        .file-input-wrapper {
            text-align: center;
            margin-bottom: 1rem;
        }

        .file-input-label {
            display: inline-block;
            background: #5FB574;
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            background: #4FA564;
            transform: translateY(-2px);
        }

        .file-info {
            margin-top: 1rem;
            padding: 1rem;
            background: #F7FCF9;
            border-radius: 10px;
            font-size: 0.85rem;
            color: #666;
        }

        .replace-btn {
            background: #f39c12;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: all 0.3s;
        }

        .replace-btn:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }

        .media-info {
            background: #F7FCF9;
            padding: 1.2rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: 2px solid #E8F4F8;
        }

        .media-info p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            color: #555;
        }

        .media-info strong {
            color: #5FB574;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #5FB574;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #E8F4F8;
        }

        .form-actions .left {
            display: flex;
            gap: 1rem;
        }

        .delete-form {
            margin-top: 1rem;
        }

        .delete-form button {
            width: 100%;
        }

        /* Style khusus untuk field yang hanya muncul untuk section tertentu */
        .conditional-field {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .conditional-field.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
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

            .edit-form,
            .media-upload-section {
                padding: 1.5rem;
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

            .form-actions .left {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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

            .edit-form,
            .media-upload-section {
                padding: 1rem;
                border-radius: 10px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 0.7rem 0.8rem;
                font-size: 0.9rem;
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
                <a href="{{ route('admin.testimonials.index') }}" class="menu-item">
                    <span class="menu-icon">⭐</span>
                    <span>Kelola Testimoni</span>
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
            <div class="container">
                <!-- Header -->
                <div class="admin-header">
                    <h1>✏️ Edit Media</h1>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">← Kembali</a>
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

                <!-- Media Upload Section -->
                <div class="media-upload-section">
                    <h3 style="margin-bottom: 1rem; color: #5FB574;">🖼️ Ganti Media</h3>

                    <!-- Media Preview -->
                    <div class="media-preview" id="mediaPreviewContainer">
                        @if($media->isImage())
                            <img src="{{ $media->getMediaUrl() }}" alt="{{ $media->title }}" id="currentMediaPreview">
                        @elseif($media->isVideo())
                            <video controls style="max-width: 100%; max-height: 300px;" id="currentMediaPreview">
                                <source src="{{ $media->getMediaUrl() }}" type="{{ $media->mime_type }}">
                            </video>
                        @endif
                        <div id="mediaError" style="display: none; color: #FF8A5B; margin-top: 1rem;">
                            <p>⚠️ Media tidak dapat ditampilkan. Pastikan file ada di lokasi yang benar.</p>
                        </div>
                    </div>

                    <!-- File Upload - Menerima semua jenis file (image & video) -->
                    <div class="file-input-wrapper">
                        <label class="file-input-label">
                            📁 Pilih File Baru (Gambar atau Video)
                            <input type="file" id="mediaFile" accept="image/*,video/*" style="display:none" onchange="previewNewMedia(this)">
                        </label>
                        <div>
                            <button type="button" class="replace-btn" onclick="document.getElementById('mediaFile').click()">
                                🔄 Ganti Media
                            </button>
                        </div>
                        <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">
                            📌 Format didukung: Gambar (JPG, PNG, WEBP, GIF) | Video (MP4, WebM, OGG)
                        </p>
                    </div>

                    <!-- New Media Preview -->
                    <div id="newMediaPreview" style="display: none; margin-top: 1rem;">
                        <p style="font-weight: 600; color: #5FB574; margin-bottom: 0.5rem;">📷 Preview Media Baru:</p>
                        <div id="newPreviewContainer" style="text-align: center;"></div>
                        <div class="file-info" id="newFileInfo"></div>
                    </div>
                </div>

                <!-- Media Info -->
                <div class="media-info">
                    <p><strong>Tipe Saat Ini:</strong> {{ strtoupper($media->type) }}</p>
                    <p><strong>Nama File:</strong> {{ $media->file_name }}</p>
                    <p><strong>Ukuran:</strong> {{ $media->file_size_formatted }}</p>
                    <p><strong>Diupload:</strong> {{ $media->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Diupload oleh:</strong> {{ $media->uploader->name ?? 'Unknown' }}</p>
                </div>

                <!-- Form Update -->
                <form action="{{ route('admin.media.update', $media->id) }}" method="POST" class="edit-form" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- File input (tersembunyi, akan dikirim jika ada file baru) -->
                    <input type="file" name="file" id="hiddenFileInput" style="display:none">

                    <!-- Title - SEMUA SECTION BISA EDIT JUDUL -->
                    <div class="form-group" id="titleGroup">
                        <label for="title" id="titleLabel">Judul *</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $media->title) }}">
                        <small class="form-help" id="titleHelp">Judul akan ditampilkan di website</small>
                        @error('title')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Section -->
                    <div class="form-group">
                        <label for="section">Section *</label>
                        <select name="section" id="section" required onchange="toggleFieldsBySection()">
                            <option value="">-- Pilih Section --</option>
                            <option value="hero" {{ old('section', $media->section) == 'hero' ? 'selected' : '' }}>🎯 Intro (1 gambar)</option>
                            <option value="story" {{ old('section', $media->section) == 'story' ? 'selected' : '' }}>📖 Background (1 gambar)</option>
                            <option value="whylearn" {{ old('section', $media->section) == 'whylearn' ? 'selected' : '' }}>💡 Fitur 3 (1 gambar)</option>
                            <option value="features" {{ old('section', $media->section) == 'features' ? 'selected' : '' }}>⭐ Fitur Unggulan (4 gambar)</option>
                            <option value="aktivitas" {{ old('section', $media->section) == 'aktivitas' ? 'selected' : '' }}>🎮 Aktivitas & Tutorial (6 gambar)</option>
                            <option value="products" {{ old('section', $media->section) == 'products' ? 'selected' : '' }}>📦 Products (2 gambar)</option>
                        </select>
                        @error('section')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <small class="form-help" id="sectionHelp">Pilih di section mana media ini akan ditampilkan</small>
                    </div>

                    <!-- Description Field - UNTUK FEATURES, AKTIVITAS, dan PRODUCTS -->
                    <div class="form-group conditional-field" id="descriptionField">
                        <label for="description" id="descriptionLabel">Deskripsi</label>
                        <textarea name="description" id="description" placeholder="Masukkan deskripsi (pisahkan fitur dengan baris baru)&#10;Contoh:&#10;Board game edukatif&#10;Includes 4 player pieces&#10;Dice & cards included" rows="4">{{ old('description', $media->description) }}</textarea>
                        @error('description')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <small class="form-help" id="descriptionHelp">Deskripsi akan ditampilkan di website</small>
                    </div>

                    <!-- Price Field - HANYA UNTUK PRODUCTS -->
                    <div class="form-group conditional-field" id="priceField">
                        <label for="price">Harga Produk (Rp) *</label>
                        <input type="number"
                               name="price"
                               id="price"
                               value="{{ old('price', $media->price ?? 0) }}"
                               min="0"
                               max="9999999999.99"
                               step="0.01"
                               placeholder="Contoh: 300000.00">
                        @error('price')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <small class="form-help">Hanya untuk section Products. Maksimal Rp 9.999.999.999,99</small>
                    </div>

                    <!-- Active Status -->
                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $media->is_active) ? 'checked' : '' }}>
                            <span>Aktifkan media ini</span>
                        </label>
                        <small class="form-help">Media yang tidak aktif tidak akan ditampilkan di landing page</small>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="left">
                            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        </div>
                    </div>
                </form>

                <!-- Form Delete (dipisah dari form update) -->
                <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin menghapus media ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">🗑️ Hapus Media</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Variabel untuk menyimpan file baru
        let newMediaFile = null;

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

        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });

        // Deteksi tipe file berdasarkan MIME type
        function detectFileType(file) {
            if (file.type.startsWith('image/')) {
                return 'image';
            } else if (file.type.startsWith('video/')) {
                return 'video';
            }
            return null;
        }

        // Preview media baru (bisa image atau video)
        function previewNewMedia(input) {
            const file = input.files[0];
            if (!file) return;

            // Validasi ukuran (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB!');
                input.value = '';
                return;
            }

            // Deteksi tipe file
            const fileType = detectFileType(file);
            if (!fileType) {
                alert('Tipe file tidak didukung! Gunakan gambar (JPG, PNG, WEBP) atau video (MP4, WebM).');
                input.value = '';
                return;
            }

            newMediaFile = file;

            // Simpan file ke hidden input untuk dikirim ke server
            const hiddenFileInput = document.getElementById('hiddenFileInput');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            hiddenFileInput.files = dataTransfer.files;

            // Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('newPreviewContainer');
                const fileInfo = document.getElementById('newFileInfo');

                if (fileType === 'image') {
                    previewContainer.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 2px solid #E8F4F8;">`;
                } else {
                    previewContainer.innerHTML = `<video controls style="max-width: 100%; max-height: 200px; border-radius: 8px;"><source src="${e.target.result}" type="${file.type}"></video>`;
                }

                fileInfo.innerHTML = `
                    <strong>File baru:</strong> ${file.name}<br>
                    <strong>Ukuran:</strong> ${formatFileSize(file.size)}<br>
                    <strong>Tipe:</strong> ${fileType === 'image' ? 'Gambar' : 'Video'} (${file.type})
                `;

                document.getElementById('newMediaPreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Section yang memiliki field DESKRIPSI (features, aktivitas, products)
        const sectionsWithDescription = ['features', 'aktivitas', 'products'];
        const sectionsWithPrice = ['products'];

        function toggleFieldsBySection() {
            const section = document.getElementById('section').value;
            const descriptionField = document.getElementById('descriptionField');
            const priceField = document.getElementById('priceField');
            const descriptionInput = document.getElementById('description');
            const priceInput = document.getElementById('price');
            const descriptionLabel = document.getElementById('descriptionLabel');
            const descriptionHelp = document.getElementById('descriptionHelp');
            const sectionHelp = document.getElementById('sectionHelp');

            const descriptions = {
                'hero': '🎯 Intro - gambar utama board game. Hanya 1 media aktif yang ditampilkan.',
                'story': '📖 Background - gambar box di samping cerita. Hanya 1 media aktif yang ditampilkan.',
                'whylearn': '💡 Fitur 3 - gambar fitur ketiga. Hanya 1 media aktif yang ditampilkan.',
                'features': '⭐ Fitur Unggulan - 4 slot yang ditampilkan. Bisa menambahkan deskripsi untuk setiap fitur.',
                'aktivitas': '🎮 Aktivitas & Tutorial - 6 slot yang ditampilkan. Bisa menambahkan deskripsi untuk setiap aktivitas.',
                'products': '📦 Products - gambar untuk bagian produk. 2 slot yang ditampilkan. HARUS DIISI DESKRIPSI DAN HARGA!'
            };

            if (section && descriptions[section]) {
                sectionHelp.textContent = descriptions[section];
                sectionHelp.style.color = '#5FB574';
                sectionHelp.style.fontWeight = '500';
            } else {
                sectionHelp.textContent = 'Pilih di section mana media ini akan ditampilkan';
                sectionHelp.style.color = '#666';
                sectionHelp.style.fontWeight = 'normal';
            }

            if (sectionsWithDescription.includes(section)) {
                descriptionField.classList.add('show');
                descriptionInput.required = false;

                if (section === 'products') {
                    descriptionLabel.innerHTML = 'Deskripsi Produk';
                    descriptionHelp.innerHTML = 'Deskripsi produk akan ditampilkan sebagai list fitur di halaman produk';
                } else if (section === 'features') {
                    descriptionLabel.innerHTML = 'Deskripsi Fitur';
                    descriptionHelp.innerHTML = 'Deskripsi fitur akan ditampilkan di halaman website';
                } else if (section === 'aktivitas') {
                    descriptionLabel.innerHTML = 'Deskripsi Aktivitas';
                    descriptionHelp.innerHTML = 'Deskripsi aktivitas akan ditampilkan di halaman website';
                }
            } else {
                descriptionField.classList.remove('show');
                descriptionInput.required = false;
            }

            if (sectionsWithPrice.includes(section)) {
                priceField.classList.add('show');
                priceInput.required = true;
            } else {
                priceField.classList.remove('show');
                priceInput.required = false;
                if (section !== 'products') {
                    priceInput.value = '0';
                }
            }
        }

        // Setup price validation
        function setupPriceValidation() {
            const priceInput = document.getElementById('price');
            if (!priceInput) return;

            priceInput.addEventListener('input', function(e) {
                let value = e.target.value;
                value = value.replace(/[^\d.]/g, '');
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                if (parts.length === 2 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                }
                const numericValue = parseFloat(value);
                if (!isNaN(numericValue) && numericValue > 9999999999.99) {
                    alert('Harga terlalu besar! Maksimal Rp 9.999.999.999,99');
                    value = '9999999999.99';
                }
                e.target.value = value;
            });

            priceInput.addEventListener('blur', function(e) {
                let value = parseFloat(e.target.value);
                if (!isNaN(value)) {
                    e.target.value = value.toFixed(2);
                }
            });
        }

        // Form validation
        function setupFormValidation() {
            const form = document.getElementById('editForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                const section = document.getElementById('section').value;
                const titleInput = document.getElementById('title');

                if (!titleInput.value.trim()) {
                    e.preventDefault();
                    alert('Harap isi judul!');
                    titleInput.focus();
                    return;
                }

                if (section === 'products') {
                    const priceInput = document.getElementById('price');
                    const price = parseFloat(priceInput.value);
                    if (!priceInput.value || isNaN(price) || price < 0) {
                        e.preventDefault();
                        alert('Harap isi harga yang valid untuk section Products!');
                        priceInput.focus();
                        return;
                    }
                    if (price > 9999999999.99) {
                        e.preventDefault();
                        alert('Harga terlalu besar! Maksimal Rp 9.999.999.999,99');
                        priceInput.focus();
                        return;
                    }
                }
            });
        }

        // Check if media loads successfully
        function checkMediaLoad() {
            const mediaElement = document.getElementById('currentMediaPreview');
            const errorDiv = document.getElementById('mediaError');

            if (mediaElement) {
                if (mediaElement.tagName === 'IMG') {
                    mediaElement.onerror = function() {
                        errorDiv.style.display = 'block';
                    };
                    mediaElement.onload = function() {
                        errorDiv.style.display = 'none';
                    };
                } else if (mediaElement.tagName === 'VIDEO') {
                    mediaElement.onerror = function() {
                        errorDiv.style.display = 'block';
                    };
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFieldsBySection();
            checkMediaLoad();
            setupPriceValidation();
            setupFormValidation();
        });
    </script>
</body>
</html>
