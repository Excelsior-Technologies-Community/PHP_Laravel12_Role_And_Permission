# PHP_Laravel12_Role_And_Permission

A complete **Laravel 12** application implementing **Role-Based Access Control (RBAC)** using the **Spatie Laravel Permission** package. This project includes full CRUD functionality for **Users, Roles, and Products**, along with authentication and permission-based access restrictions.

---

## Project Overview

This repository demonstrates how to build a secure and scalable RBAC system in Laravel 12. It is designed to help developers understand:

* How to manage roles and permissions using Spatie
* How to restrict access based on user roles
* How to build CRUD modules protected by permissions
* How authentication and authorization work together in Laravel

This project is suitable for:

* MCA / BCA final year projects
* Interview preparation
* Learning Laravel authorization concepts
* Admin panel development reference

---

## Features

* Laravel 12 framework
* Spatie Roles & Permissions integration
* User Management (Create, Read, Update, Delete)
* Role Management (Create, Assign, Update, Delete)
* Product Management (CRUD)
* Authentication (Login & Registration)
* Permission-based route and UI access control
* Clean MVC structure

---

## Project Screenshots

<img width="1739" height="585" alt="Users" src="https://github.com/user-attachments/assets/3d71bc9d-7ca3-4f09-994c-a6d3ca6c541a" />
<img width="1779" height="649" alt="Roles" src="https://github.com/user-attachments/assets/db96241b-8df1-42c3-9a2f-efd5f37592dd" />
<img width="1735" height="459" alt="Products" src="https://github.com/user-attachments/assets/6c4b42d8-9047-4db1-bcf9-97587f655e78" />
<img width="1701" height="461" alt="Permissions" src="https://github.com/user-attachments/assets/492be21b-50df-402d-a439-730ff0cd49bb" />

---

## Tech Stack

### Backend

* Laravel 12
* PHP 8.2 or higher
* Spatie Laravel Permission

### Frontend

* Blade Templates
* Bootstrap UI

### Database

* MySQL

### Package Management

* Composer
* NPM

---

## Installation Guide

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/laravel-roles-permissions.git
cd laravel-roles-permissions
```

---

### Step 2: Install Dependencies

```bash
composer install
npm install
```

---

### Step 3: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=roles_permissions
DB_USERNAME=root
DB_PASSWORD=
```

---

### Step 4: Install Spatie Permission Package

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

---

### Step 5: Run Migrations

```bash
php artisan migrate
```

---

### Step 6: Install Authentication Scaffolding

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm run build
```

---

## Database Seeding

Run the following seeders to create default roles, permissions, and admin user:

```bash
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=CreateAdminUserSeeder
```

---

## Default Admin Login

```text
Email    : admin@gmail.com
Password : 123456
```

---

## Run the Application

```bash
php artisan serve
```

Open in browser:

```text
http://localhost:8000
```

---

## Project Structure

```text
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
```

---

## Access Control Flow

* Admin user manages roles and permissions
* Roles are assigned to users
* Permissions are assigned to roles
* Routes and UI elements are protected using middleware and Blade directives

---

## Use Cases

This project can be used as:

* Role & permission starter template
* Admin dashboard base project
* Learning reference for Spatie RBAC
* Secure CRUD application example

---
