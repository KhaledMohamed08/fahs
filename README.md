# Fahs – Laravel Assessment Platform

**Fahs** is a powerful Laravel-based platform that enables foundations and organizations to create, manage, and assign online assessments to participants. With support for multiple question types and automated result processing, Fahs streamlines evaluation workflows for education, hiring, and training.

## 🔍 Features

- Foundation/organization user roles
- User-friendly step-based assessment interface
- Supports multiple question types:
  - Multiple choice
  - True/false
  - Free text
- Automatic submission and result evaluation
- Dashboard for managing assessments, users, and results
- Clean, modern UI optimized for all devices

## 📦 Requirements

- PHP >= 8.1
- Composer
- Laravel >= 10
- MySQL or PostgreSQL or SQLite
- Node.js & NPM (for asset compilation)

## 🚀 Installation

Follow these steps to set up **Fahs** on your local machine:

1. **Clone the repository**
    ```bash
    git clone https://github.com/KhaledMohamed08/fahs.git
    cd fahs
    ```

2. **Install PHP dependencies using Composer**
    ```bash
    composer install
    ```

3. **Copy the .env file and generate the application key**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Set up your database**

    Fahs supports **MySQL** (default) and **SQLite**. Choose one of the following:

    <details>
    <summary>🔹 MySQL Configuration (default)</summary>

    1. Create a database in MySQL (e.g., `fahs_db`).
    2. Open the `.env` file and update these lines:
        ```ini
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=fahs_db
        DB_USERNAME=root
        DB_PASSWORD=your_password
        ```
    </details>

    <details>
    <summary>🔹 SQLite Configuration (alternative)</summary>

    1. Create a new SQLite database file:
        ```bash
        touch database/database.sqlite
        ```

    2. Open the `.env` file and update these lines:
        ```ini
        DB_CONNECTION=sqlite
        DB_DATABASE=${DB_DATABASE_PATH}/database/database.sqlite
        ```
       **Note:** If the variable ${DB_DATABASE_PATH} doesn't work, replace it with the full path to the file.
       
       **Tip:** To get the absolute path, run `pwd` in your project directory and append `/database/database.sqlite`.  
            Then update your `.env` file as follows:
    </details>

5. **Run database migrations**
    ```bash
    php artisan migrate
    ```

6. **(Optional) Seed the database with sample data**
    ```bash
    php artisan db:seed
    ```

7. **Install frontend dependencies**
    ```bash
    npm install
    npm run build
    ```

8. **Start the local development server**
    ```bash
    php artisan serve
    ```
    The application will be available at [http://localhost:8000](http://localhost:8000).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
