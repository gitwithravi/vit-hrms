# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**LiteHRM** — a self-hosted Human Resource Management System built with Laravel 10 (backend API) and Vue.js 3 (SPA frontend). The two entry points are built and served separately (`app` for the HR application, `site` for the marketing/landing site).

## Common Commands

### PHP / Laravel
```bash
php artisan serve              # Start dev server
php artisan migrate            # Run database migrations
php artisan db:seed            # Seed database
php artisan horizon            # Start queue worker (Horizon)
php artisan test               # Run all tests (Pest)
php artisan test tests/Feature/SomeTest.php  # Run single test file
./vendor/bin/pest              # Run tests via Pest directly
./vendor/bin/pest --filter "test name"       # Run single test by name
```

### Frontend (Vite + Vue 3)
```bash
npm run dev         # Dev mode (both app + site, with HMR)
npm run dev-app     # Dev mode for app only
npm run dev-site    # Dev mode for site only
npm run prod        # Production build (both)
npm run prod-app    # Production build for app only
npm run prod-site   # Production build for site only
```

## Architecture

### Backend (Laravel 10)

**Route namespacing** (`app/Providers/RouteServiceProvider.php`):
- `/api/v1/auth/*` — unauthenticated auth endpoints
- `/api/v1/app/*` — protected endpoints (Sanctum + permissions middleware)
- `/api/v1/api/*` — limited public endpoints (Config, Timesheet)
- Modular routes loaded from `routes/modules/*.php`

**Middleware chain on protected routes:**
`auth:sanctum` → `user.config` → `option.verifier` → `under.maintenance` → `xss.protection` → route-level permission gates

**Key patterns:**
- Controllers in `app/Http/Controllers/` organized by domain (Auth, Company, Employee, Attendance, Leave, Payroll, Finance, Task, Config, Team, Utility, Calendar)
- Business logic extracted into **Action classes** (`app/Actions/`) — e.g., `ValidateRole`, `SendMailTemplate`, `GetNextRepeatDate`
- Authorization via **Policies** (`app/Policies/`) and Spatie Permission role/permission strings
- 52+ Eloquent models covering: User/Team, Employee, Payroll (PayHead, SalaryTemplate, Salary), Attendance (WorkShift, Timesheet), Leave (Allocation, Request), Finance (Ledger, Transaction), Tasks

**Auth:** Laravel Sanctum (stateful for SPA + token for API). Two-factor auth and screen-lock middleware exist. SSO via Laravel Socialite (Microsoft OAuth).

### Frontend (Vue 3 + Vuex + Vue Router)

```
resources/js/
├── app.js / site.js        # Entry points
├── core/
│   ├── apis/               # Axios-based API client modules
│   ├── composables/        # Vue 3 composables
│   └── utils/              # Utility helpers
├── routes/modules/         # Feature-scoped route definitions (60+ files)
├── stores/modules/         # Vuex 4 feature modules (23 modules)
├── repositories/           # API communication layer (called by stores/components)
├── views/Modules/          # Feature page components
└── components/             # Reusable UI components
```

**Data flow:** Components → Repositories (Axios calls) → Laravel API → Eloquent Models

**Build config:** Two independent Vite configs (`vite.app.config.js`, `vite.site.config.js`) with corresponding Tailwind configs (`tailwind.app.config.js`, `tailwind.site.config.js`).

### Testing

Pest 2 is the test runner. Tests live in `tests/Feature/` and `tests/Unit/`. Global helpers in `tests/Pest.php`:
- `createUser()` — creates a user with the `user` role
- `login(User $user)` — authenticates as that user

Tests use `LazilyRefreshDatabase` (fresh DB per test, lazy migration).

### Key Packages

| Package | Purpose |
|---|---|
| Spatie Permission | RBAC (roles + permissions on all protected routes) |
| Spatie Activity Log | Audit trail |
| Laravel Horizon | Redis-based queue management |
| Laravel Sanctum | SPA + token auth |
| Laravel Folio | File-based page routing (site) |
| Livewire 3 | Some server-rendered interactive components |
| mPDF | PDF generation |
| Maatwebsite/Excel | Excel import/export |
| Intervention Image | Image processing |
| Pusher | Real-time broadcasting |

## Environment

- Database: MySQL (`DB_DATABASE=lite_hrm_vit`)
- Queue: `sync` by default (switch to `redis` for Horizon)
- Cache/Session: `file` driver
- Broadcasting: `log` by default (configure Pusher keys for real-time)
- Storage: local by default (S3 supported)
- `SANCTUM_STATEFUL_DOMAINS` must include the frontend domain for cookie auth
