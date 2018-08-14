<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),

			),
		'between' => array(
            'rule' => array('lengthBetween', 5, 20),
            'message' => 'Between 5 to 20 characters'
        )
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email is not valid!',
			),
			'unique' => array(
	            'rule' => 'isUnique',
	            'message' => 'Provided Email already exists.'
	        )
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'confirm_password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'password_confirm'=>array(
	                'rule'=>array('password_confirm'),
	                'message'=>'Password Confirmation must match Password',                         
	            ),  
			),
			'match'=>array(
		        'rule' => 'validatePasswdConfirm',
		        'message' => 'Passwords do not match'
		    )
		),
		'gender' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'last_login_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
			),
		),
		'created_ip' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'modified_ip' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'old_password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'image' => array(
			'extension'=>array(
    			'rule' => array('extension', array('png', 'jpg', 'jpeg')),
        		'message'=>'Please enter a valid image!',
        		'required' => false,
        		'allowEmpty' => true
        	)
		),
	);

	function validatePasswdConfirm($data) {
	    if ($this->data['User']['password'] !== $data['confirm_password'])
	    {
	      return false;
	    }
	    return true;
	  }

  	function beforeSave($options = array()) {
	    if (isset($this->data['User']['password'])) {
	    	$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
	    }
	    if (isset($this->data['User']['confirm_password'])) {
	    	unset($this->data['User']['confirm_password']);
	    }
	    return true;
	}

	public $hasMany = array(
    	'Message' => array(
    		'className' => 'Message',
    		'foreignKey' => 'from_id',
    		'dependent' => false,
    		'conditions' => '',
    		'fields' => '',
    		'order' => '',
    		'limit' => '',
    		'offset' => '',
    		'exclusive' => '',
    		'finderQuery' => '',
    		'counterQuery' => '',
    	),
    	'Receiver' => array(
    		'className' => 'Message',
    		'foreignKey' => 'to_id',
    		'dependent' => false,
    		'conditions' => '',
    		'fields' => '',
    		'order' => '',
    		'limit' => '',
    		'offset' => '',
    		'exclusive' => '',
    		'finderQuery' => '',
    		'counterQuery' => '',
    	)
    );




}
