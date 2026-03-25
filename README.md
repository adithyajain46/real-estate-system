# Real Estate CRM System

A web-based CRM/ERP system for managing real estate operations built with Laravel, Bootstrap, and MySQL.

## Features
- User Authentication (Login / Logout / Register)
- Dashboard with analytics overview
- Property Management (Add / Edit / Delete / Search)
- Client Management
- Reports and Analytics
- Notifications System

## Tech Stack
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Backend:** Laravel 10
- **Database:** MySQL
- **Tools:** Composer, Artisan CLI

## Installation

```bash
git clone https://github.com/adithyajain46/real-estate-crm.git
cd real-estate-crm
composer install
cp .env.example .env
php artisan key:generate
# Set DB credentials in .env
php artisan migrate
php artisan db:seed
php artisan serve
```

## Modules
1. **Authentication** - Secure login/register with Laravel Auth
2. **Dashboard** - Overview cards showing total properties, clients, revenue
3. **Properties** - Full CRUD with search and filter
4. **Clients** - Manage buyer/seller information
5. **Reports** - Analytics with charts
6. **Notifications** - System alerts for new leads

## Developer
Adithya Jain | adithyajain121@gmail.com | github.com/adithyajain46
