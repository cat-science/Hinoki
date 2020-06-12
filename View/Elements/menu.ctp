<?php $this->start('menu'); ?>

	<ul class="navbar-nav mr-auto">
		<?php $is_active = ($this->name=='UsersCourses') ? ' active' : '';?>
		<li class="nav-item <?php echo $is_active;?>">
			<?php
				echo $this->Html->link(__('ダッシュボード'), array('controller' => 'users_courses', 'action' => 'index'),array('class' => 'nav-link'));
			?>
		</li>
		<?php $is_active = ($this->name=='Qas') ? ' active' : '';?>
		<li class="nav-item <?php echo $is_active;?>">
			<?php
				echo $this->Html->link(__('Q & A'), array('controller' => 'qas', 'action' => 'index'),array('class' => 'nav-link'));
			?>
		</li>
	</ul>

<?php echo $this->end();?>
