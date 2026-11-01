# orderby

سیستم مدیریت سفارش‌ها، ساخته‌شده با Laravel.

## پیش‌نیازها

- PHP 8.2 یا بالاتر
- Composer
- MySQL 8 (یا MariaDB)
- Redis (روی ویندوز: Memurai یا Laragon)
- Git

## راه‌اندازی

bash
git clone <آدرس-ریپو> orderby
cd orderby
composer install
cp .env.example .env
php artisan key:generate
بعد در MySQL یک دیتابیس با نام orderby بسازید (collation: `utf8mb4_unicode_ci`):

sql
CREATE DATABASE orderby CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
سپس مقادیر DB_USERNAME و DB_PASSWORD را در .env با تنظیمات خودتان یکی کنید، مطمئن شوید Redis روشن است (`redis-cli ping` باید PONG بدهد) و اجرا کنید:

bash
php artisan migrate
php artisan serve
برنامه روی http://127.0.0.1:8000 بالا می‌آید.

## ساختار پوشه‌ها

| پوشه | نقش |
|---|---|
| app | کد اصلی برنامه: مدل‌ها، کنترلرها، سرویس‌ها |
| routes | تعریف مسیرها (`web.php`، `console.php`) |
| config | فایل‌های تنظیمات که مقدارشان را از .env می‌گیرند |
| database | migrationها، seederها و factoryها |
| bootstrap | راه‌اندازی فریم‌ورک و کش بوت‌استرپ |

## نکات

- فایل .env نباید در Git باشد؛ فقط .env.example commit می‌شود.
- اتصال Redis با predis است (نیازی به اکستنشن PHP نیست).