<?php echo $this->element('menu');?>

<div class="col-11 mx-auto bg-light mb-5">
  <div class="h2"><?php echo __('Q & A一覧'); ?></div>
	<div class="row mb-3">
    <div class="col-4 offset-8 col-md-1 offset-md-11">
	  	<button type="button" class="btn btn-outline-primary" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">投稿</button>
    </div>
  </div>

  <table class="table table-striped table-responsive-sm">
    <thead>
      <tr>
        <th nowrap>タイトル</th>
        <th class="ib-col-date">投稿日</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($qa_list as $qa):?>
      <?php
        $title = $qa['Qa']['title'];  
      ?>
        <tr>
		      <td><?php echo $this->Html->link($title, array('controller' => 'qasRecords','action' => 'reply', $qa['Qa']['id']))?>&nbsp;</td>
		      <td class="ib-col-date"><?php echo Utils::getYMDHN($qa['Qa']['created']); ?>&nbsp;</td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </div>
  
</table>