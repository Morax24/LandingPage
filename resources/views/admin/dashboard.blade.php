<?php
// ===========================================
// KONEKSI DATABASE
// ===========================================
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "1-bester";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// ===========================================
// FUNGSI UNTUK MENGAMBIL PATH GAMBAR MEDIA
// ===========================================
function getMediaThumbnailPath($media) {
    // Jika ada file_path di database, gunakan itu
    if (!empty($media['file_path'])) {
        // Cek apakah file ada di server
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $media['file_path'];
        if (file_exists($full_path)) {
            return $media['file_path'];
        }
    }

    // Fallback ke placeholder berdasarkan tipe
    if ($media['type'] == 'image') {
        return 'https://via.placeholder.com/40x40/5FB574/fff?text=IMG';
    } else {
        return 'https://via.placeholder.com/40x40/3498db/fff?text=VID';
    }
}

// ===========================================
// FUNGSI UTAMA UNTUK MENJAMIN DATA ADA
// ===========================================
function ensureVisitorData($conn) {
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    // Cek dan buat data untuk hari ini jika belum ada
    $check_today = "SELECT COUNT(*) as exist FROM visitor_counter WHERE date = '$today'";
    $result_today = $conn->query($check_today);
    $row_today = $result_today->fetch_assoc();

    if ($row_today['exist'] == 0) {
        // Buat data untuk hari ini dengan count = 0
        $insert_today = "INSERT INTO visitor_counter (date, count, created_at, updated_at)
                       VALUES ('$today', 0, NOW(), NOW())";
        $conn->query($insert_today);
    } else {
        // Cek apakah data hari ini perlu di-reset (jika tanggal terakhir update bukan hari ini)
        $check_last_update = "SELECT updated_at, count FROM visitor_counter WHERE date = '$today'";
        $result_last = $conn->query($check_last_update);
        if ($result_last->num_rows > 0) {
            $row_last = $result_last->fetch_assoc();
            $last_updated = strtotime($row_last['updated_at']);
            $last_date = date('Y-m-d', $last_updated);

            // Reset jika data terakhir diupdate bukan hari ini (berarti hari baru)
            if ($last_date != $today) {
                $reset_sql = "UPDATE visitor_counter SET count = 0, updated_at = NOW() WHERE date = '$today'";
                $conn->query($reset_sql);
            }
        }
    }

    // Cek dan buat data untuk kemarin jika belum ada
    $check_yesterday = "SELECT COUNT(*) as exist FROM visitor_counter WHERE date = '$yesterday'";
    $result_yesterday = $conn->query($check_yesterday);
    $row_yesterday = $result_yesterday->fetch_assoc();

    if ($row_yesterday['exist'] == 0) {
        // Coba cari data terakhir sebelum hari ini
        $find_yesterday_data = "SELECT count FROM visitor_counter
                              WHERE date < '$today'
                              ORDER BY date DESC LIMIT 1";
        $result_yest_data = $conn->query($find_yesterday_data);
        $yesterday_count = 0;

        if ($result_yest_data->num_rows > 0) {
            $row_yest = $result_yest_data->fetch_assoc();
            $yesterday_count = $row_yest['count'] ?? 0;
        }

        $insert_yesterday = "INSERT INTO visitor_counter (date, count, created_at, updated_at)
                           VALUES ('$yesterday', $yesterday_count, NOW(), NOW())";
        $conn->query($insert_yesterday);
    }

    return ['today' => $today, 'yesterday' => $yesterday];
}

// Panggil fungsi untuk memastikan data ada
$dates = ensureVisitorData($conn);
$today = $dates['today'];
$yesterday = $dates['yesterday'];

// ===========================================
// QUERY DATA DARI DATABASE
// ===========================================

// 1. Total Size Media (dalam MB)
$size_sql = "SELECT SUM(file_size) as total_size FROM media";
$size_result = $conn->query($size_sql);
$total_size_mb = 0;
if ($size_result->num_rows > 0) {
    $row = $size_result->fetch_assoc();
    $total_size_mb = round(($row['total_size'] ?? 0) / (1024 * 1024), 2);
}

// 2. Total Pesan
$contacts_sql = "SELECT COUNT(*) as total FROM contacts";
$contacts_result = $conn->query($contacts_sql);
$total_contacts = 0;
if ($contacts_result->num_rows > 0) {
    $row = $contacts_result->fetch_assoc();
    $total_contacts = $row['total'] ?? 0;
}

// 3. Pesan Pending
$pending_sql = "SELECT COUNT(*) as pending FROM contacts WHERE status = 'pending'";
$pending_result = $conn->query($pending_sql);
$pending_contacts = 0;
if ($pending_result->num_rows > 0) {
    $row = $pending_result->fetch_assoc();
    $pending_contacts = $row['pending'] ?? 0;
}

// 4. Pesan Disetujui
$approved_sql = "SELECT COUNT(*) as approved FROM contacts WHERE status = 'approved'";
$approved_result = $conn->query($approved_sql);
$approved_contacts = 0;
if ($approved_result->num_rows > 0) {
    $row = $approved_result->fetch_assoc();
    $approved_contacts = $row['approved'] ?? 0;
}

// 5. Pesan Ditolak
$rejected_sql = "SELECT COUNT(*) as rejected FROM contacts WHERE status = 'rejected'";
$rejected_result = $conn->query($rejected_sql);
$rejected_contacts = 0;
if ($rejected_result->num_rows > 0) {
    $row = $rejected_result->fetch_assoc();
    $rejected_contacts = $row['rejected'] ?? 0;
}

