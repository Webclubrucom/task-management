<?php


require_once 'db.php';

require_once 'thumbs.php';

if ($_POST['add_list']) {
	$title = $_POST['add_list'];
	$sth = $pdo->prepare("INSERT INTO `lists` SET `title` = :title");
	$sth->execute(array('title' => $title));

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['change_title_list']) {
	$title = htmlspecialchars($_POST['change_title_list']);
	$id = $_POST['id'];
	$sth = $pdo->prepare("UPDATE `lists` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => $title, 'id' => $id));
}

if ($_POST['del_list']) {
	$id = $_POST['del_list'];
	$count = $pdo->exec("DELETE FROM `lists` WHERE `id` = $id");
	$count = $pdo->exec("DELETE FROM `tasks` WHERE `list_id` = $id");
}

if ($_GET['order_list']) {
	if (isset($_GET["order_list"])) {
		$order  = explode(",", $_GET["order_list"]);
		for ($i = 0; $i < count($order); $i++) {
			$sth =  $pdo->prepare("UPDATE lists SET position='" . $i . "' WHERE id=" . $order[$i]);
			$sth->execute();
		}
	}
}

if ($_GET['order_check']) {
	if (isset($_GET["order_check"])) {
		$order  = explode(",", $_GET["order_check"]);
		for ($i = 0; $i < count($order); $i++) {
			$sth =  $pdo->prepare("UPDATE checklists_line SET position='" . $i . "' WHERE id=" . $order[$i]);
			$sth->execute();
		}
	}
}

if ($_POST['add_task']) {



	$sth = $pdo->prepare("INSERT INTO `tasks` SET `title` = :title, `list_id` = :list_id");
	$sth->execute(array('title' => htmlspecialchars($_POST['add_task']), 'list_id' => $_POST['list_id']));

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_GET['order_task']) {
	if (isset($_GET["order_task"])) {
		$order  = explode(",", $_GET["order_task"]);
		for ($i = 0; $i < count($order); $i++) {
			$sth =  $pdo->prepare("UPDATE tasks SET position='" . $i . "' WHERE id=" . $order[$i]);
			$sth->execute();
		}
	}
}

if ($_POST['task_list_id']) {
	$sth = $pdo->prepare("UPDATE `tasks` SET `list_id` = :list_id WHERE `id` = :id");
	$sth->execute(array('list_id' => $_POST['task_list_id'], 'id' => $_POST['id']));
}

if ($_POST['check_background']) {
	$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = :key_field");
	$sth->execute(array('value' => $_POST['check_background'], 'key_field' => 'background'));
}

if ($_FILES['upload_background']) {
	if (0 < $_FILES['upload_background']['error']) {
		echo 'Error: ' . $_FILES['upload_background']['error'] . '<br>';
	} else {

		$type_files = array('jpg', 'jpeg', 'png', 'gif');
		$tmp_name = $_FILES['upload_background']['tmp_name'];
		$file_name = $_FILES['upload_background']['name'];
		$url_path  = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/background/uploads/';
		$ext = mb_strtolower(mb_substr(mb_strrchr(@$file_name, '.'), 1));

		if (!is_dir($url_path)) {
			mkdir($url_path, 0777, true);
		}

		$url_file_name = $url_path . $file_name;

		if (file_exists($url_file_name)) {

			$file_name  = time() . '-' . $file_name;
		}

		if (empty($ext) || !in_array($ext, $type_files)) {
			$error = 'Недопустимый тип файла';
		} else {

			$params['thumbnail'] = date('d.m.y') . '/' . $file_name;

			move_uploaded_file($tmp_name, $url_path . $file_name);
		}
	}

	$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = :key_field");
	$sth->execute(array('value' => $file_name, 'key_field' => 'background'));

	$dir    = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/background/uploads/';
	$bacgrounds = array_diff(scandir($dir), array('..', '.'));

	foreach ($bacgrounds as $bacground) : ?>
		<div class="section_img">
			<input type="radio" name="background" class="check_img" id="<?= $bacground ?>'" value="<?= $bacground ?>">
			<label for="<?= $bacground ?>'" class="bacground_img" style="background: url('/template/backend/assets/images/background/uploads/<?= $bacground ?>') center / cover no-repeat; transition: background 1s ease"></label>
		</div>
	<?php endforeach;
}

if ($_POST['changeTitleTask']) {
	$sth = $pdo->prepare("UPDATE `tasks` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => htmlspecialchars($_POST['changeTitleTask']), 'id' => $_POST['id']));


	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['editDescriptionTask']) {
	$sth = $pdo->prepare("UPDATE `tasks` SET `description` = :description WHERE `id` = :id");
	$sth->execute(array('description' => htmlspecialchars($_POST['editDescriptionTask']), 'id' => $_POST['id']));


	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['addColor']) {
	$sth = $pdo->prepare("INSERT INTO `color_tags` SET `color` = :color");
	$sth->execute(array('color' => trim($_POST['addColor'])));

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<p class="del_color" data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>
	<?php
	}
}

if ($_POST['color_all']) {

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<p class="del_color" data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>
	<?php
	}
}

if ($_POST['modalTagsNew']) {

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<div class="modal_tag">
			<p data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>
		</div>

	<?php
	}
}

if ($_POST['color_all_sidebar']) {

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<div class="modal_tag">
			<p data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>
		</div>


	<?php
	}
}


if ($_POST['add_color_task']) {

	$id_task = $_POST['id_task'];
	$id_color = trim($_POST['add_color_task']);
	$id_color_id = trim($_POST['id_color']);

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task' AND id_color='$id_color'");
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);

	if (!$result) {
		if ($id_color_id != '0' || $id_color_id > 0 || $id_color != 'undefined') {
			$sth = $pdo->prepare("INSERT INTO `task_color` SET `id_task` = :id_task, `id_color` = :id_color, `id_color_id` = :id_color_id");
			$sth->execute(array('id_task' => $id_task, 'id_color' => $id_color, 'id_color_id' => $id_color_id));
		}
	}
	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTask = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTask as $colorTask) {
	?>
		<div class="modal_tag header_modal_tag">
			<p data-color="<?php echo $colorTask['id_color']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" data-id="<?php echo $colorTask['id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></p>
		</div>
	<?php
	}
}

if ($_POST['color_all_appened']) {

	$id_task = $_POST['id_task'];

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTaskAppened = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTaskAppened as $colorTask) {

	?>
		<div class="modal_tag header_modal_tag">
			<p data-color="<?php echo $colorTask['id_color']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" data-id="<?php echo $colorTask['id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></p>
		</div>
	<?php
	}
}

if ($_POST['add_color_task_destop']) {

	$id_task = $_POST['id_task'];

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTaskDesctop = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTaskDesctop as $colorTask) {

	?>

		<div class="tag" data-id="<?php echo $colorTask['id']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></div>
	<?php
	}
}


if ($_POST['del_color_task']) {
	$id = $_POST['del_color_task'];
	$id_task = $_POST['id_task'];

	$count = $pdo->exec("DELETE FROM `task_color` WHERE `id` = $id");

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTaskAppened = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTaskAppened as $colorTask) {

	?>
		<div class="modal_tag header_modal_tag">
			<p data-color="<?php echo $colorTask['id_color']; ?>" data-id="<?php echo $colorTask['id']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></p>
		</div>
	<?php
	}
}

if ($_POST['delete_item_color_task']) {
	$id_task = $_POST['delete_item_color_task'];

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTasks as $colorTask) {

	?>
		<div class="tag" data-id="<?php echo $colorTask['id']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></div>
	<?php
	}
}

if ($_POST['delete_color']) {
	$id_task = $_POST['delete_color'];
	$id_color = $_POST['hex_color'];
	$id_color_id = $_POST['id_color_id'];

	$count = $pdo->exec("DELETE FROM `color_tags` WHERE `id` = $id_task");
	$coun2 = $pdo->exec("DELETE FROM `task_color` WHERE `id_color_id` = $id_task");

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<div class="modal_tag">
			<p data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>
		</div>


	<?php
	}
}

