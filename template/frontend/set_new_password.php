<?php
if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {

    $id = intval($_COOKIE['id']);

    $sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    $sth->execute();
    $userdata = $sth->fetchAll(PDO::FETCH_ASSOC);

    if (($userdata[0]['hash'] == $_COOKIE['hash']) or ($userdata[0]['id'] == $_COOKIE['id'])) {


        header("Location: /dashboard");
    }
}

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header("Location: /reset_password");
}

if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
} else {
    header("Location: /reset_password");
}
$sth = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
$sth->execute();
$email_check = $sth->fetchAll(PDO::FETCH_ASSOC);

if (isset($email_check[0]['email']) && $email_check[0]['reset_password_token'] == $token) {
?>
    <!DOCTYPE html>
    <html lang="ru">
    <?php require_once 'header.php'; ?>

    <body>
        <!-- Loader -->
        <!-- <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> -->
        <!-- Loader -->
        <?php
        require_once 'new_password.php';
        require_once 'footer.php';
        ?>

    </body>

    </html>
<?php
} else {
    header("Location: /reset_password");
}

?>