// 6. Total Media
$media_total_sql = "SELECT COUNT(*) as total FROM media";
$media_total_result = $conn->query($media_total_sql);
$total_media = 0;
if ($media_total_result->num_rows > 0) {
    $row = $media_total_result->fetch_assoc();
    $total_media = $row['total'] ?? 0;
}

// 7. Media Aktif
$media_active_sql = "SELECT COUNT(*) as active FROM media WHERE is_active = 1";
$media_active_result = $conn->query($media_active_sql);
$active_media = 0;
if ($media_active_result->num_rows > 0) {
    $row = $media_active_result->fetch_assoc();
    $active_media = $row['active'] ?? 0;
}

// 8. Media Nonaktif
$media_inactive_sql = "SELECT COUNT(*) as inactive FROM media WHERE is_active = 0";
$media_inactive_result = $conn->query($media_inactive_sql);
$inactive_media = 0;
if ($media_inactive_result->num_rows > 0) {
    $row = $media_inactive_result->fetch_assoc();
    $inactive_media = $row['inactive'] ?? 0;
}

// 9. Total Pengunjung Hari Ini
$today_visitors_sql = "SELECT count FROM visitor_counter WHERE date = '$today'";
$today_visitors_result = $conn->query($today_visitors_sql);
$today_visitors = 0;
if ($today_visitors_result->num_rows > 0) {
    $row = $today_visitors_result->fetch_assoc();
    $today_visitors = $row['count'] ?? 0;

    // Jika hari ini lebih dari 0, reset ke 1 (karena baru buka)
    if ($today_visitors > 1) {
        // Reset hanya jika parameter reset diberikan
        if (isset($_GET['reset_visitors'])) {
            $reset_sql = "UPDATE visitor_counter SET count = 1 WHERE date = '$today'";
            $conn->query($reset_sql);
            $today_visitors = 1;
        }
    }
}

// 10. Total Pengunjung Keseluruhan (kumulatif semua hari)
$total_visitors_sql = "SELECT SUM(count) as total FROM visitor_counter";
$total_visitors_result = $conn->query($total_visitors_sql);
$total_visitors = 0;
if ($total_visitors_result->num_rows > 0) {
    $row = $total_visitors_result->fetch_assoc();
    $total_visitors = $row['total'] ?? 0;
}

// 11. Pengunjung Kemarin
$yesterday_visitors_sql = "SELECT count FROM visitor_counter WHERE date = '$yesterday'";
$yesterday_visitors_result = $conn->query($yesterday_visitors_sql);
$yesterday_visitors = 0;
if ($yesterday_visitors_result->num_rows > 0) {
    $row = $yesterday_visitors_result->fetch_assoc();
    $yesterday_visitors = $row['count'] ?? 0;
}

// 12. Histori Pengunjung (7 hari terakhir)
$history_visitors_sql = "SELECT COUNT(DISTINCT date) as days FROM visitor_counter WHERE date >= DATE_SUB('$today', INTERVAL 7 DAY)";
$history_visitors_result = $conn->query($history_visitors_sql);
$history_days = 0;
if ($history_visitors_result->num_rows > 0) {
    $row = $history_visitors_result->fetch_assoc();
    $history_days = $row['days'] ?? 0;
}

// 13. Rata-rata per Hari
$avg_visitors_sql = "SELECT
                    CASE
                        WHEN COUNT(DISTINCT date) > 0
                        THEN SUM(count) / COUNT(DISTINCT date)
                        ELSE 0
                    END as average
                    FROM visitor_counter";
$avg_visitors_result = $conn->query($avg_visitors_sql);
$avg_visitors = 0;
if ($avg_visitors_result->num_rows > 0) {
    $row = $avg_visitors_result->fetch_assoc();
    $avg_visitors = round($row['average'] ?? 0);
}

// 14. Hari Terbanyak (dengan nama hari)
$max_visitors_sql = "SELECT date, count, DAYNAME(date) as day_name
                     FROM visitor_counter
                     ORDER BY count DESC, date DESC
                     LIMIT 1";
$max_visitors_result = $conn->query($max_visitors_sql);
$max_visitors_day = 'Tidak ada data';
$max_visitors_count = 0;

if ($max_visitors_result->num_rows > 0) {
    $row = $max_visitors_result->fetch_assoc();
    $max_visitors_day = $row['day_name'];
    $max_visitors_count = $row['count'];
}

// 15. Total Testimoni
$testimonial_sql = "SELECT COUNT(*) as total FROM contacts WHERE type = 'testimonial'";
$testimonial_result = $conn->query($testimonial_sql);
$total_testimonials = 0;
if ($testimonial_result->num_rows > 0) {
    $row = $testimonial_result->fetch_assoc();
    $total_testimonials = $row['total'] ?? 0;
}

// Data untuk Chart (15 data)
$chart_data = [
    $total_size_mb,          // 1. Total Size Media
    $total_contacts,         // 2. Total Pesan
    $pending_contacts,       // 3. Pesan Pending
    $approved_contacts,      // 4. Pesan Disetujui
    $rejected_contacts,      // 5. Pesan Ditolak
    $total_media,            // 6. Total Media
    $active_media,           // 7. Media Aktif
    $inactive_media,         // 8. Media Nonaktif
    $today_visitors,         // 9. Hari Ini
    $total_visitors,         // 10. Total Kumulatif
    $yesterday_visitors,     // 11. Kemarin
    $history_days,           // 12. Histori Pengunjung
    $total_testimonials,     // 13. Total Testimoni (GANTI!)
    $avg_visitors,           // 14. Rata-rata per Hari
    $max_visitors_count      // 15. Hari Terbanyak (jumlah)
];

