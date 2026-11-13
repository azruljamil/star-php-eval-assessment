# The Daily Brief

A Laravel news portal with article listings, live title search, article detail pages, and a paginated JSON API. Only published articles whose publication date has passed are displayed.

## Requirements

- PHP 8.5 with the SQLite extension
- Composer 2

## Setup

1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env` and generate an application key: `php artisan key:generate`
3. Create an empty `database/database.sqlite` file, then run `php artisan migrate --seed`.
4. Start the application: `php artisan serve`

The default environment uses SQLite. Update `.env` if you prefer another database.

## Routes

- `/` and `/articles` — published articles and title search
- `/articles/{permalink}` — article details
- `/api/articles` and `/api/v1/articles` — paginated article JSON

Run the test suite with `php artisan test`. The tests use an in-memory SQLite database.
