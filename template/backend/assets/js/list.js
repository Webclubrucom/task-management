/** Добавление списка */

async function addList() {

    const btnAddList = document.querySelector('.add_list_item')

    btnAddList.addEventListener('click', function (e) {
        const lists = document.querySelector('.lists')

        var formData = new FormData()
        var title = 'Введите название';
        formData.append('add_list', title);
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
addList()


/** Изменение название списка */

async function changeTitle() {
    const titles = document.querySelectorAll('.title')
    titles.forEach(title => {

        title.addEventListener('mousedown', function (e) {

            e.target.contentEditable = "true"


        })

        title.addEventListener('mouseup', function (e) {

            if (title.textContent == 'Введите название') {
                title.textContent = ''
            }
            e.target.classList.add('focus')


        })

        title.addEventListener('keydown', function (e) {
            if (e.keyCode === 13) {
                title.contentEditable = "false"
                this.blur()
            }
        })

        const emptyTitle = title

        document.addEventListener('click', function (e) {

            if (!emptyTitle.contains(e.target)) {

                title.contentEditable = "false"

            }
            if (!emptyTitle.contains(e.target) && title.textContent == '') {

                title.textContent = 'Введите название'

            }
        })

        title.addEventListener('input', function (e) {
            let id = e.target.dataset.title;
            let titleList = e.target.textContent;
            var formData = new FormData()
            if (titleList != '') {
                formData.append('change_title_list', titleList);
            } else {
                formData.append('change_title_list', 'Введите название');
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

        title.addEventListener('keydown', function (e) {
            if (e.keyCode === 13) {

                if (title.textContent == '') {
                    title.textContent = 'Введите название'
                }
            }
        })
    })
}
changeTitle()

/** Показать/Скрыть кнопку удаления списка */

async function showActions() {
    const listZoneAll = document.querySelectorAll('.list_zone')
    for (let s = 0; s < listZoneAll.length; s++) {
        const listZone = listZoneAll[s]
        const actions = listZone.querySelector('.actions')
        const action = listZone.querySelector('.action')

        actions.addEventListener('click', function (e) {

            if (action.classList.contains('active_block')) {
                action.classList.remove('active_block')
            } else {
                action.classList.add('active_block')
            }
        })

        /** Скрытие блоков при клике не по необходимому элементу */

        const activeBlock = listZone.querySelector('.close_action')

        document.addEventListener('click', function (e) {
            if (!activeBlock.contains(e.target)) {
                action.classList.remove('active_block')
            }
        })

    }

}
showActions()

/** Удаление списка */

async function delList() {
    const listZoneAll = document.querySelectorAll('.list_zone')
    for (let y = 0; y < listZoneAll.length; y++) {
        const list = listZoneAll[y]
        const btnDel = list.querySelector('.action')
        btnDel.addEventListener('click', function (e) {
            list.remove()
            let id = list.id;

            var formData = new FormData()
            formData.append('del_list', id);
            $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {},
                success: function (result) {


                }
            })

        })
    }
}
delList()

/** Перетаскивание списков с помощью библиотеки SortableJS. GitHub - https://github.com/SortableJS/Sortable */


async function dragNdropList() {

    const dragArea = document.querySelector(".lists")
    new Sortable(dragArea, {
        group: "lists",
        animation: 150,
        handle: ".adden_list",
        ghostClass: "drag_background",
        sort: true,
        dataIdAttr: 'data-zone',
        forceFallback: true,
        onEnd: function (evt) {

            evt.item.querySelector('.title').contentEditable = "false"

            //console.log(evt.newDraggableIndex)title

            var item_order = new Array();
            $('.list_zone').each(function () {
                item_order.push($(this).attr("id"));
            });
            var order_string = 'order_list=' + item_order;

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
dragNdropList()