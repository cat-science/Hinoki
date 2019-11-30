<?php echo $this->element('docent_menu');?>
<div class="admin-courses-edit">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'docent_index'))?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo ($this->action == 'admin_edit') ? __('授業記録') :  __('授業記録'); ?>
		</div>
		<div class="panel-body">
			<?php echo $this->Form->create('Lecture', Configure::read('form_defaults')); ?>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('lecture_name',	array('label' => __('授業名')));
				/*
				echo $this->Form->input('opened',	array(
					'type' => 'datetime',
					'dateFormat' => 'YMD',
					'monthNames' => false,
					'timeFormat' => '24',
					'separator' => ' - ',
					'label'=> '公開日時',
					'style' => 'width:initial; display: inline;'
				));
				*/
				echo $this->Form->input('docent_id',	array(
					'label' => __('担当講師'),
					'options'=> $docent_list, 
					'selected'=> $docent_list[$docent_id], 
					'empty' => '', 
					'required'=>false, 
					'class'=>'form-control'
        ));
        echo $this->Form->input('text_info',		array(
					'label' => __('単元名とテキスト該当ページ'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width : 200px',
        ));
        //ここはダミー
        echo $this->Form->input('attendance',		array(
					'label' => __('出欠席'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width : 200px',
        ));
        //
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
        
				echo $this->Form->input('lecture_date',array(
					'label' => __('授業日'),
    			'type' => 'textarea',
    			'class' => '',
					'style' => '',
					'placeholder' => '2019/11/01
2019/11/02
のように入力してください',
    			'value' => $enquete_inputted['Enquete']['before_false_reason']
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