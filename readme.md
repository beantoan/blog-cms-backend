## Setup

Execute the following guide to setup project:

- Run command `composer install` to install the requirements
- Copy file `.env.example` into `.env`
- Update database variables in `.env`
    * `DB_HOST`: Domain or ip address of mysql server
    * `DB_PORT`: Port of mysql server
    * `DB_DATABASE`: Name of database
    * `DB_USERNAME`: Username of mysql
    * `DB_PASSWORD`: Password of mysql
- Create a database and an account in mysql server as the above configuration 
- Run command `php artisan migrate` to migrate the schema to database
- Run command `php artisan jwt:secret` to generate secret key
- Run command `php artisan serve` to start backend project