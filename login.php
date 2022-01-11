<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require_once "functions.php";
    require_once "connection.php";

    session_start(['name' => 'IN']);
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    {
        echo "<p class='success'>Вы успешно авторизованы!</p>";
        echo "<a href='catFacts.php'>Насладиться фактами о котах</a>";
    }
    else
    {
        echo "<p>Если вы еще не зарегистрированы, зарегистрируйтесь: <a href='register.php'>Регистрация</a></p>";

        if (!isset($_SESSION['capt'])) $_SESSION['capt'] = rnd();
        echo $_SESSION['capt']; ///////////////////////
        generateForm('Авторизация'); // форма

        if (isset($_POST['submit']))
        {
            if (trim($_POST['captcha']) == $_SESSION['capt'])
            {

                if (trim($_POST['name']) != "" && trim($_POST['password']) != "")
                {

                    if (checkUser($_POST['name'], $connection) == true)
                    {
                        if (checkPassword($_POST['name'], $_POST['password'], $connection))
                        {
                            login($_POST['name'], $connection);
                            $_SESSION['logged'] = true;
                            $_SESSION['capt'] = rnd();
                            header('Location: login.php');
                        }
                        else
                        {
                            echo "<p class='danger'>Неверный пароль!</p>";
                            $_SESSION['capt'] = rnd();
                        }
                    }
                    else if (checkUser(trim($_POST['name']), $connection) == false)
                    {
                        echo "<p class='danger'>Данный пользователь не найден!</p>";
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