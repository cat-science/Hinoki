<?php echo $this->element('admin_menu');?>
<div class="admin-qas-edit col">
  <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>

  <div class="card bg-ligt">
    <div class="card-header">
      <?php echo __("Q & A編集");?>
    </div>
    <div class="card-body">
      <?php
        echo $this->Form->create('Qa');
        echo $this->Form->input('id');

        echo $this->Form->input('title',array(
          'type' => 'text',
          'id' => 'qaTitle',
          'label' => array(
            'for' => 'qaTitle',
            'text' => 'タイトル',
            'class' => 'h2'
          ),
          'class' => 'from-control',
          'div' => 'form-group'
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
          'div' => 'form-group'
        ));    

        // ステータス
				echo $this->Form->input('is_public',	array(
					'type' => 'radio',
					'before' => '<label class=" h2">ステータス</label>',
					'after' => '<div class="col col-sm-3"></div><span class="status-exp">　非公開と設定した場合、管理者権限でログインした場合のみQ & A一覧に表示されます。</span>',
					'separator' => '　', 
					'legend' => false,
					'class' => false,
					'default' => 1,
					'options' => Configure::read('content_status')
					)
				);
      ?>
    </div>
    <div class="form-group">
      <div class="col-12">
        <input type="submit" class="btn btn-outline-primary btn-lg" value="保存">
      </div>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>