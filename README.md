Challenge Joan Teich
 
-- Requeriments:
  * Php 8.x
  * Composer 2.x
  * Sql database

-- Install:
  1. In the selected folder execute:
        git clone https://github.com/Joante/Challenge.git
  2. Copy the .env.example to .env
        cp .env.example .env
  3. Modify the .env file to connect to the database:
    `
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=DATABASE
      DB_USERNAME=USERNAME
      DB_PASSWORD=PASSWORD
     `
  4. Install all the dependencies with composer:
        composer update
  5. Create the tables in the database:
        php artisan migrate

-- Run the application:
  1. Create a server with artisan:
        php artisan serve
  2. Run the queque listener:
        php artisan queue:listen

    
If you make a POST request to URL/api/url with a body like this:
    `
    {
        "url":WANTED_URL
    }
    `
This will return a JSON body with the locale url route

If you make a GET request to URL/api/ranking it will return a JSON body with the most frequently accessed websites
    `
    {
         "ranking": [
            {
                "title": "Google",
                "visits": 9,
                "redirection": "localhost\/a"
            },
            {
                "title": "Twitter",
                "visits": 2,
                "redirection": "localhost\/d"
            },
            {
                "title": "Facebook - Inicia sesión o regístrate",
                "visits": 1,
                "redirection": "localhost\/b"
            },
            {
                "title": "Instagram",
                "visits": 1,
                "redirection": "localhost\/c"
            }
        ]
    }`
