# 🌌 EduIde — Future Learning Ecosystem

<div align="center">
  <img src="resources/images/welcome-hero.jpg" alt="EduIde Hero" width="100%" style="border-radius: 40px; margin-bottom: 20px;">
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
  [![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
  [![AlpineJS](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)
  [![Cloudinary](https://img.shields.io/badge/Cloudinary-Integration-3448C5?style=for-the-badge&logo=cloudinary)](https://cloudinary.com)
</div>

---

## ✨ Overview
**EduIde** is a premium, high-performance Learning Management System (LMS) designed with a **Luxury Dark Glassmorphism** aesthetic. It provides a seamless, crystalline interface for students to master future-proof skills and for administrators to manage curriculum with surgical precision.

### 💎 Key Features
-   **Luxury Experience**: Elegant Blue/White/Black color palette with interactive glass effects, micro-animations, and shimmer states.
-   **Intelligent Catalog**: Dynamic course discovery with 16:9 uniform thumbnails and smart category filtering.
-   **Advanced Learning Flow**: Interactive lesson viewer with Plyr integration, scroll progress tracking, and crystal-clear PDF/Video support.
-   **Admin Console 2.0**: Professional dashboard for course CRUD, automated audit logs, and localized PDF/CSV data exports.
-   **Cloud-First Media**: Full Cloudinary integration for lightning-fast asset delivery and automatic image optimization.
-   **Secure Authentication**: Dual-layered auth with standard credentials and Google OAuth 2.0 support.
-   **Smart Notifications**: Custom Alpine.js-powered floating glass toast system for non-intrusive feedback.

---

## 🛠 Tech Stack
-   **Framework**: [Laravel 11.x](https://laravel.com)
-   **Frontend**: [Alpine.js](https://alpinejs.dev) & [Vite](https://vitejs.dev)
-   **Styling**: [Tailwind CSS](https://tailwindcss.com) (Luxury Design Tokens)
-   **Database**: MySQL / PostgreSQL
-   **Storage**: [Cloudinary](https://cloudinary.com) (Images & Videos)
-   **Rendering**: [DomPDF](https://github.com/barryvdh/laravel-dompdf) (Advanced PDF Reporting)
-   **Video**: [Plyr.io](https://plyr.io) (Customized Interactive Player)

---

## 🚀 Installation & Setup

### 1. Zero to One: Clone & Install
```bash
git clone https://github.com/AldiRenaldi19/EduIde-MediaBelajar.git
cd EduIde-MediaBelajar
composer install
npm install
```

### 2. Environment Configuration
Create your environment file and configure your credentials:
```bash
cp .env.example .env
php artisan key:generate
```
> [!IMPORTANT]
> Ensure you configure `CLOUDINARY_CLOUD_NAME`, `GOOGLE_CLIENT_ID`, and your Database credentials in `.env` to enable full functionality.

### 3. Database Initialization
```bash
php artisan migrate --seed
```

### 4. Launch the Ecosystem
Run the development servers:
```bash
# Terminal 1: Frontend Assets
npm run dev

# Terminal 2: PHP Engine
php artisan serve
```

---

## 📜 Audit & Security
-   **Timezone**: Synchronized to `Asia/Jakarta` for real-time reporting.
-   **Sanitization**: All inputs are strictly validated and sanitized to prevent XSS/SQLi.
-   **Privacy**: `.env` is protected via `.gitignore`. Legacy secrets have been purged from history.

## 🤝 Contributing
For significant architecture changes or security disclosures, please open an issue first. We maintain a high standard for UI consistency—ensure all new components adhere to the **Global Glassmorphism Design System**.

## ⚖️ License
Licensed under the [MIT License](LICENSE). 

---

<p align="center">
  Built with ❤️ by <b>EduIde Engineering</b><br>
  <i>"Powering the future of education, one course at a time."</i>
</p>
