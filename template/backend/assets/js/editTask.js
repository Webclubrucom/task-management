/** Всплывающее окно для редактирования карточки */


function openModalTask() {

	const taskAll = document.querySelectorAll('.open_edit_task')

	for (let i = 0; i < taskAll.length; i++) {
		const task = taskAll[i]

		task.addEventListener('click', function (e) {
			const modalBlock = document.querySelector('.modal_block')
			var modalId = task.dataset.modal
			var modalTitle = task.dataset.title
			var modalDesc = task.dataset.desc
			var modalCover = task.dataset.cover
			var typeCover = task.dataset.typecover
			var modalAvatar = task.dataset.avatar
			var idUser = task.dataset.iduser


			modalBlock.innerHTML = `
				
				<div class="modal js-modal task_modal" data-modal="${modalId}">
					<svg class="modal__cross js-modal-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z" />
					</svg>
					<div class="cover_modal" style="background: url('template/backend/assets/images/covers/${modalCover}') center / cover no-repeat; transition: background 1s ease;"></div>
					<div contenteditable="true" spellcheck="false" class="title_modal" data-title="${modalId}">${modalTitle}</div>
					<div class="modal_body">
						<div class="modal_col_8">
							<div class="block_tags"></div>
							<div class="modal_desc">
								<div contenteditable="true" spellcheck="false" data-desc="${modalId}" class="modal_textarea_desc editor" placeholder="Добавьте подробное описание">${modalDesc}</div>
							</div>
							<div class="modal_data"></div>
							<div class="modal_attachments" data-idtask="${modalId}"></div>
							<div class="modal_checkbox" data-idtask="${modalId}"></div>
							<div class="modal_comm">
								<div class="comm_block_full">
									<div class="comm_block">
										<div class="avatar_block">
											<img src="template/backend/assets/images/users/${modalAvatar}" class="avatar_img"></div>
											<div contenteditable="true" spellcheck="false" class="modal_textarea_comm add_comm_input" placeholder="Напишите комментарий..." data-idtask="${modalId}" aria-label="Написать комментарий">
										</div>
									</div>
									<div class="block_btn_comm">
										<div class="btn_add_comm" data-iduser="${idUser}"><i class="fa-solid fa-floppy-disk"></i> Сохранить</div>
									</div>
								</div>
								<div class="items_comm" data-idtask="${modalId}" data-iduser="${idUser}"></div>
								
							</div>

							<div class="block_tags_add">
								<div class="block_color_tags" data-task="${modalId}"></div>
								<div class="title_color">Добавтьте новую цветовую метку</div>
									<div class="block_color_add">
										<div id="color-picker" class="cp-default">
											<div class="picker-wrapper">
											<div id="picker" class="picker"></div>
											<div id="picker-indicator" class="picker-indicator"></div>
										</div>
										<div class="pcr-wrapper">
											<div id="pcr" class="pcr"></div>
											<div id="pcr-indicator" class="pcr-indicator"></div>
										</div>
										<ul id="color-values">
											<li><label>RGB:</label><span id="rgb"></span></li>
											<li><label>HSV:</label><span id="hsv"></span></li>
											<li><label>HEX:</label><span id="hex"></span></li>
											<li><div id="pcr_bg"></div></li>
										</ul>
										
									</div>
									<div class="add_color_tag">Добавить</div>
								</div>
								
							</div>
							<div class="block_date_add">
								<div class="flex_date">
									<div class="title_date">Укажите дату дедлайна</div>
									<div class="title_date_view"></div>
								</div>
								
								<div class="add_date">
								
								<input type="text" data-idtask="${modalId}" class="datepicker" data-zdp_disable_time_picker="true" data-zdp_show_select_today="Сегодня" data-zdp_show_clear_date="0" data-zdp_first_day_of_week="1" value="">
								</div>
								
							</div>

							<div class="block_cover_add">
								<div class="wrapper">
									<div class="preview-box">
										<div class="cancel-icon"><i class="fas fa-times"></i></div>
										<div class="img-preview" data-idcover="${modalId}" style="background: url('template/backend/assets/images/covers/${modalCover}') center / cover no-repeat; transition: background 1s ease;"></div>
										<div class="content">
											<div class="img-icon"><i class="fal fa-image"></i></div>
											
										</div>
									</div>
									<form name="uploaderCover" enctype="multipart/form-data" method="POST">
										<div class="form-group">
											<input type="file" name="file" id="cover" class="input-cover" accept="image/jpeg,image/png,image/gif,image/webp">
											<label for="cover" class="btn btn-tertiary js-labelFileCover upload-file">
												<i class="icon fa fa-check"></i>
												<span class="js-fileName">Выберите изображение</span>
											</label>
										</div>
									</form>
								</div>
								<div class="size_cover">
									<div class="item_size_cover cover_type_1">
										<div class="item_cover">
											<div class="header_cover_item"></div>
											<div class="footer_cover_item">
												<div class="line_1"></div>
												<div class="line_2"></div>
												<div class="line_3">
													<div class="line_item_1"></div>
													<div class="line_item_2"></div>
												</div>
												<div class="line_4"></div>
											</div>
										</div>

									</div>
									<div class="item_size_cover cover_type_2">
										<div class="item_cover">
											<div class="full_item_cover">
												<div class="full_line">
													<div class="line_5"></div>
													<div class="line_6"></div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								
							</div>

							
							
						</div>

						<div class="modal_col_2">
							<div class="modal_tags_all">
								<div class="modal_tags"></div>
								
							</div>
							<div class="modal_sidebar">
								<div class="btn_modal_sidbar block_info"><i class="fal tm fa-stream"></i> Карточка</div>
								<div class="btn_modal_sidbar modal_tag_plus add_tag"><i class="fal tm fa-tags"></i> Метки</div>
								<div class="btn_modal_sidbar block_date"><i class="fal tm fa-clock"></i> Срок</div>
								<input id="attach" name="attach" accept="image/*,.zip,.rar,.pdf,.doc,.docx,.dotx,.xlsx,.xltx,.pptx,ppsx,.potx,.js,.json,.php,.html,.htm,.css,sql,.htaccess,.webp,.mp3,.mp4" class="attach" type="file">
								<label for="attach" class="btn_modal_sidbar block_attach"><i class="fal tm fa-paperclip"></i> Вложение</label>
								<div class="btn_modal_sidbar block_check"><i class="fal tm fa-check-square"></i> Чек-лист</div>
								<div class="btn_modal_sidbar block_cover"><i class="fal tm fa-image"></i> Обложка</div>
								<div class="btn_modal_sidbar del_task"><i class="fal wtm fa-trash"></i> Удалить</div>
							</div>
						</div>
					</div>	
					
				</div>
				<div class="overlay js-modal-overlay"></div>

				`


			$("[contenteditable]").focusout(function () {
				var element = $(this);
				if (!element.text().trim().length) {
					element.empty();
				}
			});

			checklist()
			addComment()
			viewComment()
			deleteComment()


			$("[contenteditable]").focusout();




			/** Отображение чек-листов в окне */

			const modalCheckbox = document.querySelector('.modal_checkbox')
			var idTaskCheck = modalCheckbox.dataset.idtask
			var taskItem = document.querySelector('.task_item[id="' + idTaskCheck + '"]')

			var formData = new FormData();

			formData.append('view_checklists', idTaskCheck);

			$.ajax({
				type: "POST",
				url: 'core/request.php',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				beforeSend: function () {},
				success: function (result) {

					if (result) {
						modalCheckbox.innerHTML = result

						chengeTitleCheck()
						changeTitleCheckLine()
						deleteChecklist()
						deleteCheckLine()
						dragNdropCheck()
					}

					selectCheck()
					addLineCheck()


				}
			})



			/** Отображение обложки в шапке окна и во вкладке ОБЛОЖКА */

			if (modalCover != '1') {
				if (typeCover == '1') {
					var content = document.querySelector('.content')
					var cancelIcon = document.querySelector('.cancel-icon')
					var header = document.querySelector('.cover_modal')
					content.style.display = 'none'
					header.style.display = 'block'
					cancelIcon.style.display = 'block'
					var titleModal = document.querySelector('.title_modal')
					titleModal.style.paddingTop = '100px'
					var size_cover = document.querySelector('.size_cover')
					size_cover.style.display = 'flex'
					var cover_type_1 = document.querySelector('.cover_type_1')
					cover_type_1.classList.add('active_cover')
				} else {
					var content = document.querySelector('.content')
					var cancelIcon = document.querySelector('.cancel-icon')
					var header = document.querySelector('.cover_modal')
					content.style.display = 'none'
					header.style.display = 'block'
					cancelIcon.style.display = 'block'
					var titleModal = document.querySelector('.title_modal')
					titleModal.style.paddingTop = '100px'
					var size_cover = document.querySelector('.size_cover')
					size_cover.style.display = 'flex'
					var cover_type_2 = document.querySelector('.cover_type_2')
					cover_type_2.classList.add('active_cover')
				}

			}

			var cover_type_1 = document.querySelector('.cover_type_1')
			var cover_type_2 = document.querySelector('.cover_type_2')
			var lists = document.querySelector('.lists')

			cover_type_2.addEventListener('click', function (e) {
				cover_type_2.classList.add('active_cover')
				cover_type_1.classList.remove('active_cover')
				var formData = new FormData()

				var taskId = modalId

				formData.append('select_cover_type_2', taskId);

				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {

					},
					success: function (data) {
						lists.innerHTML = data
						typeCover = 2
						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()

					}
				})
			})

			cover_type_1.addEventListener('click', function (e) {
				cover_type_1.classList.add('active_cover')
				cover_type_2.classList.remove('active_cover')
				var formData = new FormData()

				var taskId = modalId

				formData.append('select_cover_type_1', taskId);

				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {

					},
					success: function (data) {
						lists.innerHTML = data
						typeCover = 1
						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()
					}
				})
			})



			/** Галочка для кнопки загрузки файлов ОБЛОЖКА КАРТОЧКИ */

			$(function () {

				'use strict';

				$('.input-cover').each(function () {
					var $input = $(this),
						$label = $input.next('.js-labelFileCover'),
						labelVal = $label.html();

					var validFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

					/** Проверка расширения файла при загрузке со стороны пользователя с предепреждением */

					$input.on('change', function (element) {
						var extn = $(this).val().split(".").pop();

						if (validFormats.indexOf(extn) == -1) {
							$(this).val('');
							var message = document.querySelector('#message')
							message.innerHTML = `
								<div class="alert danger-alert">
									<h4 class="danger">Ошибка! <span> Загружайте только .jpeg, .png, gif, webp</span></h4>
								</div>
							`
							setTimeout(function () {
								message.innerHTML = ""

							}, 4000)
						} else {
							var fileName = '';
							if (element.target.value) fileName = element.target.value.split('\\').pop();
							fileName ? $label.addClass('has-file').find('.js-fileNameCover').html(fileName) : $label.removeClass('has-file').html(labelVal);

							setTimeout(function () {
								$label.addClass('has-file').find('.js-fileNameCover').html('Загрузить изображение')
								$label.removeClass('has-file').html(labelVal)
							}, 4000)

							var formData = new FormData();





							var file = element.target.files[0];

							var coverPreview = document.querySelector('.img-preview')
							var idTask = coverPreview.dataset.idcover
							var task = document.querySelector('.task_item[id="' + idTask + '"]');
							var content = document.querySelector('.content')
							var lists = document.querySelector('.lists')
							var cancel = document.querySelector('.cancel-icon')
							var header = document.querySelector('.cover_modal')
							var cover_task_one = task.querySelector('.cover_task_one')
							var size_cover = task.querySelector('.size_cover')
							var cancelIcon = document.querySelector('.cancel-icon')
							var cancelFas = cancelIcon.querySelector('.fas')
							cancelIcon.style.display = 'block'
							var size_cover = document.querySelector('.size_cover')
							size_cover.style.display = 'flex'
							if (typeCover == '1') {
								var cover_type_1 = document.querySelector('.cover_type_1')
								cover_type_1.classList.add('active_cover')
								var cover_type_2 = document.querySelector('.cover_type_2')
								cover_type_2.classList.remove('active_cover')
							} else {
								var cover_type_2 = document.querySelector('.cover_type_2')
								cover_type_2.classList.add('active_cover')
								var cover_type_1 = document.querySelector('.cover_type_1')
								cover_type_1.classList.remove('active_cover')
							}

							if (cover_task_one) {
								cover_task_one.style.display = 'block'
							}

							var file_name = Math.random() + '-' + file.name
							cancelFas.style.display = 'block'
							header.style.display = 'block'

							content.style.display = 'none'
							cancel.style.display = 'block'
							var titleModal = document.querySelector('.title_modal')
							titleModal.style.paddingTop = '100px'

							formData.append('upload_cover', file)
							formData.append('id_task', idTask)
							formData.append('file_name', file_name);

							var xhr = new XMLHttpRequest();
							xhr.open('POST', 'core/request.php');
							xhr.onreadystatechange = function () {

								header.style.background = 'url("template/backend/assets/images/covers/' + file_name + '") center / cover no-repeat'
								coverPreview.style.background = 'url("template/backend/assets/images/covers/' + file_name + '") center / cover no-repeat'

								var formData = new FormData()
								formData.append('view_cover_task', taskId);
								formData.append('file_name', file_name);

								$.ajax({
									url: 'core/request.php',
									type: 'POST',
									data: formData,
									cache: false,
									contentType: false,
									processData: false,
									beforeSend: function () {

									},
									success: function (data) {

										lists.innerHTML = data

										showActions()
										changeTitle()
										delList()
										addTask()
										dragNdrop()
										openModalTask()
									}
								})
								check()
								delCover()
							};
							xhr.send(formData);
						}
					});
				});
			});





			var formData = new FormData()
			const dataView = document.querySelector('.title_date_view')


			var taskId = modalId

			formData.append('view_date_task_info', taskId);

			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (data) {

					dataView.innerHTML = data
					delCover()
				}
			})

			var formData = new FormData()

			const modalData = document.querySelector('.modal_data')

			var taskId = modalId

			formData.append('view_date_task_date', taskId);

			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (data) {

					modalData.innerHTML = data

				}
			})

			var formData = new FormData()
			const blockTags = document.querySelector('.block_tags')
			formData.append('color_all_appened', 'hexhex');

			var taskId = modalId

			formData.append('id_task', taskId);

			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (data) {

					blockTags.innerHTML = data
					delColorTask()
				}
			})


			var formData = new FormData()
			var modalTags = document.querySelector('.modal_tags')
			formData.append('color_all_sidebar', 'hex');

			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {},
				success: function (result) {
					modalTags.innerHTML = result
					addTaskColor()
					delColorTask()
					delTask()


				}
			})



			/** Открытие блоков */

			const addTagBtn = document.querySelector('.add_tag')
			const addInfoBtn = document.querySelector('.block_info')
			const addDateBtn = document.querySelector('.block_date')
			const addCoverBtn = document.querySelector('.block_cover')

			const modalBodyTaskEdit = document.querySelector('.modal_col_8')

			addDateBtn.addEventListener('click', function (e) {
				modalBodyTaskEdit.querySelector('.block_tags').style.display = 'flex'
				modalBodyTaskEdit.querySelector('.modal_desc').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_data').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_attachments').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_checkbox').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_comm').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_tags_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_cover_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_date_add').style.display = 'block'

				/** Вывод даты и времени для выбора */

				$('.datepicker').Zebra_DatePicker({
					always_visible: $('.add_date'),
					format: 'd M Y',
					lang_clear_date: 'Убрать дату',
					months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
					days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
					months_abbr: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
					days_abbr: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
					onSelect: function (view, elements) {

						const dataInput = document.querySelector('.datepicker')
						const dataValue = dataInput.value
						const taskId = dataInput.dataset.idtask
						const dataView = document.querySelector('.title_date_view')
						const modalData = document.querySelector('.modal_data')
						var task = document.querySelector('.task_item[id="' + taskId + '"]');
						var itemClip = task.querySelector('.item_clip')
						console.log(itemClip)

						var formData = new FormData()

						if (dataValue != '') {
							formData.append('input_date', dataValue);
						} else {
							formData.append('input_date', '1');
						}

						formData.append('id_task', taskId);
						$.ajax({
							url: 'core/request.php',
							type: 'POST',
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {},
							success: function (result) {
								dataView.innerHTML = result

								var formData = new FormData()

								formData.append('modal_data', taskId);
								$.ajax({
									url: 'core/request.php',
									type: 'POST',
									data: formData,
									cache: false,
									contentType: false,
									processData: false,
									beforeSend: function () {},
									success: function (result) {
										modalData.innerHTML = result

										var formData = new FormData()

										formData.append('task_data', taskId);
										$.ajax({
											url: 'core/request.php',
											type: 'POST',
											data: formData,
											cache: false,
											contentType: false,
											processData: false,
											beforeSend: function () {},
											success: function (result) {
												itemClip.innerHTML = result

												showActions()
												changeTitle()
												delList()
												addTask()
												dragNdrop()
												openModalTask()
											}
										})
									}
								})
							}
						})

					},
					onClear: function (view, elements) {

						const dataInput = document.querySelector('.datepicker')

						const taskId = dataInput.dataset.idtask
						const dataView = document.querySelector('.title_date_view')
						var formData = new FormData()
						const modalData = document.querySelector('.modal_data')
						var itemClip = task.querySelector('.item_clip')

						formData.append('input_date', '1');


						formData.append('id_task', taskId);
						$.ajax({
							url: 'core/request.php',
							type: 'POST',
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {},
							success: function (result) {
								dataView.innerHTML = result

								var formData = new FormData()

								formData.append('modal_data', taskId);
								$.ajax({
									url: 'core/request.php',
									type: 'POST',
									data: formData,
									cache: false,
									contentType: false,
									processData: false,
									beforeSend: function () {},
									success: function (result) {
										modalData.innerHTML = result

										var formData = new FormData()

										formData.append('task_data', taskId);
										$.ajax({
											url: 'core/request.php',
											type: 'POST',
											data: formData,
											cache: false,
											contentType: false,
											processData: false,
											beforeSend: function () {},
											success: function (result) {
												itemClip.innerHTML = result

												showActions()
												changeTitle()
												delList()
												addTask()
												dragNdrop()
												openModalTask()
											}
										})
									}
								})
							}
						})

					}

				});


			})

			addInfoBtn.addEventListener('click', function (e) {
				modalBodyTaskEdit.querySelector('.block_tags').style.display = 'flex'
				modalBodyTaskEdit.querySelector('.modal_desc').style.display = 'block'
				modalBodyTaskEdit.querySelector('.modal_data').style.display = 'block'
				modalBodyTaskEdit.querySelector('.modal_attachments').style.display = 'flex'
				modalBodyTaskEdit.querySelector('.modal_checkbox').style.display = 'block'
				modalBodyTaskEdit.querySelector('.modal_comm').style.display = 'block'
				modalBodyTaskEdit.querySelector('.block_tags_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_cover_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_date_add').style.display = 'none'
			})

			addCoverBtn.addEventListener('click', function (e) {
				modalBodyTaskEdit.querySelector('.block_tags').style.display = 'flex'
				modalBodyTaskEdit.querySelector('.modal_desc').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_data').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_attachments').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_checkbox').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_comm').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_tags_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_cover_add').style.display = 'block'
				modalBodyTaskEdit.querySelector('.block_date_add').style.display = 'none'
			})



			addTagBtn.addEventListener('click', function (e) {

				/*modalBodyTaskEdit.querySelector('.block_tags').style.display = 'none'*/
				modalBodyTaskEdit.querySelector('.modal_desc').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_data').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_attachments').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_checkbox').style.display = 'none'
				modalBodyTaskEdit.querySelector('.modal_comm').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_date_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_cover_add').style.display = 'none'
				modalBodyTaskEdit.querySelector('.block_tags_add').style.display = 'block'
				var formData = new FormData()
				var blockAddNewColorTag = document.querySelector('.block_color_tags')
				var colorAll = 'Все цвета';
				formData.append('color_all', colorAll);

				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {},
					success: function (result) {
						blockAddNewColorTag.innerHTML = result
						delColor()
					}
				})
			})

			/** Изменение фона при заполненом блоке описания */

			const textarea_desc = document.querySelector(".modal_textarea_desc");
			if (textarea_desc.textContent != '') {
				//textarea_desc.style.backgroundColor = '#f4f5f7'
			}

			/** Загрузка файлов - вложений к карточке ФАЙЛЫ */

			$("#attach").change(function () {

				var formData = new FormData();

				const modalAttach = document.querySelector('.modal_attachments')

				const idTask = modalAttach.dataset.idtask

				formData.append('upload_file_task', 'input');
				formData.append('id_task', idTask);

				$.each($(".attach")[0].files, function (key, input) {

					formData.append('file[]', input);

					var file_name = Math.random() + '-' + input['name']

					formData.append('file_name', file_name);


				});

				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {

						var message = document.querySelector('#message')
						message.innerHTML = `
						<div class="alert success-alert">
							<h4 class="danger">Внимание! <span> Идет загрузка...</span></h4>
						</div>
						`

					},
					success: function (result) {

						modalAttach.innerHTML = result
						var formData = new FormData();


						var task = document.querySelector('.task_item[id="' + taskId + '"]');
						var viewFilesTask = task.querySelector('.item_files')
						formData.append('count_file_task_upload', idTask);


						$.ajax({
							type: "POST",
							url: 'core/request.php',
							cache: false,
							contentType: false,
							processData: false,
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {},
							success: function (result) {
								var message = document.querySelector('#message')
								setTimeout(function () {
									message.innerHTML = ''
								}, 1000)

								viewFilesTask.innerHTML = result
								delFile()

							}

						});
					}

				});

			});

			/** Вывод файлов карточки */

			$(document).ready(function () {
				var formData = new FormData();

				const modalAttach = document.querySelector('.modal_attachments')
				const idTask = modalAttach.dataset.idtask
				formData.append('id_task', idTask);
				formData.append('view_file_task', 'input');

				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {},
					success: function (result) {

						modalAttach.innerHTML = result
						delFile()

					}

				});
			});

			/** Открытие окна */

			e.preventDefault()

			var modalName = $(this).attr('data-modal')
			var modal = $('.js-modal[data-modal="' + modalName + '"]')

			modal.addClass('is-show')
			$('.js-modal-overlay').addClass('is-show')

			$('.js-modal-close').click(function () {
				$(this).parent('.js-modal').removeClass('is-show')
				$('.js-modal-overlay').removeClass('is-show')
			})

			$('.js-modal-overlay').click(function () {
				$('.js-modal.is-show').removeClass('is-show')
				$(this).removeClass('is-show')
				delColorTask()
			})


			/** Выбор цвета */

			cp = ColorPicker(document.getElementById('pcr'), document.getElementById('picker'),
				function (hex, hsv, rgb, mousePicker, mousepcr) {
					currentColor = hex;
					ColorPicker.positionIndicators(
						document.getElementById('pcr-indicator'),
						document.getElementById('picker-indicator'),
						mousepcr, mousePicker);

					document.getElementById('hex').innerHTML = hex;
					document.getElementById('rgb').innerHTML = 'rgb(' + rgb.r.toFixed() + ', ' + rgb.g.toFixed() + ', ' + rgb.b.toFixed() + ')';
					document.getElementById('hsv').innerHTML = 'hsv(' + hsv.h.toFixed() + ',' + hsv.s.toFixed(2) + ',' + hsv.v.toFixed(2) + ')';

					document.getElementById('pcr_bg').style.backgroundColor = hex;
				});
			cp.setHex('#00ff49');

			/** Изменение названия карточки */

			var title = document.querySelector('.title_modal')

			var lists = document.querySelector('.lists')



			title.addEventListener('click', function (e) {

				if (title.textContent == 'Введите название') {
					title.textContent = ''
				}
				e.target.classList.add('focus')

				title.addEventListener('keydown', function (e) {
					if (e.keyCode === 13) {

						this.blur()

						if (title.textContent == '') {
							title.textContent = 'Введите название'
						}
					}
				})


				const emptyTitle = title

				document.addEventListener('click', function (e) {

					if (!emptyTitle.contains(e.target) && title.textContent == '') {

						title.textContent = 'Введите название'

					}
				})

				title.addEventListener('input', function (e) {
					let id = e.target.dataset.title;
					let titleList = e.target.innerHTML;
					var formData = new FormData()
					if (titleList != '') {
						formData.append('changeTitleTask', titleList);
					} else {
						formData.append('changeTitleTask', 'Введите название');
					}
					formData.append('id', id);
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {

						},
						success: function (result) {
							lists.innerHTML = result
							showActions()
							changeTitle()
							delList()
							addTask()
							dragNdrop()
							openModalTask()
						}
					})
				})


			})

			/** Изменение описания карточки */

			var desc = document.querySelector('.modal_textarea_desc')

			desc.addEventListener('click', function (e) {

				if (desc.textContent == 'Добавьте подробное описание') {
					desc.textContent = ''
				}
				e.target.classList.add('focus')




				const emptyDesc = desc

				document.addEventListener('click', function (e) {

					if (!emptyDesc.contains(e.target) && desc.textContent == '') {

						desc.textContent = 'Добавьте подробное описание'

					}
				})





				desc.addEventListener('input', function (e) {
					let id = e.target.dataset.desc;
					let description = e.target.innerHTML;

					var formData = new FormData()

					if (description != '') {
						formData.append('editDescriptionTask', description);
					} else {
						formData.append('editDescriptionTask', 'Добавьте подробное описание');
					}


					formData.append('id', id);
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {

						},
						success: function (result) {
							lists.innerHTML = result
							showActions()
							changeTitle()
							delList()
							addTask()
							dragNdrop()
							openModalTask()
						}
					})
				})


			})

			/** Добавление нового цвета */

			const btnAddNewColorTag = document.querySelector('.add_color_tag')

			var blockAddNewColorTag = document.querySelector('.block_color_tags')



			btnAddNewColorTag.addEventListener('click', function (e) {
				const hex = document.querySelector('#rgb').textContent
				var modalTags = document.querySelector('.modal_tags')


				var formData = new FormData()

				formData.append('addColor', hex);

				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {

					},
					success: function (result) {
						blockAddNewColorTag.innerHTML = result

						var formDataHex = new FormData()


						formDataHex.append('modalTagsNew', 'hex');

						$.ajax({
							url: 'core/request.php',
							type: 'POST',
							data: formDataHex,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {

							},
							success: function (result) {
								modalTags.innerHTML = result
								addTaskColor()
								delColor()
							}
						})
					}
				})
			})
		})
	}


}
openModalTask()

