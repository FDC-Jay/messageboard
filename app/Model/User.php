<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    var $useTable = 'users';
    
    public $validate = array(
        'email' => array(
            'notBlank' => array(
                'rule' => 'email',
				'required' => 'true',
				'allowEmpty' => false,
                'message' => 'Please provide a valid email address.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'The entered e-mail address is already in use.'
            ),
            'code' => array(
				'rule' => '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i',
				'message' => 'Email address has invalid characters'
			)
		),
        'password' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Password is required'
            ),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Please enter alphanumeric characters'
            ),
            'lengthBetween' => array(
				'rule' => array('lengthBetween', 5, 20),
				'message' => 'Please enter the following 5 to 20 characters'
			)
		),
        'password_confirm' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Confirmation password is required' 
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Please enter alphanumeric characters'
			),
			'compare' => array(
				'rule' => array('equaltofield','password'),
				'message' => 'Password does not match',
			)
		),
        'name' => array(
            'lengthBetween' => array(
				'rule' => array('lengthBetween', 5, 20),
				'message' => 'Please enter the following 5 to 20 characters'
			)
        ),
        'profile_pic' => array(
            'image' => array(
				'rule' => array(
                    'extension',
                    ['jpg', 'gif', 'png']
                ),
				'message' => 'Image extensions should be .jpg, .gif, or .png',
                'allowEmpty' => true,
                'required' => false
			)
        ),
        'birthday' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'required' => 'true',
                'message' => 'Field is required',
            )
        ),
        'gender' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'required' => 'true',
                'allowEmpty' => 'false',
                'message' => 'Field is required'
            )
        )
        
    );

    function equaltofield($check,$otherfield) {
		$fkey = '';
		foreach ($check as $key => $value) {
			$fkey = $key;
			break;
		}
		return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fkey];
	}

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        if (isset($this->data[$this->alias]['id']) && !empty($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['created'] = date('Y-m-d H:i:s');
            $this->data[$this->alias]['created_ip'] = env('REMOTE_ADDR');
        }

        $this->data[$this->alias]['modified'] = date('Y-m-d H:i:s');
        $this->data[$this->alias]['modified_ip'] = env('REMOTE_ADDR');

        return true;
    }
}