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
		
	}

	/* 専任講師関連 */

	/*
		「授業編集」のページ関連
	*/
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
		$this->loadModel('User');

		$from_date = array(
			'year' => date('Y', strtotime("-1 month")),
			'month' => date('m', strtotime("-1 month")), 
			'day' => date('d', strtotime("-1 month"))
		);
		
		$to_date	= array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'));

		$conditions['Lecture.created BETWEEN ? AND ?'] = array(
			implode("/", $from_date), 
			implode("/", $to_date).' 23:59:59'
		);
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
