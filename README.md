# simple_user_crud
To test oop

#### Run Docker
 - Copy env_example to .env .
 - Run `docker-compose up` or run `docker-compose up -d` to run containers in background.

#### Composer

 - `cd /project_path/`
 - `composer install`

#### Postman
 Import ./simple_user_crud.json to postman collection.
 
 
#### Routes
All routes are defined in `routes.php` file.

#### Start

 - You can visit `http://localhost:{HTTP_PORT}` (exp: http://localhost).
 - Call `http://localhost:{HTTP_PORT}/migration/up` to run migrations.

#### Run test

- `cd /project_path/`

- `./vendor/bin/phpunit tests`

