<?php

$sth = $pdo->prepare("SELECT * FROM `lists` ORDER BY position");
$sth->execute();
$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->prepare("SELECT * FROM `tasks` ORDER BY position");
$sth->execute();
$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->prepare("SELECT * FROM `settings`");
$sth->execute();
$settings = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->prepare("SELECT * FROM `task_color`");
$sth->execute();
$taskColors = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->query("SELECT * FROM `attachments`");
$sth->execute();
$attachments = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->query("SELECT * FROM `checklists`");
$sth->execute();
$checklists = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->query("SELECT * FROM `checklists_line`");
$sth->execute();
$checklists_line = $sth->fetchAll(PDO::FETCH_ASSOC);

$dir    = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/background/uploads/';
$bacgrounds = array_diff(scandir($dir), array('..', '.'));

$sth = $pdo->query("SELECT * FROM `users`");
$sth->execute();
$users = $sth->fetchAll(PDO::FETCH_ASSOC);

if (isset($_COOKIE['id'])) {
    $id_current_user = $_COOKIE['id'];
    $sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
    $sth->execute();
    $userdata = $sth->fetchAll(PDO::FETCH_ASSOC);
}

$sth = $pdo->query("SELECT * FROM `comments`");
$sth->execute();
$comments = $sth->fetchAll(PDO::FETCH_ASSOC);

$id_block_group_contacts = '1';
$sth = $pdo->prepare("SELECT `title` FROM `block_contacts_group` WHERE `id` = '$id_block_group_contacts' LIMIT 1");
$sth->execute();
$id_block_group_contacts = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->query("SELECT * FROM `contacts_group` ORDER BY position");
$sth->execute();
$contacts_groups = $sth->fetchAll(PDO::FETCH_ASSOC);
