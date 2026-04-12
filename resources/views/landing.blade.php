<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waluya Land - Belajar Kewirausahaan</title>
    <style>
        /* SEMUA CSS SAMA SEPERTI SEBELUMNYA - TIDAK BERUBAH */
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
            height: 100%;
            object-fit: cover;
        }

        .feature-image-original {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        img,
        video {
            max-width: 100%;
            height: auto;
            display: block;
        }

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

        .morph-btn {
            position: relative;
            padding: 18px 48px;
            font-family: "Segoe UI", system-ui, sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #ffffff;
            background: transparent;
            border: none;
            cursor: pointer;
            overflow: visible;
            isolation: isolate;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .morph-btn .btn-fill {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border-radius: 4px;
            transition: border-radius 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1;
        }

        .morph-btn:hover .btn-fill {
            border-radius: 50px;
            animation: jelly 0.5s ease;
        }

        @keyframes jelly {
            0% { transform: scale(1, 1); }
            30% { transform: scale(1.15, 0.85); }
            50% { transform: scale(0.9, 1.1); }
            70% { transform: scale(1.05, 0.95); }
            100% { transform: scale(1, 1); }
        }

        .morph-btn .orbit-dots {
            position: absolute;
            inset: -25px;
            pointer-events: none;
        }

        .morph-btn .orbit-dots span {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #f39c12;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .morph-btn:hover .orbit-dots span {
            opacity: 1;
        }

        .morph-btn .orbit-dots span:nth-child(1) {
            top: 0;
            left: 50%;
            animation: orbit1 3s linear infinite;
        }

        .morph-btn .orbit-dots span:nth-child(2) {
            bottom: 0;
            left: 50%;
            animation: orbit2 3s linear infinite;
        }

        .morph-btn .orbit-dots span:nth-child(3) {
            top: 50%;
            left: 0;
            animation: orbit3 4s linear infinite;
        }

        .morph-btn .orbit-dots span:nth-child(4) {
            top: 50%;
            right: 0;
            animation: orbit4 4s linear infinite;
        }

        @keyframes orbit1 {
            0% { transform: translateX(-50%) translateY(0) scale(1); }
            25% { transform: translateX(25px) translateY(8px) scale(0.6); }
            50% { transform: translateX(-50%) translateY(15px) scale(1); }
            75% { transform: translateX(-65px) translateY(8px) scale(0.6); }
            100% { transform: translateX(-50%) translateY(0) scale(1); }
        }

        @keyframes orbit2 {
            0% { transform: translateX(-50%) translateY(0) scale(0.6); }
            25% { transform: translateX(-65px) translateY(-8px) scale(1); }
            50% { transform: translateX(-50%) translateY(-15px) scale(0.6); }
            75% { transform: translateX(25px) translateY(-8px) scale(1); }
            100% { transform: translateX(-50%) translateY(0) scale(0.6); }
        }

        @keyframes orbit3 {
            0% { transform: translateY(-50%) translateX(0) scale(0.8); }
            50% { transform: translateY(-50%) translateX(-12px) scale(1.2); }
            100% { transform: translateY(-50%) translateX(0) scale(0.8); }
        }

        @keyframes orbit4 {
            0% { transform: translateY(-50%) translateX(0) scale(1.2); }
            50% { transform: translateY(-50%) translateX(12px) scale(0.8); }
            100% { transform: translateY(-50%) translateX(0) scale(1.2); }
        }

        .morph-btn .btn-text {
            position: relative;
            display: inline-block;
            z-index: 3;
            white-space: nowrap;
        }

        .morph-btn .btn-text span {
            display: inline-block;
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transition-delay: calc(var(--i) * 0.03s);
        }

        .morph-btn:hover .btn-text span {
            transform: translateY(-100%);
            animation: letterBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            animation-delay: calc(var(--i) * 0.03s);
        }

        @keyframes letterBounce {
            0% { transform: translateY(0); }
            40% { transform: translateY(-120%); }
            70% { transform: translateY(10%); }
            100% { transform: translateY(0); }
        }

        .morph-btn .corners span {
            position: absolute;
            width: 15px;
            height: 15px;
            border: 2px solid #f39c12;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            opacity: 0;
        }

        .morph-btn:hover .corners span {
            opacity: 1;
        }

        .morph-btn .corners span:nth-child(1) {
            top: -8px;
            left: -8px;
            border-right: none;
            border-bottom: none;
        }

        .morph-btn .corners span:nth-child(2) {
            top: -8px;
            right: -8px;
            border-left: none;
            border-bottom: none;
        }

        .morph-btn .corners span:nth-child(3) {
            bottom: -8px;
            left: -8px;
            border-right: none;
            border-top: none;
        }

        .morph-btn .corners span:nth-child(4) {
            bottom: -8px;
            right: -8px;
            border-left: none;
            border-top: none;
        }

        .morph-btn:hover .corners span:nth-child(1) {
            transform: translate(-4px, -4px) rotate(-5deg);
        }

        .morph-btn:hover .corners span:nth-child(2) {
            transform: translate(4px, -4px) rotate(5deg);
        }

        .morph-btn:hover .corners span:nth-child(3) {
            transform: translate(-4px, 4px) rotate(5deg);
        }

        .morph-btn:hover .corners span:nth-child(4) {
            transform: translate(4px, 4px) rotate(-5deg);
        }

        .morph-btn .shadow {
            position: absolute;
            inset: 5px;
            background: rgba(243, 156, 18, 0.3);
            border-radius: 4px;
            filter: blur(12px);
            z-index: 0;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform: translateY(8px);
        }

        .morph-btn:hover .shadow {
            border-radius: 50px;
            transform: translateY(12px) scale(1.1);
            filter: blur(15px);
        }

        .morph-btn:active .btn-fill {
            transform: scale(0.92);
            transition: transform 0.1s ease;
        }

        .morph-btn:active .shadow {
            transform: translateY(3px) scale(0.85);
            filter: blur(8px);
            opacity: 0.5;
            transition: all 0.1s ease;
        }

        .morph-btn:active .btn-text {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }

        .morph-btn:active .corners span:nth-child(1) {
            transform: translate(-12px, -12px) rotate(-15deg) scale(0.8);
        }

        .morph-btn:active .corners span:nth-child(2) {
            transform: translate(12px, -12px) rotate(15deg) scale(0.8);
        }

        .morph-btn:active .corners span:nth-child(3) {
            transform: translate(-12px, 12px) rotate(15deg) scale(0.8);
        }

        .morph-btn:active .corners span:nth-child(4) {
            transform: translate(12px, 12px) rotate(-15deg) scale(0.8);
        }

        .morph-btn:active .orbit-dots span {
            animation-play-state: paused;
            transform: scale(1.5);
        }

        .morph-btn-sm {
            padding: 14px 32px !important;
            font-size: 14px !important;
            letter-spacing: 1px !important;
        }

        .morph-btn-sm .btn-fill {
            background: linear-gradient(135deg, #7cb342 0%, #689f38 100%) !important;
        }

        .morph-btn-sm .orbit-dots span {
            background: #7cb342 !important;
        }

        .morph-btn-sm .corners span {
            border-color: #7cb342 !important;
        }

        .morph-btn-sm .shadow {
            background: rgba(124, 179, 66, 0.3) !important;
        }

        @media (max-width: 768px) {
            .morph-btn {
                padding: 16px 36px;
                font-size: 14px;
                letter-spacing: 1px;
            }
            .morph-btn-sm {
                padding: 12px 28px !important;
                font-size: 13px !important;
            }
            .morph-btn .orbit-dots {
                inset: -20px;
            }
            .morph-btn .orbit-dots span {
                width: 5px;
                height: 5px;
            }
            .morph-btn .corners span {
                width: 12px;
                height: 12px;
            }
        }

        @media (max-width: 480px) {
            .morph-btn {
                padding: 14px 28px;
                font-size: 13px;
            }
            .morph-btn-sm {
                padding: 10px 24px !important;
                font-size: 12px !important;
            }
        }

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

        .story-content p {
            color: #666;
            line-height: 1.8;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

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

        .why-learn-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .why-learn-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
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
            align-items: start;
        }

        .feature-media-box {
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 600px;
        }

        .feature-text-box {
            padding: 0;
            background: transparent;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 650px;
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

        @media (min-width: 768px) {
            .feature-row {
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
                align-items: start;
            }
            .feature-row:nth-child(even) .feature-media-box {
                order: 2;
            }
            .feature-row:nth-child(even) .feature-text-box {
                order: 1;
            }
        }

        @media (max-width: 767px) {
            .features-zigzag {
                gap: 2rem;
            }
            .feature-row {
                gap: 1.5rem;
            }
            .feature-media-box {
                height: 400px;
            }
            .feature-text-box {
                height: auto;
                padding: 1rem 0;
                min-height: auto;
            }
            .feature-text-box h3 {
                font-size: 1.4rem;
                margin-bottom: 0.8rem;
            }
            .feature-text-box p {
                font-size: 1rem;
                line-height: 1.6;
            }
        }

        @media (max-width: 480px) {
            .feature-media-box {
                height: 350px;
            }
            .feature-text-box {
                padding: 0.5rem 0;
            }
            .feature-text-box h3 {
                font-size: 1.3rem;
                margin-bottom: 0.8rem;
            }
            .feature-text-box p {
                font-size: 0.95rem;
                line-height: 1.6;
            }
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-template-rows: repeat(6, 1fr);
            gap: 8px;
            margin-top: 2rem;
            width: 100%;
            height: 900px;
        }

        @media (min-width: 768px) {
            .grid {
                height: 80vh;
                max-height: 800px;
            }
        }

        @media (max-width: 767px) {
            .grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: repeat(3, 200px);
                gap: 10px;
                height: auto;
            }
            .item-0 {
                grid-column: 1 / span 2;
                grid-row: 1 / span 1;
                height: 250px;
            }
            .item-1, .item-2, .item-3, .item-4, .item-5 {
                grid-column: auto;
                grid-row: auto;
                height: 180px;
            }
            .item-1 { grid-area: 2 / 1 / span 1 / span 1; }
            .item-2 { grid-area: 2 / 2 / span 1 / span 1; }
            .item-3 { grid-area: 3 / 1 / span 1 / span 1; }
            .item-4 { grid-area: 3 / 2 / span 1 / span 1; }
            .item-5 { grid-area: 4 / 1 / span 1 / span 2; }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(6, 200px);
            }
            .item-0, .item-1, .item-2, .item-3, .item-4, .item-5 {
                grid-column: 1 / span 1;
                grid-row: auto;
                height: 200px;
            }
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

        .testimonial-carousel-container {
            position: relative;
            overflow: hidden;
            margin: 2rem 0;
            min-height: 500px;
        }

        .testimonial-carousel {
            width: 100%;
            position: relative;
        }

        .carousel-slide {
            width: 100%;
            opacity: 0;
            transition: opacity 0.8s ease;
            display: none;
            position: absolute;
            top: 0;
            left: 0;
        }

        .carousel-slide.active {
            opacity: 1;
            display: block;
            position: relative;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(124, 179, 66, 0.9);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .carousel-btn:hover {
            background: rgba(124, 179, 66, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-btn.prev-btn {
            left: 10px;
        }

        .carousel-btn.next-btn {
            right: 10px;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: #7cb342;
            transform: scale(1.2);
        }

        .testimonial-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin: 0.75rem 0;
            flex-wrap: wrap;
        }

        .testimonial-rating .stars {
            display: inline-flex;
            gap: 0.15rem;
        }

        .testimonial-rating .star-filled {
            color: #ffc107;
            font-size: 1rem;
        }

        .testimonial-rating .star-empty {
            color: #ddd;
            font-size: 1rem;
        }

        .testimonial-rating .rating-number {
            color: #666;
            font-size: 0.8rem;
            margin-left: 0.5rem;
            font-weight: 500;
        }

        .testimonial-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
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
            margin-bottom: 1rem;
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

        .no-testimonials {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        /* CSS untuk Rating Count Badge */
        .rating-count-badge {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 0.2rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 0.25rem;
        }

        .filter-rating-btn.active .rating-count-badge {
            background: rgba(255, 255, 255, 0.3);
        }

        .forum-carousel-container {
            position: relative;
            overflow: hidden;
            margin: 2rem 0;
            min-height: 600px;
        }

        .forum-carousel {
            width: 100%;
            position: relative;
        }

        .forum-slide {
            width: 100%;
            opacity: 0;
            transition: opacity 0.8s ease;
            display: none;
            position: absolute;
            top: 0;
            left: 0;
        }

        .forum-slide.active {
            opacity: 1;
            display: block;
            position: relative;
        }

        .forum-carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(243, 156, 18, 0.9);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .forum-carousel-btn:hover {
            background: rgba(243, 156, 18, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .forum-carousel-btn.prev-btn {
            left: 10px;
        }

        .forum-carousel-btn.next-btn {
            right: 10px;
        }

        .forum-carousel-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
        }

        .forum-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .forum-dot.active {
            background: #f39c12;
            transform: scale(1.2);
        }

        .forum-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .forum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .forum-card {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .forum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 0.3rem;
        }

        .forum-institution {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }

        .forum-date {
            color: #999;
            font-size: 0.75rem;
        }

        .forum-message {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            line-height: 1.6;
            color: #555;
            margin: 1rem 0;
            font-style: italic;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .replies-section {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .replies-title {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .reply-item {
            background: #f8f9fa;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            border-left: 3px solid #7cb342;
        }

        .reply-item.hidden-reply {
            display: none;
        }

        .reply-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.3rem;
        }

        .reply-avatar {
            width: 25px;
            height: 25px;
            background: #7cb342;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: white;
            font-weight: bold;
            flex-shrink: 0;
        }

        .reply-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #333;
        }

        .reply-message {
            font-size: 0.85rem;
            color: #555;
            margin: 0.5rem 0;
            line-height: 1.5;
        }

        .reply-date {
            color: #999;
            font-size: 0.75rem;
        }

        .show-all-replies-btn {
            background: none;
            border: none;
            color: #7cb342;
            cursor: pointer;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .show-all-replies-btn:hover {
            color: #689f38;
            text-decoration: underline;
        }

        .reply-form {
            margin-top: 1rem;
        }

        .reply-toggle-btn {
            background: none;
            border: none;
            color: #7cb342;
            cursor: pointer;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0;
            transition: color 0.3s;
        }

        .reply-toggle-btn:hover {
            color: #689f38;
        }

        .reply-form-container {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .reply-form-container.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reply-form-input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
        }

        .reply-form-input:focus {
            outline: none;
            border-color: #7cb342;
        }

        .reply-form-textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
            resize: vertical;
            min-height: 80px;
        }

        .reply-form-textarea:focus {
            outline: none;
            border-color: #7cb342;
        }

        .reply-form-actions {
            display: flex;
            gap: 0.5rem;
        }

        .reply-submit-btn {
            background: #7cb342;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: background 0.3s;
        }

        .reply-submit-btn:hover {
            background: #689f38;
        }

        .reply-cancel-btn {
            background: #ccc;
            color: #333;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: background 0.3s;
        }

        .reply-cancel-btn:hover {
            background: #bbb;
        }

        .no-replies {
            text-align: center;
            padding: 1rem;
            color: #999;
            font-size: 0.85rem;
            font-style: italic;
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

        .faq-contact-form input:focus,
        .faq-contact-form textarea:focus {
            outline: none;
            border-color: #7cb342;
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

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.show {
            display: flex;
        }

        .testimonial-premium-modal {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 28px;
            max-width: 520px;
            width: 90%;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideUp 0.5s cubic-bezier(0.34, 1.2, 0.64, 1);
            overflow: hidden;
            position: relative;
        }

        .testimonial-premium-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #f39c12, #7cb342, #f39c12);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -100% 0; }
            100% { background-position: 100% 0; }
        }

        .testimonial-premium-header {
            padding: 1.8rem 2rem 1rem 2rem;
            text-align: center;
            position: relative;
        }

        .testimonial-premium-header .modal-icon-star {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            animation: starPulse 0.8s ease;
        }

        @keyframes starPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .testimonial-premium-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.3rem;
        }

        .testimonial-premium-header p {
            color: #888;
            font-size: 0.85rem;
        }

        .close-testimonial-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.05);
            border: none;
            font-size: 1.5rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #999;
            transition: all 0.3s;
        }

        .close-testimonial-btn:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
            transform: rotate(90deg);
        }

        .testimonial-premium-body {
            padding: 0.5rem 2rem 2rem 2rem;
        }

        .rating-container {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .rating-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
        }

        .stars-wrapper {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-direction: row-reverse;
        }

        .star-rating-input {
            display: none;
        }

        .star-rating-label {
            font-size: 2.2rem;
            color: #ddd;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .star-rating-label:hover,
        .star-rating-label:hover ~ .star-rating-label,
        .star-rating-input:checked ~ .star-rating-label {
            color: #ffc107;
            text-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }

        .stars-wrapper:hover .star-rating-label {
            color: #ffc107;
        }

        .stars-wrapper .star-rating-label:hover {
            transform: scale(1.1);
        }

        .rating-value-display {
            text-align: center;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #999;
        }

        .premium-input-group {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .premium-input-group input,
        .premium-input-group textarea {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #f0f0f0;
            border-radius: 16px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: white;
        }

        .premium-input-group textarea {
            resize: vertical;
            min-height: 100px;
            padding-left: 3rem;
        }

        .premium-input-group input:focus,
        .premium-input-group textarea:focus {
            outline: none;
            border-color: #7cb342;
            box-shadow: 0 0 0 3px rgba(124, 179, 66, 0.1);
        }

        .premium-input-group .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #bbb;
            pointer-events: none;
        }

        .premium-input-group textarea ~ .input-icon {
            top: 1.2rem;
            transform: none;
        }

        .premium-submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .premium-submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .premium-submit-btn:hover::before {
            left: 100%;
        }

        .premium-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
        }

        .success-premium-modal {
            background: linear-gradient(135deg, #ffffff 0%, #f0fff4 100%);
            border-radius: 28px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            padding: 2rem;
            animation: modalSlideUp 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .success-premium-modal::before {
            content: '✓';
            position: absolute;
            top: -30px;
            right: -30px;
            font-size: 120px;
            opacity: 0.05;
            font-weight: bold;
        }

        .success-icon-premium {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #7cb342, #689f38);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: successPop 0.5s cubic-bezier(0.34, 1.2, 0.64, 1);
        }

        .success-icon-premium span {
            font-size: 3rem;
            color: white;
        }

        @keyframes successPop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-premium-modal h3 {
            font-size: 1.6rem;
            color: #7cb342;
            margin-bottom: 0.5rem;
        }

        .success-premium-modal p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .success-premium-modal .premium-submit-btn {
            background: linear-gradient(135deg, #7cb342, #689f38);
            width: auto;
            padding: 0.8rem 2rem;
            display: inline-block;
        }

        .error-premium-modal {
            background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
            border-radius: 28px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            padding: 2rem;
            animation: modalSlideUp 0.4s ease;
        }

        .error-icon-premium {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a5a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: errorShake 0.5s ease;
        }

        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .error-icon-premium span {
            font-size: 3rem;
            color: white;
        }

        .error-premium-modal h3 {
            font-size: 1.6rem;
            color: #ff6b6b;
            margin-bottom: 0.5rem;
        }

        .error-premium-modal p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .comments-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 99999;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
            padding: 1rem;
        }

        .comments-modal-overlay.show {
            display: flex;
        }

        .comments-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            animation: modalSlideUp 0.4s ease;
        }

        .comments-modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .comments-modal-header h3 {
            font-size: 1.1rem;
            color: #333;
            margin: 0;
            flex: 1;
            text-align: center;
        }

        .close-modal-btn {
            background: none;
            border: none;
            font-size: 1.8rem;
            color: #666;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .close-modal-btn:hover {
            background: #f5f5f5;
            color: #333;
        }

        .comments-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: #fafafa;
        }

        .modal-original-post {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #f39c12;
        }

        .modal-comment-item {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 3px solid #7cb342;
        }

        .modal-comment-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
        }

        .modal-comment-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #7cb342 0%, #689f38 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
            color: white;
            flex-shrink: 0;
        }

        .modal-comment-info {
            flex: 1;
        }

        .modal-comment-name {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .modal-comment-date {
            color: #999;
            font-size: 0.75rem;
            margin-top: 0.2rem;
        }

        .modal-comment-message {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.5;
            padding-left: 0.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 1024px) {
            .hero, .story-grid, .why-learn-grid {
                grid-template-columns: 1fr;
            }
            .stats {
                grid-template-columns: repeat(2, 1fr);
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
                padding: 2rem 3% 4rem !important;
                gap: 2rem;
            }
            .hero h1 {
                font-size: 1.8rem !important;
            }
            .stats, .pricing-grid, .skills-grid {
                grid-template-columns: 1fr;
                padding: 2rem 3%;
            }
            .story-section, .why-learn-section, .faq-contact-section, .forum-section, .pricing-section, .testimonial-section {
                padding: 2rem 3%;
            }
            .faq-contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .testimonial-grid, .forum-grid {
                grid-template-columns: 1fr;
            }
            .carousel-btn, .forum-carousel-btn {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            .section-title {
                font-size: 1.8rem !important;
            }
        }

        @media (min-width: 768px) {
            .grid {
                gap: 16px;
                height: 80vh;
                max-height: 800px;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 1.5rem !important;
            }
            .stats {
                gap: 1rem;
            }
            .stat-card {
                padding: 1rem;
            }
            .grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(6, 200px);
            }
            .item-0, .item-1, .item-2, .item-3, .item-4, .item-5 {
                grid-column: 1 / span 1;
                grid-row: auto;
                height: 200px;
            }
            .carousel-btn, .forum-carousel-btn {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            <p>Sebuah permainan papan inovatif yang mengubah konsep bisnis yang kompleks menjadi pengalaman belajar yang menarik, interaktif bagi siswa dan profesional.</p>
            <button class="morph-btn" onclick="window.location.href='#pricing'">
                <span class="btn-fill"></span>
                <span class="shadow"></span>
                <span class="btn-text">
                    <span style="--i:0">D</span><span style="--i:1">a</span><span style="--i:2">p</span><span style="--i:3">a</span><span style="--i:4">t</span><span style="--i:5">k</span><span style="--i:6">a</span><span style="--i:7">n</span>
                    <span style="--i:8"> </span><span style="--i:9">S</span><span style="--i:10">e</span><span style="--i:11">k</span><span style="--i:12">a</span><span style="--i:13">r</span><span style="--i:14">a</span><span style="--i:15">n</span><span style="--i:16">g</span>
                </span>
                <span class="orbit-dots"><span></span><span></span><span></span><span></span></span>
                <span class="corners"><span></span><span></span><span></span><span></span></span>
            </button>
        </div>
        <div class="hero-image">
            <div class="board-placeholder">
                @if($heroMedia)
                    @if($heroMedia->isVideo())
                        <video controls autoplay muted loop class="hero-image-original">
                            <source src="{{ $heroMedia->getMediaUrl() }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ $heroMedia->getMediaUrl() }}" alt="{{ $heroMedia->title }}" class="hero-image-original" onerror="this.src='https://via.placeholder.com/800x600/7cb342/ffffff?text={{ urlencode($heroMedia->title) }}'">
                    @endif
                @else
                    <img src="https://via.placeholder.com/800x600/7cb342/ffffff?text=Waluya+Land+Board+Game" alt="Waluya Land Board Game" class="hero-image-original">
                @endif
            </div>
        </div>
    </section>

    <section id="home" class="stats">
        <div class="stat-card"><h3>85%</h3><p>Kepuasan user sejauh ini saat bermain</p></div>
        <div class="stat-card"><h3>50+</h3><p>Sekolah dan siswa yang sudah menekankannya</p></div>
        <div class="stat-card"><h3>80%</h3><p>Membantu mereka dari pengalaman baru</p></div>
        <div class="stat-card"><h3>87%</h3><p>Meningkatkan pemahaman pembelajaran</p></div>
    </section>

    <section class="story-section">
        <div class="story-grid">
            <div class="story-image">
                @if($storyMedia)
                    <img src="{{ $storyMedia->getMediaUrl() }}" alt="{{ $storyMedia->title }}" class="image-original" onerror="this.src='https://via.placeholder.com/350x350/f8f9fa/333333?text={{ urlencode($storyMedia->title) }}'">
                @else
                    <img src="https://via.placeholder.com/350x350/f8f9fa/333333?text=Story+Image" alt="Story" class="image-original">
                @endif
            </div>
            <div class="story-content">
                <span class="story-badge">Background</span>
                <h2>Cerita di Balik GameBoard</h2>
                <p>Terlatir dari ide para tenaga pendidikan didalam kewirausahaan dalam kehidupan untuk memulai pendidikan kewirausahaan ini lebih menarik, interaktif dan praktis sebagai alat pembelajaran melalui permainan papan kami menyajikan kesempatan antara teori pelajaran dan implementasi di lapangan</p>
            </div>
        </div>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon">💡</div><h3>Problem Solving</h3><p>Dapat membantu siswa menyebarkan kebutuhan untuk pembelajaran interaktif dalam pendidikan bisnis.</p></div>
            <div class="feature-card"><div class="feature-icon">👥</div><h3>Kolaborasi</h3><p>Mendorong kerja tim antar industri secara efektif</p></div>
            <div class="feature-card"><div class="feature-icon">🎯</div><h3>Pengalaman Praktis</h3><p>Dorong para mengambil proyek kewirausahaan dalam membuat konsep bisnis yang kompleks menjadi mudah dipahami dan menyenangkan bagi semua peserta didik</p></div>
        </div>
    </section>

    <section class="why-learn-section">
        <div class="why-learn-grid">
            <div class="why-learn-media">
                @if($whyLearnMedia)
                    <img src="{{ $whyLearnMedia->getMediaUrl() }}" alt="{{ $whyLearnMedia->title }}" class="image-original" onerror="this.src='https://via.placeholder.com/600x400/f8f9fa/333333?text={{ urlencode($whyLearnMedia->title) }}'">
                @else
                    <img src="https://via.placeholder.com/600x400/f8f9fa/333333?text=Belajar+Kewirausahaan" alt="Belajar Kewirausahaan" class="image-original">
                @endif
            </div>
            <div class="why-learn-content">
                <h2>Mengapa Belajar Kewirausahaan Melalui Permainan Papan?</h2>
                <div class="why-learn-item"><strong>① Pengalaman Belajar Interaktif dan Praktis</strong><p>Melatih pengambilan keputusan dan presentasi bisnis dengan feedback langsung</p></div>
                <div class="why-learn-item"><strong>② Real-Case Skenario</strong><p>Hadapi tantangan berdasarkan situasi bisnis nyata</p></div>
                <div class="why-learn-item"><strong>③ Belajar Kolaboratif</strong><p>Kembangkan strategi dan komunikasi sambil bersinergi dan bekerja sama dengan orang lain</p></div>
            </div>
        </div>
    </section>

    <section style="padding: 2rem 0; background: #f8f9fa;">
        <h2 class="section-title">Keterampilan yang Akan Anda Dapatkan</h2>
        <p class="section-subtitle">Main keterampilan kewirausahaan yang sukses melalui permainan yang menarik</p>
        <div class="skills-grid">
            <div class="skill-card"><div class="feature-icon">🔧</div><h3>Problem Solving</h3><p>Mengidentifikasi masalah dan mencari solusi kreatif dalam berbagai situasi bisnis</p></div>
            <div class="skill-card"><div class="feature-icon">🎓</div><h3>Kerjasama</h3><p>Belajar untuk bekerja berbasis skuid untuk mencoba kerjasama interaktif</p></div>
            <div class="skill-card"><div class="feature-icon">📊</div><h3>Pengambilan Keputusan</h3><p>Berlatih membuat keputusan keseluruhan yang mempengaruhi layanan</p></div>
            <div class="skill-card"><div class="feature-icon">✨</div><h3>Inovasi</h3><p>Dorong aktivitas membuat ide strategi pemasaran yang efektif</p></div>
        </div>
    </section>

    <section id="features" style="padding:4rem 5%; background:#f8f9fa;">
        <span class="story-badge">Features</span>
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="features-zigzag">
            @if($featuresMedia && $featuresMedia->count() > 0)
                @foreach($featuresMedia as $item)
                    <div class="feature-row">
                        <div class="feature-media-box">
                            @if($item->isVideo())
                                <video controls class="feature-image-original"><source src="{{ $item->getMediaUrl() }}" type="video/mp4"></video>
                            @else
                                <img src="{{ $item->getMediaUrl() }}" alt="{{ $item->title }}" class="feature-image-original" onerror="this.src='https://via.placeholder.com/600x400/f8f9fa/333333?text={{ urlencode($item->title) }}'">
                            @endif
                        </div>
                        <div class="feature-text-box">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->description ?? 'Fitur menarik untuk pembelajaran kewirausahaan' }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div style="text-align: center; margin-top: 3rem;">
            <button class="morph-btn" onclick="window.location.href='#pricing'">
                <span class="btn-fill"></span><span class="shadow"></span>
                <span class="btn-text"><span style="--i:0">D</span><span style="--i:1">a</span><span style="--i:2">p</span><span style="--i:3">a</span><span style="--i:4">t</span><span style="--i:5">k</span><span style="--i:6">a</span><span style="--i:7">n</span> <span style="--i:8"> </span><span style="--i:9">S</span><span style="--i:10">e</span><span style="--i:11">k</span><span style="--i:12">a</span><span style="--i:13">r</span><span style="--i:14">a</span><span style="--i:15">n</span><span style="--i:16">g</span></span>
                <span class="orbit-dots"><span></span><span></span><span></span><span></span></span>
                <span class="corners"><span></span><span></span><span></span><span></span></span>
            </button>
        </div>
    </section>

    <section id="aktivitas" style="padding:4rem 5%;background:#f8f9fa;">
        <h2 class="section-title">Aktivitas Terbaru & Tutorial</h2>
        <p class="section-subtitle">Kumpulan aktivitas bermain GameBoard & bagaimana kita menggunakannya</p>
        <div class="grid">
            @if($aktivitasMedia && $aktivitasMedia->count() > 0)
                @foreach($aktivitasMedia as $index => $item)
                    <div class="item item-{{ $index }}">
                        @if($item->isVideo())
                            <video controls class="grid-image-original"><source src="{{ $item->getMediaUrl() }}" type="video/mp4"></video>
                        @else
                            <img src="{{ $item->getMediaUrl() }}" alt="{{ $item->title }}" class="grid-image-original" onerror="this.src='https://via.placeholder.com/400x300/f8f9fa/333333?text={{ urlencode($item->title) }}'">
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <section id="pricing" class="pricing-section">
        <span class="pricing-badge">Product</span>
        <h2 class="section-title">Main Sekaligus Belajar, Semua Dimulai dari Sini!</h2>
        <p class="section-subtitle">Tingkatkan pemahaman kewirausahaan lewat board game yang seru dan interaktif</p>
        <div class="pricing-grid">
            @if($productsMedia && $productsMedia->count() > 0)
                @foreach($productsMedia as $index => $product)
                    <div class="pricing-card {{ $index == 0 ? 'product-basic' : 'product-premium' }}">
                        <div class="product-image-container">
                            @if($product->isImage())
                                <img src="{{ $product->getMediaUrl() }}" alt="{{ $product->title }}" class="product-image-original" onerror="this.src='https://via.placeholder.com/600x400/{{ $index == 0 ? '7cb342' : 'f7e92b' }}/{{ $index == 0 ? 'ffffff' : '333333' }}?text={{ urlencode($product->title) }}'">
                            @else
                                <div style="width:100%;height:200px;display:flex;align-items:center;justify-content:center;"><div style="text-align:center;"><div style="font-size:3rem;margin-bottom:0.5rem;">{{ $index == 0 ? '🎲' : '⭐' }}</div><p>{{ $product->title }}</p></div></div>
                            @endif
                        </div>
                        <h3>{{ $product->title }}</h3>
                        <div class="price">{{ $product->formatted_price }}</div>
                        <ul>
                            @if($product->description && strpos($product->description, "\n") !== false)
                                @php $features = explode("\n", $product->description); foreach($features as $feature) { if(trim($feature)) echo '<li>' . trim($feature) . '</li>'; } @endphp
                            @endif
                        </ul>
                        <button class="morph-btn morph-btn-sm" onclick="window.open('https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->title) }}%20(Rp%20{{ number_format($product->price, 0, ',', '.') }})', '_blank')">
                            <span class="btn-fill"></span><span class="shadow"></span>
                            <span class="btn-text"><span style="--i:0">D</span><span style="--i:1">a</span><span style="--i:2">p</span><span style="--i:3">a</span><span style="--i:4">t</span><span style="--i:5">k</span><span style="--i:6">a</span><span style="--i:7">n</span>@if($index > 0)<span style="--i:8"> </span><span style="--i:9">S</span><span style="--i:10">e</span><span style="--i:11">k</span><span style="--i:12">a</span><span style="--i:13">r</span><span style="--i:14">a</span><span style="--i:15">n</span><span style="--i:16">g</span>@endif</span>
                            <span class="orbit-dots"><span></span><span></span><span></span><span></span></span>
                            <span class="corners"><span></span><span></span><span></span><span></span></span>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <section id="testimonial" class="testimonial-section">
        <span class="story-badge">Testimoni</span>
        <h2 class="section-title">Apa yang Dikatakan Para Pemain</h2>
        <p class="section-subtitle">Feedback dan manfaat dari siswa</p>

        <div style="text-align: center; margin-bottom: 2rem;">
            <button onclick="showPremiumTestimonialForm()" class="morph-btn morph-btn-sm">
                <span class="btn-fill" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;"></span>
                <span class="shadow" style="background: rgba(243, 156, 18, 0.3) !important;"></span>
                <span class="btn-text">
                    <span style="--i:0">⭐</span><span style="--i:1"> </span><span style="--i:2">B</span><span style="--i:3">e</span><span style="--i:4">r</span><span style="--i:5">i</span><span style="--i:6">k</span><span style="--i:7">a</span><span style="--i:8">n</span>
                    <span style="--i:9"> </span><span style="--i:10">T</span><span style="--i:11">e</span><span style="--i:12">s</span><span style="--i:13">t</span><span style="--i:14">i</span><span style="--i:15">m</span><span style="--i:16">o</span><span style="--i:17">n</span><span style="--i:18">i</span>
                </span>
                <span class="orbit-dots"><span></span><span></span><span></span><span></span></span>
                <span class="corners"><span></span><span></span><span></span><span></span></span>
            </button>
        </div>

        {{-- FILTER RATING DENGAN JUMLAH USER --}}
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem;">
                <button type="button" data-rating="all" class="filter-rating-btn {{ !request()->has('rating') || request()->rating == 'all' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ !request()->has('rating') || request()->rating == 'all' ? '#7cb342' : '#f0f0f0' }}; color: {{ !request()->has('rating') || request()->rating == 'all' ? 'white' : '#333' }};">
                    <span>⭐</span> Semua <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts['all'] ?? 0 }}</span>
                </button>
                <button type="button" data-rating="5" class="filter-rating-btn {{ request()->rating == '5' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ request()->rating == '5' ? '#ffc107' : '#f0f0f0' }}; color: #333;">
                    <span>⭐⭐⭐⭐⭐</span> 5 <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts[5] ?? 0 }}</span>
                </button>
                <button type="button" data-rating="4" class="filter-rating-btn {{ request()->rating == '4' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ request()->rating == '4' ? '#81c784' : '#f0f0f0' }}; color: #333;">
                    <span>⭐⭐⭐⭐☆</span> 4 <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts[4] ?? 0 }}</span>
                </button>
                <button type="button" data-rating="3" class="filter-rating-btn {{ request()->rating == '3' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ request()->rating == '3' ? '#64b5f6' : '#f0f0f0' }}; color: #333;">
                    <span>⭐⭐⭐☆☆</span> 3 <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts[3] ?? 0 }}</span>
                </button>
                <button type="button" data-rating="2" class="filter-rating-btn {{ request()->rating == '2' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ request()->rating == '2' ? '#ffb74d' : '#f0f0f0' }}; color: #333;">
                    <span>⭐⭐☆☆☆</span> 2 <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts[2] ?? 0 }}</span>
                </button>
                <button type="button" data-rating="1" class="filter-rating-btn {{ request()->rating == '1' ? 'active' : '' }}"
                    style="padding: 0.6rem 1.2rem; border-radius: 30px; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; background: {{ request()->rating == '1' ? '#ef9a9a' : '#f0f0f0' }}; color: #333;">
                    <span>⭐☆☆☆☆</span> 1 <span class="rating-count-badge" style="background: rgba(0,0,0,0.1); border-radius: 20px; padding: 0.2rem 0.6rem; font-size: 0.75rem;">{{ $ratingCounts[1] ?? 0 }}</span>
                </button>
            </div>
        </div>

        <div id="testimonial-loading" style="display: none; text-align: center; padding: 2rem;">
            <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #7cb342; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <p style="margin-top: 1rem;">Memuat data...</p>
        </div>

        <div class="testimonial-carousel-container" id="testimonialCarouselContainer">
            <div class="testimonial-carousel" id="testimonialCarousel">
                @if(isset($testimonials) && $testimonials->count() > 0)
                    @php
                        $itemsPerSlide = 5;
                        $totalItems = $testimonials->count();
                        $totalSlides = ceil($totalItems / $itemsPerSlide);
                    @endphp
                    @for($slide = 0; $slide < $totalSlides; $slide++)
                        <div class="carousel-slide @if($slide === 0) active @endif" data-slide="{{ $slide }}">
                            <div class="testimonial-grid">
                                @foreach($testimonials->slice($slide * $itemsPerSlide, $itemsPerSlide) as $testimonial)
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
                                                <!--<div class="testimonial-institution">{{ $testimonial->institution ?? 'Pengguna' }}</div>-->
                                                <div class="testimonial-date">{{ $testimonial->created_at->translatedFormat('d F Y') }}</div>
                                            </div>
                                        </div>
                                        @if($testimonial->rating)
                                            <div class="testimonial-rating">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $testimonial->rating)
                                                            <span class="star-filled">★</span>
                                                        @else
                                                            <span class="star-empty">★</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="rating-number">{{ $testimonial->rating }}/5</span>
                                            </div>
                                        @else
                                            <div class="testimonial-rating">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="star-empty">★</span>
                                                    @endfor
                                                </div>
                                                <span class="rating-number">Belum dinilai</span>
                                            </div>
                                        @endif
                                        <p class="testimonial-message">"{{ $testimonial->message }}"</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
                @else
                    <div class="carousel-slide active">
                        <div class="no-testimonials">
                            <h3>Belum ada testimoni</h3>
                            <p>Jadilah yang pertama memberikan testimoni tentang pengalaman Anda!</p>
                        </div>
                    </div>
                @endif
            </div>
            @if(isset($testimonials) && $testimonials->count() > 5)
                <button class="carousel-btn prev-btn" onclick="prevTestimonialSlide()"><span>‹</span></button>
                <button class="carousel-btn next-btn" onclick="nextTestimonialSlide()"><span>›</span></button>
                <div class="carousel-dots" id="testimonialDots">
                    @for($i = 0; $i < $totalSlides; $i++)
                        <span class="dot @if($i === 0) active @endif" onclick="goToTestimonialSlide({{ $i }})"></span>
                    @endfor
                </div>
            @endif
        </div>
    </section>

    <section id="contact" class="faq-contact-section">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-contact-grid">
            <div class="faq-contact-form">
                <p style="margin-bottom: 1.5rem; color: #666;">Punya pertanyaan lain? silahkan cantumkan disini!</p>
                <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                    @csrf
                    <input type="hidden" name="type" value="forum">
                    <input type="hidden" name="email" id="autoGeneratedEmail">
                    <input type="text" name="name" id="contactName" placeholder="Nama Lengkap *" required>
                    <input type="email" name="user_email" id="userEmail" placeholder="Alamat Email *" required>
                    <input type="tel" name="phone" id="userPhone" placeholder="Nomor HP / WhatsApp *" required pattern="[0-9]{10,13}" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <input type="text" name="institution" id="contactInstitution" placeholder="Instansi (opsional)">
                    <textarea name="message" id="contactMessage" placeholder="Pesan/Pertanyaan *" required></textarea>
                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
            </div>
            <div class="faq-accordion">
                <div class="faq-item" onclick="toggleFaq(this)"><strong>Berlaku untuk siapa saja waluya land ini?</strong><div class="faq-answer">Waluya Land dirancang untuk siswa SMA/SMK, mahasiswa, dan siapa saja yang ingin belajar kewirausahaan dengan cara yang menyenangkan dan interaktif.</div></div>
                <div class="faq-item" onclick="toggleFaq(this)"><strong>Adakah panduan bermain bagi kami?</strong><div class="faq-answer">Ya, setiap paket Waluya Land dilengkapi dengan buku panduan lengkap yang menjelaskan aturan permainan dan cara bermain.</div></div>
                <div class="faq-item" onclick="toggleFaq(this)"><strong>Capaian pelajaran apa yang terpenuhi oleh Waluya Land?</strong><div class="faq-answer">Waluya Land membantu mencapai kompetensi pemahaman kewirausahaan, problem solving, kerja tim, dan pengambilan keputusan bisnis.</div></div>
                <div class="faq-item" onclick="toggleFaq(this)"><strong>Apa waluya land ini?</strong><div class="faq-answer">Waluya Land adalah board game edukatif yang mengajarkan konsep kewirausahaan dan bisnis melalui permainan interaktif.</div></div>
                <div class="faq-item" onclick="toggleFaq(this)"><strong>Apakah berlaku untuk semua kejuruan?</strong><div class="faq-answer">Ya, Waluya Land dirancang fleksibel dan dapat disesuaikan dengan berbagai kurikulum pendidikan dan kejuruan.</div></div>
            </div>
        </div>
    </section>

    <section class="forum-section">
        <span class="story-badge">Forum</span>
        <h2 class="section-title">Forum Terbuka untuk Tanya, Saran, dan Insight</h2>
        <p class="section-subtitle">Punya ide, saran, atau pertanyaan untuk kami? ajukan pertanyaan langsung pada tim kami</p>
        <div class="forum-carousel-container">
            <div class="forum-carousel" id="forumCarousel">
                @if(isset($forumPosts) && $forumPosts->count() > 0)
                    @php
                        $forumItemsPerSlide = 5;
                        $forumTotalItems = $forumPosts->count();
                        $forumTotalSlides = ceil($forumTotalItems / $forumItemsPerSlide);
                    @endphp
                    @for($slide = 0; $slide < $forumTotalSlides; $slide++)
                        <div class="forum-slide @if($slide === 0) active @endif" data-slide="{{ $slide }}">
                            <div class="forum-grid">
                                @foreach($forumPosts->slice($slide * $forumItemsPerSlide, $forumItemsPerSlide) as $post)
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
                                                <div class="forum-institution">{{ $post->institution ?? 'Pengguna' }}</div>
                                                <div class="forum-date">{{ $post->created_at->translatedFormat('d F Y, H:i') }}</div>
                                            </div>
                                        </div>
                                        <p class="forum-message">"{{ $post->message }}"</p>
                                        @if($post->replies->count() > 0)
                                            <div class="replies-section" id="repliesSection{{ $post->id }}">
                                                <h5 class="replies-title"><span>💬</span> {{ $post->replies->count() }} Balasan</h5>
                                                @foreach($post->replies as $index => $reply)
                                                    <div class="reply-item {{ $index >= 1 ? 'hidden-reply' : '' }}">
                                                        <div class="reply-header">
                                                            <div class="reply-avatar">
                                                                @php
                                                                    $replyNames = explode(' ', $reply->name);
                                                                    $replyInitials = '';
                                                                    foreach($replyNames as $n) {
                                                                        if(!empty(trim($n))) {
                                                                            $replyInitials .= strtoupper(substr(trim($n), 0, 1));
                                                                        }
                                                                    }
                                                                    echo substr($replyInitials, 0, 2) ?: 'GU';
                                                                @endphp
                                                            </div>
                                                            <span class="reply-name">{{ $reply->name }}</span>
                                                        </div>
                                                        <p class="reply-message">{{ $reply->message }}</p>
                                                        <div class="reply-date">{{ $reply->created_at->diffForHumans() }}</div>
                                                    </div>
                                                @endforeach
                                                @if($post->replies->count() > 0)
                                                    <button class="show-all-replies-btn" onclick="openCommentsModal({{ $post->id }})"><i>💬</i> Lihat {{ $post->replies->count() }} Balasan</button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="no-replies">Belum ada balasan. Jadilah yang pertama membalas!</div>
                                        @endif
                                        <div class="reply-form">
                                            <button class="reply-toggle-btn" onclick="toggleReplyForm({{ $post->id }})"><span>💬</span> Balas</button>
                                            <div class="reply-form-container" id="replyForm{{ $post->id }}">
                                                <form onsubmit="submitReply(event, {{ $post->id }})">
                                                    @csrf
                                                    <input type="hidden" name="contact_id" value="{{ $post->id }}">
                                                    <input type="hidden" name="email" id="replyEmail{{ $post->id }}" value="guest@waluyaland.com">
                                                    <div><input type="text" name="name" placeholder="Nama Anda *" required class="reply-form-input" id="replyName{{ $post->id }}"></div>
                                                    <div><textarea name="message" placeholder="Tulis balasan Anda... *" required rows="3" class="reply-form-textarea" id="replyMessage{{ $post->id }}"></textarea></div>
                                                    <div class="reply-form-actions">
                                                        <button type="submit" class="reply-submit-btn">Kirim Balasan</button>
                                                        <button type="button" onclick="toggleReplyForm({{ $post->id }})" class="reply-cancel-btn">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
                @else
                    <div class="forum-slide active">
                        <div class="forum-card">
                            <div class="forum-header"><div class="forum-avatar">WL</div><div><h4>Waluya Land Team</h4><div class="forum-institution">Admin</div><div class="forum-date">{{ now()->translatedFormat('d F Y, H:i') }}</div></div></div>
                            <p class="forum-message">"Selamat datang di forum Waluya Land! Silakan ajukan pertanyaan atau saran Anda di sini."</p>
                            <div class="no-replies">Belum ada balasan. Jadilah yang pertama membalas!</div>
                            <div class="reply-form"><button class="reply-toggle-btn" onclick="showPremiumTestimonialForm()"><span>💬</span> Balas</button></div>
                        </div>
                    </div>
                @endif
            </div>
            @if(isset($forumPosts) && $forumPosts->count() > 5)
                <button class="forum-carousel-btn prev-btn" onclick="prevForumSlide()"><span>‹</span></button>
                <button class="forum-carousel-btn next-btn" onclick="nextForumSlide()"><span>›</span></button>
                <div class="forum-carousel-dots" id="forumDots">
                    @for($i = 0; $i < $forumTotalSlides; $i++)
                        <span class="forum-dot @if($i === 0) active @endif" onclick="goToForumSlide({{ $i }})"></span>
                    @endfor
                </div>
            @endif
        </div>
        <div class="forum-cta">
            <h3>Siap untuk mengubah pengalaman belajar Anda?</h3>
            <p>Bergabunglah dengan ribuan siswa dan pendidik yang sudah menggunakan Waluya Land</p>
            <button class="morph-btn" onclick="window.open('https://wa.me/628986908167?text=Halo%20saya%20tertarik%20dengan%20produk%20Waluya%20Land!', '_blank')">
                <span class="btn-fill"></span><span class="shadow"></span>
                <span class="btn-text"><span style="--i:0">D</span><span style="--i:1">a</span><span style="--i:2">p</span><span style="--i:3">a</span><span style="--i:4">t</span><span style="--i:5">k</span><span style="--i:6">a</span><span style="--i:7">n</span> <span style="--i:8"> </span><span style="--i:9">S</span><span style="--i:10">e</span><span style="--i:11">k</span><span style="--i:12">a</span><span style="--i:13">r</span><span style="--i:14">a</span><span style="--i:15">n</span><span style="--i:16">g</span></span>
                <span class="orbit-dots"><span></span><span></span><span></span><span></span></span>
                <span class="corners"><span></span><span></span><span></span><span></span></span>
            </button>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div><h4>📚 Waluya Land</h4><p>Making entrepreneurship education engaging and accessible through innovative board games</p></div>
            <div><h4>Product</h4><a href="#features">Features</a><a href="#pricing">Pricing</a></div>
            <div><h4>Support</h4><a href="#contact">Contact Us</a><a href="#testimonial">Testimonials</a></div>
            <div><h4>Dapatkan di e-commerce</h4><div style="display: flex; gap: 1rem; margin-top: 0.5rem;"><a href="https://shopee.co.id" target="_blank"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/shopee.svg" alt="Shopee" style="height: 35px; filter: invert(38%) sepia(86%) saturate(2798%) hue-rotate(354deg) brightness(96%) contrast(93%);"></a><a href="https://www.tokopedia.com" target="_blank"><img src="https://cdn.brandfetch.io/idoruRsDhk/theme/dark/symbol.svg?c=1dxbfHSJFAPEGdCLU4o5B" alt="Tokopedia" style="height: 35px;"></a></div></div>
        </div>
        <div class="footer-bottom"><p>© 2025 Waluya Land. All rights reserved.</p></div>
    </footer>

    <div class="comments-modal-overlay" id="commentsModal"><div class="comments-modal"><div class="comments-modal-header"><button class="close-modal-btn" onclick="closeCommentsModal()">×</button><h3>Semua Balasan</h3></div><div class="comments-modal-body" id="commentsModalBody"></div></div></div>
    <div class="modal-overlay" id="testimonialModal"><div class="testimonial-premium-modal"><div class="testimonial-premium-header"><div class="modal-icon-star">⭐</div><h2>Bagikan Pengalamanmu</h2><p>Ceritakan kesanmu menggunakan Waluya Land</p><button class="close-testimonial-btn" onclick="closePremiumTestimonialModal()">×</button></div><div class="testimonial-premium-body"><form action="{{ route('contact.store') }}" method="POST" id="premiumTestimonialForm">@csrf<input type="hidden" name="type" value="testimonial"><div class="rating-container"><span class="rating-label">Berikan Penilaian Anda</span><div class="stars-wrapper"><input type="radio" name="rating" value="5" id="star5" class="star-rating-input" required><label for="star5" class="star-rating-label" title="Sangat Baik">★</label><input type="radio" name="rating" value="4" id="star4" class="star-rating-input"><label for="star4" class="star-rating-label" title="Baik">★</label><input type="radio" name="rating" value="3" id="star3" class="star-rating-input"><label for="star3" class="star-rating-label" title="Cukup">★</label><input type="radio" name="rating" value="2" id="star2" class="star-rating-input"><label for="star2" class="star-rating-label" title="Kurang">★</label><input type="radio" name="rating" value="1" id="star1" class="star-rating-input"><label for="star1" class="star-rating-label" title="Sangat Kurang">★</label></div><div class="rating-value-display" id="ratingValueDisplay">Klik bintang untuk memberi rating</div></div><div class="premium-input-group"><span class="input-icon">👤</span><input type="text" name="name" placeholder="Nama Lengkap *" required></div><div class="premium-input-group"><span class="input-icon">✉️</span><input type="email" name="email" placeholder="Alamat Email *" required></div><div class="premium-input-group"><span class="input-icon">💬</span><textarea name="message" placeholder="Ceritakan pengalaman Anda menggunakan Waluya Land... *" required></textarea></div><button type="submit" class="premium-submit-btn">✨ Kirim Testimoni ✨</button></form></div></div></div>
    <div class="modal-overlay" id="successModal"><div class="success-premium-modal"><div class="success-icon-premium"><span>✓</span></div><h3>Terima Kasih!</h3><p>Testimoni Anda telah berhasil dikirim. Kami sangat menghargai feedback dari Anda!</p><button class="premium-submit-btn" onclick="closeSuccessModal()">Mengerti</button></div></div>
    <div class="modal-overlay" id="errorModal"><div class="error-premium-modal"><div class="error-icon-premium"><span>✕</span></div><h3>Gagal Mengirim</h3><p id="errorMessage">Terjadi kesalahan. Silakan coba lagi.</p><button class="premium-submit-btn" onclick="closeErrorModal()">Coba Lagi</button></div></div>

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
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        });
    });

    function toggleFaq(element) { element.classList.toggle('active'); }

    let currentRequest = null;
    let testimonialSlides = [], testimonialIndex = 0, testimonialInterval;
    function initTestimonialCarousel() {
        testimonialSlides = document.querySelectorAll('.testimonial-carousel .carousel-slide');
        const testimonialDots = document.querySelectorAll('#testimonialDots .dot');
        if (testimonialSlides.length > 1) {
            testimonialSlides.forEach(slide => { slide.style.display = 'none'; });
            testimonialSlides[0].classList.add('active');
            testimonialSlides[0].style.display = 'block';
            window.nextTestimonialSlide = function() {
                testimonialSlides[testimonialIndex].classList.remove('active');
                testimonialSlides[testimonialIndex].style.display = 'none';
                testimonialIndex = (testimonialIndex + 1) % testimonialSlides.length;
                testimonialSlides[testimonialIndex].classList.add('active');
                testimonialSlides[testimonialIndex].style.display = 'block';
                testimonialDots.forEach((dot, i) => dot.classList.toggle('active', i === testimonialIndex));
            };
            window.prevTestimonialSlide = function() {
                testimonialSlides[testimonialIndex].classList.remove('active');
                testimonialSlides[testimonialIndex].style.display = 'none';
                testimonialIndex = (testimonialIndex - 1 + testimonialSlides.length) % testimonialSlides.length;
                testimonialSlides[testimonialIndex].classList.add('active');
                testimonialSlides[testimonialIndex].style.display = 'block';
                testimonialDots.forEach((dot, i) => dot.classList.toggle('active', i === testimonialIndex));
            };
            window.goToTestimonialSlide = function(slideIndex) {
                testimonialSlides[testimonialIndex].classList.remove('active');
                testimonialSlides[testimonialIndex].style.display = 'none';
                testimonialIndex = slideIndex;
                testimonialSlides[testimonialIndex].classList.add('active');
                testimonialSlides[testimonialIndex].style.display = 'block';
                testimonialDots.forEach((dot, i) => dot.classList.toggle('active', i === testimonialIndex));
            };
            testimonialInterval = setInterval(window.nextTestimonialSlide, 5000);
            const container = document.querySelector('.testimonial-carousel-container');
            if (container) {
                container.addEventListener('mouseenter', () => clearInterval(testimonialInterval));
                container.addEventListener('mouseleave', () => testimonialInterval = setInterval(window.nextTestimonialSlide, 5000));
            }
        }
    }

    let forumSlides = [], forumIndex = 0, forumInterval;
    function initForumCarousel() {
        forumSlides = document.querySelectorAll('.forum-carousel .forum-slide');
        const forumDots = document.querySelectorAll('#forumDots .forum-dot');
        if (forumSlides.length > 1) {
            forumSlides.forEach(slide => { slide.style.display = 'none'; });
            forumSlides[0].classList.add('active');
            forumSlides[0].style.display = 'block';
            window.nextForumSlide = function() {
                forumSlides[forumIndex].classList.remove('active');
                forumSlides[forumIndex].style.display = 'none';
                forumIndex = (forumIndex + 1) % forumSlides.length;
                forumSlides[forumIndex].classList.add('active');
                forumSlides[forumIndex].style.display = 'block';
                forumDots.forEach((dot, i) => dot.classList.toggle('active', i === forumIndex));
            };
            window.prevForumSlide = function() {
                forumSlides[forumIndex].classList.remove('active');
                forumSlides[forumIndex].style.display = 'none';
                forumIndex = (forumIndex - 1 + forumSlides.length) % forumSlides.length;
                forumSlides[forumIndex].classList.add('active');
                forumSlides[forumIndex].style.display = 'block';
                forumDots.forEach((dot, i) => dot.classList.toggle('active', i === forumIndex));
            };
            window.goToForumSlide = function(slideIndex) {
                forumSlides[forumIndex].classList.remove('active');
                forumSlides[forumIndex].style.display = 'none';
                forumIndex = slideIndex;
                forumSlides[forumIndex].classList.add('active');
                forumSlides[forumIndex].style.display = 'block';
                forumDots.forEach((dot, i) => dot.classList.toggle('active', i === forumIndex));
            };
            forumInterval = setInterval(window.nextForumSlide, 6000);
            const container = document.querySelector('.forum-carousel-container');
            if (container) {
                container.addEventListener('mouseenter', () => clearInterval(forumInterval));
                container.addEventListener('mouseleave', () => forumInterval = setInterval(window.nextForumSlide, 6000));
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initTestimonialCarousel();
        initForumCarousel();

        // ==================== FILTER RATING TESTIMONIAL ====================
        const filterButtons = document.querySelectorAll('.filter-rating-btn');
        const loadingIndicator = document.getElementById('testimonial-loading');
        const carouselContainer = document.getElementById('testimonialCarouselContainer');

        filterButtons.forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();

                const rating = this.getAttribute('data-rating');
                const currentUrl = new URL(window.location.href);

                console.log('Filter clicked - Rating:', rating);

                // Reset semua tombol ke style default
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = '#f0f0f0';
                    btn.style.color = '#333';
                });

                // Set active style pada tombol yang diklik
                this.classList.add('active');

                if (rating === 'all') {
                    this.style.background = '#7cb342';
                    this.style.color = 'white';
                    currentUrl.searchParams.delete('rating');
                    console.log('Filter: Menampilkan SEMUA testimonial');
                } else {
                    // Warna berbeda untuk setiap rating
                    switch(rating) {
                        case '5':
                            this.style.background = '#ffc107';
                            break;
                        case '4':
                            this.style.background = '#81c784';
                            break;
                        case '3':
                            this.style.background = '#64b5f6';
                            break;
                        case '2':
                            this.style.background = '#ffb74d';
                            break;
                        case '1':
                            this.style.background = '#ef9a9a';
                            break;
                        default:
                            this.style.background = '#ffc107';
                    }
                    this.style.color = '#333';
                    currentUrl.searchParams.set('rating', rating);
                    console.log(`Filter: Menampilkan rating ${rating} ★`);
                }

                // Update URL tanpa reload
                window.history.replaceState({}, '', currentUrl);

                // Tampilkan loading indicator
                if (loadingIndicator) loadingIndicator.style.display = 'block';
                if (carouselContainer) carouselContainer.style.opacity = '0.5';

                // Abort request sebelumnya jika ada
                if (currentRequest) currentRequest.abort();

                try {
                    console.log('Fetching data from:', currentUrl.toString());

                    const response = await fetch(currentUrl.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        signal: AbortSignal.timeout(10000)
                    });

                    const data = await response.json();
                    console.log('Response received:', data);

                    // UPDATE JUMLAH RATING BADGE
                    if (data.ratingCounts) {
                        console.log('Updating rating counts:', data.ratingCounts);

                        const allBtn = document.querySelector('.filter-rating-btn[data-rating="all"]');
                        const btn5 = document.querySelector('.filter-rating-btn[data-rating="5"]');
                        const btn4 = document.querySelector('.filter-rating-btn[data-rating="4"]');
                        const btn3 = document.querySelector('.filter-rating-btn[data-rating="3"]');
                        const btn2 = document.querySelector('.filter-rating-btn[data-rating="2"]');
                        const btn1 = document.querySelector('.filter-rating-btn[data-rating="1"]');

                        if (allBtn) { const badge = allBtn.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts.all || 0; }
                        if (btn5) { const badge = btn5.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts[5] || 0; }
                        if (btn4) { const badge = btn4.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts[4] || 0; }
                        if (btn3) { const badge = btn3.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts[3] || 0; }
                        if (btn2) { const badge = btn2.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts[2] || 0; }
                        if (btn1) { const badge = btn1.querySelector('.rating-count-badge'); if (badge) badge.textContent = data.ratingCounts[1] || 0; }
                    }

                    if (data.success && data.html) {
                        console.log('Updating carousel with new data...');

                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;

                        const newCarousel = tempDiv.querySelector('.testimonial-carousel');
                        const newDots = tempDiv.querySelector('#testimonialDots');

                        if (newCarousel) {
                            const oldCarousel = document.getElementById('testimonialCarousel');
                            if (oldCarousel) {
                                oldCarousel.innerHTML = newCarousel.innerHTML;
                                initTestimonialCarousel();
                                console.log('Carousel updated successfully');
                            }
                        }

                        if (newDots && document.getElementById('testimonialDots')) {
                            document.getElementById('testimonialDots').innerHTML = newDots.innerHTML;
                            const dots = document.querySelectorAll('#testimonialDots .dot');
                            dots.forEach((dot, idx) => {
                                dot.addEventListener('click', () => goToTestimonialSlide(idx));
                            });
                            console.log('Dots updated successfully');
                        }
                    } else {
                        console.error('Invalid response format:', data);
                    }

                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Fetch error:', error);
                        showErrorModal('Gagal memuat data testimonial. Silakan coba lagi.');
                    }
                } finally {
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    if (carouselContainer) carouselContainer.style.opacity = '1';
                }
            });
        });

        const ratingInputs = document.querySelectorAll('.star-rating-input');
        const ratingDisplay = document.getElementById('ratingValueDisplay');
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                const ratingValue = this.value;
                const ratingText = { '5': 'Sangat Baik ⭐⭐⭐⭐⭐', '4': 'Baik ⭐⭐⭐⭐', '3': 'Cukup ⭐⭐⭐', '2': 'Kurang ⭐⭐', '1': 'Sangat Kurang ⭐' };
                ratingDisplay.textContent = ratingText[ratingValue] || `${ratingValue} Bintang`;
                ratingDisplay.style.color = '#7cb342';
                ratingDisplay.style.fontWeight = 'bold';
            });
        });
    });

    function toggleReplyForm(contactId) {
        const formContainer = document.getElementById(`replyForm${contactId}`);
        if (formContainer) {
            formContainer.classList.toggle('show');
            if (formContainer.classList.contains('show')) {
                setTimeout(() => formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
            }
        }
    }

    function submitReply(event, contactId) {
        event.preventDefault();
        const name = document.getElementById(`replyName${contactId}`).value.trim();
        const message = document.getElementById(`replyMessage${contactId}`).value.trim();
        if (!name) { showErrorModal('Harap isi Nama Lengkap'); return; }
        if (!message) { showErrorModal('Harap isi Pesan/Pertanyaan'); return; }
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');
        formData.append('contact_id', contactId);
        formData.append('name', name);
        formData.append('message', message);
        formData.append('email', 'guest@waluyaland.com');
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Mengirim...';
        submitBtn.disabled = true;
        fetch('{{ route("forum.reply.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                event.target.reset();
                const formContainer = document.getElementById(`replyForm${contactId}`);
                if (formContainer) formContainer.classList.remove('show');
                showSuccessModal('Balasan Anda berhasil dikirim!');
                location.reload();
            } else {
                showErrorModal(data.message || 'Gagal mengirim balasan.');
            }
        })
        .catch(error => { console.error('Error:', error); showErrorModal('Terjadi kesalahan. Silakan coba lagi.'); })
        .finally(() => { submitBtn.textContent = originalText; submitBtn.disabled = false; });
    }

    function openCommentsModal(contactId) {
        const modal = document.getElementById('commentsModal');
        const modalBody = document.getElementById('commentsModalBody');
        const postCard = document.querySelector(`#repliesSection${contactId}`)?.closest('.forum-card');
        if (!postCard) return;
        const postData = {
            name: postCard.querySelector('h4').textContent,
            institution: postCard.querySelector('.forum-institution')?.textContent || '',
            date: postCard.querySelector('.forum-date')?.textContent || '',
            message: postCard.querySelector('.forum-message')?.textContent || ''
        };
        const repliesSection = document.getElementById(`repliesSection${contactId}`);
        const replies = repliesSection ? repliesSection.querySelectorAll('.reply-item') : [];
        let modalContent = `<div class="modal-original-post"><div class="modal-comment-header"><div class="modal-comment-avatar">${getInitials(postData.name)}</div><div class="modal-comment-info"><div class="modal-comment-name">${postData.name}</div>${postData.institution ? `<div style="color:#666;font-size:0.8rem;">${postData.institution}</div>` : ''}<div class="modal-comment-date">${postData.date}</div></div></div><div class="modal-comment-message">${postData.message}</div></div><hr style="margin:1.5rem 0;border:none;border-top:1px solid #eee;">`;
        if (replies.length > 0) {
            replies.forEach(reply => {
                const name = reply.querySelector('.reply-name')?.textContent || 'Pengguna';
                const message = reply.querySelector('.reply-message')?.textContent || '';
                const date = reply.querySelector('.reply-date')?.textContent || '';
                modalContent += `<div class="modal-comment-item"><div class="modal-comment-header"><div class="modal-comment-avatar">${getInitials(name)}</div><div class="modal-comment-info"><div class="modal-comment-name">${name}</div><div class="modal-comment-date">${date}</div></div></div><div class="modal-comment-message">${message}</div></div>`;
            });
        } else {
            modalContent += `<div style="text-align:center;padding:3rem;color:#999;"><div style="font-size:3rem;margin-bottom:1rem;">💬</div><p>Belum ada balasan</p><p style="font-size:0.9rem;margin-top:1rem;">Jadilah yang pertama memberikan balasan!</p></div>`;
        }
        modalBody.innerHTML = modalContent;
        modal.classList.add('show');
        modalBody.scrollTop = 0;
        document.body.style.overflow = 'hidden';
    }

    function closeCommentsModal() {
        document.getElementById('commentsModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function getInitials(name) {
        const names = name.split(' ');
        let initials = '';
        names.forEach(n => { if (n.trim()) initials += n.trim().charAt(0).toUpperCase(); });
        return initials.substring(0, 2) || 'GU';
    }

    function showPremiumTestimonialForm() { document.getElementById('testimonialModal').classList.add('show'); document.body.style.overflow = 'hidden'; }
    function closePremiumTestimonialModal() { document.getElementById('testimonialModal').classList.remove('show'); document.body.style.overflow = 'auto'; }
    function showSuccessModal(message) { if (message) { const msg = document.querySelector('#successModal p'); if (msg) msg.textContent = message; } document.getElementById('successModal').classList.add('show'); document.body.style.overflow = 'hidden'; setTimeout(() => closeSuccessModal(), 3000); }
    function closeSuccessModal() { document.getElementById('successModal').classList.remove('show'); document.body.style.overflow = 'auto'; }
    function showErrorModal(message) { if (message) { const msg = document.getElementById('errorMessage'); if (msg) msg.textContent = message; } document.getElementById('errorModal').classList.add('show'); document.body.style.overflow = 'hidden'; }
    function closeErrorModal() { document.getElementById('errorModal').classList.remove('show'); document.body.style.overflow = 'auto'; }

    document.querySelectorAll('.modal-overlay, .comments-modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'testimonialModal') closePremiumTestimonialModal();
                else if (this.id === 'commentsModal') closeCommentsModal();
                else if (this.id === 'successModal') closeSuccessModal();
                else if (this.id === 'errorModal') closeErrorModal();
            }
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePremiumTestimonialModal(); closeCommentsModal(); closeSuccessModal(); closeErrorModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        const autoEmailField = document.getElementById('autoGeneratedEmail');
        const userEmailInput = document.getElementById('userEmail');
        const userPhoneInput = document.getElementById('userPhone');
        const contactNameInput = document.getElementById('contactName');
        const contactMessageInput = document.getElementById('contactMessage');
        if (contactForm && autoEmailField) {
            contactForm.addEventListener('submit', function(e) {
                document.querySelectorAll('.faq-contact-form .error-text').forEach(span => span.remove());
                document.querySelectorAll('.faq-contact-form input, .faq-contact-form textarea').forEach(input => input.style.borderColor = '#ddd');
                let isValid = true;
                if (!contactNameInput.value.trim()) { showFieldError(contactNameInput, 'Harap isi Nama Lengkap'); isValid = false; }
                const emailValue = userEmailInput.value.trim();
                if (!emailValue) { showFieldError(userEmailInput, 'Harap isi Alamat Email'); isValid = false; }
                else if (!/^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(emailValue)) { showFieldError(userEmailInput, 'Format email tidak valid'); isValid = false; }
                const phoneValue = userPhoneInput.value.trim();
                if (!phoneValue) { showFieldError(userPhoneInput, 'Harap isi Nomor HP/WhatsApp'); isValid = false; }
                else { const cleanPhone = phoneValue.replace(/\D/g, ''); if (cleanPhone.length < 10 || cleanPhone.length > 13) { showFieldError(userPhoneInput, 'Nomor HP harus 10-13 digit'); isValid = false; } else if (phoneValue !== cleanPhone) { showFieldError(userPhoneInput, 'Nomor HP hanya boleh berisi angka'); isValid = false; } }
                if (!contactMessageInput.value.trim()) { showFieldError(contactMessageInput, 'Harap isi Pesan/Pertanyaan'); isValid = false; }
                if (!isValid) { e.preventDefault(); return; }
                autoEmailField.value = emailValue;
                const submitBtn = contactForm.querySelector('.btn-submit');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = 'Mengirim...';
                submitBtn.disabled = true;
                setTimeout(() => { submitBtn.innerHTML = originalText; submitBtn.disabled = false; }, 3000);
            });
        }
    });

    function showFieldError(input, message) {
        input.style.borderColor = '#e74c3c';
        const errorSpan = document.createElement('span');
        errorSpan.className = 'error-text';
        errorSpan.textContent = message;
        errorSpan.style.cssText = 'display:block;margin-top:-0.5rem;margin-bottom:0.5rem;color:#e74c3c;font-size:0.8rem';
        input.parentNode.insertBefore(errorSpan, input.nextSibling);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                if (this.classList.contains('product-image-original')) this.src = 'https://via.placeholder.com/800x600/7cb342/ffffff?text=Waluya+Land';
                else this.src = 'https://via.placeholder.com/800x600/f8f9fa/333333?text=Image+Not+Found';
            });
        });
    });

    @if(session('success'))
    document.addEventListener('DOMContentLoaded', () => setTimeout(() => showSuccessModal('{{ session('success') }}'), 500));
    @endif
    @if($errors->any())
    document.addEventListener('DOMContentLoaded', () => setTimeout(() => showErrorModal('{{ $errors->first() }}'), 500));
    @endif

    document.addEventListener('DOMContentLoaded', () => { fetch('/track-visitor').catch(e => console.log('Visitor tracking failed:', e)); });
    </script>
</body>
</html>