/** Добавление цветовой метки к карточке */

async function addTaskColor() {
	const addTaskColorAll = document.querySelectorAll('.modal_tag')
	const blockTags = document.querySelector('.block_tags')
	delColor()
	for (let y = 0; y < addTaskColorAll.length; y++) {
		const addTaskColor = addTaskColorAll[y]

		addTaskColor.addEventListener('click', function (e) {

			const idColor = e.target.dataset.color
			const idColorId = e.target.dataset.id

			const modalSelector = document.querySelector('.js-modal')
			var taskId = modalSelector.dataset.modal

			var task = document.querySelector('.task_item[id="' + taskId + '"]');

			var tags = task.querySelector('.tags')


			if (idColorId != undefined) {


				var formData = new FormData()

				formData.append('add_color_task', idColor);
				formData.append('id_task', taskId);
				formData.append('id_color', idColorId);
				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {

					},
					success: function (data) {

						blockTags.innerHTML = data
						var formData = new FormData()

						formData.append('add_color_task_destop', idColor);
						formData.append('id_task', taskId);
						$.ajax({
							url: 'core/request.php',
							type: 'POST',
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {},
							success: function (data) {
								tags.innerHTML = data
								delColorTask()
								delColor()
							}
						})


					}
				})
			}

		})

	}
}
addTaskColor()

