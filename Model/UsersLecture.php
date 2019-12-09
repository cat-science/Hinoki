<?php
/**
 * 
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');

/**
 * UsersLecture Model
 *
 * @property User $User
 * @property Lecture $Lecture
 */
class UsersLecture extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			'user_id' => array(
					'numeric' => array(
							'rule' => array(
									'numeric'
							)
					// 'message' => 'Your custom message here',
					// 'allowEmpty' => false,
					// 'required' => false,
					// 'last' => false, // Stop validation after this rule
					// 'on' => 'create', // Limit validation to 'create' or
					// 'update' operations
										)
			),
			'lecture_id' => array(
					'numeric' => array(
							'rule' => array(
									'numeric'
							)
					// 'message' => 'Your custom message here',
					// 'allowEmpty' => false,
					// 'required' => false,
					// 'last' => false, // Stop validation after this rule
					// 'on' => 'create', // Limit validation to 'create' or
					// 'update' operations
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
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
			'Lecture' => array(
					'className' => 'Lecture',
					'foreignKey' => 'lecture_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			)
	);

	public function findAllUsersInThisLecture($lecture_id){
		$sql = "select id, user_id from ib_users_lectures where lecture_id = $lecture_id";
		$data = $this->query($sql);
		$rows = [];
		foreach($data as $row){
			$k = $row['ib_users_lectures']['id'];
			$v = $row['ib_users_lectures']['user_id'];
			$rows[] = array($k => $v);
		}
		return $rows;
	}
}
