

# Blog Project

## Description

This is a blog application built using the Laravel framework. The project serves as a skeleton application for Laravel, providing essential features and functionalities for creating and managing blog posts. It leverages Laravel's powerful features, including routing, middleware, and Eloquent ORM for database interactions.

## Requirements

- PHP ^8.2
- Composer

## Documentation
all of the documentation is in file below 

download and import it to Postman

    https://drive.google.com/file/d/1xudIslSnu6PF1Fi9hdAs1rortQnGD6XW/view?usp=drive_link
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


# Usage

you can see all the blogs and its data in Admin/Blog/all blogs endpoint

inside this Request we have some params like :

archived :: that is bool and you can send 1 to see the archived blogs and 0 to see normal blogs 

status :: is draft or approved you choose between it

user_id :: with this you can say blogs of which user to show you

category_id :: with this you can say blogs of which category to show you

NOTE :: in blogs web service for clients 
you have only user_id and category_id to choose 
and it would not show to client blogs that are draft or is archived


and with the Admin/Blogs/archive you archive a Blog and then you can restore it with Admin/Blog/restore archive web service by sending blogId of deleted blog
