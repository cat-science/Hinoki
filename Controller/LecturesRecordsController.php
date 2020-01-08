<?php
/**
 * Hinoki Project
 *
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');
App::uses('Group', 'Group');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class LecturesRecordsController extends AppController
{
	public $components = array(
			'Session',
			'Paginator',
			'Search.Prg',
	);

	public function admin_edit($lecture_id, $lecture_date){
		$this->loadModel('User');
		$this->loadModel('UsersLecture');
		$this->loadModel('Lecture');
		$this->loadModel('LecturesAttendance');

		$lecture_info = $this->Lecture->find('first',array(
			'conditions' => array(
				'Lecture.id' => $lecture_id
			)
		));
		$lecture_name = $lecture_info['Lecture']['lecture_name']."($lecture_date)";

		//講師リストを探し，作る
		$docent_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'OR' => array(
					array('User.role' => 'admin'),
					array('User.role' => 'docent')
				)
			)
		));

		//受講する生徒を探す．
		$lecture_student_rows = $this->UsersLecture->findAllUsersInThisLecture($lecture_id);

		//$this->log($lecture_student_rows);

		$conditions = [];
		foreach($lecture_student_rows as $row){
			$conditions['OR'][] = array('User.id' => $row);
		}

		//受講する学生の名前を探す．
		$users = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => $conditions
		));

			
		$this->set(compact("lecture_name","docent_list","users"));

		//test area
		$attendance_infos = $this->LecturesAttendance->find('all',array(
			'fileds' => array(
				'LecturesAttendance.user_id','LecturesAttendance.id'
			),
			'conditions' => array(
				'AND' => array(
					array('LecturesAttendance.lecture_id' => $lecture_id),
					array('LecturesAttendance.lecture_date' => $lecture_date)
				)
			)
		));

		$attendance_data_id = [];
		foreach($attendance_infos as $info){
			$LA = $info['LecturesAttendance'];
			$attendance_data_id[$LA['user_id']] = $LA['id'];
		}
		$this->log($attendance_data_id);


		
		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			//saveデータを整理する
			$request_data = $this->request->data;
			$request_data['LecturesRecord']['lecture_id'] = $lecture_id;
			$request_data['LecturesRecord']['lecture_date'] = $lecture_date;
			$no = $this->LecturesRecord->find('count',array(
				'conditions' => array(
					'lecture_id' => $lecture_id
				)
			));
			//すでに履歴が存在する場合．
			if($request_data['LecturesRecord']['id'] >= 1){
				$no = $no;
			}else{
				$no++;
			}
			$request_data['LecturesRecord']['no'] = $no;

			//$this->log($request_data);


			//attendanceのデータを別処理で，LecturesAttendanceテーブルに保存する．

			//出席情報がすでに存在するかどうかをチェックする
			$attendance_infos = $this->LecturesAttendance->find('all',array(
				'conditions' => array(
					'AND' => array(
						array('LecturesAttendance.lecture_id' => $lecture_id),
						array('LecturesAttendance.lecture_date' => $lecture_date)
					)
				)
			));
			$this->log("attendance_infos");
			$this->log($attendance_infos);

			$attendance_data_id = [];
			foreach($attendance_infos as $info){
				$LA = $info['LecturesAttendance'];
				$attendance_data_id[$LA['user_id']] = $LA['id'];
			}


			$attendance_data = [];
			foreach($users as $k => $v){
				$status = $request_data['LecturesRecord']["$k-attendance"];
				$attendance_data["$k"] = array(
					'id' => $attendance_data_id[$k],
					'lecture_id' => $lecture_id,
					'no' => $no,
					'lecture_date' => $lecture_date,
					'user_id' => $k,
					'status' => $status
				);
			}
			$this->log($attendance_data);


			if($this->LecturesRecord->save($request_data)){
				
				//出席情報を保存する．
				foreach($attendance_data as $row){
					$this->LecturesAttendance->create();
					if($this->LecturesAttendance->save($row)){
						continue;
					}else{
						$this->Flash->error(__('The course could not be saved. Please, try again.'));
					}
				}

				$this->Flash->success(__('授業記録が保存されました'));
				return $this->redirect(array(
					'controller' => 'lectures',
					'action' => 'index'
				));

			}else{
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}

		}else{
			$this->log($this->Lecture->find('all'));
			$options = array(
				'conditions' => array(
					'AND' => array(
						array('LecturesRecord.lecture_id' => $lecture_id),
						array('LecturesRecord.lecture_date' => $lecture_date)
					)
				)
			);
			$tmp = $this->LecturesRecord->find('first', $options);

			if(isset($tmp)){
				$attendance_infos = $this->LecturesAttendance->find('all',array(
					'conditions' => array(
						'AND' => array(
							array('LecturesAttendance.lecture_id' => $lecture_id),
							array('LecturesAttendance.lecture_date' => $lecture_date)
						)
					)
				));
	
				
				$rows = [];
				foreach($attendance_infos as $info){
					$tmp['LecturesRecord'][$info['LecturesAttendance']['user_id'].'-attendance'] = $info['LecturesAttendance']['status'];
				}
				$this->request->data = $tmp;
			}
			
		}
		
					
	}
	
	public function docent_edit($lecture_id, $lecture_date){
		$this->loadModel('User');
		$this->loadModel('UsersLecture');
		$this->loadModel('Lecture');
		$this->loadModel('LecturesAttendance');

		$lecture_info = $this->Lecture->find('first',array(
			'conditions' => array(
				'Lecture.id' => $lecture_id
			)
		));
		$lecture_name = $lecture_info['Lecture']['lecture_name']."($lecture_date)";

		//講師リストを探し，作る
		$docent_list = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => array(
				'OR' => array(
					array('User.role' => 'admin'),
					array('User.role' => 'docent')
				)
			)
		));

		//受講する生徒を探す．
		$lecture_student_rows = $this->UsersLecture->findAllUsersInThisLecture($lecture_id);

		//$this->log($lecture_student_rows);

		$conditions = [];
		foreach($lecture_student_rows as $row){
			$conditions['OR'][] = array('User.id' => $row);
		}

		//受講する学生の名前を探す．
		$users = $this->User->find('list',array(
			'filed' => array(
				'User.id','User.name'
			),
			'conditions' => $conditions
		));

			
		$this->set(compact("lecture_name","docent_list","users"));

		//test area
		$attendance_infos = $this->LecturesAttendance->find('all',array(
			'fileds' => array(
				'LecturesAttendance.user_id','LecturesAttendance.id'
			),
			'conditions' => array(
				'AND' => array(
					array('LecturesAttendance.lecture_id' => $lecture_id),
					array('LecturesAttendance.lecture_date' => $lecture_date)
				)
			)
		));

		$attendance_data_id = [];
		foreach($attendance_infos as $info){
			$LA = $info['LecturesAttendance'];
			$attendance_data_id[$LA['user_id']] = $LA['id'];
		}
		$this->log($attendance_data_id);


		
		if ($this->request->is(array(
			'post',
			'put'
		)))
		{
			//saveデータを整理する
			$request_data = $this->request->data;
			$request_data['LecturesRecord']['lecture_id'] = $lecture_id;
			$request_data['LecturesRecord']['lecture_date'] = $lecture_date;
			$no = $this->LecturesRecord->find('count',array(
				'conditions' => array(
					'lecture_id' => $lecture_id
				)
			));
			//すでに履歴が存在する場合．
			if($request_data['LecturesRecord']['id'] >= 1){
				$no = $no;
			}else{
				$no++;
			}
			$request_data['LecturesRecord']['no'] = $no;

			//$this->log($request_data);


			//attendanceのデータを別処理で，LecturesAttendanceテーブルに保存する．

			//出席情報がすでに存在するかどうかをチェックする
			$attendance_infos = $this->LecturesAttendance->find('all',array(
				'conditions' => array(
					'AND' => array(
						array('LecturesAttendance.lecture_id' => $lecture_id),
						array('LecturesAttendance.lecture_date' => $lecture_date)
					)
				)
			));
			$this->log("attendance_infos");
			$this->log($attendance_infos);

			$attendance_data_id = [];
			foreach($attendance_infos as $info){
				$LA = $info['LecturesAttendance'];
				$attendance_data_id[$LA['user_id']] = $LA['id'];
			}


			$attendance_data = [];
			foreach($users as $k => $v){
				$status = $request_data['LecturesRecord']["$k-attendance"];
				$attendance_data["$k"] = array(
					'id' => $attendance_data_id[$k],
					'lecture_id' => $lecture_id,
					'no' => $no,
					'lecture_date' => $lecture_date,
					'user_id' => $k,
					'status' => $status
				);
			}
			$this->log($attendance_data);


			if($this->LecturesRecord->save($request_data)){
				
				//出席情報を保存する．
				foreach($attendance_data as $row){
					$this->LecturesAttendance->create();
					if($this->LecturesAttendance->save($row)){
						continue;
					}else{
						$this->Flash->error(__('The course could not be saved. Please, try again.'));
					}
				}

				$this->Flash->success(__('授業記録が保存されました'));
				return $this->redirect(array(
					'controller' => 'lectures',
					'action' => 'index'
				));

			}else{
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}

		}else{
			$this->log($this->Lecture->find('all'));
			$options = array(
				'conditions' => array(
					'AND' => array(
						array('LecturesRecord.lecture_id' => $lecture_id),
						array('LecturesRecord.lecture_date' => $lecture_date)
					)
				)
			);
			$tmp = $this->LecturesRecord->find('first', $options);

			if(isset($tmp)){
				$attendance_infos = $this->LecturesAttendance->find('all',array(
					'conditions' => array(
						'AND' => array(
							array('LecturesAttendance.lecture_id' => $lecture_id),
							array('LecturesAttendance.lecture_date' => $lecture_date)
						)
					)
				));
	
				
				$rows = [];
				foreach($attendance_infos as $info){
					$tmp['LecturesRecord'][$info['LecturesAttendance']['user_id'].'-attendance'] = $info['LecturesAttendance']['status'];
				}
				$this->request->data = $tmp;
			}
			
		}
		
					
	}

}
