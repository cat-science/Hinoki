<?php echo $this->element('docent_menu');?>
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

</style>
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
<div class = "admin-interviews-edit">
<div class="ib-page-title" style = "width : 100%;"><?php echo __('面談情報編集'); ?></div>
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

  <div class = "row">

    <div class = "col-md-3">
      <div class = "panel panel-default">
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
      <div class = "panel panel-default">
        <div class = "panel-heading">
          EJU成績
        </div>
        <div class = "panel-body">
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
のように入力してください'
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
        <?php
				  echo __('ここに，直近の５件成績を表示，ただし，個人の履歴（全部）もアクセスできるようにする.')
        ?>
        </div>
      </div>
    </div>
  </div>


  <div class = "row">

    <div class = "col-md-3">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          希望進路
        </div>
        <div class = "panel-body">
        <?php
          echo $this->request->data['Interview']['eju_record'];
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
  	<div class="col col-sm-9 col-sm-offset-11">
  			<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
  		</div>
  	</div>
	<?php echo $this->Form->end(); ?>
</div> 