async function delColorTask() {
	const taskModal = document.querySelector('.task_modal')

	const blockColor = taskModal.querySelector('.block_tags')
	const btnDelColorTaskAll = taskModal.querySelectorAll('.header_modal_tag')


	for (let y = 0; y < btnDelColorTaskAll.length; y++) {
		const btnDelColorTask = btnDelColorTaskAll[y]
		const taskId = taskModal.dataset.modal
		btnDelColorTask.addEventListener('click', function (e) {
			e.target.remove()
			const idColor = e.target.dataset.id

			var formData = new FormData()
			formData.append('del_color_task', idColor);
			formData.append('id_task', taskId);
			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {},
				success: function (data) {

					blockColor.innerHTML = data
					var task = document.querySelector('.task_item[id="' + taskId + '"]');

					var colorBlockItem = task.querySelector('.tags')

					var formData = new FormData()
					formData.append('delete_item_color_task', taskId);
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (data) {
							colorBlockItem.innerHTML = data
							delColorTask()
							delColor()

						}
					})
				}
			})

		})
	}

}



async function delColor() {
	const delColorAll = document.querySelectorAll('.del_color')
	const modalTags = document.querySelector('.modal_tags')
	const blockTags = document.querySelector('.block_color_tags')

	for (let y = 0; y < delColorAll.length; y++) {
		const delColor = delColorAll[y]

		delColor.addEventListener('click', function (e) {

			var formData = new FormData()
			const idColor = e.target.dataset.id
			const idColorId = e.target.dataset.idcolor
			const hexColor = e.target.style.background
			const taskId = e.target.parentNode.dataset.task
			const blockTagsModalTask = document.querySelector('.block_tags')
			const lists = document.querySelector('.lists')

			formData.append('delete_color', idColor)
			formData.append('hex_color', hexColor)
			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {},
				success: function (data) {

					modalTags.innerHTML = data
					var formData = new FormData()
					formData.append('delete_block_color', idColor)
					formData.append('id_color_id', idColorId)
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (data) {
							blockTags.innerHTML = data

							var formData = new FormData()
							var task = document.querySelector('.task_item[id="' + taskId + '"]');
							const block_tags_task = task.querySelector('.tags')
							formData.append('delete_task_color_desctop', taskId)

							$.ajax({
								url: 'core/request.php',
								type: 'POST',
								data: formData,
								cache: false,
								contentType: false,
								processData: false,
								beforeSend: function () {},
								success: function (data) {
									lists.innerHTML = data

									var formData = new FormData()
									formData.append('delete_task_color_modal_task', taskId)
									$.ajax({
										url: 'core/request.php',
										type: 'POST',
										data: formData,
										cache: false,
										contentType: false,
										processData: false,
										beforeSend: function () {},
										success: function (data) {
											blockTagsModalTask.innerHTML = data
											addTaskColor()
											delColorTask()
											showActions()
											changeTitle()
											delList()
											addTask()
											dragNdrop()
											openModalTask()

										}
									})
								}
							})
						}
					})

				}
			})

		})

	}
}
delColor()


