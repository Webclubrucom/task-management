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
    require_once 'main.php';
    require_once 'footer.php';
    ?>
</body>

</html>