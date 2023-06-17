# Buzzvel Task API | [John Task List](/2023%20-%20Back-End%20Developer%20Test.pdf)
This is a solution for the Buzzvel Task API, which is a simple API that allows you to create, update, delete and list tasks.

## Story
João is tired of forgetting his tasks that he need to do daily. Your goal is to create a tool that helps João to solve his problem in a simple way.

## Solution | [Live Demo](https://buzzvel-50c147ba7cf3.herokuapp.com/) | [Swagger Documentation](https://app.swaggerhub.com/apis-docs/hendurhance/BuzzvelAPI/1.0.0)
The solution was developed using Laravel 10, PHP 8.2, MySQL 8.0.23, Docker and Docker Compose. The solution is a REST API that allows you to create, update, delete and list tasks. A user can only update and delete his own tasks. The API is protected by a Sanctum token. The API is documented using Postman.

User Login
- Email: jane@example.com
- Password: P@ssw0rd

## Installation
- Clone the repository
```bash
git clone https://github.com/hendurhance/buzzvel-task.git
```
- Enter the project folder
```bash
cd buzzvel-task
```
- Copy the .env.example file to .env
```bash
cp .env.example .env
```
- Run the containers
```bash
docker-compose up -d
```
- Install the dependencies
```bash
docker exec -it buzzvel-app-1 bash
```
- Make sure you are in the /var/www/html folder
```bash
cd /var/www/html
```
- Install the dependencies
```bash
composer install
```
- Generate Application Key
```
php artisan key:generate
```
- Storage Link & Grant Permission
```
php artisan storage:link

chmod -R 755 storage
```

- Run the migrations and seeds
```bash
php artisan migrate --seed
```
- Run the tests
```bash
php artisan test
```
- Run PHP Insights
```bash
php artisan insights
```

### Requirements
- [✅] Unique identifier of the task (ID)
- [✅] Task Title
- [✅] Task Description
- [✅] Attachment File(s)
- [✅] Mark as Completed (indicates if the task is completed or not)
- [✅] Dates ( date that the task was created, completed, updated and deleted)
- [✅] User (user that created the task)
  
### Additional Requirements
- [✅] The API must return the correct HTTP status code and a message explaining the error.
- [✅] The API must return the validation errors in a readable format.
- [✅] The API must return errors when a resource is not found/do not exist.
- [✅] The project has 21 tests.

### Specifications
- PHP 8.2
- Laravel 10
- Repository Design Pattern
- Dependency Injection
- 20+ Tests
- 85%+ on PHP Insights
- Swagger Doc

### Database Schema
![Database Schema](/drawSQL-buzzvel-test-export-2023-06-12.png)

| Table | Type | Description |
| --- | --- | --- |
| users | table | The users table contains the registered users. |
| tasks | table | The tasks table contains the registered tasks. |
| files | table | The files table contains the attached files in the tasks. |

### API Endpoints
The API is documented using Postman. You can import the [Buzzvel Task API.postman_collection.json](/buzzvel_test.postman_collection.json) file into Postman to see the documentation.
| Method | URI | Description | Parameters | Body | Response |
| --- | --- | --- | --- | --- | --- |
| POST | /api/register | Register a new user. | - | name, email, password, password_confirmation | 201 |
| POST | /api/login | Login a user. | - | email, password | 200 |
| GET | /api/logout | Logout a user. | - | - | 204 |
| GET | /api/tasks | List all tasks. | search, from, to, sort, order, offset, limit, completed | - | 200 |
| POST | /api/tasks | Create a new task. | - | title, description, completed, files | 201 |
| GET | /api/tasks/{id} | Show a task. | - | - | 200 |
| PUT | /api/tasks/{id} | Update a task. | - | title, description, completed, files | 200 |
| DELETE | /api/tasks/{id} | Delete a task. | - | - | 204 |