async function delTask() {
	const task = document.querySelector('.task_modal')
	const taskId = task.dataset.modal
	const btnTaskDelete = task.querySelector('.del_task')
	const lists = document.querySelector('.lists')

	btnTaskDelete.addEventListener('click', function (e) {
		var formData = new FormData()
		formData.append('delete_task', taskId);
		$.ajax({
			url: 'core/request.php',
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (result) {
				lists.innerHTML = result
				$('.js-modal.is-show').removeClass('is-show')
				$('.js-modal-overlay').removeClass('is-show')
				showActions()
				changeTitle()
				delList()
				addTask()
				dragNdrop()
				openModalTask()
			}
		})
	})
}

async function delFile() {
	const btnDelFileAll = document.querySelectorAll('.delete_file')
	const modalAttach = document.querySelector('.modal_attachments')

	for (let i = 0; i < btnDelFileAll.length; i++) {
		const btnDelFile = btnDelFileAll[i]


		btnDelFile.addEventListener('click', function (e) {

			const idTask = btnDelFile.dataset.idtask
			const idFile = btnDelFile.dataset.id
			var formData = new FormData();

			formData.append('delete_file_task_file', idFile);

			$.ajax({
				type: "POST",
				url: 'core/request.php',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				beforeSend: function () {},
				success: function () {
					var formData = new FormData();

					formData.append('id_task', idTask);
					formData.append('delete_file', idFile);

					$.ajax({
						type: "POST",
						url: 'core/request.php',
						cache: false,
						contentType: false,
						processData: false,
						data: formData,

						beforeSend: function () {},
						success: function (result) {

							modalAttach.innerHTML = result
							var formData = new FormData();


							var task = document.querySelector('.task_item[id="' + idTask + '"]');
							var viewFilesTask = task.querySelector('.item_files')
							formData.append('count_file_task', idTask);
							formData.append('id_file', idFile);

							$.ajax({
								type: "POST",
								url: 'core/request.php',
								cache: false,
								contentType: false,
								processData: false,
								data: formData,
								beforeSend: function () {},
								success: function (result) {

									viewFilesTask.innerHTML = result



								}

							});
						}

					});

					delFile()
				}

			});


		})



	}
}