if ($_POST['delete_block_color']) {
	$id_task = $_POST['delete_block_color'];

	$sth = $pdo->prepare("SELECT * FROM color_tags");
	$sth->execute();
	$colors = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colors as $color) {
		//var_dump($color)
	?>
		<p class="del_color" data-color="<?php echo $color['color']; ?>" data-id="<?php echo $color['id']; ?>" style="background:<?php echo $color['color']; ?>;"></p>

	<?php
	}
}

if ($_POST['delete_task_color_desctop']) {
	$id_task = $_POST['delete_task_color_desctop'];

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['delete_task_color_modal_task']) {
	$id_task = $_POST['delete_task_color_modal_task'];

	$sth = $pdo->prepare("SELECT * FROM task_color WHERE id_task='$id_task'");
	$sth->execute();
	$colorsTasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($colorsTasks as $colorTask) {

	?>
		<div class="modal_tag header_modal_tag">
			<p data-color="<?php echo $colorTask['id_color']; ?>" data-idcolor="<?php echo $colorTask['id_color_id']; ?>" data-id="<?php echo $colorTask['id']; ?>" style="background:<?php echo $colorTask['id_color']; ?>;"></p>
		</div>
	<?php
	}
}

if ($_POST['delete_task']) {
	$id = $_POST['delete_task'];
	$count = $pdo->exec("DELETE FROM `tasks` WHERE `id` = $id");
	$count = $pdo->exec("DELETE FROM `task_color` WHERE `id_task` = $id");

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['input_date']) {
	$period = $_POST['input_date'];
	$id = $_POST['id_task'];

	$sth = $pdo->prepare("UPDATE `tasks` SET `period` = :period WHERE `id` = :id");
	$sth->execute(array('period' => $period, 'id' => $id));

	$sth = $pdo->prepare("SELECT `period` FROM `tasks` WHERE `id` = '$id'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['period'] != '1') {
		echo $data[0]['period'] . ' года';
	} else {
	}
}

if ($_POST['modal_data']) {

	$id = $_POST['modal_data'];


	$sth = $pdo->prepare("SELECT `period` FROM `tasks` WHERE `id` = '$id'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['period'] != '1') {

	?>
		<div class="period"><span>
				<?php echo 'Срок: ' . $data[0]['period'] . ' года'; ?>
			</span>
			<!--<span class="badge color_success">Выполнено</span>-->
		</div>
	<?php
	}
}

if ($_POST['task_data']) {

	$id = $_POST['task_data'];


	$sth = $pdo->prepare("SELECT `period` FROM `tasks` WHERE `id` = '$id'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['period'] != '1') {

	?>

		<span class="span_clip"><i class="fal fa-clock"></i> <?php echo substr($data[0]['period'], 0, -5); ?></span>

	<?php
	}
}

if ($_POST['view_date_task_info']) {

	$id = $_POST['view_date_task_info'];

	$sth = $pdo->prepare("SELECT `period` FROM `tasks` WHERE `id` = '$id'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['period'] != '1') {
		echo $data[0]['period'] . ' года';
	}
}

if ($_POST['view_date_task_date']) {

	$id = $_POST['view_date_task_date'];


	$sth = $pdo->prepare("SELECT `period` FROM `tasks` WHERE `id` = '$id'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['period'] != '1') {

	?>
		<div class="period"><span>
				<?php echo 'Срок: ' . $data[0]['period'] . ' года'; ?>
			</span>
			<!--<span class="badge color_success">Выполнено</span>-->
		</div>
		<?php
	}
}

if ($_POST['upload_file_task']) {
	// Название <input type="file">
	$input_name = 'file';

	// Разрешенные расширения файлов.
	$allow = array(
		'js', 'json', 'php', 'html', 'htm', 'css', 'sql', 'htaccess', 'jpg', 'jpeg', 'png', 'gif', 'pdf', 'webp', 'zip', 'rar', 'pdf', 'doc', 'docx', 'dotx', 'xlsx', 'xltx', 'pptx', 'ppsx', 'potx', 'mp3', 'mp4'

	);

	// Запрещенные расширения файлов.
	$deny = array(
		'phtml', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
		'aspx', 'shtml', 'shtm', 'htpasswd', 'ini', 'log', 'sh',
		'spl', 'scgi', 'fcgi', 'exe'
	);

	// Директория куда будут загружаться файлы.
	$path = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/';

	if (isset($_FILES[$input_name])) {

		// Преобразуем массив $_FILES в удобный вид для перебора в foreach.
		$files = array();
		$diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
		if ($diff == 0) {
			$files = array($_FILES[$input_name]);
		} else {
			foreach ($_FILES[$input_name] as $k => $l) {
				foreach ($l as $i => $v) {
					$files[$i][$k] = $v;
				}
			}
		}

		foreach ($files as $file) {

			if (empty($file['error']) || !empty($file['tmp_name'])) {

				$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
				$name = mb_eregi_replace($pattern, '-', $_POST['file_name']);
				$name = mb_ereg_replace('[-]+', '-', $name);
				$parts = pathinfo($name);

				if (in_array(strtolower($parts['extension']), $allow) && !in_array(strtolower($parts['extension']), $deny)) {

					if (move_uploaded_file($file['tmp_name'], $path . $name)) {



						$sth = $pdo->prepare("INSERT INTO `attachments` SET `name_file` = :name_file, `id_task` = :id_task");
						$sth->execute(array('name_file' => $name, 'id_task' => $_POST['id_task']));

						if ($parts['extension'] == 'jpg' || $parts['extension'] == 'jpeg' || $parts['extension'] == 'png' || $parts['extension'] == 'webp' || $parts['extension'] == 'gif') {
							$image = new Thumbs($path . $name);
							$image->thumb(300, 200);
							$image->save($path . "thumb-" . $name);
						}


						$sth = $pdo->prepare("SELECT * FROM attachments");
						$sth->execute();
						$attachments = $sth->fetchAll(PDO::FETCH_ASSOC);

						foreach ($attachments as $attachment) {
							if ($attachment['id_task'] == $_POST['id_task']) {
								$type_file = pathinfo($dir . $attachment['name_file'], PATHINFO_EXTENSION);
								$name_file = $attachment['name_file'];
								$name_file = substr(strstr($name_file, '-'), 1, strlen($name_file));

								$path_img = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/';
								if ($type_file == 'jpg' || $type_file == 'jpeg' || $type_file == 'png' || $type_file == 'gif' || $type_file == 'webp') {

		?>
									<div class="attachment_item">
										<a data-fancybox="gallery" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
											<div class="attachment_img" style="background: url('template/backend/uploads/thumb-<?php echo $attachment['name_file']; ?>') center / cover no-repeat; transition: background 1s ease;"></div>
										</a>
										<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
									</div>
								<?php
								} elseif ($type_file == 'mp4') {
								?>
									<div class="attachment_item">
										<a class="video_fun" data-fancybox href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
											<div class="attachment_file"><?php echo $type_file; ?></div>
											<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
										</a>
										<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
									</div>
								<?php
								} elseif ($type_file == 'mp3') {


								?>
									<div class="attachment_item audio">

										<a data-fancybox="S" data-type="video" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">


											<div class="attachment_file"><?php echo $type_file; ?></div>
											<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
										</a>
										<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
									</div>

								<?php
								} elseif ($type_file == 'pdf') {
								?>
									<div class="attachment_item">
										<a target="_blank" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
											<div class="attachment_file"><?php echo $type_file; ?></div>
											<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
										</a>
										<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
									</div>
								<?php
								} else {
								?>
									<div class="attachment_item">
										<a download href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
											<div class="attachment_file"><?php echo $type_file; ?></div>
											<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
										</a>

										<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
									</div>
				<?php
								}
							}
						}
					}
				}
			}
		}
	}
}

