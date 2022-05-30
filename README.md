Docker running Nginx, PHP-FPM, Composer, MySQL and PHPMyAdmin.

### Images to use

* [Nginx](https://hub.docker.com/_/nginx/)
* [MySQL](https://hub.docker.com/_/mysql/)
* [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)
* [Composer](https://hub.docker.com/_/composer/)
* [PHPMyAdmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)

You should be careful when installing third party web servers such as MySQL or Nginx.

This project use the following ports :

| Server     | Port |
|------------|------|
| MySQL      | 8989 |
| PHPMyAdmin | 8080 |
| Nginx      | 8000 |

___

## Run the application
1. Start the application :

    ```sh
    docker-compose up -d
    ```

    **Please wait this might take a several minutes...**

    ```sh
    docker-compose logs -f # Follow log output
    ```

2. Open your favorite browser :

    * [http://localhost:8000](http://localhost:8000/)
    * [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (username: root, password: root)

3. Stop and clear services

    ```sh
    docker-compose down -v
    ```
___

## Use Docker commands

### Installing package with composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer require symfony/yaml
```

### Updating PHP dependencies with composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer update
```

### Generating PHP API documentation

```sh
docker run --rm -v $(pwd):/data phpdoc/phpdoc -i=vendor/ -d /data/web/app/src -t /data/web/app/doc
```

### Checking installed PHP extensions

```sh
docker-compose exec php php -m
```

### Handling database

#### MySQL shell access

```sh
docker exec -it mysql bash
```

and

```sh
mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD"
```

#### Connecting MySQL from [PDO](http://php.net/manual/en/book.pdo.php)

```php
<?php
    try {
        $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
        $pdo = new PDO($dsn, 'dev', 'dev');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
```

## run mysql script

```sh
create database real_estate_rental;

use real_estate_rental;

CREATE TABLE `real_estate_rental`.`clients` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `real_estate_rental`.`owners` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `day_to_pass_on` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `real_estate_rental`.`properties` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `address` TEXT NOT NULL,
    `owner_id` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `real_estate_rental`.`contracts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `property_id` INT NOT NULL,
    `owner_id` INT NOT NULL,
    `client_id` INT NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `administrative_fee` DECIMAL(10,2) NOT NULL,
    `rent_value` DECIMAL(10,2) NOT NULL,
    `condominium_value` DECIMAL(10,2) NOT NULL,
    `iptu_value` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `real_estate_rental`.`monthly_fees` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `contract_id` INT NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `value` DECIMAL(10,2) NOT NULL,
    `reference_month` DATE NOT NULL,
    `expiration` DATE NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `real_estate_rental`.`transfers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `monthlyfee_id` INT NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `value` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE properties
ADD FOREIGN KEY (owner_id) REFERENCES owners(id);

ALTER TABLE contracts
ADD FOREIGN KEY (property_id) REFERENCES properties(id);
ALTER TABLE contracts
ADD FOREIGN KEY (owner_id) REFERENCES owners(id);
ALTER TABLE contracts
ADD FOREIGN KEY (client_id) REFERENCES clients(id);

ALTER TABLE monthly_fees
ADD FOREIGN KEY (contract_id) REFERENCES contracts(id);

ALTER TABLE transfers
ADD FOREIGN KEY (monthly_fee_id) REFERENCES monthly_fees(id);

```


___

# API PHP

## Clients
curl --location --request GET 'http://localhost:8000/?route=client_all' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json'

```sh
{
    "body": [
        {
            "id": "4",
            "name": "Markus Lima",
            "email": "mkbits@mkbits.com.br",
            "phone": "21986214127"
        },
        {
            "id": "5",
            "name": "Jack Padarai Badilari",
            "email": "jack@padarai.com.br",
            "phone": "219861616161"
        }
    ],
    "msg": "success"
}
```


curl --location --request GET 'http://localhost:8000/?route=client_find&params=7' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'

```sh
{
    "body": [
        {
            "id": "6",
            "name": "Jack Padarai Badilari",
            "email": "jack@mkbits.com.br",
            "phone": "219861616161"
        }
    ],
    "msg": "success"
}
```

```sh
{
    "body": [],
    "msg": "not found"
}
```

curl --location --request POST 'http://localhost:8000/?route=client_add' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Jack Padarai Badilari",
    "email": "jack@mkbits.com.br",
    "phone": "219861616161"
}

```sh
{
    "msg": "already exists"
}
```

```sh
{
    "body": [
        {
            "id": "11",
            "name": "Markus Lima",
            "email": "markus@mkbits.com.br",
            "phone": "219861214127"
        }
    ],
    "msg": "success"
}
```

curl --location --request POST 'http://localhost:8000/?route=client_update&params=7' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Jack Padarai Badilari",
    "email": "jack@padarai.com",
    "phone": "219861616161"
}'

```sh
{
    "msg": "not found"
}
```

```sh
{
    "body": {
        "id": "10",
        "name": "Jack Padarai Badilari",
        "email": "jack@padarai.com",
        "phone": "219861616161"
    },
    "msg": "success"
}
```

curl --location --request GET 'http://localhost:8000/?route=client_delete&params=7'
```sh
{
    "msg": "not found"
}
```
```sh
{
    "msg": "success"
}
```

## All other endpoints are the same structure
### Owner ...
### Property ...
### Contract ...
### Monthly fee ...
### Transfer ...


## Visual of the application
![App Screenshot](https://github.com/MarkusLima/Docker_Nginx_Php_Mysql/blob/master/doc/diagrama_relacional.png)
![App Screenshot](https://github.com/MarkusLima/Docker_Nginx_Php_Mysql/blob/master/doc/Capturar.PNG)
![App Screenshot](https://github.com/MarkusLima/Docker_Nginx_Php_Mysql/blob/master/doc/Capturar1.PNG)
![App Screenshot](https://github.com/MarkusLima/Docker_Nginx_Php_Mysql/blob/master/doc/Capturar2.PNG)
![App Screenshot](https://github.com/MarkusLima/Docker_Nginx_Php_Mysql/blob/master/doc/Capturar3.PNG)



