# Laravel 12 – Roles & Permissions

This project is a Laravel 12 application that implements **Role-Based Access Control (RBAC)** using the **Spatie Laravel Permission** package. It includes full CRUD for **Users, Roles, and Products** with permissions.

---

## 🚀 Features

- Laravel 12
- Spatie Roles & Permissions
- User Management (CRUD)
- Role Management (CRUD)
- Product Management (CRUD)
- Authentication (Login/Register)
- Permission-based Access Control

---
📸 Project Screenshots

<img width="1739" height="585" alt="image" src="https://github.com/user-attachments/assets/3d71bc9d-7ca3-4f09-994c-a6d3ca6c541a" />
<img width="1779" height="649" alt="image" src="https://github.com/user-attachments/assets/db96241b-8df1-42c3-9a2f-efd5f37592dd" />
<img width="1735" height="459" alt="image" src="https://github.com/user-attachments/assets/6c4b42d8-9047-4db1-bcf9-97587f655e78" />
<img width="1701" height="461" alt="image" src="https://github.com/user-attachments/assets/492be21b-50df-402d-a439-730ff0cd49bb" />


## 📦 Installation

Clone the repository:

```bash
git clone https://github.com/yourusername/laravel-roles-permissions.git
cd laravel-roles-permissions


Install dependencies:

composer install
npm install


Copy .env file:

cp .env.example .env


Generate application key:

php artisan key:generate

⚙️ Environment Configuration

Update your .env file with database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=roles_permissions
DB_USERNAME=root
DB_PASSWORD=

🛠️ Setup Steps

Install Spatie Permission package:

composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"


Run migrations:

php artisan migrate


Install Laravel UI authentication:

composer require laravel/ui
php artisan ui bootstrap --auth
npm run build

🌱 Database Seeding

Run these seeders to create roles, permissions, and admin user:

php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=CreateAdminUserSeeder

Default Admin Login
Email: admin@gmail.com
Password: 123456

▶️ Run the Application
php artisan serve


Open in browser:

http://localhost:8000

📁 Project Structure
app/
 ├── Http/Controllers/
 │   ├── UserController.php
 │   ├── RoleController.php
 │   └── ProductController.php
 ├── Models/
 │   ├── User.php
 │   └── Product.php

resources/
 └── views/
     ├── users/
     ├── roles/
     └── products/




