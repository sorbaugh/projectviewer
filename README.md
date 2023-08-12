# Project Viewer

Project Viewer is a PHP/Symfony 6 application designed to help you manage and view projects effectively.

## Important Packages

- Doctrine: Object-Relational Mapping (ORM) library for database interactions.
- EasyAdmin: Symfony bundle for creating administration panels.
- Webpack Encore: Asset management and build tool for front-end assets.

## Setup Requirements

Before you get started, ensure you have the following tools installed on your system:

- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [Git](https://git-scm.com/downloads)

## Setup Instructions

Follow these steps to set up and run the Project Viewer application:

1. Clone the Repository:
   ```sh
   git clone https://github.com/sorbaugh/projectviewer
   cd projectviewer
   
2. Create Containers:
   Make sure that Docker-Desktop is up and running and run the following command in the project's root directory to create Docker containers:
   ```sh
   docker-compose up -d

3. Connect into the docker container and install PHP dependencies:
   ```sh
   docker exec -ti projectviewer-php_symfony_app-1 /bin/bash
   ```

4. Change to the /var/www directory inside the Docker container:
   ```sh
   cd /var/www
   ```

5. Then install PHP dependencies using Composer:
   ```sh
   composer install
   ```
   
6. Install Front-End Dependencies:
   Still in the /var/www directory inside the Docker container, install front-end dependencies using npm:
   ```sh
   npm install
   ```
   
7. Build the assets:
   ```sh
   npm run build
   ```
   
8. Create the database:
   ```sh
   php bin/console doctrine:database:create
   ```
   
9. Execute doctrine migration (type "yes" when prompted)
   ```sh
   php bin/console doctrine:migrations:migrate
   ```

## Access the Application
You're done!

Open your web browser and navigate to http://localhost:9000 to access the Project Viewer application.

You can also navigate to http://localhost:5050 to access pgadmin.

## Usage
Use the Project Viewer application to manage and view your projects efficiently. Explore the features provided by Doctrine, EasyAdmin, and Webpack Encore to streamline your workflow.

## Contributing
Contributions are welcome! If you find a bug or want to add new features, feel free to create issues or pull requests.