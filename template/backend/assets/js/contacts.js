/** Переключение страниц */

async function selectPage() {
    var btnBoardsPage = document.querySelector('.btn_menu_boards')
    var btnContactsPage = document.querySelector('.btn_menu_contacts')
    var contacts = document.querySelector('.contacts')
    var lists = document.querySelector('.lists')

    btnContactsPage.addEventListener('click', function (e) {
        lists.style.display = 'none'
        contacts.style.display = 'flex'
		btnContactsPage.style.display = 'none'
		btnBoardsPage.style.display = 'block'

        var formData = new FormData()
        const dnd_conacts = document.querySelector('.dnd_conacts')
        formData.append('open_page_contacts', 'id_group');

        $.ajax({
            url: 'core/request.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (result) {
                dnd_conacts.innerHTML = result
				actionsContacts()
				delContacts()
            }
        })
    })
    btnBoardsPage.addEventListener('click', function (e) {
        lists.style.display = 'flex'
        contacts.style.display = 'none'
		btnContactsPage.style.display = 'block'
		btnBoardsPage.style.display = 'none'
    })
}
selectPage()

/** Добавление групп контактов */

async function addGroupContacts() {
    const group_contacts_zone = document.querySelector('.group_contacts_zone_item')
    const add_group = group_contacts_zone.querySelector('.add_group')
    const cancel_item_group = group_contacts_zone.querySelector('.cancel_item_group')
    const form_add_group = group_contacts_zone.querySelector('.form_add_group')
    const add_item_group = group_contacts_zone.querySelector('.add_item_group')
    const textarea_add_group = group_contacts_zone.querySelector('.textarea_add_group')
    const lists_group = group_contacts_zone.querySelector('.lists_group')
    add_group.addEventListener('click', function (e) {
        form_add_group.style.display = "block"
        add_group.style.display = "none"
        add_item_group.style.display = "none"
        textarea_add_group.focus()
        textarea_add_group.addEventListener('input', e => {
            value = e.target.value
            if (value) {
                add_item_group.style.display = "block"
            } else {
                add_item_group.style.display = "none"
            }
        })
    })
    cancel_item_group.addEventListener('click', () => {
        textarea_add_group.value = ''
        value = ''
        form_add_group.style.display = "none"
        add_group.style.display = "flex"
    })
    textarea_add_group.addEventListener('keydown', function (e) {
        if (e.keyCode === 27) {
            textarea_add_group.value = ''
            value = ''
            form_add_group.style.display = "none"
            add_group.style.display = "flex"
        }
    })
    textarea_add_group.addEventListener('keydown', function (e) {
        if (e.keyCode === 13) {
            this.blur()
            if (value != '') {
                var formData = new FormData()
                var titleGroup = value;
                formData.append('add_group_contacts', titleGroup);
                $.ajax({
                    url: 'core/request.php',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {},
                    success: function (result) {
                        lists_group.innerHTML = result
						actionGroupContacts()
						delGroupContacts()
						openTabContacts()
						
						var formData = new FormData()
						var blockAddGroupContactSettings = document.getElementById('group_member');
						formData.append('select_group_contacts_settings', blockAddGroupContactSettings);
						$.ajax({
							url: 'core/request.php',
							type: 'POST',
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {},
							success: function (result) {
								blockAddGroupContactSettings.innerHTML = result

							}
						})
                    }
                })
                form_add_group.style.display = "none"
                add_group.style.display = "flex"
                textarea_add_group.value = ''
                value = ''
            }
        }
    })
    add_item_group.addEventListener('click', () => {
        var formData = new FormData()
        var titleGroup = value;
        formData.append('add_group_contacts', titleGroup);
        $.ajax({
            url: 'core/request.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (result) {
                lists_group.innerHTML = result
				actionGroupContacts()
				delGroupContacts()
				openTabContacts()
				
				var formData = new FormData()
				var blockAddGroupContactSettings = document.getElementById('group_member');
				formData.append('select_group_contacts_settings', blockAddGroupContactSettings);
				$.ajax({
					url: 'core/request.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {},
					success: function (result) {
						blockAddGroupContactSettings.innerHTML = result

					}
				})
            }
        })
        form_add_group.style.display = "none"
        add_group.style.display = "flex"
        textarea_add_group.value = ''
        value = ''
    })
}
addGroupContacts()