if ($_POST['view_file_task']) {
	$sth = $pdo->prepare("SELECT * FROM attachments");
	$sth->execute();
	$attachments = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($attachments as $attachment) {
		if ($attachment['id_task'] == $_POST['id_task']) {
			$type_file = pathinfo($dir . $attachment['name_file'], PATHINFO_EXTENSION);
			$name_file = $attachment['name_file'];
			$name_file = substr(strstr($name_file, '-'), 1, strlen($name_file));

			$path_img = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/';
			if ($type_file == 'jpg' || $type_file == 'jpeg' || $type_file == 'png' || $type_file == 'gif' || $type_file == 'webp') {

				?>
				<div class="attachment_item">
					<a data-fancybox="gallery" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_img" style="background: url('template/backend/uploads/thumb-<?php echo $attachment['name_file']; ?>') center / cover no-repeat; transition: background 1s ease;"></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} elseif ($type_file == 'mp4') {
			?>
				<div class="attachment_item">
					<a class="video_fun" data-fancybox href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} elseif ($type_file == 'mp3') {
			?>
				<div class="attachment_item audio">
					<a data-fancybox="S" data-type="iframe" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} elseif ($type_file == 'pdf') {
			?>
				<div class="attachment_item">
					<a target="_blank" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} else {
			?>
				<div class="attachment_item">
					<a download href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>

					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			}
		}
	}
}


if ($_POST['delete_file']) {

	$id = $_POST['delete_file'];
	$id_task = $_POST['id_task'];

	$sth = $pdo->prepare("SELECT `name_file` FROM `attachments` WHERE `id` = $id");
	$sth->execute();
	$name_file = $sth->fetch(PDO::FETCH_ASSOC);


	$count = $pdo->exec("DELETE FROM `attachments` WHERE `id` = $id");

	$sth = $pdo->prepare("SELECT * FROM attachments");
	$sth->execute();
	$attachments = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($attachments as $attachment) {
		if ($attachment['id_task'] == $_POST['id_task']) {
			$type_file = pathinfo($dir . $attachment['name_file'], PATHINFO_EXTENSION);
			$name_file = $attachment['name_file'];
			$name_file = substr(strstr($name_file, '-'), 1, strlen($name_file));

			$path_img = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/';
			if ($type_file == 'jpg' || $type_file == 'jpeg' || $type_file == 'png' || $type_file == 'gif' || $type_file == 'webp') {

			?>
				<div class="attachment_item">
					<a data-fancybox="gallery" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_img" style="background: url('template/backend/uploads/thumb-<?php echo $attachment['name_file']; ?>') center / cover no-repeat; transition: background 1s ease;"></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} elseif ($type_file == 'mp4') {
			?>
				<div class="attachment_item">
					<a class="video_fun" data-fancybox href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} elseif ($type_file == 'mp3') {


			?>
				<div class="attachment_item audio">

					<a data-fancybox="S" data-type="video" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">


						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>

			<?php
			} elseif ($type_file == 'pdf') {
			?>
				<div class="attachment_item">
					<a target="_blank" href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>
					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
			<?php
			} else {
			?>
				<div class="attachment_item">
					<a download href="template/backend/uploads/<?php echo $attachment['name_file']; ?>">
						<div class="attachment_file"><?php echo $type_file; ?></div>
						<div class="attachment_title"><?php echo mb_strimwidth($name_file, 0, 18, "..."); ?></div>
					</a>

					<div data-id="<?php echo $attachment['id']; ?>" data-idtask="<?php echo $attachment['id_task']; ?>" class="delete_file"><i class="fas fa-times"></i></div>
				</div>
	<?php
			}
		}
	}
}

if ($_POST['delete_file_task_file']) {

	$id = $_POST['delete_file_task_file'];

	$sth = $pdo->prepare("SELECT `name_file` FROM `attachments` WHERE `id` = :id");
	$sth->execute(array('id' => $id));
	$name_file = $sth->fetch(PDO::FETCH_COLUMN);
	var_dump($name_file);
	unlink($_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/' . $name_file);
	unlink($_SERVER['DOCUMENT_ROOT'] . '/template/backend/uploads/thumb-' . $name_file);
}

if ($_POST['count_file_task_upload']) {
	$id_task = $_POST['count_file_task_upload'];
	$sth = $pdo->query("SELECT COUNT(*) as count FROM attachments WHERE id_task = $id_task");
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$row = $sth->fetch();
	$rowFiles = $row['count'];
	?>
	<span class="span_clip"><i class="fal fa-paperclip"></i> <?php echo $rowFiles; ?></span>
	<?php
}

if ($_POST['count_file_task']) {
	$id_task = $_POST['count_file_task'];
	$sth = $pdo->query("SELECT COUNT(*) as count FROM attachments WHERE id_task = $id_task");
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$row = $sth->fetch();
	$rowFiles = $row['count'];
	if ($rowFiles != 0) {
	?>
		<span class="span_clip"><i class="fal fa-paperclip"></i> <?php echo $rowFiles; ?></span>
	<?php
	}
}


if ($_FILES['upload_cover']) {
	if (0 < $_FILES['upload_cover']['error']) {
		echo 'Error: ' . $_FILES['upload_cover']['error'] . '<br>';
	} else {

		$type_files = array('jpg', 'jpeg', 'png', 'gif', 'webp');
		$tmp_name = $_FILES['upload_cover']['tmp_name'];
		$file_name = $_POST['file_name'];
		$url_path  = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/covers/';
		$ext = mb_strtolower(mb_substr(mb_strrchr(@$file_name, '.'), 1));

		if (!is_dir($url_path)) {
			mkdir($url_path, 0777, true);
		}

		$url_file_name = $url_path . $file_name;

		/*if (file_exists($url_file_name)) {

			$file_name  = time() . '-' . $file_name;
		}*/

		if (empty($ext) || !in_array($ext, $type_files)) {
			$error = 'Недопустимый тип файла';
		} else {

			//$params['thumbnail'] = date('d.m.y') . '/' . $file_name;

			move_uploaded_file($tmp_name, $url_path . $file_name);

			$image = new Thumbs($url_path . $file_name);
			$image->reduce(512, 512);
			$image->save();
		}
	}

	$cover = $file_name;
	$id_task = $_POST['id_task'];



	$sth = $pdo->prepare("UPDATE `tasks` SET `cover` = :cover WHERE `id` = :id");
	$sth->execute(array('cover' => $cover, 'id' => $id_task));
}

if ($_POST['view_cover_task_upload']) {
	$id_task = $_POST['view_cover_task_upload'];
	$sth = $pdo->prepare("SELECT `cover` FROM `tasks` WHERE `id` = '$id_task'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['cover']) {

	?>

		<div class="cover_one" style="background: url('template/backend/assets/images/covers/<?= $data[0]['cover'] ?>') center / cover no-repeat;"></div>

	<?php
	}
}

if ($_POST['view_cover_task']) {


	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['view_cover_tab']) {


	$id_task = $_POST['view_cover_tab'];
	$sth = $pdo->prepare("SELECT `cover` FROM `tasks` WHERE `id` = '$id_task'");
	$sth->execute();
	$data = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($data[0]['cover']) {

	?>

		<div class="cover_one" style="background: url('template/backend/assets/images/covers/<?= $data[0]['cover'] ?>') center / cover no-repeat;"></div>

	<?php
	}
}


if ($_POST['delete_cover']) {

	$id = $_POST['delete_cover'];
	$cover = $_POST['cover'];
	$sth = $pdo->prepare("UPDATE `tasks` SET `cover` = :cover WHERE `id` = :id");
	$sth->execute(array('cover' => $cover, 'id' => $id));

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['delete_cover_file']) {
	$name_cover = $_POST['modal_cover'];
	unlink($_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/covers/' . $name_cover);
}

if ($_POST['select_cover_type_2']) {
	$id = $_POST['select_cover_type_2'];
	$sth = $pdo->prepare("UPDATE `tasks` SET `type_cover` = :type_cover WHERE `id` = :id");
	$sth->execute(array('type_cover' => '2', 'id' => $id));

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['select_cover_type_1']) {
	$id = $_POST['select_cover_type_1'];
	$sth = $pdo->prepare("UPDATE `tasks` SET `type_cover` = :type_cover WHERE `id` = :id");
	$sth->execute(array('type_cover' => '1', 'id' => $id));

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['add_checklist']) {
	$id_task = $_POST['add_checklist'];
	$title = 'Название чек-листа';

	$sth = $pdo->prepare("INSERT INTO `checklists` SET `title` = :title, `id_task` = :id_task");
	$sth->execute(array('title' => $title, 'id_task' => $id_task));

	$stn = $pdo->prepare("SELECT * FROM checklists WHERE `id_task` = '$id_task'");
	$stn->execute();
	$checklists = $stn->fetchAll(PDO::FETCH_ASSOC);

	$stn = $pdo->prepare("SELECT * FROM checklists_line ORDER BY position");
	$stn->execute();
	$checklists_line = $stn->fetchAll(PDO::FETCH_ASSOC);



	foreach ($checklists as $checklist) { ?>

		<div class="flex_title_check">
			<div spellcheck="false" contenteditable="true" class="title_check" data-title="<?php echo $checklist['id']; ?>"><?php echo $checklist['title']; ?></div>
			<div class="btn_del_check" data-idcheck="<?php echo $checklist['id']; ?>" data-idtask="<?php echo $checklist['id_task']; ?>"><i data-idtask="<?php echo $checklist['id_task']; ?>" data-idcheck="<?php echo $checklist['id']; ?>" class="fa-solid fa-circle-minus"></i></div>
		</div>

		<?php
		$id_check = $checklist['id'];

		$count_select_check_full = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check);
			}
		);

		$count_select_check = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check && $value['status'] == '2');
			}
		);
		if (count($count_select_check) > 0) {
			$value_progress = 100 / count($count_select_check_full) * count($count_select_check);
		} else {
			$value_progress = 0;
		}


		?>

		<div class="progress_block">
			<progress id="progress_<?php echo $checklist['id']; ?>" class="check_progress" value="<?php echo $value_progress; ?>" max="100">Determinate</progress>
			<div class="progress_precent"><?php echo ceil($value_progress); ?>%</div>
		</div>

		<div class="line_checkbox" data-check="<?php echo $checklist['id']; ?>">
			<?php foreach ($checklists_line as $line) { ?>
				<?php if ($line['id_check'] == $checklist['id']) { ?>
					<div class="icheckbox disabled" data-id="<?php echo $line['id']; ?>" data-check="<?php echo $checklist['id']; ?>">
						<div class="handler_check"><i class="fa-solid fa-grip-vertical"></i></div>
						<input type="checkbox" data-idcheck="<?php echo $line['id']; ?>" class="checkbox_item" name="chek-<?php echo $line['id']; ?>" <?php if ($line['status'] == 2) { ?> checked <?php } ?>>
						<label class="line_check">
							<div spellcheck="false" data-idtitlecheck="<?php echo $line['id']; ?>" contenteditable="true" class="chek_name" style="<?php if ($line['status'] == 2) { ?>text-decoration: line-through;<?php } ?>"><?php echo $line['title']; ?></div>
						</label>
						<div class="btn_del_check_line" data-idcheckline="<?php echo $line['id']; ?>"><i class="fa-solid fa-circle-minus" data-idcheckline="<?php echo $line['id']; ?>"></i></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="add_checkline">Добавить элемент <i class="fas add_check_btn fa-plus-circle"></i></div>
		<hr>
	<?php
	}
}

