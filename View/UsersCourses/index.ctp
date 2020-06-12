<?php echo $this->element('menu');?>
<style>
	.today{
		background: orange;
	}
</style>

<div class="col-11 mx-auto bg-light mb-5">
	</br>
	<div class="card bg-light">
		<div class="card-header"><?php echo __('お知らせ'); ?></div>
		<div class="card-body">
			<?php if($info!=""){?>
			<div class="well">
				<?php
				$info = $this->Text->autoLinkUrls($info, array( 'target' => '_blank'));
				$info = nl2br($info);
				echo $info;
				?>
			</div>
			<?php }?>
			
			<?php if(count($infos) > 0){?>
			<table cellpadding="0" cellspacing="0">
			<tbody>
			<?php foreach ($infos as $info): ?>
			<tr>
				<td width="120" valign="top"><?php echo h(Utils::getYMD($info['Info']['created'])); ?></td>
				<td><?php echo $this->Html->link($info['Info']['title'], 
					array(
						'controller' => 'infos', 
						'action' => 'view', 
						$info['Info']['id']
					)
					); ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			<div class="text-right"><?php echo $this->Html->link(__('一覧を表示'), array('controller' => 'infos', 'action' => 'index')); ?></div>
			<?php }?>
			<?php echo $no_info;?>
		</div>
	</div>
	</br>

	<?php //カレンダー ?>
	<?php
		// タイムゾーンを設定
		date_default_timezone_set('Asia/Tokyo');
		// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
		if (isset($_GET['ym'])) {
		    $ym = $_GET['ym'];
		} else {
		    // 今月の年月を表示
		    $ym = date('Y-m');
		}
		// タイムスタンプを作成し、フォーマットをチェックする
		$timestamp = strtotime($ym . '-01');
		if ($timestamp === false) {
		    $ym = date('Y-m');
		    $timestamp = strtotime($ym . '-01');
		}
		// 今日の日付 フォーマット　例）2018-07-3
		$today = date('Y-m-d');
		// カレンダーのタイトルを作成　例）2017年7月
		$html_title = date('Y年n月', $timestamp);
		// 前月・次月の年月を取得
		$prev = date('Y-m', strtotime('-1 month', $timestamp));
		$next = date('Y-m', strtotime('+1 month', $timestamp));
		// 該当月の日数を取得
		$day_count = date('t', $timestamp);
		// １日が何曜日か　0:日 1:月 2:火 ... 6:土
		$youbi = date('w', $timestamp);
		// カレンダー作成の準備
		$weeks = [];
		$week = '';
		// 第１週目：空のセルを追加
		// 例）１日が水曜日だった場合、日曜日から火曜日の３つ分の空セルを追加する
		//$this->log($date_name_list);
		$week .= str_repeat('<td></td>', $youbi);
		for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
				// 2017-07-3
				$tmp_day = $day < 10 ? '0'.$day : $day;
				$date = $ym . '-' . $tmp_day;
				// その日の授業の配列を取得
				$date_slash = str_replace("-","/",$date);
				$date_lectures = $date_name_list[$date_slash];

				/*
				$this->log($date_slash);
				$this->log($date_lectures);
				*/

		    if ($today == $date) {
					// 今日の日付の場合は、class="today"をつける
					$week .= '<td class="today" style = "width : 120px;">' . $day;
					if(isset($date_lectures)){
						foreach($date_lectures as $lecture){
							$lecture_url = '<div style = "margin : auto ;border: 1px solid #000; width : 80px; text-align: center">'. $this->Html->link($lecture, array('controller' => 'lectures', 'action' => 'index', $lecture_name_id[$lecture])) .'</div>';
							$week .= $lecture_url;
						}
					}
					
		    } else {
					$week .= '<td style = "width : 120px;" >' . $day;
					if(isset($date_lectures)){
						foreach($date_lectures as $lecture){
							$lecture_url = '<div style = "margin : auto ;border: 1px solid #000; width : 80px; text-align: center">'. $this->Html->link($lecture, array('controller' => 'lectures', 'action' => 'index',  $lecture_name_id[$lecture])) .'</div>';
							$week .= $lecture_url;
						}
					}
					
		    }
		    $week .= '</td>';
		    // 週終わり、または、月終わりの場合
		    if ($youbi % 7 == 6 || $day == $day_count) {
		      if ($day == $day_count) {
		        // 月の最終日の場合、空セルを追加
		        // 例）最終日が木曜日の場合、金・土曜日の空セルを追加
		        $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
		      }
		      // weeks配列にtrと$weekを追加する
		      $weeks[] = '<tr>' . $week . '</tr>';
		      // weekをリセット
		      $week = '';
			}
		}
		?>
	<div class="container">
		<h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
      <table class="table table-bordered table-responsive-sm">
        <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
        </tr>
        <?php
          foreach ($weeks as $week) {
            echo $week;
          }
        ?>
      </table>
  	</div>


	
	</br>
	<div class="card bg-light">
		<div class="card-header"><?php echo __('Webテスト一覧'); ?></div>
		<div class="card-body">
			<ul class="list-group">
			<?php foreach ($courses as $course): ?>
			<?php //debug($course)?>
				<a href="<?php echo Router::url(array('controller' => 'contents', 'action' => 'index', $course['Course']['id']));?>" class="list-group-item">
					<div class="row">
						<div class="col-md-8">
							<h4 class="list-group-item-heading"><?php echo h($course['Course']['title']);?></h4>
							<p class="list-group-item-text">
							<span><?php echo __('学習開始日').': '.Utils::getYMD($course['Record']['first_date']); ?></span>
							<span><?php echo __('最終学習日').': '.Utils::getYMD($course['Record']['last_date']); ?></span>
							</p>
						</div>
						<div class="col-md-auto offset-md-2">
							<?php if($course[0]['left_cnt']!=0){?>
							<button type="button" class="btn btn-danger btn-rest"><?php echo __('残り')?> <span class="badge"><?php echo h($course[0]['left_cnt']); ?></span></button>
							<?php }?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
			<?php echo $no_record;?>
			</ul>
		</div>
	</div>
</div>
