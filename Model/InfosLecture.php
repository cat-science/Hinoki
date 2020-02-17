<?php
/**
 * Hinoki Project
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');

/**
 * InfosLecture Model
 *
 * @property Info $Info
 * @property Lecture $Lecture
 */
class InfosLecture extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
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
}
