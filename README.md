# Candidate Technical Evaluation - Star Media Group

## Time Limit: 60 - 90 Minutes

### Prerequisites
- PHP 8.5+ installed
- Composer 2.x installed

### Quick Setup Instructions
1. Clone this repository to your local machine.
2. Run `composer install`
3. Copy the environment file: `cp .env.example .env`
4. Generate app key: `php artisan key:generate`
5. Create SQLite file if needed (see database/ folder) and run migrations: `php artisan migrate`
6. Start dev server: `php artisan serve`

### Tasks
#### 1. **Migrations & Models:** Create the Article and Category models with standard Eloquent relationships (a Category has many Articles).
- `Category` Model Fields:
  - `id` (primary key)
  - `name` (string)
  - `Article` Model Fields:
    - `title` (string)
    - `summary` (string)
    - `body` (text)
    - `published_at` (timestamp, nullable)
    - `permalink` (string)
    - `category_id` (foreign key referencing `categories`)
    - _(Optional)_: Add 1 or 2 extra properties you feel are essential for a news portal article (e.g., `status`, `thumbnail_url`, `author`).
#### 2. **Factories & Database Seeding**
- Create an `ArticleFactory` using Faker for titles, summary, and body content.
- Configure `DatabaseSeeder.php` so running `php artisan db:seed` automatically populates the database with at least 5 categories and 20 articles.
#### 3. **Controller & API Endpoint:** Create a GET controller method returning articles formatted as JSON. Prevent N+1 database queries using eager loading (`with`).
#### 4. **Frontend Integration:**
- **Article List View:** Render a list of articles using standard Blade views styled with Bootstrap (or Livewire).
- **Search Filter:** Implement a simple real-time JavaScript (or Livewire) search filter to filter articles by title on the list page.
- **Article Detail Page:** Create a single article view page that displays the full title, body, category, and published date when an article from the list is clicked.

### Submission Guidelines
- Commit code cleanly with clear commit messages.
- Push your completed work back to your repository and share the repository link with us.