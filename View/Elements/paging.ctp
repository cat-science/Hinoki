<div class="text-center">
<?php
echo $this->Paginator->counter(array(
	'format' => __('合計 : {:count}件　{:page} / {:pages}ページ')
));
?>
</div>

<div class="col">
	<nav aria-label="Page navigation">
		<ul class="pagination justify-content-center">
			<?php
				$this->Paginator->options(array('class' => 'page-link'));
				echo $this->Paginator->prev('<',array('tag' => 'li class="page-item"'));
				echo $this->Paginator->numbers(array('currentTag' => 'a class="page-link"'));
				echo $this->Paginator->next('>',array('tag' => 'li class="page-item"'));
			?>
		</ul>
	</nav>
</div>

