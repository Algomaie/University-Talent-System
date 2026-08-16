# University Talent System (UTS) 🎓

A comprehensive platform designed for universities to discover, manage, and nurture student talents through structured competitions and evaluations.

## Features ✨

*   **Role-Based Access Control (RBAC):** Distinct interfaces and permissions for Students, Managers, and Administrators.
*   **Talent Management:** Dynamically create and manage various talent categories (e.g., Coding, Writing, Design).
*   **Competitions:** Managers and Admins can launch competitions with specific start/end dates, target talents, and participant limits.
*   **Submissions:** Students can submit their work (documents, images, videos) to active competitions securely.
*   **Evaluation System:** Managers evaluate student submissions based on structured criteria (Creativity, Technical Skill, Presentation) and nominate top talents.
*   **System Notifications:** Real-time in-app notifications to keep students informed about their submission statuses and competition updates.
*   **Secure Backups:** Admins can securely export and restore database backups directly from the dashboard.
*   **Audit Logging:** Detailed tracking of critical actions (Creates, Updates, Deletes) across the system for accountability.

## Tech Stack 🛠️

*   **Framework:** Laravel 11
*   **Frontend:** Tailwind CSS, Alpine.js, Blade Components
*   **Database:** MySQL
*   **Asset Bundler:** Vite

## Security Enhancements 🛡️

This project has recently undergone a comprehensive security audit and refactoring to ensure production readiness:

*   **Command Injection Prevention:** Safe, PDO-based database export/import (no `shell_exec`).
*   **Insecure Direct Object Reference (IDOR) Protection:** Enforced using strict Laravel Policies.
*   **Mass Assignment Protection:** Implemented using Laravel Form Requests.
*   **Strict File Upload Validation:** Extension blocklists and MIME type verification.
*   **Debug & Stack Trace Protection:** Cleaned routes, removed debug views, and sanitized error reporting for production environments.

## Installation 🚀

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Algomaie/University-Talent-System.git
    cd student_talents_system
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies & compile assets:**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Make sure to configure your database settings in the `.env` file.*

5.  **Run Migrations and Seeders:**
    ```bash
    php artisan migrate --seed
    ```

6.  **Serve the application:**
    ```bash
    php artisan serve
    ```

## License 📄

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
