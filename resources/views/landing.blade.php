<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waluya Land - Belajar Kewirausahaan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        /* PERBAIKAN UNTUK GAMBAR - UKURAN ASLI */
        .image-original {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .hero-image-original {
            width: 100%;
            height: auto;
            max-height: none;
            display: block;
            object-fit: cover;
        }

        .product-image-original {
            width: 100%;
            height: auto;
            max-height: none;
            display: block;
            object-fit: cover;
        }

        .grid-image-original {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .feature-image-original {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        img,
        video {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* HEADER - TETAP SAMA */
        header {
            background: #d4f1f4;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .logo-box {
            background: #333;
            color: #fff;
            padding: 0.3rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 3px;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
            background: none;
            border: none;
            padding: 5px;
            z-index: 1001;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #333;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        nav a:hover {
            color: #666;
        }

        .btn-kickstarter {
            background: #f39c12;
            color: #fff;
            padding: 0.6rem 1.5rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-kickstarter:hover {
            background: #e67e22;
        }

        /* HERO SECTION - BACKGROUND ABU-ABU */
        .hero {
            background: #f8f9fa;
            padding: 4rem 5% 8rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::after,
        .hero::before {
            display: none;
        }

        .hero-content {
            z-index: 2;
            position: relative;
        }

        .hero h1 {
            font-size: clamp(1.8rem, 5vw, 2.8rem);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero p {
            color: #555;
            margin-bottom: 2rem;
            line-height: 1.8;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        .btn-primary {
            background: #f39c12;
            color: #fff;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: transform 0.3s;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-image {
            z-index: 2;
            position: relative;
        }

        .board-placeholder {
            width: 100%;
            background: #e9ecef;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* STATS SECTION - BACKGROUND ABU-ABU */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 3rem 5%;
            background: #f8f9fa;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-card:nth-child(1),
        .stat-card:nth-child(3) {
            background: #7cb342;
            color: #fff;
        }

        .stat-card:nth-child(2),
        .stat-card:nth-child(4) {
            background: #f7e92b;
            color: #333;
        }

        .stat-card h3 {
            font-size: clamp(2rem, 5vw, 2.5rem);
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: clamp(0.85rem, 2vw, 1rem);
        }

        /* STORY SECTION - BACKGROUND ABU-ABU */
        .story-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .story-badge {
            background: #f7e92b;
            color: #333;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .story-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
            align-items: start;
            margin-bottom: 5rem;
        }

        .story-image {
            background: #e9ecef;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .story-content h2 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin-bottom: 1rem;
        }

        .story-content h3 {
            font-size: clamp(1.3rem, 3.5vw, 1.8rem);
            margin-bottom: 1rem;
        }

        .story-content p {
            color: #666;
            line-height: 1.8;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        /* FEATURES GRID */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: #7cb342;
            color: #fff;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: clamp(2rem, 5vw, 2.5rem);
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        /* SECTION STYLES */
        .section-title {
            text-align: center;
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 3rem;
            font-size: clamp(0.9rem, 2vw, 1rem);
            padding: 0 1rem;
        }

        /* WHY LEARN SECTIONS - BACKGROUND ABU-ABU */
        .why-learn-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .why-learn-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .why-learn-media {
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .why-learn-content h2 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin-bottom: 1rem;
        }

        .why-learn-item {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            border-left: 4px solid #7cb342;
        }

        .why-learn-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .why-learn-item strong {
            display: block;
            margin-bottom: 0.8rem;
            font-size: 1.1rem;
            color: #7cb342;
        }

        .why-learn-item p {
            color: #666;
            line-height: 1.6;
            margin: 0;
        }

        /* KETERAMPILAN YANG AKAN DIDAPATKAN - DARI CODE 1 */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .skill-card {
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .skill-card:nth-child(1),
        .skill-card:nth-child(3) {
            background: #7cb342;
            color: #fff;
        }

        .skill-card:nth-child(2),
        .skill-card:nth-child(4) {
            background: #f7e92b;
            color: #333;
        }

        .skill-card:hover {
            transform: translateY(-5px);
        }

        .skill-card h3 {
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            margin-bottom: 0.5rem;
        }

        .skill-card p {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        /* PLACEHOLDER */
        .placeholder {
            width: 100%;
            height: 100%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-weight: 600;
            font-size: clamp(0.85rem, 2vw, 1rem);
        }

        /* NEW FEATURES GRID - ZIGZAG LAYOUT */
        .features-zigzag {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            margin-top: 2rem;
        }

        .feature-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: center;
        }

        .feature-media-box {
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 400px;
        }

        .feature-text-box {
            padding: 0;
            background: transparent;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 400px;
            padding-top: 1rem;
        }

        .feature-text-box h3 {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-text-box p {
            color: #666;
            line-height: 1.8;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        /* Desktop Layout - Zigzag */
        @media (min-width: 768px) {
            .feature-row {
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
            }

            .feature-row:nth-child(even) .feature-media-box {
                order: 2;
            }

            .feature-row:nth-child(even) .feature-text-box {
                order: 1;
            }
        }

        /* NEW GRID LAYOUT FOR AKTIVITAS */
        .grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-template-rows: repeat(6, 1fr);
            gap: 8px;
            margin-top: 2rem;
        }

        .item {
            background-color: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .mobile-only {
            display: block;
        }

        .desktop-only {
            display: none;
        }

        .item-0 {
            grid-column: 1 / span 4;
            grid-row: 1 / span 4;
        }

        .item-1 {
            grid-column: 5 / span 2;
            grid-row: 1 / span 2;
        }

        .item-2 {
            grid-column: 5 / span 2;
            grid-row: 3 / span 2;
        }

        .item-3 {
            grid-column: 1 / span 2;
            grid-row: 5 / span 2;
        }

        .item-4 {
            grid-column: 3 / span 2;
            grid-row: 5 / span 2;
        }

        .item-5 {
            grid-column: 5 / span 2;
            grid-row: 5 / span 2;
        }

        /* PRICING SECTION - BACKGROUND ABU-ABU - DIPERBAIKI */
        .pricing-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .pricing-badge {
            background: #f7e92b;
            color: #333;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .pricing-card {
            border-radius: 15px;
            padding: 2.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-basic {
            background: linear-gradient(135deg, #7cb342 0%, #689f38 100%);
            color: #fff;
        }

        .product-premium {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            color: #333;
            border: 2px solid #dee2e6;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .pricing-card h3 {
            margin-bottom: 1rem;
            font-size: clamp(1.2rem, 3vw, 1.5rem);
        }

        .pricing-card .price {
            font-size: clamp(1.8rem, 4vw, 2.2rem);
            font-weight: bold;
            margin: 1rem 0;
            color: inherit;
        }

        .pricing-card > p {
            font-size: clamp(0.9rem, 2vw, 1rem);
            margin-bottom: 1.5rem;
            min-height: 60px;
        }

        .pricing-card ul {
            list-style: none;
            margin: 1.5rem 0;
            flex-grow: 1;
        }

        .pricing-card ul li {
            padding: 0.5rem 0;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            position: relative;
            padding-left: 1.5rem;
        }

        .product-basic ul li::before {
            content: "✓ ";
            position: absolute;
            left: 0;
            color: #fff;
            font-weight: bold;
        }

        .product-premium ul li::before {
            content: "✓ ";
            position: absolute;
            left: 0;
            color: #7cb342;
            font-weight: bold;
        }

        /* Container untuk gambar produk */
        .product-image-container {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            min-height: 200px;
        }

        /* TESTIMONIAL SECTION - YANG DIPERBAIKI */
        .testimonial-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .testimonial-card {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7cb342 0%, #689f38 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: bold;
            color: white;
            flex-shrink: 0;
        }

        .testimonial-info {
            flex: 1;
        }

        .testimonial-card h4 {
            font-size: clamp(0.95rem, 2.5vw, 1.1rem);
            margin-bottom: 0.3rem;
        }

        .testimonial-institution {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }

        .testimonial-date {
            color: #999;
            font-size: 0.75rem;
        }

        .testimonial-card .testimonial-message {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            line-height: 1.6;
            color: #555;
            margin-top: auto;
            font-style: italic;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }

        /* NO TESTIMONIALS STATE */
        .no-testimonials {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .no-testimonials p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        /* FAQ SECTION - BACKGROUND ABU-ABU */
        .faq-contact-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .faq-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-top: 2rem;
        }

        .faq-contact-form {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
        }

        .faq-contact-form input,
        .faq-contact-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            font-size: clamp(0.85rem, 2vw, 1rem);
        }

        .faq-contact-form textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-submit {
            background: #f39c12;
            color: #fff;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: clamp(0.9rem, 2vw, 1rem);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }

        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .faq-item {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            background: #f8f9fa;
        }

        .faq-item strong {
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        .faq-item::after {
            content: "▼";
            float: right;
            transition: transform 0.3s;
            font-size: 0.8rem;
        }

        .faq-item.active::after {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        /* Mobile Layout - Tampil di bawah 768px */
        .faq-contact-mobile {
            display: block;
        }

        .faq-contact-desktop {
            display: none;
        }

        .faq-contact-form-mobile {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .faq-contact-form-mobile input,
        .faq-contact-form-mobile textarea {
            width: 100%;
            border: 1px solid #ddd;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            font-size: clamp(0.85rem, 2vw, 1rem);
        }

        .faq-contact-form-mobile textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* FORUM SECTION - BACKGROUND ABU-ABU */
        .forum-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .forum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .forum-card {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .forum-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .forum-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: bold;
            color: white;
            flex-shrink: 0;
        }

        .forum-card h4 {
            font-size: clamp(0.95rem, 2.5vw, 1.1rem);
        }

        .forum-card p {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            line-height: 1.6;
        }

        .forum-cta {
            text-align: center;
            margin-top: 3rem;
        }

        .forum-cta h3 {
            font-size: clamp(1.3rem, 4vw, 1.8rem);
            margin-bottom: 1rem;
        }

        .forum-cta p {
            color: #666;
            margin-bottom: 2rem;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        /* FOOTER - BACKGROUND ABU-ABU SEDIKIT LEBIH GELAP */
        footer {
            background: #d4f1f4;
            color: #333;
            padding: 3rem 5%;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-content h4 {
            margin-bottom: 1rem;
            font-size: clamp(1rem, 2.5vw, 1.2rem);
        }

        .footer-content p {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        .footer-content a {
            color: #333;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        .footer-bottom {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 2rem;
            text-align: center;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        /* MODAL - POP UP NOTIFICATION */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
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
            padding: 2.5rem;
            border-radius: 20px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
            transform-origin: center;
        }

        /* MODAL SEND CONFIRMATION - DIUBAH: TIDAK ADA EMAIL FIELD */
        .send-confirm-modal {
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
            transform-origin: center;
        }

        .send-confirm-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #f39c12;
            display: inline-block;
        }

        .generated-email {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #333;
        }

        .email-field {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .email-field label {
            font-weight: bold;
            min-width: 100px;
        }

        .email-field input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .send-confirm-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .btn-send-email {
            background: #f39c12;
            color: #fff;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send-email:hover {
            background: #e67e22;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
        }

        .btn-send-whatsapp {
            background: #25D366;
            color: #fff;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send-whatsapp:hover {
            background: #128C7E;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
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

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .modal-icon.success {
            color: #28a745;
            background: #e8f5e9;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            border: 4px solid #28a745;
        }

        .modal-icon.error {
            color: #dc3545;
            background: #fde8e8;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            border: 4px solid #dc3545;
        }

        .modal-title {
            font-size: clamp(1.5rem, 4vw, 1.8rem);
            margin-bottom: 1rem;
            color: #333;
            font-weight: 700;
        }

        .modal-message {
            color: #666;
            margin-bottom: 2rem;
            font-size: clamp(1rem, 2.5vw, 1.1rem);
            line-height: 1.6;
        }

        .modal-btn {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: #fff;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            font-size: clamp(1rem, 2.5vw, 1.1rem);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
            min-width: 150px;
        }

        .modal-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
        }

        .modal-btn:active {
            transform: translateY(-1px);
        }

        .error-text {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            text-align: left;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero,
            .story-grid,
            .why-learn-grid {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .skills-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem 3%;
            }

            .hamburger {
                display: flex;
            }

            nav {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #d4f1f4;
                flex-direction: column;
                gap: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            nav.active {
                max-height: 500px;
            }

            nav a {
                padding: 1rem 5%;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                width: 100%;
            }

            .hero {
                padding: 2rem 3% 4rem;
                gap: 2rem;
            }

            .stats,
            .pricing-grid,
            .testimonial-grid,
            .forum-grid,
            .skills-grid {
                grid-template-columns: 1fr;
                padding: 2rem 3%;
            }

            .story-section,
            .why-learn-section,
            .faq-contact-section,
            .forum-section,
            .pricing-section,
            .testimonial-section {
                padding: 2rem 3%;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .feature-card,
            .skill-card {
                padding: 1.5rem;
            }

            .pricing-card {
                padding: 2rem;
                margin-bottom: 1rem;
            }

            .pricing-card:hover {
                transform: translateY(-5px);
            }

            .faq-item {
                padding: 1rem 1.5rem;
            }

            .story-grid {
                gap: 2rem;
            }

            .why-learn-grid {
                gap: 2rem;
            }

            /* Grid responsive untuk mobile */
            .grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(6, auto);
                gap: 12px;
            }

            .item-0,
            .item-1,
            .item-2,
            .item-3,
            .item-4,
            .item-5 {
                grid-column: 1 / span 1;
                grid-row: auto;
            }

            .item-0 { grid-row: 1 / span 1; }
            .item-1 { grid-row: 2 / span 1; }
            .item-2 { grid-row: 3 / span 1; }
            .item-3 { grid-row: 4 / span 1; }
            .item-4 { grid-row: 5 / span 1; }
            .item-5 { grid-row: 6 / span 1; }

            /* Send confirm actions responsive */
            .send-confirm-actions {
                flex-direction: column;
            }

            .btn-send-email,
            .btn-send-whatsapp {
                width: 100%;
            }

            /* Desktop Layout - Tampil di atas 768px */
            .faq-contact-mobile {
                display: none;
            }

            .faq-contact-desktop {
                display: block;
            }

            /* Modal responsive */
            .modal-content {
                padding: 2rem;
            }

            .modal-icon {
                font-size: 3rem;
                width: 80px;
                height: 80px;
                line-height: 80px;
            }

            .send-confirm-modal {
                padding: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(6, 1fr);
                grid-template-rows: repeat(6, 1fr);
                gap: 16px;
            }

            .mobile-only {
                display: none;
            }

            .desktop-only {
                display: block;
            }

            .item-0 {
                grid-column: 1 / span 4;
                grid-row: 1 / span 4;
            }

            .item-1 {
                grid-column: 5 / span 2;
                grid-row: 1 / span 2;
            }

            .item-2 {
                grid-column: 5 / span 2;
                grid-row: 3 / span 2;
            }

            .item-3 {
                grid-column: 1 / span 2;
                grid-row: 5 / span 2;
            }

            .item-4 {
                grid-column: 3 / span 2;
                grid-row: 5 / span 2;
            }

            .item-5 {
                grid-column: 5 / span 2;
                grid-row: 5 / span 2;
            }

            /* Mobile Layout - Tampil di bawah 768px */
            .faq-contact-mobile {
                display: none;
            }

            .faq-contact-desktop {
                display: block;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 0.8rem 3%;
            }

            .logo {
                font-size: 1rem;
            }

            .hero {
                padding: 1.5rem 3% 3rem;
            }

            .stats {
                gap: 1rem;
                padding: 2rem 3%;
            }

            .stat-card {
                padding: 1rem;
            }

            .story-section,
            .why-learn-section {
                padding: 2rem 3%;
            }

            .features-grid {
                gap: 1rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .testimonial-card,
            .forum-card {
                padding: 1.5rem;
            }

            .faq-contact-form,
            .faq-contact-form-mobile {
                padding: 1.5rem;
            }

            .pricing-card {
                padding: 1.5rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .modal-icon {
                font-size: 2.5rem;
                width: 70px;
                height: 70px;
                line-height: 70px;
                margin-bottom: 1rem;
            }

            .modal-title {
                font-size: 1.3rem;
            }

            .modal-message {
                font-size: 0.9rem;
            }

            /* Mobile Layout - Tampil di bawah 768px */
            .faq-contact-mobile {
                display: block;
            }

            .faq-contact-desktop {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <span class="logo-box">■</span>
            <span>WALUYA LAND</span>
        </div>
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav id="navMenu">
            <a href="#home">About</a>
            <a href="#pricing">Pricing</a>
            <a href="#testimonial">Testimonial</a>
            <a href="#contact" class="btn-kickstarter">Kontak Kami</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Belajar Kewirausahaan Dengan Bermain</h1>
            <p>Sebuah permainan papan inovatif yang mengubah konsep bisnis yang kompleks menjadi pengalaman belajar yang
                menarik, interaktif bagi siswa dan profesional.</p>
            <a href="#pricing" class="btn-primary">Dapatkan Sekarang</a>
        </div>
        <div class="hero-image">
            <div class="board-placeholder">
                @if($heroMedia)
                    @if($heroMedia->isVideo())
                        <video controls autoplay muted loop class="hero-image-original">
                            <source src="{{ $heroMedia->getMediaUrl() }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @else
                        <img src="{{ $heroMedia->getMediaUrl() }}"
                             alt="{{ $heroMedia->title }}"
                             class="hero-image-original"
                             onerror="this.src='https://via.placeholder.com/800x600/7cb342/ffffff?text={{ urlencode($heroMedia->title) }}'">
                    @endif
                @else
                    <img src="https://via.placeholder.com/800x600/7cb342/ffffff?text=Waluya+Land+Board+Game"
                         alt="Waluya Land Board Game"
                         class="hero-image-original">
                @endif
            </div>
        </div>
    </section>

    <section id="home" class="stats">
        <div class="stat-card">
            <h3>85%</h3>
            <p>Kepuasan user sejauh ini saat bermain</p>
        </div>
        <div class="stat-card">
            <h3>50+</h3>
            <p>Sekolah dan siswa yang sudah menekankannya</p>
        </div>
        <div class="stat-card">
            <h3>80%</h3>
            <p>Membantu mereka dari pengalaman baru</p>
        </div>
        <div class="stat-card">
            <h3>87%</h3>
            <p>Meningkatkan pemahaman pembelajaran</p>
        </div>
    </section>

    <section class="story-section">
        <div class="story-grid">
            <div class="story-image">
                @if($storyMedia)
                    <img src="{{ $storyMedia->getMediaUrl() }}"
                         alt="{{ $storyMedia->title }}"
                         class="image-original"
                         onerror="this.src='https://via.placeholder.com/350x350/f8f9fa/333333?text={{ urlencode($storyMedia->title) }}'">
                @else
                    <img src="https://via.placeholder.com/350x350/f8f9fa/333333?text=Story+Image"
                         alt="Story"
                         class="image-original">
                @endif
            </div>
            <div class="story-content">
                <span class="story-badge">Background</span>
                <h2>Cerita di Balik GameBoard</h2>
                <p>Terlatir dari ide para tenaga pendidikan didalam kewirausahaan dalam kehidupan untuk memulai
                    pendidikan kewirausahaan ini lebih menarik, interaktif dan praktis sebagai alat pembelajaran melalui
                    permainan papan kami menyajikan kesempatan antara teori pelajaran dan implementasi di lapangan</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <h3>Problem Solving</h3>
                <p>Dapat membantu siswa menyebarkan kebutuhan untuk pembelajaran interaktif dalam pendidikan bisnis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Kolaborasi</h3>
                <p>Mendorong kerja tim antar industri secara efektif</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Pengalaman Praktis</h3>
                <p>Dorong para mengambil proyek kewirausahaan dalam membuat konsep bisnis yang kompleks menjadi mudah
                    dipahami dan menyenangkan bagi semua peserta didik</p>
            </div>
        </div>
    </section>

    <!-- BAGIAN MENGAPA BELAJAR KEWIRAUSAHAAN YANG DIPERBAIKI -->
    <section class="why-learn-section">
        <div class="why-learn-grid">
            <div class="why-learn-media">
                @if($whyLearnMedia)
                    <img src="{{ $whyLearnMedia->getMediaUrl() }}"
                         alt="{{ $whyLearnMedia->title }}"
                         class="image-original"
                         onerror="this.src='https://via.placeholder.com/600x400/f8f9fa/333333?text={{ urlencode($whyLearnMedia->title) }}'">
                @else
                    <img src="https://via.placeholder.com/600x400/f8f9fa/333333?text=Belajar+Kewirausahaan"
                         alt="Belajar Kewirausahaan"
                         class="image-original">
                @endif
            </div>
            <div class="why-learn-content">
                <h2>Mengapa Belajar Kewirausahaan Melalui Permainan Papan?</h2>

                <div class="why-learn-item">
                    <strong>① Pengalaman Belajar Interaktif dan Praktis</strong>
                    <p>Melatih pengambilan keputusan dan presentasi bisnis dengan feedback langsung</p>
                </div>

                <div class="why-learn-item">
                    <strong>② Real-Case Skenario</strong>
                    <p>Hadapi tantangan berdasarkan situasi bisnis nyata</p>
                </div>

                <div class="why-learn-item">
                    <strong>③ Belajar Kolaboratif</strong>
                    <p>Kembangkan strategi dan komunikasi sambil bersinergi dan bekerja sama dengan orang lain</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN KETERAMPILAN YANG AKAN DIDAPATKAN -->
    <section style="padding: 2rem 0; background: #f8f9fa;">
        <h2 class="section-title">Keterampilan yang Akan Anda Dapatkan</h2>
        <p class="section-subtitle">Main keterampilan kewirausahaan yang sukses melalui permainan yang menarik</p>
        <div class="skills-grid">
            <div class="skill-card">
                <div class="feature-icon">🔧</div>
                <h3>Problem Solving</h3>
                <p>Mengidentifikasi masalah dan mencari solusi kreatif dalam berbagai situasi bisnis</p>
            </div>
            <div class="skill-card">
                <div class="feature-icon">🎓</div>
                <h3>Kerjasama</h3>
                <p>Belajar untuk bekerja berbasis skuid untuk mencoba kerjasama interaktif</p>
            </div>
            <div class="skill-card">
                <div class="feature-icon">📊</div>
                <h3>Pengambilan Keputusan</h3>
                <p>Berlatih membuat keputusan keseluruhan yang mempengaruhi layanan</p>
            </div>
            <div class="skill-card">
                <div class="feature-icon">✨</div>
                <h3>Inovasi</h3>
                <p>Dorong aktivitas membuat ide strategi pemasaran yang efektif</p>
            </div>
        </div>
    </section>

    <!-- BAGIAN FITUR UNGGULAN DENGAN LAYOUT ZIGZAG -->
    <section id="features" style="padding:4rem 5%; background:#f8f9fa;">
        <span class="story-badge">Features</span>
        <h2 class="section-title">Fitur Unggulan</h2>

        <div class="features-zigzag">
            @if($featuresMedia && $featuresMedia->count() > 0)
                @foreach($featuresMedia as $index => $item)
                    <div class="feature-row">
                        <div class="feature-media-box">
                            @if($item->isVideo())
                                <video controls class="feature-image-original">
                                    <source src="{{ $item->getMediaUrl() }}" type="video/mp4">
                                    Browser Anda tidak mendukung video.
                                </video>
                            @else
                                <img src="{{ $item->getMediaUrl() }}"
                                     alt="{{ $item->title }}"
                                     class="feature-image-original"
                                     onerror="this.src='https://via.placeholder.com/600x400/f8f9fa/333333?text={{ urlencode($item->title) }}'">
                            @endif
                        </div>
                        <div class="feature-text-box">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->description ?? 'Fitur menarik untuk pembelajaran kewirausahaan' }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback -->
                <div class="feature-row">
                    <div class="feature-media-box">
                        <img src="https://via.placeholder.com/600x400/f8f9fa/333333?text=Feature+1"
                             alt="Feature 1"
                             class="feature-image-original">
                    </div>
                    <div class="feature-text-box">
                        <h3>Game Interaktif</h3>
                        <p>Pengalaman belajar yang menyenangkan melalui permainan papan interaktif</p>
                    </div>
                </div>
            @endif
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="#pricing" class="btn-primary">Dapatkan Sekarang</a>
        </div>
    </section>

    <!-- BAGIAN AKTIVITAS DENGAN GRID LAYOUT BARU -->
    <section id="aktivitas" style="padding:4rem 5%;background:#f8f9fa;">
        <h2 class="section-title">Aktivitas Terbaru & Tutorial</h2>
        <p class="section-subtitle">Kumpulan aktivitas bermain GameBoard & bagaimana kita menggunakannya</p>

        <div class="grid">
            @if($aktivitasMedia && $aktivitasMedia->count() > 0)
                @foreach($aktivitasMedia as $index => $item)
                    <div class="item item-{{ $index }}">
                        @if($item->isVideo())
                            <video controls class="grid-image-original">
                                <source src="{{ $item->getMediaUrl() }}" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        @else
                            <img src="{{ $item->getMediaUrl() }}"
                                 alt="{{ $item->title }}"
                                 class="grid-image-original"
                                 onerror="this.src='https://via.placeholder.com/400x300/f8f9fa/333333?text={{ urlencode($item->title) }}'">
                        @endif
                    </div>
                @endforeach
            @else
                @for($i = 0; $i < 6; $i++)
                    <div class="item item-{{ $i }}">
                        <img src="https://via.placeholder.com/400x300/f8f9fa/333333?text=Aktivitas+{{ $i+1 }}"
                             alt="Aktivitas {{ $i+1 }}"
                             class="grid-image-original">
                    </div>
                @endfor
            @endif
        </div>
    </section>

    <!-- BAGIAN PRICING SECTION YANG DIPERBAIKI -->
    <section id="pricing" class="pricing-section">
        <span class="pricing-badge">Product</span>
        <h2 class="section-title">Main Sekaligus Belajar, Semua Dimulai dari Sini!</h2>
        <p class="section-subtitle">Tingkatkan pemahaman kewirausahaan lewat board game yang seru dan interaktif</p>

        <div class="pricing-grid">
            @if($productsMedia && $productsMedia->count() > 0)
                @foreach($productsMedia as $index => $product)
                    <div class="pricing-card {{ $index == 0 ? 'product-basic' : 'product-premium' }}">
                        <!-- Gambar Produk -->
                        <div class="product-image-container">
                            @if($product->isImage())
                                <img src="{{ $product->getMediaUrl() }}"
                                     alt="{{ $product->title }}"
                                     class="product-image-original"
                                     onerror="this.src='https://via.placeholder.com/600x400/{{ $index == 0 ? '7cb342' : 'f7e92b' }}/{{ $index == 0 ? 'ffffff' : '333333' }}?text={{ urlencode($product->title) }}'">
                            @else
                                <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; color: #{{ $index == 0 ? '999' : '666' }};">
                                    <div style="text-align: center;">
                                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">{{ $index == 0 ? '🎲' : '⭐' }}</div>
                                        <p>{{ $product->title }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- JUDUL DARI DATABASE -->
                        <h3>{{ $product->title }}</h3>

                        <!-- HARGA DARI DATABASE -->
                        <div class="price">{{ $product->formatted_price }}</div>

                        <!-- FITUR PRODUK -->
                        <ul>
                            <!-- Gunakan deskripsi dari database jika ada, jika tidak gunakan default -->
                            @if($product->description && strpos($product->description, "\n") !== false)
                                <!-- Jika ada deskripsi panjang di database, pecah menjadi list -->
                                @php
                                    $features = explode("\n", $product->description);
                                    foreach($features as $feature) {
                                        if(trim($feature)) {
                                            echo '<li>' . trim($feature) . '</li>';
                                        }
                                    }
                                @endphp
                            @else
                                <!-- Default features -->
                                @if($index == 0)
                                @else
                                @endif
                            @endif
                        </ul>

                        <!-- Tombol Aksi -->
                        <a href="https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->title) }}%20(Rp%20{{ number_format($product->price, 0, ',', '.') }})"
                           class="btn-primary"
                           style="display: block; text-align: center; margin-top: 1.5rem;{{ $index > 0 ? ' background: linear-gradient(135deg, #f7e92b 0%, #ffc107 100%); color: #333;' : '' }}"
                           target="_blank">
                            {{ $index > 0 ? '📦 Pre-Order Sekarang' : '🛒 Dapatkan Sekarang' }}
                        </a>
                    </div>
                @endforeach
            @else
                <!-- Fallback jika tidak ada produk di database -->
                <!-- Produk Basic -->
                <div class="pricing-card product-basic">
                    <div class="product-image-container">
                        <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; color: #999;">
                            <div style="text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 0.5rem;">🎲</div>
                                <p>Waluya Land Basic</p>
                            </div>
                        </div>
                    </div>
                    <h3>Waluya Land Basic</h3>
                    <div class="price">Rp 300.000</div>
                    <p style="margin-bottom: 1.5rem;">Paket lengkap untuk mulai belajar kewirausahaan</p>
                    <ul>
                        <li>1 set board game lengkap</li>
                        <li>Kartu permainan dan token</li>
                        <li>Buku panduan bermain</li>
                        <li>Akses tutorial online</li>
                    </ul>
                    <a href="https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20Waluya%20Land%20Basic!"
                       class="btn-primary"
                       style="display: block; text-align: center; margin-top: 1.5rem;"
                       target="_blank">🛒 Dapatkan Sekarang</a>
                </div>

                <!-- Produk Premium -->
                <div class="pricing-card product-premium">
                    <div class="product-image-container">
                        <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; color: #666;">
                            <div style="text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 0.5rem;">⭐</div>
                                <p>Waluya Land Premium</p>
                            </div>
                        </div>
                    </div>
                    <h3>Waluya Land Premium</h3>
                    <div class="price">Rp 450.000</div>
                    <p style="margin-bottom: 1.5rem;">Paket premium dengan fitur tambahan eksklusif</p>
                    <ul>
                        <li>Semua fitur paket basic</li>
                        <li>Kupon diskon 15% untuk pembelian berikutnya</li>
                        <li>Buku panduan advanced edition</li>
                        <li>Akses workshop online eksklusif</li>
                        <li>Sesi konsultasi gratis 1x</li>
                    </ul>
                    <a href="https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20Waluya%20Land%20Premium!"
                       class="btn-primary"
                       style="display: block; text-align: center; margin-top: 1.5rem; background: linear-gradient(135deg, #f7e92b 0%, #ffc107 100%); color: #333;"
                       target="_blank">🛒 Dapatkan Sekarang</a>
                </div>
            @endif
        </div>
    </section>

    <!-- =========================================== -->
    <!-- BAGIAN TESTIMONIAL YANG SUDAH DIPERBAIKI -->
    <!-- =========================================== -->
    <section id="testimonial" class="testimonial-section">
        <span class="story-badge">Testimoni</span>
        <h2 class="section-title">Apa yang Dikatakan Para Pemain</h2>
        <p class="section-subtitle">Feedback dan manfaat dari siswa</p>

        <div class="testimonial-grid">
            @if(isset($testimonials) && $testimonials->count() > 0)
                @foreach($testimonials->take(5) as $testimonial)
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                @php
                                    $names = explode(' ', $testimonial->name);
                                    $initials = '';
                                    foreach($names as $n) {
                                        if(!empty(trim($n))) {
                                            $initials .= strtoupper(substr(trim($n), 0, 1));
                                        }
                                    }
                                    echo substr($initials, 0, 2) ?: 'GU';
                                @endphp
                            </div>
                            <div class="testimonial-info">
                                <h4>{{ $testimonial->name }}</h4>
                                <div class="testimonial-institution">
                                    {{ $testimonial->institution ?? 'Pengguna' }}
                                </div>
                                <div class="testimonial-date">
                                    {{ $testimonial->created_at->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-message">"{{ $testimonial->message }}"</p>
                    </div>
                @endforeach
            @else
                <div class="no-testimonials">
                    <h3>Belum ada testimoni</h3>
                    <p>Jadilah yang pertama memberikan testimoni tentang pengalaman Anda!</p>
                    <button onclick="showTestimonialForm()" class="btn-primary">⭐ Berikan Testimoni</button>
                </div>
            @endif
        </div>
    </section>

    <!-- BAGIAN FAQ DENGAN LAYOUT RESPONSIF -->
    <section id="contact" class="faq-contact-section">
        <h2 class="section-title">Frequently Asked Questions</h2>

        <!-- Mobile Layout (satu kolom) -->
        <div class="faq-contact-mobile">
            <div class="faq-accordion">
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div>
                        <strong>Berlaku untuk siapa saja waluya land ini?</strong>
                        <div class="faq-answer"
                            style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                            Waluya Land dirancang untuk siswa SMA/SMK, mahasiswa, dan siapa saja yang ingin belajar
                            kewirausahaan dengan cara yang menyenangkan dan interaktif.
                        </div>
                    </div>
                </div>
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div>
                        <strong>Adakah panduan bermain bagi kami?</strong>
                        <div class="faq-answer"
                            style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                            Ya, setiap paket Waluya Land dilengkapi dengan buku panduan lengkap yang menjelaskan aturan
                            permainan dan cara bermain.
                        </div>
                    </div>
                </div>
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div>
                        <strong>Capaian pelajaran apa yang terpenuhi oleh Waluya Land?</strong>
                        <div class="faq-answer"
                            style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                            Waluya Land membantu mencapai kompetensi pemahaman kewirausahaan, problem solving, kerja
                            tim, dan pengambilan keputusan bisnis.
                        </div>
                    </div>
                </div>
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div>
                        <strong>Apa waluya land ini?</strong>
                        <div class="faq-answer"
                            style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                            Waluya Land adalah board game edukatif yang mengajarkan konsep kewirausahaan dan bisnis
                            melalui permainan interaktif.
                        </div>
                    </div>
                </div>
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div>
                        <strong>Apakah berlaku untuk semua kejuruan?</strong>
                        <div class="faq-answer"
                            style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                            Ya, Waluya Land dirancang fleksibel dan dapat disesuaikan dengan berbagai kurikulum
                            pendidikan dan kejuruan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-contact-form-mobile">
                <p style="margin-bottom: 1.5rem; color: #666; text-align: center;">Punya pertanyaan lain? silahkan cantumkan disini</p>
                <form id="contactFormMobile" onsubmit="openSendConfirmModal('mobile'); return false;">
                    @csrf
                    <input type="hidden" name="type" value="forum">

                    <input type="text" name="name" placeholder="Nama Lengkap *" id="nameMobile" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                    <input type="text" name="institution" placeholder="Instansi (opsional)" id="institutionMobile">
                    @error('institution')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                    <textarea name="message" placeholder="Pesan/Pertanyaan *" id="messageMobile" required></textarea>
                    @error('message')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                    <!-- TOMBOL "KIRIM" SAJA -->
                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
            </div>
        </div>

        <!-- Desktop Layout (2 kolom) -->
        <div class="faq-contact-desktop">
            <div class="faq-contact-grid">
                <div class="faq-contact-form">
                    <p style="margin-bottom: 1.5rem; color: #666;">Punya pertanyaan lain? silahkan cantumkan disini!</p>
                    <form id="contactFormDesktop" onsubmit="openSendConfirmModal('desktop'); return false;">
                        @csrf
                        <input type="hidden" name="type" value="forum">

                        <input type="text" name="name" placeholder="Nama Lengkap *" id="nameDesktop" required>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror

                        <input type="text" name="institution" placeholder="Instansi (opsional)" id="institutionDesktop">
                        @error('institution')
                            <span class="error-text">{{ $message }}</span>
                        @enderror

                        <textarea name="message" placeholder="Pesan/Pertanyaan *" id="messageDesktop" required></textarea>
                        @error('message')
                            <span class="error-text">{{ $message }}</span>
                        @enderror

                        <!-- TOMBOL "KIRIM" SAJA -->
                        <button type="submit" class="btn-submit">Kirim</button>
                    </form>
                </div>

                <div class="faq-accordion">
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div>
                            <strong>Berlaku untuk siapa saja waluya land ini?</strong>
                            <div class="faq-answer"
                                style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                                Waluya Land dirancang untuk siswa SMA/SMK, mahasiswa, dan siapa saja yang ingin belajar
                                kewirausahaan dengan cara yang menyenangkan dan interaktif.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div>
                            <strong>Adakah panduan bermain bagi kami?</strong>
                            <div class="faq-answer"
                                style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                                Ya, setiap paket Waluya Land dilengkapi dengan buku panduan lengkap yang menjelaskan aturan
                                permainan dan cara bermain.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div>
                            <strong>Capaian pelajaran apa yang terpenuhi oleh Waluya Land?</strong>
                            <div class="faq-answer"
                                style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                                Waluya Land membantu mencapai kompetensi pemahaman kewirausahaan, problem solving, kerja
                                tim, dan pengambilan keputusan bisnis.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div>
                            <strong>Apa waluya land ini?</strong>
                            <div class="faq-answer"
                                style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                                Waluya Land adalah board game edukatif yang mengajarkan konsep kewirausahaan dan bisnis
                                melalui permainan interaktif.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div>
                            <strong>Apakah berlaku untuk semua kejuruan?</strong>
                            <div class="faq-answer"
                                style="display: none; margin-top: 0.5rem; color: #666; font-weight: normal;">
                                Ya, Waluya Land dirancang fleksibel dan dapat disesuaikan dengan berbagai kurikulum
                                pendidikan dan kejuruan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN FORUM YANG DIPERBAIKI -->
    <section class="forum-section">
        <span class="story-badge">Forum</span>
        <h2 class="section-title">Forum Terbuka untuk Tanya, Saran, dan Insight</h2>
        <p class="section-subtitle">Punya ide, saran, atau pertanyaan untuk kami? ajukan pertanyaan langsung pada tim kami</p>

        <div class="forum-grid">
            @if(isset($forumPosts) && $forumPosts->count() > 0)
                @foreach($forumPosts as $post)
                    <div class="forum-card">
                        <div class="forum-header">
                            <div class="forum-avatar">
                                @php
                                    $names = explode(' ', $post->name);
                                    $initials = '';
                                    foreach($names as $n) {
                                        if(!empty(trim($n))) {
                                            $initials .= strtoupper(substr(trim($n), 0, 1));
                                        }
                                    }
                                    echo substr($initials, 0, 2) ?: 'GU';
                                @endphp
                            </div>
                            <div>
                                <h4>{{ $post->name }}</h4>
                                <small style="color: #999;">
                                    {{ $post->institution ?? 'Pengguna' }}
                                </small>
                                <br>
                                <small style="color: #999;">
                                    {{ $post->email }}
                                </small>
                            </div>
                        </div>
                        <p>"{{ Str::limit($post->message, 120) }}"</p>
                    </div>
                @endforeach
            @else
                <div class="forum-card">
                    <div class="forum-header">
                        <div class="forum-avatar">WL</div>
                        <div>
                            <h4>Waluya Land Team</h4>
                            <small style="color: #999;">Admin</small>
                            <br>
                            <small style="color: #999;">admin@waluyaland.com</small>
                        </div>
                    </div>
                    <p>"Selamat datang di forum Waluya Land! Silakan ajukan pertanyaan atau saran Anda di sini."</p>
                </div>
            @endif
        </div>

        <div class="forum-cta">
            <h3>Siap untuk mengubah pengalaman belajar Anda?</h3>
            <p>Bergabunglah dengan ribuan siswa dan pendidik yang sudah menggunakan Waluya Land</p>
            <a href="https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20Waluya%20Land!"
                class="btn-primary" style="padding: 1.2rem 3rem;" target="_blank">Dapatkan Sekarang</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div>
                <h4>📚 Waluya Land</h4>
                <p>Making entrepreneurship education engaging and accessible through innovative board games</p>
            </div>
            <div>
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
            </div>
            <div>
                <h4>Support</h4>
                <a href="#contact">Contact Us</a>
                <a href="#testimonial">Testimonials</a>
            </div>
            <div>
                <h4>Dapatkan di e-commerce</h4>
                <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                    <a href="https://shopee.co.id" target="_blank">
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/shopee.svg"
                            alt="Shopee"
                            style="height: 35px; filter: invert(38%) sepia(86%) saturate(2798%) hue-rotate(354deg) brightness(96%) contrast(93%);">
                    </a>
                    <a href="https://www.tokopedia.com" target="_blank">
                        <img src="https://cdn.brandfetch.io/idoruRsDhk/theme/dark/symbol.svg?c=1dxbfHSJFAPEGdCLU4o5B"
                            alt="Tokopedia" style="height: 35px;">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Waluya Land. All rights reserved.</p>
        </div>
    </footer>

    <!-- MODAL KONFIRMASI PENGIRIMAN - TANPA EMAIL FIELD -->
    <div class="modal-overlay" id="sendConfirmModal">
        <div class="send-confirm-modal">
            <div class="send-confirm-icon">📧</div>
            <h3 class="modal-title">Konfirmasi Pengiriman Pesan</h3>
            <p class="modal-message">Pesan Anda siap dikirim:</p>

            <div class="generated-email">
                <div class="email-field">
                    <label>Nama Lengkap:</label>
                    <span id="confirmName"></span>
                </div>
                <div class="email-field">
                    <label>Instansi:</label>
                    <span id="confirmInstitution"></span>
                </div>
                <div class="email-field">
                    <label>Pesan:</label>
                    <div style="margin-top: 0.5rem; padding: 0.8rem; background: #fff; border-radius: 5px;">
                        <span id="confirmMessage"></span>
                    </div>
                </div>
            </div>

            <div class="send-confirm-actions">
                <button class="btn-send-email" onclick="sendFormData()">
                    <span>📧 Kirim via Email</span>
                </button>
                <button class="btn-send-whatsapp" onclick="sendWhatsAppMessage()">
                    <span>💬 Kirim via WhatsApp</span>
                </button>
            </div>

            <button class="modal-btn" onclick="closeSendConfirmModal()"
                    style="margin-top: 1.5rem; background: #6c757d;">
                Kembali ke Form
            </button>
        </div>
    </div>

    <!-- MODAL POP UP SUKSES -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon success">✓</div>
            <h3 class="modal-title">Pesan Berhasil Dikirim!</h3>
            <p class="modal-message" id="successMessage">Terima kasih telah menghubungi kami. Kami akan segera membalas pesan Anda melalui email yang telah Anda berikan.</p>
            <button class="modal-btn" onclick="closeModal()">Mengerti</button>
        </div>
    </div>

    <!-- MODAL POP UP ERROR -->
    <div class="modal-overlay" id="errorModal">
        <div class="modal-content">
            <div class="modal-icon error">✕</div>
            <h3 class="modal-title">Gagal Mengirim Pesan</h3>
            <p class="modal-message" id="errorMessage">Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.</p>
            <button class="modal-btn" onclick="closeModal()">Coba Lagi</button>
        </div>
    </div>

    <!-- MODAL FORM TESTIMONI -->
    <div class="modal-overlay" id="testimonialModal">
        <div class="modal-content" style="max-width: 500px; padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 class="modal-title">⭐ Berikan Testimoni</h2>
                <button onclick="closeTestimonialModal()" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #666; line-height: 1;">×</button>
            </div>

            <form action="{{ route('contact.store') }}" method="POST" id="testimonialForm">
                @csrf
                <input type="hidden" name="type" value="testimonial">

                <div class="form-group">
                    <input type="text" name="name" placeholder="Nama Lengkap *" required value="{{ old('name') }}">
                    @error('name')
                        <span class="error-text" style="display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email *" required value="{{ old('email') }}">
                    @error('email')
                        <span class="error-text" style="display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="institution" placeholder="Instansi/Sekolah (opsional)" value="{{ old('institution') }}">
                    @error('institution')
                        <span class="error-text" style="display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea name="message" placeholder="Ceritakan pengalaman Anda menggunakan Waluya Land... *" required rows="5">{{ old('message') }}</textarea>
                    @error('message')
                        <span class="error-text" style="display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="modal-btn" style="flex: 1;">Kirim Testimoni</button>
                    <button type="button" onclick="closeTestimonialModal()" class="btn btn-secondary" style="padding: 1rem 2rem; background: #95a5a6;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        function toggleFaq(element) {
            element.classList.toggle('active');
            const answer = element.querySelector('.faq-answer');
            if (element.classList.contains('active')) {
                answer.style.display = 'block';
            } else {
                answer.style.display = 'none';
            }
        }

        // ===========================================
        // FUNGSI UNTUK MODAL KONFIRMASI PENGIRIMAN
        // ===========================================
        let currentFormType = '';
        let formDataToSend = {};

        function openSendConfirmModal(formType) {
            currentFormType = formType;

            // Ambil nilai dari form yang sesuai
            let nameInput, institutionInput, messageInput;

            if (formType === 'mobile') {
                nameInput = document.getElementById('nameMobile');
                institutionInput = document.getElementById('institutionMobile');
                messageInput = document.getElementById('messageMobile');
            } else {
                nameInput = document.getElementById('nameDesktop');
                institutionInput = document.getElementById('institutionDesktop');
                messageInput = document.getElementById('messageDesktop');
            }

            const name = nameInput.value.trim();
            const institution = institutionInput.value.trim();
            const message = messageInput.value.trim();

            // Validasi
            if (!name) {
                showErrorModal('Harap isi Nama Lengkap');
                return;
            }

            if (!message) {
                showErrorModal('Harap isi Pesan/Pertanyaan');
                return;
            }

            // Simpan data untuk dikirim nanti
            formDataToSend = {
                name: name,
                institution: institution,
                message: message,
                formType: formType
            };

            // Generate email otomatis (untuk backend)
            let generatedEmail = generateEmailFromName(name);

            // Update form dengan email yang digenerate (field tersembunyi)
            if (formType === 'mobile') {
                // Tambahkan field email tersembunyi di form mobile
                let hiddenEmailField = document.querySelector('#contactFormMobile input[name="email"]');
                if (!hiddenEmailField) {
                    hiddenEmailField = document.createElement('input');
                    hiddenEmailField.type = 'hidden';
                    hiddenEmailField.name = 'email';
                    hiddenEmailField.id = 'hiddenEmailMobile';
                    document.getElementById('contactFormMobile').appendChild(hiddenEmailField);
                }
                hiddenEmailField.value = generatedEmail;
            } else {
                // Tambahkan field email tersembunyi di form desktop
                let hiddenEmailField = document.querySelector('#contactFormDesktop input[name="email"]');
                if (!hiddenEmailField) {
                    hiddenEmailField = document.createElement('input');
                    hiddenEmailField.type = 'hidden';
                    hiddenEmailField.name = 'email';
                    hiddenEmailField.id = 'hiddenEmailDesktop';
                    document.getElementById('contactFormDesktop').appendChild(hiddenEmailField);
                }
                hiddenEmailField.value = generatedEmail;
            }

            // Tampilkan data di modal konfirmasi
            document.getElementById('confirmName').textContent = name;
            document.getElementById('confirmInstitution').textContent = institution || '-';
            document.getElementById('confirmMessage').textContent = message;

            // Tampilkan modal
            document.getElementById('sendConfirmModal').classList.add('show');
        }

        function generateEmailFromName(name) {
            // Bersihkan nama dari karakter khusus
            let cleanName = name.toLowerCase()
                .replace(/[^a-z0-9\s]/g, '') // Hapus karakter khusus
                .replace(/\s+/g, ' ') // Normalisasi spasi
                .trim();

            // Ganti spasi dengan titik
            let emailName = cleanName.replace(/\s+/g, '.');

            // Jika nama terlalu pendek, tambahkan angka acak
            if (emailName.length < 3) {
                emailName += Math.floor(Math.random() * 100);
            }

            // Tambahkan domain @gmail.com
            return emailName + '@gmail.com';
        }

        function sendFormData() {
            // Kirim data ke server
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('type', 'forum');
            formData.append('name', formDataToSend.name);

            // Gunakan email yang telah digenerate (dari field tersembunyi)
            let emailField;
            if (currentFormType === 'mobile') {
                emailField = document.getElementById('hiddenEmailMobile');
            } else {
                emailField = document.getElementById('hiddenEmailDesktop');
            }
            formData.append('email', emailField.value);

            formData.append('institution', formDataToSend.institution || '');
            formData.append('message', formDataToSend.message);

            // Tampilkan loading
            const sendBtn = document.querySelector('.btn-send-email');
            const originalText = sendBtn.innerHTML;
            sendBtn.innerHTML = 'Mengirim...';
            sendBtn.disabled = true;

            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset form
                    if (currentFormType === 'mobile') {
                        document.getElementById('contactFormMobile').reset();
                    } else {
                        document.getElementById('contactFormDesktop').reset();
                    }

                    // Tutup modal konfirmasi
                    closeSendConfirmModal();

                    // Tampilkan modal sukses
                    showSuccessModal('Pesan berhasil dikirim! Kami akan menghubungi Anda melalui email.');

                    // Scroll ke atas
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } else {
                    showErrorModal(data.message || 'Terjadi kesalahan saat mengirim pesan.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorModal('Koneksi bermasalah. Silakan coba lagi.');
            })
            .finally(() => {
                // Reset button
                sendBtn.innerHTML = originalText;
                sendBtn.disabled = false;
            });
        }

        function sendWhatsAppMessage() {
            // Format pesan untuk WhatsApp
            const name = formDataToSend.name;
            const institution = formDataToSend.institution;
            const message = formDataToSend.message;

            let whatsappMessage = `Halo Waluya Land!\n\n`;
            whatsappMessage += `Saya ingin bertanya mengenai produk Waluya Land:\n\n`;
            whatsappMessage += `Nama: ${name}\n`;
            if (institution) {
                whatsappMessage += `Instansi: ${institution}\n`;
            }
            whatsappMessage += `Pertanyaan/Pesan: ${message}\n\n`;
            whatsappMessage += `Mohon informasi lebih lanjut. Terima kasih!`;

            // Encode pesan untuk URL
            const encodedMessage = encodeURIComponent(whatsappMessage);

            // Nomor WhatsApp
            const phoneNumber = '628986908167';

            // Buat URL WhatsApp
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

            // Buka WhatsApp di tab baru
            window.open(whatsappUrl, '_blank');

            // Tutup modal konfirmasi
            closeSendConfirmModal();

            // Tampilkan konfirmasi
            showSuccessModal('WhatsApp akan terbuka. Silakan kirim pesan Anda!');
        }

        function closeSendConfirmModal() {
            document.getElementById('sendConfirmModal').classList.remove('show');
        }

        // ===========================================
        // FUNGSI MODAL LAINNYA
        // ===========================================
        function showSuccessModal(message) {
            if (message) {
                document.getElementById('successMessage').textContent = message;
            }
            document.getElementById('successModal').classList.add('show');
            // Auto close after 5 seconds
            setTimeout(() => {
                closeModal();
            }, 5000);
        }

        function showErrorModal(message) {
            if (message) {
                document.getElementById('errorMessage').textContent = message;
            }
            document.getElementById('errorModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('successModal').classList.remove('show');
            document.getElementById('errorModal').classList.remove('show');
        }

        // Fungsi untuk testimonial modal
        function showTestimonialForm() {
            document.getElementById('testimonialModal').classList.add('show');
        }

        function closeTestimonialModal() {
            document.getElementById('testimonialModal').classList.remove('show');
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (this.id === 'sendConfirmModal') {
                        closeSendConfirmModal();
                    } else if (this.id === 'testimonialModal') {
                        closeTestimonialModal();
                    } else {
                        closeModal();
                    }
                }
            });
        });

        // Handle broken images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    if (this.classList.contains('product-image-original')) {
                        this.src = 'https://via.placeholder.com/800x600/7cb342/ffffff?text=Waluya+Land';
                    } else {
                        this.src = 'https://via.placeholder.com/800x600/f8f9fa/333333?text=Image+Not+Found';
                    }
                });
            });
        });

        // Check if there's a success message from server-side validation
        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                showSuccessModal('{{ session('success') }}');
            }, 500);
        });
        @endif

        @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                showErrorModal('{{ $errors->first() }}');
            }, 500);
        });
        @endif

        // Press ESC to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeTestimonialModal();
                closeSendConfirmModal();
            }
        });

        // VISITOR TRACKING
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/track-visitor')
                .then(response => response.json())
                .then(data => {
                    console.log('Visitor tracked successfully');
                })
                .catch(error => {
                    console.log('Visitor tracking failed:', error);
                });
        });
    </script>
</body>
</html>
