<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');

/**
 * Interview Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class InterviewsController extends AppController{

	public $components = array(
			'Paginator',
			'Search.Prg'
	);

	public $paginate = array();
	
	public $presetVars = array(
		array(
			'name' => 'name', 
			'type' => 'value',
			'field' => 'User.name'
		), 
		array(
			'name' => 'username',
			'type' => 'like',
			'field' => 'User.username'
		), 
		array(
			'name' => 'contenttitle', 'type' => 'like',
			'field' => 'Content.title'
		)
	);

	//public $uses = array('Record');

	/* 生徒関連 -- user */


	/* 講師関連 -- docent */
	public function docent_index(){
		$this->loadModel('User');

		$users = $this->User->find('all',array(
			'conditions' => array(
				'User.role' => 'user'
			),
			'ORDER BY' => 'User.created DESC'
		));

		$this->set(compact("users"));

	}

	public function docent_edit($user_id){
		$this->loadModel('User');
		$this->loadModel('Records');

		//個人情報を検索
		$user_info = $this->User->find('all',array(
			'conditions' => array(
				'User.id' => $user_id
			)
		));

		$user_info = $user_info[0];
		$this->log($user_info);


		$this->set(compact("user_info"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			$this->log($request_data);
			if ($this->Interview->save($request_data))
			{
				$this->Flash->success(__('面談情報が保存されました'));
				return $this->redirect( array(
					'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The Information could not be saved. Please, try again.'));
			}
		}else{
			$conditions['Interview.user_id'] = $user_id;
			$info = $this->Interview->find('first',array(
				'conditions' => $conditions
			));
			$this->request->data = $info;
		}
	}

	/* 専任講師関連 -- admin */
	public function admin_index(){
		$this->loadModel('User');

		$conditions = [];

		$users = $this->User->find('all',array(
			'conditions' => array(
				'User.role' => 'user'
			),
			'ORDER BY' => 'User.created DESC'
		));

		$this->set(compact("users"));

	}

	/** 
	* @param int $user_id 生徒ID
	*/
	public function admin_edit($user_id){
		$this->loadModel('User');
		$this->loadModel('Record');

		//個人情報を検索
		$user_info = $this->User->find('all',array(
			'conditions' => array(
				'User.id' => $user_id
			)
		));

		$user_info = $user_info[0];
		

		$records = $this->Record->find('all',array(
			'conditions' => array(
				'User.id' => $user_id,
				'Content.kind' => 'test',
			),
			'limit' => 3
		));
		$this->log($records);


		$this->set(compact("user_info","records","user_id"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			$this->log($request_data);
			if ($this->Interview->save($request_data))
			{
				$this->Flash->success(__('面談情報が保存されました'));
				return $this->redirect( array(
					'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The Information could not be saved. Please, try again.'));
			}
		}else{
			$conditions['Interview.user_id'] = $user_id;
			$info = $this->Interview->find('first',array(
				'conditions' => $conditions
			));
			$this->request->data = $info;
		}

	}

	public function admin_delete(){

	}

	public function admin_all_records($user_id){
		$this->loadModel('User');
		$this->loadModel('Record');
		$this->loadModel('Course');
		$this->loadModel('Content');

		/** User情報をセットする */
		$user_info = $this->User->find('first',array(
			'conditions' => array(
				'User.id' => $user_id
			)
		));
		$this->set(compact("user_id","user_info"));

		// SearchPluginの呼び出し
		$this->Prg->commonProcess();
		
		// Model の filterArgs に定義した内容にしたがって検索条件を作成
		// ただしアソシエーションテーブルには対応していないため、独自に検索条件を設定する必要がある
		$conditions = $this->Record->parseCriteria($this->Prg->parsedParams());
		
		$course_id			= (isset($this->request->query['course_id'])) ? $this->request->query['course_id'] : "";
		$contenttitle		= (isset($this->request->query['contenttitle'])) ? $this->request->query['contenttitle'] : "";
		
		
		// グループが指定されている場合、指定したグループに所属するユーザの履歴を抽出
		
		if($course_id != "")
			$conditions['Course.id'] = $course_id;
		
		if($contenttitle != "")
			$conditions['Content.title like'] = '%'.$contenttitle.'%';
		
		// CSV出力モードの場合
		if(@$this->request->query['cmd']=='csv')
		{
			$this->autoRender = false;

			// メモリサイズ、タイムアウト時間を設定
			ini_set("memory_limit", '512M');
			ini_set("max_execution_time", (60 * 10));

			// Content-Typeを指定
			$this->response->type('csv');

			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="user_records.csv"');
			
			$fp = fopen('php://output','w');
			
			$options = array(
				'conditions'	=> $conditions,
				'order'			=> 'Record.created desc'
			);
			
			$this->Record->recursive = 0;
			$rows = $this->Record->find('all', $options);
			
			$header = array("コース", "コンテンツ", "氏名", "得点", "合格点", "結果", "理解度", "学習時間", "学習日時");
			
			mb_convert_variables("SJIS-WIN", "UTF-8", $header);
			fputcsv($fp, $header);
			
			foreach($rows as $row)
			{
				$row = array(
					$row['Course']['title'], 
					$row['Content']['title'], 
					$row['User']['name'], 
					$row['Record']['score'], 
					$row['Record']['pass_score'], 
					Configure::read('record_result.'.$row['Record']['is_passed']), 
					Configure::read('record_understanding.'.$row['Record']['understanding']), 
					Utils::getHNSBySec($row['Record']['study_sec']), 
					Utils::getYMDHN($row['Record']['created']),
				);
				
				mb_convert_variables("SJIS-WIN", "UTF-8", $row);
				
				fputcsv($fp, $row);
			}
			
			fclose($fp);
		}
		else
		{
			$this->Paginator->settings['conditions'] = $conditions;
			$this->Paginator->settings['order']      = 'Record.created desc';
			$this->Record->recursive = 0;
			
			try
			{
				$result = $this->paginate('Record');
			}
			catch (Exception $e)
			{
				$this->request->params['named']['page']=1;
				$result = $this->paginate('Record');
			}
			
			$this->set('records', $result);
			
			//$groups = $this->Group->getGroupList();
			
			$this->Group = new Group();
			$this->Course = new Course();
			$this->User = new User();
			//debug($this->User);
			
			$this->set('groups',     $this->Group->find('list'));
			$this->set('courses',    $this->Course->find('list'));
			$this->set('group_id',   $group_id);
			$this->set('course_id',  $course_id);
			$this->set('name',       $name);
			$this->set('content_category',	$content_category);
			$this->set('contenttitle',		$contenttitle);
			$this->set('from_date', $from_date);
			$this->set('to_date', $to_date);
		}

	}

}
