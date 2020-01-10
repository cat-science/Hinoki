<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');
App::uses('Group', 'Group');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class LecturesController extends AppController
{
	public $components = array(
			'Session',
			'Paginator',
			'Security' => array(
				'csrfUseOnce' => false,
				'unlockedActions' => array('login','docent_login','admin_login'),
			),
			'Search.Prg',
			'Cookie',
			'Auth' => array(
					'allowedActions' => array(
							'index',
							'login',
							'logout'
					)
			)
	);
	
	/* 生徒関連 */
	/**
	 * ホーム画面（受講コース一覧）へリダイレクト
	 */
	public function index($lecture_id)
	{
		$this->loadModel('LecturesRecord');
		$this->loadModel('User');
		$this->loadModel('LecturesAttendance');


		$user_id = $this->Auth->user('id');

		$records = $this->LecturesRecord->find('all',array(
			//'fields' => array( 'id', 'lecture_date' ),
			'conditions' => array(
				'LecturesRecord.lecture_id' => $lecture_id
			),
			'order' => 'LecturesRecord.lecture_date desc'
		));
		
		$lecture_list = $this->Lecture->find('list',array(
			'fields' => array('id', 'lecture_name')
		));

		$user_list = $this->User->find('list',array(
			'fields' => array('id', 'name')
		));

		$attendance_list = $this->LecturesAttendance->find('list',array(
			'fields' => array('lecture_date', 'status'),
			'conditions' => array(
				'LecturesAttendance.lecture_id' => $lecture_id,
				'LecturesAttendance.user_id' => $user_id
			)
		));


		$this->log($attendance_list);
		$this->log($records);

		$this->set(compact("records","lecture_list","lecture_id"));
		$this->set(compact("user_list","attendance_list"));

	}

	/* 専任講師関連 */

	/*
		「授業編集」のページ関連
	*/

	/** admin-カレンダー */
	public function admin_index(){

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
	}

	public function admin_index_2(){
		$this->loadModel('User');
		$lectures = $this->Lecture->find('all',array(
			
		));
		//$this->log($lectures);
		//講師リストを探し，作る
		$docent_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'OR' => array(
					array('User.role' => 'admin'),
					array('User.role' => 'docent')
				)
			)
		));
		
		$this->set(compact("lectures","docent_list"));

	}

	/*
		授業情報を追加する
	*/
	public function admin_add(){
		$this->admin_edit();
		$this->render('admin_edit');
	}
	/*
		授業情報を編集する．
		@param int $lecture_id 授業ID
	*/
	public function admin_edit($lecture_id = null){
		$this->loadModel('User');
		//講師リストを探し，作る
		$docent_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'OR' => array(
					array('User.role' => 'admin'),
					array('User.role' => 'docent')
				)
			)
		));
	
		//受講生リストを探し，作る
		$student_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'User.role' => 'user'
			)
		));
		/*
		$student_list = [];
		foreach($rows as $k => $v){
			$row = array(
				'id' => $k,
				'text' => $v
			);
			$student_list[] = $row;
		}
		$this->log(json_encode($student_list));
		$student_list = json_encode($student_list);
		*/

		$this->set(compact("docent_list","student_list"));
		$lectures = $this->Lecture->find('list',array(
			'fields' => array(
				'Lecture.id',
				'Lecture.lecture_name'
			)
		));
		
		$this->set(compact('lectures'));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			$this->log($request_data);
			if($this->Lecture->save($request_data)){
				$this->Flash->success(__('コースが保存されました'));
				return $this->redirect(array(
					'action' => 'index_2'
				));
			}else{
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}
			
			
			
		}else{
			$options = array(
				'conditions' => array(
					'Lecture.' . $this->Lecture->primaryKey => $lecture_id
				)
			);
			$this->request->data = $this->Lecture->find('first', $options);
			$members = $this->User->find('list',array(
				'fileds' => array(
					'User.id','User.username'
				),
				'conditions' => array(
					'User.role' => 'user'
				)
			));
			$this->set(compact("members"));
			
			$this->log($this->request->data);
			$this->log($members);
		}
	}
	/*
		授業情報を削除する.
	*/
	public function admin_delete(){

	}


	
	/*-----------------------------------*/
	/* 講師関連 */
	public function docent_login(){
		$this->login();
	}

	public function docent_logout(){
		$this->logout();
	}

	public function docent_index(){
		$this->loadModel('UsersLecture');
		$this->loadModel('User');
		$this->loadModel('UsersCourse');

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

		$from_date = array(
			'year' => date('Y', strtotime("-1 month")),
			'month' => date('m', strtotime("-1 month")), 
			'day' => date('d', strtotime("-1 month"))
		);
		
		$to_date	= array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'));

		
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
		$this->log('l_n_i');
		$this->log($lecture_name_id);

		$date_name_list = [];
		foreach($lectures as $lecture){
			$rows = $lecture['Lecture']['lecture_date'];
			$lecture_name = $lecture['Lecture']['lecture_name'];

			$rows = explode("\n",$rows);
			foreach($rows as $row){
				$row = str_replace(array("\r","\r\n","\n"), '', $row);
				$this->log($row);

				if($date_name_list[$row]){
					array_push($date_name_list[$row],$lecture_name);
				}else{
					$date_name_list[$row] = array();
					array_push($date_name_list[$row],$lecture_name);
				}
				
			}
			$this->log($date_name_list);
			
		}
		$this->set(compact("date_name_list","lecture_name_id"));
	}


	public function docent_lecture_edit($lecture_id, $lecture_date){
		$this->loadModel('User');
		$this->loadModel('UsersLecture');

		$lecture_info = $this->Lecture->find('first',array(
			'conditions' => array(
				'Lecture.id' => $lecture_id
			)
		));
		$lecture_name = $lecture_info['Lecture']['lecture_name']."($lecture_date)";

		//講師リストを探し，作る
		$docent_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'OR' => array(
					array('User.role' => 'admin'),
					array('User.role' => 'docent')
				)
			)
		));

		$lecture_student_rows = $this->UsersLecture->findAllUsersInThisLecture($lecture_id);

		$this->log($lecture_student_rows);

		$conditions = [];
		foreach($lecture_student_rows as $row){
			$conditions['OR'][] = array('User.id' => $row);
		}

		
		$users = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => $conditions
		));

			
		$this->set(compact("lecture_name","docent_list","users"));
		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			$this->log($request_data);
			/*
			if($this->Lecture->save($request_data)){
				$this->Flash->success(__('コースが保存されました'));
				return $this->redirect(array(
					'action' => 'index_2'
				));
			}else{
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}
			
			
			
		}else{
			$options = array(
				'conditions' => array(
					'Lecture.' . $this->Lecture->primaryKey => $lecture_id
				)
			);
			$this->request->data = $this->Lecture->find('first', $options);
		}
		*/
		}

	}
}
