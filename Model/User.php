<?php
/**
 * iroha Board Project
 *
 * @author        Kotaro Miura
 * @copyright     2015-2016 iroha Soft, Inc. (http://irohasoft.jp)
 * @link          http://irohaboard.irohasoft.jp
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property Group $Group
 * @property Content $Content
 * @property Course $Course
 * @property Group $Group
 */
class User extends AppModel
{
	public $order = "User.name"; 

	public $validate = array(
		'username' => array(
				array(
						'rule' => 'isUnique',
						'message' => 'ログインIDが重複しています'
				),
				array(
						'rule' => 'alphaNumeric',
						'message' => 'ログインIDは英数字で入力して下さい'
				),
				array(
						'rule' => array(
								'between',
								4,
								32
						),
						'message' => 'ログインIDは4文字以上32文字以内で入力して下さい'
				)
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				),
				'message' => '氏名が入力されていません'
			)
		),
		'role' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				),
				'message' => '権限が指定されていません'
			)
		),
		'password' => array(
				array(
						'rule' => 'alphaNumeric',
						'message' => 'パスワードは英数字で入力して下さい'
				),
				array(
						'rule' => array(
								'between',
								4,
								32
						),
						'message' => 'パスワードは4文字以上32文字以内で入力して下さい'
				)
		),
		'new_password' => array(
				array(
						'rule' => 'alphaNumeric',
						'message' => 'パスワードは英数字で入力して下さい',
						'allowEmpty' => true
				),
				array(
						'rule' => array(
								'between',
								4,
								32
						),
						'message' => 'パスワードは4文字以上32文字以内で入力して下さい',
						'allowEmpty' => true
				)
		)
	);

	// The Associations below have been created with all possible keys, those
	// that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
			'Content' => array(
					'className' => 'Content',
					'foreignKey' => 'user_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			),
			'Interview' => array(
					'className' => 'Interview',
					'foreignKey' => 'user_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			),
			'EjusRecord' => array(
				'className' => 'EjusRecord',
				'foreignKey' => 'user_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'PracticesRecord' => array(
				'className' => 'PracticesRecord',
				'foreignKey' => 'user_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => ' PracticesRecord.practice_date DESC',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
			'Course' => array(
					'className' => 'Course',
					'joinTable' => 'users_courses',
					'foreignKey' => 'user_id',
					'associationForeignKey' => 'course_id',
					'unique' => 'keepExisting',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => ''
			),
			'Group' => array(
					'className' => 'Group',
					'joinTable' => 'users_groups',
					'foreignKey' => 'user_id',
					'associationForeignKey' => 'group_id',
					'unique' => 'keepExisting',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => ''
	 		),
			 'Lecture' => array(
					 'className' => 'Lecture',
					 'joinTable' => 'users_lectures',
					 'foreignKey' => 'user_id',
					 'associationForeignKey' => 'lecture_id',
					 'unique' => 'keepExisting',
					 'conditions' => '',
					 'fields' => '',
					 'order' => '',
					 'limit' => '',
					 'offset' => '',
					 'finderQuery' => ''
			 )
	);

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password']))
		{
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	/**
	 * 検索用
	 */
	public $actsAs = array(
		'Search.Searchable'
	);

	public $filterArgs = array(
		'username' => array(
			'type' => 'like',
			'field' => 'User.username'
		),
		'name' => array(
			'type' => 'like',
			'field' => 'User.name'
		),
		'course_id' => array(
			'type' => 'like',
			'field' => 'course_id'
		),
	);

	/**
	 * 学習履歴の削除
	 * 
	 * @param int array $user_id 学習履歴を削除するユーザのID
	 */
	public function deleteUserRecords($user_id)
	{
		$sql = 'DELETE FROM ib_records_questions WHERE record_id IN (SELECT id FROM ib_records WHERE user_id = :user_id)';
		
		$params = array(
			'user_id' => $user_id,
		);
		
		$this->query($sql, $params);
		
		App::import('Model', 'Record');
		$this->Record = new Record();
		$this->Record->deleteAll(array('Record.user_id' => $user_id), false);
	}

	public function setUserManyTitles($users){
		foreach($users as &$user){
			$group_title = "";
			$course_title = "";
			$lecture_title = "";
			$tmp = 0;
			foreach($user['Group'] as $user_group){
				if($tmp !== 0){
					$group_title .= ", ".$user_group['title'];
				}else{
					$group_title .= $user_group['title'];
				}
				$tmp++;
			}
			$tmp = 0;
			foreach($user['Course'] as $user_course){
				if($tmp !== 0){
					$course_title .= ", ".$user_course['title'];
				}else{
					$course_title .= $user_course['title'];
				}
				$tmp++;
			}
			$tmp = 0;
			foreach($user['Lecture'] as $user_lecture){
				if($tmp !== 0){
					$lecture_title .= ", ".$user_lecture['lecture_name'];
				}else{
					$lecture_title .= $user_lecture['lecture_name'];
				}
				$tmp++;
			}
			$user[0] = array(
				'group_title' => $group_title,
				'course_title' => $course_title,
				'lecture_title' => $lecture_title
			);
		}
		unset($user);
		return $users;
		
	}
}
