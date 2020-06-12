<?php
  if($this->action == 'admin_practice_edit'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'docent_practice_edit'){
    echo $this->element('docent_menu');
  }
?>
<?php $this->start('script-embedded'); ?>
<script>
	
</script>
<?php $this->end(); ?>
<div class="col-11 mx-auto bg-light">
  <div class="text-left">
    <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'practice_index',$user_info['id']))?>  
  </div>
  <div class="h2">
    生徒氏名:<?php echo $user_info['name'];?>さん 面談練習ー編集
  </div>
  <div class="card bg-light">
    <div class="card-body">
      <?php
        echo $this->Form->create('PracticesRecord');
        echo $this->Form->input('id');
        echo $this->Form->hidden('user_id',array(
          'value' => $user_info['id']
        ));
      ?>
      <div class="form-group row">
        <label class="col-4 col-md-2 col-form-label d-flex align-items-center justify-content-end mb-3">面談日：</label>
        <?php
          // echo $this->Form->input('practice_date', array(
          //   'type' => 'date',
          //   'div' => 'form-inline col-10 col-md-4',
          //   'dateFormat' => 'YMD',
          //   'monthNames' => false,
          //   'timeFormat' => '24',
          //   'minYear' => date('Y') - 5,
          //   'maxYear' => date('Y'),
          //   'separator' => ' / ',
          //   'label'=> false,
          //   'class'=>'form-control',
          //   'value' => $practice_date
          // ));
        ?>
        <input class="col-8 col-md-2 mb-3 form-control" type="date" name="data[PracticesRecord][practice_date]" value=<?php echo $practice_date;?>>
        <label class="col-4 col-md-2 col-form-label d-flex align-items-center justify-content-end mb-3">担当者：</label>
        <?php
          echo $this->Form->input('docent_id', array(
            'div' => 'form-inline col-8 col-md-2 mb-3',
            'class'=>'form-control',
            'label' => false,
            'options' => $docent_list,
            'selected' => $docent_id,
            'empty' => ''
          ));
        ?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-md-2 col-form-label d-flex align-items-center justify-content-center">テーマ</label>
        <?php echo $this->Form->input('practice_theme',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8',
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-12 col-md-2 col-form-label d-flex align-items-center justify-content-center">練習内容</label>
        <?php echo $this->Form->input('practice_body',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-12 col-md-8',
          'rows' => 20
        ))?>
      </div>
      <?php
        echo $this->Form->button('提出',array(
          'type' => 'submit',
          'class' => 'btn btn-outline-primary'
        ));
      ?>

      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>