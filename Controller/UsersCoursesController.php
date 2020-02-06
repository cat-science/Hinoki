<?php
/**
 * iroha Board Project
 *
 * @author        Kotaro Miura
 * @copyright     2015-2016 iroha Soft, Inc. (http://irohasoft.jp)
 * @link          http://irohaboard.irohasoft.jp
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');

/**
 * UsersCourses Controller
 *
 * @property UsersCourse $UsersCourse
 * @property PaginatorComponent $Paginator
 */
class UsersCoursesController extends AppController
{
	public $components = array(
	);

	/**
	 * 受講コース一覧（ホーム画面）を表示
	 */
	public function index()
	{
		$this->loadModel('Lecture');
		$this->loadModel('UsersLecture');
		$this->loadModel('User');

		$user_id = $this->Auth->user('id');
		
		// 全体のお知らせの取得
		App::import('Model', 'Setting');
		$this->Setting = new Setting();
		
		$data = $this->Setting->find('all', array(
			'conditions' => array(
				'Setting.setting_key' => 'information'
			)
		));
		
		$info = $data[0]['Setting']['setting_value'];
		
		// お知らせ一覧を取得
		$this->loadModel('Info');
		$infos = $this->Info->getInfos($user_id, 2);
		
		$no_info = "";
		
		// 全体のお知らせもお知らせも存在しない場合
		if(($info=="") && count($infos)==0)
			$no_info = __('お知らせはありません');
		
		// 受講コース情報の取得
		$courses = $this->UsersCourse->getCourseRecord($user_id);
		
		$no_record = "";
		
		if(count($courses)==0)
			$no_record = __('受講可能なコースはありません');
		
		$this->set(compact('courses', 'no_record', 'info', 'infos', 'no_info'));


		//講義情報の取得---start
		$from_date = array(
			'year' => date('Y', strtotime("-1 month")),
			'month' => date('m', strtotime("-1 month")), 
			'day' => date('d', strtotime("-1 month"))
		);
		
		$to_date	= array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'));

	
		$rows = $this->User->find('all',array(
			'conditions' => array(
				'User.id' => $user_id
			)
		));

		
		$conditions['OR'][] = array('Lecture.id' => 0);
		$rows = $rows[0]['Lecture'];
		foreach($rows as $row){
			$conditions['OR'][] = array(
				'Lecture.id' => $row['id']
			);
		}

		//$this->log($rows);

		$lectures = $this->Lecture->find('all',array(
			'conditions' => $conditions,
			'order' => 'Lecture.created DESC'
		));
		//$this->log($lectures);

		$lecture_name_id = $this->Lecture->find('list',array(
			'fields' => array(
				'Lecture.lecture_name','Lecture.id'
			)
		));
		/*
		$this->log('l_n_i');
		$this->log($lecture_name_id);
		*/

		$date_name_list = [];
		
		foreach($lectures as $lecture){
			$rows = $lecture['Lecture']['lecture_date'];
			$lecture_name = $lecture['Lecture']['lecture_name'];

			$rows = explode("\n",$rows);
			foreach($rows as $row){
				$row = str_replace(array("\r","\r\n","\n"), '', $row);

				if($date_name_list[$row]){
					array_push($date_name_list[$row],$lecture_name);
				}else{
					$date_name_list[$row] = array();
					array_push($date_name_list[$row],$lecture_name);
				}
				
			}
			
			
		}
		$this->set(compact("date_name_list","lecture_name_id"));
		//$this->log($date_name_list);
		//講義情報の取得---end

	}

}
