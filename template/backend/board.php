<div class="app" style="background: url('template/backend/assets/images/background/uploads/<?= $settings[2]['value'] ?>') center / cover no-repeat; transition: background 1s ease;">
	<header class="header">
		<div class="left_header">
			<div class="caret_header"><i class="fas fa-sort-amount-up"></i></div>
			<div class="logo_header"><?php echo $settings[0]['value']; ?></div>
		</div>
		<div class="right_header">
		<?php if ($userdata[0]['role'] == 'admin') { ?>
			<div class="menu_header">
				<div class="menu_items btn_menu_boards">
					Задачи
				</div>
				<div class="menu_items btn_menu_contacts">
					Контакты
				</div>
			</div>
		<?php } ?>
			<div class="dropdown_header">
				<div class="clockpage">
					<span id="numberOfDay"></span>
					<span id="dayOfWeek"></span>
					<span id="clock"></span>

				</div>
				<!--<img src="assets/images/user.jpg" alt="user" class="avatar">-->
			</div>
			<div class="block_header_profile">
				<i id="exit" class="fa-solid fa-right-from-bracket"></i>
			</div>
		</div>
	</header>
	<div class="main_dashboard">
		<div class="contacts">
			<?php require_once 'template/backend/includes/contacts.php'; ?>
		</div>
		<div class="lists">
			<?php require_once 'template/backend/includes/lists.php'; ?>
		</div>
	</div>
</div>