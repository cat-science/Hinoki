<?php echo $this->element('admin_menu');?>
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
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
<div class = "admin-interviews-edit">
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

  <?php echo $this->Form->create('Interview', $form_default); ?>

  <div class = "row row-eq-height">
    <div class = "col-md-3">
      <div class = "panel panel-default" style = "height:95%">
        <div class = "panel-heading">
          個人情報
        </div>
        <div class = "panel-body">
          <table class = "table table-borderless ">
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
                <th>生年月日</th>
                <th>yyyy/mm/dd</th>
              </tr>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class = "col-md-5">
      <div class = "panel panel-default" style = "height:95%">
        <div class = "panel-heading">
          EJU成績
        </div>
        <div class = "panel-body" >
        <?php
          echo $this->Form->input('id');
          echo $this->Form->hidden('user_id',array(
            'value' => $user_info['User']['id']
          ));
          echo $this->Form->input('eju_record',array(
            'label' => array(
              'style' => '',
              'text' => ''
            ),
            'type' => 'textarea',
            'class' => 'form-control',
            'placeholder' => '2019年第一回:数学150,物理100,..
2019年第二回:数学100,物理100,..
のように入力してください',
            'rows' => 8
          ));
        ?>
        </div>
      </div>
    </div>

    <div class = "col-md-4">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          Webテスト成績
        </div>
        <div class = "panel-body">
          <table class = "table table-borderless ">
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
          <a href="javascript:openRecord(<?php echo h($user_id); ?>);"><?php echo __('Webテスト成績一覧はこちら')?></a>
          <?php //echo $this->Html->link(__('Webテスト成績一覧はこちら'), array('action' => 'all_records',$user_id))?>
        </div>
      </div>
    </div>
  </div>


  <div class = "row row-eq-height">

    <div class = "col-md-3">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          希望進路
        </div>
        <div class = "panel-body">
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
のように入力してください'
          ));
        ?>
        </div>
      </div>
    </div>

    <div class = "col-md-5">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          英語成績
        </div>
        <div class = "panel-body">
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

    <div class = "col-md-4">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          面談練習内容
        </div>
        <div class = "panel-body">
        <?php
          echo $this->Form->input('practice_record',array(
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

  </div>

  <div class = "row">
    <div class = "col-md-3">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          希望分野
        </div>
        <div class = "panel-body">
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
    <div class = "col-md-9">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          専任講師コメント
        </div>
        <div class = "panel-body">
        <?php
          echo $this->Form->input('admin_comment',array(
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

  </div>

  <div class="form-group">
  
  	<div class="col col-md-offset-11">
  			<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
  	</div>
  </div>
	<?php echo $this->Form->end(); ?>
</div> 