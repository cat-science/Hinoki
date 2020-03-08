<?php $this->start('menu'); ?>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
	<?php $is_active = (($this->name=='Users')&&($this->params["action"]!='admin_password')) ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('ユーザ'), array('controller' => 'users', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>
	<?php $is_active = ($this->name=='Interviews') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('面談'), array('controller' => 'interviews', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>
	<?php $is_active = ($this->name=='Groups') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('キャンパス'), array('controller' => 'groups', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>
	
	<?php $is_active = (($this->name=='Courses')||($this->name=='Contents')||($this->name=='ContentsQuestions')) ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('Webテスト'), array('controller' => 'courses', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = (($this->name=='Qas')||($this->name=='QasRecords')) ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('Q & A'), array('controller' => 'qas', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = ($this->name=='Records') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('学習履歴'), array('controller' => 'records', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = ($this->name=='Lectures') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('授業編集'), array('controller' => 'lectures', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = ($this->name=='Logs') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('ログイン履歴'), array('controller' => 'logs', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = ($this->name=='Infos') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('お知らせ'), array('controller' => 'infos', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>
	
	<?php 
		if($loginedUser['role']=='admin')
		{
			$is_active = ($this->name=='Settings') ? ' active' : '';
			echo '<li class="nav-item '.$is_active.'">'.$this->Html->link(__('システム設定'), array('controller' => 'settings', 'action' => 'index'),array('class' => 'nav-link')).'</li>';
		}
	?>
</div>

<?php echo $this->end();?>