/* Клик по группе контактов (Отображение группы контактов по клику) */

async function openTabContacts() {
    const groupContactsItemAll = document.querySelectorAll('.group_contacts_item')
    
    for (let y = 0; y < groupContactsItemAll.length; y++) {
        const groupContactsItem = groupContactsItemAll[y]

        var btnOpenContacts = groupContactsItem.querySelector('.title_group_contacts_item')

        btnOpenContacts.addEventListener('click', function (e) {
            var id_group = e.target.dataset.idgroup
           
            var formData = new FormData()
            const dnd_conacts = document.querySelector('.dnd_conacts')
            formData.append('open_contacts_group', id_group);

            $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {},
                success: function (result) {
                    dnd_conacts.innerHTML = result
					actionsContacts()
					delContacts()
                }
            })
        })
    }
}
openTabContacts()

/** Перетаскивание списков групп контактов с помощью библиотеки SortableJS. GitHub - https://github.com/SortableJS/Sortable */


async function dragNdropGroupContacts() {

    const dragGroup = document.querySelector(".lists_group")
    new Sortable(dragGroup, {
        group: "lists_group",
        animation: 150,
        handle: ".handler_check_group",
        ghostClass: "drag_background",
        sort: true,

        
        onEnd: function (evt) {

            var item_order = new Array();
            $('.group_contacts_item').each(function () {
                item_order.push($(this).attr("data-idgroup"));
            });
            var order_string = 'order_group=' + item_order;

            $.ajax({
                type: "GET",
                url: "core/request.php",
                data: order_string,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {}
            });
        }
    })
}
dragNdropGroupContacts()


/** Перетаскивание контактов с помощью библиотеки SortableJS. GitHub - https://github.com/SortableJS/Sortable */


async function dragNdropContacts() {

    const dragGroup = document.querySelector(".dnd_conacts")
    new Sortable(dragGroup, {
        group: "dnd_conacts",
        animation: 150,
        handle: ".table_handle",
        ghostClass: "drag_background",
        sort: true,

        onEnd: function (evt) {

            var item_order = new Array();
            $('.dnd_item_conacts').each(function () {
                item_order.push($(this).attr("data-idcontact"));
            });
            var order_string = 'order_contacts=' + item_order;

            $.ajax({
                type: "GET",
                url: "core/request.php",
                data: order_string,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {}
            });
        }
    })
}
dragNdropContacts()

/** Открытие окна с действиями групп контактов (удаление, изменение) */

async function actionGroupContacts() {

    const actionGroupContactsAll = document.querySelectorAll('.action_group')
    for (let s = 0; s < actionGroupContactsAll.length; s++) {
        const actionGroupContacts = actionGroupContactsAll[s]
        //const actions = actionGroupContacts.querySelector('.actions')
        const action = actionGroupContacts.querySelector('.action_group_btns')

        actionGroupContacts.addEventListener('click', function (e) {

            if (action.classList.contains('active_block')) {
                action.classList.remove('active_block')
            } else {
                action.classList.add('active_block')
            }
        })

        /** Скрытие блоков при клике не по необходимому элементу */

        const activeBlock = actionGroupContacts.querySelector('.close_action')
 
        document.addEventListener('click', function (e) {
            if (!actionGroupContacts.contains(e.target)) {
                action.classList.remove('active_block')
            }
        })

    }
}
actionGroupContacts()

/** Удаление группы контактов */

async function delGroupContacts() {
    const delGroupContactAll = document.querySelectorAll('.group_contacts_item')
    for (let y = 0; y < delGroupContactAll.length; y++) {
        const delGroupContact = delGroupContactAll[y]
        const btnDel = delGroupContact.querySelector('.action_group_del')
        btnDel.addEventListener('click', function (e) {
            delGroupContact.remove()
            let id = delGroupContact.dataset.idgroup;

            var formData = new FormData()
            formData.append('del_group_contacts', id);
            $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {},
                success: function (result) {
					var formData = new FormData()
					const dnd_conacts = document.querySelector('.dnd_conacts')
					formData.append('open_page_contacts', 'id_group');

					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (result) {
							dnd_conacts.innerHTML = result
						}
					})
					
					
					var formData = new FormData()
					var blockAddGroupContactSettings = document.getElementById('group_member');
					formData.append('select_group_contacts_settings', blockAddGroupContactSettings);
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (result) {
							blockAddGroupContactSettings.innerHTML = result
							
							
						}
					})

                }
            })

        })
    }
}
delGroupContacts()

