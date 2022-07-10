/** Добавление карточек (задач) */

async function addTask(){
    
const listZoneAll    = document.querySelectorAll('.list_zone')
const lists = document.querySelector('.lists')
    
    for(let y = 0; y < listZoneAll.length; y++){
        const list = listZoneAll[y]
        const btnAddTask = list.querySelector('.add_task')
        const cancelBtn = list.querySelector('.cancel_item')
        const form = list.querySelector('.form')
        const addItem = list.querySelector('.add_item')
        const textarea = list.querySelector('.textarea')
        const tasks = list.querySelector('.tasks')

        btnAddTask.addEventListener('click', function(e) {
            form.style.display = "block"
            btnAddTask.style.display = "none"
            addItem.style.display = "none"
            textarea.focus()
            textarea.addEventListener('input', e =>{
                value = e.target.value
                
                if(value){
                    addItem.style.display = "block"
                } else {
                    addItem.style.display = "none"
                }
            })
        })
        
        cancelBtn.addEventListener('click', () =>{
            textarea.value = ''
            value = ''
            form.style.display = "none"
            btnAddTask.style.display = "flex"
    
        })
        textarea.addEventListener('keydown', function(e) {
            if (e.keyCode === 27) {
                textarea.value = ''
                value = ''
                form.style.display = "none"
                btnAddTask.style.display = "flex"
            }
        })

        textarea.addEventListener('keydown', function(e) {
            if (e.keyCode === 13) {

                this.blur()
    
                if(value != ''){

                    const listId = form.dataset.form

                    var formData = new FormData()
                    var title = value;
                    formData.append('add_task', title);
                    formData.append('list_id', listId);
                    $.ajax({
                        url: 'core/request.php',
                        type: 'POST',
                        data: formData,
                        cache: false,
						contentType: false,
						processData: false,
                        beforeSend: function(){
                        },
                        success: function(result){
                          lists.innerHTML = result
                          showActions()
                          changeTitle()
                          delList()
                          dragNdrop()
                          addTask()
                          openModalTask()
                        }
                    })

                    form.style.display = "none"
                    btnAddTask.style.display = "flex"
                    textarea.value = ''
                    value = ''
                }
            }
        })

        addItem.addEventListener('click', () =>{

            const listId = form.dataset.form

            var formData = new FormData()
            var title = value;
            formData.append('add_task', title);
            formData.append('list_id', listId);
            $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
				contentType: false,
				processData: false,
                beforeSend: function(){
                },
                success: function(result){
                  lists.innerHTML = result
                  showActions()
                  changeTitle()
                  delList()
                  dragNdrop()
                  addTask()
                  openModalTask()
                }
            })

            form.style.display = "none"
            btnAddTask.style.display = "flex"
            textarea.value = ''
            value = ''
        })
    }
}
addTask()

/** Перетаскивание задач между списками и их сортировка в списке */

function dragNdrop(){

	const tasksAll = document.querySelectorAll('.tasks')

	for(let i = 0; i < tasksAll.length; i++){
        const task = tasksAll[i]

		new Sortable(task, {
			group: "tasks",
			animation: 50,
			ghostClass: "selected",
			dataIdAttr: 'data-id',
			sort: true,
            forceFallback: true,
			onEnd: function(evt) {

				var item_order = new Array();
				$('.task_item').each(function() {
					item_order.push($(this).attr("id"));
				}); 
				var order_string = 'order_task='+item_order;
	
				$.ajax({
					type: "GET",
					url: "core/request.php",
					data: order_string,
					cache: false,
					contentType: false,
					processData: false,
					success: function(){}
				})
				var formData = new FormData()
                                
				var idTask = evt.item.id
				var idList = evt.to.dataset.list
				
				console.log(idTask)
				console.log(idList)

				formData.append('id', idTask);
				formData.append('task_list_id', idList);
				$.ajax({
					type: "POST",
					url: "core/request.php",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(){}
				})
			}
		})
	}
}
dragNdrop()
