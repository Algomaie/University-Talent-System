# University Talent System (UTS) 🎓

A comprehensive platform designed for universities to discover, manage, and nurture student talents through structured competitions and evaluations.

---

## Screenshots 📸

*(Placeholder for screenshots - Add your actual image paths here)*

| Student Dashboard | Manager Dashboard | Admin Panel |
| :---: | :---: | :---: |
| ![Student Dashboard](https://via.placeholder.com/400x250?text=Student+Dashboard) | ![Manager Dashboard](https://via.placeholder.com/400x250?text=Manager+Dashboard) | ![Admin Panel](https://via.placeholder.com/400x250?text=Admin+Panel) |

---

## Features ✨

*   **Role-Based Access Control (RBAC):** Distinct interfaces and permissions for Students, Managers, and Administrators.
*   **Talent Management:** Dynamically create and manage various talent categories (e.g., Coding, Writing, Design).
*   **Competitions:** Managers and Admins can launch competitions with specific start/end dates, target talents, and participant limits.
*   **Submissions:** Students can submit their work (documents, images, videos) to active competitions securely.
*   **Evaluation System:** Managers evaluate student submissions based on structured criteria (Creativity, Technical Skill, Presentation) and nominate top talents.
*   **System Notifications:** Real-time in-app notifications to keep students informed about their submission statuses and competition updates.
*   **Secure Backups:** Admins can securely export and restore database backups directly from the dashboard.
*   **Audit Logging:** Detailed tracking of critical actions (Creates, Updates, Deletes) across the system for accountability.

---

## Tech Stack 🛠️

*   **Framework:** Laravel 11
*   **Frontend:** Tailwind CSS, Alpine.js, Blade Components
*   **Database:** MySQL
*   **Asset Bundler:** Vite
*   **Authentication:** Laravel Breeze / Session-based Auth

---

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

---

## Database Setup 🗄️

1. Create a MySQL database for the project (e.g., `university_talents`).
2. Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=university_talents
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Run the migrations and seeders to set up the tables and default roles:
   ```bash
   php artisan migrate --seed
   ```
4. **Serve the application:**
   ```bash
   php artisan serve
   ```

---

## Authentication / Roles 🔐

The system uses three primary roles:

1.  **Admin (`admin`):**
    *   Full system access.
    *   Manage users, talents, and overall system settings.
    *   Access audit logs and perform database backups.
2.  **Manager (`manager`):**
    *   Create and manage competitions.
    *   Review and evaluate student submissions.
    *   Nominate top talents within their competitions.
3.  **Student (`student`):**
    *   Browse active competitions.
    *   Submit entries and track evaluation progress.
    *   View their own notifications and results.

> Access control is strictly enforced using standard Laravel Policies (`CompetitionPolicy`, `SubmissionPolicy`, `EvaluationPolicy`) to prevent IDOR vulnerabilities.

---

## API Documentation 📡

The application exposes internal APIs used via AJAX, protected under the `api` middleware.

| Endpoint | Method | Description |
| :--- | :---: | :--- |
| `/api/notifications/unread-count` | `GET` | Fetches the number of unread notifications for the authenticated user. |
| `/api/notifications/mark-read` | `POST` | Marks all notifications as read. |
| `/api/talents/active` | `GET` | Retrieves a list of all active talents available for competitions. |

*(All endpoints require the user to be authenticated and maintain a valid session).*

---

## Security 🛡️

This application implements several layers of security to protect data and server integrity:

*   **Command Injection Prevention:** Uses pure `PDO` PHP data objects for database backups instead of vulnerable system calls like `shell_exec()`.
*   **Mass Assignment Protection:** Uses explicit Laravel `FormRequest` validation classes to extract `$request->validated()` data exclusively.
*   **IDOR Protection:** Uses Laravel Policies to ensure users (Students/Managers) can only interact with IDs/resources that belong to them.
*   **File Upload Validation:** The custom `FileUploadService` verifies MIME types and blocks execution file extensions (`php`, `exe`, `bat`, `sh`) from being uploaded to the server.
*   **Environment Safety:** Debug routes have been removed, `.env` files are globally ignored, and errors are sanitized from production exposure.

---
## License 📄

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