/** Функция выделения текста */

function selectElementContents(el) {
    var range = document.createRange();
    range.selectNodeContents(el);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
}

/** Изменение название блока групп контактов */

async function changeTitleGroupContats() {
    const editGroupContactAll = document.querySelectorAll('.group_contacts_item')
    for (let y = 0; y < editGroupContactAll.length; y++) {
        const editGroupContact = editGroupContactAll[y]
        const btnEdit = editGroupContact.querySelector('.action_group_edit')
        btnEdit.addEventListener('click', function (e) {
            const titleGroupEdit = editGroupContact.querySelector('.title_group_contacts_item')
			titleGroupEdit.contentEditable = "true"
			titleGroupEdit.classList.add('group_focus')
			titleGroupEdit.focus()
            
			selectElementContents(titleGroupEdit)

        })
		
		const titleGroupInput = editGroupContact.querySelector('.title_group_contacts_item')
		titleGroupInput.addEventListener('input', function (e) {
            let idgroup = e.target.dataset.idgroup;
            let titleGroupText = e.target.textContent;
            var formData = new FormData()
            if (titleGroupText != '') {
                formData.append('change_title_group', titleGroupText);
            } else {
                formData.append('change_title_group', 'Название группы');
            }
            formData.append('idgroup', idgroup);
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
					var formData = new FormData()
					var blockAddGroupContactSettings = document.getElementById('group_member');
					formData.append('select_group_contacts_settings', blockAddGroupContactSettings);
					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (result) {
							blockAddGroupContactSettings.innerHTML = result
							
							
						}
					})
                }
            })
        })
		
		titleGroupInput.addEventListener('keydown', function (e) {
            if (e.keyCode === 13) {
                titleGroupInput.contentEditable = "false"
                this.blur()
				window.getSelection().removeAllRanges()
            }
        })
		
		
			document.addEventListener('click', function (e) {

				if (!titleGroupInput.contains(e.target) &&  !btnEdit.contains(e.target) ) {

					titleGroupInput.contentEditable = "false"

				}
				
			})
		

        
    }
}
changeTitleGroupContats()

/** Открытие окна с действиями контактов (удаление, изменение) */

async function actionsContacts() {

    const actionContactsAll = document.querySelectorAll('.action_contact')
	
    for (let s = 0; s < actionContactsAll.length; s++) {
        const actionContacts = actionContactsAll[s]
        
        const action = actionContacts.querySelector('.action_contact_btns')

        actionContacts.addEventListener('click', function (e) {

            if (action.classList.contains('active_block')) {
                action.classList.remove('active_block')
            } else {
                action.classList.add('active_block')
            }
        })

        /** Скрытие блоков при клике не по необходимому элементу */

 
        document.addEventListener('click', function (e) {
            if (!actionContacts.contains(e.target)) {
                action.classList.remove('active_block')
            }
        })

    }
}


/** Удаление контактов */

async function delContacts() {
	
    const delContactAll = document.querySelectorAll('.dnd_item_conacts')
	console.log(delContactAll)
    for (let y = 0; y < delContactAll.length; y++) {
        const delContact = delContactAll[y]
        var btnDel = delContact.querySelector('.action_contact_del')
		
        btnDel.addEventListener('click', function (e) {
            delContact.remove()
            let id = delContact.dataset.idcontact;

            var formData = new FormData()
            formData.append('del_contacts', id);
            $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {},
                success: function (result) {
					var formData = new FormData()
					const dnd_conacts = document.querySelector('.dnd_conacts')
					formData.append('open_page_contacts', 'id_group');

					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (result) {
							dnd_conacts.innerHTML = result
							actionsContacts()
							delContacts()
						}
					})
                }
            })

        })
    }
}