if ($_POST['view_checklists']) {
	$id_task = $_POST['view_checklists'];
	$id_check = $_POST['id_check'];

	$stn = $pdo->prepare("SELECT * FROM checklists WHERE `id_task` = '$id_task'");
	$stn->execute();
	$checklists = $stn->fetchAll(PDO::FETCH_ASSOC);

	$stn = $pdo->prepare("SELECT * FROM checklists_line ORDER BY position");
	$stn->execute();
	$checklists_line = $stn->fetchAll(PDO::FETCH_ASSOC);



	foreach ($checklists as $checklist) { ?>

		<div class="flex_title_check">
			<div spellcheck="false" contenteditable="true" class="title_check" data-title="<?php echo $checklist['id']; ?>"><?php echo $checklist['title']; ?></div>
			<div class="btn_del_check" data-idcheck="<?php echo $checklist['id']; ?>" data-idtask="<?php echo $checklist['id_task']; ?>"><i data-idtask="<?php echo $checklist['id_task']; ?>" data-idcheck="<?php echo $checklist['id']; ?>" class="fa-solid fa-circle-minus"></i></div>
		</div>

		<?php
		$id_check = $checklist['id'];

		$count_select_check_full = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check);
			}
		);

		$count_select_check = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check && $value['status'] == '2');
			}
		);
		if (count($count_select_check) > 0) {
			$value_progress = 100 / count($count_select_check_full) * count($count_select_check);
		} else {
			$value_progress = 0;
		}


		?>

		<div class="progress_block">
			<progress id="progress_<?php echo $checklist['id']; ?>" class="check_progress" value="<?php echo $value_progress; ?>" max="100">Determinate</progress>
			<div class="progress_precent"><?php echo ceil($value_progress); ?>%</div>
		</div>

		<div class="line_checkbox" data-check="<?php echo $checklist['id']; ?>">
			<?php foreach ($checklists_line as $line) { ?>
				<?php if ($line['id_check'] == $checklist['id']) { ?>
					<div class="icheckbox disabled" data-id="<?php echo $line['id']; ?>" data-check="<?php echo $checklist['id']; ?>">
						<div class="handler_check"><i class="fa-solid fa-grip-vertical"></i></div>
						<input type="checkbox" data-idcheck="<?php echo $line['id']; ?>" class="checkbox_item" name="chek-<?php echo $line['id']; ?>" <?php if ($line['status'] == 2) { ?> checked <?php } ?>>

						<label class="line_check">
							<div spellcheck="false" data-idtitlecheck="<?php echo $line['id']; ?>" contenteditable="true" class="chek_name" style="<?php if ($line['status'] == 2) { ?>text-decoration: line-through;<?php } ?>"><?php echo $line['title']; ?></div>
						</label>
						<div class="btn_del_check_line" data-idcheckline="<?php echo $line['id']; ?>"><i class="fa-solid fa-circle-minus" data-idcheckline="<?php echo $line['id']; ?>"></i></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="add_checkline">Добавить элемент <i class="fas add_check_btn fa-plus-circle"></i></div>
		<hr>
	<?php
	}
}

