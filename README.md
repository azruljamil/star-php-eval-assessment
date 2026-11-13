# The Daily Brief

A Laravel news portal with article listings, live title search, article detail pages, and a paginated JSON API. Only published articles whose publication date has passed are displayed.

## Requirements

- PHP 8.5 with the PDO MySQL extension
- Composer 2
- MySQL

## Setup

1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env` and generate an application key: `php artisan key:generate`
3. Create a MySQL database and configure its connection in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

   Use the credentials for your local MySQL installation. The supplied `.env.example` defaults to SQLite, so these values must be changed for MySQL.

4. Run `php artisan migrate --seed`.
5. Start the application: `php artisan serve`

## Routes

- `/` and `/articles` — published articles and title search
- `/articles/{permalink}` — article details
- `/api/articles` and `/api/v1/articles` — paginated article JSON

Run the test suite with `php artisan test`. The tests use an in-memory SQLite database and require the PHP SQLite extension, even when the application uses MySQL.
