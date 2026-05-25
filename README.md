# Optimum Inventory Control of Machine Spares

A full-stack industrial inventory management system built using Laravel 12.

## Features
- Multi-role authentication
- Stock In / Stock Out transactions
- Low stock alerts
- PDF & CSV exports
- Dashboard analytics
- Machine-wise spare tracking
- Role-based authorization
- Modern dark UI

## Tech Stack
- Laravel 12
- PHP 8.2
- MySQL
- Tailwind CSS
- Blade
- JavaScript

## Roles
- Admin
- Manager
- Staff

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
