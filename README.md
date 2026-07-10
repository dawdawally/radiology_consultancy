# MedRad Technical Consultancy Website

A professional, CMS-driven consultancy website for radiation equipment installation, commissioning, training, and regulatory compliance. Built with PHP 8, MySQL, and Bootstrap 5.

## Features

- **Public website** — Home, About, Services (11 detail pages), Equipment, Blog, Case Studies, Contact, Privacy, Terms
- **Admin dashboard** — Full CRUD for all content without touching code
- **Seed content** — Real consultancy copy based on business requirements (uses "we" voice throughout)
- **Security** — PDO prepared statements, CSRF protection, password hashing, session auth

## Requirements

- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.3+
- Apache with `mod_rewrite` enabled

## Local Setup

1. **Copy local configuration**
   ```bash
   cp includes/config/config.example.php includes/config/config.local.php
   ```
   Production uses a separate `config.production.php` on the server (see DEPLOY.md).

2. **Create the database and seed content**
   ```bash
   php database/install.php
   ```

3. **Configure Apache** to point to this folder, or use PHP built-in server (routing limited):
   ```bash
   php -S localhost:8000
   ```
   For clean URLs, use Apache/XAMPP/WAMP with the included `.htaccess`.

4. **Adjust RewriteBase** in `.htaccess` if your project is not at `/biomedical_consultancy/`.

## Admin Access

- URL: `/admin/` or `/admin/login.php`
- Username: `admin`
- Password: `Admin@123456`

Change the password immediately after first login via **Profile** in the admin dashboard.

## Hostinger Deployment

**Domain:** https://radiationequipmentconsultancy.com

See **[DEPLOY.md](DEPLOY.md)** for the full step-by-step Hostinger deployment guide.

Quick summary:
1. Upload code to `public_html`
2. Upload production `config.production.php` with Hostinger DB credentials
3. Use `.htaccess.production` on the server (domain root + HTTPS)
4. Run `APP_ENV=production php database/install.php` via SSH, then delete installer
5. Enable SSL, change admin password, update Settings

## Project Structure

```
admin/              Admin dashboard entry points
assets/             CSS, JS, images
database/           Schema, seed data, installer
includes/           PHP core (models, controllers, views, config)
uploads/            User-uploaded media
index.php           Public site front controller
.htaccess           URL rewriting
```

## Content Management

All business content is stored in MySQL and editable via the admin panel:

| Module | Manages |
|--------|---------|
| Homepage | Hero, about preview, services intro, why choose us, process, CTA |
| About | Bio, qualifications, certifications, safety philosophy, team |
| Services | 11 service pages with full detail structure |
| Equipment | Equipment expertise by category |
| Blog | Articles and categories |
| Testimonials | Case studies and client quotes |
| Messages | Contact form inbox |
| SEO | Per-page meta titles and descriptions |
| Settings | Contact info, footer, privacy, terms |

## License

Proprietary — MedRad Technical Consultancy
