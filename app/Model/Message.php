<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property To $To
 * @property From $From
 */
class Message extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'to_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Message is required.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'search' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Type to seach.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
    	'User' => array(
    		'className' => 'User',
    		'foreignKey' => 'from_id',
    		'conditions' => '',
    		'fields' => '',
    		'order' => ''
    	),
    	'Receiver' => array(
    		'className' => 'User',
    		'foreignKey' => 'to_id',
    		'conditions' => '',
    		'fields' => '',
    		'order' => ''
    	),
    );



}

