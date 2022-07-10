<div class="group_contacts_zone">
    <div class="group_contacts_zone_item">
        <div class="header_group_contacts">
            <span spellcheck="false" class="title_group_contacts no_focus focus" contenteditable="true"><?php echo $id_block_group_contacts[0]['title']; ?></span>
        </div>
        <div class="group_contacts">
            <div class="lists_group">
                <?php foreach ($contacts_groups as $contacts_group) { ?>
                    <div class="group_contacts_item" data-idgroup="<?php echo $contacts_group['id']; ?>">
                        <div class="left_section_group">
                            <div class="handler_check_group"><i class="fa-solid fa-grip-vertical"></i></div>
                            <div class="title_group_contacts_item" data-idgroup="<?php echo $contacts_group['id']; ?>"><?php echo $contacts_group['title']; ?></div>
                        </div>
                        <div class="action_group"><i class="fa-solid fa-ellipsis-vertical"></i>
							<div class="action_group_btns">
								<p class="action_group_edit">Изменить</p>
								<p class="action_group_del">Удалить</p>
							</div>
                        </div>
                        
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form_add_group">
            <textarea class="textarea_add_group" placeholder="Введите название группы"></textarea>
            <div class="buttons_add_group">
                <button class="add_item_group">Добавить</button>
                <button class="cancel_item_group">Отмена</button>
            </div>
        </div>
        <div class="add_group"><span> + </span> Добавить группу</div>
    </div>
</div>

<div class="table_contacts">
    <div class="block_table_contacts">
        <table>
            <thead>
                <tr>
                    <th class="table_handle"></th>
                    <th class="thead table_avatar">Фото</th>
                    <td class="thead">Имя</td>
                    <td class="thead">Email</td>
					<td class="thead">Телефон</td>
					<!--<td class="thead">Доски</td>-->
                    <td class="thead">Роль</td>
                    <td class="thead">Должность</td>
					<td class="thead"></td>
					
                </tr>
            </thead>
            <tbody class="dnd_conacts">
            </tbody>
        </table>
    </div>
</div>