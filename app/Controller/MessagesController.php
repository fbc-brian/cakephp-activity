<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController {

	public $components = array('Paginator');
	protected $perPage = 2;

	public function index() {
		$this->paginate = array(
			"joins" => array(
	            array(
	                'table' => '(select *, max(created) as MaxDate from messages group by con_id)',
	                'alias' => 'Maxdate',
	                'type' => 'INNER',	                
	           		'conditions' => array('Maxdate.from_id='.$this->Auth->user('id').' OR Maxdate.to_id='.$this->Auth->user('id'))       	
	            ),
        	),
        	'conditions' => [
	            'Message.created = Maxdate.maxdate',
	        ],
			'order' => [
                'Message.created' => 'DESC',
            ],
            'limit' => $this->perPage
        );
		$this->set('messages', $this->Paginator->paginate('Message'));
		if ($this->request->is('ajax')) {
			$this->render('table', 'ajax');
		}
	}

	public function view($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
		$this->set('message', $this->Message->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Message->create();
			$this->request->data['Message']['from_id'] = $this->Auth->user('id');
			$this->request->data['Message']['con_id'] = $this->checkConvo($this->request->data['Message']['to_id']);
			if ($this->Message->save($this->request->data)) {
				$this->Flash->success(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The message could not be saved. Please, try again.'));
			}
		}
		$options = array(
			'conditions' => [
				'id!='.$this->Auth->user('id')
			]
		);
		$this->set('users', $this->Message->User->find('list', $options));
	}

	public function edit($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Flash->success(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
	}

	public function delete($id = null) {
		if (!$this->request->is('ajax')) {
			return $this->redirect(array('action' => 'index'));
		}

		$this->Message->id = $id;
		$response = array();
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->Message->delete()) {
			$response['msg'] = __('The message has been deleted.');
			$response['status'] = true;
		} else {
			$response['msg'] = __('The message could not be deleted. Please, try again.');
			$response['status'] = false;
		}

		$this->set('response', $response);		
		$this->render('ajax', 'ajax');
	}
 
	public function delcon($id = null) {
		if ($this->request->is('ajax')) {
			$data = array();
			$options = array(
				'conditions' => [
					'con_id='.$id
				]
			);
			$convo = $this->Message->find('first', $options);
			if (!$convo) {
				throw new NotFoundException(__('Invalid message'));
			}
			$this->request->allowMethod('get', 'delete');	
			if ($this->Message->deleteAll(['Message.con_id' => $id])) {
				$data['status'] = true;
				$data['msg'] = __('The message has been deleted.');
			} else {
				$data['status'] = false;
				$data['msg'] = __('The message could not be deleted. Please, try again.');
			}
			$this->set('response', $data);
			$this->render('ajax', 'ajax');
		}
	}
	
    public function from($id) {
    	if (!$id || $id == $this->Auth->user('id')) {
            throw new NotFoundException(__('Invalid post'));
        }

        $fromPerson = $this->Message->User->findById($id);
        if (!$fromPerson) {
            throw new NotFoundException(__('Invalid post'));
        } else {
        	if ($this->request->is(array('post', 'put'))) {
        		$this->request->data['Message']['from_id'] = $this->Auth->user('id');
        		$this->request->data['Message']['to_id'] = $id;
        		$this->request->data['Message']['con_id'] = $this->checkConvo($id);
        		$response = array();
        		if ($this->Message->save($this->request->data)) {
					$response['msg'] = __('The message has been saved.');
					$response['status'] = true;
				} else {
					$response['msg'] = __('The message could not be saved. Please, try again.');
					$response['status'] = false;
				}
	    		$this->set('response', $response);
	    		$this->render('ajax', 'ajax');
	    	} else {
	        	$this->paginate = array(
	        		'conditions' => array('(to_id='.$id.' AND from_id='.$this->Auth->user('id').') OR (from_id='.$id.' AND to_id='.$this->Auth->user('id').')'),
	        		'limit' => $this->perPage

	        	);
	        	$this->set(['messages' => $this->Paginator->paginate(), 'fromPerson' => $fromPerson]);
	        	if ($this->request->is('ajax')) {
					$this->render('ballon', 'ajax');
				}
	        }
        }
    }

	public function search() {
		$find = '%'.$this->request->data['Message']['search'].'%';
		$this->paginate = array(	
        	'conditions' => [
        		'(Message.from_id=' .$this->Auth->user('id'). ' OR Message.to_id=' .$this->Auth->user('id'). ')',
        		'OR' => [
        			'Message.content LIKE ' => $find,
        			'Receiver.name LIKE' => $find
        		]
	        ],
			'order' => [
                'Message.created' => 'DESC',
            ],
            'limit' => $this->perPage
        );

		$this->set('messages', $this->Paginator->paginate('Message'));
		if ($this->request->is('ajax')) {
			$this->render('search', 'ajax');
		}

	}
	protected function checkConvo($toId) {
		$options = array(
			'conditions' => [
				'(to_id='.$toId.' AND from_id='.$this->Auth->user('id').') OR (from_id='.$toId.' AND to_id='.$this->Auth->user('id').')'
			]
		);
		$convo = $this->Message->find('first', $options);
		if (!$convo) {
			$getCon = array(
				'fields' => array('MAX(Message.con_id) AS max_id'),
				"alias" => "Message",
			);
			$conId = $this->Message->find('first', $getCon);
			return $conId[0]['max_id'] + 1 ;
		}else{
			return $convo['Message']['con_id'];
		}
	}
}