// 16. Data Tabel Pengunjung (5 hari terakhir)
$visitor_table_sql = "SELECT date, count, DAYNAME(date) as day_name FROM visitor_counter ORDER BY date DESC LIMIT 5";
$visitor_table_result = $conn->query($visitor_table_sql);
$visitor_data = [];
if ($visitor_table_result->num_rows > 0) {
    while($row = $visitor_table_result->fetch_assoc()) {
        $visitor_data[] = $row;
    }
}

// 17. Aktivitas Terbaru
$activities = [];

// Aktivitas dari media
$media_activity_sql = "SELECT
    CONCAT('Gambar diupload: ', title) as title,
    section,
    created_at as timestamp,
    'media' as type
    FROM media
    ORDER BY created_at DESC
    LIMIT 2";
$media_activity_result = $conn->query($media_activity_sql);
if ($media_activity_result->num_rows > 0) {
    while($row = $media_activity_result->fetch_assoc()) {
        $activities[] = $row;
    }
}

// Aktivitas dari contacts
$contacts_activity_sql = "SELECT
    CONCAT('Pesan baru dari ', name) as title,
    'contact' as type,
    created_at as timestamp
    FROM contacts
    ORDER BY created_at DESC
    LIMIT 3";
$contacts_activity_result = $conn->query($contacts_activity_sql);
if ($contacts_activity_result->num_rows > 0) {
    while($row = $contacts_activity_result->fetch_assoc()) {
        $activities[] = $row;
    }
}

// Aktivitas statistik
$stat_activity_sql = "SELECT
    'Update statistik pengunjung' as title,
    'stats' as type,
    updated_at as timestamp
    FROM visitor_counter
    ORDER BY updated_at DESC
    LIMIT 1";
$stat_activity_result = $conn->query($stat_activity_sql);
if ($stat_activity_result->num_rows > 0) {
    while($row = $stat_activity_result->fetch_assoc()) {
        $activities[] = $row;
    }
}

// Urutkan aktivitas
usort($activities, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});

// 18. Pesan Terbaru
$recent_messages_sql = "SELECT name, email, status, created_at
                       FROM contacts
                       ORDER BY created_at DESC
                       LIMIT 4";
$recent_messages_result = $conn->query($recent_messages_sql);
$recent_messages = [];
if ($recent_messages_result->num_rows > 0) {
    while($row = $recent_messages_result->fetch_assoc()) {
        $recent_messages[] = $row;
    }
}

// 19. Media Terbaru (DENGAN FILE_PATH)
$recent_media_sql = "SELECT title, type, section, file_path, created_at
                    FROM media
                    ORDER BY created_at DESC
                    LIMIT 4";
$recent_media_result = $conn->query($recent_media_sql);
$recent_media = [];
if ($recent_media_result->num_rows > 0) {
    while($row = $recent_media_result->fetch_assoc()) {
        $row['thumbnail_path'] = getMediaThumbnailPath($row);
        $recent_media[] = $row;
    }
}

