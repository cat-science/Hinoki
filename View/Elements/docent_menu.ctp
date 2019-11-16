<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<?php
			$is_active = (($this->name=='Lecture')&&($this->params["action"]!='admin_password')) ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('授業関連'), array('controller' => 'lectures', 'action' => 'index')).'</li>';

			$is_active = ($this->name=='Groups') ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('グループ'), array('controller' => 'groups', 'action' => 'index')).'</li>';


			if($loginedUser['role']=='admin')
			{
				$is_active = ($this->name=='Settings') ? ' active' : '';
				echo '<li class="'.$is_active.'">'.$this->Html->link(__('システム設定'), array('controller' => 'settings', 'action' => 'index')).'</li>';
			}
			?>
		</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