async function delCover() {
	const btnDelCover = document.querySelector('.cancel-icon')

	btnDelCover.addEventListener('click', function (e) {
		e.target.style.display = 'none'
		var coverPreview = document.querySelector('.img-preview')
		var idTask = coverPreview.dataset.idcover
		var task = document.querySelector('.task_item[id="' + idTask + '"]');
		var content = document.querySelector('.content')
		var lists = document.querySelector('.lists')
		var titleModal = document.querySelector('.title_modal')
		var header = document.querySelector('.cover_modal')
		var cover_task_one = task.querySelector('.cover_task_one')
		var cover_task_two = task.querySelector('.cover_task_two')
		var size_cover = document.querySelector('.size_cover')
		size_cover.style.display = 'none'

		if (cover_task_one) {
			cover_task_one.style.display = 'none'
		}
		if (cover_task_two) {
			cover_task_two.style.display = 'none'
		}


		content.style.display = 'block'
		coverPreview.style.background = ''
		header.style.background = ''
		titleModal.style.paddingTop = '0px'
		var modalCover = task.dataset.cover

		var formData = new FormData();

		formData.append('delete_cover', idTask);
		formData.append('cover', '1');
		formData.append('modal_cover', modalCover);

		$.ajax({
			type: "POST",
			url: 'core/request.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function () {},
			success: function (result) {

				lists.innerHTML = result

				var formData = new FormData();

				formData.append('delete_cover_file', idTask);;
				formData.append('modal_cover', modalCover);
				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {



						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()

					}

				});

			}

		});

	})
}

