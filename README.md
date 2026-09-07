# JM PADDY — Paddy & Farmer Bill Management System

A responsive PHP + MySQL web application based on the JM PADDY Visual Design Report.

## Included
- Secure staff login with session authentication
- Dashboard: farmers, bills, weight and payment totals
- Farmer CRUD and search
- Bill creation with district-based sack weight rules
- Automatic sack count, net weight and payment calculations
- Bill preview, browser print / Save as PDF, and WhatsApp sharing
- Daily/monthly reports with Chart.js
- Settings for district sack weights
- Responsive agricultural-themed UI
- MySQL schema + seed/demo data

## Stack
- PHP 8+
- MySQL 8+ / MariaDB 10+
- HTML5, CSS3, vanilla JavaScript
- Chart.js via CDN

## Quick start (XAMPP)
1. Copy the `jm-paddy` folder into `htdocs`.
2. Create a MySQL database named `jm_paddy`.
3. Import `sql/schema.sql`.
4. Edit `config/config.php` with your MySQL credentials.
5. Open `http://localhost/jm-paddy/`.
6. Demo login: **admin** / **admin123**

## Calculation rule
The app follows the report's sample logic: sack count is the whole-sack portion of gross weight (`floor(gross / sack_weight)`), sack weight is `sacks × configured sack weight`, and net/remainder weight is `gross - sack_total`. Payment follows the report's sample bill and is calculated from gross weight × price per kg.

District defaults from the report:
- Vavuniya: 72 kg
- Mullaitivu: 73 kg
- Mannar: 73 kg
- Kilinochchi: 73 kg
- Jaffna: 73 kg

## GitHub
This folder is already organized as a Git repository-ready project. After adding it to Git:

```bash
git init
git add .
git commit -m "Initial JM PADDY system"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/jm-paddy.git
git push -u origin main
```

Do not commit real passwords or production database credentials.

## Production notes
- Change the default admin password immediately.
- Put secrets in environment variables.
- Enable HTTPS.
- Add CSRF protection and stronger role-based permissions before production use.
