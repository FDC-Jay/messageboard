<?php
App::uses('AppController', 'Controller');

class LoginController extends AppController {
    public $uses = array(
        'User'
    );

    public function beforeFilter(){
        parent::beforeFilter();
        $this->layout = 'login';
        $this->Auth->allow([
            'thankyou'
        ]);
    }

    public function index() {
        if($this->request->is('post')) {
            if ($this->Auth->login()) {
                $data = [
                    'User' => [
                        'last_login' => date('Y-m-d H:i:s')
                    ]
                ];
                $this->User->read(['last_login'], $this->Auth->user('id'));
                $this->User->set($data);
                $this->User->save($data);

                return $this->redirect($this->getUrl . '/user/' . $this->Auth->user('id'));
            }
            $this->Flash->error('Invalid username or password, try again');
        }
    }

    public function thankyou() {
        $this->render('thankyou');
    }
}