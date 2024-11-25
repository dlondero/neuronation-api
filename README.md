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
