## Alpes One API
A Laravel API to import car data via JSON/API, store it in a database, and provide REST endpoints.

## Technologies Used

- Laravel 10 – PHP framework.
- MySQL 8 – Database.
- Docker & Docker Compose – Local environment and EC2 deployment.
- GitHub Actions – CI/CD for build, test, and deploy.
- PHPUnit – Unit and integration testing.
- Postman – API testing.

## Database Schema
cars

├─ id (PK)

├─ external_id

├─ type

├─ brand

├─ model

├─ version

├─ year_model

├─ year_build

├─ optionals (JSON)

├─ doors

├─ board

├─ chassi

├─ transmission

├─ km

├─ description

├─ created_api

├─ updated_api

├─ sold

├─ category

├─ url_car

├─ old_price

├─ price

├─ color

├─ fuel

├─ photos (JSON)

├─ json_hash

## Setup Instructions (Docker)
### 1. Clone the repository
- git clone https://github.com/your-username/your-repo.git
- cd your-repo

### Copy the environment file
- cp .env.example .env

### Start the containers
- docker compose up -d --build

### Access the API
- http://localhost:8000/api/cars

## Automated EC2 Deployment
GitHub Actions handles deployment via SSH and Docker Compose. Workflow steps:
- **Build the Docker image**
- **Push to Docker Hub**
- **SSH into EC2 and run docker compose up -d --build**

##  Testing
- Unit tests: validations for the import command

- Integration tests: API endpoints, authentication, and pagination

## Final Thoughts

- Ready for production with Docker Compose and CI/CD.
- Future improvements:
  - JWT authentication for API endpoints
  - Swagger/OpenAPI documentation
  - Caching to improve import performance
  - Alerts in case of import failure

##