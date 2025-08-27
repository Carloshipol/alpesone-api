# 🚗 Alpes One API

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red)]()
[![PHP](https://img.shields.io/badge/PHP-8.2-blue)]()
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED)]()
[![CI/CD](https://img.shields.io/badge/GitHub_Actions-CI%2FCD-green)]()

A **Laravel 10** API for importing and managing car data via JSON/API, storing it in **MySQL 8**, and exposing **RESTful endpoints** for integration with external systems.  
Fully containerized with **Docker** and ready for deployment with **CI/CD pipelines (GitHub Actions + EC2)**.

---

## Features
- Import car data from external APIs (JSON format)  
- Store and query vehicles in a relational database (MySQL)  
- RESTful endpoints with pagination and filtering  
- Automated deployment with Docker Compose + GitHub Actions  
- Unit and integration tests with PHPUnit  

---

## Tech Stack
- **Laravel 10** – PHP framework  
- **MySQL 8** – Relational database  
- **Docker & Docker Compose** – Local and cloud environments  
- **GitHub Actions** – CI/CD pipeline  
- **PHPUnit** – Unit and integration testing  
- **Postman** – API testing  

---

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

---

## Setup with Docker

```bash
# 1. Clone the repository
git clone https://github.com/Carloshipol/alpesone-api.git
cd alpesone-api

# 2. Copy the environment file
cp .env.example .env

# 3. Start containers
docker compose up -d --build

# API available at
http://localhost:8000/api/cars
```

## Example Usage
```bash
# Get all cars
curl -X GET http://localhost:8000/api/cars

# Get car by ID
curl -X GET http://localhost:8000/api/cars/1
```
## Sample response:
```json 

{
  "id": 1,
  "brand": "Ford",
  "model": "Fiesta",
  "year_model": 2020,
  "price": 45000
}

```
## Testing
```bash
php artisan test 
# or
./vendor/bin/phpunit

```
## Automated Deployment (EC2)
Deployment is handled via GitHub Actions:
 - Build Docker image

- Push image to Docker Hub

- SSH into EC2 and run docker compose up -d --build
---
## Roadmap
  - Caching layer for performance improvements
  - Import failure alert system
