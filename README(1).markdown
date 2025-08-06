# Laravel CRUD IOU Research Project

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

## Overview

This repository serves as a research and development sandbox for a Laravel-based CRUD (Create, Read, Update, Delete) application with IOU (I Owe You) functionality. It explores various Laravel packages, integrations, and use cases to evaluate their suitability for a production-grade project. The project includes features like CAPTCHA integration, regional data handling, QR code generation, and more.

## Table of Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Dependencies](#dependencies)
- [Live Demos](#live-demos)
- [Use Cases](#use-cases)
- [Contributing](#contributing)
- [License](#license)

## Features

- **CRUD Operations**: Basic create, read, update, and delete functionality for managing IOU records.
- **CAPTCHA Integration**: Bot protection using `captcha-com/laravel-captcha`.
- **Regional Data**: Support for Indonesian region data using `azishapidin/indoregion` and `laravolt/indonesia`.
- **QR Code Generation**: Generate QR codes with `simplesoftwareio/simple-qrcode`.
- **PDF Generation**: Create PDFs using `elibyy/tcpdf-laravel`.
- **Authentication**: Optional scaffolding with Laravel Breeze or Laravel UI.
- **Performance Optimization**: Optional Laravel Octane for enhanced performance.
- **Role & Permissions**: Manage roles and permissions with `spatie/laravel-permission`.
- **DataTables**: Server-side DataTables integration with `yajra/laravel-datatables-oracle`.
- **Development Tools**: Includes Laravel Tinker, Sail, and Pint for development and code style.

## Screenshots

### Application Interface
![Main Application](https://github.com/ugunNet21/laravel-crud-iou/assets/45864165/0cb7e8e3-995e-44c8-96fe-d31a08de2ef8)

### CAPTCHA Bot Protection
![CAPTCHA](https://github.com/user-attachments/assets/d495da2c-6dd9-496a-9bd9-b9b765e9b480)

## Installation

Follow these steps to set up the project locally:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ugunNet21/laravel-crud-iou.git
   cd laravel-crud-iou
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Set Up Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   Update the `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_crud_iou
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Install and Publish Packages**
   Run the following commands to install and configure the required packages:

   ```bash
   # Install Laravel Captcha
   composer require captcha-com/laravel-captcha:"4.*"
   php artisan vendor:publish --provider="LaravelCaptcha\Providers\LaravelCaptchaServiceProvider"

   # Install Nwidart Laravel Modules
   composer require nwidart/laravel-modules:^10.0
   php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

   # Install Laravel Breeze (optional)
   composer require laravel/breeze --dev
   php artisan breeze:install

   # Install Laravel UI (optional)
   composer require laravel/ui
   php artisan ui bootstrap --auth
   npm install && npm run dev

   # Install Laravel Octane (optional)
   composer require laravel/octane
   php artisan octane:install

   # Install Laravel Sanctum (optional)
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

   # Install Laravel Tinker
   composer require laravel/tinker

   # Install Laravel Sail (optional)
   composer require laravel/sail --dev
   php artisan sail:install

   # Install Laravel Pint (optional)
   composer require laravel/pint --dev

   # Install Spatie Laravel Permission
   composer require spatie/laravel-permission
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

   # Install Yajra DataTables
   composer require yajra/laravel-datatables-oracle
   php artisan vendor:publish --tag=datatables

   # Install Simple QR Code
   composer require simplesoftwareio/simple-qrcode

   # Install Indonesia Region Database
   composer require azishapidin/indoregion
   php artisan vendor:publish --provider="AzisHapidin\IndoRegion\IndoRegionServiceProvider"

   # Install Laravolt Indonesia
   composer require laravolt/indonesia
   php artisan indonesia:migrate

   # Install TCPDF Wrapper
   composer require elibyy/tcpdf-laravel
   php artisan vendor:publish --provider="Elibyy\TCPDF\ServiceProvider"

   # Rebuild Composer Autoload
   composer dump-autoload
   ```

7. **Run the Application**
   ```bash
   php artisan serve
   ```

## Dependencies

The following packages are used in this project:

| Package | Description | Reference |
|---------|-------------|-----------|
| `captcha-com/laravel-captcha` | CAPTCHA for bot protection | [Docs](https://captcha.com/php-captcha.html#php-laravel-crashcourse) |
| `nwidart/laravel-modules` | Modular structure for Laravel | [Docs](https://docs.laravelmodules.com/) |
| `laravel/breeze` | Authentication scaffolding | [Docs](https://laravel.com/docs/breeze) |
| `laravel/ui` | UI presets for Bootstrap | [Docs](https://laravel.com/docs/ui) |
| `laravel/octane` | Performance optimization | [Docs](https://laravel.com/docs/octane) |
| `laravel/sanctum` | API token authentication | [Docs](https://laravel.com/docs/sanctum) |
| `laravel/tinker` | Interactive REPL | [Docs](https://laravel.com/docs/tinker) |
| `laravel/sail` | Docker development environment | [Docs](https://laravel.com/docs/sail) |
| `laravel/pint` | Code style fixer | [Docs](https://laravel.com/docs/pint) |
| `spatie/laravel-permission` | Role and permission management | [Docs](https://spatie.be/docs/laravel-permission) |
| `yajra/laravel-datatables-oracle` | Server-side DataTables | [Docs](https://yajra.github.io/laravel-datatables/) |
| `simplesoftwareio/simple-qrcode` | QR code generation | [Docs](https://www.simplesoftware.io/docs/simple-qrcode) |
| `azishapidin/indoregion` | Indonesian regional data | [Docs](https://github.com/azishapidin/indoregion) |
| `laravolt/indonesia` | Alternative Indonesian regional data | [Docs](https://laravolt.dev/docs/indonesia) |
| `elibyy/tcpdf-laravel` | PDF generation | [Docs](https://github.com/elibyy/tcpdf-laravel) |

## Live Demos

Explore the live demos for specific features:

- **CAPTCHA Demo**: [View](https://ugunnet21.github.io/laravel-crud-iou/src/html/captcha.html)
- **Userway Demo**: [View](https://ugunnet21.github.io/laravel-crud-iou/src/html/userway.html)

## Use Cases

This project is designed to evaluate the following scenarios for a production-grade Laravel application:

1. **Bot Protection**: Implementing CAPTCHA to prevent automated submissions.
2. **Regional Data Handling**: Supporting Indonesian regional data for location-based features.
3. **Document Generation**: Generating PDFs and QR codes for IOU records.
4. **Authentication**: Testing Laravel Breeze, UI, and Sanctum for user authentication.
5. **Performance**: Evaluating Laravel Octane for high-performance applications.
6. **Role Management**: Managing user roles and permissions with Spatie.
7. **Data Presentation**: Using DataTables for server-side data rendering.
8. **Modular Development**: Structuring the application with `nwidart/laravel-modules`.
9. **Development Workflow**: Leveraging Sail, Tinker, and Pint for a smooth development experience.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m "Add your feature"`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).