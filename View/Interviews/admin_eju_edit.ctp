<?php
  if($this->action == 'admin_eju_edit'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'docent_eju_edit'){
    echo $this->element('docent_menu');
  }
?>
<?php $this->start('script-embedded'); ?>
<script>
	function updateRecord()
	{
    $("#EjusRecordCmd").val("update");
    <?php
      if($this->action == 'admin_eju_edit'){
        $formName = "#EjusRecordAdminEjuEditForm";
      }elseif($this->action == 'docent_eju_edit'){
        $formName = "#EjusRecordDocentEjuEditForm";
      }
    ?>
    var formName = "<?php echo $formName;?>";
    
		$(formName).submit();
		$("#EjusRecordCmd").val("");
	}
</script>
<?php $this->end(); ?>
<div class="col-11 mx-auto mb-5 bg-light">
  <div class="text-left">
    <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'edit',$user_id))?>  
  </div>
  <div class="text-left font-weight-bold h2">
    生徒氏名:<?php echo $user_name;?>さん EJU成績入力
  </div>
  <div class="text-left">
    *注意:西暦と回数を選択した時，ページは更新され，その年のその回数の成績が表示されます．
  </div>
  <div class="card bg-light">
    <div class="card-body">
      <?php 
        echo $this->Form->create('EjusRecord',['type' => 'get']);
        echo $this->Form->input('id');
        echo $this->Form->hidden('user_id',array(
          'value' => $user_id
        ));
      ?>
      <div class="form-group row">
        <label class="col-2 col-md-3 col-form-label d-flex align-items-center justify-content-end" style="font-size : 2vw; padding-right: 0px; padding-left:0px;">西暦</label>
        <?php
          echo $this->Form->input('year',array(
            'label' => false,
            'class' => 'form-control',
            'div' => 'col-8 col-md-2',
            'type' => 'date',
            'dateFormat' => 'Y',
            'minYear' => date('Y') - 3,
            'maxYear' => date('Y') + 3,
            'value' => $arr_year,
            'onchange' => 'submit(this.form)'
          ));
        ?>
        <label class="col-2 col-md-1 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw; padding-right: 0px; padding-left:0px;">年</label>
        <label class="col-2 col-md-1 col-form-label d-flex align-items-center justify-content-end" style="font-size : 2vw; padding-right: 0px; padding-left:0px;">第</label>
        <?php
          echo $this->Form->input('number_of_times',array(
            'label' => false,
            'class' => 'form-control',
            'div' => 'col-8 col-md-2',
            'options' => array(
              '1' => '1',
              '2' => '2'
            ),
            'value' => $number_of_times,
            'onchange' => 'submit(this.form)'
          ));
        ?>
        <label class="col-2 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw; padding-right: 0px; padding-left:0px;">回</label>
      </div>


      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">日本語ー読解</label>
        <?php echo $this->Form->input('ja_reading',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">日本語ー聴解・聴読解</label>
        <?php echo $this->Form->input('ja_listening',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">日本語ー記述</label>
        <?php echo $this->Form->input('ja_writing',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">理科ー物理</label>
        <?php echo $this->Form->input('sc_physics',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">理科ー化学</label>
        <?php echo $this->Form->input('sc_chemistry',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">理科ー生物</label>
        <?php echo $this->Form->input('sc_biology',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">総合科目</label>
        <?php echo $this->Form->input('sougou',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">数学ーコース１</label>
        <?php echo $this->Form->input('ma_course1',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <div class="form-group row">
        <label class="col-4 col-form-label d-flex align-items-center justify-content-start" style="font-size : 2vw;">数学ーコース２</label>
        <?php echo $this->Form->input('ma_course2',array(
          'label' => false,
          'class' => 'form-control',
          'div' => 'col-8'
        ))?>
      </div>

      <?php echo $this->Form->hidden('cmd')?>
      <button type = "button" class="btn btn-outline-primary" onclick="updateRecord()">提出</button>
      <?php echo $this->Form->end();?>
    
    </div>
  </div>
</div>