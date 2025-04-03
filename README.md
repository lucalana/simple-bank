# Banco Simplificado

Projeto simulando um "banco" de uma maneira mais simples, colocando em prática alguns temas como tratamentos de erros,
envio de emails, filas usando redis e desacoplamento da regra de negócio.

## 📌 Technologies Used

This project was developed using the following technologies:

-   [Laravel](https://laravel.com/)
-   [PHP](https://www.php.net/)
-   [MySQL](https://www.mysql.com/)
-   [Redis](https://redis.io/)
-   [MailHog](https://github.com/mailhog/MailHog)
-   [Docker](https://www.docker.com/)

##  📚 Documentation

Access these two routes to view the documentation:

- **`/docs/api`** – Interactive UI for exploring your API documentation.
- **`/docs/api.json`** – JSON file containing the OpenAPI specification of your API.


## 🚀 Installation and Setup

### Prerequisites

To ensure everything is properly set up and that the project connects with the external API, follow these official installation guides:

-   [Laravel Installing PHP Docs](https://laravel.com/docs/12.x/installation#installing-php)
-   [Docker Installing Docs](https://docs.docker.com/engine/install/)
-   [Takeout Installing Docs](https://github.com/tighten/takeout)

### Installation Steps

1. **Clone the repository**

    ```sh
    git clone https://github.com/lucalana/simple-bank.git
    cd simple-bank
    ```

2. **Install dependencies**

    ```sh
    composer install
    ```

3. **Create and configure the .env file**

    ```sh
    cp .env.example .env
    ```

4. **Generate the application key**

    ```sh
    php artisan key:generate
    ```

5. **Start the services**
    ```sh
    takeout enable
    ```

## 🛠 Usage

-   Run migrations and seed
```sh
php artisan migrate:fresh --seed
```
-   Run queues
  ```sh
  php artisan queue:work
  ```
