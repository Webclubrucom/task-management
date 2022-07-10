<?php foreach ($tasks as $task) :
	if ($task['list_id'] == $list['id']) : ?>
		<div class="task_item open_edit_task js-open-modal" id="<?= $task['id'] ?>" data-modal="<?= $task['id'] ?>" data-title="<?= $task['title'] ?>" data-desc="<?= $task['description'] ?>" data-cover="<?= $task['cover'] ?>" data-typecover="<?= $task['type_cover'] ?>" data-avatar="<?= $userdata[0]['avatar'] ?>">
			<?php if ($task['cover'] != '1') { ?>
				<?php if ($task['type_cover'] == '1') {  ?>
					<div class="cover_task_one">
						<div class="cover_one" style="background: url('template/backend/assets/images/covers/<?= $task['cover'] ?>') center / cover no-repeat;"></div>
					</div>
				<?php } else { ?>
					<div class="cover_task_two">
						<div class="cover_two" style="background: url('template/backend/assets/images/covers/<?= $task['cover'] ?>') center / cover no-repeat;">
							<div class="section_two">
								<div class="back_two">
									<span class="title_task"><?php echo html_entity_decode($task['title']); ?></span>


									<div class="icon_task">
										<div class="item_clip">
											<?php if ($task['period'] != '1') : ?>
												<span class="span_clip"><i class="fal fa-clock"></i> <?php echo substr($task['period'], 0, -5); ?></span>
											<?php endif; ?>
										</div>
										<div class="left_icons">
											<?php
											$coun_checklists = 0;
											$coun_checklists_line = 0;
											$coun_checklists_line_check = 0;
											foreach ($checklists as $checklist) {

												if ($checklist['id_task'] == $task['id']) {
													$coun_checklists++;
													foreach ($checklists_line as $checklist_line) {
														if ($checklist_line['id_check'] == $checklist['id']) {
															$coun_checklists_line++;

															if ($checklist_line['id_check'] == $checklist['id'] && $checklist_line['status'] == '2') {
																$coun_checklists_line_check++;
															}
														}
													}
												}
											}

											if ($coun_checklists > 0) {

											?>

												<div class="item_check">
													<span class="span_clip"><i class="fal fa-check-square"></i> <?php echo $coun_checklists_line_check; ?>/<?php echo $coun_checklists_line; ?></span>
												</div>

											<?php } ?>
											<div class="item_files">

												<?php

												$coun_files = array_filter($attachments, function ($v) use ($task) {
													return isset($v['id_task'])
														&& $v['id_task'] == $task['id'];
												});

												if (count($coun_files) > 0) {
												?>
													<span class="span_clip"><i class="fal fa-paperclip"></i> <?php echo count($coun_files); ?></span>

												<?php } ?>

											</div>
										</div>

									</div>
								</div>

							</div>



						</div>


					</div>
				<?php } ?>
			<?php } ?>
			<div class="tags">
				<?php foreach ($taskColors as $taskColor) : ?>
					<?php if ($task['id'] == $taskColor['id_task']) : ?>
						<div class="tag" style="background:<?php echo $taskColor['id_color']; ?>;"></div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<span class="title_task"><?php echo html_entity_decode($task['title']); ?></span>
			<div class="item_edit" data-edit="<?= $task['id'] ?>"><i class="fas fa-pencil-alt icon_task_edit"></i></div>

			<div class="icon_task">
				<div class="item_clip">
					<?php if ($task['period'] != '1') : ?>
						<span class="span_clip"><i class="fal fa-clock"></i> <?php echo substr($task['period'], 0, -5); ?></span>
					<?php endif; ?>
				</div>
				<div class="left_icons">

					<?php
					$coun_checklists = 0;
					$coun_checklists_line = 0;
					$coun_checklists_line_check = 0;
					foreach ($checklists as $checklist) {

						if ($checklist['id_task'] == $task['id']) {
							$coun_checklists++;
							foreach ($checklists_line as $checklist_line) {
								if ($checklist_line['id_check'] == $checklist['id']) {
									$coun_checklists_line++;

									if ($checklist_line['id_check'] == $checklist['id'] && $checklist_line['status'] == '2') {
										$coun_checklists_line_check++;
									}
								}
							}
						}
					}

					if ($coun_checklists > 0) {

					?>

						<div class="item_check">
							<span class="span_clip"><i class="fal fa-check-square"></i> <?php echo $coun_checklists_line_check; ?>/<?php echo $coun_checklists_line; ?></span>
						</div>

					<?php } ?>
					<div class="item_files">

						<?php

						$coun_files = array_filter($attachments, function ($v) use ($task) {
							return isset($v['id_task'])
								&& $v['id_task'] == $task['id'];
						});

						if (count($coun_files) > 0) {
						?>
							<span class="span_clip"><i class="fal fa-paperclip"></i> <?php echo count($coun_files); ?></span>

						<?php } ?>

					</div>
				</div>

			</div>


		</div>
<?php endif;
endforeach; ?>