if ($_POST['change_title_check']) {
	$title = htmlspecialchars($_POST['change_title_check']);
	$id = $_POST['id'];
	$sth = $pdo->prepare("UPDATE `checklists` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => $title, 'id' => $id));
}

if ($_POST['add_line_checklist']) {
	$id_check = $_POST['add_line_checklist'];
	$id_task = $_POST['id_task'];
	$title = 'Название элемента';

	$sth = $pdo->prepare("INSERT INTO `checklists_line` SET `title` = :title, `id_check` = :id_check");
	$sth->execute(array('title' => $title, 'id_check' => $id_check));

	$stn = $pdo->prepare("SELECT * FROM checklists WHERE `id_task` = '$id_task'");
	$stn->execute();
	$checklists = $stn->fetchAll(PDO::FETCH_ASSOC);

	$stn = $pdo->prepare("SELECT * FROM checklists_line ORDER BY position");
	$stn->execute();
	$checklists_line = $stn->fetchAll(PDO::FETCH_ASSOC);

	foreach ($checklists as $checklist) { ?>

		<div class="flex_title_check">
			<div spellcheck="false" contenteditable="true" class="title_check" data-title="<?php echo $checklist['id']; ?>"><?php echo $checklist['title']; ?></div>
			<div class="btn_del_check" data-idcheck="<?php echo $checklist['id']; ?>" data-idtask="<?php echo $checklist['id_task']; ?>"><i data-idtask="<?php echo $checklist['id_task']; ?>" data-idcheck="<?php echo $checklist['id']; ?>" class="fa-solid fa-circle-minus"></i></div>
		</div>

		<?php
		$id_check = $checklist['id'];

		$count_select_check_full = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check);
			}
		);

		$count_select_check = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check && $value['status'] == '2');
			}
		);
		if (count($count_select_check) > 0) {
			$value_progress = 100 / count($count_select_check_full) * count($count_select_check);
		} else {
			$value_progress = 0;
		}


		?>

		<div class="progress_block">
			<progress id="progress_<?php echo $checklist['id']; ?>" class="check_progress" value="<?php echo $value_progress; ?>" max="100">Determinate</progress>
			<div class="progress_precent"><?php echo ceil($value_progress); ?>%</div>
		</div>

		<div class="line_checkbox" data-check="<?php echo $checklist['id']; ?>">
			<?php foreach ($checklists_line as $line) { ?>
				<?php if ($line['id_check'] == $checklist['id']) { ?>
					<div class="icheckbox disabled" data-id="<?php echo $line['id']; ?>" data-check="<?php echo $checklist['id']; ?>">
						<div class="handler_check"><i class="fa-solid fa-grip-vertical"></i></div>
						<input type="checkbox" data-idcheck="<?php echo $line['id']; ?>" class="checkbox_item" name="chek-<?php echo $line['id']; ?>" <?php if ($line['status'] == 2) { ?> checked <?php } ?>>
						<label class="line_check">
							<div spellcheck="false" data-idtitlecheck="<?php echo $line['id']; ?>" contenteditable="true" class="chek_name" style="<?php if ($line['status'] == 2) { ?>text-decoration: line-through;<?php } ?>"><?php echo $line['title']; ?></div>
						</label>
						<div class="btn_del_check_line" data-idcheckline="<?php echo $line['id']; ?>"><i class="fa-solid fa-circle-minus" data-idcheckline="<?php echo $line['id']; ?>"></i></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="add_checkline">Добавить элемент <i class="fas add_check_btn fa-plus-circle"></i></div>
		<hr>
		<?php
	}
}

if ($_POST['check_status_1']) {
	$id = $_POST['check_status_1'];
	$sth = $pdo->prepare("UPDATE `checklists_line` SET `status` = :status WHERE `id` = :id");
	$sth->execute(array('status' => 1, 'id' => $id));
}

if ($_POST['check_status_2']) {
	$id = $_POST['check_status_2'];
	$sth = $pdo->prepare("UPDATE `checklists_line` SET `status` = :status WHERE `id` = :id");
	$sth->execute(array('status' => 2, 'id' => $id));
}

if ($_POST['change_title_check_line']) {
	$title = htmlspecialchars($_POST['change_title_check_line']);
	$id = $_POST['id'];
	$sth = $pdo->prepare("UPDATE `checklists_line` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => $title, 'id' => $id));
}

if ($_POST['delete_check']) {
	$id = $_POST['delete_check'];
	$id_task = $_POST['id_task'];
	$count = $pdo->exec("DELETE FROM `checklists` WHERE `id` = $id");
	$count = $pdo->exec("DELETE FROM `checklists_line` WHERE `id_check` = $id");

	$stn = $pdo->prepare("SELECT * FROM checklists WHERE `id_task` = '$id_task'");
	$stn->execute();
	$checklists = $stn->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($checklists);

	$stn = $pdo->prepare("SELECT * FROM checklists_line ORDER BY position");
	$stn->execute();
	$checklists_line = $stn->fetchAll(PDO::FETCH_ASSOC);

	if ($checklists) {
		foreach ($checklists as $checklist) { ?>

			<div class="flex_title_check">
				<div spellcheck="false" contenteditable="true" class="title_check" data-title="<?php echo $checklist['id']; ?>"><?php echo $checklist['title']; ?></div>
				<div class="btn_del_check" data-idcheck="<?php echo $checklist['id']; ?>" data-idtask="<?php echo $checklist['id_task']; ?>"><i data-idtask="<?php echo $checklist['id_task']; ?>" data-idcheck="<?php echo $checklist['id']; ?>" class="fa-solid fa-circle-minus"></i></div>
			</div>

			<?php
			$id_check = $checklist['id'];

			$count_select_check_full = array_filter(
				$checklists_line,
				function ($value) use ($id_check) {
					return ($value['id_check'] == $id_check);
				}
			);

			$count_select_check = array_filter(
				$checklists_line,
				function ($value) use ($id_check) {
					return ($value['id_check'] == $id_check && $value['status'] == '2');
				}
			);
			if (count($count_select_check) > 0) {
				$value_progress = 100 / count($count_select_check_full) * count($count_select_check);
			} else {
				$value_progress = 0;
			}


			?>

			<div class="progress_block">
				<progress id="progress_<?php echo $checklist['id']; ?>" class="check_progress" value="<?php echo $value_progress; ?>" max="100">Determinate</progress>
				<div class="progress_precent"><?php echo ceil($value_progress); ?>%</div>
			</div>

			<div class="line_checkbox" data-check="<?php echo $checklist['id']; ?>">
				<?php foreach ($checklists_line as $line) { ?>
					<?php if ($line['id_check'] == $checklist['id']) { ?>
						<div class="icheckbox disabled" data-id="<?php echo $line['id']; ?>" data-check="<?php echo $checklist['id']; ?>">
							<div class="handler_check"><i class="fa-solid fa-grip-vertical"></i></div>
							<input type="checkbox" data-idcheck="<?php echo $line['id']; ?>" class="checkbox_item" name="chek-<?php echo $line['id']; ?>" <?php if ($line['status'] == 2) { ?> checked <?php } ?>>
							<label class="line_check">
								<div spellcheck="false" data-idtitlecheck="<?php echo $line['id']; ?>" contenteditable="true" class="chek_name" style="<?php if ($line['status'] == 2) { ?>text-decoration: line-through;<?php } ?>"><?php echo $line['title']; ?></div>
							</label>
							<div class="btn_del_check_line" data-idcheckline="<?php echo $line['id']; ?>"><i class="fa-solid fa-circle-minus" data-idcheckline="<?php echo $line['id']; ?>"></i></div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="add_checkline">Добавить элемент <i class="fas add_check_btn fa-plus-circle"></i></div>
			<hr>
		<?php
		}
	} else { ?>
		<div></div>
	<?php
	}
}

if ($_POST['del_line_check']) {
	$id = $_POST['del_line_check'];
	$id_check = $_POST['id_check'];

	$count = $pdo->exec("DELETE FROM `checklists_line` WHERE `id` = $id");

	$id_task = $_POST['id_task'];

	$stn = $pdo->prepare("SELECT * FROM checklists WHERE `id_task` = '$id_task'");
	$stn->execute();
	$checklists = $stn->fetchAll(PDO::FETCH_ASSOC);

	$stn = $pdo->prepare("SELECT * FROM checklists_line ORDER BY position");
	$stn->execute();
	$checklists_line = $stn->fetchAll(PDO::FETCH_ASSOC);

	foreach ($checklists as $checklist) { ?>

		<div class="flex_title_check">
			<div spellcheck="false" contenteditable="true" class="title_check" data-title="<?php echo $checklist['id']; ?>"><?php echo $checklist['title']; ?></div>
			<div class="btn_del_check" data-idcheck="<?php echo $checklist['id']; ?>" data-idtask="<?php echo $checklist['id_task']; ?>"><i data-idtask="<?php echo $checklist['id_task']; ?>" data-idcheck="<?php echo $checklist['id']; ?>" class="fa-solid fa-circle-minus"></i></div>
		</div>

		<?php
		$id_check = $checklist['id'];

		$count_select_check_full = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check);
			}
		);

		$count_select_check = array_filter(
			$checklists_line,
			function ($value) use ($id_check) {
				return ($value['id_check'] == $id_check && $value['status'] == '2');
			}
		);
		if (count($count_select_check) > 0) {
			$value_progress = 100 / count($count_select_check_full) * count($count_select_check);
		} else {
			$value_progress = 0;
		}


		?>

		<div class="progress_block">
			<progress id="progress_<?php echo $checklist['id']; ?>" class="check_progress" value="<?php echo $value_progress; ?>" max="100">Determinate</progress>
			<div class="progress_precent"><?php echo ceil($value_progress); ?>%</div>
		</div>

		<div class="line_checkbox" data-check="<?php echo $checklist['id']; ?>">
			<?php foreach ($checklists_line as $line) { ?>
				<?php if ($line['id_check'] == $checklist['id']) { ?>
					<div class="icheckbox disabled" data-id="<?php echo $line['id']; ?>" data-check="<?php echo $checklist['id']; ?>">
						<div class="handler_check"><i class="fa-solid fa-grip-vertical"></i></div>
						<input type="checkbox" data-idcheck="<?php echo $line['id']; ?>" class="checkbox_item" name="chek-<?php echo $line['id']; ?>" <?php if ($line['status'] == 2) { ?> checked <?php } ?>>
						<label class="line_check">
							<div spellcheck="false" data-idtitlecheck="<?php echo $line['id']; ?>" contenteditable="true" class="chek_name" style="<?php if ($line['status'] == 2) { ?>text-decoration: line-through;<?php } ?>"><?php echo $line['title']; ?></div>
						</label>
						<div class="btn_del_check_line" data-idcheckline="<?php echo $line['id']; ?>"><i class="fa-solid fa-circle-minus" data-idcheckline="<?php echo $line['id']; ?>"></i></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="add_checkline">Добавить элемент <i class="fas add_check_btn fa-plus-circle"></i></div>
		<hr>
	<?php
	}
}

if ($_POST['view_checklist_task']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['view_checklist_task_line']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['view_checklist_task_check_line']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->query("SELECT * FROM checklists");
	$sth->execute();
	$checklists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->query("SELECT * FROM checklists_line");
	$sth->execute();
	$checklists_line = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['view_checklist_task_uncheck_line']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->query("SELECT * FROM checklists");
	$sth->execute();
	$checklists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->query("SELECT * FROM checklists_line");
	$sth->execute();
	$checklists_line = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['delete_checklist_task']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['delete_checkline_task']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['add_comm_task']) {
	$id_task = $_POST['id_task'];
	$description = $_POST['add_comm_task'];

	$id_user = $_POST['id_user'];

	$sth = $pdo->prepare("INSERT INTO `comments` SET `description` = :description, `id_task` = :id_task, `id_user` = :id_user");
	$sth->execute(array('description' => htmlspecialchars($description), 'id_task' => $id_task, 'id_user' => $id_user));


	$sth = $pdo->prepare("SELECT * FROM comments WHERE `id_task` = $id_task");
	$sth->execute();
	$comments = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($comments as $comment) {
		$commentDesc = $comment['description'];

		// Replace empty <div> tags with nothing
		$commentDesc = preg_replace("/<div>\s*<\/div>/", "", $commentDesc);

		// Replace multiple newlines in a row with a single newline
		$commentDesc = preg_replace("/\n+/", "\n", $commentDesc);

		$id_user = $comment['id_user'];

		$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_user' LIMIT 1");
		$sth->execute();
		$usercomm = $sth->fetchAll(PDO::FETCH_ASSOC);

		$id_current_user = $_COOKIE['id'];

		$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
		$sth->execute();
		$current_user = $sth->fetchAll(PDO::FETCH_ASSOC);
	?>
		<div class="comm_block_full">
			<div class="comm_block">
				<div class="avatar_block">
					<img src="template/backend/assets/images/users/<?php echo $usercomm[0]['avatar']; ?>" class="avatar_img">
				</div>
				<div class="block_name_desc">
					<div class="name_commentator"><?php echo $usercomm[0]['username']; ?></div>
					<div <?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>contenteditable="true" <?php } ?> spellcheck="false" class="next_comm" placeholder="Напишите комментарий..." data-idtask="${modalId}" data-idcomm="<?php echo $comment['id']; ?>">
						<?php echo html_entity_decode($commentDesc); ?>
					</div>
				</div>
				<?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>
					<div class="btn_del_comm"><i class="fa-solid del_comm_fas_comm fa-circle-minus" data-idcomm="<?php echo $comment['id']; ?>"></i></div>
				<?php } ?>
			</div>
		</div>
	<?php
	}
}

