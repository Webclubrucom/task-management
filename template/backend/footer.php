<div class="copyright">
    <p class="">Создано с <i class="fa fa-heart heart" aria-hidden="true"></i> <a target="_blank" href="https://vk.com/webcreature"> в России</a></p>
</div>
<div class="add_list_item"><i class="fa fa-plus" aria-hidden="true"></i></div>

<div class="open_header"><i class="fa fa-caret-down" aria-hidden="true"></i></div>

<nav class="top-nav">
    <div class="menu-wrapper">
        <button class="menu-close" aria-label="close menu"><i class="fas fa-times"></i></button>
        <div class="settings" id="managment">
            <?php if ($userdata[0]['role'] == 'admin') { ?>
                <p class="title_settings title_background">ФОН</p>
            <?php } ?>
            <p class="title_settings title_managment">УПРАВЛЕНИЕ</p>

        </div>
        <div class="settings_managment">
            <?php if ($userdata[0]['role'] == 'admin') { ?>
                <div class="background_settings">
                    <p class="title_points title_main_setting">Смена фона</p>
                    <hr>
                    <div class="section_background">
                        <?php foreach ($bacgrounds as $bacground) : ?>
                            <div class="section_img">
                                <input <?php if ($bacground == $settings[2]['value']) {  ?> checked <?php } ?>type="radio" name="background" class="check_img" id="<?= $bacground ?>'" value="<?= $bacground ?>">
                                <label for="<?= $bacground ?>'" class="bacground_img" style="background: url('template/backend/assets/images/background/uploads/<?= $bacground ?>') center / cover no-repeat; transition: background 1s ease"></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="example-2">
                        <form name="uploader" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <input type="file" name="file" id="file" class="input-file" accept="image/jpeg,image/png,image/gif,image/webp">
                                <label for="file" class="btn btn-tertiary js-labelFile upload-file">
                                    <i class="icon fa fa-check"></i>
                                    <span class="js-fileName">Загрузить изображение</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="main_settings" <?php if ($userdata[0]['role'] == 'admin') { ?>style="display: none;" <?php } ?>>
                <p class="title_points title_main_setting">Настройки</p>
                <hr>
                <div class="section_main">
                    <?php if ($userdata[0]['role'] == 'admin' || $userdata[0]['role'] == 'customer') { ?>
                        <p class="title_points">Добавление нового пользователя</p>
                        <hr>
                        <div class="section_members">

                            <div class="group_form">
                                <label for="username_member">Имя пользователя</label>
                                <input id="username_member" class="input_form" type="text" placeholder="Введите имя пользователя" required>
                            </div>
                            <div class="group_form">
                                <label for="email_member">Email пользователя</label>
                                <input id="email_member" class="input_form" type="email" placeholder="Введите Email пользователя" required>
                            </div>
							<div class="group_form">
                                <label for="phone_member">Телефон пользователя</label>
                                <input id="phone_member" class="input_form" type="text" placeholder="Введите телефон пользователя" required>
                            </div>
                            <div class="group_form">
                                <label for="role_member">Роль пользователя</label>
                                <select class="input_form" name="role" id="role_member">
                                    <option value="member">Участник</option>
                                    <!-- <option value="customer">Клиент</option>-->
                                    <option value="admin">Администратор</option>
                                </select>
                            </div>
							<div class="group_form">
                                <label for="rank_member">Должность пользователя</label>
                                <input id="rank_member" class="input_form" type="text" placeholder="Введите должность пользователя" required>
                            </div>
							<div class="group_form">
                                <label for="group_member">Группа пользователей</label>
                                <select class="input_form" name="group_member" id="group_member">
									<?php foreach ($contacts_groups as $contacts_group) : ?>
										<option value="<?php echo $contacts_group['id'] ?>"><?php echo $contacts_group['title'] ?></option>

									<?php endforeach; ?>
                                </select>
                            </div>
							<!-- <div class="group_form">
                                <label for="role_member">Доска</label>
                                <select class="input_form" name="role" id="role_member">
                                    <option value="member">Все</option>
                                    <!-- <option value="customer">Клиент</option>-->
                                    <!-- <option value="admin">Администратор</option>
                                </select>
                            </div>-->
                            <div class="group_form">
                                <label for="password_member">Пароль пользователя</label>
                                <input id="password_member" class="input_form" type="text" placeholder="Введите пароль пользователя" required>
                            </div>
                            <div class="group_form avatar_upload">
                                <div id="avatar_member_view" class="avatar_view avatar_member" style="background:url('template/backend/assets/images/users/default.png') center / cover no-repeat;"></div>
                                <label for="avatar_member">Выберите изображение</label>
                                <input id="avatar_member" class="avatar_form" type="file">
                            </div>
                            <div class="btn_modal_sidbar btn_save_setting btn_add_member">Добавить</div>

                        </div>
                    <?php } ?>
                    <p class="title_points">Профиль</p>
                    <hr>
                    <div class="section_profile">

                        <div class="group_form">
                            <label for="username_profile">Ваше имя</label>
                            <input id="username_profile" class="input_form username_profile" type="text" placeholder="Введите имя" value="<?php echo $userdata[0]['username']; ?>">
                        </div>
                        <div class="group_form">
                            <label for="email_profile">Ваш Email</label>
                            <input id="email_profile" class="input_form email_profile" type="email" placeholder="Введите email" value="<?php echo $userdata[0]['email']; ?>">
                        </div>
                        <div class="group_form">
                            <label for="password_profile">Пароль</label>
                            <input id="password_profile" class="input_form password_profile" type="text" placeholder="Новый пароль" value="">
                        </div>
                        <div class="group_form avatar_upload">
                            <div id="avatar_profile_view" class="avatar_view" style="background:url('template/backend/assets/images/users/<?php echo $userdata[0]['avatar']; ?>') center / cover no-repeat;"></div>
                            <label for="avatar_profile">Выберите изображение</label>
                            <input id="avatar_profile" class="avatar_form" type="file">
                        </div>
                        <button Class="btn_modal_sidbar btn_save_setting btn_save_profile" name="submit" type="submit">Сохранить</button>

                    </div>
                    <?php if ($userdata[0]['role'] == 'admin') { ?>
                        <p class="title_points">Сайт</p>
                        <hr>
                        <div class="section_site">

                            <div class="group_form">
                                <label for="title_site">Название сайта</label>
                                <input id="title_site" class="input_form" type="text" placeholder="Напишите название сайта" value="<?php echo $settings[0]['value']; ?>">
                            </div>
                            <div class="group_form">
                                <label for="desc_site">Описание сайта</label>
                                <div contenteditable="true" id="desc_site" class="input_form" placeholder="Введите описание сайта"><?php echo $settings[1]['value']; ?></div>
                            </div>
                            <div class="group_form">
                                <label for="email_site">Email сайта</label>
                                <input id="email_site" class="input_form" type="text" placeholder="Введите email сайта" value="<?php echo $settings[3]['value']; ?>">
                            </div>
                            <div class="group_form favicon_upload">
                                <div id="favicon_view" class="favicon_view" style="background:url('template/backend/assets/images/<?php echo $settings[4]['value']; ?>') center / cover no-repeat;"></div>
                                <label for="favicon_site">Выберите фавикон</label>
                                <input id="favicon_site" class="favicon_form" type="file">
                            </div>
                            <button Class="btn_modal_sidbar btn_save_setting btn_save_setting_site" name="submit" type="submit">Сохранить</button>

                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>

    </div>

    <div class="fixed-menu">
        <button href="#openMenu" id="triggerButton" class="open_menu" aria-label="open menu">

            <i class="fa fa-wrench" aria-hidden="true"></i>

        </button>
    </div>

</nav>

<div class="modal_block"></div>
<div class="modal_block_sound"></div>
<!--
<nav class="context-menu-task" id="context-menu">
    <ul class="context-menu__items">

        <li class="context-menu__item">
            <a href="#" class="context-menu__link">
                <i class="fa fa-times"></i> Удалить
            </a>
        </li>
    </ul>
</nav>

                -->
<div id="message"></div>
<?php include $scripts; ?>