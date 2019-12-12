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

	/* 生徒関連 -- user */


	/* 講師関連 -- docent */
	public function docent_index(){

	}

	/* 専任講師関連 -- admin */
	public function admin_index(){
		$this->loadModel('User');

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
		$this->loadModel('Records');

		//個人情報を検索
		$user_info = $this->User->find('all',array(
			'conditions' => array(
				'User.id' => $user_id
			)
		));

		$user_info = $user_info[0];


		$this->set(compact("user_info"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			$this->log($request_data);
		}else{

		}

	}

	public function admin_delete(){

	}

}