if ($_POST['view_comm']) {
	$id_task = $_POST['view_comm'];;

	$sth = $pdo->prepare("SELECT * FROM comments WHERE `id_task` = $id_task");
	$sth->execute();
	$comments = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($comments as $comment) {
		$commentDesc = $comment['description'];

		// Replace empty <div> tags with nothing
		$commentDesc = preg_replace("/<div>\s*<\/div>/", "", $commentDesc);

		// Replace multiple newlines in a row with a single newline
		$commentDesc = preg_replace("/\n+/", "\n", $commentDesc);

		$id_user = $comment['id_user'];

		$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_user' LIMIT 1");
		$sth->execute();
		$usercomm = $sth->fetchAll(PDO::FETCH_ASSOC);

		$id_current_user = $_COOKIE['id'];

		$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
		$sth->execute();
		$current_user = $sth->fetchAll(PDO::FETCH_ASSOC);
	?>
		<div class="comm_block_full">
			<div class="comm_block">
				<div class="avatar_block">
					<img src="template/backend/assets/images/users/<?php echo $usercomm[0]['avatar']; ?>" class="avatar_img">
				</div>
				<div class="block_name_desc">
					<div class="name_commentator"><?php echo $usercomm[0]['username']; ?></div>
					<div <?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>contenteditable="true" <?php } ?> spellcheck="false" class="next_comm" placeholder="Напишите комментарий..." data-idtask="${modalId}" data-idcomm="<?php echo $comment['id']; ?>">
						<?php echo html_entity_decode($commentDesc); ?>
					</div>
				</div>
				<?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>
					<div class="btn_del_comm"><i class="fa-solid del_comm_fas_comm fa-circle-minus" data-idcomm="<?php echo $comment['id']; ?>"></i></div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

if ($_POST['del_comm']) {
	$id_comm = $_POST['del_comm'];
	$id_task = $_POST['id_task'];
	$id_user = $_POST['id_user'];

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_user' LIMIT 1");
	$sth->execute();
	$usercomm = $sth->fetchAll(PDO::FETCH_ASSOC);

	$count = $pdo->exec("DELETE FROM `comments` WHERE `id` = $id_comm");

	$sth = $pdo->prepare("SELECT * FROM comments WHERE `id_task` = $id_task");
	$sth->execute();
	$comments = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($comments) {

		foreach ($comments as $comment) {
			$commentDesc = $comment['description'];

			// Replace empty <div> tags with nothing
			$commentDesc = preg_replace("/<div>\s*<\/div>/", "", $commentDesc);

			// Replace multiple newlines in a row with a single newline
			$commentDesc = preg_replace("/\n+/", "\n", $commentDesc);

			$id_user = $comment['id_user'];

			$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_user' LIMIT 1");
			$sth->execute();
			$usercomm = $sth->fetchAll(PDO::FETCH_ASSOC);

			$id_current_user = $_COOKIE['id'];

			$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
			$sth->execute();
			$current_user = $sth->fetchAll(PDO::FETCH_ASSOC);
		?>
			<div class="comm_block_full">
				<div class="comm_block">
					<div class="avatar_block">
						<img src="template/backend/assets/images/users/<?php echo $usercomm[0]['avatar']; ?>" class="avatar_img">
					</div>
					<div class="block_name_desc">
						<div class="name_commentator"><?php echo $usercomm[0]['username']; ?></div>
						<div <?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>contenteditable="true" <?php } ?> spellcheck="false" class="next_comm" placeholder="Напишите комментарий..." data-idtask="${modalId}" data-idcomm="<?php echo $comment['id']; ?>">
							<?php echo html_entity_decode($commentDesc); ?>
						</div>
					</div>
					<?php if ($id_user == $id_current_user || $current_user[0]['role'] == 'admin') { ?>
						<div class="btn_del_comm"><i class="fa-solid del_comm_fas_comm fa-circle-minus" data-idcomm="<?php echo $comment['id']; ?>"></i></div>
					<?php } ?>
				</div>
			</div>
		<?php
		}
	} else {
		?>
		<div></div>
	<?php
	}
}

