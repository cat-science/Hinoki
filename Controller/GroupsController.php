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

class GroupsController extends AppController
{
	public $components = array(
		'Paginator',
		'Security' => array(
			'csrfUseOnce' => false,
		),
	);

	/**
	 * グループ一覧を表示
	 */
	public function admin_index()
	{
		$this->Group->recursive = 0;
		$this->Group->virtualFields['course_title'] = 'GroupCourse.course_title'; // 外部結合テーブルのフィールドによるソート用
		$this->Group->virtualFields['lecture_name'] = 'GroupLecture.lecture_name'; // 外部結合テーブルのフィールドによるソート用
		
		$this->Paginator->settings = array(
			'fields' => array('*', 'GroupCourse.course_title','GroupLecture.lecture_name'),
			'limit' => 20,
			'order' => 'created desc',
			'joins' => array(
				array('type' => 'LEFT OUTER', 'alias' => 'GroupCourse',
						'table' => '(SELECT gc.group_id, group_concat(c.title order by c.id SEPARATOR \', \') as course_title FROM ib_groups_courses gc INNER JOIN ib_courses c ON c.id = gc.course_id  GROUP BY gc.group_id)',
						'conditions' => 'Group.id = GroupCourse.group_id'),
				array('type' => 'LEFT OUTER', 'alias' => 'GroupLecture',
						'table' => '(SELECT gl.group_id, group_concat(l.lecture_name order by l.id SEPARATOR \', \') as lecture_name FROM ib_groups_lectures gl INNER JOIN ib_lectures l ON l.id = gl.lecture_id  GROUP BY gl.group_id)',
						'conditions' => 'Group.id = GroupLecture.group_id')
			)
		);
		
		$this->set('groups', $this->Paginator->paginate());
	}

	/**
	 * グループの追加
	 */
	public function admin_add()
	{
		$this->admin_edit();
		$this->render('admin_edit');
	}

	/**
	 * グループの編集
	 * @param int $group_id 編集するグループのID
	 */
	public function admin_edit($group_id = null)
	{
		$this->loadModel('Lecture');
		if ($this->action == 'edit' && ! $this->Group->exists($group_id))
		{
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			if ($this->Group->save($this->request->data))
			{
				$this->Flash->success(__('グループ情報を保存しました'));
				return $this->redirect(array(
						'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
		}
		else
		{
			$options = array(
				'conditions' => array(
					'Group.' . $this->Group->primaryKey => $group_id
				)
			);
			$this->request->data = $this->Group->find('first', $options);
		}
		
		$courses = $this->Group->Course->find('list');
		$lectures = $this->Lecture->find('list',array(
			'fields' => array('id','lecture_name')
		));
		$this->set(compact('courses','lectures'));
	}

	/**
	 * グループの削除
	 * @param int $group_id 削除するグループのID
	 */
	public function admin_delete($group_id = null)
	{
		$this->Group->id = $group_id;
		if (! $this->Group->exists())
		{
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete())
		{
			$this->Flash->success(__('グループ情報を削除しました'));
		}
		else
		{
			$this->Flash->error(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array(
				'action' => 'index'
		));
	}

	/**
	 * キャンパスに在籍する生徒と開講する授業と担当者を表示
	 */

	public function admin_user_info($group_id){
		$this->loadModel('User');
		$this->loadModel('Group');
		$this->loadModel('UsersGroup');
		$this->loadModel('Lecture');

		$conditions['User.id'] = $this->Group->getUserIdByGroupID($group_id);
		$conditions['User.role'] = 'user';

		$user_list = $this->User->find('all',array(
			'conditions' => $conditions
		));

		$group_info = $this->Group->find('first',array(
			'conditions' => array(
				'Group.id' => $group_id
			)
		));

		$conditions = [];
		$conditions['Lecture.id'] = $this->Group->getLectureIdByGroupID($group_id);

		$lecture_info = $this->Lecture->find('all',array(
			'conditions' => $conditions
		));

		$all_user_list = $this->User->find('list',array(
			'fields' => 'id, name',
			'order' => 'User.id ASC'
		));

		$this->set(compact("user_list","group_info","lecture_info",'all_user_list'));

	}
}
