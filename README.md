## Installation

Clone the repository and run the following commands to start the application:
```bash
git clone git@github.com:dlondero/neuronation-api.git
cd neuronation-api
docker-compose up -d
```

## Usage
Simply open the following URL in your browser (or use Postman/cURL for executing a GET request):
http://localhost:8000/api/users/1/progress

## Testing

Execute the following command to run the tests:
```bash
docker-compose exec app vendor/bin/phpunit
```

## Database

Database diagram image can be found in the root directory of the project: `database_diagram.png`.
For a more detailed view of the database schema you can check `./docker/database.sql` file.
