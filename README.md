<h1>MCube Machine Test – Laravel Banking API </h1>

<p>A RESTful banking API built with Laravel, MySQL, and Laravel Sanctum. The project demonstrates user authentication, bank account management, balance checking, and secure money transfers using the Repository Pattern.</p>

<h3>Features<h3
<ul>
    <li>User registration and login</li>
    <li>Laravel Sanctum API token authentication</li>
    <li>Authenticated user profile (<code>/me</code>) and logout</li>
    <li>Bank account creation</li>
    <li>Account balance retrieval</li>
    <li>Transfers between users' bank accounts</li>
    <li>Transaction history records for transfers</li>
    <li>Request validation and consistent JSON API responses</li>
    <li>Repository Pattern for database operations</li>
    <li>Database transactions and row-level locking for secure money transfers</li>
    <li>Prevention of self-transfers and transfers exceeding the available balance</li>
</ul>

<h3>Technology Stack </h3>
<ul>
    <li>Backend: PHP, Laravel 10</li>
    <li>Database: MySQL</li>
    <li>Authentication: Laravel Sanctum</li>
    <li>API Testing: Postman</li>
    <li>Architecture: Controller, Request, Resource, Service, Repository</li>
</ul>


<h3>Requirements</h3>
<ul>
    <li>PHP version compatible with Laravel 10</li>
    <li>Composer dependency manager</li>
    <li>MySQL database</li>
    <li>Laravel 10 framework</li>
    <li>Required PHP extensions, including PDO MySQL and BCMath</li>
    <li>Postman or another REST API testing client</li>
</ul>
<h2>Installation</h2>

<h3>1. Clone the repository</h3>

git clone : https://github.com/hashimpk07/mcube.git
cd <YOUR_PROJECT_DIRECTORY>

<h3>2. Install dependencies</h3>

<h6>composer install</h6>

If the project includes a frontend or JavaScript build, install its dependencies separately using the appropriate package manager.

<h3>3. Configure environment variables</h3>

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

<h3> Configure Laravel Sanctum </h3>

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

<h3> Run database migrations </h3>

php artisan config:clear
php artisan migrate

This should create the application tables, including the standard Laravel authentication tables and the banking tables defined by the project's migrations.

Do not run migrate:fresh on a database containing data you need to keep; it drops existing tables.

<h3> Start the application</h3>

php artisan serve

Base URL:

http://127.0.0.1:8000