if ($_POST['chek_email_member']) {
	$email = $_POST['chek_email_member'];

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
	$sth->execute();
	$user_check = $sth->fetchAll(PDO::FETCH_ASSOC);

	echo $user_check[0]['email'];
}

if ($_POST['add_member']) {
	$username = $_POST['add_member'];
	$email = $_POST['email_member'];
	$phone = $_POST['phone_member'];
	$role = $_POST['role_member'];
	$rank = $_POST['rank_member'];
	$id_group_contacts = $_POST['group_member'];
	$file_name = $_POST['avatar_member'];
	$password = md5(trim($_POST['password_member']));
	



	$type_files = array('jpg', 'jpeg', 'png', 'gif', 'webp');
	$tmp_name = $_FILES['avatar_file']['tmp_name'];

	$url_path  = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/users/';
	$ext = mb_strtolower(mb_substr(mb_strrchr(@$file_name, '.'), 1));

	if (!is_dir($url_path)) {
		mkdir($url_path, 0777, true);
	}

	$url_file_name = $url_path . $file_name;

	/*if (file_exists($url_file_name)) {

			$file_name  = time() . '-' . $file_name;
		}*/

	if (empty($ext) || !in_array($ext, $type_files)) {
		$error = 'Недопустимый тип файла';
	} else {

		//$params['thumbnail'] = date('d.m.y') . '/' . $file_name;

		move_uploaded_file($tmp_name, $url_path . $file_name);

		$image = new Thumbs($url_path . $file_name);
		$image->reduce(256, 256);
		$image->save();
	}

	$sth = $pdo->prepare("SELECT * FROM `settings`");
	$sth->execute();
	$settings = $sth->fetchAll(PDO::FETCH_ASSOC);


	$sth = $pdo->prepare("INSERT INTO `users` SET `username` = :username, `email` = :email, `phone` = :phone, `password` = :password, `role` = :role, `rank` = :rank, `avatar` = :avatar, `id_group_contacts` = :id_group_contacts");
	$sth->execute(array('username' => $username, 'email' => $email, 'phone' => $phone, 'password' => $password, 'role' => $role, 'rank' => $rank, 'avatar' => $file_name, 'id_group_contacts' => $id_group_contacts));

	if ($role == 'member') {
		$role_user = 'участника';
	}
	if ($role == 'customer') {
		$role_user = 'клиента';
	}
	if ($role == 'admin') {
		$role_user = 'администратора';
	}

	$email_site = $settings[3]['value'];
	$password_user = $_POST['password_member'];
	//Составляем заголовок письма
	$subject = "Регистрация на сайте " . $_SERVER['HTTP_HOST'];

	//Составляем тело сообщения
	$message = 'Здравствуйте, ' . $username . '! <br/> <br/> Сегодня ' . date("d.m.Y", time()) . ', администратором сайта <a href="' . $_SERVER['HTTP_HOST'] . '">' . $settings[0]['value'] . '</a> вы были добавлены в качестве ' . $role_user . ', используя Ваш email.<br/><br/> Ваш логин для входа: <strong>' . $email . '</strong><br/><br/> Ваш пароль: <strong>' . $password_user . '</strong>';

	$headers = "FROM: $email_site\r\nReply-to: $email_site\r\nContent-type: text/html; charset=utf-8\r\n";

	//Отправляем сообщение с ссылкой для подтверждения регистрации на указанную почту и проверяем отправлена ли она успешно или нет. 
	if (mail($email, $subject, $message, $headers)) {
		echo $username;
	}
	?>

<?php
}

if ($_POST['chek_email_profile']) {
	$email = $_POST['chek_email_profile'];

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
	$sth->execute();
	$user_check = $sth->fetchAll(PDO::FETCH_ASSOC);

	if ($user_check[0]['id'] == $_COOKIE['id']) {
		echo $user_check[0]['email'];
	}
}

