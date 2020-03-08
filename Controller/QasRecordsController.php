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
class QasRecordsController extends AppController
{

	public $components = array(
		
	);

	/** 生徒関連 */
	public function reply($qa_id){
		$this->admin_reply($qa_id);
		$this->render('admin_reply');
	}

	/** 講師関連 */


	/** 管理者関連 */

	public function admin_reply($qa_id){
		$this->loadModel('Qa');
		$this->loadModel('User');

		$user_id = $this->Auth->user('id');
		$role = $this->Auth->user('role');

		$user_list = $this->User->find('list',array(
			'fields' => array('id','name'),
		));

		$qa_info = $this->Qa->find('first',array(
			'conditions' => array(
				'Qa.id' => $qa_id
			)
		));

		$reply_records = $this->QasRecord->find('all',array(
			'conditions' => array(
				'QasRecord.qa_id' => $qa_id
			),
			'order by' => 'QasRecord.created DESC'
		));

		$this->log($qa_info);
		$this->log($reply_records);

		$this->set(compact("qa_info","reply_records","user_id","qa_id","user_list","role"));

		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			$request_data = $this->request->data;
			if ($this->QasRecord->save($request_data))
			{
				$this->Flash->success(__('返信しました'));
				return $this->redirect( array(
					'action' => 'reply', $qa_id, '#'=>'reply-form'
				));
			}
			else
			{
				$this->Flash->error(__('The Comment or Question could not be replied. Please, try again.'));
			}

		}
	}

	public function admin_delete($qasRecord_id){
		
		$id = $this->QasRecord->find('first',array(
			'conditions' => array(
				'QasRecord.id' => $qasRecord_id
			)
		));
		$qa_id = $id['QasRecord']['qa_id'];
		$this->QasRecord->id = $id['QasRecord']['id'];
		if (! $this->QasRecord->exists())
		{
			throw new NotFoundException(__('Invalid QasRecord'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->QasRecord->delete())
		{
			$this->Flash->success(__('返信が削除されました'));
		}
		else
		{
			$this->Flash->error(__('返信を削除できませんでした'));
		}
		return $this->redirect( array(
			'action' => 'reply', $qa_id, '#'=>'reply-form'
		));
	}
}
