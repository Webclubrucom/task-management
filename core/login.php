<?php

require_once 'db.php';

if ($_POST['check_email']) {
    $email = $_POST['check_email'];

    $sth = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
    $sth->execute();
    $user_check = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
	<?php echo $user_check[0]['email']; ?>
<?php

}



if ($_POST['autorize_check']) {

    function generateCode($length = 6)
    {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";

        $code = "";

        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0, $clen)];
        }

        return $code;
    }

    # Вытаскиваем из БД запись, у которой логин равняеться введенному

    $email = trim($_POST['autorize_check']);

    $sth = $pdo->prepare("SELECT `id`, `password` FROM `users` WHERE `email` = '$email' LIMIT 1");
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);

    $id = $data[0]['id'];



    # Соавниваем пароли

    if ($data[0]['password'] === md5($_POST['password'])) {

        # Генерируем случайное число и шифруем его

        $hash = md5(generateCode(10));

        # Записываем в БД новый хеш авторизации

        $sth = $pdo->prepare("UPDATE `users` SET `hash` = :hash WHERE `id` = :id");
        $sth->execute(array('hash' => $hash, 'id' => $id));

        # Ставим куки

        setcookie("id", $id, time() + 60 * 60 * 24 * 1, "/");

        setcookie("hash", $hash, time() + 60 * 60 * 24 * 1, "/");

        # Переадресовываем браузер на dashboard
        header("Location: /dashboard");
        // exit();
    } else {
        echo "1";
    }
}

if ($_POST['check_email_reset']) {
    $email = $_POST['check_email_reset'];

    $sth = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
    $sth->execute();
    $user_check = $sth->fetchAll(PDO::FETCH_ASSOC);

    echo $user_check[0]['email'];
}

if ($_POST['send_email_reset_password']) {
    $email = $_POST['send_email_reset_password'];

    $token = md5($email . time());

    $sth = $pdo->prepare("UPDATE `users` SET `reset_password_token` = :token WHERE `email` = :email");
    $sth->execute(array('token' => $token, 'email' => $email));

    $sth = $pdo->prepare("SELECT * FROM `settings`");
    $sth->execute();
    $settings = $sth->fetchAll(PDO::FETCH_ASSOC);

    $email_site = $settings[3]['value'];
    $title_site = $settings[0]['value'];

    //Составляем ссылку на страницу установки нового пароля.
    $link_reset_password = $_SERVER['HTTP_HOST'] . "/set_new_password?email=$email&token=$token";

    //Составляем заголовок письма
    $subject = "Восстановление пароля от сайта " . $title_site;

    //Составляем тело сообщения
    $message = 'Здравствуйте! <br/> <br/> Для восстановления пароля от сайта <a href="http://' . $_SERVER['HTTP_HOST'] . '"> ' . $title_site . ' </a>, перейдите по этой <a href="' . $link_reset_password . '">ссылке</a>.';

    //Составляем дополнительные заголовки для почтового сервиса mail.ru
    //Переменная $email_admin, объявлена в файле dbconnect.php
    $headers = "FROM: $email_site\r\nReply-to: $email_site\r\nContent-type: text/html; charset=utf-8\r\n";

    //Отправляем сообщение с ссылкой на страницу установки нового пароля и проверяем отправлена ли она успешно или нет. 
    if (mail($email, $subject, $message, $headers)) {

        echo $email;
    }
}

if ($_POST['update_password']) {
    $password = md5($_POST['update_password']);
    $email = $_POST['email'];

    $sth = $pdo->prepare("UPDATE `users` SET `password` = :password WHERE `email` = :email");
    $sth->execute(array('password' => $password, 'email' => $email));
}
