<?php
App::uses('AppController', 'Controller');

class ApiController extends AppController {
    public $uses = array(
        'Messages',
        'User'
    );

    public function beforeFilter(){
        parent::beforeFilter();

        $this->autoRender = false;
        $this->layout = false;
        $this->response->type('json');

        $this->Auth->allow(array(
            'messageAdd',
            'messageDelete',
            'messageSearch',
            'ajaxConversation'
        ));
    }

    public function messageAdd() {
        $data = $this->request->data;
        $response = [
            'status' => false
        ];

        if($this->request->is('post')) {      
            $this->Messages->set($data);
            if($this->Messages->save($data)) {
                $message_id = $this->Messages->id;
                $view = new View($this, false);
                $response['message'] = $view->element('message-card', array(
                    'profile_pic' => $this->Auth->user('profile_pic'),
                    'message_id' => $data['Messages']['msg_connect_id'],
                    'msg_id' => $message_id,
                    'content' => $data['Messages']['content'],
                    'is_current_user' => $this->Auth->user('id') != $data['Messages']['user_id'] ? true : false,
                    'page' => 'conversation'
                ));
                $response['status'] = true;
            }       
        }

        return json_encode($response);
    }

    public function messageDelete() {
        $data = $this->request->data;
        $response = [
            'status' => false
        ];

        if($this->request->is('post')) {    
            $saveParams = array(
                'Messages' => array(
                    'status' => 0
                )
            );

            $this->Messages->read('status', $data['Messages']['id']);
            $this->Messages->set($saveParams);
            if($this->Messages->save($saveParams)) {
                $response['status'] = true;
            }       
        }

        return json_encode($response);
    }

    public function messageSearch(){
        $data = $this->request->data;

        $response = [
            'status' => false
        ];

        if($this->request->is('post')) {    
            $messages = $this->Messages->find('all', array(
                'fields' => array(
                    'User.name',
                    'User.profile_pic',
                    'Messages.id',
                    'Messages.user_id',
                    'Messages.content',
                    'Messages.modified'
                ),
                'conditions' => array(
                    'Messages.content LIKE ' => '%' . $data['search'] . '%',
                    'Messages.status' => 1
                ),
                'joins' => array(
                    [
                        'table' => 'users',
                        'alias' => 'User',
                        'type'  => 'left',
                        'conditions' => 'User.id = Messages.user_id'
                    ]
                ),
                'order' => array(
                    'Messages.modified' => 'desc'
                )
            ));

            if($messages) {
                $view = new View($this, false);
                $content = '';
                foreach ($messages as $message) {
                    $content .= $view->element('message-card', array(
                        'profile_pic' => $message['User']['profile_pic'],
                        'message_id' => $message['Messages']['id'],
                        'msg_id' => $message['Messages']['id'],
                        'content' => $message['Messages']['content'],
                        'is_current_user' => $this->Auth->user('id') != $message['Messages']['user_id'] ? true : false,
                        'page' => 'conversation'
                    ));                    
                }

                $response['messages'] = $content;
                $response['status'] = true;
            }
        }

        return json_encode($response);
    }

    public function ajaxConversation() {
        // $this->layout = 'false'; // Use an empty layout

        $id = $this->request->params['named']['page'];

        $fields = [
            'User.name',
            'User.profile_pic',
            'Messages.id',
            'Messages.user_id',
            'Messages.content',
            'Messages.modified'
        ];
        $conditions = [
            'Messages.msg_connect_id' => $id,
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
            'limit' => 7
        ];

        $messages = $this->Paginator->paginate('Messages');

        debug($messages);

        $this->set(compact('messages'));
        $this->set('_serialize', ['messages']); // JSON serialize the response
    }
}