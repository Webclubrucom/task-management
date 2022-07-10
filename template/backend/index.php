<?php
//var_dump($_COOKIE['id']);
if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {

	$id = intval($_COOKIE['id']);

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
	$sth->execute();
	$userdata = $sth->fetchAll(PDO::FETCH_ASSOC);

	if (($userdata[0]['hash'] !== $_COOKIE['hash']) or ($userdata[0]['id'] !== $_COOKIE['id'])) {

		setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");

		setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");

		header("Location: /");
	}
} else {

	header("Location: /");
	exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<?php include $header; ?>

<body onload="clockTimer();">
	<?php include $board; ?>
	<?php include $footer; ?>
</body>

</html>