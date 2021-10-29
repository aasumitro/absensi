# OkSetda Absensi

OkSetda e-Attendance Server Platform

### Deployment Instructions
Follow this instruction below to deploy this application on the server at no pain.
But, you can run via Docker & docker-compose if you didn't have a time, KISS (KEEP IT SIMPLE STUPID) #LOL!

##### System Requirement
1. Basic/Standard Server 
2. MySql or MariaDb latest version
3. Redis latest version
4. Nginx latest version
5. PHP version ^7.4-`{fpm,cli,mysql,zip,json,common,bcmath,pdo,mbstring,xml,gd,curl,redis}`
6. Composer version ^2.1


##### System Setup
1. Clone project `git clone https://github.com/{organization_name}/{repository_name}`
2. Install Dependencies `Composer install --no-dev`
3. Copy .env.example file `cp .env.example .env`
4. Generate Secret Key `php artisan key:generate`
5. Generate JWT Secret Key `php artisan jwt:secret`
6. Update Environment Variable [Connection, Credentials, etc.]
7. Run Database Migration `php artisan migrate --seed`
8. Run Queue Worker (Laravel Horizon) [READ THIS](https://laravel.com/docs/8.x/horizon#supervisor-configuration)
9. Run Background Task Scheduler (Laravel Scheduler) [READ THIS](https://laravel.com/docs/8.x/scheduling#running-the-scheduler)
10. Cache everything like view, route, etc.


