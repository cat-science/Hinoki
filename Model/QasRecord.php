<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');

/**
 * QasRecord Model
 *
 * @property 
 */
class QasRecord extends AppModel
{
	public $validate = array(
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