if ($_POST['edit_profile']) {
	$username = $_POST['edit_profile'];
	$email = $_POST['email_profile'];

	$id_current_user = $_COOKIE['id'];
	if ($_POST['avatar_profile'] == $id_current_user) {
		$sth = $pdo->prepare("SELECT `avatar` FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
		$sth->execute();
		$avatar_profile = $sth->fetchAll(PDO::FETCH_ASSOC);
		$file_name = $avatar_profile[0]['avatar'];
	} else {
		$file_name = $_POST['avatar_profile'];

		$type_files = array('jpg', 'jpeg', 'png', 'gif', 'webp');
		$tmp_name = $_FILES['avatar_file']['tmp_name'];

		$url_path  = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/users/';
		$ext = mb_strtolower(mb_substr(mb_strrchr(@$file_name, '.'), 1));

		if (!is_dir($url_path)) {
			mkdir($url_path, 0777, true);
		}

		$url_file_name = $url_path . $file_name;

		/*if (file_exists($url_file_name)) {

				$file_name  = time() . '-' . $file_name;
			}*/

		if (empty($ext) || !in_array($ext, $type_files)) {
			$error = 'Недопустимый тип файла';
		} else {

			//$params['thumbnail'] = date('d.m.y') . '/' . $file_name;

			move_uploaded_file($tmp_name, $url_path . $file_name);

			$image = new Thumbs($url_path . $file_name);
			$image->reduce(256, 256);
			$image->save();
		}
	}

	if ($_POST['password_profile'] == $id_current_user) {
		$sth = $pdo->prepare("SELECT `password` FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
		$sth->execute();
		$password_profile = $sth->fetchAll(PDO::FETCH_ASSOC);
		$password = $password_profile[0]['password'];
	} else {
		$password = md5(trim($_POST['password_profile']));
	}

	$sth = $pdo->prepare("UPDATE `users` SET `username` = :username, `email` = :email, `password` = :password, `avatar` = :avatar WHERE `id` = :id");
	$sth->execute(array('username' => $username, 'email' => $email, 'password' => $password, 'avatar' => $file_name, 'id' => $id_current_user));

?>
	<?php echo $username; ?>
<?php
}

if ($_POST['avatar_lists']) {

	$id_current_user = $_COOKIE['id'];
	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id` = '$id_current_user' LIMIT 1");
	$sth->execute();
	$userdata = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}

if ($_POST['view_comm_task_list']) {

	$sth = $pdo->prepare("SELECT * FROM lists ORDER BY position");
	$sth->execute();
	$lists = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sth = $pdo->prepare("SELECT * FROM tasks ORDER BY position");
	$sth->execute();
	$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

	include '../template/backend/includes/lists.php';
}
if ($_POST['edit_settings_site']) {
	$title_site = $_POST['edit_settings_site'];
	$description_site = $_POST['desc_site'];
	$email_site = $_POST['email_site'];

	if ($_POST['favicon_site']) {
		$file_name = $_POST['favicon_site'];

		$type_files = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'ico');
		$tmp_name = $_FILES['favicon_file']['tmp_name'];

		$url_path  = $_SERVER['DOCUMENT_ROOT'] . '/template/backend/assets/images/';
		$ext = mb_strtolower(mb_substr(mb_strrchr(@$file_name, '.'), 1));

		if (!is_dir($url_path)) {
			mkdir($url_path, 0777, true);
		}

		$url_file_name = $url_path . $file_name;

		/*if (file_exists($url_file_name)) {
	
					$file_name  = time() . '-' . $file_name;
				}*/

		if (empty($ext) || !in_array($ext, $type_files)) {
			$error = 'Недопустимый тип файла';
		} else {

			//$params['thumbnail'] = date('d.m.y') . '/' . $file_name;

			move_uploaded_file($tmp_name, $url_path . $file_name);

			$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = 'favicon'");
			$sth->execute(array('value' => $file_name));
		}
	}





	$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = 'title_site'");
	$sth->execute(array('value' => $title_site));

	$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = 'description_site'");
	$sth->execute(array('value' => $description_site));

	$sth = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `key_field` = 'email_site'");
	$sth->execute(array('value' => $email_site));



?>
	<?php echo $username; ?>
	<?php
}

if ($_POST['change_comment']) {
	$description = htmlspecialchars($_POST['change_comment']);
	$id = $_POST['id'];
	$sth = $pdo->prepare("UPDATE `comments` SET `description` = :description WHERE `id` = :id");
	$sth->execute(array('description' => $description, 'id' => $id));
}

if ($_POST['add_group_contacts']) {
	$title = $_POST['add_group_contacts'];
	$sth = $pdo->prepare("INSERT INTO `contacts_group` SET `title` = :title");
	$sth->execute(array('title' => $title));

	$sth = $pdo->prepare("SELECT * FROM `contacts_group` ORDER BY position");
	$sth->execute();
	$contacts_groups = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($contacts_groups as $contacts_group) {
	?>
		<div class="group_contacts_item" data-idgroup="<?php echo $contacts_group['id']; ?>">
			<div class="left_section_group">
				<div class="handler_check_group"><i class="fa-solid fa-grip-vertical"></i></div>
				<span class="title_group_contacts_item" data-idgroup="<?php echo $contacts_group['id']; ?>"><?php echo $contacts_group['title']; ?></span>
			</div>
			<div class="action_group"><i class="fa-solid fa-ellipsis-vertical"></i>
				<div class="action_group_btns">
					<p class="action_group_edit">Изменить</p>
					<p class="action_group_del">Удалить</p>
				</div>
			</div>
			
		</div>
		<?php
	}
}

if ($_POST['change_title_block_group_contacts']) {
	$title = htmlspecialchars($_POST['change_title_block_group_contacts']);
	$id = '1';
	$sth = $pdo->prepare("UPDATE `block_contacts_group` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => $title, 'id' => $id));
}

if ($_GET['order_group']) {
	if (isset($_GET["order_group"])) {
		$order  = explode(",", $_GET["order_group"]);
		for ($i = 0; $i < count($order); $i++) {
			$sth =  $pdo->prepare("UPDATE `contacts_group` SET position='" . $i . "' WHERE id=" . $order[$i]);
			$sth->execute();
		}
	}
}

if ($_GET['order_contacts']) {
	if (isset($_GET["order_contacts"])) {
		$order  = explode(",", $_GET["order_contacts"]);
		for ($i = 0; $i < count($order); $i++) {
			$sth =  $pdo->prepare("UPDATE `users` SET position='" . $i . "' WHERE id=" . $order[$i]);
			$sth->execute();
		}
	}
}

if ($_POST['open_contacts_group']) {
	$id_group = $_POST['open_contacts_group'];

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id_group_contacts` = '$id_group' ORDER BY position");
	$sth->execute();
	$contacts_users = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($contacts_users as $contacts_user) {
		if ($contacts_user['id_group_contacts'] == $id_group) {
		?>

			<tr class="dnd_item_conacts" data-idcontact="<?php echo $contacts_user['id']; ?>">
				<th class="table_handle"><i class="fa-solid fa-grip-vertical"></i></th>
				<th class="table_avatar"><img class="avatar_table_user" src="template/backend/assets/images/users/<?php echo $contacts_user['avatar']; ?>" alt=""></th>
				<td><?php echo $contacts_user['username']; ?></td>
				<td><a href="mailto:<?php echo $contacts_user['email']; ?>"><?php echo $contacts_user['email']; ?></a></td>
				<td><?php echo $contacts_user['phone']; ?></td>
				<!--<td><?php echo $contacts_user['id_board']; ?></td>-->
				<td><?php if($contacts_user['role'] == 'member'){ ?> Участник <?php } else { ?> Администратор <?php }; ?></td>
				<td><?php echo $contacts_user['rank']; ?></td>
				
				<td class="action_contact"><i class="fa-solid fa-ellipsis-vertical"></i>
					<div class="action_contact_btns">
						<!--<p class="action_contact_edit">Изменить</p>-->
						<p class="action_contact_del">Удалить</p>
					</div>
				</td>
			</tr>

<?php
		} else {
		}
	}
}

if ($_POST['open_page_contacts']) {

	$sth = $pdo->prepare("SELECT * FROM `contacts_group` WHERE `position` = '0' LIMIT 1");
	$sth->execute();
	$contacts_groups = $sth->fetchAll(PDO::FETCH_ASSOC);

	$id_group = $contacts_groups[0]['id'];
	

	$sth = $pdo->prepare("SELECT * FROM `users` WHERE `id_group_contacts` = '$id_group' ORDER BY position");
	$sth->execute();
	$contacts_users = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($contacts_users as $contacts_user) {
		
			if ($contacts_user['id_group_contacts'] == 1) {
			?>

				<tr class="dnd_item_conacts" data-idcontact="<?php echo $contacts_user['id']; ?>">
					<th class="table_handle"><i class="fa-solid fa-grip-vertical"></i></th>
					<th class="table_avatar"><img class="avatar_table_user" src="template/backend/assets/images/users/<?php echo $contacts_user['avatar']; ?>" alt=""></th>
					<td><?php echo $contacts_user['username']; ?></td>
					<td><a href="mailto:<?php echo $contacts_user['email']; ?>"><?php echo $contacts_user['email']; ?></a></td>
					<td><?php echo $contacts_user['phone']; ?></td>
					<!--<td><?php echo $contacts_user['id_board']; ?></td>-->
					<td><?php if($contacts_user['role'] == 'member'){ ?> Участник <?php } else { ?> Администратор <?php }; ?></td>
					<td><?php echo $contacts_user['rank']; ?></td>
					
					<td class="action_contact"><i class="fa-solid fa-ellipsis-vertical"></i>
						<div class="action_contact_btns">
							<!--<p class="action_contact_edit">Изменить</p>-->
							<p class="action_contact_del">Удалить</p>
						</div>
					</td>
				</tr>

	<?php
			} else {
			}
		
	}
}

if ($_POST['del_group_contacts']) {
	$id = $_POST['del_group_contacts'];
	$count = $pdo->exec("DELETE FROM `contacts_group` WHERE `id` = $id");

}
if ($_POST['select_group_contacts_settings']) {
	
	$sth = $pdo->query("SELECT * FROM `contacts_group` ORDER BY position");
	$sth->execute();
	$contacts_groups = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($contacts_groups as $contacts_group) : ?>
		<option value="<?php echo $contacts_group['id'] ?>"><?php echo $contacts_group['title'] ?></option>
	<?php endforeach;

}


if ($_POST['change_title_group']) {
	$title = htmlspecialchars($_POST['change_title_group']);
	$id = $_POST['idgroup'];
	$sth = $pdo->prepare("UPDATE `contacts_group` SET `title` = :title WHERE `id` = :id");
	$sth->execute(array('title' => $title, 'id' => $id));
}

if ($_POST['del_contacts']) {
	$id = $_POST['del_contacts'];
	$count = $pdo->exec("DELETE FROM `users` WHERE `id` = $id");

}