MCube Machine Test – Laravel Banking API

A RESTful banking API built with Laravel, MySQL, and Laravel Sanctum. The project demonstrates user authentication, bank account management, balance checking, and secure money transfers using the Repository Pattern.

Features

User registration and login

Laravel Sanctum API token authentication

Authenticated user profile (me) and logout

Bank account creation

Account balance retrieval

Transfers between users' bank accounts

Transaction history records for transfers

Request validation and consistent JSON responses

Repository Pattern for database operations

Database transactions and row locking for money transfers

Prevention of self-transfers and transfers exceeding the available balance

Technology Stack

Backend: PHP, Laravel 10

Database: MySQL

Authentication: Laravel Sanctum

API testing: Postman

Architecture: Controller, Request, Resource, Service, Repository

Requirements

PHP version supported by your Laravel installation

Composer

MySQL

Laravel 10

PHP extensions required by Laravel, including PDO MySQL and BCMath

Postman or another REST API client

Installation

1. Clone the repository

git clone <YOUR_GITHUB_REPOSITORY_URL>
cd <YOUR_PROJECT_DIRECTORY>

2. Install dependencies

composer install

If the project includes a frontend or JavaScript build, install its dependencies separately using the appropriate package manager.

3. Configure environment variables

Create your local environment file:

cp .env.example .env

On Windows PowerShell, if needed:

Copy-Item .env.example .env

Generate the Laravel application key:

php artisan key:generate

Update the database configuration in .env:

APP_NAME="MCube Banking API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcube
DB_USERNAME=root
DB_PASSWORD=

Create the mcube database in MySQL before running migrations. Replace the database credentials with your local configuration.

4. Configure Laravel Sanctum

Ensure Sanctum is installed:

composer show laravel/sanctum

If it is not installed, install it using the appropriate instructions for your Laravel version.

The User model should include the HasApiTokens trait:

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Keep the remaining model configuration.
}

5. Run database migrations

php artisan config:clear
php artisan migrate

This should create the application tables, including the standard Laravel authentication tables and the banking tables defined by the project's migrations.

Do not run migrate:fresh on a database containing data you need to keep; it drops existing tables.

6. Start the application

php artisan serve

Base URL:

http://127.0.0.1:8000
