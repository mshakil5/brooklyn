@extends('frontend.layouts.master')

@section('content')

    <style>

        /* ============================================
        ABOUT HERO SECTION
        ============================================ */
        .about-hero {
            padding: 120px 0 80px;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 82, 255, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .about-hero::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 82, 255, 0.04) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .about-hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .about-tag {
            display: inline-block;
            background: rgba(0, 82, 255, 0.12);
            color: var(--blue);
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.78rem;
            padding: 6px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 18px;
        }

        .about-hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-white);
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .about-hero-desc {
            font-size: 1.02rem;
            color: var(--text-muted);
            line-height: 1.85;
            margin: 0;
        }

        /* ---- Stats Grid ---- */
        .about-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .about-stat-card {
            background: var(--dark-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            transition: all 0.35s ease;
        }

        .about-stat-card:hover {
            border-color: rgba(0, 82, 255, 0.25);
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        }

        .about-stat-icon {
            width: 56px;
            height: 56px;
            background: rgba(0, 82, 255, 0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            transition: all 0.35s ease;
        }

        .about-stat-icon i {
            font-size: 1.4rem;
            color: var(--blue);
            transition: all 0.35s ease;
        }

        .about-stat-card:hover .about-stat-icon {
            background: var(--blue);
        }

        .about-stat-card:hover .about-stat-icon i {
            color: #ffffff;
        }

        .about-stat-number {
            font-family: var(--font);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-white);
            line-height: 1.2;
            margin-bottom: 6px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.5s ease;
        }

        .about-stat-number.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .about-stat-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* ============================================
        OUR STORY SECTION
        ============================================ */
        .about-story {
            padding: 100px 0;
            background: #ffffff;
        }

        .story-content {
            padding-right: 40px;
        }

        .story-tag {
            display: inline-block;
            background: rgba(0, 82, 255, 0.1);
            color: var(--blue);
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.78rem;
            padding: 6px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 18px;
        }

        .story-title {
            font-size: 2.4rem;
            font-weight: 800;
            color: #111832;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 28px;
        }

        .story-text p {
            font-size: 0.95rem;
            color: #6b7280;
            line-height: 1.85;
            margin-bottom: 18px;
        }

        .story-text p:last-child {
            margin-bottom: 0;
        }

        /* Story Highlights */
        .story-highlights {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid #e8ecf4;
        }

        .story-highlight {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.92rem;
            font-weight: 500;
            color: #374151;
        }

        .story-highlight i {
            color: var(--blue);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* Story Image */
        .story-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .story-image img {
            width: 100%;
            height: 520px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .story-image:hover img {
            transform: scale(1.03);
        }

        /* BBB Badge */
        .story-badge {
            position: absolute;
            bottom: 24px;
            right: 24px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .story-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .story-badge > i {
            font-size: 2rem;
            color: var(--blue);
        }

        .badge-rating {
            display: block;
            font-family: var(--font);
            font-size: 1.6rem;
            font-weight: 800;
            color: #111832;
            line-height: 1.2;
        }

        .badge-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============================================
        ABOUT PAGE RESPONSIVE — TABLET
        ============================================ */
        @media (max-width: 991.98px) {
            .about-hero {
                padding: 100px 0 60px;
            }

            .about-hero-title {
                font-size: 2.4rem;
            }

            .about-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .about-stat-card {
                padding: 28px 20px;
            }

            .about-stat-number {
                font-size: 1.8rem;
            }

            .about-story {
                padding: 70px 0;
            }

            .story-content {
                padding-right: 0;
                margin-bottom: 50px;
                text-align: center;
            }

            .story-title {
                font-size: 2rem;
            }

            .story-highlights {
                align-items: center;
            }

            .story-image img {
                height: 400px;
            }
        }

        /* ============================================
        ABOUT PAGE RESPONSIVE — MOBILE
        ============================================ */
        @media (max-width: 767.98px) {
            .about-hero {
                padding: 80px 0 50px;
            }

            .about-hero-content {
                margin-bottom: 40px;
            }

            .about-hero-title {
                font-size: 1.8rem;
            }

            .about-hero-desc {
                font-size: 0.92rem;
            }

            .about-stats-grid {
                gap: 12px;
            }

            .about-stat-card {
                padding: 22px 16px;
                border-radius: 12px;
            }

            .about-stat-icon {
                width: 46px;
                height: 46px;
                border-radius: 12px;
                margin-bottom: 14px;
            }

            .about-stat-icon i {
                font-size: 1.2rem;
            }

            .about-stat-number {
                font-size: 1.5rem;
            }

            .about-stat-label {
                font-size: 0.72rem;
                letter-spacing: 0.5px;
            }

            .about-story {
                padding: 50px 0;
            }

            .story-title {
                font-size: 1.65rem;
            }

            .story-text p {
                font-size: 0.9rem;
                line-height: 1.8;
            }

            .story-highlight {
                font-size: 0.88rem;
            }

            .story-image {
                border-radius: 16px;
            }

            .story-image img {
                height: 320px;
            }

            .story-badge {
                bottom: 16px;
                right: 16px;
                padding: 12px 16px;
                border-radius: 12px;
                gap: 10px;
            }

            .story-badge > i {
                font-size: 1.6rem;
            }

            .badge-rating {
                font-size: 1.3rem;
            }

            .badge-label {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 575.98px) {
            .about-hero-title {
                font-size: 1.55rem;
            }

            .about-stat-number {
                font-size: 1.3rem;
            }

            .story-title {
                font-size: 1.4rem;
            }

            .story-image img {
                height: 260px;
            }

            .story-badge {
                bottom: 12px;
                right: 12px;
                padding: 10px 14px;
                border-radius: 10px;
                gap: 8px;
            }

            .story-badge > i {
                font-size: 1.3rem;
            }

            .badge-rating {
                font-size: 1.1rem;
            }

            .badge-label {
                font-size: 0.62rem;
            }
        }




        /* ============================================
        MILESTONES SECTION
        ============================================ */
        .milestones-section {
            padding: 100px 0;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
        }

        .milestones-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -80px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 82, 255, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .milestones-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -60px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(0, 82, 255, 0.04) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .milestones-header {
            margin-bottom: 70px;
            position: relative;
            z-index: 1;
        }

        .milestones-tag {
            display: inline-block;
            background: rgba(0, 82, 255, 0.12);
            color: var(--blue);
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.78rem;
            padding: 6px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 16px;
        }

        .milestones-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-white);
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .milestones-desc {
            font-size: 1.02rem;
            color: var(--text-muted);
            max-width: 580px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ============================================
        TIMELINE
        ============================================ */
        .timeline {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
            padding: 0;
        }

        /* Center Line */
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 100%;
            background: linear-gradient(
                to bottom,
                transparent 0%,
                rgba(0, 82, 255, 0.3) 5%,
                rgba(0, 82, 255, 0.3) 95%,
                transparent 100%
            );
            border-radius: 3px;
        }

        /* Timeline Item */
        .timeline-item {
            position: relative;
            width: 50%;
            padding: 0 40px 50px;
        }

        .timeline-item.left {
            left: 0;
            text-align: right;
            padding-right: 50px;
            padding-left: 0;
        }

        .timeline-item.right {
            left: 50%;
            text-align: left;
            padding-left: 50px;
            padding-right: 0;
        }

        /* Timeline Dot */
        .timeline-dot {
            position: absolute;
            top: 8px;
            width: 20px;
            height: 20px;
            background: var(--dark-card);
            border: 3px solid var(--blue);
            border-radius: 50%;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .timeline-item.left .timeline-dot {
            right: -10px;
        }

        .timeline-item.right .timeline-dot {
            left: -10px;
        }

        .timeline-item:hover .timeline-dot {
            background: var(--blue);
            box-shadow: 0 0 0 6px rgba(0, 82, 255, 0.2);
            transform: scale(1.15);
        }

        /* Timeline Card */
        .timeline-card {
            background: var(--dark-card);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 28px 26px;
            transition: all 0.35s ease;
            position: relative;
        }

        .timeline-item:hover .timeline-card {
            border-color: rgba(0, 82, 255, 0.25);
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        }

        /* Arrow pointing to center line */
        .timeline-item.left .timeline-card::after {
            content: '';
            position: absolute;
            top: 12px;
            right: -8px;
            width: 14px;
            height: 14px;
            background: var(--dark-card);
            border-right: 1px solid var(--border-dark);
            border-top: 1px solid var(--border-dark);
            transform: rotate(45deg);
            transition: border-color 0.35s ease;
        }

        .timeline-item.right .timeline-card::after {
            content: '';
            position: absolute;
            top: 12px;
            left: -8px;
            width: 14px;
            height: 14px;
            background: var(--dark-card);
            border-left: 1px solid var(--border-dark);
            border-bottom: 1px solid var(--border-dark);
            transform: rotate(45deg);
            transition: border-color 0.35s ease;
        }

        .timeline-item.left:hover .timeline-card::after {
            border-color: rgba(0, 82, 255, 0.25);
        }

        .timeline-item.right:hover .timeline-card::after {
            border-color: rgba(0, 82, 255, 0.25);
        }

        /* Year Badge */
        .timeline-year {
            display: inline-block;
            background: var(--blue);
            color: #ffffff;
            font-family: var(--font);
            font-weight: 700;
            font-size: 0.82rem;
            padding: 5px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .timeline-card h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 10px;
            line-height: 1.35;
        }

        .timeline-card p {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.75;
            margin: 0;
        }

        /* ============================================
        MILESTONES RESPONSIVE — TABLET
        ============================================ */
        @media (max-width: 991.98px) {
            .milestones-title {
                font-size: 2rem;
            }

            .milestones-header {
                margin-bottom: 50px;
            }

            .timeline::before {
                left: 30px;
            }

            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 0;
                text-align: left;
            }

            .timeline-item.left {
                left: 0;
                text-align: left;
                padding-right: 0;
                padding-left: 70px;
            }

            .timeline-item.right {
                left: 0;
                text-align: left;
                padding-left: 70px;
                padding-right: 0;
            }

            .timeline-item.left .timeline-dot,
            .timeline-item.right .timeline-dot {
                left: 21px;
                right: auto;
            }

            /* Hide arrows on tablet */
            .timeline-item.left .timeline-card::after,
            .timeline-item.right .timeline-card::after {
                display: none;
            }
        }

        /* ============================================
        MILESTONES RESPONSIVE — MOBILE
        ============================================ */
        @media (max-width: 767.98px) {
            .milestones-section {
                padding: 70px 0;
            }

            .milestones-header {
                margin-bottom: 40px;
            }

            .milestones-title {
                font-size: 1.65rem;
            }

            .milestones-desc {
                font-size: 0.92rem;
            }

            .timeline::before {
                left: 20px;
            }

            .timeline-item {
                padding-bottom: 36px;
                padding-left: 56px;
            }

            .timeline-item.left {
                padding-left: 56px;
            }

            .timeline-item.right {
                padding-left: 56px;
            }

            .timeline-item.left .timeline-dot,
            .timeline-item.right .timeline-dot {
                left: 11px;
                width: 18px;
                height: 18px;
            }

            .timeline-card {
                padding: 22px 20px;
                border-radius: 12px;
            }

            .timeline-year {
                font-size: 0.75rem;
                padding: 4px 12px;
            }

            .timeline-card h4 {
                font-size: 1rem;
            }

            .timeline-card p {
                font-size: 0.84rem;
                line-height: 1.7;
            }
        }

        @media (max-width: 575.98px) {
            .milestones-title {
                font-size: 1.4rem;
            }

            .timeline-item {
                padding-left: 48px;
                padding-bottom: 28px;
            }

            .timeline-item.left {
                padding-left: 48px;
            }

            .timeline-item.right {
                padding-left: 48px;
            }

            .timeline-item.left .timeline-dot,
            .timeline-item.right .timeline-dot {
                left: 7px;
                width: 16px;
                height: 16px;
                border-width: 2px;
            }

            .timeline-card {
                padding: 18px 16px;
            }

            .timeline-year {
                font-size: 0.7rem;
                padding: 3px 10px;
            }

            .timeline-card h4 {
                font-size: 0.92rem;
                margin-bottom: 8px;
            }

            .timeline-card p {
                font-size: 0.8rem;
            }
        }


        /* ============================================
        CORE VALUES SECTION
        ============================================ */
        .values-section {
            padding: 100px 0;
            background: #f5f7fb;
        }

        .values-header {
            margin-bottom: 55px;
        }

        .values-tag {
            display: inline-block;
            background: rgba(0, 82, 255, 0.1);
            color: var(--blue);
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.78rem;
            padding: 6px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 16px;
        }

        .values-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #111832;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .values-desc {
            font-size: 1.02rem;
            color: #6b7280;
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Value Cards */
        .value-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 36px 28px 32px;
            height: 100%;
            text-align: center;
            border: 1px solid #e8ecf4;
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--blue);
            transform: scaleX(0);
            transition: transform 0.35s ease;
        }

        .value-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 40px rgba(0, 82, 255, 0.1);
            border-color: rgba(0, 82, 255, 0.15);
        }

        .value-card:hover::before {
            transform: scaleX(1);
        }

        .value-icon {
            width: 72px;
            height: 72px;
            background: rgba(0, 82, 255, 0.08);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            transition: all 0.35s ease;
        }

        .value-icon i {
            font-size: 1.7rem;
            color: var(--blue);
            transition: all 0.35s ease;
        }

        .value-card:hover .value-icon {
            background: var(--blue);
            transform: scale(1.05);
        }

        .value-card:hover .value-icon i {
            color: #ffffff;
        }

        .value-card h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #111832;
            margin-bottom: 14px;
        }

        .value-card p {
            font-size: 0.9rem;
            color: #6b7280;
            line-height: 1.75;
            margin: 0;
        }

        /* ============================================
        LICENSED & CERTIFIED SECTION
        ============================================ */
        .certs-section {
            padding: 100px 0;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
        }

        .certs-section::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -80px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(0, 82, 255, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .certs-header {
            margin-bottom: 55px;
            position: relative;
            z-index: 1;
        }

        .certs-tag {
            display: inline-block;
            background: rgba(0, 82, 255, 0.12);
            color: var(--blue);
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.78rem;
            padding: 6px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 16px;
        }

        .certs-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-white);
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .certs-desc {
            font-size: 1.02rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Certification Cards */
        .cert-card {
            background: var(--dark-card);
            border: 1px solid var(--border-dark);
            border-radius: 18px;
            padding: 36px 30px 32px;
            height: 100%;
            text-align: center;
            transition: all 0.35s ease;
            position: relative;
            z-index: 1;
        }

        .cert-card:hover {
            border-color: rgba(0, 82, 255, 0.25);
            transform: translateY(-6px);
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.35);
        }

        .cert-card-icon {
            width: 72px;
            height: 72px;
            background: rgba(0, 82, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            transition: all 0.35s ease;
        }

        .cert-card-icon i {
            font-size: 1.8rem;
            color: var(--blue);
            transition: all 0.35s ease;
        }

        .cert-card:hover .cert-card-icon {
            background: var(--blue);
            transform: scale(1.08);
        }

        .cert-card:hover .cert-card-icon i {
            color: #ffffff;
        }

        .cert-card h4 {
            font-size: 1.12rem;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 16px;
            line-height: 1.35;
        }

        /* License Info */
        .cert-license {
            background: rgba(0, 82, 255, 0.06);
            border: 1px solid rgba(0, 82, 255, 0.1);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .license-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .license-number {
            font-family: var(--font);
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--blue);
            letter-spacing: 0.5px;
        }

        .license-number.approved {
            font-size: 0.85rem;
        }

        .cert-card p {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.75;
            margin-bottom: 20px;
        }

        /* Cert Status */
        .cert-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.15);
            border-radius: 50px;
            padding: 8px 18px;
        }

        .cert-status i {
            color: #22c55e;
            font-size: 0.9rem;
        }

        .cert-status span {
            font-size: 0.78rem;
            font-weight: 600;
            color: #22c55e;
        }

        /* ============================================
        VALUES & CERTS RESPONSIVE — TABLET
        ============================================ */
        @media (max-width: 991.98px) {
            .values-title {
                font-size: 2rem;
            }

            .certs-title {
                font-size: 2rem;
            }

            .values-header {
                margin-bottom: 40px;
            }

            .certs-header {
                margin-bottom: 40px;
            }

            .value-card {
                padding: 30px 24px 26px;
            }

            .value-icon {
                width: 64px;
                height: 64px;
                border-radius: 16px;
            }

            .value-icon i {
                font-size: 1.5rem;
            }

            .cert-card {
                padding: 30px 26px 28px;
            }

            .cert-card-icon {
                width: 64px;
                height: 64px;
            }

            .cert-card-icon i {
                font-size: 1.6rem;
            }
        }

        /* ============================================
        VALUES & CERTS RESPONSIVE — MOBILE
        ============================================ */
        @media (max-width: 767.98px) {
            .values-section {
                padding: 70px 0;
            }

            .certs-section {
                padding: 70px 0;
            }

            .values-header {
                margin-bottom: 35px;
            }

            .certs-header {
                margin-bottom: 35px;
            }

            .values-title {
                font-size: 1.65rem;
            }

            .certs-title {
                font-size: 1.65rem;
            }

            .values-desc,
            .certs-desc {
                font-size: 0.92rem;
            }

            .value-card {
                padding: 26px 20px 22px;
                border-radius: 14px;
            }

            .value-icon {
                width: 58px;
                height: 58px;
                border-radius: 14px;
                margin-bottom: 18px;
            }

            .value-icon i {
                font-size: 1.35rem;
            }

            .value-card h4 {
                font-size: 1.05rem;
                margin-bottom: 12px;
            }

            .value-card p {
                font-size: 0.86rem;
            }

            .cert-card {
                padding: 26px 22px 24px;
                border-radius: 14px;
            }

            .cert-card-icon {
                width: 58px;
                height: 58px;
                margin-bottom: 18px;
            }

            .cert-card-icon i {
                font-size: 1.4rem;
            }

            .cert-card h4 {
                font-size: 1.02rem;
                margin-bottom: 14px;
            }

            .cert-license {
                padding: 12px 14px;
                flex-direction: column;
                text-align: center;
                gap: 4px;
            }

            .license-number {
                font-size: 0.88rem;
            }

            .license-number.approved {
                font-size: 0.8rem;
            }

            .cert-card p {
                font-size: 0.84rem;
                margin-bottom: 16px;
            }

            .cert-status {
                padding: 7px 14px;
            }

            .cert-status span {
                font-size: 0.72rem;
            }
        }

        @media (max-width: 575.98px) {
            .values-title {
                font-size: 1.4rem;
            }

            .certs-title {
                font-size: 1.4rem;
            }

            .value-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
            }

            .value-icon i {
                font-size: 1.2rem;
            }

            .value-card h4 {
                font-size: 0.98rem;
            }

            .cert-card-icon {
                width: 50px;
                height: 50px;
            }

            .cert-card-icon i {
                font-size: 1.25rem;
            }

            .cert-card h4 {
                font-size: 0.95rem;
            }
        }


    </style>

    <!-- ========== ABOUT HERO SECTION ========== -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-content text-center">
                <span class="about-tag">Our Story</span>
                <h1 class="about-hero-title">25+ Years Building<br><span class="text-blue">NYC's Sidewalks</span></h1>
                <p class="about-hero-desc">Since 1998, NYC Sidewalk Pros has been the trusted name in sidewalk and concrete services across all five boroughs. What started as a small Brooklyn operation has grown into the city's most respected sidewalk contractor.</p>
            </div>

            <!-- Stats Grid -->
            <div class="about-stats-grid">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="about-stat-number">5,000+</div>
                    <div class="about-stat-label">Projects Done</div>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="about-stat-number">25+</div>
                    <div class="about-stat-label">Years Experience</div>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="about-stat-number">5</div>
                    <div class="about-stat-label">NYC Boroughs</div>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-emoji-smile"></i>
                    </div>
                    <div class="about-stat-number">98%</div>
                    <div class="about-stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== OUR STORY SECTION ========== -->
    <section class="about-story">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="story-content">
                        <span class="story-tag">Our Journey</span>
                        <h2 class="story-title">From Brooklyn Roots to <span class="text-blue">All Five Boroughs</span></h2>
                        <div class="story-text">
                            <p>NYC Sidewalk Pros was founded in 1998 by a third-generation concrete worker who saw a need for reliable, honest sidewalk services in Brooklyn. What began as a one-man operation with a pickup truck and a dream has grown into New York City's most trusted sidewalk and concrete contractor.</p>
                            <p>In those early days, we focused on small residential repairs in neighborhoods like Flatbush, Crown Heights, and Bay Ridge. Word spread quickly about our quality workmanship and fair pricing. Property managers and building owners started calling, and before long, we were working across Brooklyn and into Manhattan.</p>
                            <p>Today, we serve all five boroughs — Manhattan, Brooklyn, Queens, The Bronx, and Staten Island. Our team has grown to over 50 skilled workers, and we've completed more than 5,000 projects ranging from simple sidewalk repairs to complex commercial installations.</p>
                            <p>Despite our growth, we've never lost sight of what made us successful: treating every property like it's our own, showing up on time, doing quality work, and standing behind everything we do. That's the NYC Sidewalk Pros promise.</p>
                        </div>
                        <div class="story-highlights">
                            <div class="story-highlight">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Family-owned & operated since 1998</span>
                            </div>
                            <div class="story-highlight">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>50+ skilled concrete professionals</span>
                            </div>
                            <div class="story-highlight">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>5,000+ successful projects completed</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Our construction team at work">
                        <div class="story-badge">
                            <i class="bi bi-award-fill"></i>
                            <div>
                                <span class="badge-rating">A+</span>
                                <span class="badge-label">BBB Accredited</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection