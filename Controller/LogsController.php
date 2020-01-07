<?php
/**
 * hinoki Project
 */

App::uses('AppController', 'Controller');
App::uses('Group', 'Group');

/**
 * Logs Controller
 *
 * @property User $User
 */
class LogsController extends AppController
{

	public $components = array(
		'Paginator',
		'Search.Prg'
	);

	//public $presetVars = true;

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
		)
	);

	/**　ログイン履歴一覧  */
	public function admin_index(){
		$this->loadModel('User');

		$conditions = [];
		$user_list = $this->User->find('list',array(
			'fields' => array('id', 'name')
		));

		//$this->log($user_list);

		// SearchPluginの呼び出し
		$this->Prg->commonProcess();
		
		// Model の filterArgs に定義した内容にしたがって検索条件を作成
		// ただしアソシエーションテーブルには対応していないため、独自に検索条件を設定する必要がある
		$conditions = $this->Log->parseCriteria($this->Prg->parsedParams());
		
		$group_id			= (isset($this->request->query['group_id'])) ? $this->request->query['group_id'] : "";
		$name				  = (isset($this->request->query['name'])) ? $this->request->query['name'] : "";
		$username     =	(isset($this->request->query['username'])) ? $this->request->query['username'] : "";	
		
		// グループが指定されている場合、指定したグループに所属するユーザの履歴を抽出
		if($group_id != "")
			$conditions['User.id'] = $this->Group->getUserIdByGroupID($group_id);
		
	
		if($name != "")
			$conditions['User.name like'] = '%'.$name.'%';

		if($username != "")
			$conditions['User.username like'] = '%'.$username.'%';

		
		$this->Paginator->settings['conditions'] = $conditions;
		$this->Paginator->settings['order']      = 'Log.created desc';
		$this->Record->recursive = 0;
		
		try
		{
			$result = $this->paginate();
		}
		catch (Exception $e)
		{
			$this->request->params['named']['page']=1;
			$result = $this->paginate(); 
		}
		
		$this->set('login_records', $result);
		
		$this->Group = new Group();
		$this->set('groups',     $this->Group->find('list'));

		$this->set(compact("group_id","name","username"));

	}
}
