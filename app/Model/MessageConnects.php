<?php
App::uses('AppModel', 'Model');

class MessageConnects extends AppModel {
    var $useTable = 'message_connects';

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