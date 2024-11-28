

# Blog Project

## Description

This is a blog application built using the Laravel framework. The project serves as a skeleton application for Laravel, providing essential features and functionalities for creating and managing blog posts. It leverages Laravel's powerful features, including routing, middleware, and Eloquent ORM for database interactions.

## Requirements

- PHP ^8.2
- Composer

## Documentation
all of the documentation is in file below 

download and import it to Postman

    https://drive.google.com/file/d/12RVrMwBC3wk5jfjneC8rV99F_VumirZJ/view?usp=drive_link

## Installation

To set up the project, follow these steps:

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/AlirezaRoostaey/BlogTest.git
   cd BlogTest
Install Dependencies:

Use Composer to install the required dependencies:

    composer install
### Set Up Environment File:

 the example environment file and update the necessary configurations:

    cp .env.example .env
Generate Application Key:

Generate the application key:

     
    php artisan key:generate    
Run Migrations:

Set up the database by running migrations. Make sure your database is configured in the .env file:

    php artisan migrate
Set up the data by running seeders:

    php artisan db:seed
Start the Development Server:

You can start the Laravel development server using:

    php artisan serve   
Also you need to run worker on queues:

    php artisan queue:work   
NOTE : pleas consider that you have to add your email server 

credentials to .env

 
The application will be available at http://localhost:8000

NOTE ::  you need to run tinker

    php artisan tinker

and then update your user role to "admin" to be able to send api to admin routes 

## default Admin

inside the seeders we have created an admin


Email : 

    admin@appeto.com


Password : 

    Admin1234
you can login with
