<?php $this->start('menu'); ?>

	<ul class="navbar-nav mr-auto">
	<?php $is_active = ($this->name=='Lectures') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('授業関連'), array('controller' => 'lectures', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>

	<?php $is_active = ($this->name=='Interviews') ? ' active' : '';?>
	<li class="nav-item <?php echo $is_active;?>">
		<?php
			echo $this->Html->link(__('面談'), array('controller' => 'interviews', 'action' => 'index'),array('class' => 'nav-link'));
		?>
	</li>


<?php echo $this->end(); ?>