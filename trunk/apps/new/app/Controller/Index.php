<?php
/**
 * Index controller - handle queries in site root (http://phpdays.dev/).
 *
 * Use "php:Days - php5 framework" (http://phpdays.sf.net).
 *
 * @copyright   Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        http://phpdays.sf.net/
 * @package     phpDays
 * @subpackage  phpDays library
 * @author      Anton Danilchenko <happy@phpdays.org>
 */
class App_Controller_Index extends Days_Controller {
    /**
     * Call before all controller actions.
     */
    public function init() {
        $this->_view->set('title', 'My site based on php:Days framework');
    }

    /**
     * Index action.
     *
     * Call if typed path:
     *   http://phpdays.dev/
     *   http://phpdays.dev/index
     *   http://phpdays.dev/index/index
     */
    public function indexAction() {
        Days_Event::add('user_login_success',
            'Days_User::isLoggedIn');
        Days_Event::run('user_login_success',
            array(0=>'Days_User::isLoggedIn'));
        $this->_view->set('welcome', 'Welcome to phpDays development!');
    }

    /*
     * Login action
     *
     * Call if typed path:
     *   http://phpdays.dev/index/login
     *   http://phpdays.dev/index/login/?u=username&p=password
     */
    public function loginAction() {
        Days_User::login();
        $this->_view->set('welcome', 'Welcome to phpDays development!');
    }

}
