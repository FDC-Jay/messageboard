<?php
App::uses('AppModel', 'Model');

class Messages extends AppModel {
    public $validate = array(
        'user_to' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'required' => 'true',
				'allowEmpty' => false,
                'message' => 'Field is required'
            )
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'required' => 'true',
				'allowEmpty' => false,
                'message' => 'Field is required'
            )
        ),
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['id']) && !empty($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['created'] = date('Y-m-d H:i:s');
            $this->data[$this->alias]['created_ip'] = env('REMOTE_ADDR');
        }

        $this->data[$this->alias]['modified'] = date('Y-m-d H:i:s');
        $this->data[$this->alias]['modified_ip'] = env('REMOTE_ADDR');
    }
}