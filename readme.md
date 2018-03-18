# Investoo Group API

### How to use
```
$ git clone
$ composer install
$ touch database/database.sqlite
$ cp .env.example .env
$ php artisan migrate
$ php artisan serve
```

### Endpoints
```
GET        /api/v1/files                    # Fetch all files
GET        /api/v1/files/{id}               # Fetch a file by id
GET        /api/v1/files/download/{id}      # download a file by id
POST       /api/v1/files                    # new
{
    "csv":"investoo,group,api,dev,test",
    "filename": "filename.xls"
}
```

#### Thank you for checking out investoo group api
