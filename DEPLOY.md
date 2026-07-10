# Deployment Guide — radiationequipmentconsultancy.com

## Prerequisites

- Domain: **radiationequipmentconsultancy.com** (purchased)
- Hostinger hosting with PHP 8.1+, MySQL, Apache, SSL
- Code from: https://github.com/dawdawally/radiology_consultancy

---

## Step 1 — Hostinger: Create MySQL database

1. Log in to **hPanel** → **Databases** → **MySQL Databases**
2. Create a new database (note the full name, e.g. `u123456789_rec`)
3. Create a database user with a **strong password**
4. Assign the user to the database with **All Privileges**
5. Save these four values:
   - Database name
   - Database user
   - Database password
   - Host (usually `localhost`)

---

## Step 2 — Hostinger: Point domain to hosting

1. **Websites** → select **radiationequipmentconsultancy.com**
2. Document root should be `public_html`
3. **SSL** → install free SSL certificate
4. Enable **Force HTTPS** when available

---

## Step 3 — Upload code

### Verify these static files exist on the server

After upload, confirm these URLs open in your browser (not 404):

- `https://radiationequipmentconsultancy.com/assets/images/rmc_logo.png` ← **logo & favicon**
- `https://radiationequipmentconsultancy.com/assets/css/style.css`
- `https://radiationequipmentconsultancy.com/admin/dashboard.php` ← **admin dashboard** (required; login alone is not enough)

The logo must be at `public_html/assets/images/rmc_logo.png`.  
The copy at the project root (`rmc_logo.png`) is **not** used by the website.

### Admin folder — all three PHP files are required

The `admin/` folder on the server must contain:

| File | Role |
|------|------|
| `admin/login.php` | Sign-in page |
| `admin/dashboard.php` | **Main admin app** (homepage editor, services, etc.) |
| `admin/logout.php` | Sign out |

If `dashboard.php` is missing, `/admin/index.php` shows the public site’s “Page Not Found” (the request is routed through the main `index.php`). Upload `dashboard.php` from your project to `public_html/admin/dashboard.php`.

### Via Git (SSH)

```bash
cd ~/domains/radiationequipmentconsultancy.com/public_html
git clone https://github.com/dawdawally/radiology_consultancy.git .
```

### Via File Manager

Upload all project files into `public_html`.

---

## Step 4 — Production configuration

Upload `includes/config/config.production.php` to the server with your Hostinger credentials.

`config.php` (committed, no secrets) auto-loads:
- `config.production.php` on **radiationequipmentconsultancy.com**
- `config.local.php` on **localhost**

Production `config.production.php` should contain:

```php
'app_url' => 'https://radiationequipmentconsultancy.com',
'debug' => false,
'db' => [
    'host' => 'localhost',
    'name' => 'u207420275_prod_db',
    'user' => 'u207420275_prod_admin',
    'pass' => 'your-database-password',
],
```

This file is gitignored — upload via FTP/File Manager.

---

## Step 5 — Apache rewrite rules

The main `.htaccess` is already configured for production (`RewriteBase /`, HTTPS redirect).

For **local XAMPP** development, swap back to the local version:

```bash
cp .htaccess.local .htaccess
```

---

## Step 6 — Folder permissions

```bash
chmod 755 uploads
```

---

## Step 7 — Install database

Run **once** via SSH (set production mode for CLI):

```bash
APP_ENV=production php database/install.php
```

On Hostinger shared hosting, the database must already exist in hPanel. The installer uses the database name from `config.production.php` and does not create `medrad_consultancy`.

Then **delete the installer** (recommended):

```bash
rm database/install.php database/reseed_equipment.php
```

> `database/.htaccess` already blocks web access to this folder as a backup.

---

## Step 8 — Post-install security

1. Visit **https://radiationequipmentconsultancy.com/admin/login.php**
2. Log in: `admin` / `Admin@123456`
3. Go to **Profile** → change password immediately
4. Go to **Settings** → verify email, phone, address, LinkedIn
5. Go to **SEO** → review all page meta titles

---

## Step 9 — Email setup (Hostinger)

Create these mailboxes in hPanel → **Emails**:

| Address | Purpose |
|---------|---------|
| `info@radiationequipmentconsultancy.com` | Contact form notifications, public contact |
| `noreply@radiationequipmentconsultancy.com` | System / form sender |

Test the contact form at `/contact`. If `mail()` does not deliver, configure SMTP in Hostinger and update the app mail layer.

---

## Step 10 — Smoke test

| URL | Expected |
|-----|----------|
| https://radiationequipmentconsultancy.com/ | Homepage loads |
| https://radiationequipmentconsultancy.com/services | Services list |
| https://radiationequipmentconsultancy.com/contact | Contact form works |
| https://radiationequipmentconsultancy.com/admin/dashboard.php | Admin dashboard (login required) |

---

## Local development

```bash
cp includes/config/config.example.php includes/config/config.local.php
```

`config.php` detects `localhost` and loads `config.local.php` automatically.

For XAMPP subdirectory routing, use `.htaccess` as committed (RewriteBase `/biomedical_consultancy/`).

On the server, replace `.htaccess` with `.htaccess.production` for domain root + HTTPS.

---

## Files reference

| File | Purpose |
|------|---------|
| `includes/config/config.example.php` | Local dev config template |
| `.htaccess.production` | Apache rules for domain root + HTTPS (reference) |
| `.htaccess.local` | Apache rules for local XAMPP subdirectory |
| `database/.htaccess` | Blocks web access to DB scripts |
| `includes/config/.htaccess` | Blocks web access to config folder |
