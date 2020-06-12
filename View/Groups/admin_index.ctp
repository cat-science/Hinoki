<?php echo $this->element('admin_menu');?>
<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('キャンパス一覧'); ?></div>
	<div class="row mb-3">
    <div class="col-4 offset-9 col-md-2 offset-md-10">
	  	<button type="button" class="btn btn-outline-primary" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
    </div>
  </div>

	<table class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th nowrap><?php echo $this->Paginator->sort('title', 'キャンパス名'); ?></th>
		<th nowrap><?php echo __('受験できるWebテスト'); ?></th>
		<th nowrap ><?php echo __('開講授業'); ?></th>
		<th ><?php echo $this->Paginator->sort('modified', '更新日時'); ?></th>
		<th ><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($groups as $group): ?>
	<tr>
		<td><?php echo $this->Html->link(h($group['Group']['title']), array('action' => 'user_info',$group['Group'][id])); ?></td>
		<td><div class="reader" title="<?php echo h($group['GroupCourse']['course_title']); ?>"><p><?php echo h($group['GroupCourse']['course_title']); ?>&nbsp;</p></div></td>
		<td><div class="reader" title="<?php echo h($group['GroupLecture']['lecture_NAME']); ?>"><p><?php echo h($group['GroupLecture']['lecture_name']); ?>&nbsp;</p></div></td>
		<td><?php echo h(Utils::getYMDHN($group['Group']['modified'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Form->postLink(__('削除'), 
					array('action' => 'delete', $group['Group']['id']), 
					array('class'=>'btn btn-outline-danger'), 
					__('[%s] を削除してもよろしいですか?', $group['Group']['title'])
			); ?>
			<button type="button" class="btn btn-outline-success" onclick="location.href='<?php echo Router::url(array('action' => 'edit', $group['Group']['id'])) ?>'">編集</button>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>
