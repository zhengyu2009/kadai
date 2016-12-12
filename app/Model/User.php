<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'moji' => array(
				'rule' => '/^[ァ-ヴー]{1,40}[[:blank:]][ァ-ヴー]{1,40}$/u',
				'message' => '氏名項目は全角カタカナ、各全角40 文字以内',
			),
		),
		'email' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'メールアドレスを入力してください',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'このメールアドレスはすでに使われています',
			),
			'moji' => array(
				'rule' => '/^[A-Za-z0-9.-_]+@[A-Za-z0-9.-_]+$/',
				'message' => 'メールアドレスは半角英数で記号は「 @.-_ 」のみ許可',
			),
		),
	);
}
