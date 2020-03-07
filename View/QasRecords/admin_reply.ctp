<?php
  if($this->action == 'admin_reply'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'reply'){
    echo $this->element('menu');
  }
?>
<div class="admin-reply col">
  <?php echo $this->Html->link(__('<< 戻る'), array('controller' => 'qas','action' => 'index'))?>
  <div class="card bg-light">
    <div class="card-body">
      <div class="row">
        <div class="col-8">
          <span class="h3">タイトル</span>
        </div>
        <div class="col-4">
          <?php
            //管理者からアクセスの場合
            $q_user_id = $qa_info['Qa']['user_id'];
            if($this->action == 'admin_reply'){
              $name = $user_list[$q_user_id];
              if($qa_info['Qa']['is_anonymous'] == 1){
                $name = $name.'(匿名)';
              }
            }else{
              //生徒からアクセスの場合

              //本人の場合
              if($user_id == $q_user_id){
                $name = $user_list[$q_user_id];
                if($qa_info['Qa']['is_anonymous'] == 1){
                  $name = $name.'(匿名)';
                }
              }else{
                if($qa_info['Qa']['is_anonymous'] == 1){
                  $name = '(匿名)';
                }else{
                  $name = $user_list[$q_user_id];
                }
              }
            }
          ?>
          <span class="h4">投稿者:<?php echo $name;?></span>
        </div>
      </div>
      <p class="border border-dark h5 mb-4 mt-4"><?php echo $qa_info['Qa']['title'];?></p>
      <p class="h3">本文</p>
      <p class="border border-dark h5 mb-4 mt-4"><?php echo $qa_info['Qa']['body'];?></p>
      <p class="h3">返信履歴</p>
      <div class="reply-records mb-5">
        <?php foreach($reply_records as $record): ?>
        <?php
          $res_user_id = $record['QasRecord']['res_user_id'];
          $body = $record['QasRecord']['body']; 
          if($qa_info['Qa']['is_anonymous'] == 1 && $res_user_id == $qa_info['Qa']['user_id']){
            if($role == 'admin' || $user_id == $qa_info['Qa']['user_id']){
              $display_name = $user_list[$res_user_id]."(匿名)";
            }else{
              $display_name = "(匿名)";
            }
          }else{
            $display_name = $user_list[$res_user_id];
          }
        ?>
          <div class="row">
            <div class="col-2">
              <p class="h4"><?php echo $display_name;?></p>
            </div>
            <div class="col-8">
              <pre class="h5"><?php echo $body;?></pre>
            </div>
          </div>

        <?php endforeach;?>
      </div>
      <?php if($role == 'admin' || $user_id == $qa_info['Qa']['user_id']){?>
      <div class="reply-form" id="reply-form">
        <?php
          echo $this->Form->create('QasRecord');
          echo $this->Form->input('id');
          echo $this->Form->hidden('res_user_id', array('value' => $user_id));
          echo $this->Form->hidden('qa_id', array('value' => $qa_id));
          echo $this->Form->input('body',array(
            'label' => '返信内容'
          ));
        ?>
        <div class="form-group">
					<?php echo $this->Form->submit('保存', array('div' => false, 'class' => 'btn btn-outline-primary')); ?>
			  </div>
			  <?php echo $this->Form->end(); ?>
      </div>
      <?php }?>

    </div>
  </div>
</div>