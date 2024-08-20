
# Laravel Weather API Project

## Description

This project is a Laravel-based API for storing and providing weather data for a specific city (e.g., Kyiv). The data is stored in a MySQL database, and the API provides access to the temperature history for a selected day.

## Requirements

- Docker
- Docker Compose

## Setup and Installation

1. **Clone the Repository**

   Clone the repository to your local machine:

   ```bash
   https://github.com/RomaLytar/eadsdo.git
   cd eadsdo
   ```

2. **Create and Configure `.env` File**

   Copy the example `.env` file and configure it according to your needs:

   ```bash
   cp .env.example .env
   ```

   Ensure the following environment variables are set:

   ```
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=eadsdo
   DB_USERNAME=root
   DB_PASSWORD=your_secure_password
   WEATHER_API_KEY=your_openweathermap_api_key
   CITY=Kyiv
   X_TOKEN=your_32_character_token
   ```

3. **Build and Start the Docker Containers**

   Build and start the Docker containers using Docker Compose:

   ```bash
   docker-compose up -d --build
   ```

   This will start the Laravel application on `http://localhost:8020`.

4. **Run Database Migrations**

   Run the Laravel database migrations to set up the necessary tables:

   ```bash
   docker-compose exec app php artisan migrate
   ```

5. **Access the Application**

   The application will be available at `http://localhost:8020`.

## API Endpoints

### 1. Get Weather Data

- **URL:** `/api/weather`
- **Method:** `GET`
- **Parameters:**
    - `day` (required): Date in the format `Y-m-d`.
    - `city` (optional): Name of the city. Defaults to `Kyiv` if not provided.
- **Headers:**
    - `x-token`: A 32-character token provided in the request header for authentication.
- **Response:** JSON object containing the weather data for the specified day and city.

## Commands

### Start Docker Containers

```bash
docker-compose up -d
```

### Stop Docker Containers

```bash
docker-compose down
```

### Run Migrations

```bash
docker-compose exec app php artisan migrate
```

### Fetch and Store Weather Data

This command can be set up as a scheduled job to run hourly and store the weather data:

```bash
docker-compose exec app php artisan weather:fetch-and-store
```

## Troubleshooting

- **Page Not Accessible:**
  Ensure that the Docker containers are running and that the application is properly configured. Check the logs using:

  ```bash
  docker-compose logs app
  ```

- **Database Connection Issues:**
  Verify the database connection details in the `.env` file. Ensure the MySQL container is running:

  ```bash
  docker-compose ps
  ```

## License

This project is licensed under the MIT License.
