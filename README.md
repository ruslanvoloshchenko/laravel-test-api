# Laravel Submissions API

## Introduction
This project is a simple Laravel-based API for handling submissions. The `/submit` endpoint accepts a `POST` request with JSON payload containing `name`, `email`, and `message`. The data is validated and processed asynchronously using Laravel's job queue and event system.

## Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- A MySQL database (or any database supported by Laravel)

### Installation

1. **Clone the repository**:
    ```sh
    git clone https://github.com/ruslanvoloshchenko/laravel-test-api.git
    cd laravel-test-api
    ```

2. **Install dependencies**:
    ```sh
    composer install
    ```

3. **Set up environment variables**:
   Copy the example environment file and modify the necessary values.
    ```sh
    cp .env.example .env
    ```
   Update the `.env` file with your database credentials and other configurations:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    QUEUE_CONNECTION=database
    ```

4. **Generate application key**:
    ```sh
    php artisan key:generate
    ```

5. **Run migrations**:
   This will create the necessary database tables.
    ```sh
    php artisan migrate
    ```

6. **Set up the queue**:
   Create the jobs table and start the queue worker.
    ```sh
    php artisan queue:table
    php artisan migrate
    php artisan queue:work
    ```

7. **Run the development server**:
    ```sh
    php artisan serve
    ```

## Testing the API Endpoint

### Using Curl
You can test the API endpoint using `curl`:

```sh
curl -X POST http://127.0.0.1:8000/api/submit \
     -H "Content-Type: application/json" \
     -d '{"name":"John Doe", "email":"john.doe@example.com", "message":"This is a test message."}'
