## Instalasi

1. git clone https://github.com/App-Absensi/
2. cp .env.example .env
3. composer install
4. php artisan migrate:fresh && php artisan provinsi:reload && php artisan kabupaten:reload && php artisan db:seed && php artisan permission:reload
