<?php echo $this->element('menu');?>

<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('コメント・質問の投稿'); ?></div>

  <?php
    echo $this->Form->create('Qa');
    echo $this->Form->hidden('id');
    echo $this->Form->hidden('user_id',array('value' => $user_id));

    echo $this->Form->input('title',array(
      'type' => 'text',
      'id' => 'qaTitle',
      'label' => array(
        'for' => 'qaTitle',
        'text' => 'タイトル',
        'class' => 'h2'
      ),
      'class' => 'from-control',
      'div' => 'form-group',
      'style' => 'width: 100%',
    ));

    echo $this->Form->input('body',array(
      'type' => 'textarea',
      'id' => 'qaBody',
      'label' => array(
        'for' => 'qaBody',
        'text' => '本文',
        'class' => 'h2'
      ),
      'class' => 'from-control',
      'div' => 'form-group',
      'style' => 'width: 100%',
    ));    

    // echo $this->Form->input('is_anonymous',array(
    //   'type' => 'checkbox',
    //   'id' => 'qaIsAnonymous',
    //   'label' => array(
    //     'for' => 'qaIsAnonymous',
    //     'class' => 'form-check-label',
    //     'text' => '匿名で投稿する'
    //   ),
    //   'class' => 'form-check-input',
    //   'div' => 'form-check form-check-inline form-control-lg',
    // ));
  ?>

  <div class="from-check form-check-inline form-control-lg">  
    <input type="checkbox" name="data[Qa][is_anonymous]" id="qaIsAnonymous" class="form-check-input" value="1">
    <label class="form-check-label" for="qaIsAnonymous">匿名で投稿する</label>
  </div>

  <div class="form-group row">
    <div class="col-10">
      <input type="submit" class="btn btn-outline-primary btn-lg" value="投稿">
    </div>
  </div>
</div>