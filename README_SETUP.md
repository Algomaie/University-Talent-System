# Student Talents System - Setup Instructions

This document provides instructions for setting up and running the Student Talents System.

## Prerequisites

Before you begin, make sure you have the following installed:
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite (usually comes with PHP)

## Setup Steps

### 1. Install PHP Dependencies

```bash
composer install
```

If you don't have composer installed, download it from https://getcomposer.org/

### 2. Install JavaScript Dependencies

```bash
npm install
```

### 3. Create Database File

You can either run:
```bash
php public/create_db.php
```

Or manually create the file:
```bash
touch database/database.sqlite
```

### 4. Run Database Migrations

```bash
php artisan migrate
```

Or use our helper script:
```bash
php public/run_migrations.php
```

### 5. (Optional) Seed the Database

```bash
php artisan db:seed
```

This will populate the database with sample data including:
- User accounts (admin, managers, students)
- Talent categories
- Sample competitions

### 6. Build Frontend Assets

```bash
npm run build
```

### 7. Start the Development Server

```bash
php artisan serve
```

The application will be available at http://localhost:8000

## Creating Test Users

### Using the Helper Script

```bash
php public/create_user.php
```

### Using Artisan Commands

If you want to create users via command line:

```bash
php artisan user:create "John Doe" john@example.com password student
```

### Using the Web Interface

1. Navigate to http://localhost:8000/register
2. Fill in the registration form
3. Submit to create a new account

## Default Test Accounts

After seeding the database, you can use these accounts:

### Administrator
- Email: admin@university.edu
- Password: password

### Manager
- Email: manager1@university.edu
- Password: password

### Student
- Email: sara@student.university.edu
- Password: password

## Troubleshooting

### Database Issues

If you encounter database errors:
1. Make sure `database/database.sqlite` file exists
2. Ensure the database directory is writable
3. Run migrations: `php artisan migrate`

### Design Issues (TailwindCSS not working)

If the design looks plain or broken:
1. Make sure you ran `npm install`
2. Run `npm run build` to compile the assets
3. Check that `public/css/app.css` and `public/js/app.js` exist

### Permission Issues

If you get permission errors:
1. Make sure the storage directory is writable:
   ```bash
   chmod -R 775 storage
   ```
2. Make sure the bootstrap/cache directory is writable:
   ```bash
   chmod -R 775 bootstrap/cache
   ```

## Development Commands

### Run Development Server with Hot Reloading

```bash
npm run dev
```

### Run Tests

```bash
composer test
```

### Code Formatting

```bash
./vendor/bin/pint
```

## Security Note

For production deployment:
1. Change the APP_KEY in .env
2. Use a proper database (MySQL/PostgreSQL) instead of SQLite
3. Set APP_ENV=production and APP_DEBUG=false
4. Configure proper file permissions
5. Use a proper web server (Apache/Nginx) instead of PHP's built-in server