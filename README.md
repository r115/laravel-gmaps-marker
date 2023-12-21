Preview
---
https://markers.gari.co.ke

Local setup
---
Most of the existing Docker based configs (ddev, Laravel Sail) anticipate PHP 8.2+ and dont play nice with Postgis.

Just did not have enough time to wire a proper docker-compose.

This can be run easily in any environment with the following;

- PostgreSQL 14+ with postgis enabled. Quick instance can be spun at neon.tech
- PHP 8.1 and Composer 2+.
- NodeJS 16+ for asset compilation

Once the above requirements are met;
- `composer install`
- `npm install&&npm run build`
- `php artisan migrate`
- `php artisan serve`

This should provide a full page application with markers whenever a point is clicked.
