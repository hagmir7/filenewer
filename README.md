# Filenewer 🗂️

> **Smarter File Processing** — Convert, compress, generate, and process business documents instantly. No installation. No hassle.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=flat&logo=vite&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green?style=flat)

---

## Table of Contents

- [Overview](#overview)
- [Pages & Features](#pages--features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Tailwind v4 Color System](#tailwind-v4-color-system)
- [Blade Layout System](#blade-layout-system)
- [Deployment](#deployment)
- [Contributing](#contributing)

---

## Overview

Filenewer is a modern SaaS platform offering 50+ free online file tools — PDF converters, image processors, CSV utilities, document generators, and more. The frontend is built with **Laravel 12 Blade**, **Tailwind CSS v4**, and **Vite**, following a clean dark-mode-first design system.

---

## Pages & Features

| Page | Blade View | Description |
|---|---|---|
| Landing | `home.blade.php` | Hero, features, tool cards, security section, CTA |
| Tools List | `tools/index.blade.php` | 54 tools, live search, category sidebar, filters |
| Blog List | `blog/index.blade.php` | Featured post, article grid, newsletter, pagination |
| Blog Detail | `blog/show.blade.php` | Reading progress bar, TOC, prose article, related posts |
| Sign Up | `auth/register.blade.php` | Password strength meter, Google/GitHub OAuth |
| Sign In | `auth/login.blade.php` | Shake error animation, remember me, show/hide password |

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.3) |
| Frontend CSS | Tailwind CSS v4 via `@tailwindcss/vite` |
| Build tool | Vite 6 |
| Fonts | DM Sans + DM Serif Display + DM Mono (Google Fonts) |
| Auth scaffolding | Laravel Breeze (optional) |
| Database | MySQL / PostgreSQL |

---

## Project Structure

```
filenewer/
├── resources/
│   ├── css/
│   │   └── app.css              ← @theme with all fn-* brand colors (oklch)
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── base.blade.php   ← Main layout (nav + footer + @vite)
│       ├── home.blade.php
│       ├── tools/
│       │   └── index.blade.php
│       ├── blog/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       └── auth/
│           ├── login.blade.php
│           └── register.blade.php
├── public/
├── routes/
│   └── web.php
├── vite.config.js               ← @tailwindcss/vite plugin registered
├── package.json
└── composer.json
```

---

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- Node.js 20+
- npm or pnpm

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-org/filenewer.git
cd filenewer

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=filenewer
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Start dev server (runs Vite + Laravel together)
npm run dev
# In a separate terminal:
php artisan serve
```

Visit `http://localhost:8000`

### Build for production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Tailwind v4 Color System

All brand colors are defined in `resources/css/app.css` using **`oklch`** color space. This is required in Tailwind v4 for opacity modifiers like `/30` to work correctly.

```css
/* resources/css/app.css */
@import "tailwindcss";

@theme {
  --font-sans: "DM Sans", sans-serif;
  --font-serif: "DM Serif Display", serif;
  --font-mono: "DM Mono", monospace;

  /* ── Backgrounds ── */
  --color-fn-bg:       oklch(14.5% 0.03  255);   /* #0b0f1a */
  --color-fn-surface:  oklch(18%   0.025 255);   /* #111827 */
  --color-fn-surface2: oklch(21%   0.03  255);   /* #1a2235 */
  --color-fn-surface3: oklch(25%   0.04  255);   /* #1f2d45 */

  /* ── Blues ── */
  --color-fn-blue:     oklch(49%   0.24  264);   /* #2563eb */
  --color-fn-blue-l:   oklch(56%   0.23  264);   /* #3b82f6 */

  /* ── Accents ── */
  --color-fn-cyan:     oklch(68%   0.17  210);   /* #06b6d4 */
  --color-fn-green:    oklch(67%   0.18  162);   /* #10b981 */
  --color-fn-red:      oklch(59%   0.22   27);   /* #ef4444 */
  --color-fn-amber:    oklch(73%   0.17   72);   /* #f59e0b */

  /* ── Text ── */
  --color-fn-text:     oklch(94%   0.015 255);   /* #f1f5f9 */
  --color-fn-text2:    oklch(65%   0.04  255);   /* #94a3b8 */
  --color-fn-text3:    oklch(50%   0.04  255);   /* #64748b */
}
```

### Usage in Blade templates

```html
<!-- Backgrounds -->
<div class="bg-fn-bg">...</div>
<div class="bg-fn-surface">...</div>

<!-- Text -->
<p class="text-fn-text2">Secondary text</p>

<!-- Borders with opacity — works because of oklch ✅ -->
<div class="border border-fn-blue/30">...</div>
<div class="bg-fn-blue/10">...</div>

<!-- Hover states -->
<button class="bg-fn-blue hover:bg-fn-blue-l">Click me</button>
```

> **Why oklch?** Tailwind v4 generates opacity variants (`/30`, `/50`) by reading raw color channels from CSS variables. Hex colors (`#2563eb`) cannot be decomposed this way — `oklch` is Tailwind v4's native color space and the only format that makes opacity modifiers work reliably.
>
> Convert hex → oklch: [oklch.com](https://oklch.com)

---

## Blade Layout System

### `layouts/base.blade.php`

The main layout includes the nav, footer, fonts, and `@vite` directive.

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @yield('meta')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Vite (CSS + JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-fn-bg text-fn-text antialiased">

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
```

### Page template example

```blade
{{-- resources/views/blog/index.blade.php --}}
@extends('layouts.base')

@section('title', 'Blog – Filenewer')
@section('meta')
    <meta name="description" content="Guides and tutorials on file processing.">
@endsection

@section('content')
    {{-- page content here --}}
@endsection
```

---

## `vite.config.js`

```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

> **Note:** There is no `tailwind.config.js` in Tailwind v4. All configuration lives in `resources/css/app.css` inside the `@theme {}` block.

---

## Deployment

### Laravel Forge / shared hosting

```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
php artisan migrate --force
```

### Environment variables (`.env`)

```env
APP_NAME=Filenewer
APP_ENV=production
APP_DEBUG=false
APP_URL=https://filenewer.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=filenewer
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=hello@filenewer.com
MAIL_FROM_NAME="Filenewer"
```

---

## Pages Delivered

All HTML files in this project were designed as standalone prototypes before being converted to Blade templates. The full set of delivered pages:

| File | Description |
|---|---|
| `filenewer-tailwind-v4-fixed.html` | Landing page (Tailwind v4, oklch colors) |
| `signup.html` | Sign up page with password strength meter |
| `login.html` | Login page with error shake animation |
| `blog-list.html` | Blog listing with featured post + newsletter |
| `blog-detail.html` | Article page with reading progress + TOC sidebar |
| `tools-list.html` | Tools directory with live search + category filters |
| `filenewer-theme-v4-fixed.css` | Standalone `@theme` CSS for Tailwind v4 |

---

## Contributing

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/new-tool-page`
3. Commit your changes: `git commit -m 'Add tool detail page'`
4. Push to the branch: `git push origin feature/new-tool-page`
5. Open a Pull Request

---

## License

MIT © 2026 Filenewer. All rights reserved.
