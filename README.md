# Project Drum'N'Code
Technical task for IT company Drum'N'Code

Project on Symfony 6 using docker

## Install project

### Things you need
* composer
* npm
* docker
* php-cs-fixer

### Clone repository to your local machine
```bash
% git clone git@github.com:moroztaras/todo-list-drum-n-code.git
```
### Download and install all packages
```bash
composer install
```

### Create project config
```bash
cd todo-list-drum-n-code
cp .env .env.local
cp ./docker/.env.dist ./docker/.env
```

### Quick start of the project

Adjust .env.local line 4 and ./docker/.env lines 5-7.

It's credentials to database.

### Run a project with the docker
```bash
docker-compose -f docker/docker-compose.yaml up -d
```

### Execute a migration to the latest available version
```bash
./bin/console doctrine:migrations:migrate
```

### Load data fixtures to database
```bash
./bin/console doctrine:fixtures:load
```

### Run server
```bash
symfony serve:start
```

### Go to the link API Document
```bash
http://127.0.0.1:8000/api/doc
```
or
### You can download the postman collection
```bash
/Drum-N-Code.postman_collection.json
```