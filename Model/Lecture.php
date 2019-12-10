<?php
/**
 * Hinoki Project
 *
 * @author        
 * @copyright     
 * @link          
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');

/**
 * Lect Model
 *
 * @property Group $Group
 * @property Course $Course
 * @property User $User
 * @property Content $Content
 */
class Lecture extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'lecture_name' => array(
				'notBlank' => array(
						'rule' => array(
								'notBlank'
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
	public $hasMany = array(

	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
	
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Member' => array(
			'className' => 'User',
			'joinTable' => 'users_lectures',
			'foreignKey' => 'lecture_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => ''
	 )
	);
	
	/**
	 * 検索用
	 */
	public $actsAs = array(
		'Search.Searchable'
	);

	public $filterArgs = array(
	);
}
