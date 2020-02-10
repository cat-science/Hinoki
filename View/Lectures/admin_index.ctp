<?php echo $this->element('admin_menu');?>
<style>
	.today{
		background: orange;
	}
</style>
<div class="users-courses-index col">
	<div class="text-left">
		<?php echo $this->Html->link(__('授業の編集はこちら'), array('controller' => 'lectures', 'action' => 'index_2')); ?></br></br>
	</div>	
	<?php //カレンダー?>
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
		$week .= str_repeat('<td></td>', $youbi);
		for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
				// 2017-07-3
				$tmp_day = $day < 10 ? '0'.$day : $day;
				$date = $ym . '-' . $tmp_day;
				// その日の授業の配列を取得
				$date_slash = str_replace("-","/",$date);
				$date_lectures = $date_name_list[$date_slash];

		    if ($today == $date) {
					// 今日の日付の場合は、class="today"をつける
					$week .= '<td class="today" style = "width : 120px;">' . $day;
					foreach($date_lectures as $lecture){
						$lecture_url = '<div style = "margin : auto ;border: 1px solid #000; width : 80px; text-align: center; font-size : 12px;">'. $this->Html->link($lecture, array('controller' => 'lecturesRecords', 'action' => 'edit', $lecture_name_id[$lecture], $date)) .'</div>';
						$week .= $lecture_url;
					}
					
		    } else {
					$week .= '<td style = "width : 120px;" >' . $day;
					foreach($date_lectures as $lecture){
						$lecture_url = '<div style = "margin : auto ;border: 1px solid #000; width : 80px; text-align: center; font-size : 12px;">'. $this->Html->link($lecture, array('controller' => 'lecturesRecords', 'action' => 'edit',  $lecture_name_id[$lecture], $date)) .'</div>';
						$week .= $lecture_url;
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
      <table class="table table-bordered">
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
	
</div>
