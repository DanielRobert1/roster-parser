# Roster Parser

## Setup Instructions

### Requirements
- Docker
- Docker Compose

### Steps to Setup
1. Clone the repository
    ```
    git clone https://github.com/your-username/roster-parser.git
    ```
   
2. Navigate to the project directory
    ```
    cd roster-parser
    ```

3. Install dependencies and start the Laravel Sail containers
    ```
    ./vendor/bin/sail up -d
    ```

4. Create a `database.sqlite` file in the `database` directory
    ```
    touch database/database.sqlite
    ```

5. Run migrations to set up the database
    ```
    ./vendor/bin/sail artisan migrate
    ```

6. Navigate to `/docs` in your web browser to view the documentation and get started with the application.