# Role & Context
You are an expert Full-Stack Software Engineer and a high-end UI/UX Designer. Your task is to build a premium, white-label parking management web application named "FastTrack". This is a final vocational competency test (UKK) project designed to profoundly impress the examiners. It must look and feel like a highly polished, commercially viable SaaS product ready to be sold to any enterprise.

## Tech Stack & Environment (STRICT)
- **Environment:** Laravel Herd
- **Backend:** PHP v8.4.20 (Utilize modern PHP 8.4 features/syntax where appropriate), Laravel Framework
- **Node.js:** v22.22.2 (managed via nvm)
- **Frontend:** Livewire Starter Kit, Laravel Volt (Single-file components), TailwindCSS, Alpine.js (for micro-interactions)
- **Database:** SQLite (optimized for rapid development and fast reads)
- **Testing:** PEST Framework

## UI/UX & Design Philosophy (CRITICAL)
- **Aesthetic:** Brand-neutral, highly modern, clean, and universal. Do not use any specific themes, places, or existing brands.
- **Vibe:** Think of top-tier modern developer portfolios or high-end SaaS dashboards (e.g., Vercel, Linear, Stripe). 
- **Interactivity & "Addictive" Feel:** - Prioritize extreme user comfort and flawless responsiveness.
  - Utilize highly interactive, modern cards (e.g., bento-grid layouts for dashboards).
  - Implement butter-smooth hover states, subtle scale transformations, and soft drop-shadow transitions on interactive elements.
  - Use skeleton loaders for data fetching to make the app feel instant.
  - The UI must feel tactile and satisfying to click.

## Architecture & Core Features
1. **Landing Page:** - A breathtaking, modern landing page explaining the "FastTrack" system.
   - **Strict Structure Requirement:** Do NOT include any "Call to Action" (CTA) buttons. The landing page must flow into a clean, presentation-focused closing section designed for a live demo.
   - **Login:** Elegantly integrated directly into the Navbar (no separate routing for a login page to keep the flow uninterrupted).
2. **Modern QR Parking System (Mall-style):**
   - **Gate Masuk (Entry):** Manless kiosk interface. User clicks a prominent, satisfying button -> System generates and displays a ticket with a QR Code.
   - **Gate Keluar (Exit):** Staff/Cashier interface. Staff scans the QR code -> System instantly calculates the fee -> Staff processes the cash payment.
3. **Comprehensive Role Dashboards:** Distinct, fully fleshed-out, data-rich dashboards tailored to each role's specific tasks.

## Database Schema (SQLite Optimized)
Ensure migrations match this structure (Includes standard UKK requirements + modern QR extensions):

1. **tb_kendaraan**
   - id_kendaraan: integer primary key
   - plat_nomor: varchar(15)
   - jenis_kendaraan: enum('motor', 'mobil', 'lainnya')
   - warna: varchar(20)
   - pemilik: varchar(100)

2. **tb_tarif**
   - id_tarif: integer primary key
   - jenis_kendaraan: varchar(20)
   - tarif_per_jam: decimal(10,0)

3. **tb_area_parkir**
   - id_area: integer primary key
   - nama_area: varchar(50)
   - kapasitas: integer
   - terisi: integer

4. **tb_user**
   - id_user: integer primary key
   - nama_lengkap: varchar(50)
   - username: varchar(50)
   - password: varchar(100)
   - role: enum('admin', 'petugas', 'owner')
   - status_aktif: boolean

5. **tb_transaksi**
   - id_parkir: integer primary key
   - kode_qr: varchar(100) unique 
   - id_kendaraan: integer nullable 
   - id_area: integer
   - waktu_masuk: datetime
   - waktu_keluar: datetime nullable
   - id_tarif: integer nullable
   - durasi_jam: integer nullable
   - biaya_total: decimal(10,0) nullable
   - status: enum('masuk', 'keluar')
   - id_user: integer nullable

6. **tb_log_aktivitas**
   - id_log: integer primary key
   - id_user: integer
   - aktivitas: varchar(100)
   - waktu_aktivitas: datetime

## Roles & Feature Access

**1. Admin (System Control)**
- Master Dashboard: visually stunning overview (Stats, user counts, capacity using modern charts/cards).
- CRUD Interfaces (User, Tarif, Area, Kendaraan): Must use modals or slide-overs instead of full page reloads to maintain the "app" feel.
- View Log Aktifitas.

**2. Petugas (Gate Operator)**
- Dashboard heavily optimized for speed and large touch targets.
- **Halaman Gate Masuk:** Kiosk-style UI for generating QR Entry Tickets.
- **Halaman Gate Keluar:** POS-style UI to scan QR, input vehicle details, process cash, and checkout.
- Cetak struk parkir.

**3. Owner (Management Analytics)**
- Executive Dashboard: Focus on beautiful data visualization (Daily revenue, vehicle types).
- Rekap transaksi: Date-filtered report generation.

## Execution Plan (Strict Order)
Write tests using PEST for critical logic before moving to the next step.
1. **Scaffolding:** Setup SQLite, migrations, TailwindCSS, and Livewire Volt using PHP 8.4 and Node 22.
2. **Landing & Auth:** Build the presentation-focused landing page (Navbar login, no CTAs). Setup role-based middleware.
3. **Dashboards & Layouts:** Create the base layouts with modern bento-grid cards and smooth hover animations.
4. **Admin Panel:** Implement CRUDs using Volt. Ensure the UI feels instant.
5. **QR Core Logic:** Implement the QR generation and scanning logic.
6. **Petugas Flow:** Build the "Gate Masuk" and "Gate Keluar" pages prioritizing large, satisfying interactive elements.
7. **Owner Analytics:** Build the reporting dashboard.
8. **UI/UX Polish:** Spend significant time refining animations, hover states, and ensuring zero layout shifts. The application must look perfect for the final presentation.