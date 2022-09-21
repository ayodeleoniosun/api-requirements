# Solution to the API requirement assessment test

The assessment test is available [Here](resources/assessment.md).

## Getting Started

* Development Requirements
* Installation
* Starting Devevelopment Server
* Documentation
* Testing

## Development Requirements

This application currently runs on <b>Laravel 9.19</b> and <b>PHP 8.0 and above </b> and the development requirements to
get this application up and
running are as follow:

* PHP 8.0+
* MySQL

### Installation

#### Step 1: Clone the repository

```bash
git clone https://github.com/ayodeleoniosun/ayodele-oniosun-api-requirements.git
```

#### Step 2: Switch to the repo folder

```bash
cd ayodele-oniosun-api-requirements
```

#### Step 3: Install all composer dependencies

```bash
composer install
```

#### Step 4: Setup environment variable

- Copy `.env.example` to `.env` i.e `cp .env.example .env`
- Update all the variables as needed

#### Step 5: Generate a new application key

```bash
php artisan key:generate
``` 

## Starting Development Server

Docker via Laravel sail was used for the development server for this project. <br/>
To start your development server, your default database configuration in the .env should be as follow:

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=sail
DB_PASSWORD=password
```

#### To spring up a docker container, run

```bash
./vendor/bin/sail up -d
```

and your local server will start running on port `8001`

#### Run database migration alongside the seeder

```bash
./vendor/bin/sail artisan migrate:fresh --seed
``` 

### Documentation

The Postman API collection is available [Here](resources/json/postman_collection.json). <br/>

### Testing

The project testing is done via Pest. You can check [Here](https://pestphp.com/docs/installation) for more
details. <br/>
To run the tests:

```bash
./vendor/bin/sail artisan test
```
