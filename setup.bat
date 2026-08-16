@echo off
echo Student Talents System Setup
echo ===========================
echo.

echo Creating database file...
php public\create_db.php

echo.
echo Running database migrations...
php public\run_migrations.php

echo.
echo Creating test user...
php public\create_user.php

echo.
echo Setup completed!
echo.
echo To start the development server, run:
echo   php artisan serve
echo.
echo Then open your browser to http://localhost:8000
echo.
echo Default test account:
echo   Email: test@example.com
echo   Password: password
echo.
pause