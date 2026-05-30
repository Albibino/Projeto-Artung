# Projeto Artung

Projeto Artung is a web platform designed as a social network for artists to share and discover art. It provides a space for both underground and mainstream artists to showcase their work, connect with an audience, and gain visibility through a system that highlights both new and popular content.

## Key Features

*   **Art Showcase**: Users can create posts with an image, title, description, and up to three descriptive tags.
*   **User Profiles**: Each user has a public profile displaying their posts and the posts they have liked. Profile pictures can be uploaded and updated.
*   **Social Engagement**: Users can "like" and "unlike" posts to show appreciation.
*   **Dynamic Feeds**: The homepage features separate sections for "Recent Posts" and "Most Liked" posts, allowing for discovery of both new and popular content.
*   **Search Functionality**: A comprehensive search bar allows users to find posts by title, author, or tags.
*   **Role-Based Access Control**: The application supports `user`, `moderator`, and `admin` roles, each with distinct permissions.
*   **Content & User Management**: Administrators and moderators have access to a dashboard to manage users (ban, unban, promote, demote) and curate the available tags for posts.
*   **Content Moderation**: Banned users are restricted from accessing the platform. Admins and moderators can remove inappropriate content.

## Tech Stack

*   **Backend**: PHP 8.2+ with Laravel 12
*   **Frontend**: Blade Templates, Tailwind CSS, Alpine.js, Vite
*   **Database**: SQLite (default), with support for MySQL, PostgreSQL

## Getting Started

Follow these instructions to set up and run the project locally.

### Prerequisites

*   PHP >= 8.2
*   Composer
*   Node.js & npm

### Installation

1.  Clone the repository:
    ```bash
    git clone https://github.com/albibino/projeto-artung.git
    ```

2.  Navigate to the project directory:
    ```bash
    cd projeto-artung/Artung
    ```

3.  Install PHP dependencies:
    ```bash
    composer install
    ```

4.  Install JavaScript dependencies:
    ```bash
    npm install
    ```

5.  Create a copy of the environment file:
    ```bash
    cp .env.example .env
    ```

6.  Generate an application key:
    ```bash
    php artisan key:generate
    ```

7.  Create the SQLite database file (or configure your preferred database in the `.env` file):
    ```bash
    touch database/database.sqlite
    ```

8.  Run the database migrations to create the tables:
    ```bash
    php artisan migrate
    ```

9.  Seed the database with initial data (includes default tags and user accounts):
    ```bash
    php artisan db:seed --class=TagSeeder
    php artisan db:seed --class=UserSeeder
    ```

10. Create the symbolic link for the public storage disk:
    ```bash
    php artisan storage:link
    ```

11. Start the Vite development server:
    ```bash
    npm run dev
    ```

12. In a separate terminal, start the Laravel development server:
    ```bash
    php artisan serve
    ```

The application will be available at `http://localhost:8000`.

### Default Admin Account

The database seeder creates a default administrator account with the following credentials:
*   **Email**: `admin@artung.com`
*   **Password**: `admin123456`
