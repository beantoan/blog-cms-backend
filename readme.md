## Setup

Execute the following steps to setup project:

- Install [`composer`](https://getcomposer.org/)
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
- Run command `php artisan serve` to start the project. If the port `8000` was occupied by another program, please run the command `php artisan serve --port=4321` to start the project. Remember to update the variable `apiUrl` in `src/environments/environment.ts` of `blog-cms-frontend` project to become `http://localhost:4321`