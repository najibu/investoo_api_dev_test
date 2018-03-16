# Investoo Group API

### How to use
```
$ git clone
$ composer install
$ touch database/database.sqlite
$ cp .env.example .env
$ php artisan migrate
$ php artisan recipes:warm # warm the sqlite db from the csv file
$ php artisan serve
```

### Endpoints
```
GET        /api/v1/files               # Fetch all files
GET        /api/v1/files?page=2        # paginate
GET        /api/v1/files/{id}          # Fetch a file by id
POST       /api/v1/files               # new
```
