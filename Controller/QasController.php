<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');

/**
 * Qas Controller
 *
 * @property Content $Content
 * @property PaginatorComponent $Paginator
 */
class QasController extends AppController
{

	public $components = array(
		
	);

	/** 生徒関連 */
	public function index(){
		
	}

	public function add(){

		$user_id = $this->Auth->user('id');

		$this->set(compact("user_id"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			if ($this->Qa->save($request_data))
			{
				$this->Flash->success(__('コメント・質問が投稿されました'));
				return $this->redirect( array(
					'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The Comment or Question could not be submitted. Please, try again.'));
			}
		}
	}

	/** 講師関連 */


	/** 管理者関連 */
	public function admin_index(){
		$qa_list = $this->Qa->find('all',array(
			'order' => 'created DESC'
		));
		$this->set(compact("qa_list"));
	}
}
