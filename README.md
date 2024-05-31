# URL Shortener Application

Welcome to the URL Shortener application! This application allows users to shorten URLs and manage them through a user-friendly dashboard. It's built with Laravel 11 and Vue 3 using the Inertia.js stack.

![Dashboard Page](https://github.com/MMortymer/GlobalTicketsMaksymKovalenko/blob/main/public/images/dashboardScreenshot.png)

## Features

-   User Registration and Authentication
-   URL Management Dashboard
-   URL Manipulation Features (Create, Edit, Delete)
-   Redirection Functionality from Shortened URLs to Original URLs

## Requirements

-   PHP 8.2+
-   Composer
-   Node.js (with npm)
-   SQLite (by default, but can be changed in .env)

## Installation

1. **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd GlobalTicketsMaksymKovalenko
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

4. **Create a copy of your `.env` file:**

    ```bash
    cp .env.example .env
    ```

5. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations and seed data:**

    ```bash
    php artisan migrate --seed
    ```

This will migrate the database and seed it with sample data.
You can use credentials of the 1st user to login into aplication:

-   login: test@example.com
-   password: password

7. **Compile assets:**

    ```bash
    npm run dev
    ```

8. **Start the development server:**

    ```bash
    php artisan serve
    ```

    The application will now be available at `http://127.0.0.1:8000`.

## Testing

### Unit Tests

To run tests:

```bash
php artisan test
```

## Seeding the Database

The database can be seeded with sample data using the following command:

```bash
php artisan db:seed
```

This will clear existing data and seed the database with sample data.

## API Endpoints

The API endpoints are available under `/api/v1/urls` and can be tested using tools like Postman or Insomnia.

### Example API Endpoints

-   **GET** `/api/v1/urls` - Retrieve all URLs
-   **POST** `/api/v1/urls` - Create a new URL
-   **GET** `/api/v1/urls/{id}` - Retrieve a specific URL
-   **PUT** `/api/v1/urls/{id}` - Update a specific URL
-   **DELETE** `/api/v1/urls/{id}` - Delete a specific URL

## Security

This application does not currently implement token-based authentication for API requests. In a production environment, it is recommended to use Laravel Sanctum or Passport for secure API authentication.

## Additional Notes

-   Styling: The interface styling is minimal, I tried to implement some brand colors and logo.
-   Error Handling: Basic error handling is implemented.
-   Documentation: For more details on the implementation, refer to the inline comments in the code.

## Credits

This application was created by Maksym Kovalenko for the purpose of an assessment.

Thank you for the opportunity to complete this assessment!
