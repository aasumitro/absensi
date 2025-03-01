# Absensi

Attendance Management System

### Deployment Instructions
Follow this instruction below to deploy this application on the server.

##### System Requirement
1. Basic/Standard VPS
2. MySql or MariaDb latest version
3. Redis latest version
4. Nginx latest version
5. PHP version ^8.0-`{fpm,cli,mysql,zip,json,common,bcmath,pdo,mbstring,xml,gd,curl,redis}`
6. Composer version ^2.0

##### Server Setup (basic laravel prod setup)
1. Clone project `git clone https://github.com/aasumitro/absensi.git`
2. Install Dependencies `Composer install --no-dev`
3. Copy .env.example file `cp .env.example .env`
4. Generate Secret Key `php artisan key:generate`
5. Generate JWT Secret Key `php artisan jwt:secret`
6. Update Environment Variable [Connection, Credentials, etc.]
7. Run Database Migration `php artisan migrate --seed`
8. Run Queue Worker (Laravel Horizon) [READ THIS](https://laravel.com/docs/8.x/horizon#supervisor-configuration)
9. Run Background Task Scheduler (Laravel Scheduler) [READ THIS](https://laravel.com/docs/8.x/scheduling#running-the-scheduler)
10. Cache everything like view, route, etc.

##### Setup Desktop Application
1. `cd` to `desktop-client` directory
2. Select desktop client either the `electron` or `tauri` version
3. Follow the instruction on the `README.md` file to setup the desktop client

##### Setup Mobile Application
1. `cd` to `mobile-client` directory
2. Follow the instruction on the `README.md` file to setup the mobile client

### Versioning
Format: `{year_build}.{major_update}.{minor_update}`
- year_build - the year when the build is released
- major_update - major update like adding new feature, etc
- minor update like fixing bugs, patching or something
