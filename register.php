<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require_once "functions.php";
    require_once "connection.php";

    session_start(['name' => 'IN']);
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    {
        echo "<p class='success'>Вы успешно зарегистрированы и авторизованы!</p>";
        echo "<a href='catFacts.php'>Насладиться фактами о котах</a>";
    }
    else
    {
        $_SESSION['logged'] = false;
        echo "<p>Если вы уже зарегистрированы, авторизуйтесь: <a href='login.php'>Авторизация</a></p>";

        if (!isset($_SESSION['capt'])) $_SESSION['capt'] = rnd();
        echo $_SESSION['capt']; ///////////////////////
        generateForm('Регистрация'); // форма

        if (isset($_POST['submit']))
        {
            if (trim($_POST['captcha']) == $_SESSION['capt'])
            {

                if (trim($_POST['name']) != "" && trim($_POST['password']) != "")
                {

                    if (checkUser($_POST['name'], $connection) == false)
                    {
                        register($_POST['name'], $_POST['password'], $connection);
                        $_SESSION['logged'] = true;
                        $_SESSION['capt'] = rnd();
                        header('Location: register.php');
                    }
                    else if (checkUser(trim($_POST['name']), $connection) == true)
                    {
                        echo "<p class='danger'>Данный пользователь уже зарегистрирован!</p>";
                        $_SESSION['capt'] = rnd();
                    }
                }
                else
                {
                    echo "<p class='danger'>Вы заполнили не все поля!</p>";
                    $_SESSION['capt'] = rnd();
                }

            }
            else
            {
                echo "<p class='danger'>Код с картинки введён неправильно или не введён!</p>";
                $_SESSION['capt'] = rnd();
            }
        }
    }
    ?>
</body>
</html>