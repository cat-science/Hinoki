<?php echo $this->element('admin_menu');?>
<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('お知らせ一覧'); ?></div>
	<div class="row mb-3">
    <div class="col-4 offset-8 col-md-2 offset-md-10">
			<button type="button" class="btn btn-outline-primary btn-add" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th ><?php echo $this->Paginator->sort('title',   __('タイトル')); ?></th>
		<th nowrap><?php echo __('対象キャンパス'); ?></th>
		<th nowrap><?php echo __('対象授業'); ?></th>
		<th class="ib-col-date"><?php echo $this->Paginator->sort('modified', '更新日時'); ?></th>
		<th class="ib-col-action"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($infos as $info): ?>
	<tr>
		<td ><?php echo h($info['Info']['title']); ?>&nbsp;</td>
		<td><div class="reader col-group" title="<?php echo h($info['InfoGroup']['group_title']); ?>"><p><?php echo h($info['InfoGroup']['group_title']); ?>&nbsp;</p></td>
		<td><div class="reader col-group" title="<?php echo h($info['InfoLecture']['lecture_title']); ?>"><p><?php echo h($info['InfoLecture']['lecture_title']); ?>&nbsp;</p></td>
		<td class="ib-col-date"><?php echo Utils::getYMDHN($info['Info']['modified']); ?>&nbsp;</td>
		<td class="ib-col-action">
			<?php echo $this->Form->postLink(__('削除'), 
					array('action' => 'delete', $info['Info']['id']), 
					array('class'=>'btn btn-outline-danger'), 
					__('[%s] を削除してもよろしいですか?', $info['Info']['title'])
			); ?>
			<button type="button" class="btn btn-outline-success" onclick="location.href='<?php echo Router::url(array('action' => 'edit', $info['Info']['id'])) ?>'">編集</button>	
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>