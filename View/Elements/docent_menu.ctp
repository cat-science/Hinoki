<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<?php
			$is_active = (($this->name=='Lecture')&&($this->params["action"]!='admin_password')) ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('授業関連'), array('controller' => 'lectures', 'action' => 'index')).'</li>';

			$is_active = ($this->name=='Interview') ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('面談'), array('controller' => 'lectures', 'action' => 'index')).'</li>';

			?>
		</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