async function checklist() {

	const blockCheck = document.querySelector('.block_check')
	const modalCheckbox = document.querySelector('.modal_checkbox')

	var idTask = modalCheckbox.dataset.idtask
	var task = document.querySelector('.task_item[id="' + idTask + '"]');

	blockCheck.addEventListener('click', function (e) {
		var formData = new FormData();

		formData.append('add_checklist', idTask);

		$.ajax({
			type: "POST",
			url: 'core/request.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function () {},
			success: function (result) {

				if (result) {
					modalCheckbox.innerHTML = result

					var formData = new FormData();
					var lists = document.querySelector('.lists')
					formData.append('view_checklist_task', idTask);

					$.ajax({
						type: "POST",
						url: 'core/request.php',
						cache: false,
						contentType: false,
						processData: false,
						data: formData,
						beforeSend: function () {},
						success: function (result) {

							if (result) {
								lists.innerHTML = result
								addLineCheck()
								chengeTitleCheck()
								deleteChecklist()
								deleteCheckLine()
								dragNdropCheck()
							}

							selectCheck()
							changeTitleCheckLine()
							showActions()
							changeTitle()
							delList()
							addTask()
							dragNdrop()
							openModalTask()
						}
					})

				}

			}
		})

	})
	/*addLineCheck()*/
	chengeTitleCheck()

}

async function chengeTitleCheck() {
	const checkTitles = document.querySelectorAll('.title_check')
	checkTitles.forEach(checkTitle => {


		checkTitle.addEventListener('click', function (e) {

			if (checkTitle.textContent == 'Название чек-листа') {
				checkTitle.textContent = ''

			}
			e.target.classList.add('focus')


		})

		checkTitle.addEventListener('keydown', function (e) {
			if (e.keyCode === 13) {
				this.blur()
			}
		})

		const emptyTitle = checkTitle

		document.addEventListener('click', function (e) {

			if (!emptyTitle.contains(e.target) && checkTitle.textContent == '') {

				checkTitle.textContent = 'Название чек-листа'

			}
		})

		checkTitle.addEventListener('input', function (e) {
			let id = e.target.dataset.title;
			let titleCheck = e.target.textContent;
			var formData = new FormData()
			if (titleCheck != '') {
				formData.append('change_title_check', titleCheck);
			} else {
				formData.append('change_title_check', 'Название чек-листа');
			}
			formData.append('id', id);
			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (result) {

				}
			})
		})

		checkTitle.addEventListener('keydown', function (e) {
			if (e.keyCode === 13) {

				if (checkTitle.textContent == '') {
					checkTitle.textContent = 'Название чек-листа'
				}
			}
		})
	})
}

async function addLineCheck() {

	const lineCheckboxAll = document.querySelectorAll('.line_checkbox')
	const modalCheckbox = document.querySelector('.modal_checkbox')
	var idTask = modalCheckbox.dataset.idtask
	for (let s = 0; s < lineCheckboxAll.length; s++) {

		const lineCheckbox = lineCheckboxAll[s]
		const add_check_btn = lineCheckbox.nextElementSibling.querySelector('.add_check_btn')

		if (add_check_btn) {
			add_check_btn.addEventListener('click', function (e) {

				var idLineCheck = lineCheckbox.dataset.check

				var formData = new FormData();

				formData.append('add_line_checklist', idLineCheck);
				formData.append('id_task', idTask);

				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {

						if (result) {
							modalCheckbox.innerHTML = result
							var formData = new FormData();
							var lists = document.querySelector('.lists')
							formData.append('view_checklist_task_line', idTask);

							$.ajax({
								type: "POST",
								url: 'core/request.php',
								cache: false,
								contentType: false,
								processData: false,
								data: formData,
								beforeSend: function () {},
								success: function (result) {

									if (result) {
										lists.innerHTML = result
										addLineCheck()
										chengeTitleCheck()
										deleteChecklist()
										deleteCheckLine()
										dragNdropCheck()
									}

									selectCheck()
									changeTitleCheckLine()
									showActions()
									changeTitle()
									delList()
									addTask()
									dragNdrop()
									openModalTask()
								}
							})
						}


					}
				})



			})
		}


	}

}

