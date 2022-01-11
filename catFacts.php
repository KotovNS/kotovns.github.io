<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat facts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require_once "functions.php";

    session_start(['name' => 'IN']);
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false)
    {
        echo "<p>Авторизуйтесь, чтобы просматривать факты о котах: <a href='login.php'>Авторизация</a></p>";
        echo "<p>Если вы еще не зарегистрированы, зарегистрируйтесь: <a href='register.php'>Регистрация</a></p>";
    }
    elseif ($_SESSION['logged'] == true)
    {
        echo getFact();
    }
    ?>
</body>
</html>