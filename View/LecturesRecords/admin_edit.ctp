<?php echo $this->element('admin_menu');?>
<div class="col-11 mx-auto bg-light mb-5">
<?php echo $this->Html->link(__('<< 戻る'), array('controller' => 'lectures', 'action' => 'index'))?>
	<div class="card bg-light">
		<div class="card-header">
			<?php echo ($this->action == 'admin_edit') ? __($lecture_name."ー授業記録") :  __($lecture_name."ー授業記録"); ?>
		</div>
		<div class="card-body">
			<?php echo $this->Form->create('LecturesRecord', Configure::read('form_defaults_bs4')); ?>
			<?php
				echo $this->Form->hidden('id');
				echo $this->Form->input('docent_id',	array(
					'label' => __('担当講師'),
					'options'=> $docent_list, 
					'selected'=> $docent_list[$docent_id], 
					'empty' => '', 
					'required'=>false, 
					'class'=>'form-control'
        ));
        echo $this->Form->input('text',		array(
					'label' => __('単元名とテキスト該当ページ'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width:100%',
        ));
				?>
				<!-- <table style = "width : 74%; float : right; margin-left:26%;"> -->
				<table class="table table-striped table-responsive-sm">
				<thead>
				<tr>
					<th nowrap><?php echo __('名前'); ?></th>
					<th nowrap class="text-center"><?php echo __('出席状況'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $id => $user): ?>
				<tr>
				<td class=""><?php echo h($user); ?>&nbsp;</td>
					<td class="">
						<?php
							echo $this->Form->input("$id-attendance",	array(
								'type' => 'radio',
								'before' => '',
								'separator'=>"  ",
								'legend' => false,
								'div' => '',
								'class' => '',
								'style' => '',
								'required'=> 'required',
								'options' => Configure::read('attendance'),
								'label' => array(
									'style' => 'margin-left:25%'
								)
							));
							echo "</div>";
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
				</table>
				</br>
				<?php 
        echo $this->Form->input('homework',		array(
					'label' => __('宿題'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width:100%',
        ));
        echo $this->Form->input('comment',		array(
					'label' => __('特記事項'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width:100%',
				));
        
        
			?>
			<div class="form-group">
				<div class="col col-sm-9 col-sm-offset-3">
					<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>