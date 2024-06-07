<?php
App::uses('AppController', 'Controller');

class UserController extends AppController {
    public $uses = array(
        'User'
    );

    public function beforeFilter(){
        parent::beforeFilter();

        $this->layout = 'index';
        $this->Auth->allow(
            'signup',
        );
    }

    public function index() {
        $user_id = $this->Auth->user('id');

        $this->set('user_id', $user_id);
    }

    public function signup(){
        $this->set('page_title', 'Sign up');

        if ($this->request->is('post')) {
            if ($this->User->validates()) {
                $this->User->create(); 
                $data = $this->request->data;
                
                $this->User->set($data);

                if ($this->User->save($data)) {
                    $this->redirect($this->getUrl . '/thankyou');
                }
            }
            
            $this->set('data', $data);
        }
    }

    public function edit(){
        $profile_id = $this->request->params['id'];

        if($this->request->is('post')) {
            if(empty($this->request->data['User']['profile_pic']['name'])) unset($this->request->data['User']['profile_pic']);
            if(empty($this->request->data['User']['password'])) {
                unset($this->request->data['User']['password']);
                unset($this->request->data['User']['password_confirm']);
            }
            

            $data = $this->request->data;
            if ($this->User->validates()) {
                if(!empty($this->request->data['User']['profile_pic']['name'])){
                    if(!$this->isUploadedFile($this->request->data['User']['profile_pic'], $profile_id)) {
                        $this->Session->error(__('Unable to upload the file.'));
                    }
                    unset($data['User']['profile_pic']);
                }

                $this->User->read([
                    'name',
                    'email',
                    'birthday',
                    'gender',
                    'hobby'
                ], $profile_id);

                $this->User->set($data);
                if($this->User->save($data)) {
                    $this->redirect($this->getUrl . '/user/' . $profile_id);
                } else {
                    $this->Flash->error('Update error');
                }

            } else {
                $this->Flash->error('Update error');
            }
        }

        $fields = [
            'User.id',
            'User.name',
            'User.email',
            'User.password',
            'User.profile_pic',
            'User.birthday',
            'User.gender',
            'User.hobby',
        ];

        $conditions = [
            'User.id' => $profile_id,
            'User.status' => 1
        ];

        $userdata = $this->User->find('first', array(
            'fields' => $fields,
            'conditions' => $conditions
        ));

        $this->set('userdata', $userdata['User']);
        $this->render('edit');
    }

    public function user_profile(){
        $profile_id = $this->request->params['id'];
        $conditions = [
            'User.id' => $profile_id
        ];
        $fields = [
            'User.id',
            'User.name',
            'User.email',
            'User.profile_pic',
            'User.birthday',
            'User.gender',
            'User.hobby',
            'User.created',
            'User.last_login',
        ];

        $userdata = $this->User->find('first', array(
            'fields' => $fields,
            'conditions' => $conditions
        ));

        $age = $this->calculateAge($userdata['User']['birthday']);

        $this->set('userdata', $userdata['User']);
        $this->set('age', $age);
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    public function calculateAge($dob){
        if (empty($dob)) return null;

        $timestamp = strtotime($dob);
        if ($timestamp === false) return null; 

        $birthYear = date('Y', $timestamp);
        $birthMonth = date('m', $timestamp);
        $birthDay = date('d', $timestamp);

        $currentYear = date('Y');
        $currentMonth = date('m');
        $currentDay = date('d');

        $age = $currentYear - $birthYear;

        if ($currentMonth < $birthMonth || ($currentMonth == $birthMonth && $currentDay < $birthDay)) {
            $age--;
        }

        return $age;
    }

    public function getUsers() {
        $this->autoRender = false; // Disable view rendering
        $this->response->type('json'); // Set response type

        $this->loadModel('User');
        
        $conditions = array(
            'User.status' => 1,
            'AND' => array(
                'User.name IS NOT NULL',
                'User.name !=' => '',
                'User.id !='  => $this->Auth->user('id')
            )
        );

        // Apply conditions based on search term
        $searchTerm = $this->request->query('term');
        if (!empty($searchTerm)) {
            $conditions['User.name LIKE'] = '%' . $searchTerm . '%';
        }

        // Pagination parameters
        $limit = $this->request->query('limit', 10); // Default limit 10
        $page = $this->request->query('page', 1); // Default page 1
        $offset = ($page - 1) * $limit;

        $users = $this->User->find('all', array(
            'conditions' => $conditions, // Apply conditions
            'limit' => $limit,
            'offset' => $offset
        ));
        
        $response = [];
        foreach ($users as $user) {
            $response[] = [
                'id' => $user['User']['id'],
                'text' => $user['User']['name']
            ];
        }

        return json_encode($response);
    }

    private function isUploadedFile($file, $id){
        $uploadPath = WWW_ROOT . 'uploads' . DS;
        $uploadFile = $uploadPath . basename($file['name']);

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $this->User->read('profile_pic', $id);
            $this->User->set('profile_pic', $this->webroot . 'uploads/' . $file['name']);
            $this->User->save();
            return true;
        } else {
            return false;
        }
    }
}