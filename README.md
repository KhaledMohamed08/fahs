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
- MySQL or PostgreSQL
- Node.js & NPM (for asset compilation)

## 🚀 Installation

Follow these steps to set up **Fahs** on your local machine:

1. **Clone the repository**
   ```bash
   git clone https://github.com/KhaledMohamed08/fahs.git
   cd fahs
2. **Install PHP dependencies using Composer**
   ```bash
   composer install
3. **Copy the .env file and generate the application key**
   ```bash
   cp .env.example .env
   php artisan key:generate
4. **Set up your database**
   - Open the .env file and configure your database connection:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fahs_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
5. **Run database migrations**
    ```bash
    php artisan migrate
6. **(Optional) Seed the database with sample data**
    ```bash
    php artisan db:seed
7. **Install frontend dependencies**
   ```bash
    npm install
    npm run build
8. **Start the local development server**
   ```bash
    php artisan serve
The application will be available at http://localhost:8000.

## 🧪 Usage

- Foundations can register/login to create and assign assessments.
- Participants access assessments via unique links or codes.
- All responses are submitted and evaluated automatically.
- Results are stored and accessible through the dashboard.

## 📬 Contact

Developed by [Khaled Mohamed Ahmed](https://github.com/KhaledMohamed08)  
For inquiries or contributions, please open an issue or reach out via [GitHub](https://github.com/KhaledMohamed08/fahs).
