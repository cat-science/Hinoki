<div class="col-11 mx-auto bg-light mb-5">
	<div class="breadcrumb">
	<?php
	$this->Html->addCrumb('HOME', array(
			'controller' => 'users_courses',
			'action' => 'index'
	));

	$this->Html->addCrumb('お知らせ一覧', array(
		'controller' => 'infos',
		'action' => 'index'
	));

	echo $this->Html->getCrumbs(' / ');
	
	$title = h($info['Info']['title']);
	$date  = h(Utils::getYMD($info['Info']['created']));
	$body  = $info['Info']['body'];
	$body  = $this->Text->autoLinkUrls($body);
	$body  = nl2br($body);
	?>
	</div>

	<div class="card bg-light">
		<div class="card-header"><?php echo $title; ?></div>
		<div class="card-body">
			<div class="text-right"><?php echo $date; ?></div>
			<?php echo $body; ?>
		</div>
	</div>
</div>
