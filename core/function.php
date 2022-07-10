<?php

$db = ROOT . 'core/db.php';
$model = ROOT . 'core/model.php';
$dashboard = ROOT . 'template/backend/index.php';
$header = ROOT . 'template/backend/header.php';
$board = ROOT . 'template/backend/board.php';

$login = ROOT . 'template/frontend/index.php';

$footer = ROOT . 'template/backend/footer.php';
$styles = ROOT . 'template/backend/includes/styles.php';
$scripts = ROOT . 'template/backend/includes/scripts.php';



require_once $db;
$page = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if ($page === '/') {
    $title_page = 'Авторизация';
    require_once $login;
} elseif ($page === '/dashboard') {
    require_once 'template/backend/index.php';
} elseif ($page === '/reset_password') {
    $title_page = 'Сброс пароля';
    require_once 'template/frontend/reset_password.php';
} elseif ($page === '/set_new_password') {
    $title_page = 'Новый пароль';
    require_once 'template/frontend/set_new_password.php';
} else {
    echo 'Ошибка 404';
}
