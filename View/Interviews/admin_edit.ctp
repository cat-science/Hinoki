<?php
  if($this->action == 'admin_edit'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'docent_edit'){
    echo $this->element('docent_menu');
  }
?>
<?php $this->start('script-embedded'); ?>
<script>
	
  function openRecord(user_id)
	{
		window.open(
			'<?php echo Router::url(array('controller' => 'interviews', 'action' => 'all_records')) ?>/'+user_id,
			'user_all_records',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}

	function openTestRecord(content_id, record_id)
	{
		window.open(
			'<?php echo Router::url(array('controller' => 'contents_questions', 'action' => 'record')) ?>/'+content_id+'/'+record_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}

</script>
<?php $this->end(); ?>
<style>
.student-info-block{
  
}

.table-borderless th,
.table-borderless td,
.table-borderless thead th,
.table-borderless tbody + tbody {
  border: 0;
}

.tbody th{
  align : center;
}

.row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  .panel {
    height: 100%;
  }

}

</style>
<div class = "admin-interviews-edit col">
<div class="text-left">
  <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
</div>
<div class="ib-page-title" style = "width : 50%;"><?php echo __('面談情報編集'); ?></div>
  <?php
    $form_default = array(
      'inputDefaults' => array(
        'div' => 'form-group',
        'label' => array(
          'class' => ''
        ),
        'wrapInput' => 'col col-md-12',
        'class' => 'form-control'
      ),
      'class' => 'form-horizontal'
    );
  ?>

  <?php echo $this->Form->create('Interview',Configure::read('form_defaults_bs4')); ?>


  <div class="row row-eq-height">
    <div class="col-6">
      <div class="card bg-light">
        <div class="card-header">
          個人情報
        </div>
        <div class = "card-body">
          <table class = "table table-borderless table-striped ">
            <tbody>
              <tr>
                <th >氏名</th>
                <th ><?php echo $user_info['User']['name'];?></th>
              </tr>
              <tr>
                <th>学籍番号</th>
                <th><?php echo $user_info['User']['username'];?></th>
              </tr>
              <tr>
                <th>キャンパス</th>
                <th><?php echo $user_info[0]['group_title'];?></th>
              </tr>
              <tr>
                <th>履修科目</th>
                <th><?php echo $user_info[0]['lecture_title'];?></th>
              </tr>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class = "card bg-light" style = "height:100%">
        <div class = "card-header">
          EJU成績
          <p style="float:right; margin:0px;"><?php echo $this->Html->link(__('成績入力はこちら'), array('action' => 'eju_edit',$user_id))?></p>
          
        </div>
        <div class = "card-body">
        <?php
          echo $this->Form->input('id');
          echo $this->Form->hidden('user_id',array(
            'value' => $user_info['User']['id']
          ));
          echo $ejus_output;
        ?>
        </div>
      </div>
    </div>

    
  </div>

  </br>
  <div class="row row-eq-height">
    <div class = "col-6">
      <div class = "card bg-light">
        <div class = "card-header">
          Webテスト成績
          <p style="float:right; margin:0px;"><a href="javascript:openRecord(<?php echo h($user_id); ?>);"><?php echo __('Webテスト成績一覧はこちら')?></a></p>
          
        </div>
        <div class = "card-body">
          <table class = "table table-borderless table-striped">
            <tbody>
              <tr>
                <th>Webテスト</th>
                <th>コンテンツ名</th>
                <th>得点</th>
                <th>満点</th>
              </tr>
              <?php foreach($records as $record):?>
                <tr>
                  <th><?php echo $record['Course']['title'];?></th>
                  <th><?php echo $record['Content']['title'];?></th>
                  <th><a href="javascript:openTestRecord(<?php echo h($record['Content']['id']); ?>, <?php echo h($record['Record']['id']); ?>);"><?php echo $record['Record']['score'];?></a></th>
                  <th><?php echo $record['Record']['full_score'];?></th>
                </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class = "col-6">
      <div class = "card bg-light" style = "height : 100%;">
        <div class = "card-header">
          希望進路
        </div>
        <div class = "card-body">
        <?php
          echo $this->Form->input('future_path',array(
            'label' => array(
              'style' => '',
              'text' => ''
            ),
            'type' => 'textarea',
            'class' => 'form-control',
            'placeholder' => 'xx大学
YY大学
のように入力してください',
            'rows' => 9
          ));
        ?>
        </div>
      </div>
    </div>

  </div>
  </br>
  <div class = "row row-eq-height">
    <div class="col-6">
      <div class="card bg-light">
        <div class="card-header">
          英語成績
        </div>
        <div class="card-body">
        <?php
          echo $this->Form->input('english_record',array(
            'label' => array(
              'style' => '',
              'text' => ''
            ),
            'type' => 'textarea',
            'class' => 'form-control',
            'placeholder' => 'TOEIC:XX点
TOEFL:YY点
のように入力してください'
          ));
        ?>
        </div>
      </div>
    </div>

    <div class = "col-6">
      <div class = "card bg-light">
        <div class = "card-header">
          面談練習内容
          <p style="float:right; margin:0px;"><?php echo $this->Html->link(__('面談練習入力&編集はこちら'), array('action' => 'practice_index',$user_id))?></p>

        </div>
        <div class = "card-body">
          <table class = "table table-borderless table-striped">
            <tbody>
              <tr>
                <th>日付</th>
                <th>テーマ</th>
                <th>担当者</th>
              </tr>
              <?php foreach($practices_record as $row):?>
                <tr>
                  <th><?php echo $this->Html->link( $row['practice_date'], array('action' => 'practice_edit',$user_info['User']['id'],$row['id']))?></th>
                  <th><?php echo $row['practice_theme']?></th>
                  <th><?php echo $docent_list[$row['docent_id']]?></th>
                </tr>
              <?php endforeach;?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

  </br>
  <div class="row">
    <div class="col-3">
      <div class="card bg-light">
        <div class="card-header">
          希望分野
        </div>
        <div class="card-body">
          <?php
            echo $this->Form->input('future_field',array(
              'label' => array(
                'style' => '',
                'text' => ''
              ),
              'type' => 'textarea',
              'class' => 'form-control',
              'placeholder' => ''
            ));
          ?>
        </div>
      </div>
    </div>

    <div class="col-9">
      <div class="card bg-light">
        <div class="card-header">
          専任講師コメント
        </div>
        <div class="card-body">
          <?php
            echo $this->Form->input('admin_comment',array(
              'label' => array(
                'style' => '',
                'text' => ''
              ),
              'type' => 'textarea',
              'class' => 'form-control',
              'placeholder' => '',
              'disabled' => $this->action == 'admin_edit' ? false : true
            ));
          ?>
        </div>
      </div>
    </div>

  </div>

  </br>
  <div class="form-group">
  	<div class="col-offset-12">
  			<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
  	</div>
  </div>
	<?php echo $this->Form->end(); ?>
</div> 