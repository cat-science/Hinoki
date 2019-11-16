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
	public function admin_index_2(){
		
	}

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
