<?php echo $this->element('menu');?>

<div class="qas-index" style="width : 100%">
  <div class="row">
    <div class="col-8">
      <p class="h1">Q & A一覧</p>
    </div>
    <div class="col-2">
	    <div class="buttons_container">
        <button type="button" class="btn btn-primary btn-lg" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">投稿</button>
      </div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>タイトル</th>
        <th>投稿日</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>タイトル４</td>
        <td>2020-03-06</td>
      </tr>
    </tbody>
  </div>
  
</table>