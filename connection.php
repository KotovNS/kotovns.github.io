<?php
try
{
    $connection = new PDO('mysql:host=localhost;dbname=vhostbg3_kotov', 'vhostbg3_kotov', 'u8QRz&TG');
    // $connection = new PDO('mysql:host=localhost;dbname=test3', 'root', '');
}
catch (PDOException $e)
{
    echo "Невозможно установить соединение с БД";
}

$create = "CREATE TABLE IF NOT EXISTS `test3`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `register_date` DATETIME NOT NULL , `last_visit_date` DATETIME NOT NULL , PRIMARY KEY (`id`, `name`)) ENGINE = InnoDB;";

try
{
    $connection->exec($create);
}
catch (PDOException $e)
{
    $e->getMessage;
}