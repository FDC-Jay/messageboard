<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $ext = '.php';

    public $loginAction = array(
		'controller' => 'login',
		'action' => 'index'
	);

    public $components = array(
        'Flash',
        'Paginator',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'login',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'login',
                'action' => 'index'
            ),
            'loginAction' => array(
                'controller' => 'login',
                'action' => 'index'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    )
                )
            )
        )
    );

    public function beforeFilter(){
        parent::beforeFilter();

        $this->layout = 'index';
        $this->Auth->allow(
            'index', 
            'view',
        );

        if($this->Auth->user('id')) {
            $this->set('userdata', $this->Auth->user());            
        }
    }


}
