<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->allow(array('add', 'thankYou'));
	}

	public function index() {
		$this->redirect('/messages/index');
	}

	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			$this->User->data['User']['created_ip'] = $this->request->clientIp();
			if ($this->User->save($this->request->data)) {
				return $this->redirect(array('action' => 'thankyou'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['User']['modified_ip'] = $this->request->clientIp();
			$err = true;
            if (!empty($this->request->data['User']['image']['name'])) {
                $file = $this->request->data['User']['image'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arrExt = array('jpg', 'jpeg', 'png'); 
                $newName = round(microtime(true)) . '.' . $ext;
                if(in_array($ext, $arrExt))
                {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/uploads/' .  $newName);
                    $this->request->data['User']['image'] = $newName;
                }else{
                	$err = false;
                	$this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
            } else {
            	unset($this->request->data['User']['image']);
            }

            if ($err){
				if ($this->User->save($this->request->data)) {
					if (!empty($this->Auth->user('image'))) {
						if (file_exists(WWW_ROOT . '/img/uploads/' . $this->Auth->user('image'))) {
							unlink(WWW_ROOT . '/img/uploads/' .  $this->Auth->user('image'));
						}						
						$this->Session->write('Auth.User.image', $this->request->data['User']['image']);
					}
					$this->Flash->success(__('The user has been saved.'));
					return $this->redirect(array('action' => 'view', $this->Auth->user('id')));
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
				}
			} else  {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$user_info = $this->User->find('first', $options);
			$user_info['User']['birthdate'] = date('m-d-Y', strtotime($user_info['User']['birthdate']));
			$this->request->data = $user_info;
		}
	}

	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login() {
		if ($this->Auth->user())
			$this->redirect('/messages/index');

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
       			$this->User->saveField('last_login_time', date('Y-m-d H:i:s')); 
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->error(__('Invalid Username or Password!'));
			}
		}
	} 

	public function logout() {
		$this->Auth->logout();
		$this->redirect('/messages/index');
	}

	public function changePass($id) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$user_info = $this->User->find('first', $options);
			if ($user_info['User']['password'] == AuthComponent::password($this->request->data['User']['old_password'])) {
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('The user has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
				}
			}else{
				$this->Flash->error(__('Wrong Password.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$user_info = $this->User->find('first', $options);
			unset($user_info['User']['password']);
			$this->request->data = $user_info;
		}

	} 


	public function getUserDetails($id) {
		$user = $this->User->find('first',  array(
		    'fields' => array('User.name','User.image'),
		    'conditions' => array('User.id' => $id),
		));
		return $user;
	}

	public function thankYou() {
	} 
}