$conn->close();
?>

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

        /* Sidebar - SAMA PERSIS DENGAN MEDIA LIBRARY */
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

        /* Page Header */
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

        .btn-secondary {
            background: #95a5a6;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(108, 117, 125, 0.2);
        }

        /* Alert dengan close button */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
            position: relative;
            padding-right: 3rem;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-close {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.5rem;
            color: inherit;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .alert-close:hover {
            opacity: 1;
            background: rgba(0,0,0,0.1);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card {
            background: #fff;
            padding: 1.2rem 1rem;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.04);
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border-top: 3px solid;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.15);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.2rem;
            line-height: 1;
        }

        .stat-unit {
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-left: 2px;
        }

        .stat-label {
            color: #555;
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
            margin-top: 0.2rem;
            text-align: center;
        }

        .day-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.2rem;
            line-height: 1;
        }

        .day-count {
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-top: 0.3rem;
        }

        /* Warna border untuk stat cards */
        .stat-card:nth-child(1) { border-top-color: #4CAF50; }
        .stat-card:nth-child(2) { border-top-color: #2196F3; }
        .stat-card:nth-child(3) { border-top-color: #FFC107; }
        .stat-card:nth-child(4) { border-top-color: #4CAF50; }
        .stat-card:nth-child(5) { border-top-color: #F44336; }
        .stat-card:nth-child(6) { border-top-color: #9C27B0; }
        .stat-card:nth-child(7) { border-top-color: #4CAF50; }
        .stat-card:nth-child(8) { border-top-color: #FF9800; }
        .stat-card:nth-child(9) { border-top-color: #FFA726; }
        .stat-card:nth-child(10) { border-top-color: #3498db; }
        .stat-card:nth-child(11) { border-top-color: #8BC34A; }
        .stat-card:nth-child(12) { border-top-color: #9b59b6; }
        .stat-card:nth-child(13) { border-top-color: #F9D56E; } /* Emas untuk Testimoni */
        .stat-card:nth-child(14) { border-top-color: #2ecc71; }
        .stat-card:nth-child(15) { border-top-color: #e74c3c; }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 1.2rem;
            margin-bottom: 1.5rem;
            align-items: start;
            min-height: 400px;
        }

        .chart-container,
        .visitor-table-container,
        .activity-container {
            background: #fff;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            position: relative;
            height: 100%;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .container-title {
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.7rem;
            border-bottom: 2px solid #ecf0f1;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
        }

        .chart-wrapper {
            position: relative;
            height: 250px;
            width: 100%;
            flex-grow: 1;
        }

        .chart-tabs {
            display: flex;
            gap: 0.6rem;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #eee;
        }

        .chart-tab {
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 0.85rem;
            min-width: 90px;
            text-align: center;
            flex: 1;
        }

        .chart-tab.active {
            background: #5FB574;
            color: white;
            border-color: #5FB574;
            box-shadow: 0 2px 4px rgba(95,181,116,0.2);
        }

        .chart-tab:hover:not(.active) {
            background: #e9ecef;
            border-color: #ced4da;
        }

        /* Responsive Table Styles */
        .visitor-table-wrapper {
            flex-grow: 1;
            overflow-x: auto;
            overflow-y: auto;
            border: 1px solid #ecf0f1;
            border-radius: 8px;
            max-height: 280px;
            -webkit-overflow-scrolling: touch;
        }

        .visitor-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .visitor-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .visitor-table th {
            background: #5FB574;
            color: white;
            padding: 0.8rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            position: sticky;
            top: 0;
            white-space: nowrap;
        }

        .visitor-table td {
            padding: 0.7rem 1rem;
            border-bottom: 1px solid #ecf0f1;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .visitor-table tr:hover {
            background: #f8f9fa;
        }

        .visitor-table .date-cell {
            font-weight: 600;
            color: #2c3e50;
            white-space: nowrap;
            min-width: 100px;
        }

        .visitor-table .count-cell {
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
            min-width: 60px;
        }

        .visitor-table .day-cell {
            color: #7f8c8d;
            font-size: 0.85rem;
            min-width: 80px;
        }

        .visitor-table .highlight {
            background: linear-gradient(90deg, rgba(255, 167, 38, 0.08) 0%, transparent 100%);
        }

        .visitor-table .highlight td:first-child {
            border-left: 3px solid #FFA726;
        }

        /* Mobile Cards untuk pengunjung (alternatif) */
        .visitor-mobile-cards {
            display: none;
            flex-direction: column;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .visitor-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            border-left: 4px solid #5FB574;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
            transition: all 0.2s ease;
        }

        .visitor-card:hover {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .visitor-card-header {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #dee2e6;
        }

        .visitor-card-date {
            font-weight: 700;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .visitor-card-day {
            color: #7f8c8d;
            font-size: 0.8rem;
        }

        .visitor-card-item {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .visitor-card-label {
            font-size: 0.75rem;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .visitor-card-value {
            font-weight: 600;
            font-size: 0.9rem;
            color: #2c3e50;
        }

        .visitor-card-highlight {
            background: linear-gradient(90deg, rgba(255, 167, 38, 0.1) 0%, transparent 100%);
            border-left-color: #FFA726;
        }

        .activity-list {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 5px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            padding: 0.8rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: #f8f9fa;
            border: 1px solid transparent;
            min-height: 70px;
        }

        .activity-item:hover {
            background: #fff;
            border-color: #5FB574;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .activity-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
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
            margin-bottom: 0.2rem;
            color: #2c3e50;
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .activity-time::before {
            content: "🕒";
            font-size: 0.75rem;
        }

        .recent-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
            margin-bottom: 0;
        }

        .recent-container {
            background: #fff;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            min-height: 280px;
            display: flex;
            flex-direction: column;
        }

        .recent-title {
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.7rem;
            border-bottom: 2px solid #ecf0f1;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
        }

        .recent-list {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            overflow-y: auto;
            padding-right: 5px;
        }

        .recent-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: #f8f9fa;
            border: 1px solid transparent;
        }

        .recent-item:hover {
            background: #fff;
            border-color: #5FB574;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .recent-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .user-initial {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #5FB574;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
        }

        .media-thumbnail {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #ecf0f1;
            transition: all 0.3s ease;
        }

        .video-thumbnail {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-icon {
            font-size: 1.2rem;
            color: white;
        }

        .recent-content {
            flex: 1;
            min-width: 0;
        }

        .recent-name {
            font-weight: 600;
            margin-bottom: 0.2rem;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .recent-meta {
            font-size: 0.8rem;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .badge {
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

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
            padding: 0.6rem;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
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

        /* Responsive Design */
        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .dashboard-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto auto;
                gap: 1rem;
            }
            .chart-container {
                grid-column: 1 / -1;
                grid-row: 1;
            }
            .visitor-table-container {
                grid-column: 1;
                grid-row: 2;
            }
            .activity-container {
                grid-column: 2;
                grid-row: 2;
            }
            .recent-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
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
                gap: 0.6rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.8rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
                gap: 1rem;
            }

            .chart-container,
            .visitor-table-container,
            .activity-container {
                grid-column: 1;
                min-height: 350px;
            }

            .chart-container { grid-row: 1; }
            .visitor-table-container { grid-row: 2; }
            .activity-container { grid-row: 3; }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 1rem;
                min-height: 100px;
            }

            .stat-number {
                font-size: 1.6rem;
            }

            .day-name {
                font-size: 1.1rem;
            }

            .stat-icon {
                font-size: 1.8rem;
                height: 35px;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .chart-container,
            .visitor-table-container,
            .activity-container,
            .recent-container {
                padding: 1.2rem;
            }

            .chart-wrapper {
                height: 220px;
            }

            .header-actions {
                justify-content: center;
            }

            .page-header {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .activity-item,
            .recent-item {
                padding: 0.7rem;
            }

            .chart-tabs {
                flex-wrap: wrap;
            }

            .chart-tab {
                min-width: 80px;
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }

            /* Responsive table untuk mobile */
            .visitor-table-wrapper {
                max-height: 250px;
                font-size: 0.9rem;
                display: none;
            }

            .visitor-table {
                min-width: 550px;
            }

            .visitor-table th,
            .visitor-table td {
                padding: 0.6rem 0.8rem;
                font-size: 0.8rem;
            }

            .visitor-mobile-cards {
                display: flex;
            }
        }

        @media (min-width: 769px) {
            .visitor-table-wrapper {
                display: block;
            }

            .visitor-mobile-cards {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem;
            }

            .chart-container,
            .visitor-table-container,
            .activity-container,
            .recent-container {
                padding: 1rem;
            }

            .btn {
                padding: 0.5rem 0.9rem;
                font-size: 0.8rem;
            }

            .chart-wrapper {
                height: 200px;
            }

            .recent-grid {
                gap: 0.8rem;
            }

            .visitor-card {
                padding: 0.8rem;
                gap: 0.6rem;
            }

            .visitor-card-date {
                font-size: 0.9rem;
            }

            .visitor-card-value {
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
        <!-- Sidebar - SAMA PERSIS DENGAN MEDIA LIBRARY -->
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
        <!-- =========================================== -->
        <!-- TAMBAH MENU TESTIMONI DI SINI -->
        <!-- =========================================== -->
        <a href="{{ route('admin.testimonials.index') }}" class="menu-item">
            <span class="menu-icon">⭐</span>
            <span>Kelola Testimoni</span>
        </a>
        <!-- =========================================== -->
        <a href="{{ route('admin.media.index') }}" class="menu-item">
            <span class="menu-icon">🖼️</span>
            <span>Media Library</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">AD</div>
            <div class="user-info">
                <h4>Admin Waluya</h4>
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
                <h1>📊 Dashboard Analytics</h1>
                <span>Welcome, <strong style="color: #5FB574;">Admin</strong></span>
                <div class="header-actions">
                    <span class="btn btn-secondary">🕒 <?php echo date('d M Y, H:i'); ?></span>
                    <?php if ($today_visitors > 1): ?>
                    <a href="dashboard.php?reset_visitors=1" class="btn btn-secondary"
                       onclick="return confirm('Reset pengunjung hari ini ke 1?')">
                       🔄 Reset Pengunjung
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Alert -->
            <div class="alert alert-success" id="dashboardAlert">
                <span>✓</span>
                Dashboard loaded successfully from database
                <?php if (isset($_GET['reset_visitors'])): ?>
                <span style="margin-left: 10px;">(Pengunjung hari ini telah direset)</span>
                <?php endif; ?>
                <button class="alert-close" onclick="closeAlert()">×</button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <!-- Baris 1: Media & Pesan -->
                <a href="{{ route('admin.media.index') }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">💾</span>
                        <div class="stat-number"><?php echo $total_size_mb; ?><span class="stat-unit">MB</span></div>
                        <div class="stat-label">Total Size Media</div>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index') }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">📨</span>
                        <div class="stat-number"><?php echo $total_contacts; ?></div>
                        <div class="stat-label">Total Pesan</div>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index', ['status' => 'pending']) }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">⏳</span>
                        <div class="stat-number"><?php echo $pending_contacts; ?></div>
                        <div class="stat-label">Pesan Pending</div>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index', ['status' => 'approved']) }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">✅</span>
                        <div class="stat-number"><?php echo $approved_contacts; ?></div>
                        <div class="stat-label">Pesan Disetujui</div>
                    </div>
                </a>

                <a href="{{ route('admin.contacts.index', ['status' => 'rejected']) }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">❌</span>
                        <div class="stat-number"><?php echo $rejected_contacts; ?></div>
                        <div class="stat-label">Pesan Ditolak</div>
                    </div>
                </a>

                <!-- Baris 2: Media & Pengunjung -->
                <a href="{{ route('admin.media.index') }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">🖼️</span>
                        <div class="stat-number"><?php echo $total_media; ?></div>
                        <div class="stat-label">Total Media</div>
                    </div>
                </a>

                <a href="{{ route('admin.media.index', ['status' => 'active']) }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">🟢</span>
                        <div class="stat-number"><?php echo $active_media; ?></div>
                        <div class="stat-label">Media Aktif</div>
                    </div>
                </a>

                <a href="{{ route('admin.media.index', ['status' => 'inactive']) }}" class="stat-link">
                    <div class="stat-card">
                        <span class="stat-icon">🔴</span>
                        <div class="stat-number"><?php echo $inactive_media; ?></div>
                        <div class="stat-label">Media Nonaktif</div>
                    </div>
                </a>

                <div class="stat-card">
                    <span class="stat-icon">📅</span>
                    <div class="stat-number"><?php echo $today_visitors; ?></div>
                    <div class="stat-label">Pengunjung Hari Ini</div>
                </div>

                <div class="stat-card">
                    <span class="stat-icon">👥</span>
                    <div class="stat-number"><?php echo $total_visitors; ?></div>
                    <div class="stat-label">Total Kumulatif</div>
                </div>

                <!-- Baris 3: Statistik Pengunjung -->
                <div class="stat-card">
                    <span class="stat-icon">📊</span>
                    <div class="stat-number"><?php echo $yesterday_visitors; ?></div>
                    <div class="stat-label">Pengunjung Kemarin</div>
                </div>

                <div class="stat-card" id="historiCard">
                    <span class="stat-icon">📈</span>
                    <div class="stat-number"><?php echo $history_days; ?><span class="stat-unit">hr</span></div>
                    <div class="stat-label">Histori Pengunjung</div>
                </div>

                <!-- Total Testimoni (GANTI DARI "Hari Paling Sepi") -->
                <a href="{{ route('admin.contacts.index', ['type' => 'testimonial']) }}" class="stat-link">
                    <div class="stat-card" id="testimonialCard">
                        <span class="stat-icon">⭐</span>
                        <div class="stat-number"><?php echo $total_testimonials; ?></div>
                        <div class="stat-label">Total Testimoni</div>
                    </div>
                </a>

                <div class="stat-card">
                    <span class="stat-icon">📉</span>
                    <div class="stat-number"><?php echo $avg_visitors; ?></div>
                    <div class="stat-label">Rata-rata per Hari</div>
                </div>

                <div class="stat-card">
                    <span class="stat-icon">🤩</span>
                    <div class="day-name"><?php echo $max_visitors_day; ?></div>
                    <div class="stat-label">Kunjungan Tertinggi</div>
                    <div class="day-count">(<?php echo $max_visitors_count; ?> pengunjung)</div>
                </div>
            </div>

            <!-- Dashboard 3 Kolom -->
            <div class="dashboard-grid">
                <!-- Kolom Kiri: Statistik Dashboard -->
                <div class="chart-container">
                    <h2 class="container-title">📈 Statistik Dashboard</h2>

                    <!-- Chart Tabs -->
                    <div class="chart-tabs">
                        <button class="chart-tab active" data-chart="bar">Diagram Batang</button>
                        <button class="chart-tab" data-chart="horizontal">Diagram Horizontal</button>
                        <button class="chart-tab" data-chart="doughnut">Diagram Donat</button>
                    </div>

                    <div class="chart-wrapper">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

                <!-- Kolom Tengah: Tabel Pengunjung Harian -->
                <div class="visitor-table-container">
                    <h2 class="container-title">📊 Tabel Pengunjung Harian</h2>

                    <!-- Desktop Table -->
                    <div class="visitor-table-wrapper">
                        <table class="visitor-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($visitor_data as $index => $visitor):
                                    $date = new DateTime($visitor['date']);
                                    $count = $visitor['count'];
                                    $day_name = $visitor['day_name'];

                                    // Tentukan warna
                                    if ($count == 0) {
                                        $color = '#95a5a6';
                                        $keterangan = 'Tidak ada';
                                    } elseif ($count < 10) {
                                        $color = '#3498db';
                                        $keterangan = 'Sedikit';
                                    } elseif ($count < 20) {
                                        $color = '#f39c12';
                                        $keterangan = 'Lumayan';
                                    } else {
                                        $color = '#e74c3c';
                                        $keterangan = 'Sangat Ramai';
                                    }

                                    $highlight = ($count == $max_visitors_count) ? 'highlight' : '';
                                    // Hapus highlight untuk hari paling sepi
                                ?>
                                <tr class="<?php echo $highlight; ?>">
                                    <td class="date-cell"><?php echo $date->format('d/m/Y'); ?></td>
                                    <td class="day-cell"><?php echo $day_name; ?></td>
                                    <td class="count-cell" style="color: <?php echo $color; ?>;"><?php echo $count; ?></td>
                                    <td><?php echo $keterangan; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="visitor-mobile-cards">
                        <?php foreach($visitor_data as $index => $visitor):
                            $date = new DateTime($visitor['date']);
                            $count = $visitor['count'];
                            $day_name = $visitor['day_name'];

                            if ($count == 0) {
                                $color = '#95a5a6';
                                $keterangan = 'Tidak ada';
                            } elseif ($count < 10) {
                                $color = '#3498db';
                                $keterangan = 'Sedikit';
                            } elseif ($count < 20) {
                                $color = '#f39c12';
                                $keterangan = 'Lumayan';
                            } else {
                                $color = '#e74c3c';
                                $keterangan = 'Sangat Ramai';
                            }

                            $highlight_class = ($count == $max_visitors_count) ? 'visitor-card-highlight' : '';
                        ?>
                        <div class="visitor-card <?php echo $highlight_class; ?>">
                            <div class="visitor-card-header">
                                <div class="visitor-card-date"><?php echo $date->format('d/m/Y'); ?></div>
                                <div class="visitor-card-day"><?php echo $day_name; ?></div>
                            </div>

                            <div class="visitor-card-item">
                                <div class="visitor-card-label">Jumlah</div>
                                <div class="visitor-card-value" style="color: <?php echo $color; ?>;"><?php echo $count; ?></div>
                            </div>

                            <div class="visitor-card-item">
                                <div class="visitor-card-label">Keterangan</div>
                                <div class="visitor-card-value"><?php echo $keterangan; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Kolom Kanan: Aktivitas Terbaru -->
                <div class="activity-container">
                    <h2 class="container-title">🔄 Aktivitas Terbaru</h2>
                    <div class="activity-list">
                        <?php foreach(array_slice($activities, 0, 6) as $activity):
                            $timestamp = new DateTime($activity['timestamp']);
                            $time_diff = time() - strtotime($activity['timestamp']);

                            if ($time_diff < 3600) {
                                $time_ago = floor($time_diff / 60) . ' menit lalu';
                            } elseif ($time_diff < 86400) {
                                $time_ago = floor($time_diff / 3600) . ' jam lalu';
                            } else {
                                $time_ago = floor($time_diff / 86400) . ' hari lalu';
                            }

                            if ($activity['type'] == 'media') {
                                $icon = '🖼️';
                                $bg_color = 'linear-gradient(135deg, #F9D56E, #FFC107)';
                                $section = isset($activity['section']) ? ' - ' . $activity['section'] : '';
                            } elseif ($activity['type'] == 'contact') {
                                $icon = '📧';
                                $bg_color = 'linear-gradient(135deg, #5FB574, #4CAF50)';
                                $section = '';
                            } else {
                                $icon = '📊';
                                $bg_color = 'linear-gradient(135deg, #9b59b6, #8e44ad)';
                                $section = '';
                            }
                        ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <div class="activity-avatar" style="background: <?php echo $bg_color; ?>;"><?php echo $icon; ?></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></div>
                                <div class="activity-time"><?php echo $time_ago . $section; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Items -->
            <div class="recent-grid">
                <!-- Recent Messages -->
                <div class="recent-container">
                    <h2 class="recent-title">📩 Pesan Terbaru</h2>
                    <div class="recent-list">
                        <?php foreach($recent_messages as $message):
                            $initial = strtoupper(substr($message['name'], 0, 1));
                            $time_diff = time() - strtotime($message['created_at']);

                            if ($time_diff < 3600) {
                                $time_text = floor($time_diff / 60) . ' menit';
                            } elseif ($time_diff < 86400) {
                                $time_text = floor($time_diff / 3600) . ' jam';
                            } else {
                                $time_text = floor($time_diff / 86400) . ' hari';
                            }

                            $badge_class = 'badge-warning';
                            if ($message['status'] == 'rejected') $badge_class = 'badge-danger';
                            if ($message['status'] == 'approved') $badge_class = 'badge-success';
                        ?>
                        <div class="recent-item">
                            <div class="recent-icon">
                                <div class="user-initial"><?php echo $initial; ?></div>
                            </div>
                            <div class="recent-content">
                                <div class="recent-name"><?php echo htmlspecialchars($message['name']); ?></div>
                                <div class="recent-meta">
                                    <span><?php echo htmlspecialchars($message['email']); ?></span>
                                    <span>•</span>
                                    <span><?php echo $time_text; ?></span>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $message['status']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recent Media -->
                <div class="recent-container">
                    <h2 class="recent-title">🖼️ Media Terbaru</h2>
                    <div class="recent-list">
                        <?php foreach($recent_media as $media):
                            $time_diff = time() - strtotime($media['created_at']);

                            if ($time_diff < 3600) {
                                $time_text = floor($time_diff / 60) . ' menit';
                            } elseif ($time_diff < 86400) {
                                $time_text = floor($time_diff / 3600) . ' jam';
                            } else {
                                $time_text = floor($time_diff / 86400) . ' hari';
                            }

                            $badge_class = ($media['type'] == 'image') ? 'badge-success' : 'badge-warning';
                            $thumbnail_src = $media['thumbnail_path'];
                        ?>
                        <div class="recent-item">
                            <div class="recent-icon">
                                <?php if ($media['type'] == 'image'): ?>
                                <img src="<?php echo $thumbnail_src; ?>"
                                     alt="Thumbnail"
                                     class="media-thumbnail"
                                     onerror="this.src='https://via.placeholder.com/40x40/5FB574/fff?text=IMG'">
                                <?php else: ?>
                                <div class="video-thumbnail">
                                    <div class="video-icon">🎥</div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="recent-content">
                                <div class="recent-name"><?php echo htmlspecialchars($media['title']); ?></div>
                                <div class="recent-meta">
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $media['type']; ?></span>
                                    <span>•</span>
                                    <span><?php echo $media['section']; ?></span>
                                    <span>•</span>
                                    <span><?php echo $time_text; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ======================
        // DATA DARI PHP UNTUK CHART
        // ======================
        const chartLabels = [
            'Total Size Media', 'Total Pesan', 'Pesan Pending', 'Pesan Disetujui', 'Pesan Ditolak',
            'Total Media', 'Media Aktif', 'Media Nonaktif', 'Hari Ini', 'Total Kumulatif',
            'Kemarin', 'Histori Pengunjung', '⭐ Total Testimoni', 'Rata-rata per Hari', 'Hari Terbanyak'
        ];

        const chartDataValues = <?php echo json_encode($chart_data); ?>;

        // ======================
        // MOBILE MENU FUNCTIONALITY
        // ======================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : 'auto';
        }

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // ======================
        // ALERT AUTO-CLOSE FUNCTIONALITY
        // ======================
        function closeAlert() {
            const alert = document.getElementById('dashboardAlert');
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }

        // Auto-close alert setelah 4 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('dashboardAlert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            }
        });

        // ======================
        // CHART.JS IMPLEMENTATION
        // ======================
        const chartData = {
            labels: chartLabels,
            datasets: [{
                label: 'Statistik Dashboard',
                data: chartDataValues,
                backgroundColor: [
                    '#4CAF50', '#2196F3', '#FFC107', '#4CAF50', '#F44336',
                    '#9C27B0', '#4CAF50', '#FF9800', '#FFA726', '#3498db',
                    '#8BC34A', '#9b59b6', '#F9D56E', '#2ecc71', '#e74c3c'  // #F9D56E untuk Testimoni
                ],
                borderColor: [
                    '#2E7D32', '#1565C0', '#FF8F00', '#2E7D32', '#C62828',
                    '#7B1FA2', '#2E7D32', '#EF6C00', '#F57C00', '#1a5276',
                    '#558B2F', '#8e44ad', '#FFC107', '#27ae60', '#c0392b'  // #FFC107 untuk Testimoni
                ],
                borderWidth: 1.5,
                borderRadius: 4,
                borderSkipped: false
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
                                font: { size: 11, family: "'Segoe UI', sans-serif" },
                                padding: 10,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleFont: { size: 12 },
                            bodyFont: { size: 11 },
                            padding: 10,
                            cornerRadius: 6,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    let label = '';
                                    if (context.parsed.y !== null) {
                                        if (context.dataIndex === 0) {
                                            label = context.parsed.y.toFixed(1) + ' MB';
                                        } else if (context.dataIndex === 12) {
                                            label = '⭐ ' + context.parsed.y + ' testimoni';
                                        } else if ([8,9,10,11,13,14].includes(context.dataIndex)) {
                                            label = context.parsed.y + ' pengunjung';
                                        } else {
                                            label = context.parsed.y;
                                        }
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 800,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(236, 240, 241, 0.6)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 10 },
                                color: '#7f8c8d',
                                padding: 5
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { size: 10 },
                                color: '#7f8c8d',
                                maxRotation: 45,
                                minRotation: 45,
                                padding: 3
                            }
                        }
                    }
                }
            };

            switch(type) {
                case 'bar':
                    config.type = 'bar';
                    break;

                case 'horizontal':
                    config.type = 'bar';
                    config.options.indexAxis = 'y';
                    config.options.scales.x.grid.color = 'rgba(236, 240, 241, 0.6)';
                    config.options.scales.x.grid.drawBorder = false;
                    config.options.scales.y.grid.display = false;
                    break;

                case 'doughnut':
                    config.type = 'doughnut';
                    config.options.plugins.legend.position = 'right';
                    config.options.cutout = '55%';
                    config.options.plugins.legend.labels.boxWidth = 12;
                    config.options.plugins.legend.labels.font.size = 10;
                    delete config.options.scales;
                    break;
            }

            currentChart = new Chart(ctx, config);
        }

        // Inisialisasi chart pertama kali
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
        // STAT CARD INTERACTIONS
        // ======================
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'translateY(-3px) scale(1.02)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';

                setTimeout(() => {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }, 300);
            });
        });

        // ======================
        // HISTORI CARD CLICK FUNCTION
        // ======================
        const historiCard = document.getElementById('historiCard');
        if (historiCard) {
            historiCard.addEventListener('click', function(e) {
                e.stopPropagation();

                // Animasi klik
                this.style.transform = 'translateY(-3px) scale(1.02)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';

                setTimeout(() => {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }, 300);

                // Tampilkan detail histori
                alert('📊 Detail Histori Pengunjung\n\n' +
                      '• Data 7 hari terakhir: <?php echo $history_days; ?> hari\n' +
                      '• Total pengunjung: <?php echo $total_visitors; ?> orang\n' +
                      '• Rata-rata: <?php echo $avg_visitors; ?> pengunjung/hari\n' +
                      '• Hari terbanyak: <?php echo $max_visitors_day; ?> (<?php echo $max_visitors_count; ?> pengunjung)\n' +
                      '• Hari ini: <?php echo $today_visitors; ?> pengunjung\n' +
                      '• Kemarin: <?php echo $yesterday_visitors; ?> pengunjung\n\n' +
                      '✅ Data real-time dari database');
            });

            historiCard.style.cursor = 'pointer';
        }

        // ======================
        // ⭐ TESTIMONI CARD CLICK FUNCTION
        // ======================
        const testimonialCard = document.getElementById('testimonialCard');
        if (testimonialCard) {
            testimonialCard.addEventListener('click', function(e) {
                e.stopPropagation();

                // Animasi
                this.style.transform = 'translateY(-3px) scale(1.02)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';

                setTimeout(() => {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }, 300);

                // Info testimoni dari PHP
                const testimonialCount = <?php echo $total_testimonials; ?>;
                const totalContacts = <?php echo $total_contacts; ?>;
                const pendingContacts = <?php echo $pending_contacts; ?>;
                const approvedContacts = <?php echo $approved_contacts; ?>;
                const rejectedContacts = <?php echo $rejected_contacts; ?>;

                let message = '⭐ STATISTIK TESTIMONI\n\n';
                message += `• Total Testimoni: ${testimonialCount}\n`;

                if (testimonialCount > 0) {
                    const percentage = (testimonialCount / totalContacts * 100).toFixed(1);
                    message += `• Persentase: ${percentage}% dari total pesan\n`;
                }

                message += '\n📊 PERBANDINGAN:\n';
                message += `• Total Pesan: ${totalContacts}\n`;
                message += `• Pending: ${pendingContacts}\n`;
                message += `• Approved: ${approvedContacts}\n`;
                message += `• Rejected: ${rejectedContacts}\n\n`;

                message += '💡 INFO:\n';
                message += '• Testimoni adalah pesan khusus tipe "testimonial"\n';
                message += '• Dapat dilihat di halaman Kelola Pesan\n';
                message += '• Gunakan filter tipe untuk melihat testimoni saja';

                alert(message);
            });

            testimonialCard.style.cursor = 'pointer';
        }

        // ======================
        // PAGE LOAD ANIMATION
        // ======================
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(15px)';

                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 40);
            });

            // Animate containers
            const containers = document.querySelectorAll('.chart-container, .visitor-table-container, .activity-container');
            containers.forEach((container, index) => {
                container.style.opacity = '0';
                container.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    container.style.opacity = '1';
                    container.style.transform = 'translateY(0)';
                }, 600 + (index * 100));
            });
        });
    </script>
</body>
</html>
