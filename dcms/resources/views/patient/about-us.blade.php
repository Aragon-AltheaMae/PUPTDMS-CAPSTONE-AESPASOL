@extends('layouts.patient')

@section('title', 'PUP Taguig Dental Clinic | Appointment')

@section('styles')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Hero banner */
        .about-hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 55%, #a31515 100%);
            border-radius: 24px;
            padding: 64px 48px;
            margin-bottom: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            min-height: 240px;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .about-hero-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }

        .about-hero-text {
            position: relative;
            z-index: 2;
        }

        .about-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 16px;
        }

        .about-hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 900;
            color: white;
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        .about-hero p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.75);
            max-width: 500px;
            line-height: 1.7;
        }

        .about-hero-badge {
            position: relative;
            z-index: 2;
            flex-shrink: 0;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .about-hero-badge i {
            font-size: 44px;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 640px) {
            .about-hero {
                padding: 36px 24px;
                flex-direction: column;
                align-items: flex-start;
                min-height: unset;
            }

            .about-hero-badge {
                display: none;
            }

            .about-hero h1 {
                font-size: 2rem;
            }
        }

        /* Mission strip */
        .mission-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 56px;
        }

        @media (max-width: 767px) {
            .mission-strip {
                grid-template-columns: 1fr;
            }
        }

        .mission-card {
            background: white;
            border: 1px solid #EDE0E0;
            border-radius: 20px;
            padding: 28px 24px;
            position: relative;
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .mission-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(139, 0, 0, 0.10);
        }

        .mission-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #8B0000, #FFD700);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s ease;
        }

        .mission-card:hover::after {
            transform: scaleX(1);
        }

        .mission-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #FDF1F1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .mission-icon i {
            font-size: 20px;
            color: #8B0000;
        }

        .mission-card h3 {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .mission-card p {
            font-size: 13px;
            color: #6B7280;
            line-height: 1.65;
        }

        [data-theme="dark"] .mission-card {
            background: #0d1b2a;
            border-color: #1e2d3d;
        }

        [data-theme="dark"] .mission-card h3 {
            color: #E5E7EB;
        }

        [data-theme="dark"] .mission-icon {
            background: #1a0a0a;
        }

        /* Dentist section */
        .dentist-section {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 48px;
            align-items: center;
            margin-bottom: 64px;
        }

        @media (max-width: 900px) {
            .dentist-section {
                grid-template-columns: 1fr;
            }
        }

        .dentist-profile-card {
            background: white;
            border: 1px solid #EDE0E0;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(139, 0, 0, 0.08);
        }

        .dentist-card-header {
            background: linear-gradient(135deg, #8B0000, #660000);
            padding: 32px 28px 24px;
            position: relative;
            overflow: hidden;
        }

        .dentist-card-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .dentist-card-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 215, 0, 0.08);
            border-radius: 50%;
        }

        .dentist-img-wrap {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .dentist-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dentist-name {
            font-size: 20px;
            font-weight: 800;
            color: white;
            position: relative;
            z-index: 1;
        }

        .dentist-title {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 3px;
            position: relative;
            z-index: 1;
        }

        .dentist-card-body {
            padding: 24px 28px;
        }

        .dentist-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FDF1F1;
            border: 1px solid #F0DADA;
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #8B0000;
            margin: 4px 4px 4px 0;
        }

        .dentist-text-side {}

        .dentist-text-side h2 {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 800;
            color: #8B0000;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .dentist-text-side p {
            font-size: 14.5px;
            color: #5A5A6A;
            line-height: 1.8;
            margin-bottom: 14px;
        }

        [data-theme="dark"] .dentist-profile-card {
            background: #0d1b2a;
            border-color: #1e2d3d;
        }

        [data-theme="dark"] .dentist-text-side p {
            color: #9CA3AF;
        }

        [data-theme="dark"] .dentist-tag {
            background: #1a0a0a;
            border-color: #2a1515;
        }

        [data-theme="dark"] .dentist-card-body {
            background: #0d1b2a;
        }

        /* Services grid */
        .services-section {
            margin-bottom: 64px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (max-width: 600px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        .service-item {
            background: white;
            border: 1px solid #EDE0E0;
            border-radius: 18px;
            padding: 24px 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .22s, box-shadow .22s;
            cursor: default;
        }

        .service-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(139, 0, 0, 0.09);
        }

        .service-item-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #8B0000, #660000);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-item-icon i {
            font-size: 18px;
            color: white;
        }

        .service-item h4 {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 5px;
        }

        .service-item p {
            font-size: 12.5px;
            color: #8A8A9A;
            line-height: 1.6;
        }

        [data-theme="dark"] .service-item {
            background: #0d1b2a;
            border-color: #1e2d3d;
        }

        [data-theme="dark"] .service-item h4 {
            color: #E5E7EB;
        }

        /* FAQ section */
        .faq-section {
            margin-bottom: 64px;
        }

        .faq-header-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .faq-section-title {
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 800;
            color: #8B0000;
        }

        .faq-section-sub {
            font-size: 13px;
            color: #8A8A9A;
            margin-top: 4px;
            max-width: 380px;
        }

        .faq-item-new {
            border: 1px solid #EDE0E0;
            border-radius: 16px;
            margin-bottom: 10px;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
            background: white;
        }

        .faq-item-new.open {
            border-color: #D4AAAA;
            box-shadow: 0 4px 20px rgba(139, 0, 0, 0.06);
        }

        .faq-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
            gap: 16px;
        }

        .faq-trigger-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .faq-num {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            flex-shrink: 0;
            background: #FDF1F1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #8B0000;
            transition: background .2s, color .2s;
        }

        .faq-item-new.open .faq-num {
            background: #8B0000;
            color: white;
        }

        .faq-q {
            font-size: 14px;
            font-weight: 600;
            color: #2D2D3A;
            line-height: 1.5;
            text-align: left;
        }

        [data-theme="dark"] .faq-q {
            color: #E5E7EB;
        }

        .faq-chevron {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #EDE0E0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8A8A9A;
            flex-shrink: 0;
            transition: transform .3s cubic-bezier(.4, 0, .2, 1), background .2s, border-color .2s;
        }

        .faq-item-new.open .faq-chevron {
            transform: rotate(180deg);
            background: #FDF1F1;
            border-color: #F0DADA;
            color: #8B0000;
        }

        .faq-body {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height .35s ease, opacity .3s ease;
        }

        .faq-item-new.open .faq-body {
            opacity: 1;
        }

        .faq-body-inner {
            padding: 0 20px 18px 62px;
            font-size: 13.5px;
            color: #6B7280;
            line-height: 1.75;
        }

        [data-theme="dark"] .faq-item-new {
            background: #0d1b2a;
            border-color: #1e2d3d;
        }

        [data-theme="dark"] .faq-item-new.open {
            border-color: #4a2020;
        }

        [data-theme="dark"] .faq-body-inner {
            color: #9CA3AF;
        }

        [data-theme="dark"] .faq-num {
            background: #1a0a0a;
        }

        /* Team section */
        .team-section {
            margin-bottom: 48px;
        }

        .team-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: #8B0000;
            margin-bottom: 8px;
        }

        .team-sub {
            font-size: 13px;
            color: #8A8A9A;
            margin-bottom: 32px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 400px) {
            .team-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        }

        .team-card {
            background: white;
            border: 1px solid #EDE0E0;
            border-radius: 20px;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            text-align: center;
        }

        .team-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(139, 0, 0, 0.12);
        }

        .team-img-wrap {
            width: 100%;
            aspect-ratio: 1;
            overflow: hidden;
            position: relative;
            background: #FDF1F1;
        }

        .team-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .team-card:hover .team-img-wrap img {
            transform: scale(1.06);
        }

        .team-info {
            padding: 16px 12px 18px;
        }

        .team-name {
            font-size: 13px;
            font-weight: 700;
            color: #2D2D3A;
            margin-bottom: 4px;
        }

        .team-role {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 600;
            color: #8B0000;
            background: #FDF1F1;
            border: 1px solid #F0DADA;
            padding: 2px 10px;
            border-radius: 100px;
        }

        [data-theme="dark"] .team-card {
            background: #0d1b2a;
            border-color: #1e2d3d;
        }

        [data-theme="dark"] .team-name {
            color: #E5E7EB;
        }

        [data-theme="dark"] .team-img-wrap {
            background: #1a0a0a;
        }

        /* Closing statement */
        .closing-banner {
            background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
            border-radius: 20px;
            padding: 40px 40px;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .closing-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 50%;
        }

        .closing-banner-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .closing-banner-icon i {
            font-size: 24px;
            color: rgba(255, 255, 255, 0.85);
        }

        .closing-banner p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.75;
            position: relative;
            z-index: 1;
        }

        .closing-banner strong {
            color: white;
        }

        @media (max-width: 600px) {
            .closing-banner {
                padding: 28px 20px;
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Section label pill */
        .section-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #FDF1F1;
            border: 1px solid #F0DADA;
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #8B0000;
            margin-bottom: 12px;
        }

        /* Scroll fade */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        .reveal-delay-4 {
            transition-delay: 0.4s;
        }
    </style>
@endsection

@php
    $notifications = collect($notifications ?? []);
    $notifCount = $notifications->count();
@endphp

@section('content')
<main id="mainContent" class="pt-[90px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
  <div class="w-full fade-in">

            <div class="about-hero reveal">
                <!-- Decorative rings -->
                <div class="about-hero-ring" style="width:300px;height:300px;top:-100px;right:-100px;"></div>
                <div class="about-hero-ring" style="width:180px;height:180px;bottom:-60px;left:40%;"></div>

                <div class="about-hero-text">
                    <div class="about-hero-eyebrow">
                        <i class="fa-solid fa-tooth"></i>
                        PUP Taguig Campus
                    </div>
                    <h1>Dental Clinic</h1>
                    <p>Providing free, professional dental care to the PUP Taguig community — students, alumni, faculty,
                        and staff
                        in a safe and welcoming environment.</p>
                </div>
                <div class="about-hero-badge">
                    <i class="fa-solid fa-tooth"></i>
                </div>
            </div>

            <!-- ── MISSION PILLARS ── -->
            <div class="mission-strip reveal">
                <div class="mission-card reveal reveal-delay-1">
                    <div class="mission-icon"><i class="fa-solid fa-shield-heart"></i></div>
                    <h3>Free Dental Care</h3>
                    <p>All dental services are provided at no cost to eligible members of the PUP Taguig academic
                        community.</p>
                </div>
                <div class="mission-card reveal reveal-delay-2">
                    <div class="mission-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <h3>Easy Scheduling</h3>
                    <p>Book appointments online through the Dental Management System with real-time slot availability.
                    </p>
                </div>
                <div class="mission-card reveal reveal-delay-3">
                    <div class="mission-icon"><i class="fa-solid fa-file-medical"></i></div>
                    <h3>Digital Records</h3>
                    <p>Patient history, treatments, prescriptions, and diagnoses are securely stored and easily
                        accessible.</p>
                </div>
            </div>

            <!-- ── MEET THE DENTIST ── -->
            <section class="mb-16 reveal">
                <div class="section-pill"><i class="fa-solid fa-user-doctor"></i> Our Dentist</div>
                <div class="dentist-section">
                    <!-- Text side -->
                    <div class="dentist-text-side">
                        <h2>Led by an experienced professional</h2>
                        <p>The PUP Taguig Dental Clinic is headed by <strong>Dr. Nelson P. Angeles</strong>, the campus
                            dentist, who
                            provides professional, safe, and reliable dental care to the entire university community.
                        </p>
                        <p>With a commitment to patient comfort and oral health excellence, Dr. Angeles oversees all
                            dental
                            services, consultations, and treatment plans delivered at the clinic.</p>
                        <div class="flex flex-wrap gap-2 mt-4">
                            <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> Licensed
                                Dentist</span>
                            <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> PUP Campus
                                Dentist</span>
                            <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> Free
                                Consultations</span>
                        </div>
                    </div>

                    <!-- Profile card -->
                    <div class="dentist-profile-card">
                        <div class="dentist-card-header">
                            <div class="dentist-img-wrap">
                                <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles"
                                    onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
                            </div>
                            <div class="dentist-name">Dr. Nelson P. Angeles</div>
                            <div class="dentist-title">University Campus Dentist</div>
                        </div>
                        <div class="dentist-card-body">
                            <p class="text-sm text-[#6B7280] leading-relaxed mb-4">Serving the PUP Taguig community
                                with dedication,
                                Dr. Angeles ensures every patient receives attentive and comprehensive dental care.</p>
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                                    <span
                                        class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i
                                            class="fa-solid fa-location-dot text-[#8B0000] text-xs"></i></span>
                                    PUP Taguig Campus Dental Clinic
                                </div>
                                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                                    <span
                                        class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i
                                            class="fa-regular fa-clock text-[#8B0000] text-xs"></i></span>
                                    Monday – Friday, 8:00 AM – 5:00 PM
                                </div>
                                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                                    <span
                                        class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i
                                            class="fa-solid fa-users text-[#8B0000] text-xs"></i></span>
                                    Students, Alumni, Faculty & Staff
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ── SERVICES OFFERED ── -->
            <section class="services-section reveal">
                <div class="section-pill"><i class="fa-solid fa-stethoscope"></i> Services</div>
                <h2 class="text-2xl font-800 font-bold text-[#8B0000] mb-2">What We Offer</h2>
                <p class="text-sm text-[#8A8A9A] mb-6">The clinic provides a range of preventive and restorative dental
                    services
                    at no cost.</p>
                <div class="services-grid">
                    <div class="service-item reveal reveal-delay-1">
                        <div class="service-item-icon"><i class="fa-solid fa-hand-holding-medical"></i></div>
                        <div>
                            <h4>Oral Check-Up & Consultation</h4>
                            <p>Routine oral examinations, dental consultation, and oral health assessment.</p>
                        </div>
                    </div>
                    <div class="service-item reveal reveal-delay-2">
                        <div class="service-item-icon"><i class="fa-solid fa-droplet"></i></div>
                        <div>
                            <h4>Dental Cleaning</h4>
                            <p>Professional oral hygiene treatment to remove plaque, tartar, and surface stains.</p>
                        </div>
                    </div>
                    <div class="service-item reveal reveal-delay-3">
                        <div class="service-item-icon"><i class="fa-solid fa-teeth"></i></div>
                        <div>
                            <h4>Restoration & Prosthesis</h4>
                            <p>Fillings, crowns, inlays, and other repairs to restore damaged or missing teeth.</p>
                        </div>
                    </div>
                    <div class="service-item reveal reveal-delay-4">
                        <div class="service-item-icon"><i class="fa-solid fa-crutch"></i></div>
                        <div>
                            <h4>Dental Surgery</h4>
                            <p>Tooth extractions, supernumerary removal, and other surgical dental procedures.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ── FAQs ── -->
            <section class="faq-section reveal">
                <div class="faq-header-row">
                    <div>
                        <div class="section-pill"><i class="fa-solid fa-circle-question"></i> FAQs</div>
                        <h2 class="faq-section-title">Frequently Asked Questions</h2>
                        <p class="faq-section-sub">Quick answers about the PUP Taguig Dental Management System.</p>
                    </div>
                </div>

                @php
                    $faqs = [
                        [
                            'q' => 'Who can avail of the dental services?',
                            'a' => 'All students, alumni, faculty, and staff of the Polytechnic University of the Philippines – Taguig
        Campus are eligible for free dental services.',
                        ],
                        [
                            'q' => 'How do I book an appointment?',
                            'a' => 'You can book an appointment online through the Dental Management System portal. Simply log in, choose
        your preferred schedule, and confirm your booking.',
                        ],
                        [
                            'q' => 'Will the dentist prescribe medications?',
                            'a' => 'Yes. Depending on your dental condition, Dr. Angeles may prescribe antibiotics, pain relievers, or other
        necessary medications during your visit.',
                        ],
                        [
                            'q' => 'Can I book an appointment anytime?',
                            'a' => 'Appointments are subject to slot availability. Since the clinic operates with a single dentist and
        limited daily slots, early booking is highly recommended.',
                        ],
                        [
                            'q' => 'How do I cancel or reschedule?',
                            'a' => 'You can cancel or reschedule through the Dental Management System portal or by contacting the clinic
        directly — at least three (3) days before your scheduled appointment.',
                        ],
                        [
                            'q' => 'What if the dentist is unavailable on my scheduled day?',
                            'a' => 'If Dr. Angeles is unavailable, your confirmed appointment will be rescheduled to the next available slot
        and you will be notified accordingly.',
                        ],
                        [
                            'q' => 'What services are available at the clinic?',
                            'a' => 'The clinic provides oral check-ups, dental cleaning, fillings, extractions, dental surgery, restoration,
        prosthetics, and preventive care services.',
                        ],
                        [
                            'q' => 'Are urgent dental cases given priority?',
                            'a' => 'Yes, urgent cases may be prioritized depending on the daily schedule and the dentist\'s discretion.
        Contact the clinic directly for urgent concerns.',
                        ],
                        [
                            'q' => 'Are there restrictions for certain treatments?',
                            'a' => 'Some advanced procedures may not be available due to the clinic\'s resources and equipment. The dentist
        will guide you on available alternatives if needed.',
                        ],
                        [
                            'q' => 'Are follow-up appointments required?',
                            'a' => 'Some treatments require follow-up visits. Dr. Angeles will advise you if a follow-up is necessary after
        your initial treatment.',
                        ],
                    ];
                @endphp

                <div id="faqList">
                    @foreach ($faqs as $i => $faq)
                        <div class="faq-item-new reveal" style="transition-delay: {{ $i * 0.04 }}s;">
                            <button class="faq-trigger" onclick="toggleFaqNew(this)" aria-expanded="false">
                                <div class="faq-trigger-left">
                                    <span class="faq-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="faq-q">{{ $faq['q'] }}</span>
                                </div>
                                <span class="faq-chevron"><i class="fa-solid fa-chevron-down text-xs"></i></span>
                            </button>
                            <div class="faq-body">
                                <div class="faq-body-inner">{{ $faq['a'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- ── THE DEVELOPERS ── -->
            <section class="team-section reveal">
                <div class="section-pill"><i class="fa-solid fa-code"></i> Development Team</div>
                <h2 class="team-title">The Developers</h2>
                <p class="team-sub">The PUPT Dental Management System was built by these talented developers.</p>

                <div class="team-grid">
                    @php
                        $devs = [
                            ['img' => 'Althea-Aragon.jpg', 'name' => 'Althea Aragon', 'role' => 'Developer'],
                            ['img' => 'Grace-Lim.jpg', 'name' => 'Grace Lim', 'role' => 'Developer'],
                            ['img' => 'Hoshea-Lopez.jpg', 'name' => 'Hoshea Lopez', 'role' => 'Developer'],
                            ['img' => 'Rain-Romero.jpg', 'name' => 'Rain Romero', 'role' => 'Developer'],
                        ];
                    @endphp

                    @foreach ($devs as $i => $dev)
                        <div class="team-card reveal" style="transition-delay: {{ $i * 0.08 }}s;">
                            <div class="team-img-wrap">
                                <img src="{{ asset('images/' . $dev['img']) }}" alt="{{ $dev['name'] }}"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dev['name']) }}&background=8B0000&color=FFFFFF&size=200'">
                            </div>
                            <div class="team-info">
                                <div class="team-name">{{ $dev['name'] }}</div>
                                <span class="team-role">{{ $dev['role'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- ── CLOSING STATEMENT ── -->
            <div class="closing-banner reveal">
                <div class="closing-banner-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <p>The <strong>PUPT Dental Management System</strong> was developed to manage records and appointments
                    more
                    effectively — ensuring efficient dental service while supporting the University's commitment to
                    quality and
                    accessible care for all.</p>
            </div>

        </div>
    </main>
@endsection

@section('scripts')

    <script>
        /* ══════════════════════════════════════════════
           FAQ ACCORDION
        ══════════════════════════════════════════════ */
        function toggleFaqNew(btn) {
            var item = btn.closest('.faq-item-new');
            var body = item.querySelector('.faq-body');
            var isOpen = item.classList.contains('open');

            // close all
            document.querySelectorAll('.faq-item-new.open').forEach(function(el) {
                el.classList.remove('open');
                el.querySelector('.faq-body').style.maxHeight = '0';
                el.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
            });

            if (!isOpen) {
                item.classList.add('open');
                body.style.maxHeight = body.scrollHeight + 'px';
                btn.setAttribute('aria-expanded', 'true');
            }
        }

        /* ══════════════════════════════════════════════
           DOM READY
        ══════════════════════════════════════════════ */
        document.addEventListener('DOMContentLoaded', function() {
            /* Scroll reveal */
            var revealObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            document.querySelectorAll('.reveal').forEach(function(el) {
                revealObserver.observe(el);
            });
        });
    </script>
@endsection
