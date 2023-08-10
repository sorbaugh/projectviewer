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
   Run the following command in the project's root directory to create Docker containers:
   ```sh
   docker-compose up -d

3. Install PHP Dependencies:
   Change to the /var/www directory inside the Docker container:
   ```sh
   docker exec -ti teamviewer-php_symfony_app-1 /bin/bash
   cd /var/www
   ```
   
   Then install PHP dependencies using Composer:
   ```sh
   composer install
   ```
   
   Install Front-End Dependencies:
   Still in the /var/www directory inside the Docker container, install front-end dependencies using npm:
   ```sh
   npm install
   ```

## Access the Application
Open your web browser and navigate to http://localhost:9000 to access the Project Viewer application.

## Usage
Use the Project Viewer application to manage and view your projects efficiently. Explore the features provided by Doctrine, EasyAdmin, and Webpack Encore to streamline your workflow.

## Contributing
Contributions are welcome! If you find a bug or want to add new features, feel free to create issues or pull requests.