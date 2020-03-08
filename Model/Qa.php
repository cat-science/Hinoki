<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');

/**
 * Qa Model
 *
 * @property 
 */
class Qa extends AppModel
{
	public $validate = array(
		'title' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				),
				'message' => 'タイトルが入力されていません'
			)
		),
		'body' => array(
			'notBlank' => array(
				'rule' => array(
					'notBlank'
				),
				'message' => '本文が入力されていません'
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
			'QasRecord' => array(
					'className' => 'QasRecord',
					'foreignKey' => 'qa_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
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