async function selectCheck() {
	/** Стилизация чекбоксов - плагин iCheck */

	$('input').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue',
		handle: 'checkbox'
	});
	$('input').on('ifChecked', function (event) {
		const parentCheck = event.target.parentNode
		const textCheck = parentCheck.nextElementSibling
		textCheckText = textCheck.querySelector('.chek_name')
		textCheckText.style.textDecoration = 'line-through'
		var idCheck = event.target.dataset.idcheck


		var progress_bar = parentCheck.parentNode.parentNode.previousElementSibling.querySelector('.check_progress')
		var count_chekbox = parentCheck.parentNode.parentNode.childElementCount

		var progress_precent = progress_bar.nextElementSibling

		var progress_ind = Math.ceil(100 / count_chekbox)



		value = progress_bar.value
		max = progress_bar.value + progress_ind;
		time = 1000 / (max * 5);



		var loading = function () {
			value += 1;
			progress_bar.value = value;
			progress_precent.innerHTML = Math.ceil(progress_bar.value) + '%'

			if (value == max) {
				clearInterval(animate);
			}
		}

		var animate = setInterval(function () {
			loading();
		}, time);

		var formData = new FormData();

		formData.append('check_status_2', idCheck);

		$.ajax({
			type: "POST",
			url: 'core/request.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function () {},
			success: function () {
				var formData = new FormData();
				var lists = document.querySelector('.lists')
				formData.append('view_checklist_task_check_line', 'idTask');

				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {

						if (result) {
							lists.innerHTML = result


						}

						selectCheck()
						changeTitleCheckLine()
						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()
					}
				})
			}
		})





	});
	$('input').on('ifUnchecked', function (event) {
		const parentCheck = event.target.parentNode
		const textCheck = parentCheck.nextElementSibling
		textCheckText = textCheck.querySelector('.chek_name')
		textCheckText.style.textDecoration = 'none'
		var idCheck = event.target.dataset.idcheck

		var progress_bar = parentCheck.parentNode.parentNode.previousElementSibling.querySelector('.check_progress')
		var count_chekbox = parentCheck.parentNode.parentNode.childElementCount

		var progress_precent = progress_bar.nextElementSibling

		var progress_ind = Math.ceil(100 / count_chekbox)



		value = progress_bar.value
		max = progress_bar.value - progress_ind;
		time = 1000 / (max * 5);



		var loading = function () {
			value -= 1;
			progress_bar.value = value;
			progress_precent.innerHTML = Math.ceil(progress_bar.value) + '%'

			if (value == max) {
				clearInterval(animate);
			}
		}

		var animate = setInterval(function () {
			loading();
		}, time);


		var formData = new FormData();

		formData.append('check_status_1', idCheck);

		$.ajax({
			type: "POST",
			url: 'core/request.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function () {},
			success: function () {
				var formData = new FormData();
				var lists = document.querySelector('.lists')
				formData.append('view_checklist_task_uncheck_line', 'idTask');

				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {

						if (result) {
							lists.innerHTML = result

						}

						selectCheck()
						changeTitleCheckLine()
						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()
					}
				})
			}
		})
	});
}

async function changeTitleCheckLine() {

	const titleCheckLineAll = document.querySelectorAll('.chek_name')

	titleCheckLineAll.forEach(titleCheckLine => {


		titleCheckLine.addEventListener('click', function (e) {

			if (titleCheckLine.textContent == 'Название элемента') {
				titleCheckLine.textContent = ''
			}
			e.target.classList.add('focus')


		})

		titleCheckLine.addEventListener('keydown', function (e) {
			if (e.keyCode === 13) {
				this.blur()
			}
		})

		const emptyTitle = titleCheckLine

		document.addEventListener('click', function (e) {

			if (!emptyTitle.contains(e.target)) {


			}
			if (!emptyTitle.contains(e.target) && titleCheckLine.textContent == '') {

				titleCheckLine.textContent = 'Название элемента'

			}
		})

		titleCheckLine.addEventListener('input', function (e) {
			let id = e.target.dataset.idtitlecheck;
			let titleCheck = e.target.textContent;
			var formData = new FormData()
			if (titleCheck != '') {
				formData.append('change_title_check_line', titleCheck);
			} else {
				formData.append('change_title_check_line', 'Название элемента');
			}
			formData.append('id', id);
			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (result) {

				}
			})
		})

		titleCheckLine.addEventListener('keydown', function (e) {
			if (e.keyCode === 13) {

				if (titleCheckLine.textContent == '') {
					titleCheckLine.textContent = 'Название элемента'
				}
			}
		})
	})
}

async function deleteChecklist() {
	const btnDelCheckAll = document.querySelectorAll('.btn_del_check')

	btnDelCheckAll.forEach(btnDelCheck => {


		btnDelCheck.addEventListener('click', function (e) {
			let id = e.target.dataset.idcheck;
			let id_task = e.target.dataset.idtask;
			const modalCheckbox = document.querySelector('.modal_checkbox')

			var formData = new FormData()

			formData.append('delete_check', id);
			formData.append('id_task', id_task);
			$.ajax({
				type: "POST",
				url: 'core/request.php',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				beforeSend: function () {},
				success: function (result) {

					if (result) {
						modalCheckbox.innerHTML = result

						var formData = new FormData();
						var lists = document.querySelector('.lists')
						formData.append('delete_checklist_task', id_task);

						$.ajax({
							type: "POST",
							url: 'core/request.php',
							cache: false,
							contentType: false,
							processData: false,
							data: formData,
							beforeSend: function () {},
							success: function (result) {

								if (result) {
									lists.innerHTML = result
									addLineCheck()
									chengeTitleCheck()
									deleteChecklist()
									deleteCheckLine()
									dragNdropCheck()
								}

								selectCheck()
								changeTitleCheckLine()
								showActions()
								changeTitle()
								delList()
								addTask()
								dragNdrop()
								openModalTask()
							}
						})
					}

					selectCheck()


				}
			})
		})
	})
}

async function deleteCheckLine() {
	const lineCheckboxAll = document.querySelectorAll('.icheckbox')
	const modalCheckbox = document.querySelector('.modal_checkbox')
	var idTask = modalCheckbox.dataset.idtask
	for (let s = 0; s < lineCheckboxAll.length; s++) {

		const lineCheckbox = lineCheckboxAll[s]
		const add_check_line_btn = lineCheckbox.querySelector('.btn_del_check_line')

		if (add_check_line_btn) {
			add_check_line_btn.addEventListener('click', function (e) {

				var idLineCheckList = lineCheckbox.dataset.check
				var idLineCheckItem = e.target.dataset.idcheckline
				console.log(idLineCheckItem)
				var formData = new FormData();

				formData.append('id_check', idLineCheckList);
				formData.append('del_line_check', idLineCheckItem);
				formData.append('id_task', idTask);
				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {

						if (result) {
							modalCheckbox.innerHTML = result
							var formData = new FormData();
							var lists = document.querySelector('.lists')
							formData.append('delete_checkline_task', idTask);

							$.ajax({
								type: "POST",
								url: 'core/request.php',
								cache: false,
								contentType: false,
								processData: false,
								data: formData,
								beforeSend: function () {},
								success: function (result) {

									if (result) {
										lists.innerHTML = result
										addLineCheck()
										chengeTitleCheck()
										deleteChecklist()
										deleteCheckLine()
										dragNdropCheck()
									}

									selectCheck()
									changeTitleCheckLine()
									showActions()
									changeTitle()
									delList()
									addTask()
									dragNdrop()
									openModalTask()
								}
							})
						}



					}
				})



			})
		}
	}

}

