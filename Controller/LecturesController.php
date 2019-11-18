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
	
	/**
	 * ホーム画面（受講コース一覧）へリダイレクト
	 */
	public function index()
	{
		$this->redirect("/users_courses");
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
		
		$this->set(compact("docent_list"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			if($this->Lecture->save($request_data)){
				$this->Flash->success(__('コースが保存されました'));
				return $this->redirect(array(
					'action' => 'index_2'
				));
			}else{
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}
			
			$this->log($request_data);
			
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
		$this->log('docent_index');
	}
}
