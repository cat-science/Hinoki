<?php echo $this->element('docent_menu');?>
<div class="docent-lecture-edit col">
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
					'style' => '',
        ));
				?>
				<table>
				<thead>
				<tr>
					<th nowrap class="ib-col-datetime"><?php echo __('名前'); ?></th>
					<th nowrap class="ib-col-datetime"><?php echo __('出席状況'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $id => $user): ?>
				<tr>
				<td class="ib-col-datetime"><?php echo h($user); ?>&nbsp;</td>
					<td class="ib-col-datetime">
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
					'style' => '',
        ));
        echo $this->Form->input('comment',		array(
					'label' => __('特記事項'),
					'type' => 'textarea',
    			'class' => '',
					'style' => '',
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