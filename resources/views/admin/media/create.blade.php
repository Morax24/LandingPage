<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Media | Admin Waluya Land</title>
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
            cursor: pointer;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.15);
            border-left-color: #F9D56E;
            color: #fff;
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
            max-width: 1400px;
            margin: 0 auto;
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

        .header-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #5FB574;
            color: #fff;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #4FA564;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(95,181,116,0.4);
        }

        .btn-secondary {
            background: #95a5a6;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #FF8A5B;
            color: #fff;
            padding: 0.3rem 0.8rem;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background: #e67e22;
        }

        .btn-back {
            background: #95a5a6;
            color: #fff;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: #E8F5EC;
            color: #4FA564;
            border: 2px solid #5FB574;
        }

        .alert-warning {
            background: #FFF3E0;
            color: #E67E22;
            border: 2px solid #F9D56E;
        }

        .alert-danger {
            background: #FFE8E1;
            color: #D96F4A;
            border: 2px solid #FF8A5B;
        }

        /* Section Card */
        .section-card {
            background: #fff;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .section-header {
            padding: 1.2rem 1.5rem;
            background: #F7FCF9;
            border-bottom: 2px solid #E8F4F8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .section-title h3 {
            font-size: 1.3rem;
            color: #5FB574;
        }

        .section-status {
            font-size: 0.8rem;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            background: #E8F4F8;
            color: #666;
        }

        .section-status.filled {
            background: #5FB574;
            color: #fff;
        }

        .section-body {
            padding: 1.5rem;
        }

        /* Single Upload */
        .single-upload {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .preview-box {
            width: 180px;
            height: 180px;
            background: #F7FCF9;
            border: 2px dashed #E8F4F8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .preview-box img, .preview-box video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-box .empty-text {
            text-align: center;
            color: #999;
        }

        .upload-controls {
            flex: 1;
            min-width: 200px;
        }

        .file-input-label {
            display: inline-block;
            background: #5FB574;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            margin-bottom: 0.8rem;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            background: #4FA564;
        }

        /* Upload Grid untuk Aktivitas */
        .upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .grid-item {
            background: #F7FCF9;
            border: 2px solid #E8F4F8;
            border-radius: 12px;
            padding: 0.8rem;
            text-align: center;
            position: relative;
            transition: all 0.3s;
        }

        .grid-item:hover {
            border-color: #5FB574;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .grid-item .preview-img, .grid-item .preview-video {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .grid-item .empty-placeholder {
            width: 100%;
            height: 120px;
            background: #fff;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 2rem;
            color: #ccc;
        }

        .grid-item .empty-placeholder:hover {
            border-color: #5FB574;
            background: #F7FCF9;
            color: #5FB574;
        }

        .grid-item .item-order {
            font-size: 0.7rem;
            color: #5FB574;
            font-weight: bold;
            margin-top: 0.3rem;
        }

        .grid-item .media-badge {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
        }

        .btn-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #FF8A5B;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-remove:hover {
            background: #e67e22;
            transform: scale(1.1);
        }

        /* Feature & Product Card */
        .features-container, .products-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .feature-card, .product-card {
            background: #F7FCF9;
            border: 2px solid #E8F4F8;
            border-radius: 12px;
            padding: 1.2rem;
            position: relative;
        }

        .feature-card .feature-header, .product-card .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #E8F4F8;
        }

        .feature-card .feature-header strong, .product-card .product-header strong {
            color: #5FB574;
            font-size: 1.1rem;
        }

        .feature-form, .product-form {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 1rem;
        }

        .feature-preview, .product-preview {
            width: 120px;
            height: 120px;
            background: #fff;
            border: 2px dashed #E8F4F8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .feature-preview:hover, .product-preview:hover {
            border-color: #5FB574;
            background: #F7FCF9;
        }

        .feature-preview img, .feature-preview video,
        .product-preview img, .product-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .feature-fields, .product-fields {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .feature-fields input, .feature-fields textarea,
        .product-fields input, .product-fields textarea {
            padding: 0.7rem;
            border: 2px solid #E8F4F8;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .feature-fields input:focus, .feature-fields textarea:focus,
        .product-fields input:focus, .product-fields textarea:focus {
            outline: none;
            border-color: #5FB574;
        }

        .feature-fields textarea, .product-fields textarea {
            min-height: 80px;
            resize: vertical;
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

        /* Loading Spinner */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
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
            .feature-form, .product-form {
                grid-template-columns: 1fr;
            }
            .single-upload {
                flex-direction: column;
                align-items: center;
            }
            .upload-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <div class="overlay" id="overlay"></div>

    <div class="admin-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><span class="logo-square"></span> WALUYA LAND</h2>
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

        <main class="main-content">
            <div class="container">
                <div class="page-header">
                    <div class="header-buttons">
                        <a href="{{ route('admin.media.index') }}" class="btn-back">← Kembali</a>
                    </div>
                    <h1>🖼️ Manajemen Media</h1>
                    <div class="header-buttons">
                        <button class="btn-primary" id="saveAllBtn">💾 Simpan Semua</button>
                    </div>
                </div>

                <div id="alertContainer"></div>

                <!-- HERO SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Hero Banner</h3>
                            <span class="section-status" id="heroStatus">○ Kosong</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="single-upload">
                            <div class="preview-box" id="heroPreview"><div class="empty-text">Belum ada media</div></div>
                            <div class="upload-controls">
                                <label class="file-input-label">📁 Upload<input type="file" id="heroInput" accept="image/*,video/*" style="display:none"></label>
                                <button class="btn-secondary" id="heroRemoveBtn" style="display:none">Hapus</button>
                                <!-- <p><small>Format: JPG, PNG, WEBP, GIF (gambar) / MP4, WebM (video). Max 10MB</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STORY SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Story / Background</h3>
                            <span class="section-status" id="storyStatus">○ Kosong</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="single-upload">
                            <div class="preview-box" id="storyPreview"><div class="empty-text">Belum ada media</div></div>
                            <div class="upload-controls">
                                <label class="file-input-label">📁 Upload<input type="file" id="storyInput" accept="image/*,video/*" style="display:none"></label>
                                <button class="btn-secondary" id="storyRemoveBtn" style="display:none">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WHY LEARN SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Latar Belakang</h3>
                            <span class="section-status" id="whylearnStatus">○ Kosong</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="single-upload">
                            <div class="preview-box" id="whylearnPreview"><div class="empty-text">Belum ada media</div></div>
                            <div class="upload-controls">
                                <label class="file-input-label">📁 Upload<input type="file" id="whylearnInput" accept="image/*,video/*" style="display:none"></label>
                                <button class="btn-secondary" id="whylearnRemoveBtn" style="display:none">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FEATURES SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Fitur Unggulan</h3>
                            <span class="section-status" id="featuresStatus">○ 0/4 Terisi</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="features-container" id="featuresContainer"></div>
                        <button class="btn-secondary" id="addFeatureBtn" style="margin-top:1rem">+ Tambah Fitur Baru</button>
                    </div>
                </div>

                <!-- AKTIVITAS SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Aktivitas & Tutorial</h3>
                            <span class="section-status" id="aktivitasStatus">○ 0/6 Terisi</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="upload-grid" id="aktivitasGrid"></div>
                        <label class="file-input-label" style="display:inline-block; margin-top:0.5rem">
                            📁 Upload
                            <input type="file" id="aktivitasInput" accept="image/*,video/*" multiple style="display:none">
                        </label>
                        <!-- <p style="margin-top: 0.8rem; color: #666; font-size: 0.8rem;">
                            💡 Tips: Pilih beberapa file sekaligus (Ctrl+Click atau Shift+Click)
                        </p>-->
                    </div>
                </div>

                <!-- PRODUCTS SECTION -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <h3>Produk</h3>
                            <span class="section-status" id="productsStatus">○ 0/2 Terisi</span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="products-container" id="productsContainer"></div>
                        <button class="btn-secondary" id="addProductBtn" style="margin-top:1rem">+ Tambah Produk Baru</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // DATA STATE
        let mediaData = {
            hero: { file: null, preview: null, id: null },
            story: { file: null, preview: null, id: null },
            whylearn: { file: null, preview: null, id: null },
            features: [],
            aktivitas: [],
            products: []
        };

        const MAX_FEATURES = 4;
        const MAX_AKTIVITAS = 6;
        const MAX_PRODUCTS = 2;

        // Helper functions
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function showAlert(message, type, autoRedirect = false) {
            const container = document.getElementById('alertContainer');
            const icon = type === 'success' ? '✓' : (type === 'warning' ? '⚠️' : '✗');
            container.innerHTML = `<div class="alert alert-${type}">${icon} ${message}</div>`;
            if (autoRedirect && type === 'success') {
                setTimeout(() => window.location.href = '{{ route("admin.media.index") }}', 1500);
            } else {
                setTimeout(() => container.innerHTML = '', 3000);
            }
        }

        function createPreview(file, callback) {
            const reader = new FileReader();
            reader.onload = e => callback(e.target.result);
            reader.readAsDataURL(file);
        }

        function getMediaType(file) {
            return file.type.startsWith('image/') ? 'image' : 'video';
        }

        function updateStatus(elementId, filled, max) {
            const el = document.getElementById(elementId);
            if (el) {
                if (filled > 0) {
                    el.innerHTML = `● ${filled}/${max} Terisi`;
                    el.classList.add('filled');
                } else {
                    el.innerHTML = `○ ${filled}/${max} Terisi`;
                    el.classList.remove('filled');
                }
            }
        }

        // ========== SINGLE UPLOAD (Hero, Story, WhyLearn) ==========
        function setupSingleUpload(inputId, section, previewId, removeBtnId, statusId) {
            const input = document.getElementById(inputId);
            const previewDiv = document.getElementById(previewId);
            const removeBtn = document.getElementById(removeBtnId);

            if (!input || !previewDiv || !removeBtn) return;

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 10 * 1024 * 1024) {
                        showAlert('Ukuran file maksimal 10MB!', 'danger');
                        input.value = '';
                        return;
                    }
                    const type = getMediaType(file);
                    createPreview(file, (previewUrl) => {
                        if (type === 'image') {
                            previewDiv.innerHTML = `<img src="${previewUrl}" style="width:100%; height:100%; object-fit:cover">`;
                        } else {
                            previewDiv.innerHTML = `<video src="${previewUrl}" style="width:100%; height:100%; object-fit:cover" controls></video>`;
                        }
                        mediaData[section] = { file: file, preview: previewUrl };
                        removeBtn.style.display = 'inline-block';
                        updateStatus(statusId, 1, 1);
                    });
                }
            });

            removeBtn.addEventListener('click', function() {
                previewDiv.innerHTML = '<div class="empty-text">Belum ada media</div>';
                mediaData[section] = { file: null, preview: null };
                removeBtn.style.display = 'none';
                updateStatus(statusId, 0, 1);
                input.value = '';
            });
        }

        // ========== FEATURES ==========
        function renderFeatures() {
            const container = document.getElementById('featuresContainer');
            if (!container) return;
            container.innerHTML = '';

            for (let i = 0; i < MAX_FEATURES; i++) {
                const feat = mediaData.features[i];
                const hasMedia = feat && feat.preview;
                const mediaType = feat?.type || 'image';

                container.innerHTML += `
                    <div class="feature-card">
                        <div class="feature-header">
                            <strong>Fitur ${i + 1}</strong>
                            <button class="btn-danger" onclick="removeFeature(${i})">Hapus</button>
                        </div>
                        <div class="feature-form">
                            <div class="feature-preview" onclick="document.getElementById('featureFile${i}').click()">
                                ${hasMedia ? (mediaType === 'image' ? `<img src="${feat.preview}">` : `<video src="${feat.preview}"></video>`) : '📷 + Media'}
                            </div>
                            <div class="feature-fields">
                                <input type="text" id="featureTitle${i}" placeholder="Judul" value="${feat ? escapeHtml(feat.title || '') : ''}" onchange="updateFeature(${i}, 'title', this.value)">
                                <textarea id="featureDesc${i}" placeholder="Deskripsi " rows="3" onchange="updateFeature(${i}, 'description', this.value)">${feat ? escapeHtml(feat.description || '') : ''}</textarea>
                            </div>
                            <input type="file" id="featureFile${i}" accept="image/*,video/*" style="display:none" onchange="handleFeatureFile(${i}, this)">
                        </div>
                    </div>
                `;
            }

            const filled = mediaData.features.filter(f => f !== null && (f.file !== null || (f.title && f.title.trim()))).length;
            updateStatus('featuresStatus', filled, MAX_FEATURES);
        }

        window.updateFeature = function(idx, field, value) {
            if (!mediaData.features[idx]) {
                mediaData.features[idx] = { file: null, preview: null, title: '', description: '' };
            }
            mediaData.features[idx][field] = value;
        };

        window.handleFeatureFile = function(idx, input) {
            const file = input.files[0];
            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    showAlert('Ukuran file maksimal 10MB!', 'danger');
                    input.value = '';
                    return;
                }
                const type = getMediaType(file);
                createPreview(file, (previewUrl) => {
                    if (!mediaData.features[idx]) {
                        mediaData.features[idx] = { file: null, preview: null, title: '', description: '' };
                    }
                    mediaData.features[idx].file = file;
                    mediaData.features[idx].preview = previewUrl;
                    mediaData.features[idx].type = type;
                    renderFeatures();
                });
            }
        };

        window.removeFeature = function(idx) {
            mediaData.features[idx] = null;
            renderFeatures();
        };

        // ========== AKTIVITAS ==========
        function renderAktivitasGrid() {
            const grid = document.getElementById('aktivitasGrid');
            if (!grid) return;
            grid.innerHTML = '';

            for (let i = 0; i < MAX_AKTIVITAS; i++) {
                const item = mediaData.aktivitas[i];
                if (item && item.preview) {
                    grid.innerHTML += `
                        <div class="grid-item">
                            <button class="btn-remove" onclick="removeAktivitasItem(${i})">✕</button>
                            ${item.type === 'image' ?
                                `<img src="${item.preview}" class="preview-img">` :
                                `<video src="${item.preview}" class="preview-video"></video>`
                            }
                            <div class="item-order">${item.type === 'image' ? '🖼️ Gambar' : '🎥 Video'} ${i + 1}</div>
                            <div class="media-badge">${item.type === 'image' ? 'Gambar' : 'Video'}</div>
                        </div>
                    `;
                } else {
                    grid.innerHTML += `
                        <div class="grid-item">
                            <div class="empty-placeholder" onclick="addToAktivitas(${i})">📷</div>
                            <div class="item-order">Kosong</div>
                        </div>
                    `;
                }
            }

            const filled = mediaData.aktivitas.filter(f => f !== null).length;
            updateStatus('aktivitasStatus', filled, MAX_AKTIVITAS);
        }

        window.addToAktivitas = function(index) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*,video/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 10 * 1024 * 1024) {
                        showAlert('Ukuran file maksimal 10MB!', 'danger');
                        return;
                    }
                    const type = getMediaType(file);
                    createPreview(file, (previewUrl) => {
                        mediaData.aktivitas[index] = { file: file, preview: previewUrl, type: type };
                        renderAktivitasGrid();
                    });
                }
            };
            input.click();
        };

        window.removeAktivitasItem = function(index) {
            mediaData.aktivitas[index] = null;
            renderAktivitasGrid();
        };

        function handleMultipleUpload(inputId, maxCount) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                let currentCount = mediaData.aktivitas.filter(f => f !== null).length;
                let availableSlots = maxCount - currentCount;

                if (availableSlots <= 0) {
                    showAlert(`Slot sudah penuh! Maksimal ${maxCount} media.`, 'warning');
                    input.value = '';
                    return;
                }

                const filesToAdd = files.slice(0, availableSlots);
                filesToAdd.forEach((file) => {
                    if (file.size > 10 * 1024 * 1024) {
                        showAlert(`File ${file.name} terlalu besar! Maksimal 10MB.`, 'warning');
                        return;
                    }
                    const type = getMediaType(file);
                    createPreview(file, (previewUrl) => {
                        const emptyIndex = mediaData.aktivitas.findIndex(f => f === null);
                        if (emptyIndex !== -1) {
                            mediaData.aktivitas[emptyIndex] = { file: file, preview: previewUrl, type: type };
                            renderAktivitasGrid();
                        }
                    });
                });

                if (filesToAdd.length < files.length) {
                    showAlert(`Hanya ${availableSlots} slot tersisa. ${files.length - filesToAdd.length} file tidak ditambahkan.`, 'warning');
                }
                input.value = '';
            });
        }

        // ========== PRODUCTS ==========
        function renderProducts() {
            const container = document.getElementById('productsContainer');
            if (!container) return;
            container.innerHTML = '';

            for (let i = 0; i < MAX_PRODUCTS; i++) {
                const prod = mediaData.products[i];
                const hasMedia = prod && prod.preview;
                const mediaType = prod?.type || 'image';

                container.innerHTML += `
                    <div class="product-card">
                        <div class="product-header">
                            <strong>Produk ${i + 1}</strong>
                            <button class="btn-danger" onclick="removeProduct(${i})">Hapus</button>
                        </div>
                        <div class="product-form">
                            <div class="product-preview" onclick="document.getElementById('prodFile${i}').click()">
                                ${hasMedia ? (mediaType === 'image' ? `<img src="${prod.preview}">` : `<video src="${prod.preview}"></video>`) : '📷 + Media'}
                            </div>
                            <div class="product-fields">
                                <input type="text" id="prodTitle${i}" placeholder="Judul Produk" value="${prod ? escapeHtml(prod.title || '') : ''}" onchange="updateProduct(${i}, 'title', this.value)">
                                <input type="number" id="prodPrice${i}" placeholder="Harga (Rp)" value="${prod ? prod.price || '' : ''}" onchange="updateProduct(${i}, 'price', this.value)">
                                <textarea id="prodDesc${i}" placeholder="Deskripsi Produk (pisahkan fitur dengan baris baru)" rows="3" onchange="updateProduct(${i}, 'description', this.value)">${prod ? escapeHtml(prod.description || '') : ''}</textarea>
                            </div>
                            <input type="file" id="prodFile${i}" accept="image/*,video/*" style="display:none" onchange="handleProductFile(${i}, this)">
                        </div>
                    </div>
                `;
            }

            const filled = mediaData.products.filter(p => p !== null && (p.file !== null || (p.title && p.title.trim()))).length;
            updateStatus('productsStatus', filled, MAX_PRODUCTS);

            const addBtn = document.getElementById('addProductBtn');
            if (addBtn) addBtn.style.display = mediaData.products.length >= MAX_PRODUCTS ? 'none' : 'inline-block';
        }

        window.updateProduct = function(idx, field, value) {
            if (!mediaData.products[idx]) {
                mediaData.products[idx] = { file: null, preview: null, title: '', price: '', description: '' };
            }
            mediaData.products[idx][field] = value;
        };

        window.handleProductFile = function(idx, input) {
            const file = input.files[0];
            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    showAlert('Ukuran file maksimal 10MB!', 'danger');
                    input.value = '';
                    return;
                }
                const type = getMediaType(file);
                createPreview(file, (previewUrl) => {
                    if (!mediaData.products[idx]) {
                        mediaData.products[idx] = { file: null, preview: null, title: '', price: '', description: '' };
                    }
                    mediaData.products[idx].file = file;
                    mediaData.products[idx].preview = previewUrl;
                    mediaData.products[idx].type = type;
                    renderProducts();
                });
            }
        };

        window.removeProduct = function(idx) {
            mediaData.products[idx] = null;
            renderProducts();
        };

        // ========== SAVE ALL ==========
        async function saveAllMedia() {
            const saveBtn = document.getElementById('saveAllBtn');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<span class="loading"></span> Menyimpan...';
            saveBtn.disabled = true;

            try {
                const formData = new FormData();

                // Single sections
                if (mediaData.hero && mediaData.hero.file) {
                    formData.append('hero', mediaData.hero.file);
                }
                if (mediaData.story && mediaData.story.file) {
                    formData.append('story', mediaData.story.file);
                }
                if (mediaData.whylearn && mediaData.whylearn.file) {
                    formData.append('whylearn', mediaData.whylearn.file);
                }

                // Features
                const featuresData = [];
                mediaData.features.forEach((feat, idx) => {
                    if (feat && (feat.file || (feat.title && feat.title.trim()))) {
                        featuresData.push({
                            title: feat.title || '',
                            description: feat.description || '',
                            order: idx
                        });
                        if (feat.file) {
                            formData.append(`feature_images[]`, feat.file);
                        }
                    }
                });
                formData.append('features_data', JSON.stringify(featuresData));

                // Aktivitas
                mediaData.aktivitas.forEach((act) => {
                    if (act && act.file) {
                        formData.append(`aktivitas[]`, act.file);
                    }
                });

                // Products
                const productsData = mediaData.products.map(p => ({
                    title: p?.title || '',
                    price: p?.price || '',
                    description: p?.description || ''
                }));
                formData.append('products_data', JSON.stringify(productsData));

                mediaData.products.forEach((p) => {
                    if (p && p.file) {
                        formData.append(`product_images[]`, p.file);
                    }
                });

                const response = await fetch('{{ route("admin.media.storeAll") }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                const result = await response.json();
                if (result.success) {
                    showAlert(result.message || 'Semua media berhasil disimpan!', 'success', true);
                } else {
                    showAlert('Gagal menyimpan: ' + (result.message || 'Terjadi kesalahan'), 'danger');
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan saat menyimpan data.', 'danger');
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        }

        // ========== MOBILE MENU ==========
        function initMobileMenu() {
            const toggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    overlay.classList.toggle('active');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                });
            }
        }

        // ========== INIT ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi array
            for (let i = 0; i < MAX_FEATURES; i++) mediaData.features.push(null);
            for (let i = 0; i < MAX_AKTIVITAS; i++) mediaData.aktivitas.push(null);
            for (let i = 0; i < MAX_PRODUCTS; i++) mediaData.products.push(null);

            renderFeatures();
            renderAktivitasGrid();
            renderProducts();

            setupSingleUpload('heroInput', 'hero', 'heroPreview', 'heroRemoveBtn', 'heroStatus');
            setupSingleUpload('storyInput', 'story', 'storyPreview', 'storyRemoveBtn', 'storyStatus');
            setupSingleUpload('whylearnInput', 'whylearn', 'whylearnPreview', 'whylearnRemoveBtn', 'whylearnStatus');

            handleMultipleUpload('aktivitasInput', MAX_AKTIVITAS);

            document.getElementById('addFeatureBtn')?.addEventListener('click', () => {
                const currentFilled = mediaData.features.filter(f => f !== null && (f.file !== null || (f.title && f.title.trim()))).length;
                if (currentFilled >= MAX_FEATURES) {
                    showAlert(`Maksimal ${MAX_FEATURES} fitur!`, 'warning');
                    return;
                }
                const emptyIndex = mediaData.features.findIndex(f => f === null);
                if (emptyIndex !== -1) {
                    mediaData.features[emptyIndex] = { file: null, preview: null, title: '', description: '' };
                    renderFeatures();
                }
            });

            document.getElementById('addProductBtn')?.addEventListener('click', () => {
                const currentFilled = mediaData.products.filter(p => p !== null && (p.file !== null || (p.title && p.title.trim()))).length;
                if (currentFilled >= MAX_PRODUCTS) {
                    showAlert(`Maksimal ${MAX_PRODUCTS} produk!`, 'warning');
                    return;
                }
                const emptyIndex = mediaData.products.findIndex(p => p === null);
                if (emptyIndex !== -1) {
                    mediaData.products[emptyIndex] = { file: null, preview: null, title: '', price: '', description: '' };
                    renderProducts();
                }
            });

            document.getElementById('saveAllBtn')?.addEventListener('click', saveAllMedia);
            initMobileMenu();
        });
    </script>
</body>
</html>
