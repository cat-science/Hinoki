<?php echo $this->element('admin_menu');?>

<div class="admin-groups-user-info col">
  <?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?></br>
  <div class="text-left" style="font-size : 25px;"><?php echo $group_info['Group']['title']; ?></div>
  <div class="" style="font-size : 25px; float:right">開講授業と授業担当者</div>
  <div class="text-left" style="font-size : 25px;"><?php echo __('生徒リスト'); ?></div>
  <div class="row justify-content-between">

    <table class="col-5">
	  <thead>
	  <tr>
	  	<th class="text-center"><?php echo __('ログインID'); ?></th>
	  	<th class="text-center"><?php echo __('氏名'); ?></th>
	  </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($user_list as $user): ?>
	  <tr>
	  	<td class="text-center"><?php echo $user['User']['username']; ?></td>
	  	<td class="text-center"><?php echo $user['User']['name']; ?></td>
	  </tr>
	  <?php endforeach; ?>
	  </tbody>
    </table>
    <table class="col-5">
      <thead>
        <tr>
          <th class="text-center">授業名</th>
          <th class="text-center">担当者名</th>
        </tr>
      </thead>
    <tbody>
      <?php foreach ($lecture_info as $lecture): ?>
      <?php $docent_id = $lecture['Lecture']['docent_id'];?>
	    <tr>
	    	<td class="text-center"><?php echo $lecture['Lecture']['lecture_name']; ?></td>
	    	<td class="text-center"><?php echo $all_user_list[$docent_id]; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    </table>
  </div>

</div>