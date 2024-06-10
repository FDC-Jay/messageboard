<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController {
    public $uses = array(
        'Messages',
        'User',
        'MessageConnects'
    );

    public function beforeFilter(){
        parent::beforeFilter();
        $this->layout = 'index';

        $this->Auth->allow('');
        
        $this->set('username', $this->Auth->user('name'));
    }

    public function index(){
        $this->Paginator->settings = [
            'fields' => array(
                'MessageConnects.id', 
                'MessageConnects.user_one', 
                'MessageConnects.user_two'
            ),
            'conditions' => array(
                'MessageConnects.status' => 1,
                'OR' => array(
                    'MessageConnects.user_one' => array($this->Auth->user('id')),
                    'MessageConnects.user_two' => array($this->Auth->user('id')),
                )
            ),
            'limit' => 5
        ];

        $connect_ids = $this->Paginator->paginate('MessageConnects');


        if(!empty($connect_ids)) {
            $messages = [];

            foreach ($connect_ids as $convo) {
                $fields = [
                    'User.id',
                    'User.name',
                    'User.profile_pic',
                    'Messages.id',
                    'Messages.user_id',
                    'Messages.modified',
                    'Messages.msg_connect_id',
                    'Messages.content',
                    'Messages.modified'
                ];
                $conditions = [
                    'Messages.msg_connect_id' => $convo['MessageConnects']['id'],
                    'Messages.status' => 1
                ];
                $user = $this->Auth->user('id') == $convo['MessageConnects']['user_one'] ? $convo['MessageConnects']['user_two'] : $convo['MessageConnects']['user_one'];
                $message = $this->Messages->find('first', array(
                    'fields' => $fields,
                    'conditions' => $conditions,
                    'joins' => array(
                        [
                            'table' => 'users',
                            'alias' => 'User',
                            'type'  => 'left',
                            'conditions' => 'User.id = ' . $user
                        ]
                    ),
                    'order' => array('Messages.created' => 'desc')
                ));
                $messages[] = $message;
            }
            
    
            $this->set('messages', $messages);
            $this->set('user_id', $this->Auth->user('id'));
        }      
    }

    public function add(){
        if($this->request->is('post')) {
            $data = $this->request->data;

            if($data['Messages']['user_to'] == 0) {
                $this->Flash->error('Select a recipient');
                return;
            }

            if($this->Messages->validates()) {
                // check if exist
                $connect_id = $this->MessageConnects->find('first', array(
                    'fields' => 'MessageConnects.id',
                    'conditions' => array(
                        'OR' => array(
                            'MessageConnects.user_one' => array($this->Auth->user('id'), $data['Messages']['user_to']),
                            'MessageConnects.user_two' => array($this->Auth->user('id'), $data['Messages']['user_to']),
                        )
                    )
                ));

                $connect_id = $connect_id['MessageConnects'];

                if(empty($connect_id)) {
                    $data_params = array(
                        'MessageConnects' => array(
                            'user_one' => $this->Auth->user('id'),
                            'user_two' => $data['Messages']['user_to']
                        )
                    );
                    $this->MessageConnects->set($data_params);
                    if($this->MessageConnects->save($data_params)) {
                        $connect_id = $this->MessageConnects->id;
                    }                 
                }

                $data['Messages']['msg_connect_id'] = $connect_id['id']; 
                $data['Messages']['user_id'] = $this->Auth->user('id'); 

                $this->Messages->set($data);
                if($this->Messages->save($data)) {
                   $this->redirect($this->getUrl . '/messages'); 
                }
            }            
        }
    }

    public function conversation() {
        $fields = [
            'User.name',
            'User.profile_pic',
            'Messages.id',
            'Messages.user_id',
            'Messages.content',
            'Messages.modified'
        ];
        $conditions = [
            'Messages.msg_connect_id' => $this->request->params['id'],
            'Messages.status' => 1
        ];
    
        $this->Paginator->settings = [
            'fields' => $fields,
            'conditions' => $conditions,
            'joins' => [
                [
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => 'User.id = Messages.user_id'
                ]
            ],
            'order' => [
                'Messages.modified' => 'asc'
            ],
            'limit' => 5
        ];

        
    
        $messages = $this->Paginator->paginate('Messages');

        if($this->request->is('post')) {
            $this->autoRender = false;
            $this->layout = false;
            $this->response->type('json');
            $data = $this->request->data;
            $response = '';

            foreach ($messages as $message) {
                $view = new View($this, false);  
                $response .= $view->element('message-card', array(
                    'profile_pic' => $message['User']['profile_pic'],
                    'message_id' => $data['Messages']['msg_connect_id'],
                    'msg_id' => $message['Messages']['id'],
                    'content' => $message['Messages']['content'],
                    'is_current_user' => $this->Auth->user('id') != $message['Messages']['user_id'] ? true : false,
                    'page' => 'conversation'
                ));
            }

            return json_encode(array('message' => $response, 'paginator' => $this->params['paging']['Messages']));
        }
    
        $this->set('messages', $messages);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('user_pic', $this->Auth->user('profile_pic'));
    }
}