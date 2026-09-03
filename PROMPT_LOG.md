# Parel-Portfolio - Prompt Log

A record of all prompts used to build and maintain the Parel-Portfolio project.

---

## 1. Initial Portfolio Build

Build a modern, creative single-page portfolio website for Kirby Duane King S. Parel, styled with a striking Electric Blue and Vibrant Purple dual-accent color palette, display typography, elegant spacing, light/dark mode toggling, and interactive modal viewports for both Projects and Certificates.

**IMPORTANT INSTRUCTIONS:**

### 1. Personal Profile & Core Data

- **Full Name:** Kirby Duane King S. Parel
- **Contact Info:** 09495909683
- **Bio / Motto:** "Don't Chase Success, Let the Success Chase you"
- **Educational Background:**
  - College: Data Center College of the Philippines - Bangued (2026-Present)
  - High School: Abra State Institute of Science and Technology - Bangued (2022-2023)

### 2. Color Palette & Visual Design (Blue & Purple Theme)

- **Primary Accent Palette:**
  - Electric Blue: `#3b82f6` / `#60a5fa` (Buttons, key highlights, active nav indicators)
  - Vibrant Purple / Violet: `#8b5cf6` / `#a855f7` (Gradients, badges, glowing borders, hero text accents)
  - Blue-to-Purple Gradient: `bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600`

- **Light Mode & Dark Mode Styling:**
  - **Dark Theme (Default):** Deep Midnight Navy/Slate background (`#0b0f19` / `#0f172a`), semi-transparent glassmorphism cards (`rgba(15, 23, 42, 0.75)` with `backdrop-blur-md` and subtle purple/blue border outlines `border-purple-500/20`), crisp white headings (`#f8fafc`), and ambient blue/purple background radial glows.
  - **Light Theme:** Soft off-white backdrop (`#f8fafc`), pure white glass cards (`rgba(255, 255, 255, 0.9)` with soft purple/blue shadows), deep slate text (`#0f172a`), and rich cobalt blue and royal purple accents.

- **Typography & Layout:**
  - Display Headings: Stylish, high-impact display font (e.g., Syne, Cabinet Grotesk, or Clash Display) for major titles and name callouts.
  - Body Text: Clean sans-serif font (e.g., Plus Jakarta Sans, Inter, or Outfit) with comfortable line-height and generous spacing.
  - Hero Canvas: Low-density interactive particle/network background in the hero section that reacts gently to cursor hover, rendered in glowing blue and purple nodes.

### 3. Navigation & Theme Controls

- **Fixed Top Navigation Bar:**
  - Logo / Brand: "KIRBY PAREL" (styled with a subtle blue-to-purple text gradient).
  - Navigation Links: [Home] -> [About] -> [Skills] -> [Projects] -> [Education] -> [Contact].
  - Theme Toggle: Sun/Moon icon toggle button in the navbar saving the theme state ('light' or 'dark') to `localStorage` and checking system preferences (`prefers-color-scheme`).
  - Features: Native smooth scrolling (`scroll-behavior: smooth`), Intersection Observer active link highlighting, and a mobile hamburger menu.

### 4. Typography Scaling & Sizing Adjustments

- **Enlarged Display Headings:**
  - Hero Header / Name Callout: Scale up to `text-5xl md:text-7xl lg:text-8xl` with `font-black` display typography (e.g., Syne, Cabinet Grotesk, or Clash Display) to create immediate visual impact.
  - Section Titles (#about, #skills, #projects, #education, #contact): Increase heading size to `text-3xl md:text-5xl` with dynamic blue-to-purple gradient text fill.
  - Card Titles & Modal Headers: Enlarge to `text-xl md:text-2xl` for bold legibility.

- **Fluid Responsive Fitting & Container Containment:**
  - Apply responsive dynamic sizing (`clamp()`, `min-vw`, or Tailwind responsive breakpoints `sm:`, `md:`, `lg:`) to ensure text perfectly scales without wrapping awkwardly or breaking layout boundaries.
  - Set explicit word-wrapping (`break-words` or `overflow-wrap: anywhere`) on long text blocks and titles so text stays strictly contained within card containers, lightboxes, and mobile viewports with zero horizontal overflow.

- **Body & Supporting Text:**
  - Body Copy: Increase default reading size to `text-base md:text-lg` using a clean sans-serif (e.g., Plus Jakarta Sans, Inter, or Outfit) with relaxed line-height (`leading-relaxed`) and comfortable tracking.

### 5. Color Palette & Visual Design (Blue & Purple Theme)

- **Primary Accent Palette:**
  - Electric Blue: `#3b82f6` / `#60a5fa` (Buttons, key highlights, active nav indicators)
  - Vibrant Purple / Violet: `#8b5cf6` / `#a855f7` (Gradients, badges, glowing borders, hero text accents)
  - Blue-to-Purple Gradient: `bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600`

- **Light Mode & Dark Mode Styling:**
  - **Dark Theme (Default):** Deep Midnight Navy/Slate background (`#0b0f19` / `#0f172a`), semi-transparent glassmorphism cards (`rgba(15, 23, 42, 0.75)` with `backdrop-blur-md` and subtle purple/blue border outlines `border-purple-500/20`), crisp white headings (`#f8fafc`), and ambient blue/purple background radial glows.
  - **Light Theme:** Soft off-white backdrop (`#f8fafc`), pure white glass cards (`rgba(255, 255, 255, 0.9)` with soft purple/blue shadows), deep slate text (`#0f172a`), and rich cobalt blue and royal purple accents.
  - **Hero Canvas:** Low-density interactive particle/network background in the hero section reacting gently to cursor movement, rendered with glowing blue and purple nodes.

### 6. Navigation & Theme Controls

- **Fixed Top Navigation Bar:**
  - Logo / Brand: "KIRBY PAREL" (styled with a subtle blue-to-purple text gradient, enlarged to `text-xl md:text-2xl font-extrabold`).
  - Navigation Links: [Home] -> [About] -> [Skills] -> [Projects] -> [Education] -> [Contact].
  - Theme Toggle: Sun/Moon icon toggle button in the navbar saving choice ('light' or 'dark') to `localStorage` and checking `prefers-color-scheme`.
  - Features: Native smooth scrolling (`scroll-behavior: smooth`), Intersection Observer active link highlighting, and a mobile hamburger menu.

---

## 2. Fix Secondary School Name

Why is my secondary still Our Lady of Fatima? Change it to Abra State Institute of Science and Technology-Bangued.

**Resolution:** Updated `database/seeders/PortfolioSeeder.php` (line 112) to use the correct school name. Re-seeded the database with `php artisan migrate:fresh --seed`.

---

## 3. Fix Missing Sessions Migration

After running `php artisan migrate:fresh --seed`, the following error appeared:

```
Illuminate\Database\QueryException
SQLSTATE[HY000]: General error: 1 no such table: sessions (Connection: sqlite)
```

**Resolution:** Created `database/migrations/0001_01_01_000002_create_sessions_table.php` since `SESSION_DRIVER=database` was set in `.env` but the sessions table migration was missing.
