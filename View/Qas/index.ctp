<?php echo $this->element('menu');?>

<div class="qas-index" style="width : 100%">
  <div class="row">
    <div class="col-8">
      <p class="h1">Q & A一覧</p>
    </div>
    <div class="col-2">
	    <div class="buttons_container">
        <button type="button" class="btn btn-primary btn-lg" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">投稿</button>
      </div>
    </div>
  </div>

  <table>
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
		      <td><?php echo $this->Html->link($title, array('controller' => 'qasrecords','action' => 'reply', $qa['Qa']['id']))?>&nbsp;</td>
		      <td class="ib-col-date"><?php echo Utils::getYMDHN($qa['Qa']['created']); ?>&nbsp;</td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </div>
  
</table>