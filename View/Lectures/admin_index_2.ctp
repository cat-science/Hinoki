<?php echo $this->element('admin_menu');?>

<div class="admin-courses-index col">
	<div class="ib-page-title"><?php echo __('授業一覧'); ?></div>
	<div class="buttons_container">
		<button type="button" class="btn btn-primary btn-add" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
	</div>

	<table id='sortable-table'>
	<thead>
	<tr>
		<th><?php echo __('授業名'); ?></th>
		<th class="ib-col-datetime"><?php echo __('担当講師'); ?></th>
    <th class="ib-col-datetime"><?php echo __('作成日時'); ?></th>
		<th class="ib-col-datetime"><?php echo __('更新日時'); ?></th>
		<th class="ib-col-action"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($lectures as $lecture): ?>
	<tr>
		<td>
			<?php 
				echo $this->Html->link($lecture['Lecture']['lecture_name'], array('controller' => 'lectures', 'action' => 'edit', $lecture['Lecture']['id']));
				echo $this->Form->hidden('id', array('id'=>'', 'class'=>'lecture_id', 'value'=>$lecture['Lecture']['id']));
			?>
		</td>
    <td class="ib-col-date"><?php echo h($docent_list[$lecture['Lecture']['docent_id']]);?>&nbsp;</td>
		<td class="ib-col-date"><?php echo h(Utils::getYMDHN($lecture['Lecture']['created'])); ?>&nbsp;</td>
		<td class="ib-col-date"><?php echo h(Utils::getYMDHN($lecture['Lecture']['modified'])); ?>&nbsp;</td>
		<td class="ib-col-action">
			<?php
			if($loginedUser['role']=='admin')
			{
				echo $this->Form->postLink(__('削除'),
					array('action' => 'delete', $lecture['Lecture']['id']),
					array('class'=>'btn btn-danger'),
					__('[%s] を削除してもよろしいですか?', $lecture['Lecture']['lecture_name'])
				);
			}?>
			<button type="button" class="btn btn-success" onclick="location.href='<?php echo Router::url(array('action' => 'edit', $lecture['Lecture']['id'])) ?>'">編集</button>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>