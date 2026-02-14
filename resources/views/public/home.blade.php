@extends('layouts.app_layout')

@section('title', 'Charlie DevLab - Développeur Web Fullstack & Formateur Digital')

@push('styles')
<style>
    /* ========================================
       ANIMATIONS GLOBALES DYNAMIQUES
    ======================================== */

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes rotateIn {
        from {
            opacity: 0;
            transform: rotate(-180deg) scale(0.5);
        }
        to {
            opacity: 1;
            transform: rotate(0) scale(1);
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
    }

    @keyframes gradient-shift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes shimmer {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }

    @keyframes expandWidth {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }

    @keyframes flipIn {
        from {
            opacity: 0;
            transform: perspective(400px) rotateX(90deg);
        }
        to {
            opacity: 1;
            transform: perspective(400px) rotateX(0);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Animation de glitch */
    @keyframes glitch {
        0% {
            transform: translate(0);
        }
        20% {
            transform: translate(-2px, 2px);
        }
        40% {
            transform: translate(-2px, -2px);
        }
        60% {
            transform: translate(2px, 2px);
        }
        80% {
            transform: translate(2px, -2px);
        }
        100% {
            transform: translate(0);
        }
    }

    /* Effet de révélation */
    @keyframes reveal {
        from {
            clip-path: polygon(0 0, 0 0, 0 100%, 0% 100%);
        }
        to {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
    }

    /* Observer pour détecter les éléments visibles */
    .animate-on-scroll {
        opacity: 0;
    }

    .animate-on-scroll.visible {
        animation-fill-mode: forwards;
    }

    /* ========================================
       HERO SECTION AVEC ANIMATIONS
    ======================================== */

    .hero-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(108, 92, 231, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(0, 184, 169, 0.1) 0%, transparent 50%);
        animation: gradient-shift 15s ease infinite;
        background-size: 200% 200%;
    }

    .hero-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .hero-content {
        animation: slideInLeft 1s ease-out;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0, 212, 170, 0.1);
        border: 1px solid var(--success);
        color: var(--success);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 2rem;
        animation: slideDown 0.8s ease-out, pulse 2s ease-in-out infinite 1s;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: var(--success);
        border-radius: 50%;
        animation: pulse 1.5s ease-in-out infinite;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease-out 0.2s backwards;
    }

    .hero-title .highlight {
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
        animation: glitch 5s ease-in-out infinite;
    }

    .hero-roles {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .role-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        animation: zoomIn 0.6s ease-out backwards;
    }

    .role-badge:nth-child(1) {
        animation-delay: 0.4s;
    }

    .role-badge:nth-child(2) {
        animation-delay: 0.6s;
    }

    .role-badge:nth-child(3) {
        animation-delay: 0.8s;
    }

    .role-badge:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.3);
    }

    .role-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: bounce 2s ease-in-out infinite;
    }

    .hero-description {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 2.5rem;
        max-width: 550px;
        animation: fadeInUp 0.8s ease-out 0.6s backwards;
    }

    .hero-cta {
        display: flex;
        gap: 1.5rem;
        animation: fadeInUp 0.8s ease-out 1s backwards;
    }

    .btn-large {
        padding: 1rem 2rem;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn-large::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-large:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-download {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--dark-border);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-download:hover {
        border-color: var(--secondary);
        background: rgba(0, 184, 169, 0.1);
        transform: translateY(-3px);
    }

    /* Hero Image avec animations */
    .hero-image-container {
        position: relative;
        animation: slideInRight 1s ease-out 0.4s backwards;
    }

    .hero-image-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        animation: float 6s ease-in-out infinite;
    }

    .hero-image {
        width: 100%;
        height: auto;
        border-radius: 20px;
        border: 3px solid var(--primary);
        box-shadow:
            0 20px 60px rgba(108, 92, 231, 0.3),
            0 0 0 10px rgba(108, 92, 231, 0.1);
        transition: transform 0.3s ease;
    }

    .hero-image:hover {
        transform: scale(1.02) rotate(1deg);
    }

    .floating-badge {
        position: absolute;
        background: rgba(10, 14, 39, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid var(--dark-border);
        border-radius: 15px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .floating-badge:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .floating-badge.badge-1 {
        top: 10%;
        right: -10%;
        animation: slideInRight 1s ease-out 1s backwards;
    }

    .floating-badge.badge-2 {
        bottom: 15%;
        left: -5%;
        animation: slideInLeft 1s ease-out 1.2s backwards;
    }

    .floating-badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        animation: rotateIn 1s ease-out;
    }

    .floating-badge-icon.fullstack {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
    }

    .floating-badge-icon.trainer {
        background: linear-gradient(135deg, var(--secondary), #00E5D0);
    }

    .floating-badge-text h4 {
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 0.2rem;
    }

    .floating-badge-text p {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    /* ========================================
       STATS SECTION AVEC COMPTEUR ANIMÉ
    ======================================== */

    .stats-section {
        padding: 4rem 2rem;
        background: var(--dark-card);
        border-top: 1px solid var(--dark-border);
        border-bottom: 1px solid var(--dark-border);
    }

    .stats-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
    }

    .stat-item {
        text-align: center;
        opacity: 0;
        transition: all 0.6s ease;
    }

    .stat-item.animate-on-scroll.visible {
        animation: scaleIn 0.6s ease-out forwards;
    }

    .stat-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stat-item:nth-child(2) {
        animation-delay: 0.3s;
    }

    .stat-item:nth-child(3) {
        animation-delay: 0.5s;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .stat-label {
        font-size: 1.1rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    /* ========================================
       SERVICES SECTION - CARTES FLIP
    ======================================== */

    .services-section {
        padding: 6rem 2rem;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
        opacity: 0;
    }

    .section-header.animate-on-scroll.visible {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .section-subtitle {
        font-size: 0.9rem;
        color: var(--primary-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1rem;
        animation: slideDown 0.8s ease-out;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.3;
        animation: fadeInUp 0.8s ease-out 0.2s backwards;
    }

    .section-description {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
        animation: fadeInUp 0.8s ease-out 0.4s backwards;
    }

    .services-grid {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .service-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2.5rem;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        opacity: 0;
    }

    .service-card.animate-on-scroll.visible {
        animation: flipIn 0.6s ease-out forwards;
    }

    .service-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .service-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .service-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .service-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .service-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .service-card:nth-child(6) {
        animation-delay: 0.6s;
    }

    /* Effet de vague au survol */
    .service-card::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(108, 92, 231, 0.1);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .service-card:hover::before {
        width: 500px;
        height: 500px;
    }

    .service-card:hover {
        transform: translateY(-15px) scale(1.02);
        border-color: var(--primary);
        box-shadow: 0 25px 50px rgba(108, 92, 231, 0.3);
    }

    .service-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .service-card:hover .service-icon {
        transform: scale(1.2) rotate(360deg);
    }

    .service-icon.web {
        background: linear-gradient(135deg, #667EEA, #764BA2);
    }

    .service-icon.mobile {
        background: linear-gradient(135deg, #00D4AA, #00B8A9);
    }

    .service-icon.backend {
        background: linear-gradient(135deg, #A29BFE, #6C5CE7);
    }

    .service-icon.formation {
        background: linear-gradient(135deg, #FFA500, #FF8B4D);
    }

    .service-icon.design {
        background: linear-gradient(135deg, #FF6B9D, #FF4757);
    }

    .service-icon.consulting {
        background: linear-gradient(135deg, #00D4FF, #00A8E8);
    }

    .service-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        position: relative;
        z-index: 1;
    }

    .service-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    /* ========================================
       SKILLS SECTION - BARRES PROGRESSIVES
    ======================================== */

    .skills-section {
        padding: 6rem 2rem;
        background: var(--dark-card);
        border-top: 1px solid var(--dark-border);
        border-bottom: 1px solid var(--dark-border);
    }

    .skills-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 4rem;
        margin-top: 4rem;
    }

    .skills-category {
        opacity: 0;
    }

    .skills-category.animate-on-scroll.visible {
        animation: slideInLeft 0.6s ease-out forwards;
    }

    .skills-category:nth-child(even).animate-on-scroll.visible {
        animation: slideInRight 0.6s ease-out forwards;
    }

    .skills-category:nth-child(1) {
        animation-delay: 0.1s;
    }

    .skills-category:nth-child(2) {
        animation-delay: 0.2s;
    }

    .skills-category:nth-child(3) {
        animation-delay: 0.3s;
    }

    .skills-category:nth-child(4) {
        animation-delay: 0.4s;
    }

    .skills-category-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .skills-category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .skills-category:hover .skills-category-icon {
        transform: rotate(360deg) scale(1.1);
    }

    .skills-category-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .skills-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .skill-item {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .skill-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .skill-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .skill-level {
        font-size: 0.9rem;
        color: var(--primary-light);
        font-weight: 600;
    }

    .skill-bar {
        height: 8px;
        background: var(--dark-bg);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .skill-progress {
        height: 100%;
        border-radius: 10px;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        width: 0 !important;
    }

    .skill-progress.animated {
        width: var(--skill-width) !important;
    }

    .skill-progress::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    /* ========================================
       RÉALISATIONS - CARTES EXPANDABLES
    ======================================== */

    .realisations-section {
        padding: 6rem 2rem;
        background: var(--dark-bg);
    }

    .realisations-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .realisations-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .realisation-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
        display: block;
        opacity: 0;
        position: relative;
    }

    .realisation-card.animate-on-scroll.visible {
        animation: reveal 0.8s ease-out forwards, fadeInUp 0.6s ease-out forwards;
    }

    .realisation-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .realisation-card:nth-child(2) {
        animation-delay: 0.3s;
    }

    .realisation-card:nth-child(3) {
        animation-delay: 0.5s;
    }

    .realisation-card:hover {
        transform: translateY(-15px) scale(1.03);
        border-color: var(--primary);
        box-shadow: 0 30px 60px rgba(108, 92, 231, 0.4);
        z-index: 10;
    }

    .realisation-image-wrapper {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background: var(--dark-bg);
    }

    .realisation-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .realisation-card:hover .realisation-image {
        transform: scale(1.2) rotate(2deg);
    }

    .realisation-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(10, 14, 39, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .realisation-card:hover .realisation-badge {
        transform: translateX(5px) scale(1.1);
    }

    .realisation-badge.web {
        color: #667EEA;
        border: 1px solid #667EEA;
    }

    .realisation-badge.mobile {
        color: #00D4AA;
        border: 1px solid #00D4AA;
    }

    .realisation-badge.design {
        color: #FF6B9D;
        border: 1px solid #FF6B9D;
    }

    .realisation-badge.featured {
        top: auto;
        bottom: 1rem;
        left: auto;
        right: 1rem;
        background: linear-gradient(135deg, var(--warning), #FFA500);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .realisation-content {
        padding: 2rem;
        position: relative;
    }

    .realisation-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .realisation-card:hover .realisation-title {
        color: var(--primary-light);
    }

    .realisation-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .realisation-technologies {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .tech-tag {
        padding: 0.4rem 0.9rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 6px;
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 500;
        font-family: 'JetBrains Mono', monospace;
        transition: all 0.3s ease;
    }

    .realisation-card:hover .tech-tag {
        transform: translateY(-2px);
        border-color: var(--primary);
        color: var(--primary);
    }

    .realisation-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--dark-border);
    }

    .realisation-client {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .realisation-date {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.4s ease;
        margin: 2rem auto;
        display: flex;
        width: fit-content;
        position: relative;
        overflow: hidden;
    }

    .view-all-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: var(--primary);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .view-all-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .view-all-btn:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(108, 92, 231, 0.4);
    }

    /* ========================================
       EVENTS SECTION - CARTES 3D
    ======================================== */

    .events-section {
        padding: 6rem 2rem;
        background: var(--dark-card);
        border-top: 1px solid var(--dark-border);
    }

    .events-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .event-card {
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform-style: preserve-3d;
        perspective: 1000px;
    }

    .event-card.animate-on-scroll.visible {
        animation: flipIn 0.8s ease-out forwards;
    }

    .event-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .event-card:nth-child(2) {
        animation-delay: 0.3s;
    }

    .event-card:nth-child(3) {
        animation-delay: 0.5s;
    }

    .event-card:hover {
        transform: translateY(-15px) rotateX(5deg);
        border-color: var(--secondary);
        box-shadow: 0 30px 60px rgba(0, 184, 169, 0.4);
    }

    .event-header {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .event-header-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .event-card:hover .event-header-image {
        transform: scale(1.15);
    }

    .event-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
        z-index: 1;
    }

    .event-date-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: white;
        color: var(--primary);
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 2;
        transition: all 0.3s ease;
    }

    .event-card:hover .event-date-badge {
        transform: scale(1.1) rotate(5deg);
    }

    .event-day {
        font-size: 2rem;
        line-height: 1;
    }

    .event-month {
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-top: 0.2rem;
    }

    .event-type-badges {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        display: flex;
        gap: 0.5rem;
        z-index: 2;
    }

    .event-type-badge {
        padding: 0.4rem 0.8rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .event-card:hover .event-type-badge {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.3);
    }

    .event-price-badge {
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        padding: 0.5rem 1rem;
        background: var(--warning);
        color: white;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .event-card:hover .event-price-badge {
        transform: scale(1.1);
    }

    .event-price-badge.free {
        background: var(--success);
    }

    .event-body {
        padding: 2rem;
        flex: 1;
    }

    .event-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .event-card:hover .event-title {
        color: var(--secondary);
    }

    .event-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
        transition: transform 0.3s ease;
    }

    .event-card:hover .event-meta-item {
        transform: translateX(5px);
    }

    .event-meta-icon {
        width: 30px;
        height: 30px;
        background: var(--dark-card);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--dark-border);
    }

    .event-register-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--secondary), #00E5D0);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .event-register-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .event-register-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .event-register-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 184, 169, 0.4);
    }

    /* ========================================
       CTA SECTION - EFFET PARALLAX
    ======================================== */

    .cta-section {
        padding: 6rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        animation: gradient-shift 15s ease infinite;
        background-size: 200% 200%;
    }

    .cta-container {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .cta-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 2rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        animation: pulse 2s ease-in-out infinite, rotateIn 1s ease-out;
    }

    .cta-title {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.3;
        opacity: 0;
    }

    .cta-title.animate-on-scroll.visible {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .cta-description {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 3rem;
        line-height: 1.8;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0;
    }

    .cta-description.animate-on-scroll.visible {
        animation: fadeInUp 0.6s ease-out 0.2s forwards;
    }

    .cta-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        opacity: 0;
    }

    .cta-buttons.animate-on-scroll.visible {
        animation: fadeInUp 0.6s ease-out 0.4s forwards;
    }

    .btn-white {
        background: white;
        color: var(--primary);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .btn-white::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: var(--primary-light);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .btn-white:hover::after {
        width: 400px;
        height: 400px;
    }

    .btn-white:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }

    .btn-outline-white {
        background: transparent;
        color: white;
        border: 2px solid white;
        position: relative;
        overflow: hidden;
    }

    .btn-outline-white::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: white;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .btn-outline-white:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-outline-white:hover {
        color: var(--primary);
        transform: translateY(-3px);
    }

    /* ========================================
       RESPONSIVE
    ======================================== */

    @media (max-width: 1024px) {
        .hero-container {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .stats-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .services-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .skills-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .realisations-grid,
        .events-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .hero-cta {
            flex-direction: column;
        }

        .btn-large {
            width: 100%;
            justify-content: center;
        }

        .stats-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .floating-badge {
            display: none;
        }

        .section-title {
            font-size: 2rem;
        }

        .services-grid {
            grid-template-columns: 1fr;
        }

        .service-card {
            padding: 2rem;
        }

        .realisations-grid,
        .events-grid {
            grid-template-columns: 1fr;
        }

        .event-header {
            height: 180px;
        }

        .cta-title {
            font-size: 2rem;
        }

        .cta-description {
            font-size: 1rem;
        }

        .cta-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <div class="status-badge">
                <span class="status-dot"></span>
                Disponible pour de nouveaux projets
            </div>

            <h1 class="hero-title">
                Salut, je suis<br>
                <span class="highlight">Charlie</span>
            </h1>

            <div class="hero-roles">
                <div class="role-badge">
                    <span class="role-icon">✓</span>
                    Développeur Web Fullstack
                </div>
                <div class="role-badge">
                    <span class="role-icon">✓</span>
                    Entrepreneur Tech
                </div>
                <div class="role-badge">
                    <span class="role-icon">✓</span>
                    Formateur Digital
                </div>
            </div>

            <p class="hero-description">
                Étudiant en Licence 3 Système Informatique & Logiciel et Licence 2 Sciences de l'Éducation.
                Je crée des expériences digitales exceptionnelles et forme la prochaine génération de développeurs.
            </p>

            <div class="hero-cta">
                <a href="{{ route('realisations.index') }}" class="btn btn-primary btn-large">
                    Voir mes Réalisations
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#" class="btn btn-download btn-large">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Télécharger CV
                </a>
            </div>
        </div>

        <div class="hero-image-container">
            <div class="hero-image-wrapper">
                <img src="/images/Profile.jpg" alt="Charlie - Développeur Web Fullstack" class="hero-image">
            </div>

            <div class="floating-badge badge-1">
                <div class="floating-badge-icon fullstack">
                    &lt;/&gt;
                </div>
                <div class="floating-badge-text">
                    <h4>Fullstack Dev</h4>
                    <p>Expert en développement</p>
                </div>
            </div>

            <div class="floating-badge badge-2">
                <div class="floating-badge-icon trainer">
                    📚
                </div>
                <div class="floating-badge-text">
                    <h4>Formateur</h4>
                    <p>Coach développeur</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-container">
        <div class="stat-item animate-on-scroll">
            <div class="stat-number" data-target="{{ $stats['projects'] }}">0</div>
            <div class="stat-label">Projets Réalisés</div>
        </div>
        <div class="stat-item animate-on-scroll">
            <div class="stat-number" data-target="{{ $stats['clients'] }}">0</div>
            <div class="stat-label">Clients Satisfaits</div>
        </div>
        <div class="stat-item animate-on-scroll">
            <div class="stat-number" data-target="{{ $stats['experience'] }}">0</div>
            <div class="stat-label">Années d'Expérience</div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="section-header animate-on-scroll">
        <div class="section-subtitle">CE QUE JE FAIS</div>
        <h2 class="section-title">Mes Services</h2>
        <p class="section-description">
            Des solutions complètes pour transformer vos idées en produits digitaux exceptionnels.
        </p>
    </div>

    <div class="services-grid">
        <div class="service-card animate-on-scroll">
            <div class="service-icon web">&lt;/&gt;</div>
            <h3 class="service-title">Développement Web</h3>
            <p class="service-description">
                Sites web sur mesure, e-commerce, applications web modernes avec les dernières technologies.
            </p>
        </div>

        <div class="service-card animate-on-scroll">
            <div class="service-icon mobile">📱</div>
            <h3 class="service-title">Applications Mobiles</h3>
            <p class="service-description">
                Applications iOS et Android performantes avec React Native et Flutter.
            </p>
        </div>

        <div class="service-card animate-on-scroll">
            <div class="service-icon backend">⚙️</div>
            <h3 class="service-title">Backend & API</h3>
            <p class="service-description">
                APIs robustes, bases de données optimisées, architecture scalable.
            </p>
        </div>

        <div class="service-card animate-on-scroll">
            <div class="service-icon formation">📚</div>
            <h3 class="service-title">Formation & Coaching</h3>
            <p class="service-description">
                Accompagnement personnalisé pour développeurs débutants et confirmés.
            </p>
        </div>

        <div class="service-card animate-on-scroll">
            <div class="service-icon design">🎨</div>
            <h3 class="service-title">UI/UX Design</h3>
            <p class="service-description">
                Interfaces élégantes et expériences utilisateur optimisées.
            </p>
        </div>

        <div class="service-card animate-on-scroll">
            <div class="service-icon consulting">👥</div>
            <h3 class="service-title">Consulting Tech</h3>
            <p class="service-description">
                Conseil stratégique pour vos projets digitaux et transformation numérique.
            </p>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="skills-section">
    <div class="skills-container">
        <div class="section-header animate-on-scroll">
            <div class="section-subtitle">MON EXPERTISE</div>
            <h2 class="section-title">Compétences Techniques</h2>
        </div>

        <div class="skills-grid">
            @forelse($skillCategories as $category)
            <div class="skills-category animate-on-scroll">
                <div class="skills-category-header">
                    <div class="skills-category-icon" style="background: linear-gradient(135deg, {{ $category->color }});">
                        {{ $category->icon }}
                    </div>
                    <h3 class="skills-category-title">{{ $category->name }}</h3>
                </div>
                <div class="skills-list">
                    @foreach($category->skills as $skill)
                    <div class="skill-item">
                        <div class="skill-header">
                            <span class="skill-name">{{ $skill->name }}</span>
                            <span class="skill-level">{{ $skill->level }}%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-progress" style="--skill-width: {{ $skill->level }}%; background: linear-gradient(90deg, {{ $category->color }});"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
                <p style="color: var(--text-secondary); font-size: 1.1rem;">Aucune compétence pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Réalisations Récentes Section -->
<section class="realisations-section">
    <div class="realisations-container">
        <div class="section-header animate-on-scroll">
            <div class="section-subtitle">PORTFOLIO</div>
            <h2 class="section-title">Réalisations Récentes</h2>
        </div>

        <div class="realisations-grid">
            @forelse($featuredRealisations as $realisation)
            <a href="{{ route('realisations.show', $realisation->slug) }}" class="realisation-card animate-on-scroll">
                <div class="realisation-image-wrapper">
                    <img
                        src="{{ route('realisations.image', basename($realisation->image)) }}"
                        alt="{{ $realisation->title }}"
                        class="realisation-image"
                        loading="lazy"
                    >
                    <span class="realisation-badge {{ strtolower($realisation->category) }}">{{ $realisation->category }}</span>
                    @if($realisation->featured)
                        <span class="realisation-badge featured">⭐ Featured</span>
                    @endif
                </div>
                <div class="realisation-content">
                    <h3 class="realisation-title">{{ $realisation->title }}</h3>
                    <p class="realisation-description">{{ Str::limit($realisation->description, 100) }}</p>

                    <div class="realisation-technologies">
                        @foreach($realisation->technologies as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                        @endforeach
                    </div>

                    <div class="realisation-meta">
                        <span class="realisation-client">Client: {{ $realisation->client ?? 'Personnel' }}</span>
                        <span class="realisation-date">{{ $realisation->completion_date->format('M Y') }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
                <p style="color: var(--text-secondary); font-size: 1.1rem;">Aucune réalisation pour le moment.</p>
            </div>
            @endforelse
        </div>

        <a href="{{ route('realisations.index') }}" class="view-all-btn">
            Voir tout
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

<!-- Events Preview Section -->
@if($upcomingEvents->count() > 0)
<section class="events-section">
    <div class="events-container">
        <div class="section-header animate-on-scroll">
            <div class="section-subtitle">ÉVÉNEMENTS</div>
            <h2 class="section-title">Webinaires & Masterclass</h2>
        </div>

        <div class="events-grid">
            @foreach($upcomingEvents as $event)
            <div class="event-card animate-on-scroll">
                <div class="event-header">
                    @if($event->image)
                        <img src="{{ $event->image }}" alt="{{ $event->title }}" class="event-header-image">
                    @endif

                    <div class="event-date-badge">
                        <span class="event-day">{{ $event->event_date->format('d') }}</span>
                        <span class="event-month">{{ $event->event_date->format('M') }}</span>
                    </div>

                    <div class="event-type-badges">
                        <span class="event-type-badge">{{ $event->type }}</span>
                        @if($event->location == 'En ligne')
                            <span class="event-type-badge">En ligne</span>
                        @endif
                    </div>

                    @if($event->is_free)
                        <span class="event-price-badge free">GRATUIT</span>
                    @else
                        <span class="event-price-badge">{{ number_format($event->price, 0, ',', ' ') }} FCFA</span>
                    @endif
                </div>

                <div class="event-body">
                    <h3 class="event-title">{{ $event->title }}</h3>
                    <p class="event-description">{{ Str::limit($event->description, 120) }}</p>

                    <div class="event-meta">
                        <div class="event-meta-item">
                            <span class="event-meta-icon">🕐</span>
                            {{ $event->event_date->format('H:i') }} • {{ $event->duration }}
                        </div>
                        <div class="event-meta-item">
                            <span class="event-meta-icon">📍</span>
                            {{ $event->location }}
                        </div>
                        <div class="event-meta-item">
                            <span class="event-meta-icon">👥</span>
                            {{ $event->available_slots ?? 'Illimité' }} places restantes
                        </div>
                    </div>
                </div>

                <div class="event-footer">
                    <button class="event-register-btn">
                        S'inscrire
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('events.index') }}" class="view-all-btn">
            Tous les événements
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <div class="cta-icon">⚡</div>
        <h2 class="cta-title animate-on-scroll">Prêt à Démarrer Votre Projet ?</h2>
        <p class="cta-description animate-on-scroll">
            Discutons de votre vision et créons ensemble quelque chose d'extraordinaire.
        </p>
        <div class="cta-buttons animate-on-scroll">
            <a href="{{ route('public.contact') }}" class="btn btn-white btn-large">
                Démarrer un Projet
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('product.index') }}" class="btn btn-outline-white btn-large">
                Explorer la Boutique
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // INTERSECTION OBSERVER POUR ANIMATIONS
    // ========================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');

                // Animer les compteurs pour les stats
                if (entry.target.classList.contains('stat-item')) {
                    animateCounter(entry.target);
                }

                // Animer les barres de compétences
                if (entry.target.classList.contains('skills-category')) {
                    animateSkillBars(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observer tous les éléments avec animation
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // ========================================
    // ANIMATION DES COMPTEURS (STATS)
    // ========================================

    function animateCounter(element) {
        const numberElement = element.querySelector('.stat-number');
        const target = parseInt(numberElement.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                numberElement.textContent = target + '+';
                clearInterval(timer);
            } else {
                numberElement.textContent = Math.floor(current) + '+';
            }
        }, 16);
    }

    // ========================================
    // ANIMATION DES BARRES DE COMPÉTENCES
    // ========================================

    function animateSkillBars(category) {
        const skillBars = category.querySelectorAll('.skill-progress');

        skillBars.forEach((bar, index) => {
            setTimeout(() => {
                bar.classList.add('animated');
            }, index * 100);
        });
    }

    // ========================================
    // EFFET PARALLAX SUR CTA SECTION
    // ========================================

    const ctaSection = document.querySelector('.cta-section');
    if (ctaSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const ctaOffset = ctaSection.offsetTop;
            const ctaHeight = ctaSection.offsetHeight;

            if (scrolled > ctaOffset - window.innerHeight && scrolled < ctaOffset + ctaHeight) {
                const parallax = (scrolled - ctaOffset + window.innerHeight) * 0.3;
                ctaSection.style.backgroundPositionY = parallax + 'px';
            }
        });
    }

    // ========================================
    // EFFET 3D SUR LES CARTES AU SURVOL
    // ========================================

    document.querySelectorAll('.service-card, .realisation-card, .event-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });

    // ========================================
    // SMOOTH SCROLL
    // ========================================

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // PRÉCHARGEMENT DES IMAGES
    // ========================================

    const images = document.querySelectorAll('img[loading="lazy"]');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // ========================================
    // ANIMATION DES BOUTONS
    // ========================================

    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Style pour l'effet ripple
    const style = document.createElement('style');
    style.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    console.log('🚀 Animations dynamiques chargées avec succès!');
});
</script>
@endpush
