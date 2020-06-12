<div class="col-11 mx-auto bg-light mb-5">
	<div class="breadcrumb">
	<?php
	$controller_name = $this->action == 'docent_index' ? 'lectures' : 'users_courses';
	$this->Html->addCrumb('HOME', array(
		'controller' => $controller_name,
		'action' => 'index'
	));
	echo $this->Html->getCrumbs(' / ');
	?>
	</div>
	<div class="card bg-light">
		<div class="card-header"><?php echo __('お知らせ一覧'); ?></div>
		<div class="card-body">
			<table cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('opend',   __('日付')); ?></th>
				<th><?php echo $this->Paginator->sort('title',   __('タイトル')); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($infos as $info): ?>
			<tr>
				<td width="120" valign="top"><?php echo h(Utils::getYMD($info['Info']['created'])); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($info['Info']['title'], array('action' => 'view', $info['Info']['id'])); ?>&nbsp;</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			<?php echo $this->element('paging');?>
		</div>
	</div>
</div>