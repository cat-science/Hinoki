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

	public function admin_edit(){
		
	}

	public function admin_delete(){

	}

}
