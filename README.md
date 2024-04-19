# Roster Parser

## Setup Instructions

### Requirements
- Docker
- Docker Compose

### Steps to Setup
1. Clone the repository
    ```
    git clone https://github.com/DanielRobert1/roster-parser.git
    ```
   
2. Navigate to the project directory
    ```
    cd roster-parser
    ```

3. Duplicate the `.env.example` file and rename it to `.env`
    ```
    cp .env.example .env
    ```
4. Install dependencies and start the Laravel Sail containers
    ```
    ./vendor/bin/sail up -d
    ./vendor/bin/sail composer install
    ./vendor/bin/sail php artisan key:generate
    ```

5. Create a `database.sqlite` file in the `database` directory
    ```
    touch database/database.sqlite
    ```

6. Run migrations to set up the database
    ```
    ./vendor/bin/sail artisan migrate
    ```

7. Navigate to `/docs` in your web browser to view the documentation and get started with the application.

### Uploading Roster
To upload a roster, send a POST request to `/api/roster/upload` with an HTML file in a field called `roster`.

Example using `curl`:
```bash
curl -X POST \
  -F "roster=@/path/to/your/roster.html" \
  http://localhost/api/roster/upload
```


### Retrieving Roster Data
To retrieve roster data, send a GET request to `/api/roster` with the following optional parameters:

```json
{
    "type": "FLT",
    "destination_location": "CPH",
    "metrics": "custom",
    "from_date": "01/14/2022",
    "to_date": "01/15/2022"
}
```

Example using `curl`:
```bash
curl -X GET \
  http://localhost/api/roster?type=FLT&destination_location=CPH&metrics=nextWeek&from_date=01/14/2022&to_date=01/14/2022
```

Replace the query parameters with your desired filters." 
For more infomation on please navigate to /docs to view the api documentation. Thanks