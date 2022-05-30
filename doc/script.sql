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
