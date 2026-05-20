# Curated Sanctuary

Laravel + MongoDB storefront for a furniture and interior products platform. The app includes customer registration/login, product browsing, cart, checkout, order history, and an admin portal where products added by admins appear on the storefront.

## Run locally

```bash
composer install
php artisan db:seed
php artisan serve
```

Open:

- Storefront: `http://127.0.0.1:8000`
- Shop: `http://127.0.0.1:8000/shop`
- Product details: `http://127.0.0.1:8000/products/kensho-lounge-chair`
- Login: `http://127.0.0.1:8000/login`
- Admin login: `http://127.0.0.1:8000/adminlogin`
- Cart: `http://127.0.0.1:8000/cart`
- Admin dashboard: `http://127.0.0.1:8000/admin`

Seeded accounts:

- Admin: `admin@example.com` / `password`
- Customer: `customer@example.com` / `password`

## Current structure

- `app/Http/Controllers/StorefrontController.php` handles home, shop, and product detail pages.
- `app/Http/Controllers/AuthController.php` handles customer registration/login/logout.
- `app/Http/Controllers/CartController.php` handles session cart actions.
- `app/Http/Controllers/OrderController.php` creates MongoDB-backed orders.
- `app/Http/Controllers/AdminController.php` handles the admin dashboard.
- `app/Http/Controllers/AdminProductController.php` handles admin product CRUD.
- `app/Models/Product.php`, `app/Models/Order.php`, and `app/Models/User.php` are MongoDB-backed models.
- `app/Support/Catalog.php` contains seed data for the first product collection.
- `resources/views/store` contains storefront Blade views.
- `resources/views/admin/dashboard.blade.php` contains the admin UI.
- `public/css/site.css` contains the design-system implementation.

## MongoDB setup

The project has MongoDB environment values prepared in `.env`:

```env
DB_CONNECTION=mongodb
MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=curated_sanctuary
```

For MongoDB Atlas, replace the local URI with your Atlas connection string:

```env
MONGODB_URI=mongodb+srv://USERNAME:PASSWORD@cluster0.xxxxx.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0
```

Replace `USERNAME`, `PASSWORD`, and the cluster host with your Atlas database user details. The current `.env` in this workspace still points to local MongoDB until you paste your Atlas URI.

This project uses the official `mongodb/laravel-mongodb` package. The local PHP runtime has been configured with `ext-mongodb`, and tests use `curated_sanctuary_test`.

Sessions, cache, and queues are set to file/sync drivers so MongoDB stores application data while framework runtime state stays simple during development.

## Email

Registration OTPs, order status notifications, and delivered-order invoices are sent through Laravel Mail. For inbox delivery, use SMTP values like these in `.env`:

```env
MAIL_MAILER=failover
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD="your-app-password"
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Satya Interiors"
```

For Gmail, enable 2-step verification and create an App Password. Use that app password as `MAIL_PASSWORD`, not your normal Gmail login password. For port `587`, use `MAIL_SCHEME=smtp`; for port `465`, use `MAIL_SCHEME=smtps`. After changing `.env`, run `php artisan config:clear`.

## Test

```bash
php artisan test
```
