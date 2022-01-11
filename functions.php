<?php
require_once "connection.php";

/**
 * Рандомные цифры
 */
function rnd()
{
    $capt = "";

    for ($i = 0; $i < 5; $i++)
    {
        $capt .= random_int(0, 9);
    }
    return $capt;
}

/**
 * Проверка на существование
 */
function checkUser($name, $connection)
{
    $name = trim($name);

    $query = "SELECT count(*) FROM `users` WHERE `name` = '$name';";
    $res = $connection->query($query);
    try
    {
        $result = $res->fetch();
    }
    catch (PDOException $e)
    {
        $e->getMessage;
    }

    return $result[0] != 0;
}

/**
 * Регистрация
 */
function register($name, $pass, $connection)
{
    $name = trim($name);
    $pass = trim($pass);

    $query = "INSERT INTO `users` (`name`, `password`, `register_date`, `last_visit_date`) VALUES ('$name', '$pass', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');";
    try
    {
        $res = $connection->exec($query);
    }
    catch (PDOException $e)
    {
        $e->getMessage;
    }
}

/**
 * GET-запрос факта
 */
function getFact()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://catfact.ninja/fact");
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $factJSON = curl_exec($curl);
    curl_close($curl);
    $factClass = json_decode($factJSON);
    return "<h1>$factClass->fact</h1>";
}

/**
 * Проверка пароля
 */
function checkPassword($name, $pass, $connection)
{
    $name = trim($name);
    $pass = trim($pass);

    $query = "SELECT * FROM `users` WHERE `name` = '$name';";
    $res = $connection->query($query);
    try
    {
        $result = $res->fetch();
    }
    catch (PDOException $e)
    {
        $e->getMessage;
    }

    return $result['password'] == $pass;
}

/**
 * Форма
 */
function generateForm($type)
{
    echo <<<END
    <form action="{$_SERVER['SCRIPT_NAME']}" method="POST">
        <h1>$type</h1>
        <input type="text" name="name" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <img src="captcha.php" alt="Капча">
        <input type="text" name="captcha" placeholder="Код с картинки">
        <input type="submit" name="submit" value="Отправить">
    </form>
    END;
}

/**
 * Логин
 * 
 * Обновляет дату последнего посещения
 */
function login($name, $connection)
{
    $name = trim($name);

    $query = "UPDATE `users` SET `last_visit_date` = '".date("Y-m-d H:i:s")."' WHERE `name` = '$name';";
    try
    {
        $res = $connection->exec($query);
    }
    catch (PDOException $e)
    {
        $e->getMessage;
    }
}