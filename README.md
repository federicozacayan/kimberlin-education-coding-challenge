## A set of coding challenges for engineering roles at Kimberlin Education

### Instructions
Build an application with a front and backend that allows following behaviours. You can find a rough user interface of what we are looking for [here](https://bitbucket.org/kimberlinEducation/coding-challenges/src/44afab8cd5e1ba8d9e2017131a0c7b30d35ee86d/pdf/UserInterfaceEventTest.pdf):
- Login functionality into an authenticated page (no need to build registration and logout)
- An authenticated page which shows a list of events
- Search for a event by title keyword and filter via types
- Click on an event and book based on a time slot
- Booking needs to be linked to authenticated user and saved on the db

## Stack used

```json
"php": "^7.2",
...
"laravel/framework": "^6.2",
"laravel/passport": "^8.4",
...
"phpunit/phpunit": "^8.0",
...
...
"laravel-mix": "^5.0.1",
"vue": "^2.5.17",
...
"sass": "^1.20.1",
```


## Requirement

PHP, MySQL (depends on the configuration), Composer, Node, Npm, Browser


## How to deploy

Clone the project  from the repository.

```shell script
git clone https://github.com/federicozacayan/kimberlin-education-coding-challenge.git .
```

Bring php libraries: 
```shell script
composer update
```

Bring javascript dependencies
```shell script
npm install
```

Deploy JS and CSS files
```shell script
npm run production
```

Configure .env file (example using laradock) 
```php
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret
```

Deploy database.
```shell script
php artisan migrate:refresh --seed
```

Install Passport
```shell script
php artisan passport:install
```

Then Run locally
```shell script
php artisan serve
```



## How to test

Unit test.

```shell script
phpunit
```

Note: it is responsive design.