async function addComment() {
	const blockComm = document.querySelector('.items_comm')
	const btnAddComm = document.querySelector('.btn_add_comm')
	const addCommInput = document.querySelector('.add_comm_input')

	const idUserComm = btnAddComm.dataset.iduser

	addCommInput.addEventListener('input', e => {
		value = e.target.innerHTML

		if (value) {
			btnAddComm.style.display = "block"
		} else {
			btnAddComm.style.display = "none"
		}
	})

	addCommInput.addEventListener('keydown', function (e) {
		if (e.keyCode === 27) {
			addCommInput.innerHTML = ''

			btnAddComm.style.display = "none"
		}
	})

	btnAddComm.addEventListener('click', function (e) {
		var idTask = addCommInput.dataset.idtask
		var commValue = addCommInput.innerHTML
		var lists = document.querySelector('.lists')
		addCommInput.innerHTML = ''
		btnAddComm.style.display = "none"


		var formData = new FormData();

		formData.append('add_comm_task', commValue);
		formData.append('id_task', idTask);

		formData.append('id_user', idUserComm);
		$.ajax({
			type: "POST",
			url: 'core/request.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function () {},
			success: function (result) {
				if (result) {
					blockComm.innerHTML = result
					deleteComment()
					changeComment()
				}

				var formData = new FormData();

				formData.append('view_comm_task_list', idUserComm);
				$.ajax({
					type: "POST",
					url: 'core/request.php',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					beforeSend: function () {},
					success: function (result) {
						if (result) {
							lists.innerHTML = result
							showActions()
							changeTitle()
							delList()
							addTask()
							dragNdrop()
							openModalTask()
						}
					}
				})
			}
		})
	})
}

async function viewComment() {
	const blockComm = document.querySelector('.items_comm')
	var idTask = blockComm.dataset.idtask
	var lists = document.querySelector('.lists')
	var formData = new FormData();

	formData.append('view_comm', idTask);

	$.ajax({
		type: "POST",
		url: 'core/request.php',
		cache: false,
		contentType: false,
		processData: false,
		data: formData,
		beforeSend: function () {},
		success: function (result) {
			if (result) {
				blockComm.innerHTML = result
				deleteComment()
				changeComment()
			}
			var formData = new FormData();

			formData.append('view_comm_task_list', idTask);
			$.ajax({
				type: "POST",
				url: 'core/request.php',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				beforeSend: function () {},
				success: function (result) {
					if (result) {
						lists.innerHTML = result
						showActions()
						changeTitle()
						delList()
						addTask()
						dragNdrop()
						openModalTask()
					}
				}
			})
		}
	})
}

async function deleteComment() {
	const btnDelCommAll = document.querySelectorAll('.del_comm_fas_comm')
	const blockComm = document.querySelector('.items_comm')
	var lists = document.querySelector('.lists')
	for (let w = 0; w < btnDelCommAll.length; w++) {
		const btnDelComm = btnDelCommAll[w]

		btnDelComm.addEventListener('click', function (e) {

			var idComm = btnDelComm.dataset.idcomm
			var idTask = blockComm.dataset.idtask
			console.log(idComm)
			var formData = new FormData();

			formData.append('del_comm', idComm);
			formData.append('id_task', idTask);

			$.ajax({
				type: "POST",
				url: 'core/request.php',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				beforeSend: function () {},
				success: function (result) {
					if (result) {
						blockComm.innerHTML = result
						deleteComment()
						changeComment()
					}
					var formData = new FormData();

					formData.append('view_comm_task_list', idComm);
					$.ajax({
						type: "POST",
						url: 'core/request.php',
						cache: false,
						contentType: false,
						processData: false,
						data: formData,
						beforeSend: function () {},
						success: function (result) {
							if (result) {
								lists.innerHTML = result
								showActions()
								changeTitle()
								delList()
								addTask()
								dragNdrop()
								openModalTask()
							}
						}
					})
				}
			})
		})



	}
}

async function dragNdropCheck() {

	const dragCheck = document.querySelector(".line_checkbox")
	new Sortable(dragCheck, {
		group: "line_checkbox",
		animation: 150,
		handle: ".handler_check",
		ghostClass: "selected_check",
		sort: true,
		forceFallback: false,
		onEnd: function (evt) {

			var item_order = new Array();
			$('.icheckbox').each(function () {
				item_order.push($(this).attr("data-id"));
			});
			var order_string = 'order_check=' + item_order;

			$.ajax({
				type: "GET",
				url: "core/request.php",
				data: order_string,
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {

				}
			});

		}
	})
}

async function changeComment() {

	const commentAll = document.querySelectorAll('.next_comm')

	commentAll.forEach(comment => {

		comment.addEventListener('click', function (e) {
			
			if (e.target.textContent == 'Пустой комментарий') {
				e.target.textContent = ''
			}
			if(e.target.hasAttribute('contenteditable')){
				e.target.classList.add('focus')
			}
			


		})

		comment.addEventListener('keydown', function (e) {
			if (e.keyCode === 13) {
				this.blur()
				e.target.classList.remove('focus')
			}
		})

		const emptyTitle = comment

		document.addEventListener('click', function (e) {

			if (!emptyTitle.contains(e.target) && comment.textContent == '') {

				comment.textContent = 'Пустой комментарий'
				e.target.classList.remove('focus')
			}
		})

		comment.addEventListener('input', function (e) {
			let id = e.target.dataset.idcomm;
			let titleCheck = e.target.innerHTML;
			var formData = new FormData()
			if (titleCheck != '') {
				formData.append('change_comment', titleCheck);
			} else {
				formData.append('change_comment', 'Пустой комментарий');
			}
			formData.append('id', id);
			$.ajax({
				url: 'core/request.php',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {

				},
				success: function (result) {

				}
			})
		})

		document.addEventListener('click', function (e) {

				if (e.target != comment) {
					comment.classList.remove('focus')
				}
			
		})

		comment.addEventListener('keydown', function (e) {
			
			if (e.keyCode === 13) {

				if (e.target.textContent == '') {
					e.target.textContent = 'Пустой комментарий'
					e.target.classList.remove('focus')
				}
			}
		})
	})
}