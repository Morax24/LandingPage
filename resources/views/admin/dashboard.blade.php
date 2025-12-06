<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .user-avatar-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
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

        /* Header dengan tombol Kemarin */
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

        .btn-yesterday {
            background: #3498db;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-yesterday:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
        }

        .btn-yesterday::before {
            content: "📅";
            font-size: 1.2rem;
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

        /* Stats dengan Icon */
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
            position: relative;
            overflow: hidden;
            cursor: pointer;
            color: inherit;
            display: block;
            text-decoration: none;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .stat-card h3 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            color: #5FB574;
            font-weight: 700;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Warna untuk status cards */
        .stat-card.size {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            border-left: 4px solid #4CAF50;
        }

        .stat-card.size h3 {
            color: #2E7D32;
        }

        .stat-card.contacts {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            border-left: 4px solid #2196F3;
        }

        .stat-card.contacts h3 {
            color: #1565C0;
        }

        .stat-card.pending {
            background: linear-gradient(135deg, #FFF8E1, #FFECB3);
            border-left: 4px solid #FFC107;
        }

        .stat-card.pending h3 {
            color: #FF8F00;
        }

        .stat-card.approved {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            border-left: 4px solid #4CAF50;
        }

        .stat-card.approved h3 {
            color: #2E7D32;
        }

        .stat-card.rejected {
            background: linear-gradient(135deg, #FFEBEE, #FFCDD2);
            border-left: 4px solid #F44336;
        }

        .stat-card.rejected h3 {
            color: #C62828;
        }

        .stat-card.media {
            background: linear-gradient(135deg, #F3E5F5, #E1BEE7);
            border-left: 4px solid #9C27B0;
        }

        .stat-card.media h3 {
            color: #7B1FA2;
        }

        .stat-card.active {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            border-left: 4px solid #4CAF50;
        }

        .stat-card.active h3 {
            color: #2E7D32;
        }

        .stat-card.inactive {
            background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
            border-left: 4px solid #FF9800;
        }

        .stat-card.inactive h3 {
            color: #EF6C00;
        }

        /* Warna untuk card pengunjung */
        .stat-card.visitors {
            background: linear-gradient(135deg, #E8F4F8, #3498db);
            border-left: 4px solid #2980b9;
        }
        .stat-card.visitors h3 {
            color: #1a5276;
        }

        .stat-card.today-visitors {
            background: linear-gradient(135deg, #FFF3E0, #FFB74D);
            border-left: 4px solid #FFA726;
        }
        .stat-card.today-visitors h3 {
            color: #F57C00;
        }

        .stat-card.yesterday-visitors {
            background: linear-gradient(135deg, #F1F8E9, #8BC34A);
            border-left: 4px solid #7CB342;
        }
        .stat-card.yesterday-visitors h3 {
            color: #558B2F;
        }

        /* Warna untuk card Histori Pengunjung */
        .stat-card.history {
            background: linear-gradient(135deg, #F3E5F5, #E1BEE7);
            border-left: 4px solid #9C27B0;
        }
        .stat-card.history h3 {
            color: #7B1FA2;
        }

        /* Tombol Histori */
        .btn-history {
            background: #9b59b6;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.8rem;
            display: inline-block;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-history:hover {
            background: #8e44ad;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(155, 89, 182, 0.4);
        }

        /* Link stat card */
        .stat-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-link:hover {
            text-decoration: none;
            color: inherit;
        }

        /* Dashboard Content */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-container, .activity-container {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            position: relative;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Chart Tabs - HANYA 3 TAB */
        .chart-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .chart-tab {
            padding: 0.5rem 1.5rem;
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 0.95rem;
            min-width: 120px;
            text-align: center;
        }

        .chart-tab.active {
            background: #5FB574;
            color: white;
            box-shadow: 0 2px 8px rgba(95,181,116,0.3);
        }

        .chart-tab:hover:not(.active) {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .activity-list {
            margin-top: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: #F7FCF9;
            transform: translateX(5px);
        }

        .activity-icon {
            width: 50px;
            height: 50px;
            flex-shrink: 0;
        }

        .activity-thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #5FB574;
            transition: all 0.3s ease;
        }

        .activity-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            font-weight: bold;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #666;
        }

        /* Recent Items */
        .recent-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .recent-container {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .recent-list {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .recent-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .recent-item:hover {
            background: #F7FCF9;
            border-color: #5FB574;
            transform: translateX(5px);
        }

        .recent-icon {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        .media-thumbnail {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #E8F4F8;
            transition: all 0.3s ease;
        }

        .media-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #E8F4F8, #5FB574);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .video-thumbnail {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .video-icon {
            font-size: 1.5rem;
            color: white;
            z-index: 2;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.2);
            z-index: 1;
        }

        .recent-content {
            flex: 1;
            min-width: 0;
        }

        .recent-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recent-meta {
            font-size: 0.85rem;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Badge untuk tipe media */
        .media-type-badge {
            background: #5FB574;
            color: white;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
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

        /* Dark overlay for mobile */
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

        /* MODAL POPUP untuk Histori Pengunjung */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            animation: slideUp 0.4s ease;
            transform-origin: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: #333;
        }

        /* Tabel Histori Pengunjung */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .history-table th {
            background: #5FB574;
            color: white;
            padding: 0.8rem;
            text-align: left;
            font-weight: 600;
        }

        .history-table td {
            padding: 0.8rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .history-table tr:hover {
            background: #F7FCF9;
        }

        .history-table .date-cell {
            font-weight: 600;
            color: #333;
        }

        .history-table .count-cell {
            text-align: center;
            font-weight: 600;
            color: #3498db;
        }

        .history-table .day-cell {
            color: #666;
            font-size: 0.9rem;
        }

        /* Highlight untuk hari dengan pengunjung terbanyak */
        .history-table .highlight {
            background: #FFF3E0;
            border-left: 4px solid #FFA726;
        }

        .history-table .highlight .count-cell {
            color: #F57C00;
            font-weight: 700;
        }

        /* Statistik ringkasan */
        .history-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .history-stat {
            text-align: center;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .history-stat h4 {
            font-size: 1.8rem;
            color: #5FB574;
            margin-bottom: 0.3rem;
        }

        .history-stat p {
            font-size: 0.85rem;
            color: #666;
        }

        /* Image fallback handling */
        .image-fallback {
            display: none;
        }

        /* Hover effects untuk gambar */
        .activity-item:hover .activity-thumbnail {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .recent-item:hover .media-thumbnail {
            transform: scale(1.08);
            box-shadow: 0 6px 16px rgba(95, 181, 116, 0.4);
        }

        /* Animation untuk gambar loading */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .media-thumbnail,
        .activity-thumbnail {
            animation: fadeIn 0.5s ease;
        }

        /* Video thumbnail untuk activity */
        .activity-item .video-thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border: 2px solid #3498db;
        }

        .activity-item .video-icon {
            font-size: 1.2rem;
            color: white;
            z-index: 2;
        }

        .activity-item .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            z-index: 1;
            border-radius: 50%;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .recent-grid {
                grid-template-columns: 1fr;
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
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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
            .stat-icon {
                font-size: 2rem;
            }
            .chart-container, .activity-container, .recent-container {
                padding: 1.5rem;
            }
            .chart-wrapper {
                height: 250px;
            }
            .header-actions {
                justify-content: center;
            }
            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .activity-thumbnail,
            .activity-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .media-thumbnail,
            .media-placeholder,
            .video-thumbnail {
                width: 50px;
                height: 50px;
            }

            .video-icon {
                font-size: 1.2rem;
            }

            .activity-item,
            .recent-item {
                padding: 0.8rem;
            }

            .chart-tabs {
                flex-wrap: wrap;
            }

            .history-stats {
                grid-template-columns: 1fr;
            }

            .btn-history {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
                min-width: 100px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.5rem;
            }
            .chart-container, .activity-container, .recent-container {
                padding: 1rem;
            }
            .btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
            .chart-wrapper {
                height: 200px;
            }

            .chart-tab {
                padding: 0.5rem 1rem;
                min-width: 100px;
                font-size: 0.85rem;
            }

            .btn-history {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
                min-width: 90px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <div class="overlay" id="overlay"></div>

    <!-- Modal Popup untuk Histori Pengunjung -->
    <div class="modal-overlay" id="historyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📊 Histori Pengunjung</h2>
                <button class="modal-close" id="closeModal">✕</button>
            </div>

            <!-- Statistik Ringkasan -->
            <div class="history-stats">
                <div class="history-stat">
                    <h4 id="totalVisitors">0</h4>
                    <p>Total Pengunjung</p>
                </div>
                <div class="history-stat">
                    <h4 id="averageVisitors">0</h4>
                    <p>Rata-rata per Hari</p>
                </div>
                <div class="history-stat">
                    <h4 id="peakDay">-</h4>
                    <p>Hari Terbanyak</p>
                </div>
            </div>

            <!-- Tabel Histori -->
            <div style="overflow-x: auto;">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Jumlah Pengunjung</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <!-- Data akan diisi oleh JavaScript -->
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #666;">
                                Memuat data histori pengunjung...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Catatan -->
            <div style="margin-top: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #666;">
                <strong>Catatan:</strong> Data diambil dari tabel <code>visitor_counter</code> di database.
                Saat ini hanya ada data untuk 2 hari terakhir. Data akan bertambah seiring waktu.
            </div>
        </div>
    </div>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><span class="logo-square"></span> <span>WALUYA LAND</span></h2>
                <p>Admin Panel</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="menu-item">
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
                    @if(isset(Auth::user()->avatar) && Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="user-avatar-img"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="user-avatar image-fallback">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    @else
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="user-info">
                        <h4>{{ Auth::user()->name ?? 'Admin' }}</h4>
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
            <!-- Header dengan tombol Kemarin -->
            <div class="page-header">
                <h1>📊 Dashboard</h1>
                <span>Halo, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
                <div class="header-actions">
                    <span class="btn btn-secondary">Last updated: {{ now()->format('d M Y, H:i') }}</span>
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

            <!-- Stats dengan Icon yang Bagus -->
            <div class="stats-grid">
                <!-- Baris 1 -->
                <a href="{{ route('admin.media.index') }}" class="stat-link">
                    <div class="stat-card size">
                        <span class="stat-icon">💾</span>
                        <h3>{{ number_format(($stats['total_media_size'] ?? 0) / 1024 / 1024, 2) }} MB</h3>
                        <p>Total Size Media</p>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index') }}" class="stat-link">
                    <div class="stat-card contacts">
                        <span class="stat-icon">📨</span>
                        <h3>{{ $stats['total_contacts'] ?? 0 }}</h3>
                        <p>Total Pesan</p>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index', ['status' => 'pending']) }}" class="stat-link">
                    <div class="stat-card pending">
                        <span class="stat-icon">⏳</span>
                        <h3>{{ $stats['pending_contacts'] ?? 0 }}</h3>
                        <p>Pesan Pending</p>
                    </div>
                </a>

                <!-- Baris 2 -->
                <a href="{{ route('admin.contacts.index', ['status' => 'approved']) }}" class="stat-link">
                    <div class="stat-card approved">
                        <span class="stat-icon">✅</span>
                        <h3>{{ $stats['approved_contacts'] ?? 0 }}</h3>
                        <p>Pesan Disetujui</p>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index', ['status' => 'rejected']) }}" class="stat-link">
                    <div class="stat-card rejected">
                        <span class="stat-icon">❌</span>
                        <h3>{{ $stats['rejected_contacts'] ?? 0 }}</h3>
                        <p>Pesan Ditolak</p>
                    </div>
                </a>

                <a href="{{ route('admin.media.index') }}" class="stat-link">
                    <div class="stat-card media">
                        <span class="stat-icon">🖼️</span>
                        <h3>{{ $stats['total_media'] ?? 0 }}</h3>
                        <p>Total Media</p>
                    </div>
                </a>

                <!-- Baris 3 -->
                <a href="{{ route('admin.media.index', ['status' => 'active']) }}" class="stat-link">
                    <div class="stat-card active">
                        <span class="stat-icon">🟢</span>
                        <h3>{{ $stats['active_media'] ?? 0 }}</h3>
                        <p>Media Aktif</p>
                    </div>
                </a>

                <a href="{{ route('admin.media.index', ['status' => 'inactive']) }}" class="stat-link">
                    <div class="stat-card inactive">
                        <span class="stat-icon">🔴</span>
                        <h3>{{ $stats['inactive_media'] ?? 0 }}</h3>
                        <p>Media Nonaktif</p>
                    </div>
                </a>

                <!-- Baris 4 - Visitor Stats -->
                <div class="stat-card visitors" id="visitorCard">
                    <span class="stat-icon">👥</span>
                    <h3>{{ $stats['visitor_count'] ?? 0 }}</h3>
                    <p>Total Pengunjung</p>
                </div>

                <div class="stat-card today-visitors" id="todayVisitorCard">
                    <span class="stat-icon">📅</span>
                    <h3>{{ $stats['today_visitors'] ?? 0 }}</h3>
                    <p>Hari Ini</p>
                </div>

                <div class="stat-card yesterday-visitors" id="yesterdayVisitorCard">
                    <span class="stat-icon">📊</span>
                    <h3>{{ $stats['yesterday_visitors'] ?? 0 }}</h3>
                    <p>Kemarin</p>
                </div>

                <!-- Histori Pengunjung -->
                <div class="stat-card history" id="historyCard">
                    <span class="stat-icon">📈</span>
                    <h3>{{ $stats['yesterday_visitors'] ?? 0 }}</h3>
                    <p>Histori Pengunjung</p>
                    <button class="btn-history" id="showHistoryBtn">Lihat Histori</button>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-grid">
                <!-- Chart/Graph Section -->
                <div class="chart-container">
                    <h2 style="margin-bottom: 1.5rem; color: #333;">📈 Statistik Dashboard</h2>

                    <!-- Chart Tabs - HANYA 3 TAB -->
                    <div class="chart-tabs">
                        <button class="chart-tab active" data-chart="bar">Diagram Batang</button>
                        <button class="chart-tab" data-chart="horizontal">Diagram Horizontal</button>
                        <button class="chart-tab" data-chart="doughnut">Diagram Donat</button>
                    </div>

                    <div class="chart-wrapper">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-container">
                    <h2 style="margin-bottom: 1.5rem; color: #333;">🔄 Aktivitas Terbaru</h2>
                    <div class="activity-list">
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="activity-item">
                                <div class="activity-icon">
                                    @if($activity['type'] == 'contact')
                                        <div class="activity-avatar" style="background: #5FB574;">📧</div>
                                    @elseif($activity['type'] == 'media' && isset($activity['media']))
                                        @if($activity['media']->isImage())
                                            <!-- Tampilkan thumbnail gambar asli -->
                                            <img src="{{ $activity['media']->url }}"
                                                 alt="Thumbnail"
                                                 class="activity-thumbnail"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="activity-avatar image-fallback" style="background: #F9D56E;">🖼️</div>
                                        @elseif($activity['media']->isVideo())
                                            <!-- Tampilkan thumbnail video -->
                                            <div class="video-thumbnail" style="width: 50px; height: 50px; border-radius: 50%;">
                                                <div class="video-icon">🎥</div>
                                                <div class="video-overlay"></div>
                                            </div>
                                        @else
                                            <div class="activity-avatar" style="background: #3498db;">📁</div>
                                        @endif
                                    @elseif($activity['type'] == 'reply')
                                        <div class="activity-avatar" style="background: #9b59b6;">💬</div>
                                    @else
                                        <div class="activity-avatar" style="background: #95a5a6;">📊</div>
                                    @endif
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $activity['title'] ?? 'Aktivitas' }}</div>
                                    <div class="activity-time">
                                        {{ $activity['time'] ?? '-' }}
                                        @if(isset($activity['media']))
                                            • {{ $activity['media']->section ?? 'other' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="activity-item">
                                <div class="activity-content">
                                    <div class="activity-title">Belum ada aktivitas</div>
                                    <div class="activity-time">-</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Items -->
            <div class="recent-grid">
                <!-- Recent Messages -->
                <div class="recent-container">
                    <h2 style="margin-bottom: 1.5rem; color: #333;">📩 Pesan Terbaru</h2>
                    <div class="recent-list">
                        @forelse($recentContacts ?? [] as $contact)
                            <div class="recent-item">
                                <div class="recent-icon">
                                    <div class="activity-avatar" style="background: #5FB574;">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="recent-content">
                                    <div class="recent-title">{{ $contact->name ?? 'Pengguna' }}</div>
                                    <div class="recent-meta">
                                        {{ $contact->email ?? '-' }} •
                                        {{ $contact->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item">
                                <div class="recent-content">
                                    <div class="recent-title">Belum ada pesan</div>
                                    <div class="recent-meta">-</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Media -->
                <div class="recent-container">
                    <h2 style="margin-bottom: 1.5rem; color: #333;">🖼️ Media Terbaru</h2>
                    <div class="recent-list">
                        @forelse($recentMedia ?? [] as $media)
                            <div class="recent-item">
                                <div class="recent-icon">
                                    @if($media->isImage())
                                        <img src="{{ $media->url }}"
                                             alt="{{ $media->title }}"
                                             class="media-thumbnail"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="media-placeholder image-fallback">
                                            🖼️
                                        </div>
                                    @else
                                        <div class="video-thumbnail">
                                            <div class="video-icon">🎥</div>
                                            <div class="video-overlay"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="recent-content">
                                    <div class="recent-title">{{ Str::limit($media->title ?? 'Media', 30) }}</div>
                                    <div class="recent-meta">
                                        <span class="media-type-badge">{{ $media->type }}</span> •
                                        {{ $media->section ?? '-' }} •
                                        {{ $media->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item">
                                <div class="recent-content">
                                    <div class="recent-title">Belum ada media</div>
                                    <div class="recent-meta">-</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ======================
        // MOBILE MENU FUNCTIONALITY
        // ======================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // ======================
        // CHART.JS IMPLEMENTATION (3 DIAGRAM)
        // ======================
        const chartData = {
            labels: [
                'Total Size Media',
                'Total Pesan',
                'Pesan Pending',
                'Pesan Disetujui',
                'Pesan Ditolak',
                'Total Media',
                'Media Aktif',
                'Media Nonaktif',
                'Total Pengunjung',
                'Pengunjung Hari Ini',
                'Pengunjung Kemarin',
                'Histori Pengunjung'
            ],
            datasets: [{
                label: 'Statistik Dashboard',
                data: [
                    {{ number_format(($stats['total_media_size'] ?? 0) / 1024 / 1024, 2) }},
                    {{ $stats['total_contacts'] ?? 0 }},
                    {{ $stats['pending_contacts'] ?? 0 }},
                    {{ $stats['approved_contacts'] ?? 0 }},
                    {{ $stats['rejected_contacts'] ?? 0 }},
                    {{ $stats['total_media'] ?? 0 }},
                    {{ $stats['active_media'] ?? 0 }},
                    {{ $stats['inactive_media'] ?? 0 }},
                    {{ $stats['visitor_count'] ?? 0 }},
                    {{ $stats['today_visitors'] ?? 0 }},
                    {{ $stats['yesterday_visitors'] ?? 0 }},
                    {{ $stats['yesterday_visitors'] ?? 0 }}
                ],
                backgroundColor: [
                    '#4CAF50', '#2196F3', '#FFC107', '#4CAF50', '#F44336',
                    '#9C27B0', '#4CAF50', '#FF9800', '#3498db', '#FFA726', '#8BC34A', '#9b59b6'
                ],
                borderColor: [
                    '#2E7D32', '#1565C0', '#FF8F00', '#2E7D32', '#C62828',
                    '#7B1FA2', '#2E7D32', '#EF6C00', '#1a5276', '#F57C00', '#558B2F', '#8e44ad'
                ],
                borderWidth: 2
            }]
        };

        const ctx = document.getElementById('dashboardChart').getContext('2d');
        let currentChart = null;

        // Fungsi untuk membuat chart (3 jenis)
        function createChart(type) {
            if (currentChart) {
                currentChart.destroy();
            }

            const config = {
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: { size: 12 },
                                padding: 15,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: { size: 14 },
                            bodyFont: { size: 13 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        if (context.dataIndex === 0) {
                                            label += context.parsed.y + ' MB';
                                        } else {
                                            label += context.parsed.y;
                                        }
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            };

            switch(type) {
                case 'bar':
                    config.type = 'bar';
                    config.options.scales = {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.1)' },
                            ticks: { font: { size: 12 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11 },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    };
                    break;

                case 'horizontal':
                    config.type = 'bar';
                    config.options.indexAxis = 'y';
                    config.options.scales = {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.1)' },
                            ticks: { font: { size: 12 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    };
                    break;

                case 'doughnut':
                    config.type = 'doughnut';
                    config.options.plugins.legend.position = 'right';
                    config.options.cutout = '60%';
                    break;
            }

            currentChart = new Chart(ctx, config);
        }

        // Inisialisasi chart pertama kali (Diagram Batang)
        createChart('bar');

        // Tab functionality
        const chartTabs = document.querySelectorAll('.chart-tab');
        chartTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                chartTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                createChart(this.dataset.chart);
            });
        });

        // ======================
        // MODAL HISTORY FUNCTIONALITY
        // ======================
        const showHistoryBtn = document.getElementById('showHistoryBtn');
        const historyModal = document.getElementById('historyModal');
        const closeModalBtn = document.getElementById('closeModal');
        const historyTableBody = document.getElementById('historyTableBody');
        const totalVisitorsElem = document.getElementById('totalVisitors');
        const averageVisitorsElem = document.getElementById('averageVisitors');
        const peakDayElem = document.getElementById('peakDay');

        // Data dari database (dummy data untuk contoh)
        // Dalam implementasi nyata, ini akan diambil dari endpoint API
        const visitorHistory = [
            { date: '2025-12-05', count: {{ $stats['today_visitors'] ?? 0 }}, day: 'Jumat' },
            { date: '2025-12-04', count: {{ $stats['yesterday_visitors'] ?? 0 }}, day: 'Kamis' },
            // Data dummy untuk demo (akan diganti dengan data real)
            { date: '2025-12-03', count: 15, day: 'Rabu' },
            { date: '2025-12-02', count: 18, day: 'Selasa' },
            { date: '2025-12-01', count: 22, day: 'Senin' },
            { date: '2025-11-30', count: 20, day: 'Minggu' },
            { date: '2025-11-29', count: 25, day: 'Sabtu' },
            { date: '2025-11-28', count: 19, day: 'Jumat' },
            { date: '2025-11-27', count: 21, day: 'Kamis' },
            { date: '2025-11-26', count: 17, day: 'Rabu' }
        ];

        // Fungsi untuk memformat tanggal
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Fungsi untuk menghitung statistik
        function calculateStats(data) {
            let total = 0;
            let maxCount = 0;
            let peakDate = '';

            data.forEach(item => {
                total += item.count;
                if (item.count > maxCount) {
                    maxCount = item.count;
                    peakDate = `${item.day}, ${formatDate(item.date)}`;
                }
            });

            const average = data.length > 0 ? Math.round(total / data.length) : 0;

            return {
                total: total,
                average: average,
                peak: maxCount > 0 ? peakDate : '-'
            };
        }

        // Fungsi untuk mengisi tabel history
        function populateHistoryTable() {
            historyTableBody.innerHTML = '';

            if (visitorHistory.length === 0) {
                historyTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: #666;">
                            Belum ada data histori pengunjung.
                        </td>
                    </tr>
                `;
                return;
            }

            // Hitung statistik
            const stats = calculateStats(visitorHistory);

            // Update statistik ringkasan
            totalVisitorsElem.textContent = stats.total;
            averageVisitorsElem.textContent = stats.average;
            peakDayElem.textContent = stats.peak;

            // Urutkan dari tanggal terbaru
            const sortedHistory = [...visitorHistory].sort((a, b) =>
                new Date(b.date) - new Date(a.date)
            );

            // Temukan jumlah maksimum untuk highlight
            const maxCount = Math.max(...sortedHistory.map(item => item.count));

            // Isi tabel
            sortedHistory.forEach((item, index) => {
                const isHighlight = item.count === maxCount && maxCount > 0;
                const rowClass = isHighlight ? 'highlight' : '';

                const row = document.createElement('tr');
                row.className = rowClass;

                // Warna untuk jumlah pengunjung
                let countColor = '#3498db';
                let keterangan = 'Normal';

                if (item.count === 0) {
                    countColor = '#95a5a6';
                    keterangan = 'Tidak ada pengunjung';
                } else if (item.count > 20) {
                    countColor = '#e74c3c';
                    keterangan = 'Sangat Ramai';
                } else if (item.count > 15) {
                    countColor = '#f39c12';
                    keterangan = 'Ramai';
                } else if (item.count > 10) {
                    keterangan = 'Lumayan';
                }

                row.innerHTML = `
                    <td class="date-cell">${formatDate(item.date)}</td>
                    <td class="day-cell">${item.day}</td>
                    <td class="count-cell" style="color: ${countColor}">
                        ${item.count} pengunjung
                    </td>
                    <td>${keterangan}</td>
                `;

                historyTableBody.appendChild(row);
            });
        }

        // ======================
        // CLICK FUNCTIONALITY FOR STAT CARDS
        // ======================
        document.addEventListener('DOMContentLoaded', function() {
            // Handle clicks on visitor cards
            const visitorCards = document.querySelectorAll('#visitorCard, #todayVisitorCard, #yesterdayVisitorCard');
            visitorCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Cegah event bubbling jika mengklik tombol di dalam card
                    if (!e.target.classList.contains('btn-history')) {
                        populateHistoryTable();
                        historyModal.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });

            // Handle click on history card (seluruh card)
            const historyCard = document.getElementById('historyCard');
            if (historyCard) {
                historyCard.addEventListener('click', function(e) {
                    // Hanya trigger jika tidak mengklik tombol
                    if (!e.target.classList.contains('btn-history')) {
                        populateHistoryTable();
                        historyModal.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    }
                });
            }

            // Event Listeners untuk Modal (tombol)
            showHistoryBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Cegah event bubbling
                populateHistoryTable();
                historyModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeModalBtn.addEventListener('click', function() {
                historyModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            // Tutup modal saat klik di luar konten
            historyModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    historyModal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });

            // Tutup modal dengan tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && historyModal.classList.contains('show')) {
                    historyModal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // ======================
        // IMAGE HANDLING
        // ======================
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');

            images.forEach(img => {
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';

                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });

                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const fallback = this.nextElementSibling;
                    if (fallback && (fallback.classList.contains('image-fallback') ||
                                    fallback.classList.contains('media-placeholder') ||
                                    fallback.classList.contains('activity-avatar'))) {
                        fallback.style.display = 'flex';
                        fallback.style.opacity = '1';
                    }
                });
            });
        });

        // ======================
        // AUTO-REFRESH
        // ======================
        setTimeout(() => {
            window.location.reload();
        }, 300000); // 5 menit

        // ======================
        // WINDOW RESIZE HANDLING
        // ======================
        window.addEventListener('resize', function() {
            if (currentChart) {
                currentChart.resize();
            }
        });
    </script>
</body>
</html>
