<?php
  if($this->action == 'admin_practice_index'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'docent_practice_index'){
    echo $this->element('docent_menu');
  }
?>
<?php $this->start('script-embedded'); ?>
<script>

</script>
<?php $this->end(); ?>
<div class="admin-interviews-parctice-index col">
  <div class="text-left">
    <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'edit',$user_info['id']))?>  
  </div>
  <div class="text-left font-weight-bold" style="font-size : 30px;">
    生徒氏名:<?php echo $user_info['name'];?>さん 面談練習一覧
  </div>
  <div class="row">
    <div class="col-3 offset-md-9">
	  	<button type="button" class="btn btn-outline-primary btn-add"  style="float:right; margin-bottom : 10px;" onclick="location.href='<?php echo Router::url(array('action' => 'practice_edit', $user_info['id'])) ?>'">+ 追加</button>
    </div>
  </div>
  
  <div class="col-12">
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="text-center">日付</th>
            <th class="text-center">テーマ</th>
            <th class="text-center">担当者</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($practices_record as $row):?>
            <tr>
              <td class="text-center" style="font-size : 20px;"><?php echo $row['practice_date']; ?></td>
              <td class="text-center" style="font-size : 20px;"><?php echo $row['practice_theme']?></td>
              <td class="text-center" style="font-size : 20px;"><?php echo $docent_list[$row['docent_id']]?></td>
              <td class="text-center">
              <?php
				        echo $this->Form->postLink(__('削除'), array(
				        	'action' => 'practice_delete',
				        	$row['user_id'],$row['id']
				        ), array(
				        	'class' => 'btn btn-danger'
				        ), __('[%s] の面談記録を削除してもよろしいですか?', $row['practice_date']));
		          ?>
                <button type="button" class="btn btn-success" onclick="location.href='<?php echo Router::url(array('action' => 'practice_edit', $user_info['id'], $row['id'])) ?>'">編集</button>
              </td>
            </tr>
          <?php endforeach;?>
        </tbody>

      </table>
  </div>
</div>